<?php
/********************************************************/
/* NukeSentinel(tm)                                     */
/* By: NukeScripts(tm) (http://www.nukescripts.net)     */
/* Copyright © 2000-2008 by NukeScripts(tm)             */
/* See CREDITS.txt for ALL contributors                 */
/********************************************************/

declare(strict_types=1);

if (!defined('NUKESENTINEL_ADMIN')) {
    header("Location: ../../../" . $admin_file . ".php");
    exit();
}

// Sanitize and assign POST variables
$xip = $_POST['xip'] ?? ['0', '0', '0', '0'];
$xuser_id = (int)($_POST['xuser_id'] ?? 1);
$xusername = addslashes(trim($_POST['xusername'] ?? ''));
$xuser_agent = addslashes(trim($_POST['xuser_agent'] ?? _AB_UNKNOWN));
$xexpires = (int)($_POST['xexpires'] ?? 0);
$xc2c = addslashes(trim($_POST['xc2c'] ?? '00'));
$xnotes = addslashes(htmlentities(trim($_POST['xnotes'] ?? ''), ENT_QUOTES));
$xreason = addslashes(trim($_POST['xreason'] ?? ''));
$xquery_string = addslashes(trim($_POST['xquery_string'] ?? _AB_UNKNOWN));
$xx_forward_for = addslashes(trim($_POST['xx_forward_for'] ?? 'none'));
$xclient_ip = addslashes(trim($_POST['xclient_ip'] ?? 'none'));
$xremote_addr = addslashes(trim($_POST['xremote_addr'] ?? 'none'));
$xremote_port = addslashes(trim($_POST['xremote_port'] ?? _AB_UNKNOWN));
$xrequest_method = addslashes(trim($_POST['xrequest_method'] ?? _AB_UNKNOWN));
$another = (int)($_POST['another'] ?? 1);

// Validate IP octets
foreach ($xip as $octet) {
    if ((!is_numeric($octet) || $octet < 0 || $octet > 255) && $octet !== '*') {
        showErrorAndExit();
    }
}

// Convert IP to string and long format
$xIPs = implode('.', $xip);
$bantemp = str_replace('*', '0', $xIPs);

if (filter_var($bantemp, FILTER_VALIDATE_IP)) {
    $xIPl = sprintf('%u', ip2long($bantemp));
} else {
    $xIPl = 0;
}

// Calculate expiration timestamp
$currentTime = time();
if ($xexpires > 0) {
    $xexpires = $currentTime + ($xexpires * 86400);
} else {
    $xexpires = 0; // Permanent
}

// Check if IP already banned
$escapedIP = addslashes($xIPs);
$ipExistsResult = $db->sql_query("SELECT COUNT(*) as count FROM `{$prefix}_nsnst_blocked_ips` WHERE `ip_addr` = '$escapedIP'");
$ipExistsRow = $db->sql_fetchrow($ipExistsResult);
$ipExists = $ipExistsRow['count'] ?? 0;

if ($ipExists < 1) {
    $temp_qs = base64_encode($xquery_string);

    $sql = "INSERT INTO `{$prefix}_nsnst_blocked_ips` (
        `ip_addr`, `ip_long`, `user_id`, `username`, `user_agent`,
        `notes`, `reason`, `query_string`, `get_string`, `post_string`,
        `x_forward_for`, `client_ip`, `remote_addr`, `remote_port`,
        `request_method`, `expires`, `c2c`
    ) VALUES (
        '$xIPs', '$xIPl', '$xuser_id', '$xusername', '$xuser_agent',
        '$xnotes', '$xreason', '$temp_qs', '$temp_qs', '$temp_qs',
        '$xx_forward_for', '$xclient_ip', '$xremote_addr', '$xremote_port',
        '$xrequest_method', '$xexpires', '$xc2c'
    )";

    $db->sql_query($sql);

    // Append to .htaccess if configured
    if (!empty($ab_config['htaccess_path'])) {
        // Trim trailing wildcards
        $cleanIP = $xIPs;
        for ($i = 0; $i < 3; $i++) {
            if (substr($cleanIP, -2) === '.*') {
                $cleanIP = substr($cleanIP, 0, -2);
            }
        }

        if ($cleanIP !== '*' && is_writable($ab_config['htaccess_path'])) {
            $tempip = "deny from $cleanIP\n";
            file_put_contents($ab_config['htaccess_path'], $tempip, FILE_APPEND | LOCK_EX);
        }
    }
}

// Redirect accordingly
if ($another === 1) {
    header("Location: {$admin_file}.php?op=ABBlockedIPAdd");
} else {
    header("Location: {$admin_file}.php?op=ABBlockedIPList");
}
exit();

// --- Helper Function ---
function showErrorAndExit(): void {
    global $pagetitle;
    $pagetitle = _AB_NUKESENTINEL . ": " . _AB_ADDIPERROR;
    include("header.php");
    title($pagetitle);
    OpenTable();
    echo '<div class="text-center"><strong>' . _AB_IPERROR . '</strong><br />';
    echo '<strong>' . _GOBACK . '</strong></div>';
    CloseTable();
    include("footer.php");
    exit();
}
