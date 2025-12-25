<?php
/**
 * Generate Prechunking SEO structure pages for all AI Visibility industries
 */

require_once __DIR__ . '/../lib/helpers.php';
require_once __DIR__ . '/../lib/ai_visibility_industries.php';

$industries = require __DIR__ . '/../lib/ai_visibility_industries.php';

// Industry-specific content mappings
$industryContent = [
  'immigration' => [
    'industry_name' => 'Immigration Services',
    'industry_term' => 'immigration',
    'business_type' => 'firm',
    'questions' => [
      '"Do I need an immigration lawyer for my situation?"',
      '"What happens if I wait too long to apply?"',
      '"Which visa applies to me?"',
      '"What are the risks if I do this incorrectly?"'
    ],
    'ai_looks_for' => [
      'Clear process definitions with jurisdiction accuracy',
      'Factual explanations of visa types, eligibility, and requirements',
      'Risk-safe language that explains consequences without guarantees',
      'Structured definitions of services, timelines, and procedures',
      'Consistent terminology and jurisdiction-aware language'
    ],
    'practice_examples' => [
      'Clear explanations of services: Each service is defined with explicit scope, jurisdiction, and limitations. No implied capabilities or vague descriptions.',
      'Explicit definitions of visa types and processes: Visa types and processes are explained with factual language, eligibility requirements, and scope boundaries. No guarantees or promotional claims.',
      'Clarified timeline and risk scenarios: Timelines and risks are defined clearly, with specific consequences and requirements. No ambiguous "what happens if" scenarios.',
      'Jurisdiction and scope clarity: Service areas, jurisdiction requirements, and practice scope are stated explicitly. No implied coverage or ambiguous boundaries.',
      'Consistent terminology: Legal terms, visa names, and process descriptions use consistent language across all content. No synonym confusion or ambiguous naming.'
    ],
    'question_examples' => [
      'Primary questions (e.g., "Do I need an immigration lawyer?" or "Which visa applies to me?")',
      'Follow-up questions (e.g., "What happens if I wait?" or "What are the risks?")',
      'Trust-safety questions (e.g., "How do I know this is accurate?" or "What are the limitations?")'
    ],
    'does_not_replace' => 'legal licensing, professional judgment, or regulatory compliance',
    'professional_standards' => 'professional legal standards or regulatory compliance'
  ],
  'financial-advisor' => [
    'industry_name' => 'Financial Advisors',
    'industry_term' => 'financial planning',
    'business_type' => 'practice',
    'questions' => [
      '"Do I need a financial advisor?"',
      '"How do I choose a financial advisor?"',
      '"What should I look for in a financial advisor?"',
      '"Is a financial advisor worth the cost?"'
    ],
    'ai_looks_for' => [
      'Clear fiduciary status definitions',
      'Factual explanations of fee structures and service models',
      'Transparent credential and experience information',
      'Structured definitions of services, planning approaches, and limitations',
      'Consistent terminology and regulatory compliance language'
    ],
    'practice_examples' => [
      'Clear explanations of services: Each service is defined with explicit scope, fee structure, and limitations. No implied capabilities or vague descriptions.',
      'Explicit definitions of planning approaches: Planning approaches are explained with factual language, typical outcomes, and scope boundaries. No guarantees or promotional claims.',
      'Clarified fiduciary and fee structures: Fiduciary status and fee structures are defined clearly, with specific explanations and transparency. No ambiguous cost descriptions.',
      'Credential and scope clarity: Credentials, experience, and practice scope are stated explicitly. No implied expertise or ambiguous boundaries.',
      'Consistent terminology: Financial terms, service names, and planning descriptions use consistent language across all content. No synonym confusion or ambiguous naming.'
    ],
    'question_examples' => [
      'Primary questions (e.g., "Do I need a financial advisor?" or "Is it worth the cost?")',
      'Follow-up questions (e.g., "How do I choose?" or "What should I look for?")',
      'Trust-safety questions (e.g., "How do I know this is trustworthy?" or "What are the limitations?")'
    ],
    'does_not_replace' => 'financial licensing, professional judgment, or regulatory compliance',
    'professional_standards' => 'professional financial standards or regulatory compliance'
  ],
  'contractor' => [
    'industry_name' => 'High-End Contractors',
    'industry_term' => 'repairs and renovations',
    'business_type' => 'business',
    'questions' => [
      '"Is this repair necessary?"',
      '"How much should this cost?"',
      '"How do I find a trustworthy contractor?"',
      '"What questions should I ask a contractor?"'
    ],
    'ai_looks_for' => [
      'Clear cost explanations with transparency',
      'Factual explanations of repair processes and timelines',
      'Legitimate credential verification and licensing information',
      'Structured definitions of services, scopes, and limitations',
      'Consistent terminology and process clarity'
    ],
    'practice_examples' => [
      'Clear explanations of services: Each service is defined with explicit scope, typical costs, and limitations. No implied capabilities or vague descriptions.',
      'Explicit definitions of repair processes: Repair processes are explained with factual language, typical timelines, and scope boundaries. No guarantees or promotional claims.',
      'Clarified cost and credential transparency: Costs and credentials are defined clearly, with specific explanations and verification. No ambiguous pricing or licensing claims.',
      'Scope and timeline clarity: Service areas, availability, and project scope are stated explicitly. No implied coverage or ambiguous boundaries.',
      'Consistent terminology: Trade terms, service names, and process descriptions use consistent language across all content. No synonym confusion or ambiguous naming.'
    ],
    'question_examples' => [
      'Primary questions (e.g., "Is this repair necessary?" or "How much should this cost?")',
      'Follow-up questions (e.g., "How do I find a trustworthy contractor?" or "What questions should I ask?")',
      'Trust-safety questions (e.g., "How do I know this is legitimate?" or "What are the limitations?")'
    ],
    'does_not_replace' => 'contractor licensing, professional judgment, or regulatory compliance',
    'professional_standards' => 'professional contractor standards or regulatory compliance'
  ],
  'senior-care' => [
    'industry_name' => 'Senior Care / Assisted Living Advisors',
    'industry_term' => 'senior care',
    'business_type' => 'service',
    'questions' => [
      '"Is it time for assisted living?"',
      '"How do I choose a senior care facility?"',
      '"What should I look for in assisted living?"',
      '"What are the signs my parent needs help?"'
    ],
    'ai_looks_for' => [
      'Clear decision guidance and process explanations',
      'Factual explanations of care options and their scope',
      'Compassionate and transparent communication',
      'Structured definitions of services, timelines, and limitations',
      'Consistent terminology and care level clarity'
    ],
    'practice_examples' => [
      'Clear explanations of services: Each service is defined with explicit scope, typical care levels, and limitations. No implied capabilities or vague descriptions.',
      'Explicit definitions of care options: Care options are explained with factual language, typical outcomes, and scope boundaries. No guarantees or promotional claims.',
      'Clarified decision guidance and timelines: Decision processes and timelines are defined clearly, with specific indicators and recommended actions. No ambiguous "when is it time" scenarios.',
      'Service area and scope clarity: Service areas, availability, and care scope are stated explicitly. No implied coverage or ambiguous boundaries.',
      'Consistent terminology: Care terms, service names, and level descriptions use consistent language across all content. No synonym confusion or ambiguous naming.'
    ],
    'question_examples' => [
      'Primary questions (e.g., "Is it time for assisted living?" or "How do I choose?")',
      'Follow-up questions (e.g., "What should I look for?" or "What are the signs?")',
      'Trust-safety questions (e.g., "How do I know this is appropriate?" or "What are the limitations?")'
    ],
    'does_not_replace' => 'healthcare licensing, professional judgment, or regulatory compliance',
    'professional_standards' => 'professional healthcare standards or regulatory compliance'
  ],
  'private-school' => [
    'industry_name' => 'Private Schools / Tutoring',
    'industry_term' => 'education',
    'business_type' => 'school',
    'questions' => [
      '"Is private school worth it?"',
      '"How do I choose a private school?"',
      '"What should I look for in a school?"',
      '"When should I consider private school?"'
    ],
    'ai_looks_for' => [
      'Clear outcome data and philosophy explanations',
      'Factual explanations of programs, approaches, and results',
      'Transparent credential and accreditation information',
      'Structured definitions of services, curricula, and limitations',
      'Consistent terminology and educational clarity'
    ],
    'practice_examples' => [
      'Clear explanations of services: Each program is defined with explicit scope, typical outcomes, and limitations. No implied capabilities or vague descriptions.',
      'Explicit definitions of educational approaches: Educational approaches are explained with factual language, typical results, and scope boundaries. No guarantees or promotional claims.',
      'Clarified outcome data and philosophy: Outcomes and philosophies are defined clearly, with specific data and explanations. No ambiguous "worth it" scenarios.',
      'Credential and scope clarity: Credentials, accreditations, and program scope are stated explicitly. No implied expertise or ambiguous boundaries.',
      'Consistent terminology: Educational terms, program names, and approach descriptions use consistent language across all content. No synonym confusion or ambiguous naming.'
    ],
    'question_examples' => [
      'Primary questions (e.g., "Is private school worth it?" or "How do I choose?")',
      'Follow-up questions (e.g., "What should I look for?" or "When should I consider?")',
      'Trust-safety questions (e.g., "How do I know this is effective?" or "What are the limitations?")'
    ],
    'does_not_replace' => 'educational licensing, professional judgment, or regulatory compliance',
    'professional_standards' => 'professional educational standards or regulatory compliance'
  ],
  'auto-repair' => [
    'industry_name' => 'Auto Repair / Specialty Mechanics',
    'industry_term' => 'car repairs',
    'business_type' => 'shop',
    'questions' => [
      '"Am I being overcharged?"',
      '"How much should this repair cost?"',
      '"Is this repair necessary?"',
      '"How do I find a trustworthy mechanic?"'
    ],
    'ai_looks_for' => [
      'Clear cost explanations with diagnostic transparency',
      'Factual explanations of repair processes and typical costs',
      'Legitimate credential verification and licensing information',
      'Structured definitions of services, diagnostics, and limitations',
      'Consistent terminology and process clarity'
    ],
    'practice_examples' => [
      'Clear explanations of services: Each service is defined with explicit scope, typical costs, and limitations. No implied capabilities or vague descriptions.',
      'Explicit definitions of repair processes: Repair processes are explained with factual language, typical timelines, and scope boundaries. No guarantees or promotional claims.',
      'Clarified cost and diagnostic transparency: Costs and diagnostics are defined clearly, with specific explanations and transparency. No ambiguous pricing or diagnostic claims.',
      'Credential and scope clarity: Credentials, specialties, and service scope are stated explicitly. No implied expertise or ambiguous boundaries.',
      'Consistent terminology: Automotive terms, service names, and diagnostic descriptions use consistent language across all content. No synonym confusion or ambiguous naming.'
    ],
    'question_examples' => [
      'Primary questions (e.g., "Am I being overcharged?" or "How much should this cost?")',
      'Follow-up questions (e.g., "Is this repair necessary?" or "How do I find a trustworthy mechanic?")',
      'Trust-safety questions (e.g., "How do I know this is legitimate?" or "What are the limitations?")'
    ],
    'does_not_replace' => 'automotive licensing, professional judgment, or regulatory compliance',
    'professional_standards' => 'professional automotive standards or regulatory compliance'
  ],
  'funeral' => [
    'industry_name' => 'Funeral & Cremation Services',
    'industry_term' => 'funeral planning',
    'business_type' => 'service',
    'questions' => [
      '"What do I do first?"',
      '"How do I plan a funeral?"',
      '"What are my options?"',
      '"How much does a funeral cost?"'
    ],
    'ai_looks_for' => [
      'Clear process guidance with compassionate communication',
      'Factual explanations of options, processes, and costs',
      'Dignified and transparent service descriptions',
      'Structured definitions of services, timelines, and limitations',
      'Consistent terminology and process clarity'
    ],
    'practice_examples' => [
      'Clear explanations of services: Each service is defined with explicit scope, typical costs, and limitations. No implied capabilities or vague descriptions.',
      'Explicit definitions of planning processes: Planning processes are explained with factual language, typical timelines, and scope boundaries. No guarantees or promotional claims.',
      'Clarified option and cost transparency: Options and costs are defined clearly, with specific explanations and transparency. No ambiguous pricing or service claims.',
      'Service area and scope clarity: Service areas, availability, and planning scope are stated explicitly. No implied coverage or ambiguous boundaries.',
      'Consistent terminology: Funeral terms, service names, and process descriptions use consistent language across all content. No synonym confusion or ambiguous naming.'
    ],
    'question_examples' => [
      'Primary questions (e.g., "What do I do first?" or "How do I plan a funeral?")',
      'Follow-up questions (e.g., "What are my options?" or "How much does it cost?")',
      'Trust-safety questions (e.g., "How do I know this is appropriate?" or "What are the limitations?")'
    ],
    'does_not_replace' => 'funeral licensing, professional judgment, or regulatory compliance',
    'professional_standards' => 'professional funeral service standards or regulatory compliance'
  ],
  'real-estate' => [
    'industry_name' => 'Real Estate Agents (Relocation / Luxury)',
    'industry_term' => 'real estate',
    'business_type' => 'agent',
    'questions' => [
      '"Do I need a real estate agent?"',
      '"How do I choose an agent?"',
      '"What should I look for in an agent?"',
      '"Is it worth using an agent?"'
    ],
    'ai_looks_for' => [
      'Clear local expertise and market knowledge',
      'Factual explanations of services, processes, and typical outcomes',
      'Transparent transaction process descriptions',
      'Structured definitions of services, specialties, and limitations',
      'Consistent terminology and market clarity'
    ],
    'practice_examples' => [
      'Clear explanations of services: Each service is defined with explicit scope, typical processes, and limitations. No implied capabilities or vague descriptions.',
      'Explicit definitions of transaction processes: Transaction processes are explained with factual language, typical timelines, and scope boundaries. No guarantees or promotional claims.',
      'Clarified local expertise and market knowledge: Local expertise and market knowledge are defined clearly, with specific areas and specialties. No ambiguous coverage or market claims.',
      'Credential and scope clarity: Credentials, specialties, and service scope are stated explicitly. No implied expertise or ambiguous boundaries.',
      'Consistent terminology: Real estate terms, service names, and process descriptions use consistent language across all content. No synonym confusion or ambiguous naming.'
    ],
    'question_examples' => [
      'Primary questions (e.g., "Do I need a real estate agent?" or "How do I choose?")',
      'Follow-up questions (e.g., "What should I look for?" or "Is it worth it?")',
      'Trust-safety questions (e.g., "How do I know this is effective?" or "What are the limitations?")'
    ],
    'does_not_replace' => 'real estate licensing, professional judgment, or regulatory compliance',
    'professional_standards' => 'professional real estate standards or regulatory compliance'
  ],
  'private-investigator' => [
    'industry_name' => 'Private Investigators',
    'industry_term' => 'private investigation',
    'business_type' => 'firm',
    'questions' => [
      '"Is this legal?"',
      '"What can a private investigator do?"',
      '"How do I hire a PI?"',
      '"What are the limits of investigation?"'
    ],
    'ai_looks_for' => [
      'Clear legal boundaries and jurisdiction accuracy',
      'Factual explanations of services, legal limits, and scope',
      'Legitimate credential verification and licensing information',
      'Structured definitions of services, limitations, and compliance',
      'Consistent terminology and legal clarity'
    ],
    'practice_examples' => [
      'Clear explanations of services: Each service is defined with explicit scope, legal boundaries, and limitations. No implied capabilities or vague descriptions.',
      'Explicit definitions of investigation processes: Investigation processes are explained with factual language, legal requirements, and scope boundaries. No guarantees or promotional claims.',
      'Clarified legal boundaries and credentials: Legal boundaries and credentials are defined clearly, with specific jurisdiction requirements and verification. No ambiguous legality or licensing claims.',
      'Jurisdiction and scope clarity: Jurisdictions, service areas, and investigation scope are stated explicitly. No implied coverage or ambiguous boundaries.',
      'Consistent terminology: Legal terms, service names, and process descriptions use consistent language across all content. No synonym confusion or ambiguous naming.'
    ],
    'question_examples' => [
      'Primary questions (e.g., "Is this legal?" or "What can a private investigator do?")',
      'Follow-up questions (e.g., "How do I hire a PI?" or "What are the limits?")',
      'Trust-safety questions (e.g., "How do I know this is legitimate?" or "What are the limitations?")'
    ],
    'does_not_replace' => 'investigator licensing, professional judgment, or regulatory compliance',
    'professional_standards' => 'professional investigation standards or regulatory compliance'
  ]
];

