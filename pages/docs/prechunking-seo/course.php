<?php
declare(strict_types=1);
// Prechunking SEO Operator Training Course
// This is training, not documentation. Completion requires producing artifacts and passing validation.

require_once __DIR__.'/../../../lib/schema_builders.php';

$canonicalUrl = absolute_url('/docs/prechunking-seo/course/');

// Module data structure with validation rules
$modules = [
  1 => [
    'id' => 'module-1',
    'title' => 'Chunk Extraction Reality',
    'short' => 'Understand how AI extracts chunks',
    'skill' => 'Chunk identification and extraction pattern recognition',
    'duration' => '~30 minutes',
    'prerequisite' => null
  ],
  2 => [
    'id' => 'module-2',
    'title' => 'Crouton Writing',
    'short' => 'Write atomic facts that survive extraction',
    'skill' => 'Crouton writing and atomicity validation',
    'duration' => '~45 minutes',
    'prerequisite' => 1
  ],
  3 => [
    'id' => 'module-3',
    'title' => 'Data Shaping',
    'short' => 'Transform narrative into machine-safe structure',
    'skill' => 'Declarative refactoring and scope control',
    'duration' => '~60 minutes',
    'prerequisite' => 2
  ],
  4 => [
    'id' => 'module-4',
    'title' => 'Precog Modeling',
    'short' => 'Predict follow-up questions and required information',
    'skill' => 'Intent forecasting and dependency mapping',
    'duration' => '~45 minutes',
    'prerequisite' => 3
  ],
  5 => [
    'id' => 'module-5',
    'title' => 'Prechunking Application',
    'short' => 'Apply the full workflow to real content',
    'skill' => 'Auditing, refactoring, and safe publishing',
    'duration' => '~90 minutes',
    'prerequisite' => 4
  ],
  6 => [
    'id' => 'module-6',
    'title' => 'Validation and Iteration',
    'short' => 'Verify retrieval success and diagnose failures',
    'skill' => 'Answer inspection and iteration loops',
    'duration' => '~45 minutes',
    'prerequisite' => 5
  ]
];

