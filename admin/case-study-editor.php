<?php
/**
 * NRLC AI Case Study System - Internal Authoring UI
 * 
 * This is a schema compiler with guardrails, built as an internal admin tool.
 * Marketing never touches raw HTML or JSON-LD.
 */

require_once __DIR__ . '/../lib/auth.php';
require_once __DIR__ . '/../lib/csrf.php';

require_admin(); // Gate: admin only

require_once __DIR__ . '/../lib/case_study_registry.php';
require_once __DIR__ . '/../lib/case_study_schema.php';
require_once __DIR__ . '/../lib/case_study_validator.php';

$errors = [];
$success = false;
$caseSlug = $_GET['slug'] ?? null;
$caseData = null;

// Load existing case study if editing
if ($caseSlug) {
  $caseData = get_case_study_data($caseSlug);
  if (!$caseData) {
    $errors[] = "Case study not found: {$caseSlug}";
  }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require_csrf_token(); // Validate CSRF token
  
  // Sanitize slug (prevent path traversal)
  $rawSlug = trim($_POST['slug'] ?? '');
  $slug = preg_replace('/[^a-z0-9-]/', '', strtolower($rawSlug)); // Only allow alphanumeric and hyphens
  
  $data = [
    'slug' => $slug,
    'title' => trim($_POST['title'] ?? ''),
    'description' => trim($_POST['description'] ?? ''),
    'prompt_cluster' => trim($_POST['prompt_cluster'] ?? ''),
    'industry' => trim($_POST['industry'] ?? ''),
    'situation' => trim($_POST['situation'] ?? ''),
    'ai_failure' => trim($_POST['ai_failure'] ?? ''),
    'technical_diagnosis' => trim($_POST['technical_diagnosis'] ?? ''),
    'intervention' => trim($_POST['intervention'] ?? ''),
    'outcome' => trim($_POST['outcome'] ?? ''),
    'citation_result' => trim($_POST['citation_result'] ?? '')
  ];
  
  // Check for slug collision
  $existingFile = $dataDir . $data['slug'] . '.json';
  if (file_exists($existingFile) && (!$caseSlug || $caseSlug !== $data['slug'])) {
    $errors[] = "Slug already exists: {$data['slug']}";
  }
  
  // Server-side validation
  $validationError = validate_case_study($data);
  if ($validationError) {
    $errors = explode("\n", $validationError);
  }
  
  if (empty($errors)) {
    // Generate JSON-LD
    $schemaData = [
      'slug' => $data['slug'],
      'title' => $data['title'],
      'description' => $data['description'],
      'prompt_cluster' => $data['prompt_cluster'],
      'situation' => $data['situation'],
      'ai_failure' => $data['ai_failure'],
      'technical_diagnosis' => $data['technical_diagnosis'],
      'intervention' => $data['intervention'],
      'outcome' => $data['outcome'],
      'citation_result' => $data['citation_result']
    ];
    
    $schemaGraph = generate_case_study_master_schema($schemaData);
    
    // Save to registry (in production, this would update the database/file)
    // For now, we'll save to a data file
    $dataDir = __DIR__ . '/../data/case-studies/';
    if (!is_dir($dataDir)) {
      mkdir($dataDir, 0755, true);
    }
    
    // Save JSON data
    file_put_contents(
      $dataDir . $data['slug'] . '.json',
      json_encode($data, JSON_PRETTY_PRINT)
    );
    
    // Save JSON-LD
    file_put_contents(
      $dataDir . $data['slug'] . '.jsonld',
      json_encode($schemaGraph, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
    );
    
    // Save markdown (for human-readable version)
    $mdContent = generate_markdown($data);
    file_put_contents(
      $dataDir . $data['slug'] . '.md',
      $mdContent
    );
    
    $success = true;
    $caseData = $data;
  }
}

function generate_markdown(array $data): string {
  $md = "# {$data['title']}\n\n";
  $md .= "{$data['description']}\n\n";
  $md .= "## Situation\n\n{$data['situation']}\n\n";
  $md .= "## AI Retrieval Failure\n\n{$data['ai_failure']}\n\n";
  $md .= "## Technical Diagnosis\n\n{$data['technical_diagnosis']}\n\n";
  $md .= "## Intervention\n\n{$data['intervention']}\n\n";
  $md .= "## Outcome\n\n{$data['outcome']}\n\n";
  $md .= "## Citation Result\n\n{$data['citation_result']}\n\n";
  return $md;
}

// Get prompt clusters for dropdown
$promptClusters = [
  'invisible-brand' => 'Invisible Brand in AI Answers',
  'competitor-hallucination' => 'Competitor Hallucination',
  'trust-comparison' => 'Trust and Safety Comparison',
  'local-failure' => 'Local Recommendation Failure'
];

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Case Study Editor | NRLC.ai Admin</title>
  <style>
    body { font-family: system-ui, sans-serif; max-width: 900px; margin: 2rem auto; padding: 0 1rem; }
    .error { background: #fee; border: 1px solid #fcc; padding: 1rem; margin: 1rem 0; border-radius: 4px; }
    .success { background: #efe; border: 1px solid #cfc; padding: 1rem; margin: 1rem 0; border-radius: 4px; }
    label { display: block; margin-top: 1rem; font-weight: 600; }
    input[type="text"], textarea, select { width: 100%; padding: 0.5rem; margin-top: 0.25rem; border: 1px solid #ccc; border-radius: 4px; }
    textarea { min-height: 150px; font-family: monospace; }
    button { background: #0066cc; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 4px; cursor: pointer; margin-top: 1rem; }
    button:hover { background: #0052a3; }
    .char-count { font-size: 0.875rem; color: #666; margin-top: 0.25rem; }
    .required { color: #c00; }
  </style>
</head>
<body>
  <h1>Case Study Editor</h1>
  
  <?php if ($success): ?>
    <div class="success">
      <strong>Success!</strong> Case study saved. JSON-LD and markdown files generated.
    </div>
  <?php endif; ?>
  
  <?php if (!empty($errors)): ?>
    <div class="error">
      <strong>Validation Errors:</strong>
      <ul>
        <?php foreach ($errors as $error): ?>
          <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>
  
  <form method="POST">
    <?= csrf_field() ?>
    <label>
      Slug <span class="required">*</span>
      <input type="text" name="slug" value="<?= htmlspecialchars($caseData['slug'] ?? '') ?>" required pattern="[a-z0-9-]+" placeholder="b2b-saas">
      <span class="char-count">URL-friendly identifier (lowercase, hyphens only)</span>
    </label>
    
    <label>
      Title <span class="required">*</span>
      <input type="text" name="title" value="<?= htmlspecialchars($caseData['title'] ?? '') ?>" required placeholder="B2B SaaS AI SEO Case Study">
    </label>
    
    <label>
      Description (One Sentence) <span class="required">*</span>
      <textarea name="description" required placeholder="How a SaaS company increased AI citations by 340% through structured data optimization and entity mapping."><?= htmlspecialchars($caseData['description'] ?? '') ?></textarea>
      <span class="char-count">WHAT AI GOT WRONG AND WHAT CHANGED</span>
    </label>
    
    <label>
      Prompt Cluster <span class="required">*</span>
      <select name="prompt_cluster" required>
        <option value="">-- Select Prompt Cluster --</option>
        <?php foreach ($promptClusters as $value => $label): ?>
          <option value="<?= htmlspecialchars($value) ?>" <?= ($caseData['prompt_cluster'] ?? '') === $value ? 'selected' : '' ?>>
            <?= htmlspecialchars($label) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </label>
    
    <label>
      Industry <span class="required">*</span>
      <input type="text" name="industry" value="<?= htmlspecialchars($caseData['industry'] ?? '') ?>" required placeholder="SaaS">
    </label>
    
    <label>
      Situation (Real World Context) <span class="required">*</span>
      <textarea name="situation" required minlength="150" placeholder="A leading B2B SaaS platform with strong market authority was consistently omitted from AI-generated answers..."><?= htmlspecialchars($caseData['situation'] ?? '') ?></textarea>
      <span class="char-count">Minimum 150 characters</span>
    </label>
    
    <label>
      AI Retrieval Failure (What AI Failed to Return) <span class="required">*</span>
      <textarea name="ai_failure" required minlength="150" placeholder="When users asked AI systems 'What are the best B2B SaaS platforms for [specific use case]?', the platform was never mentioned..."><?= htmlspecialchars($caseData['ai_failure'] ?? '') ?></textarea>
      <span class="char-count">Minimum 150 characters</span>
    </label>
    
    <label>
      Technical Diagnosis (Why AI Could Not Cite) <span class="required">*</span>
      <textarea name="technical_diagnosis" required minlength="100" placeholder="Analysis revealed three critical gaps: (1) Missing entity disambiguation..."><?= htmlspecialchars($caseData['technical_diagnosis'] ?? '') ?></textarea>
      <span class="char-count">Minimum 100 characters. Must reference data, entity, or schema concepts.</span>
    </label>
    
    <label>
      Intervention (Entity / Data / Schema Actions) <span class="required">*</span>
      <textarea name="intervention" required minlength="100" placeholder="Implemented comprehensive entity mapping using JSON-LD schema..."><?= htmlspecialchars($caseData['intervention'] ?? '') ?></textarea>
      <span class="char-count">Minimum 100 characters. Must describe concrete actions (implemented, added, created, etc.).</span>
    </label>
    
    <label>
      Outcome (How AI Answers Changed) <span class="required">*</span>
      <textarea name="outcome" required minlength="100" placeholder="Within 90 days, AI systems began consistently citing the platform..."><?= htmlspecialchars($caseData['outcome'] ?? '') ?></textarea>
      <span class="char-count">Minimum 100 characters. Must describe how AI answer behavior changed.</span>
    </label>
    
    <label>
      Citation Result (Citation / Inclusion / Correctness) <span class="required">*</span>
      <textarea name="citation_result" required placeholder="Platform now appears in 85% of relevant AI answers with correct brand attribution..."><?= htmlspecialchars($caseData['citation_result'] ?? '') ?></textarea>
    </label>
    
    <button type="submit">Save Case Study</button>
  </form>
  
  <hr style="margin: 2rem 0;">
  <p><small>This form enforces all validation rules server-side. JSON-LD is auto-generated. Humans never hand-edit JSON-LD.</small></p>
</body>
</html>

