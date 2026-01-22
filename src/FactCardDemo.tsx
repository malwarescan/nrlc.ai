import { useState } from 'react';
import { Link } from 'react-router-dom';
export function FactCardDemo() {
  const [hoveredCard, setHoveredCard] = useState<number | null>(null);
  const facts = [{
    status: 'verified',
    score: 92,
    category: 'Warranty · Service',
    content: 'All repairs include a 12-month workmanship warranty.',
    id: 'fact-warranty',
    updated: '10/29/25',
    color: '#25D366'
  }, {
    status: 'pending',
    score: null,
    category: 'Policy · Returns',
    content: 'Returns accepted within 30 days of purchase with original receipt.',
    id: 'fact-returns',
    updated: '10/28/25',
    color: '#6B6B6B'
  }, {
    status: 'verified',
    score: 88,
    category: 'Pricing · Discount',
    content: 'First-time customers receive 15% off their initial service.',
    id: 'fact-discount',
    updated: '10/27/25',
    color: '#25D366'
  }];
  return <section className="w-full bg-[#F8F8F8] py-24 px-8">
      <div className="max-w-4xl mx-auto">
        <div className="text-center mb-16">
          <h2 className="text-4xl md:text-5xl font-bold text-[#0A0A0A] mb-4">
            Fact Cards
          </h2>
          <p className="text-lg text-[#6B6B6B]">
            Small, verifiable, structured units of truth.
          </p>
        </div>
        <div className="space-y-6">
          {facts.map((fact, index) => <div key={index} onMouseEnter={() => setHoveredCard(index)} onMouseLeave={() => setHoveredCard(null)} className="bg-white border-l-4 p-6 transition-all duration-200 hover:shadow-lg" style={{
          borderLeftColor: fact.color
        }}>
              <div className="flex items-start justify-between mb-3">
                <div className="flex items-center gap-3">
                  <span className="text-xs font-mono text-[#6B6B6B] uppercase tracking-wider">
                    {fact.category}
                  </span>
                  {fact.status === 'verified' && fact.score && <span className="flex items-center gap-1 text-xs font-mono text-[#25D366]">
                      Verified
                      <span className="inline-block w-3 h-3 bg-[#25D366]"></span>
                      {fact.score}
                    </span>}
                  {fact.status === 'pending' && <span className="text-xs font-mono text-[#6B6B6B]">
                      Pending
                    </span>}
                </div>
              </div>
              <p className="text-lg text-[#0A0A0A] mb-4 leading-relaxed">
                "{fact.content}"
              </p>
              <div className="flex items-center justify-between text-xs font-mono text-[#6B6B6B]">
                <span>@id …#{fact.id}</span>
                <span>Updated {fact.updated}</span>
              </div>
              {hoveredCard === index && <div className="flex gap-3 mt-4 pt-4 border-t border-[#0A0A0A]/10">
                  <Link 
                    to={`/crouton/${fact.id}`}
                    className="text-xs font-mono text-[#00C2FF] hover:underline"
                  >
                    View Details
                  </Link>
                  <button className="text-xs font-mono text-[#00C2FF] hover:underline">
                    Copy @id
                  </button>
                  <button className="text-xs font-mono text-[#00C2FF] hover:underline">
                    View Source
                  </button>
                  <button className="text-xs font-mono text-[#00C2FF] hover:underline">
                    JSON
                  </button>
                  <button className="text-xs font-mono text-[#00C2FF] hover:underline">
                    Vector
                  </button>
                </div>}
            </div>)}
        </div>
      </div>
    </section>;
}