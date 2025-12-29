<?php

/**
 * Template Engine for Wallos
 * 
 * A lightweight template system that separates business logic from presentation.
 * Supports nested templates, layouts, and partials.
 */
class Template
{
    private $templateDir;
    private $layoutsDir;
    private $partialsDir;
    private $vars = [];
    private $layout = null;

    /**
     * Initialize the template engine
     * 
     * @param string $templateDir Base directory for templates
     */
    public function __construct($templateDir = 'templates')
    {
        $this->templateDir = rtrim($templateDir, '/');
        $this->layoutsDir = $this->templateDir . '/layouts';
        $this->partialsDir = $this->templateDir . '/partials';
    }

    /**
     * Set a variable for use in templates
     * 
     * @param string $name Variable name
     * @param mixed $value Variable value
     * @return self
     */
    public function set($name, $value)
    {
        $this->vars[$name] = $value;
        return $this;
    }

    /**
     * Set multiple variables at once
     * 
     * @param array $vars Associative array of variables
     * @return self
     */
    public function setVars(array $vars)
    {
        $this->vars = array_merge($this->vars, $vars);
        return $this;
    }

    /**
     * Get a variable value
     * 
     * @param string $name Variable name
     * @param mixed $default Default value if variable doesn't exist
     * @return mixed
     */
    public function get($name, $default = null)
    {
        return $this->vars[$name] ?? $default;
    }

    /**
     * Set the layout template
     * 
     * @param string $layout Layout filename (without .php extension)
     * @return self
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
        return $this;
    }

    /**
     * Render a template file
     * 
     * @param string $template Template filename (without .php extension)
     * @param array $data Additional data to pass to template
     * @return string Rendered template
     */
    public function render($template, array $data = [])
    {
        $templateFile = $this->templateDir . '/' . $template . '.php';
        
        if (!file_exists($templateFile)) {
            throw new Exception("Template file not found: {$templateFile}");
        }

        // Merge additional data with existing variables
        $data = array_merge($this->vars, $data);

        // Extract variables to local scope
        extract($data, EXTR_SKIP);

        // Start output buffering
        ob_start();

        // Include the template file
        include $templateFile;

        // Get the rendered content
        $content = ob_get_clean();

        // If a layout is set, render the content within the layout
        if ($this->layout !== null) {
            $layoutFile = $this->layoutsDir . '/' . $this->layout . '.php';
            
            if (!file_exists($layoutFile)) {
                throw new Exception("Layout file not found: {$layoutFile}");
            }

            // Make content available to layout
            $layoutData = array_merge($data, ['content' => $content]);
            extract($layoutData, EXTR_SKIP);

            ob_start();
            include $layoutFile;
            $content = ob_get_clean();
        }

        return $content;
    }

    /**
     * Render and output a template
     * 
     * @param string $template Template filename (without .php extension)
     * @param array $data Additional data to pass to template
     */
    public function display($template, array $data = [])
    {
        echo $this->render($template, $data);
    }

    /**
     * Include a partial template
     * 
     * @param string $partial Partial filename (without .php extension)
     * @param array $data Data to pass to the partial
     * @return string Rendered partial
     */
    public function partial($partial, array $data = [])
    {
        $partialFile = $this->partialsDir . '/' . $partial . '.php';
        
        if (!file_exists($partialFile)) {
            throw new Exception("Partial file not found: {$partialFile}");
        }

        // Merge with existing variables
        $data = array_merge($this->vars, $data);
        
        extract($data, EXTR_SKIP);

        ob_start();
        include $partialFile;
        return ob_get_clean();
    }

    /**
     * Escape HTML special characters for safe output
     * 
     * @param string $string String to escape
     * @return string Escaped string
     */
    public function escape($string)
    {
        return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
    }

    /**
     * Alias for escape method (shorthand)
     * 
     * @param string $string String to escape
     * @return string Escaped string
     */
    public function e($string)
    {
        return $this->escape($string);
    }
}
