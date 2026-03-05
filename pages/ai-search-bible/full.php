<?php
declare(strict_types=1);

if (!function_exists('absolute_url')) {
  require_once __DIR__ . '/../../lib/helpers.php';
}
if (!function_exists('ld_organization')) {
  require_once __DIR__ . '/../../lib/schema_builders.php';
}
require_once __DIR__ . '/components.php';
require_once __DIR__ . '/../../lib/ai_search_bible_paywall.php';

$canonicalUrl = absolute_url('/ai-search-bible/full/');
$isUnlocked = (bool)($GLOBALS['__ai_search_bible_unlocked'] ?? false);
$isLoggedIn = (bool)($GLOBALS['__ai_search_bible_logged_in'] ?? false);
$priceLabel = (string)($GLOBALS['__ai_search_bible_price_label'] ?? ai_search_bible_paywall_config()['price_label']);
$buyButtonId = (string)($GLOBALS['__ai_search_bible_buy_button_id'] ?? ai_search_bible_paywall_config()['stripe_buy_button_id']);
$publishableKey = (string)($GLOBALS['__ai_search_bible_publishable_key'] ?? ai_search_bible_paywall_config()['stripe_publishable_key']);

$GLOBALS['__jsonld'] = [
  ld_organization(),
  [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    '@id' => $canonicalUrl . '#breadcrumb',
    'itemListElement' => [
      ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => absolute_url('/')],
      ['@type' => 'ListItem', 'position' => 2, 'name' => 'AI Search Bible', 'item' => absolute_url('/ai-search-bible/')],
      ['@type' => 'ListItem', 'position' => 3, 'name' => 'Full Document', 'item' => $canonicalUrl],
    ],
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonicalUrl,
    'name' => 'The AI Search Bible - Full',
    'url' => $canonicalUrl,
    'isAccessibleForFree' => false,
    'inLanguage' => 'en-US'
  ]
];
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">

      <div class="content-block module">
        <div class="content-block__header">
          <h1 class="content-block__title heading-1">The AI Search Bible</h1>
        </div>
        <div class="content-block__body">
          <p class="lead text-lg">Complete Technical Framework For AI Search Systems</p>
        </div>
      </div>

      <?php if (!$isUnlocked): ?>
        <div class="content-block module" style="background: var(--color-background-alt, #f7f9fc); border-left: 4px solid #12355e;">
          <div class="content-block__header">
            <h2 class="content-block__title heading-2">Unlock the Full AI Search Bible</h2>
          </div>
          <div class="content-block__body">
            <p>The complete technical framework explaining how AI search systems retrieve information - and how to engineer content that gets cited by ChatGPT, Gemini, Perplexity and AI Overviews.</p>

            <h3 class="heading-3">What You're About To Unlock</h3>
            <p>Inside the full AI Search Bible you'll get the complete Neural Command framework for AI visibility.</p>
            <ul>
              <li>Sonic classifier breakdown</li>
              <li>Prompt type routing system</li>
              <li>Fan-out retrieval architecture</li>
              <li>Reciprocal Rank Fusion ranking</li>
              <li>Query rewriting mechanics</li>
              <li>Entity graph optimization</li>
              <li>Croutonized knowledge structures</li>
              <li>Retrieval surface engineering</li>
              <li>Enterprise schema systems</li>
              <li>AI citation mechanics</li>
              <li>Fan-out coverage metrics</li>
              <li>Fan-Out Intelligence Engine blueprint</li>
            </ul>

            <h3 class="heading-3">What Makes This Different</h3>
            <p>Most SEO advice still focuses on ranking pages.</p>
            <p>AI search does not rank pages.</p>
            <p>It retrieves knowledge fragments.</p>
            <p>The AI Search Bible shows you: how to engineer knowledge so AI systems retrieve it.</p>

            <h3 class="heading-3">Who This Is For</h3>
            <ul>
              <li>SEO professionals</li>
              <li>AI search engineers</li>
              <li>founders building AI visibility</li>
              <li>knowledge platform developers</li>
              <li>growth teams</li>
            </ul>

            <h3 class="heading-3">Full Access</h3>
            <p><strong><?= htmlspecialchars($priceLabel) ?></strong></p>
            <p>Access includes:</p>
            <ul>
              <li>complete AI Search Bible</li>
              <li>downloadable crouton dataset</li>
              <li>framework diagrams</li>
              <li>developer specifications</li>
            </ul>

            <h3 class="heading-3">Bonus Included</h3>
            <p>When you unlock the AI Search Bible you also get:</p>
            <ul>
              <li>Fan-Out Query Dataset</li>
              <li>Crouton Knowledge Templates</li>
              <li>AI Retrieval Architecture Diagrams</li>
              <li>NDJSON Knowledge Streams</li>
            </ul>
            <p>These are the exact building blocks used inside the Neural Command platform.</p>

            <?php if (!$isLoggedIn): ?>
              <div class="btn-group" style="margin-top: var(--spacing-lg);">
                <a href="<?= htmlspecialchars(absolute_url('/login.php?redirect=' . urlencode('/ai-search-bible/full/'))) ?>" class="btn btn--primary">Log in to Purchase</a>
                <a href="<?= htmlspecialchars(absolute_url('/login.php?redirect=' . urlencode('/ai-search-bible/full/'))) ?>" class="btn btn--secondary">Already purchased? Log in</a>
              </div>
            <?php else: ?>
              <?php if ($buyButtonId !== '' && $publishableKey !== ''): ?>
                <script async src="https://js.stripe.com/v3/buy-button.js"></script>
                <stripe-buy-button
                  id="ai-search-bible-buy-button"
                  buy-button-id="<?= htmlspecialchars($buyButtonId) ?>"
                  publishable-key="<?= htmlspecialchars($publishableKey) ?>">
                </stripe-buy-button>
              <?php else: ?>
                <p>Stripe Buy Button is not configured. Set <code>STRIPE_BUY_BUTTON_ID</code> and <code>STRIPE_PUBLISHABLE_KEY</code>.</p>
              <?php endif; ?>
              <div class="btn-group" style="margin-top: var(--spacing-lg);">
                <button type="button" class="btn btn--secondary" id="check-access-btn">Already purchased? Check access</button>
                <a href="<?= htmlspecialchars(absolute_url('/login.php?redirect=' . urlencode('/ai-search-bible/full/'))) ?>" class="btn btn--secondary">Already purchased? Log in</a>
                <button type="button" class="btn btn--secondary" id="paid-still-locked-btn">I paid but it's still locked</button>
              </div>
              <p style="margin-top: .5rem;"><small>Use the same email at checkout as your account email.</small></p>
              <p style="margin-top: .5rem;"><small>Payment processing can take up to ~30 seconds to sync.</small></p>

              <div id="paid-still-locked-modal" style="display:none; margin-top: 1rem; border: 1px solid #dce3ef; border-radius: 6px; padding: 0.75rem; background: #fff;">
                <p><strong>Payment mismatch help</strong></p>
                <p>If checkout used a different email than your account email, unlock may fail on V1.</p>
                <p>Please contact support with your account email and Stripe receipt email for manual reconciliation.</p>
                <p><a href="mailto:info@neuralcommand.com?subject=AI%20Search%20Bible%20Unlock%20Issue">Contact support</a></p>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <div class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title heading-2">AI Search Bible Progress Teaser</h2>
          </div>
          <div class="content-block__body">
            <ol>
              <li>Chapter 1 - AI Search Architecture</li>
              <li>Chapter 2 - Sonic Classifier</li>
              <li>Chapter 3 - Prompt Routing</li>
              <li>Chapter 4 - Fan-Out Retrieval</li>
              <li>[LOCKED] Chapter 5 - Retrieval Providers</li>
              <li>[LOCKED] Chapter 6 - Rank Fusion</li>
              <li>[LOCKED] Chapter 7 - Croutonization</li>
            </ol>
          </div>
        </div>
      <?php else: ?>
        <?php ai_bible_render_tldr_block([
          'Search engines ranked pages; AI systems retrieve knowledge fragments.',
          'AI visibility is driven by fan-out coverage, retrieval clarity, and entity authority.',
          'Croutonization and retrieval surface engineering improve citation probability.'
        ]); ?>

        <div class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title heading-2">Table of Contents</h2>
          </div>
          <div class="content-block__body">
            <ol>
              <li><a href="#chapter-1-introduction">1 — Introduction</a></li>
              <li><a href="#chapter-2-sonic-classifier">2 — Sonic Classifier</a></li>
              <li><a href="#chapter-3-prompt-type-classification">3 — Prompt Type Classification</a></li>
              <li><a href="#chapter-4-fan-out-retrieval">4 — Fan-Out Retrieval</a></li>
              <li><a href="#chapter-5-reciprocal-rank-fusion">5 — Reciprocal Rank Fusion</a></li>
              <li><a href="#chapter-6-query-rewriting">6 — Query Rewriting</a></li>
              <li><a href="#chapter-7-retrieval-providers">7 — Retrieval Providers</a></li>
              <li><a href="#chapter-8-entity-anchoring">8 — Entity Anchoring</a></li>
              <li><a href="#chapter-9-the-croutonization-doctrine">9 — The Croutonization Doctrine</a></li>
              <li><a href="#chapter-10-retrieval-surface-engineering">10 — Retrieval Surface Engineering</a></li>
              <li><a href="#chapter-11-retrieval-probability-model">11 — Retrieval Probability Model</a></li>
              <li><a href="#chapter-12-the-real-ranking-metric">12 — The Real Ranking Metric</a></li>
              <li><a href="#chapter-13-retrieval-cost">13 — Retrieval Cost</a></li>
              <li><a href="#chapter-14-content-architecture">14 — Content Architecture</a></li>
              <li><a href="#chapter-15-enterprise-schema">15 — Enterprise Schema</a></li>
              <li><a href="#chapter-16-ndjson-knowledge-streams">16 — NDJSON Knowledge Streams</a></li>
              <li><a href="#chapter-17-measurement-metrics">17 — Measurement Metrics</a></li>
              <li><a href="#chapter-18-the-neural-command-platform">18 — The Neural Command Platform</a></li>
              <li><a href="#chapter-19-fan-out-intelligence-engine">19 — Fan-Out Intelligence Engine</a></li>
              <li><a href="#chapter-20-the-endgame">20 — The Endgame</a></li>
            </ol>
          </div>
        </div>

        <article class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title heading-2">AI SEARCH BIBLE</h2>
          </div>
          <div class="content-block__body">
            <p>The Neural Command Framework for AI Visibility</p>
            <p><strong>Author:</strong> Neural Command<br><strong>Version:</strong> 1.0<br><strong>System:</strong> NRLC / Croutons Platform</p>

            <h2 id="chapter-1-introduction" class="heading-2">1 — Introduction</h2>
            <p>Search engines ranked pages.</p>
            <p>AI systems retrieve knowledge.</p>
            <p>This shift fundamentally changes how information must be structured to be discoverable.</p>
            <p>Traditional search followed a simple pipeline:</p>
            <p>query<br>↓<br>index lookup<br>↓<br>ranking<br>↓<br>results</p>
            <p>AI search systems operate differently.</p>
            <p>They behave as retrieval orchestrators.</p>
            <p>prompt<br>↓<br>prompt classification<br>↓<br>fan-out query generation<br>↓<br>multi-provider retrieval<br>↓<br>rank fusion<br>↓<br>evidence synthesis<br>↓<br>AI answer</p>
            <p>Instead of returning a list of links, the system synthesizes knowledge.</p>
            <p>Understanding this architecture is the foundation of AI search optimization.</p>

            <h2 id="chapter-2-sonic-classifier" class="heading-2">2 — Sonic Classifier</h2>
            <p>Before any search occurs, the system determines whether it should search the web.</p>
            <p>This decision is made by an internal classifier.</p>
            <p>This classifier is known as Sonic.</p>
            <p>Its role is to determine:</p>
            <p>should the model search the web<br>or<br>answer from internal knowledge</p>
            <p>Example:</p>
            <p>Prompt:</p>
            <p>what is the capital of France</p>
            <p>Likely behavior:</p>
            <p>model answers from training data</p>
            <p>Example:</p>
            <p>Prompt:</p>
            <p>best CRM for startups</p>
            <p>Likely behavior:</p>
            <p>search triggered</p>
            <p>The classifier outputs a probability.</p>
            <p>Example internal logic:</p>
            <p>search_probability = 0.71<br>threshold = 0.65</p>
            <p>If probability exceeds threshold, web search is triggered.</p>
            <p>Implication:</p>
            <p>Content only has a chance to be retrieved if Sonic decides to search.</p>
            <p>Therefore, prompts that trigger search include:</p>
            <ul>
              <li>comparisons</li>
              <li>product research</li>
              <li>current events</li>
              <li>technical explanations</li>
              <li>dynamic information</li>
              <li>location queries</li>
            </ul>
            <p>This means AI visibility begins with prompt engineering and topic selection.</p>

            <h2 id="chapter-3-prompt-type-classification" class="heading-2">3 — Prompt Type Classification</h2>
            <p>After Sonic triggers search, the prompt is categorized.</p>
            <p>Prompt types include:</p>
            <ul>
              <li>informational</li>
              <li>comparison</li>
              <li>shopping</li>
              <li>local</li>
              <li>news</li>
              <li>technical</li>
              <li>visual</li>
            </ul>
            <p>Each prompt type routes to different retrieval providers.</p>
            <p>Example routing:</p>
            <p>shopping prompts -&gt; product databases<br>local prompts -&gt; maps / location data<br>news prompts -&gt; news providers<br>technical prompts -&gt; documentation</p>
            <p>Therefore, content should exist in multiple formats.</p>
            <p>Example formats:</p>
            <ul>
              <li>guides</li>
              <li>FAQs</li>
              <li>comparison pages</li>
              <li>tutorials</li>
              <li>datasets</li>
              <li>product pages</li>
            </ul>
            <p>This increases eligibility across prompt types.</p>

            <h2 id="chapter-4-fan-out-retrieval" class="heading-2">4 — Fan-Out Retrieval</h2>
            <p>AI systems rarely execute a single query.</p>
            <p>Instead they generate multiple search queries simultaneously.</p>
            <p>Example prompt:</p>
            <p>best CRM for small business</p>
            <p>Fan-out queries may include:</p>
            <p>best CRM for startups<br>top CRM software SMB<br>HubSpot vs Salesforce SMB<br>CRM pricing comparison<br>affordable CRM platforms</p>
            <p>Each query is executed independently.</p>
            <p>These queries may access different providers.</p>
            <p>Examples:</p>
            <ul>
              <li>web index</li>
              <li>product data</li>
              <li>knowledge graphs</li>
              <li>embeddings databases</li>
              <li>local data</li>
              <li>documentation sources</li>
            </ul>
            <p>This architecture dramatically changes optimization strategy.</p>
            <p>Traditional SEO:</p>
            <p>rank #1 for keyword</p>
            <p>AI search:</p>
            <p>appear across fan-out queries</p>

            <h2 id="chapter-5-reciprocal-rank-fusion" class="heading-2">5 — Reciprocal Rank Fusion</h2>
            <p>After retrieval, the system merges results.</p>
            <p>This merging process uses ranking fusion algorithms.</p>
            <p>One commonly referenced method is Reciprocal Rank Fusion (RRF).</p>
            <p>Conceptually:</p>
            <p>results from provider A<br>results from provider B<br>results from provider C</p>
            <p>These lists are merged to produce the final evidence set.</p>
            <p>The algorithm favors sources that appear consistently across multiple lists.</p>
            <p>Implication:</p>
            <p>Being moderately visible across many retrieval surfaces can outperform being dominant in only one.</p>

            <h2 id="chapter-6-query-rewriting" class="heading-2">6 — Query Rewriting</h2>
            <p>User prompts are rarely used verbatim.</p>
            <p>Instead they are rewritten internally.</p>
            <p>Example:</p>
            <p>User prompt:</p>
            <p>why am I tired all day</p>
            <p>Possible internal queries:</p>
            <p>chronic fatigue causes<br>vitamin deficiency fatigue<br>sleep disorder symptoms<br>low energy during day</p>
            <p>This means content must contain both:</p>
            <ul>
              <li>natural language</li>
              <li>technical terminology</li>
            </ul>
            <p>Otherwise the system cannot match it to rewritten queries.</p>

            <h2 id="chapter-7-retrieval-providers" class="heading-2">7 — Retrieval Providers</h2>
            <p>AI systems retrieve information from multiple providers.</p>
            <p>These include:</p>
            <ol>
              <li>web indexes</li>
              <li>product feeds</li>
              <li>documentation repositories</li>
              <li>knowledge graphs</li>
              <li>datasets</li>
              <li>embeddings stores</li>
              <li>local map providers</li>
              <li>image indexes</li>
            </ol>
            <p>Each provider represents a retrieval surface.</p>
            <p>Optimization requires presence across multiple surfaces.</p>

            <h2 id="chapter-8-entity-anchoring" class="heading-2">8 — Entity Anchoring</h2>
            <p>AI models rely heavily on entity graphs.</p>
            <p>An entity is a structured representation of a concept.</p>
            <p>Example entity:</p>
            <p>HubSpot<br>CRM company<br>Founded 2006</p>
            <p>Entities connect facts.</p>
            <p>If a brand does not exist as a clear entity, attribution becomes unreliable.</p>
            <p>Strong entity anchoring requires:</p>
            <ul>
              <li>consistent naming</li>
              <li>structured schema</li>
              <li>entity pages</li>
              <li>sameAs references</li>
              <li>external knowledge bases</li>
            </ul>

            <h2 id="chapter-9-the-croutonization-doctrine" class="heading-2">9 — The Croutonization Doctrine</h2>
            <p>Croutonization is the process of converting knowledge into atomic retrieval units.</p>
            <p>Each crouton contains a single factual idea.</p>
            <p>Structure:</p>
            <p>FACT<br>CONTEXT<br>APPLICATION<br>SOURCE</p>
            <p>Example:</p>
            <p>FACT<br>ChatGPT expands prompts into multiple search queries.</p>
            <p>CONTEXT<br>This process is known as fan-out retrieval.</p>
            <p>APPLICATION<br>Content should target multiple semantic query variations.</p>
            <p>Croutons reduce inference cost.</p>
            <p>Lower inference cost increases retrieval probability.</p>

            <h2 id="chapter-10-retrieval-surface-engineering" class="heading-2">10 — Retrieval Surface Engineering</h2>
            <p>Publishing knowledge once is insufficient.</p>
            <p>AI systems retrieve knowledge from multiple surfaces.</p>
            <p>Therefore knowledge should be distributed across surfaces.</p>
            <p>Example surfaces:</p>
            <ul>
              <li>website pages</li>
              <li>structured data</li>
              <li>NDJSON fact streams</li>
              <li>documentation repositories</li>
              <li>datasets</li>
              <li>APIs</li>
              <li>entity graphs</li>
            </ul>
            <p>Example distribution:</p>
            <p>Crouton<br>↓<br>page content<br>↓<br>FAQ answer<br>↓<br>JSON-LD node<br>↓<br>NDJSON record<br>↓<br>documentation snippet</p>
            <p>This dramatically increases the chance of retrieval.</p>

            <h2 id="chapter-11-retrieval-probability-model" class="heading-2">11 — Retrieval Probability Model</h2>
            <p>Citation probability can be approximated by:</p>
            <p>retrieval_probability =<br>fanout_coverage<br>x knowledge_clarity<br>x entity_authority<br>x retrieval_surface_count</p>
            <p>Each variable increases the likelihood of being selected as evidence.</p>

            <h2 id="chapter-12-the-real-ranking-metric" class="heading-2">12 — The Real Ranking Metric</h2>
            <p>Traditional SEO metrics:</p>
            <ul>
              <li>keyword ranking</li>
              <li>traffic</li>
              <li>click-through rate</li>
            </ul>
            <p>AI retrieval metric:</p>
            <p>fan-out coverage</p>
            <p>Definition:</p>
            <p>fan_out_coverage =<br>fan_out_queries_covered<br>divided by<br>total_queries_detected</p>
            <p>Example:</p>
            <p>fan-out queries: 20<br>your coverage: 8<br>coverage score: 40%</p>

            <h2 id="chapter-13-retrieval-cost" class="heading-2">13 — Retrieval Cost</h2>
            <p>AI systems prefer sources with low retrieval cost.</p>
            <p>Retrieval cost factors:</p>
            <ul>
              <li>clarity</li>
              <li>structure</li>
              <li>fact density</li>
              <li>schema</li>
              <li>entity resolution</li>
            </ul>
            <p>Example comparison:</p>
            <p>Page A:</p>
            <p>2000 word article<br>facts buried in paragraphs</p>
            <p>Page B:</p>
            <p>crouton facts<br>FAQ answers<br>structured headings<br>schema</p>
            <p>Page B is easier to extract from.</p>
            <p>Lower cost wins.</p>

            <h2 id="chapter-14-content-architecture" class="heading-2">14 — Content Architecture</h2>
            <p>Optimal AI-visible page structure:</p>
            <p>Hero Explanation<br>TLDR<br>Crouton Facts<br>Detailed Explanation<br>Operator Playbook<br>Measurement Section<br>FAQ<br>Entities<br>References<br>Schema<br>NDJSON Facts</p>

            <h2 id="chapter-15-enterprise-schema" class="heading-2">15 — Enterprise Schema</h2>
            <p>Recommended schema:</p>
            <p>Article<br>TechArticle<br>FAQPage<br>HowTo<br>BreadcrumbList<br>Organization<br>WebPage</p>
            <p>Schema supports entity clarity and machine readability.</p>

            <h2 id="chapter-16-ndjson-knowledge-streams" class="heading-2">16 — NDJSON Knowledge Streams</h2>
            <p>Each page should generate machine-readable facts.</p>
            <p>Example:</p>
            <p>{"fact":"ChatGPT expands prompts into fan-out queries","source":"Resoneo"}</p>
            <p>Purpose:</p>
            <ul>
              <li>machine ingestion</li>
              <li>dataset creation</li>
              <li>agent training</li>
            </ul>

            <h2 id="chapter-17-measurement-metrics" class="heading-2">17 — Measurement Metrics</h2>
            <p>Track:</p>
            <ul>
              <li>fan-out coverage</li>
              <li>AI citations</li>
              <li>entity mentions</li>
              <li>retrieval surfaces</li>
              <li>recency eligibility</li>
            </ul>

            <h2 id="chapter-18-the-neural-command-platform" class="heading-2">18 — The Neural Command Platform</h2>
            <p>The Neural Command stack implements this architecture.</p>
            <p>System layers:</p>
            <p>Prompt Intelligence<br>↓<br>Fan-Out Intelligence<br>↓<br>Crouton Knowledge Extraction<br>↓<br>Retrieval Surface Distribution<br>↓<br>Citation Monitoring<br>↓<br>Entity Authority Building</p>

            <h2 id="chapter-19-fan-out-intelligence-engine" class="heading-2">19 — Fan-Out Intelligence Engine</h2>
            <p>Inputs:</p>
            <p>topic<br>prompt cluster</p>
            <p>Outputs:</p>
            <p>fan-out queries<br>coverage analysis<br>citation tracking<br>content gaps</p>
            <p>Example:</p>
            <p>Prompt: best domain registrar</p>
            <p>fan-out queries: 23<br>NameSilo coverage: 6<br>GoDaddy coverage: 12<br>Cloudflare coverage: 4</p>

            <h2 id="chapter-20-the-endgame" class="heading-2">20 — The Endgame</h2>
            <p>Search engines rank pages.</p>
            <p>AI systems retrieve knowledge fragments.</p>
            <p>The companies that win will not publish the most pages.</p>
            <p>They will publish the most retrievable knowledge.</p>
            <p>This is the foundation of AI visibility.</p>
          </div>
        </article>

        <?php ai_bible_render_crouton_block(
          'ChatGPT and similar systems fan-out prompts into multiple retrieval queries.',
          'This behavior changes optimization from single-keyword rank to multi-query coverage.',
          'Build pages and schema that can be matched across rewritten variants.',
          'AI Search Bible / Neural Command framework'
        ); ?>

        <?php ai_bible_render_entities_glossary([
          ['term' => 'Fan-Out Coverage', 'definition' => 'Percentage of expanded AI queries your knowledge surfaces can satisfy.'],
          ['term' => 'Entity Authority', 'definition' => 'The consistency and trust strength of an entity across retrieval providers.'],
          ['term' => 'Crouton', 'definition' => 'An atomic retrieval unit with fact, context, application, and source.'],
        ]); ?>

        <?php ai_bible_render_references([
          'AI Search Bible v1.0 - Neural Command',
          'Schema.org vocabulary for WebPage, Organization, BreadcrumbList',
          'Internal retrieval experiments on fan-out query behavior and citation patterns',
        ]); ?>

        <?php ai_bible_render_ndjson_link_area(absolute_url('/ai-search-bible/dataset/')); ?>
      <?php endif; ?>

    </div>
  </section>