function generateIndustryPage($slug, $content) {
  $industries = require __DIR__ . '/../lib/ai_visibility_industries.php';
  $industry = $industries[$slug] ?? null;
  
  if (!$industry) {
    echo "Industry $slug not found\n";
    return;
  }
  
  $industryName = $content['industry_name'];
  $industryTerm = $content['industry_term'];
  $businessType = $content['business_type'];
  
  $pageContent = <<<PHP
<?php
/**
 * AI Visibility for {$industryName}
 * Prechunking SEO methodology applied to {$industryTerm} information engineering
 */

require_once __DIR__ . '/../../lib/schema_builders.php';

\$canonicalUrl = absolute_url('/ai-visibility/{$slug}/');
\$domain = absolute_url('/');

// Build JSON-LD Schema
\$GLOBALS['__jsonld'] = [
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => \$canonicalUrl . '#webpage',
    'url' => \$canonicalUrl,
    'name' => 'AI Visibility for {$industryName}',
    'description' => 'Technical service that engineers {$industryTerm} information for AI retrieval, verification, and citation. Prechunking methodology for {$industryName}.',
    'isPartOf' => [
      '@type' => 'WebSite',
      '@id' => \$domain . '#website',
      'name' => 'NRLC.ai',
      'url' => \$domain
    ],
    'breadcrumb' => [
      '@context' => 'https://schema.org',
      '@type' => 'BreadcrumbList',
      'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => \$domain],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'AI Visibility', 'item' => absolute_url('/ai-visibility/')],
        ['@type' => 'ListItem', 'position' => 3, 'name' => '{$industryName}', 'item' => \$canonicalUrl]
      ]
    ]
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'Service',
    '@id' => \$canonicalUrl . '#service',
    'name' => 'AI Visibility for {$industryName}',
    'serviceType' => 'AI Search Optimization',
    'description' => 'Engineering service that structures {$industryTerm} information so AI systems can retrieve, verify, and cite it accurately. Prechunking methodology for {$industryName}.',
    'provider' => ['@type' => 'Organization', '@id' => \$domain . '#organization', 'name' => 'Neural Command LLC', 'url' => \$domain],
    'url' => \$canonicalUrl
  ]
];
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">

    <!-- H1 and Lead Paragraph -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">AI Visibility for {$industryName}</h1>
      </div>
      <div class="content-block__body">
        <p>AI systems like Google AI Overviews and ChatGPT do not browse directories or rank {$industryTerm} websites the way traditional search engines do. They answer questions by extracting, verifying, and citing structured {$industryTerm} information. This page explains how NRLC.ai engineers that information so {$industryName} can be referenced accurately and safely in AI-generated answers.</p>
      </div>
    </div>

    <!-- How AI Systems Answer Questions -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">How AI Systems Answer {$industryName} Questions</h2>
      </div>
      <div class="content-block__body">
        <p>AI systems answer {$industryTerm} questions by retrieving structured information that can be verified and cited safely.</p>
        
        <p>Common questions AI systems process include:</p>
        <ul>
