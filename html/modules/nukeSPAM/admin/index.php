<?php
/*
 * nukeSPAM(tm)
 *
 * Copyright (c) 2012, Kevin Guske  http://nukeSEO.com
 *
 * This program is free software. You can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, version 2 of the license.
 *
 * Modernized for PHP 8+ and MySQL 8+
 */

// Install necessary tables, default configuration
if (!function_exists('seoCheckInstall')) {
    function seoCheckInstall() {
        // Use existing PHP-Nuke database connection
        global $prefix, $sitename, $db;
        define('nukeSPAM_version', '2.0.0');
        
        // Helper function to execute queries safely
        function executeQuery($query, $params = []) {
            global $db;
            
            // Check if we have mysqli or PDO available
            if (isset($db) && is_object($db)) {
                // Try mysqli first
                if ($db instanceof mysqli) {
                    if (!empty($params)) {
                        $stmt = $db->prepare($query);
                        if ($stmt) {
                            if (!empty($params)) {
                                $types = str_repeat('s', count($params));
                                $stmt->bind_param($types, ...$params);
                            }
                            $result = $stmt->execute();
                            if ($query_type = strtoupper(substr(trim($query), 0, 6))) {
                                if ($query_type === 'SELECT') {
                                    return $stmt->get_result();
                                }
                            }
                            return $result;
                        }
                    } else {
                        return $db->query($query);
                    }
                }
                // Try PDO
                elseif ($db instanceof PDO) {
                    if (!empty($params)) {
                        $stmt = $db->prepare($query);
                        return $stmt->execute($params);
                    } else {
                        return $db->query($query);
                    }
                }
            }
            
            // Fallback to legacy functions if available (not recommended but for compatibility)
            if (function_exists('sql_query')) {
                return sql_query($query);
            }
            
            throw new Exception("No database connection available");
        }
        
        // Helper function to check if table exists
        function tableExists($tableName) {
            global $prefix;
            try {
                $result = executeQuery("SELECT 1 FROM `{$tableName}` LIMIT 1");
                return $result !== false;
            } catch (Exception $e) {
                return false;
            }
        }
        
        try {
            // Create seo_config table if it doesn't exist
            if (!tableExists("{$prefix}_seo_config")) {
                $createSQL = "CREATE TABLE `{$prefix}_seo_config` (
                    `config_type` VARCHAR(150) NOT NULL,
                    `config_name` VARCHAR(150) NOT NULL,
                    `config_value` TEXT NOT NULL,
                    PRIMARY KEY (`config_type`, `config_name`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
                
                executeQuery($createSQL);
            }

            // Check if nukeSPAM config exists
            $checkResult = executeQuery("SELECT COUNT(*) as count FROM `{$prefix}_seo_config` WHERE config_type = 'nukeSPAM'");
            $configExists = false;
            
            if ($checkResult) {
                if (is_object($checkResult) && method_exists($checkResult, 'fetch_assoc')) {
                    // mysqli result
                    $row = $checkResult->fetch_assoc();
                    $configExists = $row['count'] > 0;
                } elseif (is_object($checkResult) && method_exists($checkResult, 'fetchColumn')) {
                    // PDO result
                    $configExists = $checkResult->fetchColumn() > 0;
                }
            }
            
            if (!$configExists) {
                // Insert default configuration values
                $configValues = [
                    'baseMatch' => '',
                    'debug' => '0',
                    'logToDB' => '0',
                    'logToTextFile' => '0',
                    'theme' => 'smoothness',
                    'use_reg' => '1',
                    'usefSpamList' => '1',
                    'useStopForumSpam' => '1',
                    'useBotScout' => '1',
                    'useDNSBL' => '1',
                    'useDroneACH' => '1',
                    'useHTTPBLACH' => '1',
                    'useSpamACH' => '1',
                    'useZeusACH' => '1',
                    'useAHBL' => '1',
                    'useBLDE' => '1',
                    'useProjectHoneyPot' => '1',
                    'useSorbs' => '1',
                    'useSpamHaus' => '1',
                    'useSpamCop' => '1',
                    'useDroneBL' => '1',
                    'useTornevall' => '1',
                    'useEFNet' => '1',
                    'useTor' => '1',
                    'keyfSpamList' => '',
                    'keyStopForumSpam' => '',
                    'keyBotScout' => '',
                    'keyProjectHoneyPot' => '',
                    'version_check' => '0',
                    'version_newest' => nukeSPAM_version,
                    'version_number' => nukeSPAM_version,
                    'version_url' => 'http://nukeSEO.com/modules.php?name=Downloads',
                    'version_notes' => ''
                ];
                
                foreach ($configValues as $name => $value) {
                    $insertSQL = "INSERT INTO `{$prefix}_seo_config` (config_type, config_name, config_value) VALUES ('nukeSPAM', '{$name}', '{$value}')";
                    executeQuery($insertSQL);
                }
            }

            // Update version number if needed
            $versionResult = executeQuery("SELECT config_value FROM `{$prefix}_seo_config` WHERE config_type = 'nukeSPAM' AND config_name = 'version_number'");
            $needsUpdate = true;
            
            if ($versionResult) {
                if (is_object($versionResult) && method_exists($versionResult, 'fetch_assoc')) {
                    // mysqli result
                    $row = $versionResult->fetch_assoc();
                    $needsUpdate = $row['config_value'] !== nukeSPAM_version;
                } elseif (is_object($versionResult) && method_exists($versionResult, 'fetchColumn')) {
                    // PDO result
                    $needsUpdate = $versionResult->fetchColumn() !== nukeSPAM_version;
                }
            }
            
            if ($needsUpdate) {
                $updateSQL = "UPDATE `{$prefix}_seo_config` SET config_value = '" . nukeSPAM_version . "' WHERE config_type = 'nukeSPAM' AND config_name = 'version_number'";
                executeQuery($updateSQL);
            }

            // Create nukeSPAM log table if it doesn't exist
            if (!tableExists("{$prefix}_spam_log")) {
                $createLogSQL = "CREATE TABLE `{$prefix}_spam_log` (
                    `slid` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `request` CHAR(6) NOT NULL,
                    `username` VARCHAR(255) NOT NULL,
                    `email` VARCHAR(255) NOT NULL,
                    `ip` INT UNSIGNED NOT NULL,
                    `matched` VARCHAR(255) NOT NULL,
                    `added` INT(11) NOT NULL,
                    `count` INT UNSIGNED NOT NULL,
                    INDEX `idx_ip` (`ip`),
                    INDEX `idx_added` (`added`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
                
                executeQuery($createLogSQL);
            }

            // Create nukeSPAM whitelist table if it doesn't exist
            if (!tableExists("{$prefix}_spam_whitelist")) {
                $createWhitelistSQL = "CREATE TABLE `{$prefix}_spam_whitelist` (
                    `wlid` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `wltype` CHAR(1) NOT NULL,
                    `wlvalue` VARCHAR(255) NOT NULL,
                    INDEX `idx_type_value` (`wltype`, `wlvalue`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
                
                executeQuery($createWhitelistSQL);
            }

        } catch (Exception $e) {
            error_log("nukeSPAM Installation Error: " . $e->getMessage());
            // Don't throw exception to prevent fatal errors, just log it
            return false;
        }
        
        return true;
    }
}

// Modern security and initialization
global $admin_file, $admin, $db, $prefix;

// Sanitize and validate admin_file
$admin_file = $admin_file ?? 'admin';
$admin_file = preg_replace('/[^a-zA-Z0-9_-]/', '', $admin_file); // Sanitize

if (!defined('ADMIN_FILE')) {
    // Use proper header redirect with full URL
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $redirect_url = $protocol . $host . '/' . $admin_file . '.php';
    
    header('Location: ' . $redirect_url, true, 302);
    exit();
}

$module_name = basename(dirname(dirname(__FILE__)));

// Enhanced admin check with proper validation
$modAdmin = false;
if (function_exists('is_mod_admin')) {
    $modAdmin = is_mod_admin($module_name);
} elseif (function_exists('is_admin') && isset($admin)) {
    $modAdmin = is_admin($admin);
}

if ($modAdmin) {
    // Module Definition
    seoCheckInstall();
    
    // Enhanced security for file inclusion
    $allowed_operations = [
        'nukeSPAM',
        'nukeSPAMConfig', 
        'nukeSPAMCheck',
        'nukeSPAMSaveConfig',
        'nukeSPAMWL'
    ];
    
    // Sanitize operation parameter
    $operation = $_REQUEST['op'] ?? 'nukeSPAM';
    $operation = in_array($operation, $allowed_operations) ? $operation : 'nukeSPAM';
    
    // Header stuff - with proper escaping
    if (function_exists('addJSToHead')) {
        addJSToHead('includes/jquery/jquery.js', 'file');
        addJSToHead('includes/jquery/jquery.cookie.js', 'file');
    }
    
    include('header.php');
    
    $checktime = strtotime(date('Y-m-d'));
    $seoModule = 'nukeSPAM';
    
    if (function_exists('seoGetConfigs')) {
        $seoConfig = seoGetConfigs($seoModule);
    }
    
    if (function_exists('OpenTable')) {
        OpenTable();
    }
    
    // Output with proper escaping
    echo '<div class="text-center"><h2>nukeSPAM&trade;</h2></div>' . PHP_EOL;
    echo '<table width="100%" border="0">' . PHP_EOL;
    echo '<tr>' . PHP_EOL;
    
    $admin_file_escaped = htmlspecialchars($admin_file, ENT_QUOTES, 'UTF-8');
    
    // Use ternary operators for undefined constants with defaults
    $spam_config = defined('_SPAM_CONFIG') ? _SPAM_CONFIG : 'Configuration';
    $spam_wl = defined('_SPAM_WL') ? _SPAM_WL : 'Whitelist';
    $spam_check = defined('_SPAM_CHECK') ? _SPAM_CHECK : 'Check IP';
    $spam_siteadmin = defined('_SPAM_SITEADMIN') ? _SPAM_SITEADMIN : 'Site Admin';
    
    echo '<td>' . (function_exists('seoHelp') ? seoHelp('_SPAM_CONFIG') : '') . ' <a href="' . $admin_file_escaped . '.php?op=nukeSPAMConfig">' . htmlspecialchars($spam_config) . '</a></td>' . PHP_EOL;
    echo '<td>' . (function_exists('seoHelp') ? seoHelp('_SPAM_WL') : '') . ' <a href="' . $admin_file_escaped . '.php?op=nukeSPAMWL">' . htmlspecialchars($spam_wl) . '</a></td>' . PHP_EOL;
    echo '<td>' . (function_exists('seoHelp') ? seoHelp('_SPAM_CHECK') : '') . ' <a href="' . $admin_file_escaped . '.php?op=nukeSPAMCheck">' . htmlspecialchars($spam_check) . '</a></td>' . PHP_EOL;
    echo '<td><a href="modules.php?name=nukeSPAM">SPAM Log</a></td>' . PHP_EOL;
    echo '<td>' . (function_exists('seoHelp') ? seoHelp('_SPAM_SITEADMIN') : '') . ' <a href="' . $admin_file_escaped . '.php">' . htmlspecialchars($spam_siteadmin) . '</a></td>' . PHP_EOL;
    echo '</tr>' . PHP_EOL;
    echo '</table>' . PHP_EOL;
    
    if (function_exists('CloseTable')) {
        CloseTable();
    }
    
    if (function_exists('OpenTable')) {
        OpenTable();
    }

    // Secure file inclusion with validation
    switch ($operation) {
        case 'nukeSPAM':
        case 'nukeSPAMConfig':
            $config_file = 'modules/' . $module_name . '/admin/nukeSPAMConfig.php';
            if (file_exists($config_file)) {
                include_once($config_file);
            }
            break;
            
        case 'nukeSPAMCheck':
            $check_file = 'modules/' . $module_name . '/admin/nukeSPAMCheck.php';
            if (file_exists($check_file)) {
                include($check_file);
            }
            break;
            
        case 'nukeSPAMSaveConfig':
            // Enhanced CSRF protection
            if (function_exists('csrf_check')) {
                csrf_check();
            }
            $config_file = 'modules/' . $module_name . '/admin/nukeSPAMConfig.php';
            if (file_exists($config_file)) {
                include_once($config_file);
            }
            break;
            
        case 'nukeSPAMWL':
            $wl_file = 'modules/' . $module_name . '/admin/nukeSPAMWL.php';
            if (file_exists($wl_file)) {
                include_once($wl_file);
            }
            break;
    }
    
} else {
    // Enhanced error handling
    if (file_exists('header.php')) {
        include_once('header.php');
    }
    
    if (function_exists('GraphicAdmin')) {
        GraphicAdmin();
    }
    
    if (function_exists('OpenTable')) {
        OpenTable();
    }
    
    $error_text = defined('_ERROR') ? _ERROR : 'Error';
    echo '<div class="text-center"><span class="thick">' . htmlspecialchars($error_text) . '</span><br /><br />' . htmlspecialchars($module_name) . '</div>' . PHP_EOL;
}

if (function_exists('CloseTable')) {
    CloseTable();
}

if (file_exists('footer.php')) {
    include_once('footer.php');
}

?>