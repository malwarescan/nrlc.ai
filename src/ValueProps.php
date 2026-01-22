<section class="w-full py-20 px-8 bg-white relative overflow-hidden">
  <!-- Dithered Background Pattern -->
  <div class="absolute inset-0 opacity-5">
    <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
      <defs>
        <pattern id="dither" x="0" y="0" width="4" height="4" patternUnits="userSpaceOnUse">
          <rect x="0" y="0" width="2" height="2" fill="#00C2FF"/>
          <rect x="2" y="2" width="2" height="2" fill="#00C2FF"/>
        </pattern>
        <pattern id="dots" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
          <circle cx="2" cy="2" r="1" fill="#00C2FF" opacity="0.3"/>
          <circle cx="12" cy="12" r="0.5" fill="#00C2FF" opacity="0.5"/>
          <circle cx="7" cy="17" r="0.8" fill="#00C2FF" opacity="0.4"/>
        </pattern>
      </defs>
      <rect width="100%" height="100%" fill="url(#dither)"/>
      <rect width="100%" height="100%" fill="url(#dots)"/>
    </svg>
  </div>
  
  <!-- Gradient Overlay -->
  <div class="absolute inset-0 bg-gradient-to-br from-transparent via-white to-[#00C2FF]/5"></div>
  
  <!-- Content -->
  <div class="max-w-5xl w-full mx-auto relative z-10">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="text-center space-y-2">
        <div class="text-2xl font-bold text-[#0A0A0A]">Precision</div>
        <div class="text-sm text-[#6B6B6B] font-mono">
          Every byte has purpose.
        </div>
      </div>
      <div class="text-center space-y-2">
        <div class="text-2xl font-bold text-[#0A0A0A]">
          Verification
        </div>
        <div class="text-sm text-[#6B6B6B] font-mono">
          Facts built for proof, not polish.
        </div>
      </div>
      <div class="text-center space-y-2">
        <div class="text-2xl font-bold text-[#0A0A0A]">
          Transparency
        </div>
        <div class="text-sm text-[#6B6B6B] font-mono">
          Visible, structured, and impossible to fake.
        </div>
      </div>
    </div>
  </div>
</section>