</main>

<script>
(function () {
  if (typeof window.gtag === 'function') {
    window.gtag('event', 'view_ai_search_bible_full', { authorized: <?= $isUnlocked ? "'1'" : "'0'" ?> });
  }

  var buyButton = document.getElementById('ai-search-bible-buy-button');
  if (buyButton) {
    buyButton.addEventListener('click', function () {
      if (typeof window.gtag === 'function') {
        window.gtag('event', 'checkout_started', { product: 'ai-search-bible' });
      }
    });
  }

  var checkAccessButton = document.getElementById('check-access-btn');
  var paidStillLockedButton = document.getElementById('paid-still-locked-btn');
  var paidStillLockedModal = document.getElementById('paid-still-locked-modal');
  if (checkAccessButton) {
    checkAccessButton.addEventListener('click', function () {
      fetch('<?= htmlspecialchars(absolute_url('/api/entitlements/me')) ?>', { credentials: 'same-origin' })
        .then(function (res) { return res.json(); })
        .then(function (data) {
          if (data && data.ai_search_bible === true) {
            if (typeof window.gtag === 'function') {
              window.gtag('event', 'checkout_success', { product: 'ai-search-bible' });
            }
            window.location.reload();
            return;
          }
          alert('Access not active yet. Please wait a few seconds and try again.');
        })
        .catch(function () {
          alert('Unable to check access right now.');
        });
    });
  }
  if (paidStillLockedButton && paidStillLockedModal) {
    paidStillLockedButton.addEventListener('click', function () {
      paidStillLockedModal.style.display = paidStillLockedModal.style.display === 'none' ? 'block' : 'none';
    });
  }
})();
</script>
