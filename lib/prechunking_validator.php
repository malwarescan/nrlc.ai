<?php
/**
 * NRLC Prechunking Content Validator
 * 
 * Enforces SUDO_META_DIRECTIVE_PRECHUNKING.md rules
 * Validates content for AI retrieval and citation eligibility
 * 
 * Usage:
 *   $validator = new PrechunkingValidator();
 *   $result = $validator->validate($content, $filePath);
 *   if (!$result['valid']) {
 *     // Block publishing, show errors
 *   }
 */

class PrechunkingValidator {
  
  /**
   * Validate content against prechunking rules
   * 
   * @param string $content HTML or plain text content
   * @param string $filePath Optional file path for context
   * @return array ['valid' => bool, 'errors' => array, 'warnings' => array, 'score' => int]
   */
  public function validate(string $content, string $filePath = ''): array {
    $errors = [];
    $warnings = [];
    $score = 100;
    
    // Extract text content (strip HTML tags for analysis)
    $textContent = strip_tags($content);
    $htmlContent = $content;
    
    // Extract headers
    preg_match_all('/<h[1-6][^>]*>(.*?)<\/h[1-6]>/i', $htmlContent, $headerMatches);
    $headers = array_map('strip_tags', $headerMatches[1]);
    
    // Extract paragraphs/sections
    preg_match_all('/<p[^>]*>(.*?)<\/p>/i', $htmlContent, $paraMatches);
    $paragraphs = array_map('strip_tags', $paraMatches[1]);
    
    // STEP 1: Question Inventory Check
    $questionCheck = $this->validateQuestionInventory($headers);
    if (!$questionCheck['valid']) {
      $errors = array_merge($errors, $questionCheck['errors']);
      $score -= 20;
    }
    $warnings = array_merge($warnings, $questionCheck['warnings']);
    
    // STEP 2: Atomicity Enforcement
    $atomicityCheck = $this->validateAtomicity($paragraphs);
    if (!$atomicityCheck['valid']) {
      $errors = array_merge($errors, $atomicityCheck['errors']);
      $score -= 25;
    }
    $warnings = array_merge($warnings, $atomicityCheck['warnings']);
    
    // STEP 3: Query-Shaped Headers
    $headerCheck = $this->validateHeaders($headers);
    if (!$headerCheck['valid']) {
      $errors = array_merge($errors, $headerCheck['errors']);
      $score -= 15;
    }
    $warnings = array_merge($warnings, $headerCheck['warnings']);
    
    // STEP 4: Chunk Size Constraints
    $sizeCheck = $this->validateChunkSizes($paragraphs);
    if (!$sizeCheck['valid']) {
      $errors = array_merge($errors, $sizeCheck['errors']);
      $score -= 15;
    }
    $warnings = array_merge($warnings, $sizeCheck['warnings']);
    
    // STEP 5: Narrative Glue Elimination
    $narrativeCheck = $this->validateNarrativeGlue($textContent);
    if (!$narrativeCheck['valid']) {
      $errors = array_merge($errors, $narrativeCheck['errors']);
      $score -= 10;
    }
    $warnings = array_merge($warnings, $narrativeCheck['warnings']);
    
    // STEP 6: Citation Test
    $citationCheck = $this->validateCitationReadiness($paragraphs);
    if (!$citationCheck['valid']) {
      $errors = array_merge($errors, $citationCheck['errors']);
      $score -= 15;
    }
    $warnings = array_merge($warnings, $citationCheck['warnings']);
    
    // Global Content Rules Check
    $globalCheck = $this->validateGlobalRules($textContent, $paragraphs);
    if (!$globalCheck['valid']) {
      $errors = array_merge($errors, $globalCheck['errors']);
      $score -= 10;
    }
    
    $score = max(0, $score);
    
    return [
      'valid' => empty($errors),
      'errors' => $errors,
      'warnings' => $warnings,
      'score' => $score,
      'file' => $filePath
    ];
  }
  
