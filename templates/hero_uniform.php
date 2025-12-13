<?php
/**
 * Uniform Hero Content Template
 * 
 * MANDATORY STRUCTURE:
 * Line 1: Research Statement (WHAT WE STUDY)
 * Line 2: Philosophical Statement (WHY IT MATTERS)
 * Line 3: Applications Statement (WHERE IT IS USED)
 * Line 4 (Optional): Outcome Statement
 * 
 * TONE: Authoritative research, engineering clarity, zero marketing fluff
 */

function render_uniform_hero_content($include_buttons = true) {
  ?>
  <div class="hero-foreground">
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">Structured Intelligence Systems</h1>
      </div>
      <div class="content-block__body">
        <!-- Line 1: Research Statement -->
        <p class="lead">NRLC researches structured cognition, ontological reasoning, micro-fact architectures, and agentic search systems.</p>
        
        <!-- Line 2: Philosophical Statement -->
        <p>Data becomes intelligence only through structure, verification, and ontology.</p>
        
        <!-- Line 3: Applications Statement -->
        <p>Applied to schema engines, onboarding intelligence, renderer labs, microfact pipelines, and domain cognition models.</p>
        
        <?php if ($include_buttons): ?>
        <div class="btn-group">
          <a href="sms:+12135628438?body=hey, im interested in picking your brain" class="btn btn--primary" title="Send us a text message to discuss your project" aria-label="Send us a text message">Text Us</a>
          <a href="tel:+12135628438" class="btn" title="Call us now at +1 (213) 562-8438" aria-label="Call us now">Call Now</a>
          <a href="mailto:hirejoelm@gmail.com" class="btn" title="Send us an email to discuss your project" aria-label="Send us an email">Email Us</a>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <?php
}
?>

