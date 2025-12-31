<?php
/**
 * NRLC Content Chunking Validator
 * 
 * Enforces SUDO_META_DIRECTIVE_CONTENT_CHUNKING.md rules
 * Validates content for UX, readability, and scannability
 * 
 * NOTE: This is separate from prechunking validation.
 * Chunking = UX/readability, Prechunking = retrieval/citation
 * 
 * Usage:
 *   $validator = new ContentChunkingValidator();
 *   $result = $validator->validate($content, $filePath);
 *   if (!$result['valid']) {
 *     // Show warnings, suggest improvements
 *   }
 */

class ContentChunkingValidator {
  
  /**
   * Validate content against chunking rules
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
    preg_match_all('/<h([1-3])[^>]*>(.*?)<\/h[1-3]>/i', $htmlContent, $headerMatches, PREG_SET_ORDER);
    $headers = [];
    foreach ($headerMatches as $match) {
      $level = (int)$match[1];
      $text = strip_tags($match[2]);
      $headers[] = ['level' => $level, 'text' => $text];
    }
    
    // Extract paragraphs
    preg_match_all('/<p[^>]*>(.*?)<\/p>/i', $htmlContent, $paraMatches);
    $paragraphs = array_map('strip_tags', $paraMatches[1]);
    
    // PRINCIPLE 1: One Idea Per Section
    $ideaCheck = $this->validateOneIdeaPerSection($headers, $paragraphs);
    if (!$ideaCheck['valid']) {
      $errors = array_merge($errors, $ideaCheck['errors']);
      $score -= 20;
    }
    $warnings = array_merge($warnings, $ideaCheck['warnings']);
    
    // PRINCIPLE 2: Clear Hierarchical Headers
    $headerCheck = $this->validateHeaderHierarchy($headers);
    if (!$headerCheck['valid']) {
      $errors = array_merge($errors, $headerCheck['errors']);
      $score -= 20;
    }
    $warnings = array_merge($warnings, $headerCheck['warnings']);
    
    // PRINCIPLE 3: Short, Scannable Paragraphs
    $paragraphCheck = $this->validateParagraphLength($paragraphs);
    if (!$paragraphCheck['valid']) {
      $errors = array_merge($errors, $paragraphCheck['errors']);
      $score -= 20;
    }
    $warnings = array_merge($warnings, $paragraphCheck['warnings']);
    
    // PRINCIPLE 4: Visual Separation
    $visualCheck = $this->validateVisualSeparation($htmlContent);
    if (!$visualCheck['valid']) {
      $warnings = array_merge($warnings, $visualCheck['warnings']);
      $score -= 10;
    }
    
    // PRINCIPLE 5: Logical Progression (warnings only, narrative flow is allowed)
    $progressionCheck = $this->validateLogicalProgression($headers, $paragraphs);
    $warnings = array_merge($warnings, $progressionCheck['warnings']);
    
    // Check for common mistakes
    $mistakesCheck = $this->validateCommonMistakes($htmlContent, $headers, $paragraphs);
    if (!$mistakesCheck['valid']) {
      $errors = array_merge($errors, $mistakesCheck['errors']);
      $score -= 10;
    }
    $warnings = array_merge($warnings, $mistakesCheck['warnings']);
    
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
   * PRINCIPLE 1: Validate one idea per section
   */
  private function validateOneIdeaPerSection(array $headers, array $paragraphs): array {
    $errors = [];
    $warnings = [];
    
    // Check if sections have clear boundaries
    if (count($headers) < 2) {
      $warnings[] = "Content should have multiple sections (H2/H3) for better chunking.";
    }
    
    // Check for sections with too many paragraphs (might indicate multiple ideas)
    $sectionCount = 0;
    foreach ($headers as $header) {
      if ($header['level'] == 2) {
        $sectionCount++;
      }
    }
    
    if ($sectionCount > 0 && count($paragraphs) / $sectionCount > 5) {
      $warnings[] = "Some sections may contain multiple ideas. Average " . round(count($paragraphs) / $sectionCount, 1) . " paragraphs per section.";
    }
    
    return [
      'valid' => empty($errors),
      'errors' => $errors,
      'warnings' => $warnings
    ];
  }
  
