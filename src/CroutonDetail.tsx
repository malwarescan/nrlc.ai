import React, { useEffect } from 'react';
import { useParams } from 'react-router-dom';

interface Crouton {
  id: string;
  claim: string;
  entities?: string[];
  confidence?: number;
  sources: string[];
  created_at: string;
  updated_at: string;
}

export function CroutonDetail() {
  const { id } = useParams<{ id: string }>();
  const [crouton, setCrouton] = React.useState<Crouton | null>(null);
  const [loading, setLoading] = React.useState(true);
  const [error, setError] = React.useState<string | null>(null);

  useEffect(() => {
    // Add alternate link for AI crawlers
    const link = document.createElement('link');
    link.rel = 'alternate';
    link.type = 'text/markdown';
    link.href = `https://croutons.ai/v1/croutons/${id}.md`;
    document.head.appendChild(link);

    return () => {
      document.head.removeChild(link);
    };
  }, [id]);

  useEffect(() => {
    const fetchCrouton = async () => {
      try {
        const response = await fetch(`/v1/croutons/${id}`);
        const data = await response.json();
        
        if (data.ok) {
          setCrouton(data.data);
        } else {
          setError(data.error || 'Failed to load crouton');
        }
      } catch (err) {
        setError('Network error');
      } finally {
        setLoading(false);
      }
    };

    if (id) {
      fetchCrouton();
    }
  }, [id]);

  if (loading) {
    return <div className="flex justify-center items-center min-h-screen">
      <div className="text-lg">Loading...</div>
    </div>;
  }

  if (error || !crouton) {
    return <div className="flex justify-center items-center min-h-screen">
      <div className="text-red-500">Error: {error || 'Crouton not found'}</div>
    </div>;
  }

  return (
    <div className="min-h-screen bg-[#F8F8F8] py-12 px-8">
      <div className="max-w-4xl mx-auto">
        <div className="bg-white rounded-lg shadow-lg p-8">
          {/* Header */}
          <div className="mb-6">
            <div className="flex items-center gap-3 mb-4">
              <span className="text-xs font-mono text-[#6B6B6B] uppercase tracking-wider">
                Crouton
              </span>
              {crouton.confidence && (
                <span className="flex items-center gap-1 text-xs font-mono text-[#25D366]">
                  Confidence: {(crouton.confidence * 100).toFixed(0)}%
                  <span className="inline-block w-3 h-3 bg-[#25D366]"></span>
                </span>
              )}
            </div>
            
            <h1 className="text-3xl font-bold text-[#0A0A0A] mb-2">
              {crouton.claim}
            </h1>
          </div>

          {/* Entities */}
          {crouton.entities && crouton.entities.length > 0 && (
            <div className="mb-6">
              <h3 className="text-sm font-mono text-[#6B6B6B] uppercase tracking-wider mb-2">
                Entities
              </h3>
              <div className="flex flex-wrap gap-2">
                {crouton.entities.map((entity, index) => (
                  <span
                    key={index}
                    className="px-3 py-1 bg-[#00C2FF]/10 text-[#00C2FF] rounded-full text-sm font-mono"
                  >
                    {entity}
                  </span>
                ))}
              </div>
            </div>
          )}

          {/* Sources */}
          {crouton.sources && crouton.sources.length > 0 && (
            <div className="mb-6">
              <h3 className="text-sm font-mono text-[#6B6B6B] uppercase tracking-wider mb-2">
                Sources
              </h3>
              <ul className="space-y-2">
                {crouton.sources.map((source, index) => (
                  <li key={index} className="flex items-center gap-2">
                    <span className="text-[#00C2FF]">→</span>
                    <a
                      href={source}
                      target="_blank"
                      rel="noopener noreferrer"
                      className="text-[#0A0A0A] hover:text-[#00C2FF] underline"
                    >
                      {source}
                    </a>
                  </li>
                ))}
              </ul>
            </div>
          )}

          {/* Metadata */}
          <div className="border-t border-[#0A0A0A]/10 pt-6">
            <div className="flex items-center justify-between text-xs font-mono text-[#6B6B6B]">
              <span>ID: {crouton.id}</span>
              <div className="text-right">
                <div>Created: {new Date(crouton.created_at).toLocaleDateString()}</div>
                <div>Updated: {new Date(crouton.updated_at).toLocaleDateString()}</div>
              </div>
            </div>
          </div>

          {/* Actions */}
          <div className="flex gap-3 mt-6 pt-6 border-t border-[#0A0A0A]/10">
            <button
              onClick={() => navigator.clipboard.writeText(crouton.id)}
              className="text-xs font-mono text-[#00C2FF] hover:underline"
            >
              Copy ID
            </button>
            <a
              href={`/v1/croutons/${crouton.id}.md`}
              target="_blank"
              rel="noopener noreferrer"
              className="text-xs font-mono text-[#00C2FF] hover:underline"
            >
              View Markdown
            </a>
            <a
              href={`/v1/croutons/${crouton.id}`}
              target="_blank"
              rel="noopener noreferrer"
              className="text-xs font-mono text-[#00C2FF] hover:underline"
            >
              View JSON
            </a>
          </div>
        </div>
      </div>
    </div>
  );
}
