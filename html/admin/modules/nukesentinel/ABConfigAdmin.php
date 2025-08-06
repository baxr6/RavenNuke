<?php

declare(strict_types=1);

/**
 * NukeSentinel(tm)
 * By: NukeScripts(tm) (http://www.nukescripts.net)
 * Copyright © 2000-2008 by NukeScripts(tm)
 * See CREDITS.txt for ALL contributors
 */

if (!defined('NUKESENTINEL_ADMIN')) {
    header("Location: ../../../" . $admin_file . ".php");
    exit;
}

$pagetitle = _AB_NUKESENTINEL . ": " . _AB_CONFIGURATION . ": " . _AB_ADMINBLOCKER;

include("header.php");
OpenTable();
OpenMenu(_AB_ADMINBLOCKER);
mastermenu();
CarryMenu();
configmenu();
CloseMenu();
CloseTable();
echo '<br>' . PHP_EOL;
OpenTable();
echo '<form action="' . $admin_file . '.php" method="post">' . PHP_EOL;
echo '<input type="hidden" name="xblocker_row[block_name]" value="admin">' . PHP_EOL;
echo '<input type="hidden" name="xop" value="' . htmlspecialchars($op, ENT_QUOTES) . '">' . PHP_EOL;
echo '<input type="hidden" name="op" value="ABConfigSave">' . PHP_EOL;
echo '<table align="center" border="0" cellpadding="2" cellspacing="2">' . PHP_EOL;

$blocker_row = abget_blocker("admin");
$blocker_row['duration'] = $blocker_row['duration'] / 86400;

$select_activate = '';
for ($i = 0; $i <= 9; $i++) {
    $selected = ($blocker_row['activate'] == $i) ? ' selected="selected"' : '';
    $options_activate[$i] = '<option value="' . $i . '"' . $selected . '>' . constant('_AB_' . strtoupper(
        match($i) {
            0 => 'OFF',
            1 => 'EMAILONLY',
            2 => 'EMAILFORWARD',
            3 => 'EMAILTEMPLATE',
            4 => 'EMAILBLOCKFORWARD',
            5 => 'EMAILBLOCKTEMPLATE',
            6 => 'FORWARDONLY',
            7 => 'TEMPLATEONLY',
            8 => 'BLOCKFORWARD',
            9 => 'BLOCKTEMPLATE'
        }
    )) . '</option>';
}
echo '<tr><td align="center" bgcolor="' . $bgcolor2 . '" colspan="2"><strong>' . _AB_ADMINBLOCKER . '</strong></td></tr>' . PHP_EOL;
echo '<tr><td bgcolor="' . $bgcolor2 . '" width="25%">' . help_img(_AB_HELP_011) . ' ' . _AB_ACTIVATE . ':</td><td width="75%"><select name="xblocker_row[activate]">' . implode(PHP_EOL, $options_activate) . '</select></td></tr>' . PHP_EOL;

// htaccess
$htaccess_supported = str_contains($_SERVER['SERVER_SOFTWARE'], "Apache") && !empty($ab_config['htaccess_path']);
echo '<tr><td bgcolor="' . $bgcolor2 . '">' . help_img(_AB_HELP_012) . ' ' . _AB_HTWRITE . ':</td><td>';
if ($htaccess_supported) {
    $ht0 = ($blocker_row['htaccess'] == 0) ? ' selected="selected"' : '';
    $ht1 = ($blocker_row['htaccess'] == 1) ? ' selected="selected"' : '';
    echo '<select name="xblocker_row[htaccess]">';
    echo '<option value="0"' . $ht0 . '>' . _AB_NO . '</option>';
    echo '<option value="1"' . $ht1 . '>' . _AB_YES . '</option>';
    echo '</select>';
} else {
    echo '<strong>' . _AB_HTACCESSFAILED . '</strong><input type="hidden" name="xblocker_row[htaccess]" value="0">';
}
echo '</td></tr>' . PHP_EOL;

// Forward
echo '<tr><td bgcolor="' . $bgcolor2 . '">' . help_img(_AB_HELP_013) . ' ' . _AB_FORWARD . ':</td><td><input type="text" name="xblocker_row[forward]" size="50" value="' . htmlspecialchars($blocker_row['forward'], ENT_QUOTES) . '"></td></tr>' . PHP_EOL;

