<?php
$path = 'C:/xampp/htdocs/addmagpro/resources/views/service_users/welcome.blade.php';
$tmpl = file_get_contents($path);
echo 'Current lines: ' . substr_count($tmpl, PHP_EOL);
