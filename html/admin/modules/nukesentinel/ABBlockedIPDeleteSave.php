<?php

/********************************************************/
/* NukeSentinel(tm)                                     */
/* By: NukeScripts(tm) (http://www.nukescripts.net)     */
/* Copyright © 2000-2008 by NukeScripts(tm)             */
/* See CREDITS.txt for ALL contributors                 */
/* Updated to use centralized functions library         */
/********************************************************/

// Security check with early exit
if (!defined('NUKESENTINEL_ADMIN')) {
    header("Location: ../../../" . ($admin_file ?? 'admin') . ".php");
    exit;
}

// Include the centralized functions library
require_once(dirname(__FILE__) . '/functions.php');

// Initialize components using centralized classes
$dbWrapper = new DatabaseWrapper($db, $prefix);

// Sanitize and validate inputs using centralized validator
$xIPs = InputValidator::sanitizeIp($xIPs ?? '');
$xop = InputValidator::sanitizeString($xop ?? '');
$min = InputValidator::validateInt($min ?? 0);
$column = InputValidator::sanitizeColumn($column ?? '');
$direction = InputValidator::validateDirection($direction ?? '');
$sip = InputValidator::sanitizeString($sip ?? '');
$admin_file = InputValidator::sanitizeString($admin_file ?? 'admin');

// Validate required IP parameter
if (empty($xIPs)) {
    error_log("No IP address provided for deletion");
    
    $redirectUrl = NukeSentinelUtils::buildRedirectUrl($admin_file, [
        'op' => $xop,
        'error' => 'no_ip'
    ]);
    
    header("Location: " . $redirectUrl);
    exit;
}

// Delete IP from database using centralized method
$deleteSuccess = $dbWrapper->deleteRecord('nsnst_blocked_ips', 'ip_addr', $xIPs);
if (!$deleteSuccess) {
    error_log("Failed to delete IP from database: " . $xIPs);
}

// Optimize table using centralized method
$optimizeSuccess = $dbWrapper->optimizeTable('nsnst_blocked_ips');
if (!$optimizeSuccess) {
    error_log("Failed to optimize blocked IPs table");
}

// Update .htaccess file if path is configured
$htaccessSuccess = true;
if (!empty($ab_config['htaccess_path'])) {
    $htaccessManager = new HtaccessManager($ab_config['htaccess_path']);
    $htaccessSuccess = $htaccessManager->removeIpFromHtaccess($xIPs);
    
    if (!$htaccessSuccess) {
        error_log("Failed to update htaccess file for IP: " . $xIPs);
    }
}

// Build redirect URL with status using centralized utility
$redirectParams = [
    'op' => $xop,
    'min' => $min,
    'column' => $column,
    'direction' => $direction,
    'sip' => $sip
];

// Add status indicators
if (!$deleteSuccess) {
    $redirectParams['error'] = 'db_delete_failed';
} elseif (!$htaccessSuccess) {
    $redirectParams['warning'] = 'htaccess_update_failed';
} else {
    $redirectParams['success'] = 'ip_deleted';
}

// Redirect using centralized utility
$redirectUrl = NukeSentinelUtils::buildRedirectUrl($admin_file, $redirectParams);
header("Location: " . $redirectUrl);
exit;

?>