<?php
file_put_contents('/tmp/api_test.log', "API called at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
header('Content-Type: text/plain');
echo "API test working\n";
?>
