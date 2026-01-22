<?php
// Croutons Drag Interface Hero Component for NRLC.ai
?>
<!-- Croutons Drag Interface Hero -->
<div class="relative min-h-screen bg-black overflow-hidden">
  <!-- ASCII Background -->
  <div class="absolute inset-0 opacity-20">
    <pre class="text-green-500 text-xs leading-none font-mono select-none" style="font-size: 8px; line-height: 1;"><?php echo file_get_contents(__DIR__.'/../assets/ascii-art.txt'); ?></pre>
  </div>
  
  <!-- Stars Layer -->
  <div class="absolute inset-0" id="stars-layer"></div>
  
  <!-- Grid Overlay -->
  <div class="absolute inset-0 opacity-30" id="grid-overlay"></div>
  
  <!-- Fog Layer -->
  <div class="absolute inset-0 opacity-20" id="fog-layer"></div>
  
  <!-- Snap Particles Container -->
  <div class="snap-particles absolute inset-0 pointer-events-none"></div>
  
  <!-- Left Draggable Card -->
  <div id="left-card" class="absolute top-20 left-20 w-80 bg-gray-900/90 backdrop-blur-sm border border-cyan-500/30 rounded-lg p-6 cursor-grab select-none" data-draggable="left-card">
    <!-- Status line -->
    <div class="drag-handle flex items-center mb-6 cursor-grab active:cursor-grabbing select-none" data-draggable="left-card">
      <div class="text-xs text-[#00C2FF]/60">⋮⋮ DRAG ⋮⋮</div>
    </div>
    
    <!-- Logo -->
    <div class="flex flex-col items-center lg:items-start mb-6">
      <img src="/croutons-transparent.png" alt="Neural Command Logo" class="h-10 w-auto opacity-90" />
    </div>
    
    <!-- Tagline -->
    <div class="text-center lg:text-left space-y-3">
      <p class="text-sm md:text-base font-mono text-white uppercase tracking-wider">
        NEURAL COMMAND SEO
      </p>
      <p class="text-sm md:text-base text-[#C0C0C0] max-w-2xl mx-auto lg:mx-0 leading-relaxed">
        AI-powered programmatic SEO with multi-regional optimization and deterministic content generation for search dominance.
      </p>
    </div>
    
    <!-- CTA Button -->
    <div class="flex flex-col items-center lg:items-start space-y-4">
      <a href="/en-us/services/" class="inline-flex items-center px-6 py-3 bg-cyan-500 hover:bg-cyan-400 text-white font-semibold rounded-lg transition-colors duration-200">
        <span class="mr-2">🚀</span>
        Explore SEO Services
      </a>
    </div>
  </div>
  
  <!-- Right Draggable Card -->
  <div id="right-card" class="absolute top-20 right-20 w-80 bg-gray-900/90 backdrop-blur-sm border border-cyan-500/30 rounded-lg p-6 cursor-grab select-none" data-draggable="right-card">
    <!-- Status line -->
    <div class="drag-handle flex items-center mb-6 cursor-grab active:cursor-grabbing select-none" data-draggable="right-card">
      <div class="text-xs text-[#00C2FF]/60">⋮⋮ DRAG ⋮⋮</div>
    </div>
    
    <!-- Stats -->
    <div class="text-center lg:text-left space-y-4">
      <div class="space-y-2">
        <h3 class="text-lg font-bold text-white">AI Search Optimization</h3>
        <div class="space-y-1">
          <div class="flex justify-between text-sm">
            <span class="text-gray-400">Regions:</span>
            <span class="text-cyan-400 font-mono">6</span>
          </div>
          <div class="flex justify-between text-sm">
            <span class="text-gray-400">URLs Managed:</span>
            <span class="text-cyan-400 font-mono">30,000+</span>
          </div>
          <div class="flex justify-between text-sm">
            <span class="text-gray-400">Languages:</span>
            <span class="text-cyan-400 font-mono">en, es, fr, de, ko</span>
          </div>
          <div class="flex justify-between text-sm">
            <span class="text-gray-400">Schema Types:</span>
            <span class="text-cyan-400 font-mono">15+</span>
          </div>
        </div>
      </div>
      
      <!-- CTA Button -->
      <div class="mt-6">
        <a href="/en-us/ai-optimization/" class="inline-flex items-center px-6 py-3 bg-cyan-500 hover:bg-cyan-400 text-white font-semibold rounded-lg transition-colors duration-200">
          <span class="mr-2">⚡</span>
          AI Optimization
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Drag System JavaScript -->
<script src="/src/components/simple-drag.js"></script>
<script src="/src/components/hero-interactions.js"></script>
<script src="/src/components/hero-accordion.js"></script>
<script src="/src/components/ascii-background.js"></script>
