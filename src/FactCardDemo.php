<?php
$facts = [
  [
    "category" => "Hiring",
    "type" => "Applicants",
    "status" => "verified",
    "score" => 95,
    "content" => "Job listings are deduplicated by employer, location, and start date to reduce spam and repost loops.",
    "id" => "fact-job-dedupe",
    "offsetMin" => -12,
    "color" => "#25D366",
    "citation" => "https://example.com/hiring/deduplication",
    "@id" => "https://example.com/#fact-job-dedupe",
    "@context" => "https://schema.org",
    "@type" => "JobPosting"
  ],
  [
    "category" => "Investigations",
    "type" => "DevilCorp",
    "status" => "verified",
    "score" => 91,
    "content" => "Organizations are clustered by shared office addresses, recruiter names, and identical onboarding scripts.",
    "id" => "fact-org-clustering",
    "offsetMin" => -38,
    "color" => "#25D366",
    "citation" => "https://example.com/investigations/clustering",
    "@id" => "https://example.com/#fact-org-clustering",
    "@context" => "https://schema.org",
    "@type" => "Organization"
  ],
  [
    "category" => "Home Risk",
    "type" => "Flood",
    "status" => "verified",
    "score" => 89,
    "content" => "Flood risk summaries combine FEMA zone signals with localized rainfall intensity and drainage constraints.",
    "id" => "fact-flood-risk",
    "offsetMin" => -71,
    "color" => "#25D366",
    "citation" => "https://example.com/insurance/flood-risk",
    "@id" => "https://example.com/#fact-flood-risk",
    "@context" => "https://schema.org",
    "@type" => "RiskAssessment"
  ],
  [
    "category" => "Healthcare Transport",
    "type" => "NEMT",
    "status" => "verified",
    "score" => 93,
    "content" => "Trip confirmations record pickup window, rider name match, and facility requirements before dispatch.",
    "id" => "fact-nemt-confirm",
    "offsetMin" => -140,
    "color" => "#25D366",
    "citation" => "https://example.com/healthcare/nemt",
    "@id" => "https://example.com/#fact-nemt-confirm",
    "@context" => "https://schema.org",
    "@type" => "Service"
  ],
  [
    "category" => "Construction",
    "type" => "Siding",
    "status" => "verified",
    "score" => 90,
    "content" => "Siding estimates include tear-off, moisture barrier, flashing, and disposal in the written scope.",
    "id" => "fact-siding-scope",
    "offsetMin" => -260,
    "color" => "#25D366",
    "citation" => "https://example.com/construction/siding-estimates",
    "@id" => "https://example.com/#fact-siding-scope",
    "@context" => "https://schema.org",
    "@type" => "Service"
  ],
  [
    "category" => "AI Search",
    "type" => "AEO/GEO",
    "status" => "verified",
    "score" => 96,
    "content" => "Pages are built as atomic, schema-first units so answer engines can retrieve and cite specific claims.",
    "id" => "fact-atomic-schema",
    "offsetMin" => -390,
    "color" => "#25D366",
    "citation" => "https://example.com/seo/atomic-schema",
    "@id" => "https://example.com/#fact-atomic-schema",
    "@context" => "https://schema.org",
    "@type" => "SoftwareApplication"
  ],
  [
    "status" => "verified",
    "score" => 92,
    "category" => "Warranty · Service",
    "content" => "All repairs include a 12-month workmanship warranty.",
    "id" => "fact-warranty",
    "offsetMin" => -12,
    "color" => "#25D366",
    "citation" => "https://example.com/services/warranty",
    "@id" => "https://example.com/#fact-warranty",
    "@context" => "https://schema.org",
    "@type" => "Service"
  ],
  [
    "category" => "Policy · Returns",
    "type" => "",
    "status" => "pending",
    "score" => null,
    "content" => "Returns accepted within 30 days of purchase with original receipt.",
    "id" => "fact-returns",
    "offsetMin" => -38,
    "color" => "#6B6B6B",
    "citation" => "https://example.com/policies/returns",
    "@id" => "https://example.com/#fact-returns",
    "@context" => "https://schema.org",
    "@type" => "Policy"
  ],
  [
    "category" => "Marketplace",
    "type" => "Pricing",
    "status" => "verified",
    "score" => 87,
    "content" => "Listings are normalized so price comparisons aren't distorted by shipping, bundles, or variant tricks.",
    "id" => "fact-price-normalize",
    "offsetMin" => -2880,
    "color" => "#25D366",
    "citation" => "https://example.com/marketplace/price-normalization",
    "@id" => "https://example.com/#fact-price-normalize",
    "@context" => "https://schema.org",
    "@type" => "Offer"
  ],
  [
    "category" => "Compliance",
    "type" => "Jobs",
    "status" => "verified",
    "score" => 94,
    "content" => "JobPosting schema includes salary, location type, and hiring organization to qualify for rich results.",
    "id" => "fact-jobposting-schema",
    "offsetMin" => -4320,
    "color" => "#25D366",
    "citation" => "https://example.com/compliance/jobposting-schema",
    "@id" => "https://example.com/#fact-jobposting-schema",
    "@context" => "https://schema.org",
    "@type" => "JobPosting"
  ],
  [
    "category" => "Knowledge Graph",
    "type" => "Entities",
    "status" => "verified",
    "score" => 91,
    "content" => "Each brand has one authoritative Organization entity, and all services link back to it as operator.",
    "id" => "fact-org-anchor",
    "offsetMin" => -520,
    "color" => "#25D366",
    "citation" => "https://example.com/knowledge-graph/org-entities",
    "@id" => "https://example.com/#fact-org-anchor",
    "@context" => "https://schema.org",
    "@type" => "Organization"
  ],
  [
    "category" => "Observability",
    "type" => "Health Checks",
    "status" => "verified",
    "score" => 89,
    "content" => "Service health checks track status, latency, and error rate to catch failures before users do.",
    "id" => "fact-health-checks",
    "offsetMin" => -55,
    "color" => "#25D366",
    "citation" => "https://example.com/observability/health-checks"
  ],
  [
    "category" => "Payments",
    "type" => "Fraud",
    "status" => "verified",
    "score" => 92,
    "content" => "High-risk payments are scored using velocity, mismatch signals, and device fingerprint heuristics.",
    "id" => "fact-fraud-signals",
    "offsetMin" => -1200,
    "color" => "#25D366",
    "citation" => "https://example.com/payments/fraud-signals",
    "@id" => "https://example.com/#fact-fraud-signals",
    "@context" => "https://schema.org",
    "@type" => "FinancialService"
  ],
  [
    "category" => "UX",
    "type" => "Lead Capture",
    "status" => "verified",
    "score" => 90,
    "content" => "iPad lead capture uses large tap targets and offline-safe submission to avoid drop-offs at events.",
    "id" => "fact-ipad-leads",
    "offsetMin" => -180,
    "color" => "#25D366",
    "citation" => "https://example.com/ux/ipad-lead-capture",
    "@id" => "https://example.com/#fact-ipad-leads",
    "@context" => "https://schema.org",
    "@type" => "WebPage"
  ],
  [
    "category" => "Local SEO",
    "type" => "GBP",
    "status" => "verified",
    "score" => 89,
    "content" => "Service pages are localized by city intent and backed by consistent NAP + profile links.",
    "id" => "fact-local-entity",
    "offsetMin" => -840,
    "color" => "#25D366",
    "citation" => "https://example.com/local-seo/entity-consistency",
    "@id" => "https://example.com/#fact-local-entity",
    "@context" => "https://schema.org",
    "@type" => "LocalBusiness"
  ]
];
?>
<section id="facts" class="w-full bg-[#F8F8F8] py-24 px-8">
  <div class="max-w-4xl mx-auto">
    <div class="text-center mb-16">
      <h2 class="text-4xl md:text-5xl font-bold text-[#0A0A0A] mb-4">
        Fact Cards
      </h2>
      <p class="text-lg text-[#6B6B6B]">
        Small, verifiable, structured units of truth.
      </p>
    </div>
    <div class="space-y-6">
      <?php foreach ($facts as $index => $fact): ?>
        <div 
          class="fact-card bg-white border-l-4 p-6 transition-all duration-300 ease-in-out hover:shadow-lg cursor-pointer" 
          style="border-left-color: <?php echo htmlspecialchars($fact['color']); ?>;"
          data-index="<?php echo $index; ?>"
          data-fact-id="<?php echo htmlspecialchars($fact['id']); ?>"
          data-fact-json="<?php echo htmlspecialchars(json_encode($fact)); ?>"
          data-citation="<?php echo htmlspecialchars($fact['citation']); ?>"
          data-offset-min="<?php echo htmlspecialchars($fact['offsetMin']); ?>"
        >
          <div class="flex items-start justify-between mb-3">
            <div class="flex items-center gap-3">
              <span class="text-xs font-mono text-[#6B6B6B] uppercase tracking-wider">
                <?php echo htmlspecialchars($fact['category']); ?>
              </span>
              <?php if ($fact['status'] === 'verified' && $fact['score']): ?>
                <span class="flex items-center gap-1 text-xs font-mono text-[#25D366]">
                  Verified
                  <span class="inline-block w-3 h-3 bg-[#25D366]"></span>
                  <?php echo htmlspecialchars($fact['score']); ?>
                </span>
              <?php endif; ?>
              <?php if ($fact['status'] === 'pending'): ?>
                <span class="text-xs font-mono text-[#6B6B6B]">
                  Pending
                </span>
              <?php endif; ?>
            </div>
          </div>
          <p class="text-lg text-[#0A0A0A] mb-4 leading-relaxed">
            "<?php echo htmlspecialchars($fact['content']); ?>"
          </p>
          <div class="flex items-center justify-between text-xs font-mono text-[#6B6B6B]">
            <span>@id …#<?php echo htmlspecialchars($fact['id']); ?></span>
            <span class="fact-date">Verified <?php 
              $date = new DateTime();
              $date->modify(sprintf('%d minutes', $fact['offsetMin']));
              echo $date->format('M j, Y - H:i');
            ?></span>
          </div>
          <div class="fact-card-actions opacity-0 max-h-0 overflow-hidden transition-all duration-300 ease-in-out mt-0 pt-0 border-t-0 border-[#0A0A0A]/10" style="display: none;">
            <div class="flex gap-3">
              <button 
                class="copy-id-btn text-xs font-mono text-[#00C2FF] hover:underline cursor-pointer transition-opacity duration-200"
                data-fact-id="<?php echo htmlspecialchars($fact['id']); ?>"
              >
                Copy @id
              </button>
              <button 
                class="view-source-btn text-xs font-mono text-[#00C2FF] hover:underline cursor-pointer transition-opacity duration-200"
                data-citation="<?php echo htmlspecialchars($fact['citation']); ?>"
              >
                View Source
              </button>
              <button 
                class="view-json-btn text-xs font-mono text-[#00C2FF] hover:underline cursor-pointer transition-opacity duration-200"
                data-fact-json="<?php echo htmlspecialchars(json_encode($fact)); ?>"
              >
                JSON
              </button>
              <button 
                class="view-vector-btn text-xs font-mono text-[#00C2FF] hover:underline cursor-pointer transition-opacity duration-200"
                data-fact-id="<?php echo htmlspecialchars($fact['id']); ?>"
              >
                Vector
              </button>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<script>
  // Copy ID button functionality
  document.querySelectorAll('.copy-id-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const fullId = `https://example.com/#${this.getAttribute('data-fact-id')}`;
      navigator.clipboard.writeText(fullId).then(() => {
        this.textContent = 'Copied!';
        setTimeout(() => {
          this.textContent = 'Copy @id';
        }, 2000);
      });
    });
  });

  // View Source functionality - opens modal
  document.querySelectorAll('.view-source-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.stopPropagation();
      const citation = this.getAttribute('data-citation');
      
      const content = `
        <h3 class="text-2xl font-bold text-[#0A0A0A] mb-4">Source Citation</h3>
        <p class="text-[#6B6B6B] mb-4">Citation URL:</p>
        <pre class="bg-[#F8F8F8] p-4 font-mono text-sm border border-[#0A0A0A] overflow-x-auto"><code>${citation}</code></pre>
        <div class="mt-4 flex gap-2">
          <a href="${citation}" target="_blank" class="px-4 py-2 bg-[#0A0A0A] text-white text-sm hover:bg-[#00C2FF] transition-colors inline-block">
            Open Source
          </a>
          <button class="copy-source-btn px-4 py-2 border-2 border-[#0A0A0A] text-[#0A0A0A] text-sm hover:bg-[#0A0A0A] hover:text-white transition-colors">
            Copy URL
          </button>
        </div>
      `;
      showModal(content);

      // Copy Source URL button
      document.querySelector('.copy-source-btn').addEventListener('click', function() {
        navigator.clipboard.writeText(citation).then(() => {
          this.textContent = 'Copied!';
          setTimeout(() => {
            this.textContent = 'Copy URL';
          }, 2000);
        });
      });
    });
  });

  // View JSON functionality - opens modal
  document.querySelectorAll('.view-json-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.stopPropagation();
      const factJson = JSON.parse(this.getAttribute('data-fact-json'));
      
      // Format as Croutons JSON-LD structure
      const croutonJson = {
        "@context": factJson['@context'] || "https://schema.org",
        "@type": factJson['@type'] || "CreativeWork",
        "@id": factJson['@id'] || "https://example.com/#" + factJson.id,
        "text": factJson.content,
        "about": { "@type": "Thing", "name": factJson.category },
        "provider": { "@type": "Organization", "name": "Example Provider" },
        "citation": factJson.citation,
        "dateModified": factJson.updated,
        "status": factJson.status,
        "score": factJson.score
      };

      const content = `
        <h3 class="text-2xl font-bold text-[#0A0A0A] mb-4">JSON Representation</h3>
        <pre class="bg-[#F8F8F8] p-4 font-mono text-sm border border-[#0A0A0A] overflow-x-auto"><code>${JSON.stringify(croutonJson, null, 2)}</code></pre>
        <div class="mt-4 flex gap-2">
          <button class="copy-json-btn px-4 py-2 bg-[#0A0A0A] text-white text-sm hover:bg-[#00C2FF] transition-colors">
            Copy JSON
          </button>
        </div>
      `;
      showModal(content);

      // Copy JSON button
      document.querySelector('.copy-json-btn').addEventListener('click', function() {
        navigator.clipboard.writeText(JSON.stringify(croutonJson, null, 2)).then(() => {
          this.textContent = 'Copied!';
          setTimeout(() => {
            this.textContent = 'Copy JSON';
          }, 2000);
        });
      });
    });
  });

  // View Vector functionality - opens modal
  document.querySelectorAll('.view-vector-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.stopPropagation();
      const factId = this.getAttribute('data-fact-id');
      
      // Generate a mock vector representation (in real implementation, this would come from API)
      const vectorHash = btoa(factId).substring(0, 16);
      const vector = Array.from({length: 8}, () => Math.random().toFixed(6));
      
      const content = `
        <h3 class="text-2xl font-bold text-[#0A0A0A] mb-4">Vector Representation</h3>
        <p class="text-[#6B6B6B] mb-4">Vector ID: <code class="bg-[#F8F8F8] px-1 py-0.5 border border-[#0A0A0A]">${vectorHash}</code></p>
        <pre class="bg-[#F8F8F8] p-4 font-mono text-sm border border-[#0A0A0A] overflow-x-auto"><code>[${vector.join(', ')}]</code></pre>
        <p class="text-sm text-[#6B6B6B] mt-4">Vector dimensions: 8</p>
      `;
      showModal(content);
    });
  });

  // Close modal
  closeModal.addEventListener('click', function() {
    hideModal();
  });

  modal.addEventListener('click', function(e) {
    if (e.target === modal) {
      hideModal();
    }
  });

  // Close on Escape key
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
      hideModal();
    }
  });