// Get current module from query param or default to overview
$currentModule = isset($_GET['module']) ? (int)$_GET['module'] : 0;
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">

    <!-- Course Overview Page (when module = 0) -->
    <div id="course-overview" class="course-page" style="display: <?= $currentModule === 0 ? 'block' : 'none' ?>;">
      
      <!-- Course Header -->
      <div class="content-block module">
        <div class="content-block__header">
          <h1 class="content-block__title">Prechunking SEO Operator Training</h1>
        </div>
        <div class="content-block__body">
          <p style="font-size: 1.125rem; margin-bottom: 1rem;">A hands-on, skills-based training program for controlling AI retrieval, citation, and answer assembly.</p>
          <p><strong>This is not a reading course.</strong></p>
          <p><strong>This is an operator course.</strong></p>
          <p>You will complete structured modules, perform required exercises, produce artifacts, and validate your work against strict criteria.</p>
          <p style="margin-top: 1.5rem;"><strong>Advancement is earned through execution.</strong></p>
        </div>
      </div>

      <!-- Course Overview Stats -->
      <div class="content-block module" style="background: #f5f5f5; padding: 1.5rem; border-radius: 4px; margin-bottom: 2rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1.5rem; text-align: center;">
          <div>
            <div style="font-size: 2rem; font-weight: bold; color: #000080;">6</div>
            <div style="font-size: 0.875rem; color: #666;">Modules</div>
          </div>
          <div>
            <div style="font-size: 2rem; font-weight: bold; color: #000080;">6+</div>
            <div style="font-size: 0.875rem; color: #666;">Hours</div>
          </div>
          <div>
            <div style="font-size: 2rem; font-weight: bold; color: #000080;">100%</div>
            <div style="font-size: 0.875rem; color: #666;">Hands-On</div>
          </div>
        </div>
      </div>

      <!-- Course Progress -->
      <div class="content-block module" style="margin-bottom: 2rem;">
        <div class="content-block__header">
          <h2 class="content-block__title">Course Progress</h2>
        </div>
        <div class="content-block__body">
          <div style="background: #e0e0e0; height: 24px; border: 1px solid #808080; border-radius: 2px; overflow: hidden; margin-bottom: 0.5rem;">
            <div id="course-progress-bar" style="background: linear-gradient(to right, #0080ff, #40a0ff); height: 100%; width: 0%; transition: width 0.3s ease;"></div>
          </div>
          <p style="font-size: 0.875rem; color: #666; margin: 0;"><span id="course-progress-text">0 of 6 modules completed</span></p>
        </div>
      </div>

      <!-- Module Catalog -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">Course Modules</h2>
        </div>
        <div class="content-block__body">
          <p>Complete modules sequentially. Each module requires producing artifacts and passing validation before proceeding.</p>
          <div style="display: grid; gap: 1.5rem; margin-top: 2rem;" id="module-catalog">
            <?php foreach ($modules as $num => $module): ?>
            <div class="module-card" id="catalog-<?= htmlspecialchars($module['id']) ?>" style="border: 2px solid #c0c0c0; border-radius: 4px; padding: 1.5rem; background: #fff; position: relative;">
              <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                <div style="flex: 1;">
                  <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                    <span class="module-number" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: #000080; color: white; border-radius: 50%; font-weight: bold; font-size: 1rem;"><?= $num ?></span>
                    <h3 style="margin: 0; font-size: 1.25rem; color: #000080;">Module <?= $num ?>: <?= htmlspecialchars($module['title']) ?></h3>
                  </div>
                  <p style="margin: 0.5rem 0; color: #666; font-size: 0.9375rem;"><?= htmlspecialchars($module['short']) ?></p>
                  <p style="margin: 0.25rem 0; font-size: 0.875rem; color: #888;"><strong>Skill:</strong> <?= htmlspecialchars($module['skill']) ?></p>
                  <p style="margin: 0.25rem 0; font-size: 0.875rem; color: #888;"><strong>Duration:</strong> <?= htmlspecialchars($module['duration']) ?></p>
                </div>
                <div style="text-align: right;">
                  <span class="module-status-badge" data-module="<?= $num ?>" style="display: inline-block; padding: 0.25rem 0.75rem; background: #e0e0e0; border: 1px solid #808080; border-radius: 3px; font-size: 0.875rem; font-weight: bold; color: #666;">Not Started</span>
                </div>
              </div>
              <div class="module-actions" data-module="<?= $num ?>">
                <button class="btn-start-module" data-module="<?= $num ?>" onclick="navigateToModule(<?= $num ?>)" style="display: inline-block; padding: 0.5rem 1rem; background: #000080; color: white; border: none; border-radius: 3px; font-weight: bold; font-size: 0.9375rem; cursor: pointer;">Start Module <?= $num ?></button>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- How This Course Works -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">How This Course Works</h2>
        </div>
        <div class="content-block__body">
          <p>This course is divided into six sequential modules that teach the complete prechunking workflow.</p>
          <p><strong>The Prechunking Workflow:</strong></p>
          <ol>
            <li><strong>Intent Decomposition</strong> (Module 4): Break user needs into discrete questions</li>
            <li><strong>Crouton Inventory</strong> (Module 4): Map intents to required atomic facts</li>
            <li><strong>Data Shaping</strong> (Module 3): Transform narrative into declarative croutons</li>
            <li><strong>Structured Publishing</strong> (Module 5): Organize croutons preserving chunk boundaries</li>
            <li><strong>Retrieval Validation</strong> (Module 6): Test whether croutons are actually retrieved</li>
          </ol>
          <p>Modules 1-2 provide foundational skills (understanding chunk extraction and writing croutons).</p>
          <p>Each module trains a specific operational skill required to implement Prechunking SEO in real systems.</p>
          <p>For every module, you will complete:</p>
          <ul>
            <li>A required task</li>
            <li>A tangible artifact</li>
            <li>A validation check</li>
          </ul>
          <p><strong>You do not advance by reading.</strong></p>
          <p><strong>You advance by producing correct outputs.</strong></p>
        </div>
      </div>

      <!-- Course Rules -->
      <div class="content-block module" style="background: #fff3cd; border: 2px solid #ffc107; padding: 1.5rem; border-radius: 4px;">
        <div class="content-block__header">
          <h2 class="content-block__title" style="color: #856404;">Course Rules (Non-Negotiable)</h2>
        </div>
        <div class="content-block__body">
          <ul>
            <li>You do not advance without producing artifacts</li>
            <li>Artifacts must survive isolation tests</li>
            <li>Incorrect outputs must be rewritten</li>
            <li>Completion is based on demonstrated ability, not time</li>
            <li>Reading does not equal training</li>
          </ul>
          <p style="margin-top: 1rem; font-weight: bold;">This course assumes you are here to operate, not observe.</p>
        </div>
      </div>

      <!-- Reference Documentation -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">Reference Documentation</h2>
        </div>
        <div class="content-block__body">
          <p>Use the following documentation as specifications while completing the course:</p>
          <ul>
            <li><a href="/docs/prechunking-seo/">Prechunking SEO Overview</a></li>
            <li><a href="/docs/prechunking-seo/core-concepts/">Core Concepts</a></li>
            <li><a href="/docs/prechunking-seo/croutons/">Crouton Specification</a></li>
            <li><a href="/docs/prechunking-seo/precogs/">Precog Modeling</a></li>
            <li><a href="/docs/prechunking-seo/workflow/">Prechunking Workflow</a></li>
            <li><a href="/docs/prechunking-seo/academic-signals/">Academic Signals</a> - Evidence-backed research alignment</li>
          </ul>
        </div>
      </div>

      <!-- Final Note -->
      <div class="content-block module" style="margin-top: 2rem;">
        <div class="content-block__header">
          <h2 class="content-block__title">Final Note</h2>
        </div>
        <div class="content-block__body">
          <p>This course is designed to change how you think, write, and validate information for AI systems.</p>
          <p><strong>If you complete it correctly, you will no longer write content.</strong></p>
          <p><strong>You will engineer retrieval.</strong></p>
        </div>
      </div>

    </div>

    <!-- MODULE 1 PAGE -->
    <div id="module-page-1" class="course-page module-page" style="display: <?= $currentModule === 1 ? 'block' : 'none' ?>;">
      <div class="content-block module">
        <div class="content-block__header">
          <div style="margin-bottom: 1rem;">
            <a href="?module=0" onclick="navigateToModule(0); return false;" style="color: #000080; text-decoration: none; font-weight: bold; font-size: 0.9375rem;">← Back to Overview</a>
          </div>
          <div style="display: flex; align-items: center; gap: 1rem;">
            <span style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: #000080; color: white; border-radius: 50%; font-weight: bold; font-size: 1.25rem; flex-shrink: 0;">1</span>
            <h1 class="content-block__title" style="margin: 0;">Module 1: Chunk Extraction Reality</h1>
          </div>
        </div>
        <div class="content-block__body">
          <p><strong>What You Will Learn</strong></p>
          <p>How AI systems actually break content into chunks and why pages themselves are irrelevant to retrieval.</p>
          <p><strong>Why this matters for prechunking:</strong> Because AI extracts chunks (not pages), we must shape content into retrievable chunks BEFORE AI systems extract it. This is what "prechunking" means: shaping content at publishing time, not after extraction.</p>
          <p><strong>Retrieval vs Ranking:</strong> Prechunking operates at the retrieval layer, not the ranking layer. Ranking determines which pages appear in search results. Retrieval determines which facts appear in AI-generated answers. A page can rank first but have zero facts retrieved if its chunks are ambiguous.</p>
          
          <p><strong>Skill You Are Training</strong></p>
          <p>Chunk identification and extraction pattern recognition. Understanding chunk boundaries (where one retrievable unit ends and another begins).</p>
          
          <p><strong>Exercise</strong></p>
          <ol>
            <li>Select one existing NRLC.ai page or any public webpage</li>
            <li>Copy three consecutive paragraphs</li>
            <li>Split the content into extraction-sized chunks as an LLM would</li>
            <li>Identify chunk boundaries (where one fact ends and another begins)</li>
            <li>Identify context noise (narrative transitions, rhetorical questions, mixed intents, opinion blended with facts)</li>
            <li>Remove noise to reduce ambiguity</li>
          </ol>

          <p><strong>Required Artifact</strong></p>
          <ul>
            <li>A list of extracted chunks (noise-reduced)</li>
            <li>Each chunk must contain a single idea</li>
            <li>List of noise elements identified and removed</li>
          </ul>

          <p><strong>Validation Criteria</strong></p>
          <p>You PASS if:</p>
          <ul>
            <li>No chunk contains more than one fact</li>
            <li>No chunk relies on previous context</li>
            <li>Each chunk can be read in isolation without ambiguity</li>
            <li>No narrative transitions in factual sections</li>
            <li>No rhetorical questions in factual sections</li>
            <li>No mixed intents in a single section</li>
            <li>No opinion blended into factual statements</li>
          </ul>
          <p>You FAIL if:</p>
          <ul>
            <li>Pronouns exist</li>
            <li>Multiple claims exist</li>
            <li>Context is implied</li>
            <li>Noise elements remain</li>
          </ul>
          <p><strong>Academic Signal:</strong> Context noise reduction. Research shows ambiguous or overloaded text degrades model confidence and retrieval reliability.</p>

          <!-- Submission Form -->
          <div style="margin-top: 2rem; padding: 1.5rem; background: #f5f5f5; border: 2px solid #c0c0c0; border-radius: 4px;">
            <h3 style="margin-top: 0;">Submit Your Work</h3>
            <form id="module-1-form" onsubmit="validateModule1(event); return false;">
              <div style="margin-bottom: 1rem;">
                <label for="module-1-artifact" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Paste your list of extracted chunks (one per line):</label>
                <textarea id="module-1-artifact" name="artifact" rows="10" style="width: 100%; padding: 0.75rem; border: 1px solid #808080; border-radius: 3px; font-family: monospace; font-size: 0.875rem;" required></textarea>
                <p style="font-size: 0.875rem; color: #666; margin-top: 0.25rem;">Each line should be one chunk. The system will validate your submission.</p>
              </div>
              <button type="submit" style="padding: 0.75rem 1.5rem; background: #000080; color: white; border: none; border-radius: 3px; font-weight: bold; cursor: pointer;">Submit for Validation</button>
            </form>
            <div id="module-1-feedback" style="margin-top: 1rem; display: none;"></div>
          </div>

          <!-- Navigation -->
          <div style="margin-top: 3rem; padding-top: 2rem; border-top: 2px solid #e0e0e0; display: flex; justify-content: space-between;">
            <div></div>
            <div id="module-1-next" style="display: none;">
              <a href="?module=2" onclick="navigateToModule(2); return false;" style="display: inline-block; padding: 0.75rem 1.5rem; background: #000080; color: white; text-decoration: none; border-radius: 3px; font-weight: bold;">Next: Module 2 →</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- MODULE 2 PAGE -->
    <div id="module-page-2" class="course-page module-page" style="display: <?= $currentModule === 2 ? 'block' : 'none' ?>;">
      <div class="content-block module">
        <div class="content-block__header">
          <div style="margin-bottom: 1rem;">
            <a href="?module=0" onclick="navigateToModule(0); return false;" style="color: #000080; text-decoration: none; font-weight: bold; font-size: 0.9375rem;">← Back to Overview</a>
          </div>
          <div style="display: flex; align-items: center; gap: 1rem;">
            <span style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: #000080; color: white; border-radius: 50%; font-weight: bold; font-size: 1.25rem; flex-shrink: 0;">2</span>
            <h1 class="content-block__title" style="margin: 0;">Module 2: Crouton Writing</h1>
          </div>
        </div>
        <div class="content-block__body">
          <p><strong>What You Will Learn</strong></p>
          <p>How to write atomic facts that survive extraction and citation.</p>
          <p><strong>Why croutons matter:</strong> Croutons are the unit of retrieval. AI systems cite croutons, not pages. When AI extracts a crouton, it must remain accurate without the rest of the page. This is why we prechunk: to ensure facts survive extraction.</p>
          <p><strong>Reference:</strong> See the <a href="/docs/prechunking-seo/croutons/" target="_blank">Crouton Specification</a> for complete rules and examples.</p>
          
          <p><strong>Skill You Are Training</strong></p>
          <p>Crouton writing and atomicity validation. Writing facts that AI systems can retrieve and cite accurately.</p>
          
          <p><strong>Exercise</strong></p>
          <ol>
            <li>Take a narrative paragraph</li>
            <li>Extract exactly five croutons (atomic, self-contained facts)</li>
            <li>Each crouton must survive isolation (read it alone - does it make sense?)</li>
          </ol>

          <p><strong>Required Artifact</strong></p>
          <p>A list of five declarative sentences.</p>

          <p><strong>Validation Criteria</strong></p>
          <p>Each crouton must:</p>
          <ul>
            <li>Contain exactly one fact</li>
            <li>Use explicit entities (no pronouns, no implied subjects)</li>
            <li>Survive isolation (copy sentence alone - does meaning degrade?)</li>
            <li>Contain no conjunctions ("and", "but", "also", "as well as")</li>
            <li>Have explicit subject and predicate</li>
            <li>Require no implied context</li>
          </ul>
          <p><strong>Isolation Test:</strong> Copy each crouton sentence alone. If meaning degrades → FAIL.</p>
          <p>Failure of any rule results in a FAIL.</p>
          <p><strong>Academic Signal:</strong> Atomic extractability. Research shows LLM failures emerge when facts require surrounding context. Those facts are skipped or altered.</p>

          <!-- Submission Form -->
          <div style="margin-top: 2rem; padding: 1.5rem; background: #f5f5f5; border: 2px solid #c0c0c0; border-radius: 4px;">
            <h3 style="margin-top: 0;">Submit Your Work</h3>
            <form id="module-2-form" onsubmit="validateModule2(event); return false;">
              <div style="margin-bottom: 1rem;">
                <label for="module-2-artifact" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Paste your five croutons (one per line):</label>
                <textarea id="module-2-artifact" name="artifact" rows="6" style="width: 100%; padding: 0.75rem; border: 1px solid #808080; border-radius: 3px; font-family: monospace; font-size: 0.875rem;" required></textarea>
                <p style="font-size: 0.875rem; color: #666; margin-top: 0.25rem;">Exactly 5 croutons required. Each must be a single declarative sentence.</p>
              </div>
              <button type="submit" style="padding: 0.75rem 1.5rem; background: #000080; color: white; border: none; border-radius: 3px; font-weight: bold; cursor: pointer;">Submit for Validation</button>
            </form>
            <div id="module-2-feedback" style="margin-top: 1rem; display: none;"></div>
          </div>

          <!-- Navigation -->
          <div style="margin-top: 3rem; padding-top: 2rem; border-top: 2px solid #e0e0e0; display: flex; justify-content: space-between;">
            <div>
              <a href="?module=1" onclick="navigateToModule(1); return false;" style="display: inline-block; padding: 0.75rem 1.5rem; color: #000080; text-decoration: none; font-weight: bold;">← Previous: Module 1</a>
            </div>
            <div id="module-2-next" style="display: none;">
              <a href="?module=3" onclick="navigateToModule(3); return false;" style="display: inline-block; padding: 0.75rem 1.5rem; background: #000080; color: white; text-decoration: none; border-radius: 3px; font-weight: bold;">Next: Module 3 →</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- MODULE 3 PAGE -->
    <div id="module-page-3" class="course-page module-page" style="display: <?= $currentModule === 3 ? 'block' : 'none' ?>;">
      <div class="content-block module">
        <div class="content-block__header">
          <div style="margin-bottom: 1rem;">
            <a href="?module=0" onclick="navigateToModule(0); return false;" style="color: #000080; text-decoration: none; font-weight: bold; font-size: 0.9375rem;">← Back to Overview</a>
          </div>
          <div style="display: flex; align-items: center; gap: 1rem;">
            <span style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: #000080; color: white; border-radius: 50%; font-weight: bold; font-size: 1.25rem; flex-shrink: 0;">3</span>
            <h1 class="content-block__title" style="margin: 0;">Module 3: Data Shaping</h1>
          </div>
        </div>
        <div class="content-block__body">
          <p><strong>What You Will Learn</strong></p>
          <p>How to transform narrative content into machine-safe, retrieval-ready structure.</p>
          <p><strong>Prechunking Workflow:</strong> This is step 3 of the prechunking workflow (Data Shaping). Steps 1-2 are intent decomposition and crouton inventory (covered in Module 4). Step 4 is structured publishing (covered in Module 5).</p>
          <p><strong>Chunk Boundaries:</strong> As you shape content, plan chunk boundaries. Related croutons must exist within the same potential chunk so they're retrieved together. Facts that depend on each other must not be split across chunk boundaries.</p>
          
          <p><strong>Skill You Are Training</strong></p>
          <p>Declarative refactoring and scope control. Planning chunk boundaries while shaping content.</p>
          
          <p><strong>Exercise</strong></p>
          <ol>
            <li>Select an existing page section</li>
            <li>Rewrite it as:</li>
            <ul>
              <li>A crouton list (atomic facts)</li>
              <li>Chunk boundary plan (which croutons belong together)</li>
              <li>An optional structured data outline</li>
            </ul>
            <li>Ensure every brand, system, or concept is explicitly named</li>
            <li>State relationships directly ("X does Y for Z")</li>
            <li>Remove metaphors and figurative language</li>
            <li>Align schema exactly with on-page text</li>
          </ol>

          <p><strong>Required Artifacts</strong></p>
          <ul>
            <li>Refactored content</li>
            <li>Crouton inventory table</li>
          </ul>

          <p><strong>Validation Criteria</strong></p>
          <p>You PASS if:</p>
          <ul>
            <li>Every sentence is declarative</li>
            <li>Every fact is clearly scoped</li>
            <li>No narrative glue remains</li>
            <li>Every entity is explicitly named (no implied brands, systems, or concepts)</li>
            <li>Relationships are stated directly (no implied connections)</li>
            <li>No metaphors or figurative language in factual content</li>
            <li>Schema aligns exactly with on-page text</li>
          </ul>
          <p><strong>Academic Signal:</strong> Entity and relationship explicitness. LLMs extract entities and relationships, not prose meaning. Ambiguous naming or implied relationships reduce extractability.</p>

          <!-- Submission Form -->
          <div style="margin-top: 2rem; padding: 1.5rem; background: #f5f5f5; border: 2px solid #c0c0c0; border-radius: 4px;">
            <h3 style="margin-top: 0;">Submit Your Work</h3>
            <form id="module-3-form" onsubmit="validateModule3(event); return false;">
              <div style="margin-bottom: 1rem;">
                <label for="module-3-artifact" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Paste your refactored content (crouton list):</label>
                <textarea id="module-3-artifact" name="artifact" rows="10" style="width: 100%; padding: 0.75rem; border: 1px solid #808080; border-radius: 3px; font-family: monospace; font-size: 0.875rem;" required></textarea>
              </div>
              <div style="margin-bottom: 1rem;">
                <label for="module-3-inventory" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Paste your crouton inventory table:</label>
                <textarea id="module-3-inventory" name="inventory" rows="6" style="width: 100%; padding: 0.75rem; border: 1px solid #808080; border-radius: 3px; font-family: monospace; font-size: 0.875rem;" required></textarea>
              </div>
              <button type="submit" style="padding: 0.75rem 1.5rem; background: #000080; color: white; border: none; border-radius: 3px; font-weight: bold; cursor: pointer;">Submit for Validation</button>
            </form>
            <div id="module-3-feedback" style="margin-top: 1rem; display: none;"></div>
          </div>

          <!-- Navigation -->
          <div style="margin-top: 3rem; padding-top: 2rem; border-top: 2px solid #e0e0e0; display: flex; justify-content: space-between;">
            <div>
              <a href="?module=2" onclick="navigateToModule(2); return false;" style="display: inline-block; padding: 0.75rem 1.5rem; color: #000080; text-decoration: none; font-weight: bold;">← Previous: Module 2</a>
            </div>
            <div id="module-3-next" style="display: none;">
              <a href="?module=4" onclick="navigateToModule(4); return false;" style="display: inline-block; padding: 0.75rem 1.5rem; background: #000080; color: white; text-decoration: none; border-radius: 3px; font-weight: bold;">Next: Module 4 →</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- MODULE 4 PAGE -->
    <div id="module-page-4" class="course-page module-page" style="display: <?= $currentModule === 4 ? 'block' : 'none' ?>;">
      <div class="content-block module">
        <div class="content-block__header">
          <div style="margin-bottom: 1rem;">
            <a href="?module=0" onclick="navigateToModule(0); return false;" style="color: #000080; text-decoration: none; font-weight: bold; font-size: 0.9375rem;">← Back to Overview</a>
          </div>
          <div style="display: flex; align-items: center; gap: 1rem;">
            <span style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: #000080; color: white; border-radius: 50%; font-weight: bold; font-size: 1.25rem; flex-shrink: 0;">4</span>
            <h1 class="content-block__title" style="margin: 0;">Module 4: Precog Modeling</h1>
          </div>
        </div>
        <div class="content-block__body">
          <p><strong>What You Will Learn</strong></p>
          <p>How to predict follow-up questions and define required information in advance.</p>
          <p><strong>Prechunking Workflow:</strong> This is part of workflow step 1 (Intent Decomposition) and step 2 (Crouton Inventory). Precog modeling identifies what information users need, then maps those needs to required croutons.</p>
          <p><strong>Why precogs matter:</strong> Missing croutons cause AI systems to cite competitors or generate incomplete answers. Precog modeling ensures all required facts exist before users need them.</p>
          <p><strong>Trust Gaps:</strong> Identify trust questions - information users need before believing or acting on a claim. Each trust question requires specific croutons.</p>
          
          <p><strong>Skill You Are Training</strong></p>
          <p>Intent forecasting, trust-question identification, and crouton dependency mapping.</p>
          
          <p><strong>Exercise</strong></p>
          <p>Given one primary query:</p>
          <ol>
            <li>Decompose the intent (what is the user really asking?)</li>
            <li>List the next five follow-up questions a user or AI agent will ask</li>
            <li>Identify trust gaps (what information is needed to believe the answer?)</li>
            <li>Map the required croutons for each question and trust gap</li>
            <li>Ensure primary query phrasing appears verbatim in at least one crouton</li>
            <li>Ensure secondary query variants are covered in separate croutons (not merged)</li>
            <li>Ensure headers mirror how users actually ask questions (not marketing language)</li>
          </ol>

          <p><strong>Required Artifacts</strong></p>
          <ul>
            <li>Intent tree</li>
            <li>Crouton dependency map</li>
          </ul>

          <p><strong>Validation Criteria</strong></p>
          <p>You PASS if:</p>
          <ul>
            <li>Follow-up questions are logically necessary</li>
            <li>Each question has required facts</li>
            <li>No crouton serves multiple primary intents</li>
            <li>Primary query phrasing appears verbatim in at least one crouton</li>
            <li>Secondary query variants are covered in separate croutons (not merged)</li>
            <li>No crouton relies on synonyms alone when literal phrasing is common</li>
            <li>Headers mirror how users actually ask questions (not marketing language)</li>
          </ul>
          <p><strong>Academic Signal:</strong> Query–Chunk Semantic Alignment. LLMs overweight semantic overlap between query and source text when selecting citations. Stronger semantic overlap increases citation likelihood.</p>

          <!-- Submission Form -->
          <div style="margin-top: 2rem; padding: 1.5rem; background: #f5f5f5; border: 2px solid #c0c0c0; border-radius: 4px;">
            <h3 style="margin-top: 0;">Submit Your Work</h3>
            <form id="module-4-form" onsubmit="validateModule4(event); return false;">
              <div style="margin-bottom: 1rem;">
                <label for="module-4-primary" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Primary query:</label>
                <input type="text" id="module-4-primary" name="primary" style="width: 100%; padding: 0.75rem; border: 1px solid #808080; border-radius: 3px;" required>
              </div>
              <div style="margin-bottom: 1rem;">
                <label for="module-4-intent" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Intent tree (list 5 follow-up questions):</label>
                <textarea id="module-4-intent" name="intent" rows="6" style="width: 100%; padding: 0.75rem; border: 1px solid #808080; border-radius: 3px; font-family: monospace; font-size: 0.875rem;" required></textarea>
              </div>
              <div style="margin-bottom: 1rem;">
                <label for="module-4-dependency" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Crouton dependency map:</label>
                <textarea id="module-4-dependency" name="dependency" rows="8" style="width: 100%; padding: 0.75rem; border: 1px solid #808080; border-radius: 3px; font-family: monospace; font-size: 0.875rem;" required></textarea>
              </div>
              <button type="submit" style="padding: 0.75rem 1.5rem; background: #000080; color: white; border: none; border-radius: 3px; font-weight: bold; cursor: pointer;">Submit for Validation</button>
            </form>
            <div id="module-4-feedback" style="margin-top: 1rem; display: none;"></div>
          </div>

          <!-- Navigation -->
          <div style="margin-top: 3rem; padding-top: 2rem; border-top: 2px solid #e0e0e0; display: flex; justify-content: space-between;">
            <div>
              <a href="?module=3" onclick="navigateToModule(3); return false;" style="display: inline-block; padding: 0.75rem 1.5rem; color: #000080; text-decoration: none; font-weight: bold;">← Previous: Module 3</a>
            </div>
            <div id="module-4-next" style="display: none;">
              <a href="?module=5" onclick="navigateToModule(5); return false;" style="display: inline-block; padding: 0.75rem 1.5rem; background: #000080; color: white; text-decoration: none; border-radius: 3px; font-weight: bold;">Next: Module 5 →</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- MODULE 5 PAGE -->
    <div id="module-page-5" class="course-page module-page" style="display: <?= $currentModule === 5 ? 'block' : 'none' ?>;">
      <div class="content-block module">
        <div class="content-block__header">
          <div style="margin-bottom: 1rem;">
            <a href="?module=0" onclick="navigateToModule(0); return false;" style="color: #000080; text-decoration: none; font-weight: bold; font-size: 0.9375rem;">← Back to Overview</a>
          </div>
          <div style="display: flex; align-items: center; gap: 1rem;">
            <span style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: #000080; color: white; border-radius: 50%; font-weight: bold; font-size: 1.25rem; flex-shrink: 0;">5</span>
            <h1 class="content-block__title" style="margin: 0;">Module 5: Prechunking Application</h1>
          </div>
        </div>
        <div class="content-block__body">
          <p><strong>What You Will Learn</strong></p>
          <p>How to apply the full prechunking workflow to real content systems.</p>
          <p><strong>Full Prechunking Workflow:</strong> This module synthesizes Modules 1-4 into the complete workflow:</p>
          <ol>
            <li><strong>Intent Decomposition</strong> (Module 4): Break user needs into discrete questions</li>
            <li><strong>Crouton Inventory</strong> (Module 4): Map intents to required atomic facts</li>
            <li><strong>Data Shaping</strong> (Module 3): Transform narrative into declarative croutons</li>
            <li><strong>Structured Publishing</strong> (this module): Organize croutons preserving chunk boundaries</li>
            <li><strong>Retrieval Validation</strong> (Module 6): Test whether croutons are actually retrieved</li>
          </ol>
          <p><strong>Prechunking happens at publishing time:</strong> We shape content BEFORE AI systems extract it. This is why it's called "prechunking" - we chunk content in advance, not after extraction.</p>
          
          <p><strong>Skill You Are Training</strong></p>
          <p>Complete prechunking workflow: intent decomposition, crouton inventory, data shaping, structured publishing with chunk boundary planning.</p>
          
          <p><strong>Exercise</strong></p>
          <ol>
            <li>Decompose intent for a real page (what questions does it answer?)</li>
            <li>Create crouton inventory (what facts are required?)</li>
            <li>Audit the page for non-compliant chunks</li>
            <li>Refactor content into valid croutons (data shaping)</li>
            <li>Plan chunk boundaries (which croutons belong together?)</li>
            <li>Create structured publishing plan</li>
            <li>Identify key facts that appear on other pages (redundant truth reinforcement)</li>
            <li>Ensure wording is consistent across page appearances</li>
            <li>Verify no contradictions across pages</li>
          </ol>

          <p><strong>Required Artifacts</strong></p>
          <ul>
            <li>Intent decomposition (primary query + follow-up questions)</li>
            <li>Crouton inventory (mapped to intents)</li>
            <li>Before and after comparison</li>
            <li>Chunk boundary plan (which croutons are grouped together)</li>
            <li>Structured publishing plan</li>
          </ul>

          <p><strong>Validation Criteria</strong></p>
          <p>You PASS if:</p>
          <ul>
            <li>All original narrative is removed</li>
            <li>New content passes isolation tests</li>
            <li>No regression risks are introduced</li>
            <li>Key facts appear in more than one location on the domain (or plan for cross-page reinforcement)</li>
            <li>Wording is consistent across appearances</li>
            <li>No contradictions across pages</li>
            <li>Reinforcement is factual, not persuasive</li>
          </ul>
          <p><strong>Academic Signal:</strong> Redundant Truth Reinforcement. Academic work shows repeated, consistent signals increase confidence and retrieval likelihood. This is reinforcement of truth, not preference manipulation.</p>

          <!-- Submission Form -->
          <div style="margin-top: 2rem; padding: 1.5rem; background: #f5f5f5; border: 2px solid #c0c0c0; border-radius: 4px;">
            <h3 style="margin-top: 0;">Submit Your Work</h3>
            <form id="module-5-form" onsubmit="validateModule5(event); return false;">
              <div style="margin-bottom: 1rem;">
                <label for="module-5-before" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Before (original content):</label>
                <textarea id="module-5-before" name="before" rows="8" style="width: 100%; padding: 0.75rem; border: 1px solid #808080; border-radius: 3px; font-family: monospace; font-size: 0.875rem;" required></textarea>
              </div>
              <div style="margin-bottom: 1rem;">
                <label for="module-5-after" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">After (refactored content):</label>
                <textarea id="module-5-after" name="after" rows="8" style="width: 100%; padding: 0.75rem; border: 1px solid #808080; border-radius: 3px; font-family: monospace; font-size: 0.875rem;" required></textarea>
              </div>
              <div style="margin-bottom: 1rem;">
                <label for="module-5-inventory" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Crouton inventory:</label>
                <textarea id="module-5-inventory" name="inventory" rows="6" style="width: 100%; padding: 0.75rem; border: 1px solid #808080; border-radius: 3px; font-family: monospace; font-size: 0.875rem;" required></textarea>
              </div>
              <div style="margin-bottom: 1rem;">
                <label for="module-5-intent" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Intent decomposition (primary query + follow-up questions):</label>
                <textarea id="module-5-intent" name="intent" rows="4" style="width: 100%; padding: 0.75rem; border: 1px solid #808080; border-radius: 3px; font-family: monospace; font-size: 0.875rem;" required></textarea>
              </div>
              <div style="margin-bottom: 1rem;">
                <label for="module-5-boundaries" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Chunk boundary plan (which croutons are grouped together):</label>
                <textarea id="module-5-boundaries" name="boundaries" rows="4" style="width: 100%; padding: 0.75rem; border: 1px solid #808080; border-radius: 3px; font-family: monospace; font-size: 0.875rem;" required></textarea>
              </div>
              <div style="margin-bottom: 1rem;">
                <label for="module-5-plan" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Structured publishing plan:</label>
                <textarea id="module-5-plan" name="plan" rows="4" style="width: 100%; padding: 0.75rem; border: 1px solid #808080; border-radius: 3px; font-family: monospace; font-size: 0.875rem;" required></textarea>
              </div>
              <button type="submit" style="padding: 0.75rem 1.5rem; background: #000080; color: white; border: none; border-radius: 3px; font-weight: bold; cursor: pointer;">Submit for Validation</button>
            </form>
            <div id="module-5-feedback" style="margin-top: 1rem; display: none;"></div>
          </div>

          <!-- Navigation -->
          <div style="margin-top: 3rem; padding-top: 2rem; border-top: 2px solid #e0e0e0; display: flex; justify-content: space-between;">
            <div>
              <a href="?module=4" onclick="navigateToModule(4); return false;" style="display: inline-block; padding: 0.75rem 1.5rem; color: #000080; text-decoration: none; font-weight: bold;">← Previous: Module 4</a>
            </div>
            <div id="module-5-next" style="display: none;">
              <a href="?module=6" onclick="navigateToModule(6); return false;" style="display: inline-block; padding: 0.75rem 1.5rem; background: #000080; color: white; text-decoration: none; border-radius: 3px; font-weight: bold;">Next: Module 6 →</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- MODULE 6 PAGE -->
    <div id="module-page-6" class="course-page module-page" style="display: <?= $currentModule === 6 ? 'block' : 'none' ?>;">
      <div class="content-block module">
        <div class="content-block__header">
          <div style="margin-bottom: 1rem;">
            <a href="?module=0" onclick="navigateToModule(0); return false;" style="color: #000080; text-decoration: none; font-weight: bold; font-size: 0.9375rem;">← Back to Overview</a>
          </div>
          <div style="display: flex; align-items: center; gap: 1rem;">
            <span style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: #000080; color: white; border-radius: 50%; font-weight: bold; font-size: 1.25rem; flex-shrink: 0;">6</span>
            <h1 class="content-block__title" style="margin: 0;">Module 6: Validation and Iteration</h1>
          </div>
        </div>
        <div class="content-block__body">
          <p><strong>What You Will Learn</strong></p>
          <p>How to verify retrieval success and diagnose failures.</p>
          <p><strong>Retrieval vs Ranking:</strong> This validates the retrieval layer, not the ranking layer. A page can rank first but have zero facts retrieved if chunks are ambiguous. Prechunking ensures facts are available for retrieval, regardless of page ranking.</p>
          <p><strong>Iteration Loop:</strong> Failed validation requires returning to earlier workflow steps. Missing croutons → return to Module 4 (precog modeling). Ambiguous chunks → return to Module 3 (data shaping). Poor chunk boundaries → return to Module 5 (structured publishing).</p>
          
          <p><strong>Skill You Are Training</strong></p>
          <p>Retrieval validation, citation tracking, chunk boundary validation, and iteration loops back to data shaping.</p>
          
          <p><strong>Exercise</strong></p>
          <ol>
            <li>Query an AI system using your topic</li>
            <li>Capture the generated answer</li>
            <li>Identify which of your croutons appeared (citation tracking)</li>
            <li>Check chunk boundaries (were related facts retrieved together?)</li>
            <li>Identify missing croutons and diagnose why they weren't retrieved</li>
            <li>If competitors were cited instead, analyze why their chunks were clearer</li>
            <li>Check citation-readiness: Are assertions factual (not promotional)? No guarantees or exaggerated claims? Safe for summarization?</li>
            <li>Verify AI classification: Can page intent be stated in one sentence? Do meta title and description reflect same intent? No conflicting cues?</li>
          </ol>

          <p><strong>Required Artifacts</strong></p>
          <ul>
            <li>AI response</li>
            <li>Highlighted croutons</li>
            <li>Failure analysis if any are missing</li>
          </ul>

          <p><strong>Validation Criteria</strong></p>
          <p>You PASS if:</p>
          <ul>
            <li>Croutons appear verbatim or near-verbatim</li>
            <li>Missing croutons are correctly diagnosed</li>
            <li>Assertions are factual (not promotional)</li>
            <li>No guarantees or exaggerated claims in citation-eligible text</li>
            <li>Clear scope (who, what, where) in all assertions</li>
            <li>Safe for summarization without caveats</li>
            <li>Page intent can be stated in one sentence</li>
            <li>Meta title and description reflect same intent</li>
            <li>No conflicting cues (service vs education vs training)</li>
            <li>Headers align with content purpose</li>
          </ul>
          <p><strong>Academic Signals:</strong></p>
          <ul>
            <li><strong>Citation-Ready Assertion Design:</strong> LLMs avoid citing text that appears risky or promotional.</li>
            <li><strong>AI Classification Safety:</strong> If the page could be misclassified, it reduces retrieval likelihood.</li>
          </ul>

          <!-- Submission Form -->
          <div style="margin-top: 2rem; padding: 1.5rem; background: #f5f5f5; border: 2px solid #c0c0c0; border-radius: 4px;">
            <h3 style="margin-top: 0;">Submit Your Work</h3>
            <form id="module-6-form" onsubmit="validateModule6(event); return false;">
              <div style="margin-bottom: 1rem;">
                <label for="module-6-query" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Query you used:</label>
                <input type="text" id="module-6-query" name="query" style="width: 100%; padding: 0.75rem; border: 1px solid #808080; border-radius: 3px;" required>
              </div>
              <div style="margin-bottom: 1rem;">
                <label for="module-6-response" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">AI response:</label>
                <textarea id="module-6-response" name="response" rows="8" style="width: 100%; padding: 0.75rem; border: 1px solid #808080; border-radius: 3px; font-family: monospace; font-size: 0.875rem;" required></textarea>
              </div>
              <div style="margin-bottom: 1rem;">
                <label for="module-6-croutons" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Highlighted croutons that appeared:</label>
                <textarea id="module-6-croutons" name="croutons" rows="6" style="width: 100%; padding: 0.75rem; border: 1px solid #808080; border-radius: 3px; font-family: monospace; font-size: 0.875rem;" required></textarea>
              </div>
              <div style="margin-bottom: 1rem;">
                <label for="module-6-boundaries" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Chunk boundary validation (were related facts retrieved together?):</label>
                <textarea id="module-6-boundaries" name="boundaries" rows="3" style="width: 100%; padding: 0.75rem; border: 1px solid #808080; border-radius: 3px; font-family: monospace; font-size: 0.875rem;"></textarea>
              </div>
              <div style="margin-bottom: 1rem;">
                <label for="module-6-competitors" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Competitive analysis (if competitors were cited, why were their chunks clearer?):</label>
                <textarea id="module-6-competitors" name="competitors" rows="3" style="width: 100%; padding: 0.75rem; border: 1px solid #808080; border-radius: 3px; font-family: monospace; font-size: 0.875rem;"></textarea>
              </div>
              <div style="margin-bottom: 1rem;">
                <label for="module-6-analysis" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Failure analysis and iteration plan (which workflow step needs revision?):</label>
                <textarea id="module-6-analysis" name="analysis" rows="4" style="width: 100%; padding: 0.75rem; border: 1px solid #808080; border-radius: 3px; font-family: monospace; font-size: 0.875rem;"></textarea>
              </div>
              <button type="submit" style="padding: 0.75rem 1.5rem; background: #000080; color: white; border: none; border-radius: 3px; font-weight: bold; cursor: pointer;">Submit for Validation</button>
            </form>
            <div id="module-6-feedback" style="margin-top: 1rem; display: none;"></div>
          </div>

          <!-- Navigation -->
          <div style="margin-top: 3rem; padding-top: 2rem; border-top: 2px solid #e0e0e0; display: flex; justify-content: space-between;">
            <div>
              <a href="?module=5" onclick="navigateToModule(5); return false;" style="display: inline-block; padding: 0.75rem 1.5rem; color: #000080; text-decoration: none; font-weight: bold;">← Previous: Module 5</a>
            </div>
            <div id="module-6-next" style="display: none;">
              <a href="?module=0" onclick="navigateToModule(0); return false;" style="display: inline-block; padding: 0.75rem 1.5rem; background: #28a745; color: white; text-decoration: none; border-radius: 3px; font-weight: bold;">View Certificate →</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Certification Page (shown when all modules complete) -->
    <div id="certification-page" class="course-page" style="display: none;">
      <div class="content-block module" style="background: #d4edda; border: 2px solid #28a745; padding: 2rem; border-radius: 4px;">
        <div class="content-block__header">
          <h1 class="content-block__title" style="color: #155724;">🎓 Course Completion Certificate</h1>
        </div>
        <div class="content-block__body">
          <p style="font-size: 1.25rem; margin-bottom: 2rem;">Congratulations! You have completed all 6 modules of the Prechunking SEO Operator Training course.</p>
          
          <div style="border: 4px solid #000080; padding: 3rem; background: white; max-width: 800px; margin: 2rem auto;">
            <h2 style="text-align: center; color: #000080; font-size: 2.5rem; margin-bottom: 1rem;">Certificate of Completion</h2>
            <p style="text-align: center; font-size: 1.25rem; margin-bottom: 2rem;">Prechunking SEO Operator Training</p>
            <p style="text-align: center; font-size: 1.125rem; margin-bottom: 3rem;">This certifies that the operator has successfully completed all 6 modules and demonstrated competency in:</p>
            <ul style="font-size: 1rem; line-height: 2; margin-bottom: 3rem;">
              <li>Chunk extraction and identification</li>
              <li>Crouton writing and atomicity validation</li>
              <li>Data shaping and declarative refactoring</li>
              <li>Precog modeling and intent forecasting</li>
              <li>Prechunking application to real content systems</li>
              <li>Validation and iteration loops</li>
            </ul>
            <p style="text-align: center; font-size: 0.875rem; color: #666;">Issued: <span id="cert-date"></span></p>
            <p style="text-align: center; font-size: 0.875rem; color: #666;">NRLC.ai Training Program</p>
          </div>
          
          <div style="text-align: center; margin-top: 2rem;">
            <button onclick="window.print()" style="padding: 1rem 2rem; background: #000080; color: white; border: none; border-radius: 4px; font-weight: bold; font-size: 1.125rem; cursor: pointer; margin-right: 1rem;">Print Certificate</button>
            <a href="?module=0" onclick="navigateToModule(0); return false;" style="display: inline-block; padding: 1rem 2rem; background: #6c757d; color: white; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 1.125rem;">Back to Course Overview</a>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>
