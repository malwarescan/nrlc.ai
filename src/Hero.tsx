export function Hero() {
  return <section className="w-full h-screen flex flex-col items-center justify-center px-8 relative">
      <div className="max-w-5xl w-full space-y-8 relative z-10">
        {/* Logo */}
        <div className="flex flex-col items-center">
          <img src="/croutons_logo_for_website.png" alt="Croutons AI Logo" className="h-10 w-auto opacity-90" />
        </div>
        {/* Tagline */}
        <div className="text-center space-y-4">
          <p className="text-sm md:text-base font-mono text-[#6B6B6B] tracking-wider">
            THE DATA SHAPING PROTOCOL.
          </p>
          <p className="text-base md:text-lg text-[#4A4A4A] max-w-2xl mx-auto leading-relaxed">
            We transform plain information into clear, verifiable units of truth; small enough to cite, strong enough to stand alone.
          </p>
        </div>
        {/* CTA Buttons */}
        <div className="flex flex-col sm:flex-row gap-4 justify-center items-center max-w-md mx-auto">
          <button className="px-6 py-3 bg-[#0A0A0A] text-white font-medium hover:bg-[#00C2FF] transition-colors duration-200 w-full sm:w-auto">
            Understand
          </button>
          <button className="px-6 py-3 border-2 border-[#0A0A0A] text-[#0A0A0A] font-medium hover:bg-[#0A0A0A] hover:text-white transition-colors duration-200 w-full sm:w-auto">
            View Documentation
          </button>
        </div>
      </div>
    </section>;
}