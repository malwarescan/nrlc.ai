<?php
/**
 * NRLC AI Case Study System - JSON-LD Master Template Generator
 * 
 * This is the canonical schema shape for all case studies.
 * It incorporates Organization, Expertise, Prompt Clusters, Outcomes, and Trust in one graph.
 */

/**
 * Generate the full JSON-LD master template for a case study
 * 
 * @param array $data Case study data with required fields:
 *   - slug: string (e.g., 'b2b-saas')
 *   - title: string (e.g., 'B2B SaaS AI SEO Case Study')
 *   - description: string (ONE SENTENCE: WHAT AI GOT WRONG AND WHAT CHANGED)
 *   - prompt_cluster: string (one of: 'invisible-brand', 'competitor-hallucination', 'trust-comparison', 'local-failure')
 *   - situation: string (REAL WORLD CONTEXT)
 *   - ai_failure: string (WHAT AI FAILED TO RETURN)
 *   - technical_diagnosis: string (WHY AI COULD NOT CITE)
 *   - intervention: string (ENTITY / DATA / SCHEMA ACTIONS)
 *   - outcome: string (HOW AI ANSWERS CHANGED)
 *   - citation_result: string (CITATION / INCLUSION / CORRECTNESS)
 * 
 * @return array JSON-LD graph structure
 */
function generate_case_study_master_schema(array $data): array {
  $slug = $data['slug'] ?? 'unknown';
  $canonicalUrl = absolute_url("/en-us/case-studies/{$slug}/");
  $orgId = "https://nrlc.ai/#organization";
  $promptClustersId = "https://nrlc.ai/#ai-prompt-clusters";
  
  // Map prompt cluster to DefinedTerm ID
  $promptClusterMap = [
    'invisible-brand' => 'https://nrlc.ai/#prompt-invisible-brand',
    'competitor-hallucination' => 'https://nrlc.ai/#prompt-competitor-hallucination',
    'trust-comparison' => 'https://nrlc.ai/#prompt-trust-comparison',
    'local-failure' => 'https://nrlc.ai/#prompt-local-recommendation'
  ];
  
  $promptClusterId = $promptClusterMap[$data['prompt_cluster'] ?? 'invisible-brand'] ?? $promptClusterMap['invisible-brand'];
  
  // Build the complete graph
  $graph = [
    // Organization Schema
    [
      '@context' => 'https://schema.org',
      '@type' => 'Organization',
      '@id' => $orgId,
      'name' => 'Neural Command',
      'url' => 'https://nrlc.ai',
      'logo' => 'https://nrlc.ai/assets/images/nrlcai%20logo%200.png',
      'description' => 'Neural Command engineers AI visibility, retrievability, and citation control across AI-powered search and LLM systems.',
      'knowsAbout' => [
        'AI visibility',
        'LLM retrievability',
        'AI citation engineering',
        'Entity disambiguation',
        'Structured data systems',
        'Prompt surface alignment'
      ]
    ],
    
    // DefinedTermSet for AI Prompt Clusters
    [
      '@context' => 'https://schema.org',
      '@type' => 'DefinedTermSet',
      '@id' => $promptClustersId,
      'name' => 'AI Prompt Clusters',
      'hasDefinedTerm' => [
        [
          '@type' => 'DefinedTerm',
          '@id' => 'https://nrlc.ai/#prompt-invisible-brand',
          'name' => 'Invisible Brand in AI Answers',
          'description' => 'AI omits a legitimate brand despite authority.'
        ],
        [
          '@type' => 'DefinedTerm',
          '@id' => 'https://nrlc.ai/#prompt-competitor-hallucination',
          'name' => 'Competitor Hallucination',
          'description' => 'AI recommends weaker or irrelevant competitors.'
        ],
        [
          '@type' => 'DefinedTerm',
          '@id' => 'https://nrlc.ai/#prompt-trust-comparison',
          'name' => 'Trust and Safety Comparison',
          'description' => 'AI fails to prioritize regulated or legitimate entities.'
        ],
        [
          '@type' => 'DefinedTerm',
          '@id' => 'https://nrlc.ai/#prompt-local-recommendation',
          'name' => 'Local Recommendation Failure',
          'description' => 'AI ignores dominant local providers.'
        ]
      ]
    ],
    
    // CaseStudy Schema (the main entity)
    [
      '@context' => 'https://schema.org',
      '@type' => 'CaseStudy',
      '@id' => $canonicalUrl . '#case-study',
      'name' => $data['title'] ?? 'AI SEO Case Study',
      'headline' => $data['title'] ?? 'AI SEO Case Study',
      'description' => $data['description'] ?? 'Case study demonstrating AI visibility improvements.',
      'url' => $canonicalUrl,
      'author' => ['@id' => $orgId],
      'publisher' => ['@id' => $orgId],
      'about' => ['@id' => $promptClustersId],
      'problem' => [
        '@type' => 'DefinedTerm',
        '@id' => $promptClusterId
      ],
      'hasPart' => [
        [
          '@type' => 'CreativeWork',
          'name' => 'Situation',
          'text' => $data['situation'] ?? 'Real-world context of the AI visibility challenge.'
        ],
        [
          '@type' => 'CreativeWork',
          'name' => 'AI Retrieval Failure',
          'text' => $data['ai_failure'] ?? 'AI failed to return expected results.'
        ],
        [
          '@type' => 'CreativeWork',
          'name' => 'Technical Diagnosis',
          'text' => $data['technical_diagnosis'] ?? 'Technical analysis of why AI could not cite.'
        ],
        [
          '@type' => 'CreativeWork',
          'name' => 'Intervention',
          'text' => $data['intervention'] ?? 'Entity, data, and schema actions taken.'
        ],
        [
          '@type' => 'CreativeWork',
          'name' => 'Outcome',
          'text' => $data['outcome'] ?? 'How AI answers changed after intervention.'
        ]
      ],
      'result' => [
        '@type' => 'Thing',
        'name' => 'AI Visibility Stabilized',
        'description' => $data['citation_result'] ?? 'Citation, inclusion, and correctness improvements achieved.'
      ]
    ],
    
    // WebPage Schema (for page-level metadata)
    [
      '@context' => 'https://schema.org',
      '@type' => 'WebPage',
      '@id' => $canonicalUrl . '#webpage',
      'name' => $data['title'] ?? 'AI SEO Case Study',
      'url' => $canonicalUrl,
      'description' => $data['description'] ?? 'Case study demonstrating AI visibility improvements.',
      'isPartOf' => [
        '@type' => 'WebSite',
        '@id' => 'https://nrlc.ai/#website',
        'name' => 'NRLC.ai',
        'url' => 'https://nrlc.ai'
      ],
      'inLanguage' => 'en',
      'about' => ['@id' => $canonicalUrl . '#case-study']
    ],
    
    // BreadcrumbList Schema
    [
      '@context' => 'https://schema.org',
      '@type' => 'BreadcrumbList',
      '@id' => $canonicalUrl . '#breadcrumb',
      'itemListElement' => [
        [
          '@type' => 'ListItem',
          'position' => 1,
          'name' => 'Home',
          'item' => 'https://nrlc.ai/'
        ],
        [
          '@type' => 'ListItem',
          'position' => 2,
          'name' => 'Case Studies',
          'item' => 'https://nrlc.ai/case-studies/'
        ],
        [
          '@type' => 'ListItem',
          'position' => 3,
          'name' => $data['title'] ?? 'Case Study',
          'item' => $canonicalUrl
        ]
      ]
    ]
  ];
  
  return $graph;
}