</main>

<script>
// Course State Management
const COURSE_STORAGE_KEY = 'prechunking-course-state';
const modules = <?= json_encode($modules) ?>;

function getCourseState() {
  const stored = localStorage.getItem(COURSE_STORAGE_KEY);
  if (stored) {
    return JSON.parse(stored);
  }
  return {
    completed: [],
    submissions: {},
    locked: [2, 3, 4, 5, 6]
  };
}

function saveCourseState(state) {
  localStorage.setItem(COURSE_STORAGE_KEY, JSON.stringify(state));
}

function navigateToModule(moduleNum) {
  // Hide all pages
  document.querySelectorAll('.course-page').forEach(page => {
    page.style.display = 'none';
  });
  
  if (moduleNum === 0) {
    // Show overview
    document.getElementById('course-overview').style.display = 'block';
    window.history.pushState({module: 0}, '', '?module=0');
    updateProgress();
  } else {
    const state = getCourseState();
    
    // Check if module is locked
    if (state.locked.includes(moduleNum)) {
      alert('Module ' + moduleNum + ' is locked. Complete Module ' + (moduleNum - 1) + ' first.');
      navigateToModule(moduleNum - 1);
      return;
    }
    
    // Show module page
    const modulePage = document.getElementById('module-page-' + moduleNum);
    if (modulePage) {
      modulePage.style.display = 'block';
      window.history.pushState({module: moduleNum}, '', '?module=' + moduleNum);
      
      // Scroll to top
      window.scrollTo(0, 0);
      
      // Show next button if completed
      if (state.completed.includes(moduleNum)) {
        const nextBtn = document.getElementById('module-' + moduleNum + '-next');
        if (nextBtn) {
          nextBtn.style.display = 'block';
        }
      }
    }
  }
}

