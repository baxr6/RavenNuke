<?php

/********************************************************/
/* NukeSentinel(tm)                                     */
/* By: NukeScripts(tm) (http://www.nukescripts.net)     */
/* Updated for PHP 8.3+ Compatibility                   */
/********************************************************/

if (!defined('NUKESENTINEL_ADMIN')) {
    header("Location: ../../../$admin_file.php");
    exit;
}

// Validate IP parts
foreach ($xip as $octet) {
    if (
        ($octet !== "*" && (!is_numeric($octet) || $octet < 0 || $octet > 255))
    ) {
        $pagetitle = _AB_NUKESENTINEL . ": " . _AB_ADDIPERROR;
        include("header.php");
        title($pagetitle);
        OpenTable();
        echo '<br />';
        echo '<div class="text-center"><strong>' . _AB_IPERROR . ' </strong><br />';
        echo '<strong>' . _GOBACK . '</strong></div><br />';
        CloseTable();
        include("footer.php");
        exit;
    }
}

// Convert wildcard IP to full IP
$xIPs = implode(".", $xip);
$bantemp = str_replace("*", "0", $xIPs);
$xIPl = sprintf("%u", ip2long($bantemp));

// Handle expiration
$xexpires = (isset($xexpires) && is_numeric($xexpires) && $xexpires > 0)
    ? (time() + ($xexpires * 86400))
    : 0;

// Sanitize and escape input
$xuser_id = (int) ($xuser_id ?? 0);
$xusername = $db->sql_escape_string(stripslashes($xusername ?? ''));
$xuser_agent = $db->sql_escape_string(htmlentities($xuser_agent ?? '', ENT_QUOTES));
$xreason = $db->sql_escape_string($xreason ?? '');
$xc2c = $db->sql_escape_string($xc2c ?? '');

$xnotes = str_ireplace(['<br>', '<br />'], "\r\n", $xnotes ?? '');
$xnotes = $db->sql_escape_string(htmlentities($xnotes, ENT_QUOTES));

// Format date from datetime string
$xdatetime = $xdatetime ?? '';
$xdate = strtotime($xdatetime) ?: time();

// Update the database
$result = $db->sql_query("UPDATE `{$prefix}_nsnst_blocked_ips`
    SET
        `ip_addr` = '$xIPs',
        `ip_long` = '$xIPl',
        `user_id` = '$xuser_id',
        `username` = '$xusername',
        `user_agent` = '$xuser_agent',
        `date` = '$xdate',
        `notes` = '$xnotes',
        `reason` = '$xreason',
        `expires` = '$xexpires',
        `c2c` = '$xc2c'
    WHERE `ip_addr` = '" . $db->sql_escape_string($old_xIPs) . "'");

if (!$result) {
    die("DB Error");
}

// Cleanup trailing wildcards (e.g., 192.168.*.* → 192.168)
$xIPs = preg_replace('/(\.\*)+$/', '', $xIPs);
$old_xIPs = preg_replace('/(\.\*)+$/', '', $old_xIPs);

// Update .htaccess if configured
if (!empty($ab_config['htaccess_path']) && file_exists($ab_config['htaccess_path'])) {
    $htaccess = file_get_contents($ab_config['htaccess_path']);

    $deny_old = "deny from $old_xIPs\n";
    $deny_new = (!in_array($xIPs, ['0', '*'], true)) ? "deny from $xIPs\n" : '';

    if ($htaccess !== false) {
        $htaccess = str_replace($deny_old, $deny_new, $htaccess);
        file_put_contents($ab_config['htaccess_path'], $htaccess);
    }
}

// Redirect
header("Location: $admin_file.php?op=$xop&min=$min&column=$column&direction=$direction&sip=$sip");
exit;
?>
