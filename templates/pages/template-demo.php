<section class="contain">
    <div class="dashboard">
        <h1><?= $this->escape($demoData['message']) ?></h1>
        
        <div class="demo-intro">
            <p><?= $this->escape($demoData['description']) ?></p>
            <p>Logged in as: <strong><?= $this->escape($currentUser) ?></strong></p>
        </div>

        <div class="demo-features">
            <h2>Template System Features</h2>
            <ul>
                <?php foreach ($demoData['features'] as $feature): ?>
                    <li><?= $this->escape($feature) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="demo-stats">
            <h2>Example Statistics</h2>
            <div class="dashboard-subscriptions-container">
                <div class="dashboard-subscriptions-list">
                    <?php foreach ($demoData['stats'] as $label => $value): ?>
                        <div class="subscription-item thin">
                            <p class="subscription-item-title"><?= $this->escape($label) ?></p>
                            <div class="subscription-item-info">
                                <p class="subscription-item-value">
                                    <?= $this->escape($value) ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="demo-partials">
            <h2>Template Partials Example</h2>
            <p>Partials are reusable components. Below is an example info box partial:</p>
            <?= $this->partial('demo-infobox', [
                'title' => 'Info Box',
                'content' => 'This is a reusable partial component that can be used throughout the application.',
                'icon' => 'fa-info-circle'
            ]) ?>
        </div>

        <div class="demo-code">
            <h2>How It Works</h2>
            <p>This page demonstrates the template system with:</p>
            <ul>
                <li><strong>Main page file</strong>: <code>template-demo.php</code> - Contains only business logic</li>
                <li><strong>Template file</strong>: <code>templates/pages/template-demo.php</code> - Contains only presentation</li>
                <li><strong>Layout file</strong>: <code>templates/layouts/main.php</code> - Contains the overall page structure</li>
                <li><strong>Partial file</strong>: <code>templates/partials/demo-infobox.php</code> - A reusable component</li>
            </ul>
        </div>

        <div class="demo-benefits">
            <h2>Benefits of This Approach</h2>
            <div class="dashboard-subscriptions-container">
                <div class="dashboard-subscriptions-list">
                    <div class="subscription-item">
                        <p class="subscription-item-title">🔒 Security</p>
                        <div class="subscription-item-info">
                            <p class="subscription-item-value">Built-in XSS protection</p>
                        </div>
                    </div>
                    <div class="subscription-item">
                        <p class="subscription-item-title">♻️ Reusability</p>
                        <div class="subscription-item-info">
                            <p class="subscription-item-value">Share components across pages</p>
                        </div>
                    </div>
                    <div class="subscription-item">
                        <p class="subscription-item-title">🧹 Clean Code</p>
                        <div class="subscription-item-info">
                            <p class="subscription-item-value">Separation of concerns</p>
                        </div>
                    </div>
                    <div class="subscription-item">
                        <p class="subscription-item-title">🛠️ Maintainability</p>
                        <div class="subscription-item-info">
                            <p class="subscription-item-value">Easier to modify and test</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="demo-next-steps">
            <h2>Next Steps</h2>
            <p>To use the template system in your own pages:</p>
            <ol>
                <li>Include the template helpers: <code>require_once 'includes/template_helpers.php';</code></li>
                <li>Add your business logic to the main PHP file</li>
                <li>Create a template file in <code>templates/pages/</code></li>
                <li>Render the page: <code>render_page('your-page-name', $data);</code></li>
            </ol>
            <p>See <code>templates/README.md</code> for full documentation.</p>
        </div>
    </div>
</section>
