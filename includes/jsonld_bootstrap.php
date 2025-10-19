<?php
declare(strict_types=1);
/**
 * Put this single line in your base layout <head>:
 *   <?php require_once __DIR__.'/includes/jsonld_bootstrap.php'; ?>
 * Optional before-include overrides:
 *   <?php $pageTitle='Custom Title'; $pageDesc='Custom description'; ?>
 */
require_once __DIR__.'/jsonld_auto.php';
jsonld_for_request(['emitCanonical'=>true]);