/**
 * Get prompt cluster metadata
 * 
 * @param string $cluster Prompt cluster identifier
 * @return array Metadata for the prompt cluster
 */
function get_prompt_cluster_metadata(string $cluster): array {
  $clusters = [
    'invisible-brand' => [
      'name' => 'Invisible Brand in AI Answers',
      'description' => 'AI omits a legitimate brand despite authority.',
      'landing_page' => '/ai/brand-not-showing-chatgpt/',
      'canonical_prompts' => [
        'Best software for {industry}',
        'Top {industry} companies',
        'Who provides {service}?'
      ]
    ],
    'competitor-hallucination' => [
      'name' => 'Competitor Hallucination',
      'description' => 'AI recommends weaker or irrelevant competitors.',
      'landing_page' => '/ai/competitors-recommended-instead/',
      'canonical_prompts' => [
        'Best {service} providers',
        'Compare {service} companies',
        'Alternatives to {brand}'
      ]
    ],
    'trust-comparison' => [
      'name' => 'Trust and Safety Comparison',
      'description' => 'AI fails to prioritize regulated or legitimate entities.',
      'landing_page' => '/ai/compliance-trust-answers/',
      'canonical_prompts' => [
        'Most trusted {service} provider',
        'Compliant {industry} companies',
        'Regulated {service} providers'
      ]
    ],
    'local-failure' => [
      'name' => 'Local Recommendation Failure',
      'description' => 'AI ignores dominant local providers.',
      'landing_page' => '/ai/local-business-not-recommended/',
      'canonical_prompts' => [
        'Best {service} near me',
        '{Service} in {city}',
        'Local {industry} providers'
      ]
    ]
  ];
  
  return $clusters[$cluster] ?? $clusters['invisible-brand'];
}

