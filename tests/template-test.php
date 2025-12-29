<?php
/**
 * Simple Template System Test
 * 
 * Tests basic functionality of the template system
 */

require_once __DIR__ . '/../libs/Template.php';

echo "Testing Template System...\n\n";

// Test 1: Basic template rendering
echo "Test 1: Basic Template Instantiation\n";
$template = new Template(__DIR__ . '/../templates');
if ($template instanceof Template) {
    echo "✓ Template instance created successfully\n\n";
} else {
    echo "✗ Failed to create Template instance\n\n";
    exit(1);
}

// Test 2: Set and get variables
echo "Test 2: Set and Get Variables\n";
$template->set('testVar', 'Hello World');
$result = $template->get('testVar');
if ($result === 'Hello World') {
    echo "✓ Variable set and retrieved correctly\n\n";
} else {
    echo "✗ Failed to set/get variable. Expected 'Hello World', got: " . $result . "\n\n";
    exit(1);
}

// Test 3: Set multiple variables
echo "Test 3: Set Multiple Variables\n";
$template->setVars([
    'var1' => 'Value 1',
    'var2' => 'Value 2',
    'var3' => 'Value 3'
]);
if ($template->get('var1') === 'Value 1' && 
    $template->get('var2') === 'Value 2' && 
    $template->get('var3') === 'Value 3') {
    echo "✓ Multiple variables set correctly\n\n";
} else {
    echo "✗ Failed to set multiple variables\n\n";
    exit(1);
}

// Test 4: HTML escaping
echo "Test 4: HTML Escaping\n";
$dangerous = '<script>alert("xss")</script>';
$escaped = $template->escape($dangerous);
if ($escaped === '&lt;script&gt;alert(&quot;xss&quot;)&lt;/script&gt;') {
    echo "✓ HTML properly escaped\n\n";
} else {
    echo "✗ HTML escaping failed. Got: " . $escaped . "\n\n";
    exit(1);
}

// Test 5: Short escape method
echo "Test 5: Short Escape Method (e)\n";
$escaped2 = $template->e($dangerous);
if ($escaped2 === $escaped) {
    echo "✓ Short escape method works\n\n";
} else {
    echo "✗ Short escape method failed\n\n";
    exit(1);
}

// Test 6: Get with default value
echo "Test 6: Get with Default Value\n";
$result = $template->get('nonexistent', 'default_value');
if ($result === 'default_value') {
    echo "✓ Default value returned for nonexistent variable\n\n";
} else {
    echo "✗ Default value test failed. Got: " . $result . "\n\n";
    exit(1);
}

// Test 7: Create a simple test template
echo "Test 7: Simple Template Rendering\n";
$testTemplateDir = '/tmp/wallos-template-test';
if (!is_dir($testTemplateDir)) {
    mkdir($testTemplateDir, 0777, true);
}

// Create a simple template file
$testTemplate = $testTemplateDir . '/test.php';
file_put_contents($testTemplate, '<p><?= $message ?></p>');

// Create instance with test directory
$testTemplate = new Template($testTemplateDir);
$testTemplate->set('message', 'Test successful');
$output = $testTemplate->render('test');

if (trim($output) === '<p>Test successful</p>') {
    echo "✓ Template rendered correctly\n\n";
} else {
    echo "✗ Template rendering failed. Got: " . $output . "\n\n";
    exit(1);
}

// Test 8: Template with layout
echo "Test 8: Template with Layout\n";
$layoutsDir = $testTemplateDir . '/layouts';
if (!is_dir($layoutsDir)) {
    mkdir($layoutsDir, 0777, true);
}

// Create a layout file
file_put_contents($layoutsDir . '/test-layout.php', '<html><body><?= $content ?></body></html>');

// Create content template
file_put_contents($testTemplateDir . '/content.php', '<h1><?= $title ?></h1>');

$layoutTemplate = new Template($testTemplateDir);
$layoutTemplate->setLayout('test-layout');
$layoutTemplate->set('title', 'Test Title');
$layoutOutput = $layoutTemplate->render('content');

if (strpos($layoutOutput, '<html><body><h1>Test Title</h1></body></html>') !== false) {
    echo "✓ Layout rendering works correctly\n\n";
} else {
    echo "✗ Layout rendering failed. Got: " . $layoutOutput . "\n\n";
    exit(1);
}

// Test 9: Partial rendering
echo "Test 9: Partial Rendering\n";
$partialsDir = $testTemplateDir . '/partials';
if (!is_dir($partialsDir)) {
    mkdir($partialsDir, 0777, true);
}

file_put_contents($partialsDir . '/test-partial.php', '<span><?= $name ?></span>');

$partialTemplate = new Template($testTemplateDir);
$partialOutput = $partialTemplate->partial('test-partial', ['name' => 'John']);

if (trim($partialOutput) === '<span>John</span>') {
    echo "✓ Partial rendered correctly\n\n";
} else {
    echo "✗ Partial rendering failed. Got: " . $partialOutput . "\n\n";
    exit(1);
}

// Cleanup
echo "Cleaning up test files...\n";
array_map('unlink', glob($partialsDir . '/*'));
array_map('unlink', glob($layoutsDir . '/*'));
array_map('unlink', glob($testTemplateDir . '/*'));
rmdir($partialsDir);
rmdir($layoutsDir);
rmdir($testTemplateDir);

echo "\n========================================\n";
echo "All tests passed! ✓\n";
echo "========================================\n";
