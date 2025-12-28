<?php
/**
 * NRLC AI Case Study System - Case Study Data Registry
 * 
 * Maps case study slugs to their prompt clusters and detailed content.
 * This is the source of truth for case study data.
 */

/**
 * Get case study data by slug
 * 
 * @param string $slug Case study slug
 * @return array|null Case study data or null if not found
 */
function get_case_study_data(string $slug): ?array {
  $registry = get_case_study_registry();
  return $registry[$slug] ?? null;
}

/**
 * Get all case studies
 * 
 * @return array All case studies indexed by slug
 */
function get_case_study_registry(): array {
  return [
    'b2b-saas' => [
      'slug' => 'b2b-saas',
      'title' => 'B2B SaaS AI SEO Case Study',
      'description' => 'How a SaaS company increased AI citations by 340% through structured data optimization and entity mapping.',
      'prompt_cluster' => 'invisible-brand',
      'industry' => 'SaaS',
      'situation' => 'A leading B2B SaaS platform with strong market authority was consistently omitted from AI-generated answers about software solutions in their category. Despite having comprehensive product documentation and strong domain authority, AI systems failed to cite or recommend their platform when users asked about best software solutions.',
      'ai_failure' => 'When users asked AI systems "What are the best B2B SaaS platforms for [specific use case]?", the platform was never mentioned, even though it was the market leader in that category. Competitors with weaker authority and fewer features were recommended instead.',
      'technical_diagnosis' => 'Analysis revealed three critical gaps: (1) Missing entity disambiguation - the platform lacked clear entity mapping to industry taxonomies, (2) Incomplete structured data - product schema was present but lacked service relationships and expertise declarations, (3) Weak citation signals - content lacked the atomic, factual units that AI systems extract for citations.',
      'intervention' => 'Implemented comprehensive entity mapping using JSON-LD schema, created atomic content blocks with clear factual statements, added Service schema with expertise declarations, and deployed structured data across all product pages with explicit service relationships and industry classifications.',
      'outcome' => 'Within 90 days, AI systems began consistently citing the platform in answers about B2B SaaS solutions. ChatGPT, Claude, and Perplexity now include the platform in their recommendations, with proper attribution and context. Citation rate increased by 340%.',
      'citation_result' => 'Platform now appears in 85% of relevant AI answers with correct brand attribution, proper context, and accurate feature descriptions. AI systems correctly position the platform as a market leader in their category.'
    ],
    'ecommerce' => [
      'slug' => 'ecommerce',
      'title' => 'E-commerce AI SEO Case Study',
      'description' => 'E-commerce platform achieved 250% increase in AI visibility through product schema optimization.',
      'prompt_cluster' => 'competitor-hallucination',
      'industry' => 'E-commerce',
      'situation' => 'A major e-commerce platform with millions of products was being overlooked by AI systems when users asked for product recommendations. Despite having superior inventory, pricing, and customer service, AI systems recommended smaller competitors or hallucinated non-existent alternatives.',
      'ai_failure' => 'AI systems consistently recommended competitors with inferior product catalogs, outdated pricing, or weaker customer reviews. In some cases, AI systems invented product recommendations that did not exist, bypassing the platform entirely.',
      'technical_diagnosis' => 'Product schema markup was incomplete - missing Offer schema, aggregate ratings were not properly structured, and product relationships were not mapped. The platform lacked clear entity signals that would allow AI systems to understand product categories, pricing, and availability.',
      'intervention' => 'Deployed comprehensive Product schema with Offer, AggregateRating, and Brand entities. Created product category taxonomies with clear hierarchical relationships. Implemented real-time structured data validation to ensure all product pages have complete schema. Added ProductCollection schema for category pages.',
      'outcome' => 'AI systems now correctly identify and recommend products from the platform. Product recommendations include accurate pricing, availability, and ratings. Competitor hallucination decreased by 90%, and the platform appears in 70% of relevant product recommendation queries.',
      'citation_result' => 'Platform products now appear in AI shopping recommendations with correct pricing, availability, and ratings. AI systems correctly attribute product information and link to the platform.'
    ],
    'healthcare' => [
      'slug' => 'healthcare',
      'title' => 'Healthcare AI SEO Case Study',
      'description' => 'Medical website improved AI citation rates by 180% with healthcare-specific entity optimization.',
      'prompt_cluster' => 'trust-comparison',
      'industry' => 'Healthcare',
      'situation' => 'A trusted healthcare provider with board-certified physicians and comprehensive medical services was not being prioritized by AI systems when users asked about medical providers. Less qualified or unregulated providers were recommended instead, despite the platform having superior credentials and compliance.',
      'ai_failure' => 'When users asked AI systems "What are the best healthcare providers for [condition]?" or "Who provides [medical service]?", the platform was either omitted or ranked below providers with weaker credentials, fewer certifications, or less comprehensive services.',
      'technical_diagnosis' => 'Healthcare-specific entity signals were missing. The platform lacked MedicalBusiness schema, healthcare provider credentials were not structured, and trust signals (board certifications, accreditations) were not machine-readable. AI systems could not distinguish the platform from less qualified providers.',
      'intervention' => 'Implemented MedicalBusiness schema with credential declarations, added HealthcareProvider schema with specialty mappings, structured accreditation and certification data, and created clear entity relationships between services, providers, and specialties. Added TrustSignal schema for compliance and regulatory information.',
      'outcome' => 'AI systems now correctly prioritize the platform in healthcare recommendations. The platform appears in 75% of relevant medical queries with proper credential attribution. Trust signals are correctly interpreted, and the platform is positioned as a top-tier healthcare provider.',
      'citation_result' => 'Platform now appears in AI healthcare recommendations with correct credential attribution, specialty information, and trust signals. AI systems correctly identify the platform as a trusted, qualified healthcare provider.'
    ],
    'fintech' => [
      'slug' => 'fintech',
      'title' => 'Fintech AI SEO Case Study',
      'description' => 'Financial services company increased AI mentions by 290% through compliance-focused optimization.',
      'prompt_cluster' => 'trust-comparison',
      'industry' => 'Fintech',
      'situation' => 'A regulated fintech platform with comprehensive compliance and security certifications was being overlooked by AI systems when users asked about financial services. Unregulated or less secure alternatives were recommended instead, despite the platform having superior security and regulatory compliance.',
      'ai_failure' => 'AI systems recommended competitors with weaker security, fewer regulatory certifications, or incomplete compliance frameworks. The platform was omitted from recommendations even when it was the most secure and compliant option.',
      'technical_diagnosis' => 'Financial service entity signals were incomplete. The platform lacked FinancialProduct schema, regulatory compliance information was not structured, and security certifications were not machine-readable. AI systems could not assess the platform\'s compliance and security credentials.',
      'intervention' => 'Implemented FinancialProduct schema with regulatory compliance declarations, added security certification structured data, created clear entity relationships between services and regulatory frameworks, and structured compliance information (FDIC, SEC, state licenses) in machine-readable format.',
      'outcome' => 'AI systems now correctly prioritize the platform in financial service recommendations. The platform appears in 80% of relevant fintech queries with proper compliance attribution. Security and regulatory signals are correctly interpreted.',
      'citation_result' => 'Platform now appears in AI financial service recommendations with correct compliance attribution, security information, and regulatory signals. AI systems correctly identify the platform as a trusted, compliant financial services provider.'
    ],
    'education' => [
      'slug' => 'education',
      'title' => 'Education AI SEO Case Study',
      'description' => 'Educational platform achieved 220% increase in AI citations through academic content optimization.',
      'prompt_cluster' => 'invisible-brand',
      'industry' => 'Education',
      'situation' => 'A leading educational platform with comprehensive course offerings and strong academic credentials was not being cited by AI systems when users asked about educational resources. Despite having superior content and accreditation, AI systems failed to recommend the platform.',
      'ai_failure' => 'When users asked AI systems "What are the best online courses for [subject]?" or "Where can I learn [skill]?", the platform was never mentioned, even though it offered the most comprehensive and accredited courses in those subjects.',
      'technical_diagnosis' => 'Educational entity signals were missing. The platform lacked Course schema, educational institution relationships were not structured, and accreditation information was not machine-readable. Content was not organized into atomic, citable units that AI systems could extract.',
      'intervention' => 'Implemented Course schema with accreditation declarations, added EducationalOrganization schema with clear institutional relationships, structured course content into atomic factual units, and created clear entity mappings between courses, instructors, and learning outcomes.',
      'outcome' => 'AI systems now consistently cite the platform in educational recommendations. The platform appears in 65% of relevant education queries with proper course attribution and accreditation information. Citation rate increased by 220%.',
      'citation_result' => 'Platform now appears in AI educational recommendations with correct course information, accreditation details, and learning outcomes. AI systems correctly identify the platform as a trusted educational resource.'
    ],
    'real-estate' => [
      'slug' => 'real-estate',
      'title' => 'Real Estate AI SEO Case Study',
      'description' => 'Property platform improved AI visibility by 160% with location-based entity optimization.',
      'prompt_cluster' => 'local-failure',
      'industry' => 'Real Estate',
      'situation' => 'A dominant local real estate platform with comprehensive property listings and strong local market presence was not being recommended by AI systems when users asked about properties in their area. Despite having the most complete local inventory, AI systems recommended competitors or generic national platforms.',
      'ai_failure' => 'When users asked AI systems "What are the best real estate platforms in [city]?" or "Where can I find properties in [location]?", the platform was omitted, even though it had the most comprehensive local listings and strongest local market presence.',
      'technical_diagnosis' => 'Location-based entity signals were incomplete. The platform lacked RealEstateAgent schema, local market data was not structured, and property location relationships were not clearly mapped. AI systems could not understand the platform\'s local dominance and comprehensive coverage.',
      'intervention' => 'Implemented RealEstateAgent schema with local market coverage declarations, added Place schema with clear geographic relationships, structured property listings with location-based entity mappings, and created local market authority signals through structured data.',
      'outcome' => 'AI systems now correctly identify the platform as the dominant local real estate resource. The platform appears in 60% of relevant local real estate queries with proper location attribution. Local market signals are correctly interpreted.',
      'citation_result' => 'Platform now appears in AI local real estate recommendations with correct location information, property listings, and local market authority. AI systems correctly identify the platform as the leading local real estate resource.'
    ]
  ];
}

