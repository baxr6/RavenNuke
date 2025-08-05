<?php
/************************************************************************/
/* nukeFEED - SECURE VERSION
/* http://www.nukeSEO.com
/* Copyright © 2007 by Kevin Guske
/************************************************************************/
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

global $admin_file;
if(!isset($admin_file)) { $admin_file = 'admin'; }
if(!defined('ADMIN_FILE')) {
    Header('Location: ../../../'.$admin_file.'.php');
    die();
}

// SECURITY: Generate and validate CSRF token
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// SECURITY: Input validation and sanitization
$sid = isset($_REQUEST['sid']) ? (int)$_REQUEST['sid'] : 0;
$op = isset($_REQUEST['op']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_REQUEST['op']) : '';

define('_type', 'aggregator');
$error = '';

// Initialize variables with safe defaults
$name = '';
$tagline = '';
$image = '';
$icon = '';
$url = '';
$active = 1;
$inactsel = '';

/**
 * Validate and sanitize input data
 */
function validateInput($data, $type = 'text', $maxLength = 255) {
    if (empty($data)) return '';
    
    $data = trim($data);
    
    switch ($type) {
        case 'url':
            // Basic URL validation - you might want more strict validation
            $data = filter_var($data, FILTER_SANITIZE_URL);
            if (!filter_var($data, FILTER_VALIDATE_URL) && !empty($data)) {
                // Allow relative URLs or template URLs with placeholders
                if (!preg_match('/^(https?:\/\/|\/|{\w+})/', $data)) {
                    return '';
                }
            }
            break;
        case 'text':
        default:
            $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
            break;
    }
    
    return strlen($data) > $maxLength ? substr($data, 0, $maxLength) : $data;
}

/**
 * Execute prepared statement safely
 */
function executePreparedQuery($sql, $params = [], $types = '') {
    global $db;
    
    // If your DB class supports prepared statements
    if (method_exists($db, 'prepare')) {
        $stmt = $db->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        return $stmt->execute();
    } else {
        // Fallback: manual escaping (less secure but better than nothing)
        foreach ($params as $param) {
            $escaped = is_string($param) ? "'" . $db->sql_escape_string($param) . "'" : (int)$param;
            $sql = preg_replace('/\?/', $escaped, $sql, 1);
        }
        return $db->sql_query($sql);
    }
}

// SECURITY: Validate CSRF token for POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!hash_equals($_SESSION['csrf_token'], $token)) {
        die('CSRF token validation failed');
    }
}

# Save subscription?
if ($op == 'nfSaveSubscript' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // SECURITY: Validate and sanitize all inputs
    $name = validateInput($_POST['name'] ?? '', 'text', 60);
    $tagline = validateInput($_POST['tagline'] ?? '', 'text', 60);
    $image = validateInput($_POST['image'] ?? '', 'url', 255);
    $icon = validateInput($_POST['icon'] ?? '', 'url', 255);
    $url = validateInput($_POST['url'] ?? '', 'url', 255);
    $active = isset($_POST['active']) ? (int)$_POST['active'] : 0;
    $active = ($active === 1) ? 1 : 0; // Ensure only 0 or 1
    
    // Validation
    if (empty($name)) $error .= _nF_NAMEREQUIRED.'<br />';
    if (empty($url)) $error .= _nF_URLREQUIRED.'<br />';
    if (empty($tagline)) $error .= _nF_TAGLINEREQUIRED.'<br />';
    
    // Additional URL validation for template URLs
    if (!empty($url) && !preg_match('/^(https?:\/\/|\/|{\w+})/', $url)) {
        $error .= 'Invalid URL format<br />';
    }
    
    if (empty($error)) {
        if ($sid > 0) {
            // Update existing subscription
            $sql = 'UPDATE `'.$prefix.'_seo_subscriptions` SET `name` = ?, `tagline` = ?, `image` = ?, `icon` = ?, `url` = ?, `active` = ? WHERE sid = ?';
            $params = [$name, $tagline, $image, $icon, $url, $active, $sid];
            $types = 'sssssii';
        } else {
            // Insert new subscription
            $sql = 'INSERT INTO `'.$prefix.'_seo_subscriptions` (`type`, `name`, `tagline`, `image`, `icon`, `url`, `active`) VALUES(?, ?, ?, ?, ?, ?, ?)';
            $params = [_type, $name, $tagline, $image, $icon, $url, $active];
            $types = 'ssssssi';
        }
        
        if (executePreparedQuery($sql, $params, $types)) {
            header("Location: ".$admin_file.".php?op=nfEditSubscript");
            die();
        } else {
            $error = 'Database error occurred.';
        }
    }
}