function updateProgress() {
  const state = getCourseState();
  const completed = state.completed.length;
  const total = 6;
  const percentage = (completed / total) * 100;
  
  const progressBar = document.getElementById('course-progress-bar');
  const progressText = document.getElementById('course-progress-text');
  
  if (progressBar) {
    progressBar.style.width = percentage + '%';
  }
  
  if (progressText) {
    progressText.textContent = completed + ' of ' + total + ' modules completed';
  }
  
  // Update module status badges
  Object.keys(modules).forEach(numStr => {
    const num = parseInt(numStr, 10);
    const badge = document.querySelector(`[data-module="${num}"].module-status-badge`);
    const card = document.querySelector(`#catalog-module-${num}`);
    const actions = document.querySelector(`[data-module="${num}"].module-actions`);
    
    if (state.completed.includes(num)) {
      if (badge) {
        badge.textContent = 'Completed';
        badge.style.background = '#d4edda';
        badge.style.color = '#155724';
        badge.style.borderColor = '#28a745';
      }
      if (card) {
        card.style.borderColor = '#28a745';
      }
      if (actions) {
        actions.innerHTML = `<button onclick="navigateToModule(${num})" style="padding: 0.5rem 1rem; background: #6c757d; color: white; border: none; border-radius: 3px; font-weight: bold; cursor: pointer;">Review Module ${num}</button>`;
      }
    } else if (state.locked.includes(num)) {
      if (badge) {
        badge.textContent = 'Locked';
        badge.style.background = '#f8d7da';
        badge.style.color = '#721c24';
        badge.style.borderColor = '#dc3545';
      }
      if (card) {
        card.style.opacity = '0.6';
        card.style.borderColor = '#dc3545';
      }
      if (actions) {
        actions.innerHTML = `<button disabled style="padding: 0.5rem 1rem; background: #6c757d; color: white; border: none; border-radius: 3px; font-weight: bold; cursor: not-allowed; opacity: 0.6;">Complete Module ${num - 1} First</button>`;
      }
    } else {
      if (badge) {
        badge.textContent = 'Available';
        badge.style.background = '#d1ecf1';
        badge.style.color = '#0c5460';
        badge.style.borderColor = '#17a2b8';
      }
      if (actions) {
        actions.innerHTML = `<button onclick="navigateToModule(${num})" style="padding: 0.5rem 1rem; background: #000080; color: white; border: none; border-radius: 3px; font-weight: bold; cursor: pointer;">Start Module ${num}</button>`;
      }
    }
  });
  
  // Show certification page if all complete
  if (completed === total) {
    const certPage = document.getElementById('certification-page');
    if (certPage && window.location.search.includes('certificate')) {
      certPage.style.display = 'block';
      document.querySelectorAll('.course-page').forEach(page => {
        if (page.id !== 'certification-page') {
          page.style.display = 'none';
        }
      });
      const certDate = document.getElementById('cert-date');
      if (certDate) {
        certDate.textContent = new Date().toLocaleDateString();
      }
    }
  }
}

