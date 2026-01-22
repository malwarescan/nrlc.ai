<section class="w-full h-screen bg-[#0A0A0A] flex items-center justify-center px-8 relative overflow-hidden">
  <!-- Parallax Background Layers -->
  <div class="absolute inset-0 overflow-hidden">
    <!-- Grid Points Layer -->
    <div class="parallax-layer grid-points absolute inset-0 opacity-4">
      <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
        <defs>
          <pattern id="grid-dots" x="0" y="0" width="32" height="32" patternUnits="userSpaceOnUse">
            <circle cx="16" cy="16" r="0.5" fill="#00C2FF" opacity="0.3"/>
          </pattern>
        </defs>
        <rect width="100%" height="100%" fill="url(#grid-dots)"/>
      </svg>
    </div>
    
    <!-- Stars Layer -->
    <div class="parallax-layer stars-layer absolute inset-0 opacity-3">
      <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
        <defs>
          <pattern id="stars" x="0" y="0" width="400" height="400" patternUnits="userSpaceOnUse">
            <circle cx="20" cy="20" r="0.3" fill="#00C2FF" opacity="0.15"/>
            <circle cx="180" cy="120" r="0.2" fill="#00C2FF" opacity="0.2"/>
            <circle cx="350" cy="50" r="0.25" fill="#00C2FF" opacity="0.15"/>
            <circle cx="80" cy="380" r="0.2" fill="#00C2FF" opacity="0.1"/>
            <!-- Rare bright stars with glow -->
            <circle cx="250" cy="200" r="0.8" fill="#00C2FF" opacity="0.4"/>
            <circle cx="100" cy="300" r="0.6" fill="#00C2FF" opacity="0.3"/>
          </pattern>
        </defs>
        <rect width="100%" height="100%" fill="url(#stars)"/>
      </svg>
    </div>
    
    <!-- Fog Layer -->
    <div class="parallax-layer fog-layer absolute inset-0">
      <div class="absolute top-0 left-0 w-96 h-96 bg-gradient-to-br from-cyan-900/10 via-transparent to-transparent rounded-full blur-3xl"></div>
      <div class="absolute bottom-0 right-0 w-80 h-80 bg-gradient-to-tl from-blue-900/5 via-transparent to-transparent rounded-full blur-2xl"></div>
    </div>
  </div>
  
  <!-- Grid Overlay (shown during drag) -->
  <div id="grid-overlay" class="absolute inset-0 opacity-0 pointer-events-none transition-opacity duration-300">
    <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
      <defs>
        <pattern id="drag-grid" x="0" y="0" width="32" height="32" patternUnits="userSpaceOnUse">
          <circle cx="16" cy="16" r="0.8" fill="#00C2FF" opacity="0.2"/>
        </pattern>
      </defs>
      <rect width="100%" height="100%" fill="url(#drag-grid)"/>
    </svg>
  </div>
  
  <!-- Soft vignette for depth -->
  <div class="absolute inset-0 bg-gradient-to-br from-transparent via-transparent to-black/20 pointer-events-none"></div>
  
  <div class="w-full mx-auto grid grid-cols-12 gap-12 items-start relative px-4 sm:px-6 lg:px-12">
    <!-- Left Column: Primary Card (7 columns) -->
    <div id="left-card" data-card-id="left" class="col-span-12 lg:col-span-7 lg:absolute">
      <div class="bg-[#0A0A0A]/95 border border-[#00C2FF]/20 rounded-xl p-6 shadow-2xl relative h-fit select-none">
        <!-- Corner Bolts -->
        <div class="absolute top-2 left-2 w-3 h-3 bg-gradient-to-br from-gray-600 to-gray-800 rounded-full border border-gray-500 shadow-sm"></div>
        <div class="absolute top-2 right-2 w-3 h-3 bg-gradient-to-br from-gray-600 to-gray-800 rounded-full border border-gray-500 shadow-sm"></div>
        <div class="absolute bottom-2 left-2 w-3 h-3 bg-gradient-to-br from-gray-600 to-gray-800 rounded-full border border-gray-500 shadow-sm"></div>
        <div class="absolute bottom-2 right-2 w-3 h-3 bg-gradient-to-br from-gray-600 to-gray-800 rounded-full border border-gray-500 shadow-sm"></div>
        
        <!-- Snap Particles Container -->
        <div class="snap-particles absolute inset-0 pointer-events-none"></div>
        
        <!-- Status line -->
        <div class="drag-handle flex items-center mb-6 cursor-grab active:cursor-grabbing select-none" data-draggable="left-card">
          <div class="text-xs text-[#00C2FF]/60">⋮⋮ DRAG ⋮⋮</div>
        </div>
        
        <!-- Logo -->
        <div class="flex flex-col items-center lg:items-start mb-6">
          <img src="/public/croutons-transparent.png" alt="Croutons AI Logo" class="h-10 w-auto opacity-90" />
        </div>
        
        <!-- Tagline -->
        <div class="text-center lg:text-left space-y-3">
          <p class="text-sm md:text-base font-mono text-white uppercase tracking-wider">
            BUILT FOR THE THIRD AUDIENCE
          </p>
          <p class="text-sm md:text-base text-[#C0C0C0] max-w-2xl mx-auto lg:mx-0 leading-relaxed">
            AI agents don't want HTML noise. Croutons publishes small, stable facts with proof: @id, source URL, observed time, and verification state. Delivered as NDJSON and mirrored as Markdown.
          </p>
        </div>
      </div>
    </div>
    
    <!-- Right Column: System Module Card (5 columns) -->
    <div id="right-card" data-card-id="right" class="col-span-12 lg:col-span-5 lg:absolute">
      <div class="bg-[#0A0A0A]/95 border border-[#00C2FF]/20 rounded-xl p-6 shadow-2xl relative h-fit select-none">
        <!-- Corner Bolts -->
        <div class="absolute top-2 left-2 w-3 h-3 bg-gradient-to-br from-gray-600 to-gray-800 rounded-full border border-gray-500 shadow-sm"></div>
        <div class="absolute top-2 right-2 w-3 h-3 bg-gradient-to-br from-gray-600 to-gray-800 rounded-full border border-gray-500 shadow-sm"></div>
        <div class="absolute bottom-2 left-2 w-3 h-3 bg-gradient-to-br from-gray-600 to-gray-800 rounded-full border border-gray-500 shadow-sm"></div>
        <div class="absolute bottom-2 right-2 w-3 h-3 bg-gradient-to-br from-gray-600 to-gray-800 rounded-full border border-gray-500 shadow-sm"></div>
        
        <!-- Snap Particles Container -->
        <div class="snap-particles absolute inset-0 pointer-events-none"></div>
        
        <!-- Module Header -->
        <div class="drag-handle flex items-center mb-4 cursor-grab active:cursor-grabbing select-none" data-draggable="right-card">
          <div class="text-xs text-[#00C2FF]/60">⋮⋮ DRAG ⋮⋮</div>
        </div>
        
        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center mb-6">
          <a href="understand.php" class="px-4 sm:px-6 py-2 text-[#00C2FF] font-medium hover:text-[#00D4FF] transition-all duration-200 underline decoration-2 underline-offset-4 hover:decoration-[#00D4FF] w-full sm:w-auto text-sm sm:text-base text-center">
            Understand
          </a>
          <a href="docs.php" class="px-4 sm:px-6 py-2 text-white font-medium hover:text-[#C0C0C0] transition-all duration-200 underline decoration-2 underline-offset-4 hover:decoration-[#C0C0C0] w-full sm:w-auto text-sm sm:text-base text-center">
            View Docs
          </a>
        </div>
        
        <!-- Module Rows -->
        <div class="space-y-1">
          <div class="mechanism-row group">
            <div class="flex items-center gap-3 p-3 rounded-lg border border-white/5 hover:border-[#00C2FF]/30 hover:bg-white/5 transition-all duration-200 cursor-pointer focus:outline focus:outline-2 focus:outline-[#00C2FF]/50">
              <div class="text-xs font-mono text-[#00C2FF] w-4">01</div>
              <div class="flex-1">
                <div class="mechanism-header flex items-center justify-between">
                  <div class="text-sm font-bold text-white">Markdown Mirroring</div>
                  <div class="text-[#00C2FF] transition-transform duration-200">›</div>
                </div>
                <div class="mechanism-content opacity-0 max-h-0 overflow-hidden transition-all duration-300">
                  <div class="text-xs text-white/70 pt-2 border-t border-white/10">Clean .md twins of key pages for agent-friendly extraction.</div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="border-t border-white/5"></div>
          
          <div class="mechanism-row group">
            <div class="flex items-center gap-3 p-3 rounded-lg border border-white/5 hover:border-[#00C2FF]/30 hover:bg-white/5 transition-all duration-200 cursor-pointer focus:outline focus:outline-2 focus:outline-[#00C2FF]/50">
              <div class="text-xs font-mono text-[#00C2FF] w-4">02</div>
              <div class="flex-1">
                <div class="mechanism-header flex items-center justify-between">
                  <div class="text-sm font-bold text-white">NDJSON Fact Stream</div>
                  <div class="text-[#00C2FF] transition-transform duration-200">›</div>
                </div>
                <div class="mechanism-content opacity-0 max-h-0 overflow-hidden transition-all duration-300">
                  <div class="text-xs text-white/70 pt-2 border-t border-white/10">Append-only fact feed with stable @id, source URL, timestamps, and state.</div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="border-t border-white/5"></div>
          
          <div class="mechanism-row group">
            <div class="flex items-center gap-3 p-3 rounded-lg border border-white/5 hover:border-[#00C2FF]/30 hover:bg-white/5 transition-all duration-200 cursor-pointer focus:outline focus:outline-2 focus:outline-[#00C2FF]/50">
              <div class="text-xs font-mono text-[#00C2FF] w-4">03</div>
              <div class="flex-1">
                <div class="mechanism-header flex items-center justify-between">
                  <div class="text-sm font-bold text-white">Temporal Proof (Drift Logs)</div>
                  <div class="text-[#00C2FF] transition-transform duration-200">›</div>
                </div>
                <div class="mechanism-content opacity-0 max-h-0 overflow-hidden transition-all duration-300">
                  <div class="text-xs text-white/70 pt-2 border-t border-white/10">Change events logged so drift and freshness stay visible over time.</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="src/components/simple-drag.js"></script>
<script src="src/components/hero-accordion.js"></script>
<link rel="stylesheet" href="src/components/tooltip.css">
<link rel="stylesheet" href="src/components/particles.css">
