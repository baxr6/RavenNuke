<?php
// Save this as template_debug.php in /var/www/raven/modules/Forums/admin/
// Access via http://raven.localhost/modules/Forums/admin/template_debug.php

echo "<h2>Template Class Debug</h2>";

// Set up the basic environment
$phpbb_root_path = './../';
$template_root = $phpbb_root_path . 'templates/subSilver/admin';

echo "Template root path: $template_root<br>";
echo "Template root realpath: " . realpath($template_root) . "<br>";
echo "Template root exists: " . (is_dir($template_root) ? 'YES' : 'NO') . "<br>";
echo "page_header.tpl exists: " . (file_exists($template_root . '/page_header.tpl') ? 'YES' : 'NO') . "<br><br>";

// Include the template class
echo "<h3>Loading Template Class</h3>";
if (file_exists($phpbb_root_path . 'includes/template.php')) {
    echo "Including template.php...<br>";
    include_once($phpbb_root_path . 'includes/template.php');
    echo "Template.php included<br>";
} else {
    die("template.php not found at: " . $phpbb_root_path . 'includes/template.php');
}

// Check if Template class exists
if (class_exists('Template')) {
    echo "Template class found<br>";
    
    // Get class info
    $reflection = new ReflectionClass('Template');
    echo "Template class methods: " . implode(', ', array_map(function($m) { return $m->getName(); }, $reflection->getMethods())) . "<br>";
    echo "Template class properties: " . implode(', ', array_map(function($p) { return $p->getName(); }, $reflection->getProperties())) . "<br><br>";
    
    // Try to create template object with debug
    echo "<h3>Creating Template Object</h3>";
    echo "Calling: new Template('$template_root')<br>";
    
    try {
        $template = new Template($template_root);
        echo "Template object created successfully<br>";
        
        // Check all properties
        echo "<h4>Template Object Properties:</h4>";
        $vars = get_object_vars($template);
        foreach ($vars as $key => $value) {
            if (is_string($value) || is_numeric($value)) {
                echo "$key: '$value'<br>";
            } elseif (is_array($value)) {
                echo "$key: [array with " . count($value) . " elements]<br>";
            } elseif (is_object($value)) {
                echo "$key: [object of type " . get_class($value) . "]<br>";
            } else {
                echo "$key: [" . gettype($value) . "]<br>";
            }
        }
        
        // Test the make_filename method directly
        echo "<h4>Testing make_filename method:</h4>";
        if (method_exists($template, 'make_filename')) {
            try {
                echo "Testing with 'admin/page_header.tpl':<br>";
                $result = $template->make_filename('admin/page_header.tpl');
                echo "Result: $result<br>";
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage() . "<br>";
            }
        }
        
        // Test set_filenames method
        echo "<h4>Testing set_filenames method:</h4>";
        if (method_exists($template, 'set_filenames')) {
            try {
                echo "Testing with array('test' => 'admin/page_header.tpl'):<br>";
                $result = $template->set_filenames(array('test' => 'admin/page_header.tpl'));
                echo "Result: " . ($result ? 'SUCCESS' : 'FAILED') . "<br>";
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage() . "<br>";
            }
        }
        
    } catch (Exception $e) {
        echo "Error creating template: " . $e->getMessage() . "<br>";
        echo "Stack trace:<br><pre>" . $e->getTraceAsString() . "</pre>";
    }
    
} else {
    echo "Template class not found after include<br>";
}

// Also check what happens with different paths
echo "<h3>Testing Different Constructor Arguments</h3>";

$test_paths = array(
    $template_root,
    realpath($template_root),
    $template_root . '/',
    realpath($template_root) . '/',
);

foreach ($test_paths as $test_path) {
    echo "Testing path: '$test_path'<br>";
    try {
        $test_template = new Template($test_path);
        $vars = get_object_vars($test_template);
        echo "&nbsp;&nbsp;Root property: '" . (isset($vars['root']) ? $vars['root'] : 'NOT SET') . "'<br>";
    } catch (Exception $e) {
        echo "&nbsp;&nbsp;Error: " . $e->getMessage() . "<br>";
    }
    echo "<br>";
}
?>