function completeModule(moduleNum, submission) {
  const state = getCourseState();
  
  if (!state.completed.includes(moduleNum)) {
    state.completed.push(moduleNum);
  }
  
  state.submissions[moduleNum] = {
    timestamp: new Date().toISOString(),
    data: submission
  };
  
  // Unlock next module
  const nextModule = moduleNum + 1;
  if (nextModule <= 6) {
    const index = state.locked.indexOf(nextModule);
    if (index > -1) {
      state.locked.splice(index, 1);
    }
  }
  
  saveCourseState(state);
  updateProgress();
  
  // Show next button
  const nextBtn = document.getElementById('module-' + moduleNum + '-next');
  if (nextBtn) {
    nextBtn.style.display = 'block';
  }
  
  // If all modules complete, show link to certificate
  if (state.completed.length === 6) {
    const module6Next = document.getElementById('module-6-next');
    if (module6Next) {
      module6Next.innerHTML = '<a href="?certificate=1" onclick="showCertificate(); return false;" style="display: inline-block; padding: 0.75rem 1.5rem; background: #28a745; color: white; text-decoration: none; border-radius: 3px; font-weight: bold;">View Certificate →</a>';
      module6Next.style.display = 'block';
    }
  }
}

function showCertificate() {
  navigateToModule(0);
  setTimeout(() => {
    document.querySelectorAll('.course-page').forEach(page => {
      page.style.display = 'none';
    });
    const certPage = document.getElementById('certification-page');
    if (certPage) {
      certPage.style.display = 'block';
      const certDate = document.getElementById('cert-date');
      if (certDate) {
        certDate.textContent = new Date().toLocaleDateString();
      }
      window.scrollTo(0, 0);
    }
  }, 100);
}

