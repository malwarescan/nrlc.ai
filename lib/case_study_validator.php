<?php
/**
 * NRLC AI Case Study System - Authoring Validation & Enforcement
 * 
 * This is a schema compiler with guardrails.
 * Marketing never touches raw HTML.
 */

/**
 * Banned phrases (regex patterns) - hard blocks
 */
function get_banned_phrases(): array {
  return [
    '/cutting-edge/i',
    '/leveraged/i',
    '/optimized content/i',
    '/boosted visibility/i',
    '/industry-leading/i',
    '/game-changing/i',
    '/revolutionary/i',
    '/next-level/i',
    '/synergy/i',
    '/paradigm shift/i'
  ];
}

/**
 * Validate case study content structure
 * 
 * @param array $data Case study data to validate
 * @return array ['valid' => bool, 'errors' => array]
 */
function validate_case_study_content(array $data): array {
  $errors = [];
  
  // Required fields
  $required = [
    'prompt_cluster' => 'Prompt cluster selection',
    'situation' => 'Situation description',
    'ai_failure' => 'AI failure description',
    'technical_diagnosis' => 'Technical diagnosis',
    'intervention' => 'Intervention description',
    'outcome' => 'AI outcome description'
  ];
  
  foreach ($required as $field => $label) {
    if (empty($data[$field])) {
      $errors[] = "Missing required field: {$label}";
    }
  }
  
  // Validate prompt cluster
  $validClusters = ['invisible-brand', 'competitor-hallucination', 'trust-comparison', 'local-failure'];
  if (!empty($data['prompt_cluster']) && !in_array($data['prompt_cluster'], $validClusters)) {
    $errors[] = "Invalid prompt cluster. Must be one of: " . implode(', ', $validClusters);
  }
  
  // Minimum length requirements
  $minLengths = [
    'situation' => 150,
    'ai_failure' => 150,
    'technical_diagnosis' => 100,
    'intervention' => 100,
    'outcome' => 100
  ];
  
  foreach ($minLengths as $field => $minLen) {
    if (!empty($data[$field]) && strlen(trim($data[$field])) < $minLen) {
      $errors[] = "{$field} must be at least {$minLen} characters";
    }
  }
  
  // Check for banned phrases
  $bannedPhrases = get_banned_phrases();
  $allText = implode(' ', array_values($data));
  
  foreach ($bannedPhrases as $pattern) {
    if (preg_match($pattern, $allText)) {
      $errors[] = "Content contains banned phrase matching: {$pattern}";
    }
  }
  
  // Validate technical diagnosis references
  if (!empty($data['technical_diagnosis'])) {
    $techKeywords = ['entity', 'data', 'schema', 'structured', 'markup', 'JSON-LD', 'retrieval', 'citation'];
    $hasTechRef = false;
    foreach ($techKeywords as $keyword) {
      if (stripos($data['technical_diagnosis'], $keyword) !== false) {
        $hasTechRef = true;
        break;
      }
    }
    if (!$hasTechRef) {
      $errors[] = "Technical diagnosis must reference data, entity, or schema concepts";
    }
  }
  
  // Validate intervention concreteness
  if (!empty($data['intervention'])) {
    $concreteKeywords = ['implemented', 'added', 'created', 'updated', 'deployed', 'configured', 'mapped'];
    $hasConcrete = false;
    foreach ($concreteKeywords as $keyword) {
      if (stripos($data['intervention'], $keyword) !== false) {
        $hasConcrete = true;
        break;
      }
    }
    if (!$hasConcrete) {
      $errors[] = "Intervention must describe concrete actions (implemented, added, created, etc.)";
    }
  }
  
  // Validate outcome describes answer behavior
  if (!empty($data['outcome'])) {
    $behaviorKeywords = ['answer', 'response', 'citation', 'mention', 'include', 'recommend', 'return'];
    $hasBehavior = false;
    foreach ($behaviorKeywords as $keyword) {
      if (stripos($data['outcome'], $keyword) !== false) {
        $hasBehavior = true;
        break;
      }
    }
    if (!$hasBehavior) {
      $errors[] = "Outcome must describe how AI answer behavior changed";
    }
  }
  
  return [
    'valid' => empty($errors),
    'errors' => $errors
  ];
}

/**
 * Validate case study data and return formatted errors
 * 
 * @param array $data Case study data
 * @return string|null Error message or null if valid
 */
function validate_case_study(array $data): ?string {
  $result = validate_case_study_content($data);
  
  if (!$result['valid']) {
    return implode("\n", $result['errors']);
  }
  
  return null;
}