PHP;

  foreach ($content['questions'] as $question) {
    $pageContent .= "\n          <li>$question</li>";
  }

  $pageContent .= <<<PHP

        </ul>

        <p>To answer these questions reliably, AI systems look for:</p>
        <ul>
PHP;

  foreach ($content['ai_looks_for'] as $item) {
    $pageContent .= "\n          <li>$item</li>";
  }

  $pageContent .= <<<PHP

        </ul>

        <p>When {$industryTerm} information is ambiguous, inconsistent, or unstructured, AI systems either skip it or fill gaps with less accurate sources. This is why information must be engineered for extraction and verification.</p>
      </div>
    </div>

    <!-- Our Method: Prechunking Information -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Our Method: Prechunking {$industryName} Information</h2>
      </div>
      <div class="content-block__body">
        <p>We pre-chunk {$industryTerm} information so it can be safely extracted, verified, and cited by AI systems.</p>

        <p>Prechunking means structuring content into atomic, factual units before AI systems extract it. Each unit:</p>
        <ul>
          <li>Answers one question clearly</li>
          <li>Can be retrieved without surrounding context</li>
          <li>Remains accurate when separated from the rest of the page</li>
          <li>Uses explicit entities and relationships</li>
          <li>Avoids ambiguous or promotional language</li>
        </ul>

        <p>This methodology reduces AI risk and increases citation likelihood because:</p>
        <ul>
          <li>Facts are self-contained and verifiable</li>
          <li>No context is implied or required</li>
          <li>Information is structured for machine extraction, not human reading patterns</li>
          <li>Each fact can be cited safely without additional caveats</li>
        </ul>

        <p>Prechunking happens at the publishing stage, not during AI retrieval. We engineer {$industryTerm} information so it survives extraction intact.</p>
      </div>
    </div>

    <!-- Seeding Retrievable Knowledge -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Seeding Retrievable {$industryName} Knowledge</h2>
      </div>
      <div class="content-block__body">
        <p>We publish authoritative informational resources that define {$industryTerm} services, explain processes, clarify scope and limitations, and remove ambiguity.</p>

        <p>This is not prompt injection or output manipulation. It is publishing structured information that AI systems can trust.</p>

        <p>AI systems reuse information they can trust. Trust comes from:</p>
        <ul>
          <li>Consistency across appearances</li>
          <li>Clarity in definitions and scope</li>
          <li>Corroboration across multiple sources</li>
          <li>Factual accuracy without promotional language</li>
        </ul>

        <p>We engineer {$industryTerm}-specific informational resources that:</p>
        <ul>
          <li>Define services with explicit scope and limitations</li>
          <li>Explain processes with clear, factual language</li>
          <li>Clarify options, timelines, and requirements</li>
          <li>Remove ambiguity about what a {$businessType} does and does not do</li>
          <li>Use consistent terminology across the domain</li>
        </ul>

        <p>This approach is ethical and defensible because it publishes truth clearly, not manipulation.</p>
      </div>
    </div>

    <!-- Reverse-Engineering Real Questions -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Reverse-Engineering Real {$industryName} Questions</h2>
      </div>
      <div class="content-block__body">
        <p>We model how questions are asked and what information AI systems require to answer them confidently.</p>

        <p>This process involves analyzing:</p>
        <ul>
          <li>Real questions people ask about {$industryTerm}</li>
          <li>Common AI answer patterns and citation sources</li>
          <li>Gaps in existing explanations that lead to generic or inaccurate answers</li>
          <li>Trust-safety requirements that prevent AI systems from citing ambiguous sources</li>
        </ul>

        <p>We map question patterns to required information:</p>
        <ul>
