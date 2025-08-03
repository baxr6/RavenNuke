<?php
// Save this as diagnostic.php in /var/www/raven/modules/Forums/admin/
// Then access it via http://raven.localhost/modules/Forums/admin/diagnostic.php

echo "<h2>RavenNuke Forums Admin Diagnostic</h2>";

echo "<h3>1. Current Directory Structure</h3>";
echo "Current working directory: " . getcwd() . "<br>";
echo "Script location: " . __FILE__ . "<br>";

echo "<h3>2. File System Check</h3>";
$current_dir = dirname(__FILE__);
echo "Current admin directory: $current_dir<br>";

// Check for template directories
$template_paths_to_check = array(
    './../templates/subSilver/admin',
    '../templates/subSilver/admin', 
    './templates/subSilver/admin',
    '../../templates/subSilver/admin',
    './../templates/subSilver',
    '../templates/subSilver'
);

foreach ($template_paths_to_check as $path) {
    $real_path = realpath($path);
    echo "Testing path: <code>$path</code><br>";
    echo "&nbsp;&nbsp;Realpath: " . ($real_path ? $real_path : '<span style="color:red">NOT FOUND</span>') . "<br>";
    
    if ($real_path && is_dir($real_path)) {
        echo "&nbsp;&nbsp;Directory contents: ";
        $contents = scandir($real_path);
        $files = array();
        foreach ($contents as $item) {
            if ($item != '.' && $item != '..') {
                $files[] = $item . (is_dir($real_path . '/' . $item) ? '/' : '');
            }
        }
        echo implode(', ', $files) . "<br>";
        
        // Check specifically for page_header.tpl
        if (file_exists($real_path . '/page_header.tpl')) {
            echo "&nbsp;&nbsp;<span style='color:green'>✓ page_header.tpl EXISTS</span><br>";
        } else {
            echo "&nbsp;&nbsp;<span style='color:red'>✗ page_header.tpl MISSING</span><br>";
        }
    }
    echo "<br>";
}

echo "<h3>3. Check Key Files</h3>";
$key_files = array(
    './index.php',
    './pagestart.php', 
    './page_header_admin.php',
    './../common.php',
    './../config.php'
);

foreach ($key_files as $file) {
    echo "File: <code>$file</code> - ";
    if (file_exists($file)) {
        echo "<span style='color:green'>EXISTS</span> (" . filesize($file) . " bytes)<br>";
    } else {
        echo "<span style='color:red'>MISSING</span><br>";
    }
}

echo "<h3>4. Template Class Investigation</h3>";
// Try to include the necessary files to check the Template class
try {
    $phpbb_root_path = './../';
    
    // Try to load the template class
    if (file_exists($phpbb_root_path . 'includes/template.php')) {
        echo "Template class file found<br>";
        include_once($phpbb_root_path . 'includes/template.php');
        
        // Check if Template class exists
        if (class_exists('Template')) {
            echo "Template class loaded successfully<br>";
            
            // Try to create a template object with different paths
            foreach ($template_paths_to_check as $path) {
                if (is_dir($path) && file_exists($path . '/page_header.tpl')) {
                    echo "Attempting to create Template object with path: $path<br>";
                    try {
                        $test_template = new Template($path);
                        echo "&nbsp;&nbsp;SUCCESS - Template object created<br>";
                        echo "&nbsp;&nbsp;Template root property: " . (isset($test_template->root) ? $test_template->root : 'NOT SET') . "<br>";
                        break;
                    } catch (Exception $e) {
                        echo "&nbsp;&nbsp;FAILED - " . $e->getMessage() . "<br>";
                    }
                }
            }
        } else {
            echo "Template class not found after include<br>";
        }
    } else {
        echo "Template class file not found at: " . $phpbb_root_path . 'includes/template.php<br>';
    }
    
} catch (Exception $e) {
    echo "Error during template investigation: " . $e->getMessage() . "<br>";
}

echo "<h3>5. Complete Directory Tree</h3>";
function show_directory_tree($dir, $level = 0) {
    if ($level > 3) return; // Prevent infinite recursion
    
    $contents = scandir($dir);
    foreach ($contents as $item) {
        if ($item == '.' || $item == '..') continue;
        
        $path = $dir . '/' . $item;
        echo str_repeat('&nbsp;&nbsp;', $level) . $item;
        
        if (is_dir($path)) {
            echo "/<br>";
            show_directory_tree($path, $level + 1);
        } else {
            echo "<br>";
        }
    }
}

echo "Starting from admin directory:<br>";
show_directory_tree('.', 0);
?>