  /**
   * STEP 1: Validate question inventory structure
   */
  private function validateQuestionInventory(array $headers): array {
    $errors = [];
    $warnings = [];
    
    if (empty($headers)) {
      $errors[] = "No headers found. Content must have question-shaped headers.";
      return ['valid' => false, 'errors' => $errors, 'warnings' => $warnings];
    }
    
    // Check if headers resemble questions or direct queries
    $questionLikeCount = 0;
    foreach ($headers as $idx => $header) {
      $header = trim($header);
      if (empty($header)) continue;
      
      // Check if header starts with question words or is query-shaped
      $isQuestionLike = preg_match('/^(what|how|why|when|where|who|which|does|do|is|are|can|could|should|will)/i', $header) ||
                        preg_match('/\?$/', $header) ||
                        $this->isQueryShaped($header);
      
      if ($isQuestionLike) {
        $questionLikeCount++;
      } else {
        $warnings[] = "Header #" . ($idx + 1) . " may not be query-shaped: \"{$header}\"";
      }
    }
    
    if ($questionLikeCount === 0) {
      $errors[] = "No question-shaped headers found. Headers must resemble search queries.";
    } elseif ($questionLikeCount < count($headers) * 0.7) {
      $warnings[] = "Only {$questionLikeCount} of " . count($headers) . " headers are question-shaped. Target: 100%";
    }
    
    return [
      'valid' => empty($errors),
      'errors' => $errors,
      'warnings' => $warnings
    ];
  }
  
  /**
   * STEP 2: Validate atomicity (chunks are self-contained)
   */
  private function validateAtomicity(array $paragraphs): array {
    $errors = [];
    $warnings = [];
    
    $forbiddenPatterns = [
      '/\b(this|that|these|those|it|they|them)\s+(shows?|demonstrates?|indicates?|means?|proves?)/i',
      '/\b(as\s+mentioned\s+earlier|as\s+stated\s+above|as\s+noted\s+previously)/i',
      '/\b(in\s+conclusion|to\s+summarize|in\s+summary)/i',
      '/\b(above|below|earlier|later|previously|next)\s+(section|paragraph|chapter)/i',
      '/\b(see\s+above|see\s+below|as\s+above)/i'
    ];
    
    foreach ($paragraphs as $idx => $para) {
      $para = trim($para);
      if (empty($para) || strlen($para) < 20) continue;
      
      // Check for forbidden patterns
      foreach ($forbiddenPatterns as $pattern) {
        if (preg_match($pattern, $para)) {
          $errors[] = "Paragraph #" . ($idx + 1) . " violates atomicity: contains reference to other sections. Text: \"" . substr($para, 0, 100) . "...\"";
          break;
        }
      }
      
      // Check for pronouns that might need context
      if (preg_match('/\b(this|that|these|those|it|they)\s+[a-z]+/i', $para) && 
          !preg_match('/\b(this\s+(is|means|refers\s+to)|that\s+(is|means|refers\s+to))/i', $para)) {
        $warnings[] = "Paragraph #" . ($idx + 1) . " may contain ambiguous pronouns: \"" . substr($para, 0, 80) . "...\"";
      }
      
      // Check for conjunctions in factual claims (multi-fact sentences)
      if (preg_match('/\b(and|but|also|however|moreover)\s+[A-Z]/', $para)) {
        $warnings[] = "Paragraph #" . ($idx + 1) . " may contain multiple facts in one sentence: \"" . substr($para, 0, 80) . "...\"";
      }
    }
    
    return [
      'valid' => empty($errors),
      'errors' => $errors,
      'warnings' => $warnings
    ];
  }
  