  /**
   * PRINCIPLE 2: Validate header hierarchy
   */
  private function validateHeaderHierarchy(array $headers): array {
    $errors = [];
    $warnings = [];
    
    if (empty($headers)) {
      $errors[] = "Content must have headers (H1, H2, H3) for proper chunking.";
      return ['valid' => false, 'errors' => $errors, 'warnings' => $warnings];
    }
    
    // Check for H1
    $hasH1 = false;
    foreach ($headers as $header) {
      if ($header['level'] == 1) {
        $hasH1 = true;
        break;
      }
    }
    
    if (!$hasH1) {
      $warnings[] = "Content should have an H1 header for the page topic.";
    }
    
    // Check header hierarchy (H2 should come before H3)
    $lastLevel = 0;
    $hierarchyIssues = 0;
    foreach ($headers as $idx => $header) {
      $level = $header['level'];
      if ($level > $lastLevel + 1 && $lastLevel > 0) {
        $hierarchyIssues++;
      }
      $lastLevel = $level;
    }
    
    if ($hierarchyIssues > 0) {
      $warnings[] = "Header hierarchy may be inconsistent. Ensure H2 comes before H3, etc.";
    }
    
    // Check for vague/abstract headers
    $vaguePatterns = [
      '/^(introduction|overview|conclusion|summary|getting started|next steps)$/i',
      '/^(why\s+this\s+matters|the\s+future|what\s+next)$/i'
    ];
    
    foreach ($headers as $idx => $header) {
      $text = trim($header['text']);
      foreach ($vaguePatterns as $pattern) {
        if (preg_match($pattern, $text)) {
          $warnings[] = "Header #" . ($idx + 1) . " may be too vague: \"{$text}\". Headers should describe what the section contains.";
          break;
        }
      }
    }
    
    return [
      'valid' => empty($errors),
      'errors' => $errors,
      'warnings' => $warnings
    ];
  }
  
  /**
   * PRINCIPLE 3: Validate paragraph length (2-4 sentences, 40-80 words)
   */
  private function validateParagraphLength(array $paragraphs): array {
    $errors = [];
    $warnings = [];
    
    $overlongCount = 0;
    $overshortCount = 0;
    
    foreach ($paragraphs as $idx => $para) {
      $para = trim($para);
      if (empty($para)) continue;
      
      $wordCount = str_word_count($para);
      $sentenceCount = preg_match_all('/[.!?]+/', $para);
      
      // Check word count (40-80 ideal)
      if ($wordCount > 100) {
        $overlongCount++;
        $errors[] = "Paragraph #" . ($idx + 1) . " is too long ({$wordCount} words). Target: 40-80 words for scannability.";
      } elseif ($wordCount > 80) {
        $warnings[] = "Paragraph #" . ($idx + 1) . " exceeds ideal length ({$wordCount} words). Target: 40-80 words.";
      } elseif ($wordCount < 20 && $wordCount > 0) {
        $overshortCount++;
      }
      
      // Check sentence count (2-4 ideal)
      if ($sentenceCount > 5) {
        $warnings[] = "Paragraph #" . ($idx + 1) . " has {$sentenceCount} sentences. Target: 2-4 sentences for scannability.";
      }
    }
    
    if ($overlongCount > count($paragraphs) * 0.3) {
      $errors[] = "Too many paragraphs exceed ideal length. Over 30% of paragraphs are too long for scannability.";
    }
    
    return [
      'valid' => empty($errors),
      'errors' => $errors,
      'warnings' => $warnings
    ];
  }
  
