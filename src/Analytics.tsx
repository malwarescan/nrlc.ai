import React from 'react';
export function Analytics() {
  const metrics = [{
    label: 'AI Visibility Index',
    value: '94',
    unit: '%',
    color: '#00C2FF'
  }, {
    label: 'TrustScore',
    value: '89',
    unit: '/100',
    color: '#25D366'
  }, {
    label: 'Fact Velocity',
    value: '2.4k',
    unit: '/day',
    color: '#00C2FF'
  }, {
    label: 'Vector Reach',
    value: '12.8M',
    unit: 'nodes',
    color: '#25D366'
  }];
  return <section className="w-full bg-white py-24 px-8">
      <div className="max-w-6xl mx-auto">
        <div className="text-center mb-16">
          <h2 className="text-4xl md:text-5xl font-bold text-[#0A0A0A] mb-4">
            Measure What Matters
          </h2>
          <p className="text-lg text-[#6B6B6B]">
            Data-dense, unobtrusive, precise.
          </p>
        </div>
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          {metrics.map((metric, index) => <div key={index} className="border-2 border-[#0A0A0A] p-8 hover:border-[#00C2FF] transition-colors duration-200">
              <div className="space-y-4">
                <div className="flex items-baseline gap-1">
                  <span className="text-5xl font-bold text-[#0A0A0A]">
                    {metric.value}
                  </span>
                  <span className="text-xl font-mono text-[#6B6B6B]">
                    {metric.unit}
                  </span>
                </div>
                <div className="h-1 w-full bg-[#F8F8F8]">
                  <div className="h-full transition-all duration-300" style={{
                width: `${Math.min(parseInt(metric.value.replace(/[^0-9]/g, '')) / 100 * 100, 100)}%`,
                backgroundColor: metric.color
              }}></div>
                </div>
                <div className="text-sm font-mono text-[#6B6B6B] uppercase tracking-wider">
                  {metric.label}
                </div>
              </div>
            </div>)}
        </div>
        <div className="mt-16 p-8 bg-[#F8F8F8] border-2 border-[#0A0A0A]">
          <div className="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div className="space-y-2">
              <h3 className="text-2xl font-bold text-[#0A0A0A]">
                Dashboard Preview
              </h3>
              <p className="text-[#6B6B6B]">
                Left = human summary. Right = JSON preview.
              </p>
            </div>
            <button className="px-6 py-3 bg-[#0A0A0A] text-white font-mono text-sm hover:bg-[#00C2FF] transition-colors duration-200">
              View Full Dashboard
            </button>
          </div>
        </div>
      </div>
    </section>;
}