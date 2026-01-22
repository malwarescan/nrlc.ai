import React from 'react';
export function CTA() {
  return <section className="w-full bg-[#0A0A0A] py-24 px-8">
      <div className="max-w-4xl mx-auto text-center space-y-8">
        <h2 className="text-4xl md:text-6xl font-bold text-white">
          Structure is Clarity.
        </h2>
        <p className="text-xl text-[#6B6B6B] max-w-2xl mx-auto">
          Start transforming unstructured information into verifiable
          micro-facts.
        </p>
        <div className="flex flex-col sm:flex-row gap-4 justify-center items-center pt-8">
          <button className="px-8 py-4 bg-white text-[#0A0A0A] font-medium hover:bg-[#00C2FF] hover:text-white transition-colors duration-200">
            Get API Access
          </button>
          <button className="px-8 py-4 border-2 border-white text-white font-medium hover:bg-white hover:text-[#0A0A0A] transition-colors duration-200">
            Read the Docs
          </button>
        </div>
        <div className="pt-16 border-t border-white/20">
          <div className="grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
            <div className="space-y-2">
              <h4 className="text-sm font-mono text-white uppercase tracking-wider">
                Understand
              </h4>
              <p className="text-sm text-[#6B6B6B]">
                What is a Crouton? Learn the fundamentals.
              </p>
              <p className="text-sm text-[#6B6B6B] mt-2">
                Individual facts are also available as clean Markdown for AI agents that retrieve information one claim at a time.
              </p>
            </div>
            <div className="space-y-2">
              <h4 className="text-sm font-mono text-white uppercase tracking-wider">
                Build
              </h4>
              <p className="text-sm text-[#6B6B6B]">
                API keys, endpoints, documentation.
              </p>
            </div>
            <div className="space-y-2">
              <h4 className="text-sm font-mono text-white uppercase tracking-wider">
                Measure
              </h4>
              <p className="text-sm text-[#6B6B6B]">
                Analytics + AI Visibility Index.
              </p>
            </div>
          </div>
        </div>
        <div className="pt-8 text-xs font-mono text-[#6B6B6B]">
          © 2025 Croutons.ai · The Micro-Fact Protocol
        </div>
      </div>
    </section>;
}