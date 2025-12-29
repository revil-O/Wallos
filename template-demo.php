<?php
/**
 * Template System Demo Page
 * 
 * This page demonstrates the Wallos template system.
 * It can be accessed at /template-demo.php
 */

require_once 'includes/header.php';
require_once 'includes/template_helpers.php';
require_once 'includes/getdbkeys.php';

// Example: Business logic separated from presentation
$demoData = [
    'message' => 'Welcome to the Wallos Template System!',
    'description' => 'This is a demonstration of separating business logic from presentation.',
    'features' => [
        'Clean separation of concerns',
        'Reusable partials',
        'Built-in output escaping',
        'Layout support',
        'Easy to maintain and extend'
    ],
    'stats' => [
        'Total Subscriptions' => 42,
        'Active Users' => 15,
        'Monthly Cost' => '$299.99'
    ]
];

// Additional page-specific data
$pageData = [
    'pageTitle' => 'Template System Demo - Wallos',
    'demoData' => $demoData,
    'currentUser' => $userData['username'] ?? 'Guest'
];

// Render the page using the template system
render_page('template-demo', $pageData);
?>
