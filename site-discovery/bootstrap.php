<?php declare(strict_types=1);
spl_autoload_register(function($c){
  $p = __DIR__ . '/lib/' . str_replace('\\','/',$c) . '.php';
  if (is_file($p)) require $p;
});
mb_internal_encoding('UTF-8');