  /**
   * STEP 3: Validate headers are query-shaped (not clever/abstract)
   */
  private function validateHeaders(array $headers): array {
    $errors = [];
    $warnings = [];
    
    $forbiddenPatterns = [
      '/^(understanding|exploring|diving\s+into|unlocking|mastering|discovering)/i',
      '/^(why\s+this\s+matters|the\s+future\s+of|introduction\s+to)/i',
      '/^(a\s+deep\s+dive|an\s+overview|getting\s+started)/i'
    ];
    
    foreach ($headers as $idx => $header) {
      $header = trim($header);
      if (empty($header)) continue;
      
      // Check for forbidden abstract patterns
      foreach ($forbiddenPatterns as $pattern) {
        if (preg_match($pattern, $header)) {
          $errors[] = "Header #" . ($idx + 1) . " is too abstract/clever: \"{$header}\". Headers must resemble search queries.";
          break;
        }
      }
      
      // Check if header is too short or vague
      if (strlen($header) < 10) {
        $warnings[] = "Header #" . ($idx + 1) . " is very short: \"{$header}\". Consider making it more specific.";
      }
      
      // Check if header contains marketing language
      if (preg_match('/\b(revolutionary|cutting-edge|game-changing|next-level|industry-leading)/i', $header)) {
        $errors[] = "Header #" . ($idx + 1) . " contains marketing language: \"{$header}\". Use factual, query-shaped headers.";
      }
    }
    
    return [
      'valid' => empty($errors),
      'errors' => $errors,
      'warnings' => $warnings
    ];
  }
  
  /**
   * STEP 4: Validate chunk size constraints (40-120 words ideal, 150 max)
   */
  private function validateChunkSizes(array $paragraphs): array {
    $errors = [];
    $warnings = [];
    
    foreach ($paragraphs as $idx => $para) {
      $para = trim($para);
      if (empty($para)) continue;
      
      $wordCount = str_word_count($para);
      
      if ($wordCount > 150) {
        $errors[] = "Paragraph #" . ($idx + 1) . " exceeds hard maximum (150 words): {$wordCount} words. Split into smaller chunks.";
      } elseif ($wordCount > 120) {
        $warnings[] = "Paragraph #" . ($idx + 1) . " exceeds ideal length (120 words): {$wordCount} words. Consider splitting.";
      } elseif ($wordCount < 40 && $wordCount > 10) {
        $warnings[] = "Paragraph #" . ($idx + 1) . " is below ideal minimum (40 words): {$wordCount} words. May be too short for retrieval.";
      }
    }
    
    return [
      'valid' => empty($errors),
      'errors' => $errors,
      'warnings' => $warnings
    ];
  }
  
  /**
   * STEP 5: Validate narrative glue elimination
   */
  private function validateNarrativeGlue(string $content): array {
    $errors = [];
    $warnings = [];
    
    $forbiddenPhrases = [
      '/as\s+mentioned\s+earlier/i',
      '/in\s+conclusion/i',
      '/this\s+shows\s+that/i',
      '/to\s+summarize/i',
      '/in\s+summary/i',
      '/moving\s+forward/i',
      '/with\s+that\s+said/i',
      '/building\s+on\s+this/i',
      '/now\s+that\s+we\s+ve/i'
    ];
    
    foreach ($forbiddenPhrases as $pattern) {
      if (preg_match($pattern, $content)) {
        $errors[] = "Content contains forbidden narrative glue phrase matching: {$pattern}";
      }
    }
    
    // Check for essay-style transitions
    $transitionPatterns = [
      '/\b(furthermore|moreover|additionally|consequently|therefore|thus|hence)/i'
    ];
    
    foreach ($transitionPatterns as $pattern) {
      if (preg_match($pattern, $content)) {
        $warnings[] = "Content contains essay-style transition. Consider removing for atomicity.";
      }
    }
    
    return [
      'valid' => empty($errors),
      'errors' => $errors,
      'warnings' => $warnings
    ];
  }
  
