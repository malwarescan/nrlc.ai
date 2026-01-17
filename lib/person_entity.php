<?php
/**
 * Joel Maldonado Entity Home - Global Person ID Constants
 * 
 * NON-NEGOTIABLE: These IDs are locked and must never change.
 * All authored content across NRLC ecosystem references these canonical IDs.
 */

// Canonical entity home URL (locale-prefixed)
define('JOEL_ENTITY_HOME_URL', 'https://nrlc.ai/en-us/about/joel-maldonado/');

// Canonical Person @id (the ONE global identifier)
define('JOEL_PERSON_ID', 'https://nrlc.ai/en-us/about/joel-maldonado/#person');

// ProfilePage @id
define('JOEL_PROFILEPAGE_ID', 'https://nrlc.ai/en-us/about/joel-maldonado/#profilepage');

// Organization @id (already exists)
define('NRLC_ORG_ID', 'https://nrlc.ai/#organization');

/**
 * Get canonical Person author object for schema markup
 * 
 * Use this function in all Article/BlogPosting schemas to reference
 * the canonical Person entity without minting new Person IDs.
 * 
 * @return array Person schema object with @id reference
 */
function joel_person_author(): array {
  return [
    '@id' => JOEL_PERSON_ID,
    '@type' => 'Person',
    'name' => 'Joel David Maldonado',
    'url' => JOEL_ENTITY_HOME_URL
  ];
}