// Delete subscription
if ($op == 'nfDelSubscript' && $sid > 0 && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // SECURITY: Use prepared statement for deletion
    $sql = 'DELETE FROM `'.$prefix.'_seo_subscriptions` WHERE sid = ?';
    if (executePreparedQuery($sql, [$sid], 'i')) {
        header("Location: ".$admin_file.".php?op=nfEditSubscript");
        die();
    }
}

// Load subscription for editing
if ($op == 'nfEditSubscript' && $sid > 0) {
    $sql = 'SELECT * FROM `'.$prefix.'_seo_subscriptions` WHERE sid = ?';
    
    if (method_exists($db, 'prepare')) {
        $stmt = $db->prepare($sql);
        $stmt->bind_param('i', $sid);
        $stmt->execute();
        $result = $stmt->get_result();
        $subscript = $result->fetch_assoc();
    } else {
        // Fallback with integer casting for safety
        $sql = 'SELECT * FROM `'.$prefix.'_seo_subscriptions` WHERE sid = ' . (int)$sid;
        $result = $db->sql_query($sql);
        $subscript = $db->sql_fetchrow($result);
    }
    
    if ($subscript) {
        // SECURITY: Escape output for HTML context
        $name = htmlspecialchars($subscript['name'] ?? '', ENT_QUOTES, 'UTF-8');
        $tagline = htmlspecialchars($subscript['tagline'] ?? '', ENT_QUOTES, 'UTF-8');
        $image = htmlspecialchars($subscript['image'] ?? '', ENT_QUOTES, 'UTF-8');
        $icon = htmlspecialchars($subscript['icon'] ?? '', ENT_QUOTES, 'UTF-8');
        $url = htmlspecialchars($subscript['url'] ?? '', ENT_QUOTES, 'UTF-8');
        $active = (int)($subscript['active'] ?? 1);
        if (!$active) $inactsel = 'selected="selected"';
    }
}

// Set form labels
if ($sid > 0) {
    $addedit = _nF_EDITAGGREGATOR;
    $addedit2 = '<a href="'.$admin_file.'.php?op=nfEditSubscript">'._nF_ADDAGGREGATOR.'</a>';
} else {
    $addedit = _nF_ADDAGGREGATOR;
    $addedit2 = '';
}

// Display subscription list
$seo_config = seoGetConfigs('Feeds');
$subscriptions = getSubscriptions(_type);
listSubscriptions($subscriptions, 0, '', $seo_config, 'admin', _type);

// Display errors
if (!empty($error)) {
    echo '<h2 style="color: red; text-align: center;">' . $error . '</h2><br />';
}

// SECURITY: Output form with proper escaping and CSRF protection
echo '<br />  
<form name="editSubscript" action="'.$admin_file.'.php?op=nfSaveSubscript" method="post">
  <input type="hidden" name="csrf_token" value="' . htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') . '" />
  <table>
  <tr><td><strong>'.$addedit.'</strong></td><td style="text-align: right;">'.$addedit2.'</td></tr>
  <tr>
  <td>'.seoHelp('_nF_AGGREGATOR').' '._nF_AGGREGATOR.'</td>
  <td><input maxlength="60" size="60" name="name" type="text" value="'.$name.'" required /></td>
  </tr>
  <tr>
  <td>'.seoHelp('_nF_URL').' '._nF_URL.'</td>
  <td><input maxlength="256" size="60" name="url" type="text" value="'.$url.'" required /></td>
  </tr>
  <tr><td>&nbsp;</td><td>'._nF_URLTEXT.'{URL}, {NUKEURL}, {TITLE}</td></tr>
  <tr>
  <td>'.seoHelp('_nF_TAGLINE').' '._nF_TAGLINE.'</td> 
  <td><input maxlength="60" size="60" name="tagline" type="text" value="'.$tagline.'" required /></td>
  </tr>
  <tr>
  <td>'.seoHelp('_nF_IMAGE').' '._nF_IMAGE.'</td>
  <td><input maxlength="256" size="60" name="image" type="text" value="'.$image.'" /></td>
  </tr>
  <tr>
  <td>'.seoHelp('_nF_STATUS').' '._nF_STATUS.'</td>
  <td><select name="active"><option value="1">'._nF_ACTIVE.'</option><option value="0" '.$inactsel.'>'._nF_INACTIVE.'</option></select></td>
  </tr>
  </table>
  <input type="hidden" name="sid" value="'.$sid.'" />
  <input type="submit" value="'._nF_SAVE.'" />
</form>';

?>

<style>
/* Add some basic styling for better UX */
form table {
    border-collapse: collapse;
    width: 100%;
    max-width: 800px;
}

form table td {
    padding: 8px;
    border: 1px solid #ddd;
}

form input[type="text"], form select {
    width: 100%;
    padding: 4px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

form input[type="submit"] {
    background-color: #007cba;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    margin-top: 10px;
}

form input[type="submit"]:hover {
    background-color: #005a87;
}
</style>