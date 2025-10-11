<?php
require_once __DIR__.'/../bootstrap/env.php';
require_once __DIR__.'/../bootstrap/canonical.php';
require_once __DIR__.'/../bootstrap/router.php';

canonical_guard();
route_request();