// Validation Functions
function validateModule1(event) {
  event.preventDefault();
  const artifact = document.getElementById('module-1-artifact').value.trim();
  const chunks = artifact.split('\n').filter(c => c.trim().length > 0);
  const feedback = document.getElementById('module-1-feedback');
  
  const errors = [];
  const checks = {
    hasPronouns: false,
    hasMultipleFacts: false,
    hasContext: false
  };
  
  chunks.forEach((chunk, idx) => {
    const lower = chunk.toLowerCase();
    
    const pronouns = /\b(i|we|you|he|she|it|they|this|that|these|those|it|its|their|them)\b/i;
    if (pronouns.test(chunk)) {
      checks.hasPronouns = true;
      errors.push(`Chunk ${idx + 1}: Contains pronouns: "${chunk.substring(0, 50)}..."`);
    }
    
    if ((chunk.match(/ and | or | but | as well as | in addition to /gi) || []).length > 0) {
      checks.hasMultipleFacts = true;
      errors.push(`Chunk ${idx + 1}: Contains multiple facts: "${chunk.substring(0, 50)}..."`);
    }
    
    const contextWords = /\b(this|that|these|those|the above|the following|as mentioned|as stated)\b/i;
    if (contextWords.test(chunk)) {
      checks.hasContext = true;
      errors.push(`Chunk ${idx + 1}: Depends on context: "${chunk.substring(0, 50)}..."`);
    }
  });
  
  const passed = errors.length === 0 && chunks.length >= 3;
  
  if (passed) {
    feedback.innerHTML = '<div style="padding: 1rem; background: #d4edda; border: 2px solid #28a745; border-radius: 4px; color: #155724;"><strong>✓ PASS</strong><p style="margin: 0.5rem 0 0 0;">All chunks passed validation. Module 1 complete!</p></div>';
    completeModule(1, { chunks });
    setTimeout(() => {
      alert('Module 1 complete! Module 2 is now unlocked.');
    }, 1000);
  } else {
    feedback.innerHTML = '<div style="padding: 1rem; background: #f8d7da; border: 2px solid #dc3545; border-radius: 4px; color: #721c24;"><strong>✗ FAIL</strong><ul style="margin: 0.5rem 0 0 0; padding-left: 1.5rem;">' + errors.map(e => '<li>' + e + '</li>').join('') + '</ul><p style="margin-top: 0.5rem; font-weight: bold;">Please fix these issues and resubmit.</p></div>';
  }
  
  feedback.style.display = 'block';
}