</script>

<!-- Modal Structure -->
<div id="fact-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
  <div class="bg-white rounded-lg max-w-2xl w-full max-h-[80vh] overflow-y-auto">
    <div class="p-6">
      <div class="flex justify-between items-start mb-4">
        <div id="modal-content"></div>
        <button id="close-modal" class="text-[#6B6B6B] hover:text-[#0A0A0A] text-2xl leading-none">&times;</button>
      </div>
    </div>
  </div>
</div>

<script>
  // Modal functions
  function showModal(content) {
    const modal = document.getElementById('fact-modal');
    const modalContent = document.getElementById('modal-content');
    modalContent.innerHTML = content;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
  }

  function hideModal() {
    const modal = document.getElementById('fact-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
  }

  // Fact card hover/click interactions
  document.querySelectorAll('.fact-card').forEach(card => {
    card.addEventListener('mouseenter', function() {
      const actions = this.querySelector('.fact-card-actions');
      if (actions) {
        actions.style.opacity = '1';
        actions.style.maxHeight = '200px';
        actions.style.marginTop = '1rem';
        actions.style.paddingTop = '1rem';
        actions.style.borderTopWidth = '1px';
        actions.style.display = 'block';
      }
    });

    card.addEventListener('mouseleave', function() {
      const actions = this.querySelector('.fact-card-actions');
      if (actions) {
        actions.style.opacity = '0';
        actions.style.maxHeight = '0';
        actions.style.marginTop = '0';
        actions.style.paddingTop = '0';
        actions.style.borderTopWidth = '0';
      }
    });
  });

  // Modal elements
  const modal = document.getElementById('fact-modal');
  const closeModal = document.getElementById('close-modal');
</script>
