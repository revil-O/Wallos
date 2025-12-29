# Wallos Template System

The Wallos template system provides a clean separation between business logic and presentation layers, making the codebase more maintainable and easier to understand.

## Overview

The template system consists of:
- **Template Engine** (`libs/Template.php`) - Core rendering engine
- **Template Helpers** (`includes/template_helpers.php`) - Helper functions and initialization
- **Layouts** (`templates/layouts/`) - Page structure templates
- **Partials** (`templates/partials/`) - Reusable component templates
- **Pages** (`templates/pages/`) - Individual page content templates

## Directory Structure

```
templates/
├── layouts/          # Full page layouts (header, footer, etc.)
│   └── main.php      # Main application layout
├── partials/         # Reusable components
│   └── ...
└── pages/            # Page-specific content
    └── ...
```

## Basic Usage

### Using the Template System

1. **In your PHP page file**, include the necessary setup and helper:

```php
<?php
require_once 'includes/header.php';  // Loads session, auth, settings
require_once 'includes/template_helpers.php';

// Your business logic here
$data = [
    'pageTitle' => 'My Page Title',
    'myVariable' => 'Some value'
];

// Render the page with the main layout
render_page('mypage', $data);
?>
```

2. **Create your page template** in `templates/pages/mypage.php`:

```php
<section class="contain">
    <h1><?= $this->escape($pageTitle) ?></h1>
    <p><?= $myVariable ?></p>
</section>
```

### Advanced Features

#### Using Partials

Partials are reusable template components. To use a partial:

```php
<?= $this->partial('subscription-card', ['subscription' => $sub]) ?>
```

#### Escaping Output

Always escape user-provided content:

```php
<?= $this->escape($userInput) ?>
<!-- or use the shorthand -->
<?= $this->e($userInput) ?>
```

#### Custom Layouts

To use a different layout:

```php
$template = get_template_instance();
$template->setLayout('custom-layout');
$template->display('pages/mypage', $data);
```

#### Without Layout

To render a template without any layout:

```php
$template = get_template_instance();
echo $template->render('pages/mypage', $data);
```

## API Reference

### Template Class Methods

- **`set($name, $value)`** - Set a single variable
- **`setVars(array $vars)`** - Set multiple variables
- **`get($name, $default = null)`** - Get a variable value
- **`setLayout($layout)`** - Set the layout to use
- **`render($template, array $data = [])`** - Render a template and return the output
- **`display($template, array $data = [])`** - Render and output a template
- **`partial($partial, array $data = [])`** - Render a partial template
- **`escape($string)`** / **`e($string)`** - Escape HTML special characters

### Helper Functions

- **`get_template_instance()`** - Get a configured Template instance with global variables
- **`render_page($page, array $data = [])`** - Render a page with the main layout
- **`render_partial($partial, array $data = [])`** - Render a partial template

## Migration Guide

### Converting Existing Pages

1. **Separate logic from presentation:**
   - Keep all PHP logic at the top of your file
   - Move HTML to a template file

2. **Before:**
```php
<?php
require_once 'includes/header.php';
$name = "John";
?>
<section>
    <h1>Hello <?= $name ?></h1>
</section>
<?php require_once 'includes/footer.php'; ?>
```

3. **After:**

Main file (e.g., `mypage.php`):
```php
<?php
require_once 'includes/header.php';
require_once 'includes/template_helpers.php';

$name = "John";

render_page('mypage', ['name' => $name]);
?>
```

Template file (`templates/pages/mypage.php`):
```php
<section>
    <h1>Hello <?= $this->escape($name) ?></h1>
</section>
```

## Benefits

1. **Separation of Concerns** - Business logic and presentation are clearly separated
2. **Reusability** - Partials can be reused across multiple pages
3. **Maintainability** - Easier to modify layouts without touching logic
4. **Security** - Built-in output escaping helps prevent XSS attacks
5. **Testability** - Logic can be tested independently of presentation

## Examples

See the converted `index.php` for a complete example of using the template system.