// Block Type
$block_type_options = ['0OCTECT', '1OCTECT', '2OCTECT', '3OCTECT'];
echo '<tr><td bgcolor="' . $bgcolor2 . '">' . help_img(_AB_HELP_014) . ' ' . _AB_BLOCKTYPE . ':</td><td><select name="xblocker_row[block_type]">';
foreach ($block_type_options as $i => $type) {
    $selected = ($blocker_row['block_type'] == $i) ? ' selected="selected"' : '';
    echo '<option value="' . $i . '"' . $selected . '>' . constant('_AB_' . $type) . '</option>';
}
echo '</select></td></tr>' . PHP_EOL;

// Templates
$templatedir = dir('abuse');
$templates = [];
while ($file = $templatedir->read()) {
    if (str_starts_with($file, 'abuse_')) {
        $templates[] = $file;
    }
}
closedir($templatedir->handle);
sort($templates);
echo '<tr><td bgcolor="' . $bgcolor2 . '">' . help_img(_AB_HELP_015) . ' ' . _AB_TEMPLATE . ':</td><td><select name="xblocker_row[template]">';
foreach ($templates as $template) {
    $display = ucfirst(str_replace('_', ' ', str_ireplace(['abuse_', '.tpl'], '', $template)));
    $selected = ($template === $blocker_row['template']) ? ' selected="selected"' : '';
    echo '<option value="' . $template . '"' . $selected . '>' . $display . '</option>';
}
echo '</select></td></tr>' . PHP_EOL;

// Email Lookup
$mailtest = defined('TNML_IS_ACTIVE') ? TNML_IS_ACTIVE : @mail();
echo '<tr><td bgcolor="' . $bgcolor2 . '">' . help_img(_AB_HELP_016) . ' ' . _AB_EMAILLOOKUP . ':</td>';
if (!$mailtest && !str_contains($_SERVER['SERVER_SOFTWARE'], 'PHP-CGI')) {
    $options = [
        0 => 'OFF',
        1 => 'Arin.net',
        2 => 'DNSStuff.com'
    ];
    echo '<td><select name="xblocker_row[email_lookup]">';
    foreach ($options as $val => $label) {
        $selected = ($blocker_row['email_lookup'] == $val) ? ' selected="selected"' : '';
        echo '<option value="' . $val . '"' . $selected . '>' . $label . '</option>';
    }
    echo '</select></td>';
} else {
    echo '<td><strong>' . _AB_NOTAVAILABLE . '</strong><input type="hidden" name="xblocker_row[email_lookup]" value="0"></td>';
}
echo '</tr>' . PHP_EOL;

// Reason
echo '<tr><td bgcolor="' . $bgcolor2 . '">' . help_img(_AB_HELP_017) . ' ' . _AB_REASON . ':</td><td><input type="text" name="xblocker_row[reason]" size="20" maxlength="20" value="' . htmlspecialchars($blocker_row['reason'], ENT_QUOTES) . '"></td></tr>' . PHP_EOL;

// Duration
echo '<tr><td bgcolor="' . $bgcolor2 . '">' . help_img(_AB_HELP_018) . ' ' . _AB_DURATION . ':</td><td><select name="xblocker_row[duration]">';
echo '<option value="0"' . ($blocker_row['duration'] == 0 ? ' selected="selected"' : '') . '>' . _AB_PERMENANT . '</option>';
for ($i = 1; $i <= 365; $i++) {
    $selected = ($blocker_row['duration'] == $i) ? ' selected="selected"' : '';
    $expiredate = date("Y-m-d", time() + ($i * 86400));
    echo '<option value="' . $i . '"' . $selected . '>' . $i . ' (' . $expiredate . ')</option>';
}
echo '</select></td></tr>' . PHP_EOL;

// Submit
echo '<tr><td align="center" colspan="2"><input type="submit" value="' . _AB_SAVECHANGES . '"></td></tr>' . PHP_EOL;
echo '</table>' . PHP_EOL;
echo '</form>' . PHP_EOL;
CloseTable();
include("footer.php");