function validateModule2(event) {
  event.preventDefault();
  const artifact = document.getElementById('module-2-artifact').value.trim();
  const croutons = artifact.split('\n').filter(c => c.trim().length > 0);
  const feedback = document.getElementById('module-2-feedback');
  
  if (croutons.length !== 5) {
    feedback.innerHTML = '<div style="padding: 1rem; background: #f8d7da; border: 2px solid #dc3545; border-radius: 4px; color: #721c24;"><strong>✗ FAIL</strong><p>You must submit exactly 5 croutons. You submitted ' + croutons.length + '.</p></div>';
    feedback.style.display = 'block';
    return;
  }
  
  const errors = [];
  
  croutons.forEach((crouton, idx) => {
    if (/\b(and|or|but|as well as|in addition to)\b/i.test(crouton)) {
      errors.push(`Crouton ${idx + 1}: Contains conjunctions`);
    }
    
    if (/\b(i|we|you|he|she|it|they|this|that|these|those)\b/i.test(crouton)) {
      errors.push(`Crouton ${idx + 1}: Contains pronouns`);
    }
    
    if (!crouton.trim().endsWith('.')) {
      errors.push(`Crouton ${idx + 1}: Must be a declarative sentence ending with a period`);
    }
  });
  
  const passed = errors.length === 0;
  
  if (passed) {
    feedback.innerHTML = '<div style="padding: 1rem; background: #d4edda; border: 2px solid #28a745; border-radius: 4px; color: #155724;"><strong>✓ PASS</strong><p style="margin: 0.5rem 0 0 0;">All croutons passed validation. Module 2 complete!</p></div>';
    completeModule(2, { croutons });
    setTimeout(() => {
      alert('Module 2 complete! Module 3 is now unlocked.');
    }, 1000);
  } else {
    feedback.innerHTML = '<div style="padding: 1rem; background: #f8d7da; border: 2px solid #dc3545; border-radius: 4px; color: #721c24;"><strong>✗ FAIL</strong><ul style="margin: 0.5rem 0 0 0; padding-left: 1.5rem;">' + errors.map(e => '<li>' + e + '</li>').join('') + '</ul></div>';
  }
  
  feedback.style.display = 'block';
}

function validateModule3(event) {
  event.preventDefault();
  const artifact = document.getElementById('module-3-artifact').value.trim();
  const inventory = document.getElementById('module-3-inventory').value.trim();
  const feedback = document.getElementById('module-3-feedback');
  
  const errors = [];
  
  const narrativeWords = /\b(therefore|however|thus|hence|consequently|meanwhile|furthermore|moreover)\b/i;
  if (narrativeWords.test(artifact)) {
    errors.push('Content contains narrative connectors (therefore, however, etc.)');
  }
  
  const sentences = artifact.split(/[.!?]+/).filter(s => s.trim().length > 0);
  sentences.forEach((sent, idx) => {
    if (sent.trim().startsWith('?')) {
      errors.push(`Sentence ${idx + 1}: Questions are not declarative`);
    }
  });
  
  const passed = errors.length === 0 && artifact.length > 0 && inventory.length > 0;
  
  if (passed) {
    feedback.innerHTML = '<div style="padding: 1rem; background: #d4edda; border: 2px solid #28a745; border-radius: 4px; color: #155724;"><strong>✓ PASS</strong><p style="margin: 0.5rem 0 0 0;">Content passes validation. Module 3 complete!</p></div>';
    completeModule(3, { artifact, inventory });
    setTimeout(() => {
      alert('Module 3 complete! Module 4 is now unlocked.');
    }, 1000);
  } else {
    feedback.innerHTML = '<div style="padding: 1rem; background: #f8d7da; border: 2px solid #dc3545; border-radius: 4px; color: #721c24;"><strong>✗ FAIL</strong><ul style="margin: 0.5rem 0 0 0; padding-left: 1.5rem;">' + errors.map(e => '<li>' + e + '</li>').join('') + '</ul></div>';
  }
  
  feedback.style.display = 'block';
}

