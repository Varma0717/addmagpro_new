<?php
$file = 'routes/web.php';
$content = file_get_contents($file);

// Extract all route names
preg_match_all('/->name\([\'"]([^\'"]+)[\'"]\)/', $content, $matches);

$names = $matches[1];
$counts = array_count_values($names);

// Find duplicates
$duplicates = array_filter($counts, fn($count) => $count > 1);

if (empty($duplicates)) {
    echo "✓ No duplicate route names found!\n";
} else {
    echo "✗ Found duplicate route names:\n";
    foreach ($duplicates as $name => $count) {
        echo "  - '$name' appears $count times\n";
    }
}
