<?php
require_once __DIR__.'/../../lib/helpers.php';

$service = $_GET['service'] ?? '';
?>
<main class="container">
  <h1><?=htmlspecialchars(ucwords(str_replace('-',' ',$service)))?></h1>
  <p>Select a city to see localized implementation.</p>
</main>

