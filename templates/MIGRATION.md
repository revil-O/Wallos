# Template System Migration Guide

This guide helps you convert existing Wallos pages to use the new template system.

## Why Migrate?

- **Better organization**: Separate business logic from presentation
- **Reusability**: Create reusable components (partials)
- **Security**: Built-in XSS protection with output escaping
- **Maintainability**: Easier to modify and test
- **Consistency**: Uniform approach across the application

## Migration Steps

### Step 1: Identify Logic vs. Presentation

Look at your current page and separate:
- **Logic** (PHP code, database queries, calculations) stays in the main file
- **Presentation** (HTML, templates) moves to `templates/pages/`

### Step 2: Convert the Main Page File

**Before:**
```php
<?php
require_once 'includes/header.php';

// Business logic
$name = $_SESSION['username'];
$subscriptions = getSubscriptions($userId);
?>

<section class="contain">
    <h1>Welcome <?= htmlspecialchars($name) ?></h1>
    <ul>
        <?php foreach ($subscriptions as $sub): ?>
            <li><?= htmlspecialchars($sub['name']) ?></li>
        <?php endforeach; ?>
    </ul>
</section>

<?php require_once 'includes/footer.php'; ?>
```

**After:**

Main file (`mypage.php`):
```php
<?php
require_once 'includes/header.php';
require_once 'includes/template_helpers.php';

// Business logic only
$name = $_SESSION['username'];
$subscriptions = getSubscriptions($userId);

// Prepare data for template
$data = [
    'name' => $name,
    'subscriptions' => $subscriptions
];

// Render page with template
render_page('mypage', $data);
?>
```

Template file (`templates/pages/mypage.php`):
```php
<section class="contain">
    <h1>Welcome <?= $this->escape($name) ?></h1>
    <ul>
        <?php foreach ($subscriptions as $sub): ?>
            <li><?= $this->escape($sub['name']) ?></li>
        <?php endforeach; ?>
    </ul>
</section>
```

### Step 3: Create Reusable Partials

If you have repeated UI elements, create partials:

**Create partial** (`templates/partials/subscription-card.php`):
```php
<div class="subscription-card">
    <h3><?= $this->escape($name) ?></h3>
    <p class="price"><?= $this->escape($price) ?></p>
    <p class="date"><?= $this->escape($nextPayment) ?></p>
</div>
```

**Use in template:**
```php
<section class="contain">
    <h2>Your Subscriptions</h2>
    <?php foreach ($subscriptions as $sub): ?>
        <?= $this->partial('subscription-card', [
            'name' => $sub['name'],
            'price' => $sub['price'],
            'nextPayment' => $sub['next_payment']
        ]) ?>
    <?php endforeach; ?>
</section>
```

## Common Patterns

### Pattern 1: Simple Page

**Old:**
```php
<?php
require_once 'includes/header.php';
$message = "Hello World";
?>
<p><?= htmlspecialchars($message) ?></p>
<?php require_once 'includes/footer.php'; ?>
```

**New:**
```php
<?php
require_once 'includes/header.php';
require_once 'includes/template_helpers.php';

render_page('simple', ['message' => 'Hello World']);
?>
```

Template (`templates/pages/simple.php`):
```php
<p><?= $this->escape($message) ?></p>
```

### Pattern 2: Form Page

**Old:**
```php
<?php
require_once 'includes/header.php';
// form processing logic
?>
<form method="post">
    <input type="text" name="name" value="<?= htmlspecialchars($name ?? '') ?>">
    <button type="submit">Submit</button>
</form>
<?php require_once 'includes/footer.php'; ?>
```

**New:**
```php
<?php
require_once 'includes/header.php';
require_once 'includes/template_helpers.php';

// Form processing logic here
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
}

render_page('form', ['name' => $name ?? '']);
?>
```

Template (`templates/pages/form.php`):
```php
<form method="post">
    <input type="text" name="name" value="<?= $this->escape($name) ?>">
    <button type="submit">Submit</button>
</form>
```

### Pattern 3: Dashboard with Multiple Sections

Create partials for each section and compose them in your main template.

## Best Practices

1. **Always escape user input:**
   ```php
   <?= $this->escape($userInput) ?>
   // or shorthand:
   <?= $this->e($userInput) ?>
   ```

2. **Keep templates simple:**
   - Minimal logic in templates
   - Complex calculations in main file

3. **Use descriptive variable names:**
   ```php
   render_page('subscriptions', [
       'activeSubscriptions' => $active,
       'inactiveSubscriptions' => $inactive,
       'totalCost' => $total
   ]);
   ```

4. **Create partials for reusable components:**
   - Navigation elements
   - Cards/widgets
   - Form fields
   - Alerts/notifications

5. **Test your templates:**
   - Check for missing variables
   - Verify proper escaping
   - Test with edge cases (empty arrays, null values)

## Troubleshooting

### Issue: Variable not found in template

**Error:** `Undefined variable: myVar`

**Solution:** Make sure you pass the variable in the data array:
```php
render_page('mypage', ['myVar' => $value]);
```

### Issue: Need to use a global function

**Solution:** Functions are available in templates, but variables need to be passed:
```php
// In main file:
render_page('mypage', [
    'translate' => function($key) use ($i18n) {
        return translate($key, $i18n);
    }
]);

// In template:
<?= $translate('hello') ?>
```

Or better, add commonly used functions to template_helpers.php.

### Issue: Layout not rendering

**Solution:** Make sure you're using `render_page()` which sets the layout automatically:
```php
// This sets layout automatically:
render_page('mypage', $data);

// This doesn't use layout:
$template = get_template_instance();
echo $template->render('pages/mypage', $data);
```

## Gradual Migration

You don't need to convert all pages at once:

1. **Start with new features** - Use templates for all new pages
2. **Convert simple pages first** - Static pages, about pages, etc.
3. **Convert complex pages last** - Settings, admin pages with lots of logic
4. **Keep both approaches working** - Old and new can coexist

## Examples

See these files for complete examples:
- `template-demo.php` - Demo showcasing all features
- `templates/pages/template-demo.php` - Complete template example
- `templates/partials/demo-infobox.php` - Partial example
- `tests/template-test.php` - Unit tests showing API usage

## Getting Help

- Read `templates/README.md` for full API documentation
- Check the demo page at `/template-demo.php`
- Review existing templates in `templates/pages/`
- Ask questions in issues or Discord