  /**
   * STEP 6: Validate citation readiness
   */
  private function validateCitationReadiness(array $paragraphs): array {
    $errors = [];
    $warnings = [];
    
    $promotionalPatterns = [
      '/\b(guaranteed|guarantee|promise|assure|definitely|absolutely|always|never)/i',
      '/\b(best|greatest|most\s+powerful|unbeatable|unmatched)/i',
      '/\b(revolutionary|cutting-edge|game-changing|industry-leading)/i'
    ];
    
    foreach ($paragraphs as $idx => $para) {
      $para = trim($para);
      if (empty($para)) continue;
      
      // Check for promotional language
      foreach ($promotionalPatterns as $pattern) {
        if (preg_match($pattern, $para)) {
          $errors[] = "Paragraph #" . ($idx + 1) . " contains promotional language unsuitable for citation: \"" . substr($para, 0, 100) . "...\"";
          break;
        }
      }
      
      // Check if paragraph can stand alone
      if (strlen($para) < 30) {
        $warnings[] = "Paragraph #" . ($idx + 1) . " is very short and may not be citation-ready: \"" . $para . "\"";
      }
    }
    
    return [
      'valid' => empty($errors),
      'errors' => $errors,
      'warnings' => $warnings
    ];
  }
  
  /**
   * Validate global content rules
   */
  private function validateGlobalRules(string $content, array $paragraphs): array {
    $errors = [];
    
    // Rule: Pages MUST be composed of discrete chunks
    if (count($paragraphs) < 2) {
      $errors[] = "Content must be composed of discrete chunks. Found only " . count($paragraphs) . " paragraph(s).";
    }
    
    // Rule: Each chunk must be understandable in isolation
    // (This is partially covered by atomicity check, but verify minimum content)
    $emptyChunks = 0;
    foreach ($paragraphs as $para) {
      if (strlen(trim($para)) < 20) {
        $emptyChunks++;
      }
    }
    
    if ($emptyChunks > count($paragraphs) * 0.3) {
      $errors[] = "Too many chunks are too short or empty. Content must be composed of substantial, discrete chunks.";
    }
    
    return [
      'valid' => empty($errors),
      'errors' => $errors
    ];
  }
  
  /**
   * Check if text is query-shaped (resembles a search query)
   */
  private function isQueryShaped(string $text): bool {
    // Query-shaped text typically:
    // - Contains question words
    // - Is direct and specific
    // - Avoids abstract concepts
    // - Uses common search phrasing
    
    $queryIndicators = [
      preg_match('/^(what|how|why|when|where|who|which|does|do|is|are|can|could|should|will)/i', $text),
      preg_match('/\?$/', $text),
      preg_match('/\b(guide|tutorial|explanation|definition|example|comparison|difference|benefit|cost|price|review)/i', $text),
      strlen($text) >= 15 && strlen($text) <= 80 // Typical query length
    ];
    
    return in_array(true, $queryIndicators);
  }
  
  /**
   * Get validation summary for reporting
   */
  public function getSummary(array $result): string {
    $summary = "Prechunking Validation Results\n";
    $summary .= "============================\n\n";
    $summary .= "File: " . ($result['file'] ?: 'N/A') . "\n";
    $summary .= "Score: {$result['score']}/100\n";
    $summary .= "Status: " . ($result['valid'] ? "✅ PASS" : "❌ FAIL") . "\n\n";
    
    if (!empty($result['errors'])) {
      $summary .= "Errors (" . count($result['errors']) . "):\n";
      foreach ($result['errors'] as $idx => $error) {
        $summary .= "  " . ($idx + 1) . ". {$error}\n";
      }
      $summary .= "\n";
    }
    
    if (!empty($result['warnings'])) {
      $summary .= "Warnings (" . count($result['warnings']) . "):\n";
      foreach ($result['warnings'] as $idx => $warning) {
        $summary .= "  " . ($idx + 1) . ". {$warning}\n";
      }
      $summary .= "\n";
    }
    
    if ($result['valid']) {
      $summary .= "✅ Content passes all prechunking validation rules.\n";
    } else {
      $summary .= "❌ Content FAILS prechunking validation. Publishing is BLOCKED.\n";
      $summary .= "Fix all errors before publishing.\n";
    }
    
    return $summary;
  }
}