  /**
   * PRINCIPLE 4: Validate visual separation
   */
  private function validateVisualSeparation(string $htmlContent): array {
    $warnings = [];
    
    // Check for lists (good visual separation)
    $listCount = preg_match_all('/<(ul|ol)[^>]*>/i', $htmlContent);
    
    // Check for long text blocks without breaks
    $textBlocks = preg_split('/<(h[1-6]|ul|ol|table|hr)[^>]*>/i', $htmlContent);
    $longBlocks = 0;
    
    foreach ($textBlocks as $block) {
      $text = strip_tags($block);
      $wordCount = str_word_count($text);
      if ($wordCount > 200) {
        $longBlocks++;
      }
    }
    
    if ($longBlocks > 0) {
      $warnings[] = "Found {$longBlocks} long text block(s) without visual separation. Consider adding headers, lists, or breaks.";
    }
    
    if ($listCount == 0 && str_word_count(strip_tags($htmlContent)) > 500) {
      $warnings[] = "Long content without lists. Consider using bulleted or numbered lists for better visual separation.";
    }
    
    return [
      'valid' => true,
      'warnings' => $warnings
    ];
  }
  
  /**
   * PRINCIPLE 5: Validate logical progression (warnings only)
   */
  private function validateLogicalProgression(array $headers, array $paragraphs): array {
    $warnings = [];
    
    // This is a soft check - narrative flow is allowed in chunking
    // Just warn if structure seems completely random
    
    if (count($headers) > 3) {
      // Check if headers seem to follow a logical order
      // This is heuristic and should only warn, not error
      $hasDefinition = false;
      $hasExplanation = false;
      
      foreach ($headers as $header) {
        $text = strtolower($header['text']);
        if (preg_match('/\b(what|definition|define|meaning)\b/i', $text)) {
          $hasDefinition = true;
        }
        if (preg_match('/\b(how|why|explain|example|benefit|advantage)\b/i', $text)) {
          $hasExplanation = true;
        }
      }
      
      // This is just a suggestion, not a requirement
    }
    
    return ['warnings' => $warnings];
  }
  
  /**
   * Validate common mistakes
   */
  private function validateCommonMistakes(string $htmlContent, array $headers, array $paragraphs): array {
    $errors = [];
    $warnings = [];
    
    // Mistake: Overusing headers for every sentence
    if (count($headers) > count($paragraphs) * 0.8) {
      $warnings[] = "Too many headers relative to content. Headers should structure content, not replace paragraphs.";
    }
    
    // Mistake: Sections with no substantive content
    // This is harder to detect automatically, but we can check for very short sections
    $shortSections = 0;
    // Approximate: count paragraphs between headers
    if (count($headers) > 1) {
      // Rough heuristic: if we have many headers but few paragraphs, sections may be too short
      if (count($paragraphs) < count($headers) * 0.5) {
        $warnings[] = "Some sections may lack substantive content. Ensure each section has meaningful content.";
      }
    }
    
    // Mistake: Large uninterrupted blocks of text
    $textBlocks = preg_split('/<(h[1-6]|ul|ol|table|hr|br)[^>]*>/i', $htmlContent);
    $wallOfText = 0;
    foreach ($textBlocks as $block) {
      $text = strip_tags($block);
      $wordCount = str_word_count($text);
      if ($wordCount > 300) {
        $wallOfText++;
      }
    }
    
    if ($wallOfText > 0) {
      $errors[] = "Found {$wallOfText} large uninterrupted text block(s). Break into smaller chunks with headers or lists.";
    }
    
    return [
      'valid' => empty($errors),
      'errors' => $errors,
      'warnings' => $warnings
    ];
  }
  
  /**
   * Get validation summary for reporting
   */
  public function getSummary(array $result): string {
    $summary = "Content Chunking Validation Results\n";
    $summary .= "==================================\n\n";
    $summary .= "File: " . ($result['file'] ?: 'N/A') . "\n";
    $summary .= "Score: {$result['score']}/100\n";
    $summary .= "Status: " . ($result['valid'] ? "✅ PASS" : "⚠️  NEEDS IMPROVEMENT") . "\n\n";
    
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
    
    if ($result['valid'] && empty($result['warnings'])) {
      $summary .= "✅ Content passes all chunking standards.\n";
    } elseif ($result['valid']) {
      $summary .= "✅ Content passes chunking standards but could be improved.\n";
    } else {
      $summary .= "⚠️  Content needs improvement for better chunking.\n";
      $summary .= "Fix errors to improve scannability and UX.\n";
    }
    
    return $summary;
  }
}