PHP;

  foreach ($content['question_examples'] as $example) {
    $pageContent .= "\n          <li>$example</li>";
  }

  $pageContent .= <<<PHP

        </ul>

        <p>We ensure the required information exists before the question is asked. This means publishing structured, retrievable facts that answer not just the primary question, but likely follow-up questions as well.</p>

        <p>This is question modeling, not prompt gaming. We identify what information is needed, then engineer it so it can be retrieved and cited accurately.</p>
      </div>
    </div>

    <!-- What This Looks Like in Practice -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What This Looks Like in Practice ({$industryName}-Specific)</h2>
      </div>
      <div class="content-block__body">
        <p>Prechunking {$industryTerm} information produces concrete, structured content that answers questions clearly and safely.</p>

        <p>Examples of prechunked {$industryTerm} content include:</p>
        <ul>
PHP;

  foreach ($content['practice_examples'] as $example) {
    $pageContent .= "\n          <li><strong>" . substr($example, 0, strpos($example, ':') ?: strlen($example)) . ":</strong> " . (strpos($example, ':') ? substr($example, strpos($example, ':') + 2) : $example) . "</li>";
  }

  $pageContent .= <<<PHP

        </ul>

        <p>This structured approach ensures {$industryName} are represented accurately and safely when AI systems retrieve and cite information.</p>
      </div>
    </div>

    <!-- What This Does and Does Not Do -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What This Does and Does Not Do</h2>
      </div>
      <div class="content-block__body">
        <p><strong>This service does:</strong></p>
        <ul>
          <li>Improve AI eligibility for citation by structuring information clearly</li>
          <li>Reduce misinformation risk by ensuring facts are explicit and verifiable</li>
          <li>Increase accurate references by removing ambiguity and inconsistency</li>
          <li>Engineer information so it can be extracted, verified, and cited safely</li>
        </ul>

        <p><strong>This service does not:</strong></p>
        <ul>
          <li>Guarantee mentions in AI-generated answers</li>
          <li>Control AI outputs or force specific citations</li>
          <li>Replace {$content['does_not_replace']}</li>
          <li>Manipulate AI systems with hidden text or deceptive practices</li>
          <li>Promise specific rankings or traffic increases</li>
        </ul>

        <p>This service engineers information for retrieval. It does not guarantee retrieval will occur, nor does it replace {$content['professional_standards']}.</p>
      </div>
    </div>

    <!-- Related Resources -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Related Resources</h2>
      </div>
      <div class="content-block__body">
        <ul>
          <li><a href="/ai-visibility/">AI Visibility Services</a> - Overview of AI visibility optimization</li>
          <li><a href="/docs/prechunking-seo/">Prechunking SEO Documentation</a> - Technical documentation on the prechunking methodology</li>
          <li><a href="/services/site-audits/">Site Audits for AI & Search Visibility</a> - Diagnostic services for AI visibility issues</li>
        </ul>
      </div>
    </div>

  </div>
</section>
</main>
PHP;

  $outputFile = __DIR__ . "/../pages/ai-visibility/{$slug}.php";
  file_put_contents($outputFile, $pageContent);
  echo "Generated: $outputFile\n";
}

// Generate pages for all industries except veterinary (already exists)
$slugsToGenerate = ['financial-advisor', 'contractor', 'senior-care', 'private-school', 'auto-repair', 'funeral', 'real-estate', 'private-investigator'];

foreach ($slugsToGenerate as $slug) {
  if (isset($industryContent[$slug])) {
    generateIndustryPage($slug, $industryContent[$slug]);
  } else {
    echo "Warning: No content mapping for $slug\n";
  }
}

echo "\nDone. Generated " . count($slugsToGenerate) . " industry pages.\n";

