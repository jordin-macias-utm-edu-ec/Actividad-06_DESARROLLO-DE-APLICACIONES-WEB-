<?php
$password_clara = '123456';
$hash = password_hash($password_clara, PASSWORD_DEFAULT);
echo "Hash generado para '123456': " . $hash . "\n";
?>