function validateModule4(event) {
  event.preventDefault();
  const primary = document.getElementById('module-4-primary').value.trim();
  const intent = document.getElementById('module-4-intent').value.trim();
  const dependency = document.getElementById('module-4-dependency').value.trim();
  const feedback = document.getElementById('module-4-feedback');
  
  const questions = intent.split('\n').filter(q => q.trim().length > 0);
  
  const errors = [];
  
  if (questions.length !== 5) {
    errors.push('You must provide exactly 5 follow-up questions');
  }
  
  if (!dependency.includes('crouton') && !dependency.includes('fact')) {
    errors.push('Dependency map must reference croutons or facts');
  }
  
  const passed = errors.length === 0 && primary.length > 0 && intent.length > 0 && dependency.length > 0;
  
  if (passed) {
    feedback.innerHTML = '<div style="padding: 1rem; background: #d4edda; border: 2px solid #28a745; border-radius: 4px; color: #155724;"><strong>✓ PASS</strong><p style="margin: 0.5rem 0 0 0;">Precog model passes validation. Module 4 complete!</p></div>';
    completeModule(4, { primary, intent, dependency });
    setTimeout(() => {
      alert('Module 4 complete! Module 5 is now unlocked.');
    }, 1000);
  } else {
    feedback.innerHTML = '<div style="padding: 1rem; background: #f8d7da; border: 2px solid #dc3545; border-radius: 4px; color: #721c24;"><strong>✗ FAIL</strong><ul style="margin: 0.5rem 0 0 0; padding-left: 1.5rem;">' + errors.map(e => '<li>' + e + '</li>').join('') + '</ul></div>';
  }
  
  feedback.style.display = 'block';
}

function validateModule5(event) {
  event.preventDefault();
  const before = document.getElementById('module-5-before').value.trim();
  const after = document.getElementById('module-5-after').value.trim();
  const inventory = document.getElementById('module-5-inventory').value.trim();
  const intent = document.getElementById('module-5-intent').value.trim();
  const boundaries = document.getElementById('module-5-boundaries').value.trim();
  const plan = document.getElementById('module-5-plan').value.trim();
  const feedback = document.getElementById('module-5-feedback');
  
  const errors = [];
  
  const narrativeInBefore = (before.match(/\b(therefore|however|thus|meanwhile|furthermore|moreover)\b/gi) || []).length;
  const narrativeInAfter = (after.match(/\b(therefore|however|thus|meanwhile|furthermore|moreover)\b/gi) || []).length;
  
  if (narrativeInAfter >= narrativeInBefore) {
    errors.push('Narrative connectors must be removed from refactored content');
  }
  
  if (before === after) {
    errors.push('Refactored content must differ from original');
  }
  
  const passed = errors.length === 0 && before.length > 0 && after.length > 0 && inventory.length > 0 && intent.length > 0 && boundaries.length > 0 && plan.length > 0;
  
  if (passed) {
    feedback.innerHTML = '<div style="padding: 1rem; background: #d4edda; border: 2px solid #28a745; border-radius: 4px; color: #155724;"><strong>✓ PASS</strong><p style="margin: 0.5rem 0 0 0;">Prechunking application passes validation. Module 5 complete!</p></div>';
    completeModule(5, { before, after, inventory, intent, boundaries, plan });
    setTimeout(() => {
      alert('Module 5 complete! Module 6 is now unlocked.');
    }, 1000);
  } else {
    feedback.innerHTML = '<div style="padding: 1rem; background: #f8d7da; border: 2px solid #dc3545; border-radius: 4px; color: #721c24;"><strong>✗ FAIL</strong><ul style="margin: 0.5rem 0 0 0; padding-left: 1.5rem;">' + errors.map(e => '<li>' + e + '</li>').join('') + '</ul></div>';
  }
  
  feedback.style.display = 'block';
}

function validateModule6(event) {
  event.preventDefault();
  const query = document.getElementById('module-6-query').value.trim();
  const response = document.getElementById('module-6-response').value.trim();
  const croutons = document.getElementById('module-6-croutons').value.trim();
  const boundaries = document.getElementById('module-6-boundaries').value.trim();
  const competitors = document.getElementById('module-6-competitors').value.trim();
  const analysis = document.getElementById('module-6-analysis').value.trim();
  const feedback = document.getElementById('module-6-feedback');
  
  const errors = [];
  
  if (croutons.length === 0) {
    errors.push('You must identify which croutons appeared in the AI response');
  }
  
  if (query.length === 0 || response.length === 0) {
    errors.push('Query and AI response are required');
  }
  
  const passed = errors.length === 0;
  
  if (passed) {
    feedback.innerHTML = '<div style="padding: 1rem; background: #d4edda; border: 2px solid #28a745; border-radius: 4px; color: #155724;"><strong>✓ PASS</strong><p style="margin: 0.5rem 0 0 0;">Validation complete. Module 6 complete!</p></div>';
    completeModule(6, { query, response, croutons, boundaries, competitors, analysis });
    setTimeout(() => {
      alert('🎓 All modules complete! Redirecting to certificate...');
      showCertificate();
    }, 1000);
  } else {
    feedback.innerHTML = '<div style="padding: 1rem; background: #f8d7da; border: 2px solid #dc3545; border-radius: 4px; color: #721c24;"><strong>✗ FAIL</strong><ul style="margin: 0.5rem 0 0 0; padding-left: 1.5rem;">' + errors.map(e => '<li>' + e + '</li>').join('') + '</ul></div>';
  }
  
  feedback.style.display = 'block';
}

// Handle browser back/forward
window.addEventListener('popstate', function(event) {
  const module = event.state ? event.state.module : (new URLSearchParams(window.location.search).get('module') || 0);
  navigateToModule(parseInt(module, 10));
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
  const urlParams = new URLSearchParams(window.location.search);
  const module = urlParams.get('module');
  const cert = urlParams.get('certificate');
  
  if (cert) {
    showCertificate();
  } else if (module) {
    navigateToModule(parseInt(module, 10));
  } else {
    navigateToModule(0);
  }
  
  updateProgress();
});
</script>

<?php
// Course Schema (Google Structured Data)
// Creator attribution: Joel Maldonado (explicit creator field for intellectual work)
require_once __DIR__.'/../../../lib/SchemaFixes.php';
use NRLC\Schema\SchemaFixes;

$baseUrl = SchemaFixes::ensureHttps(absolute_url('/'));
$joelPersonId = $baseUrl . '#joel-maldonado';
$orgId = $baseUrl . '#neural-command';

// Initialize JSON-LD array if not already set
$GLOBALS['__jsonld'] = $GLOBALS['__jsonld'] ?? [];

// WebPage Schema
$GLOBALS['__jsonld'][] = [
  '@context' => 'https://schema.org',
  '@type' => 'WebPage',
  '@id' => $canonicalUrl . '#webpage',
  'url' => $canonicalUrl,
  'name' => 'Prechunking SEO Operator Training',
  'description' => 'Prechunking SEO operator training course. Hands-on, skills-based program with required tasks, artifacts, and validation criteria. Completion requires demonstrated ability.',
  'isPartOf' => ['@id' => absolute_url('/docs/prechunking-seo/') . '#collection'],
  'breadcrumb' => [
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
      [
        '@type' => 'ListItem',
        'position' => 1,
        'name' => 'Home',
        'item' => absolute_url('/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 2,
        'name' => 'Documentation',
        'item' => absolute_url('/docs/prechunking-seo/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 3,
        'name' => 'Course',
        'item' => $canonicalUrl
      ]
    ]
  ]
];

// Course Schema with explicit creator attribution
$GLOBALS['__jsonld'][] = [
  '@context' => 'https://schema.org',
  '@type' => 'Course',
  '@id' => $canonicalUrl . '#course',
  'name' => 'Prechunking SEO Operator Training',
  'description' => 'A skills-based operator training program for engineering AI-retrievable content through chunk-level information design.',
  'creator' => [
    '@type' => 'Person',
    '@id' => $joelPersonId,
    'name' => 'Joel Maldonado',
    'jobTitle' => 'Founder and AI Search Engineer',
    'affiliation' => [
      '@type' => 'Organization',
      '@id' => $orgId,
      'name' => 'Neural Command LLC',
      'url' => $baseUrl
    ]
  ],
  'provider' => [
    '@type' => 'Organization',
    '@id' => $orgId,
    'name' => 'Neural Command LLC',
    'url' => $baseUrl
  ],
  'url' => $canonicalUrl,
  'courseCode' => 'PRECHUNK-101',
  'educationalLevel' => 'Advanced',
  'teaches' => [
    'Prechunking SEO',
    'AI content retrieval engineering',
    'Chunk-based information architecture',
    'Crouton-based fact modeling',
    'Precognitive intent modeling'
  ],
  'numberOfCredits' => '6',
  'timeRequired' => 'PT6H',
  'inLanguage' => 'en',
  'hasCourseInstance' => [
    '@type' => 'CourseInstance',
    'courseMode' => 'online',
    'instructor' => [
      '@type' => 'Person',
      '@id' => $joelPersonId,
      'name' => 'Joel Maldonado'
    ]
  ]
];
?>
