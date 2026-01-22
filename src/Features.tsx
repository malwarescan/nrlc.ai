import React from 'react';
export function Features() {
  const features = [{
    title: 'Atomic Clarity',
    description: 'Each component does one thing clearly. Every element is readable by humans and exportable as JSON.',
    icon: '▣'
  }, {
    title: 'Dual Readability',
    description: 'Designed for both human comprehension and machine parsing. Elegance in code syntax and UI symmetry.',
    icon: '◈'
  }, {
    title: 'Progressive Depth',
    description: 'Reveal technical layers on demand. Vector IDs, citations, and metadata available when you need them.',
    icon: '◇'
  }, {
    title: 'Trust Through Space',
    description: 'White space signals integrity and focus. Every pixel is as intentional as every fact.',
    icon: '◻'
  }];
  return <section className="w-full bg-white py-24 px-8">
      <div className="max-w-6xl mx-auto">
        <div className="text-center mb-16">
          <h2 className="text-4xl md:text-5xl font-bold text-[#0A0A0A] mb-4">
            The Data Distiller
          </h2>
          <p className="text-lg text-[#6B6B6B] max-w-2xl mx-auto">
            Structured flavor for data. Transform chaos into clarity.
          </p>
        </div>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
          {features.map((feature, index) => <div key={index} className="border-2 border-[#0A0A0A] p-8 hover:bg-[#F8F8F8] transition-colors duration-200">
              <div className="text-5xl mb-4 text-[#0A0A0A]">{feature.icon}</div>
              <h3 className="text-2xl font-bold text-[#0A0A0A] mb-3">
                {feature.title}
              </h3>
              <p className="text-[#6B6B6B] leading-relaxed">
                {feature.description}
              </p>
            </div>)}
        </div>
      </div>
    </section>;
}