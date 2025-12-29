<?php

/**
 * Template Helpers
 * 
 * Helper functions and initialization for the template system
 */

require_once __DIR__ . '/../libs/Template.php';

/**
 * Initialize and return a configured template instance
 * 
 * @return Template
 */
function get_template_instance() {
    // Get the base path of the application
    $basePath = dirname(__DIR__);
    
    // Create template instance
    $template = new Template($basePath . '/templates');
    
    // Make commonly used variables available globally
    global $version, $theme, $updateThemeSettings, $lang, $colorTheme, $settings;
    global $customCss, $languages, $mobileNavigation, $userData, $i18n, $isAdmin;
    global $demoMode, $userId, $db, $currencies;
    
    // Set global template variables
    $template->setVars([
        'version' => $version ?? '',
        'theme' => $theme ?? 'automatic',
        'updateThemeSettings' => $updateThemeSettings ?? false,
        'lang' => $lang ?? 'en',
        'colorTheme' => $colorTheme ?? 'blue',
        'settings' => $settings ?? [],
        'customCss' => $customCss ?? '',
        'languages' => $languages ?? [],
        'mobileNavigation' => $mobileNavigation ?? '',
        'userData' => $userData ?? [],
        'i18n' => $i18n ?? [],
        'isAdmin' => $isAdmin ?? false,
        'demoMode' => $demoMode ?? false,
        'userId' => $userId ?? null,
        'db' => $db ?? null,
        'currencies' => $currencies ?? []
    ]);
    
    return $template;
}

/**
 * Helper function to render a page with the main layout
 * 
 * @param string $page Page template name
 * @param array $data Additional data for the page
 */
function render_page($page, array $data = []) {
    $template = get_template_instance();
    $template->setLayout('main');
    $template->display('pages/' . $page, $data);
}

/**
 * Helper function to render a partial template
 * 
 * @param string $partial Partial template name
 * @param array $data Data for the partial
 * @return string
 */
function render_partial($partial, array $data = []) {
    $template = get_template_instance();
    return $template->partial($partial, $data);
}
