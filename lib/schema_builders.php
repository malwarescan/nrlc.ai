<?php
require_once __DIR__.'/helpers.php';
require_once __DIR__.'/SchemaFixes.php';

use NRLC\Schema\SchemaFixes;

function base_schemas(): array {
  return [
    ld_organization(),
    ld_website_with_searchaction(),
    ld_breadcrumbs(),
  ];
}

function ld_organization(): array {
  return [
    '@context'=>'https://schema.org',
    '@type'=>'Organization',
    'name'=>'NRLC.ai',
    'url'=>SchemaFixes::ensureHttps(absolute_url('/')),
    'logo'=>SchemaFixes::ensureHttps(absolute_url('/assets/logo.png')),
    'sameAs'=>['https://www.linkedin.com/company/neural-command/']
  ];
}

function ld_website_with_searchaction(): array {
  return [
    '@context'=>'https://schema.org',
    '@type'=>'WebSite',
    'url'=>SchemaFixes::ensureHttps(absolute_url('/')),
    'name'=>'NRLC.ai',
    'potentialAction'=>[
      '@type'=>'SearchAction',
      'target'=>SchemaFixes::ensureHttps(absolute_url('/?q={search_term_string}')),
      'query-input'=>'required name=search_term_string'
    ]
  ];
}

function ld_breadcrumbs(): array {
  $crumbs = current_breadcrumbs();
  $items = [];
  $i=1;
  foreach ($crumbs as $c) {
    $items[] = ['@type'=>'ListItem','position'=>$i++,'name'=>$c['name'],'item'=>$c['url']];
  }
  return ['@context'=>'https://schema.org','@type'=>'BreadcrumbList','itemListElement'=>$items];
}

function ld_faq(array $faqs): array {
  return [
    '@context'=>'https://schema.org',
    '@type'=>'FAQPage',
    'mainEntity'=> array_map(function($f){
      return ['@type'=>'Question','name'=>$f['q'],'acceptedAnswer'=>['@type'=>'Answer','text'=>$f['a']]];
    }, $faqs)
  ];
}

function ld_local_business(?array $cityCtx): array {
  return [
    '@context'=>'https://schema.org',
    '@type'=>'LocalBusiness',
    'name'=>'NRLC.ai',
    'url'=>SchemaFixes::ensureHttps(absolute_url('/')),
    'image'=>SchemaFixes::ensureHttps(absolute_url('/assets/images/nrlcai logo 0.png')),
    'logo'=>SchemaFixes::ensureHttps(absolute_url('/assets/logo.png')),
    'areaServed'=> $cityCtx ? [
      '@type'=>'AdministrativeArea',
      'name'=>$cityCtx['city_name'].' '.$cityCtx['country']
    ] : null,
    'telephone'=>'+1-844-568-4624'
  ];
}

/**
 * Service JSON-LD with nested OfferCatalog of pain-point solutions.
 * $desc should be the deterministic, city-aware description text.
 */
function ld_service(array $service, ?array $cityCtx, array $painPoints, string $desc): array {
  $offers = array_map(function($pp){
    return [
      '@type'=>'Offer',
      'itemOffered'=>[
        '@type'=>'Service',
        'name'=>$pp['pain_point'],
        'description'=>$pp['solution']
      ]
    ];
  }, $painPoints);

  return [
    '@context'=>'https://schema.org',
    '@type'=>'Service',
    'serviceType'=>$service['name'],
    'name'=>$service['name'] . ($cityCtx ? " in ".$cityCtx['city_name'] : ''),
    'description'=>$desc,
    'provider'=>['@type'=>'Organization','name'=>'NRLC.ai','url'=>SchemaFixes::ensureHttps(absolute_url('/'))],
    'areaServed'=>$cityCtx ? [
      '@type'=>'City',
      'name'=>$cityCtx['city_name'],
      'containedInPlace'=>['@type'=>'Country','name'=>$cityCtx['country']]
    ] : null,
    'hasOfferCatalog'=>[
      '@type'=>'OfferCatalog',
      'name'=>'Pain Point Solutions',
      'itemListElement'=>$offers
    ],
    'additionalType'=>'https://schema.org/ProfessionalService'
  ];
}

function ld_jobposting(array $job, array $cityCtx): array {
  return [
    '@context'=>'https://schema.org',
    '@type'=>'JobPosting',
    'title'=>$job['title'],
    'description'=>$job['description_html'],
    'datePosted'=>$job['datePosted'],
    'validThrough'=>$job['validThrough'],
    'employmentType'=>$job['employmentType'],
    'hiringOrganization'=>[
      '@type'=>'Organization',
      'name'=>'NRLC.ai',
      'sameAs'=>SchemaFixes::ensureHttps(absolute_url('/')),
      'logo'=>SchemaFixes::ensureHttps(absolute_url('/assets/logo.png'))
    ],
    'jobLocation'=>[
      '@type'=>'Place',
      'address'=>[
        '@type'=>'PostalAddress',
        'streetAddress'=>$cityCtx['street_address'] ?? 'Remote',
        'addressLocality'=>$cityCtx['city_name'],
        'addressRegion'=>$cityCtx['subdivision'],
        'postalCode'=>$cityCtx['postal_code'] ?? '',
        'addressCountry'=>$cityCtx['country']
      ]
    ],
    'applicantLocationRequirements'=>[
      '@type'=>'Country','name'=>$cityCtx['country']
    ]
  ];
}

function ld_service_hefty(array $ctx): array {
  // $ctx: service, city, url, currency, price (optional), faqs[], offers[]
  $name = ucfirst(str_replace('-',' ', $ctx['service'])) . " — " . ucwords(str_replace('-',' ', $ctx['city']));
  $desc = "Hefty, locally-relevant coverage of {$ctx['service']} in ".ucwords(str_replace('-',' ',$ctx['city']))." including crawl clarity, schema depth, and LLM seeding.";
  $offers = array_map(fn($o)=>[
    "@type"=>"Offer",
    "name"=>$o['headline']??"Remediation",
    "description"=>($o['solution']??'')." Impact: ".($o['impact']??''),
    "category"=>"SEO",
  ], $ctx['offers'] ?? []);
  $faqItems = array_map(fn($f)=>[
    "@type"=>"Question",
    "name"=>$f['q'],
    "acceptedAnswer"=>["@type"=>"Answer","text"=>$f['a']]
  ], $ctx['faqs'] ?? []);
  return [
    "@context"=>"https://schema.org",
    "@type"=>"Service",
    "name"=>$name,
    "description"=>$desc,
    "areaServed"=>$ctx['city'],
    "provider"=>["@type"=>"Organization","name"=>"NRLC.ai"],
    "offers"=>[
      "@type"=>"OfferCatalog",
      "name"=>"Pain-point Solutions",
      "itemListElement"=>$offers
    ],
    "mainEntityOfPage"=>$ctx['url'],
    // FAQ schema should be emitted as a separate top-level FAQPage entity, not nested.
  ];
}

function ld_faqpage(array $faqs): array {
  return [
    "@context"=>"https://schema.org",
    "@type"=>"FAQPage",
    "mainEntity"=>array_map(fn($f)=>[
      "@type"=>"Question","name"=>$f['q'],
      "acceptedAnswer"=>["@type"=>"Answer","text"=>$f['a']]
    ], $faqs)
  ];
}
