<?php
require_once __DIR__.'/helpers.php';

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
    'url'=>absolute_url('/'),
    'logo'=>absolute_url('/assets/logo.png'),
    'sameAs'=>['https://www.linkedin.com/company/neural-command/']
  ];
}

function ld_website_with_searchaction(): array {
  return [
    '@context'=>'https://schema.org',
    '@type'=>'WebSite',
    'url'=>absolute_url('/'),
    'name'=>'NRLC.ai',
    'potentialAction'=>[
      '@type'=>'SearchAction',
      'target'=>absolute_url('/?q={search_term_string}'),
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
    'url'=>absolute_url('/'),
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
    'provider'=>['@type'=>'Organization','name'=>'NRLC.ai','url'=>absolute_url('/')],
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
      'sameAs'=>absolute_url('/'),
      'logo'=>absolute_url('/assets/logo.png')
    ],
    'jobLocation'=>[
      '@type'=>'Place',
      'address'=>[
        '@type'=>'PostalAddress',
        'addressLocality'=>$cityCtx['city_name'],
        'addressRegion'=>$cityCtx['subdivision'],
        'addressCountry'=>$cityCtx['country']
      ]
    ],
    'applicantLocationRequirements'=>[
      '@type'=>'Country','name'=>$cityCtx['country']
    ]
  ];
}

