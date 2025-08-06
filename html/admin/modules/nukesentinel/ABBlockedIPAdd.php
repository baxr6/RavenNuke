<?php

if (!defined('NUKESENTINEL_ADMIN')) {
    header("Location: ../../../" . $admin_file . ".php");
    exit;
}

$pagetitle = _AB_NUKESENTINEL . ": " . _AB_ADDIP;
include("header.php");

OpenTable();
OpenMenu(_AB_ADDIP);
mastermenu();
CarryMenu();
blockedipmenu();
CloseMenu();
CloseTable();

echo '<br />' . "\n";
OpenTable();

echo '<form action="' . HtmlHelper::escape($admin_file) . '.php" method="post">' . "\n";
echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="2">' . "\n";

echo '<tr bgcolor="' . $bgcolor1 . '"><td align="center" class="content" colspan="2">' . _AB_ADDIPS . '</td></tr>' . "\n";

// Initialize IP input default values safely
$tip = [];
if (isset($tip) && is_array($tip)) {
    // keep existing
} elseif (isset($_GET['tip']) && preg_match("/^(\d{1,3}\.){3}\d{1,3}$/", $_GET['tip'])) {
    $tip = explode('.', $_GET['tip']);
} else {
    $tip = ['', '0', '0', '0'];
}

echo '<tr><td bgcolor="' . $bgcolor2 . '"><strong>' . _AB_IPBLOCKED . ':</strong></td><td>';
for ($i = 0; $i < 4; $i++) {
    $val = isset($tip[$i]) ? HtmlHelper::escape($tip[$i]) : '';
    echo '<input type="text" name="xip[' . $i . ']" value="' . $val . '" size="4" maxlength="3" style="text-align: center;" />' . ($i < 3 ? '. ' : '');
}
echo "</td></tr>\n";

echo '<tr><td bgcolor="' . $bgcolor2 . '"><strong>' . _AB_USERID . ':</strong></td><td><input type="text" name="xuser_id" size="10" value="1" /></td></tr>' . "\n";

echo '<tr><td bgcolor="' . $bgcolor2 . '"><strong>' . _AB_USERNAME . ':</strong></td><td><input type="text" name="xusername" size="20" value="' . HtmlHelper::escape($anonymous ?? '') . '" /></td></tr>' . "\n";

echo '<tr><td bgcolor="' . $bgcolor2 . '"><strong>' . _AB_AGENT . ':</strong></td><td><input type="text" name="xuser_agent" size="40" value="' . HtmlHelper::escape(_AB_UNKNOWN) . '" /></td></tr>' . "\n";

echo '<tr><td bgcolor="' . $bgcolor2 . '" valign="top"><strong>' . _AB_EXPIRESIN . ':</strong></td><td><select name="xexpires">' . "\n";
echo '<option value="0">' . _AB_PERMENANT . '</option>' . "\n";

for ($i = 1; $i <= 365; $i++) {
    $expiredate = date("Y-m-d", time() + ($i * 86400));
    echo '<option value="' . $i . '">' . $i . ' (' . $expiredate . ')</option>' . "\n";
}

echo '</select><br />' . _AB_EXPIRESINS . '</td></tr>' . "\n";

echo '<tr><td bgcolor="' . $bgcolor2 . '"><strong>' . _AB_COUNTRY . ':</strong></td><td><select name="xc2c">' . "\n";
echo '<option value="00" selected="selected">' . _AB_SELECTCOUNTRY . '</option>' . "\n";

// Fetch countries using DatabaseWrapper
$dbWrapper = new DatabaseWrapper($db, $prefix);
$countries = $dbWrapper->getCountries();

foreach ($countries as $country) {
    $value = HtmlHelper::escape($country['c2c']);
    $name = HtmlHelper::escape(strtoupper($country['c2c']) . ' - ' . $country['country']);
    echo "<option value=\"{$value}\">{$name}</option>\n";
}

echo '</select></td></tr>' . "\n";

echo '<tr><td bgcolor="' . $bgcolor2 . '" valign="top"><strong>' . _AB_NOTES . ':</strong></td><td><textarea name="xnotes" rows="10" cols="60">' . HtmlHelper::escape(_AB_ADDBY . ' ' . ($aid ?? '')) . '</textarea></td></tr>' . "\n";

echo '<tr><td bgcolor="' . $bgcolor2 . '"><strong>' . _AB_REASON . ':</strong></td><td><select name="xreason">' . "\n";

// Fetch blockers
$blockers = $dbWrapper->getBlockers();

foreach ($blockers as $blocker) {
    $value = HtmlHelper::escape($blocker['blocker']);
    $reason = HtmlHelper::escape($blocker['reason']);
    echo "<option value=\"{$value}\">{$reason}</option>\n";
}

echo '</select></td></tr>' . "\n";

echo '<tr><td bgcolor="' . $bgcolor2 . '"><strong>' . _AB_QUERY . ':</strong></td><td><input type="text" name="xquery_string" size="40" value="' . HtmlHelper::escape(_AB_UNKNOWN) . '" /></td></tr>' . "\n";

echo '<tr><td bgcolor="' . $bgcolor2 . '"><strong>' . _AB_X_FORWARDED . ':</strong></td><td><input type="text" name="xx_forward_for" size="40" value="none" /></td></tr>' . "\n";

echo '<tr><td bgcolor="' . $bgcolor2 . '"><strong>' . _AB_CLIENT_IP . ':</strong></td><td><input type="text" name="xclient_ip" size="40" value="none" /></td></tr>' . "\n";

echo '<tr><td bgcolor="' . $bgcolor2 . '"><strong>' . _AB_REMOTE_ADDR . ':</strong></td><td><input type="text" name="xremote_addr" size="40" value="none" /></td></tr>' . "\n";

echo '<tr><td bgcolor="' . $bgcolor2 . '"><strong>' . _AB_REMOTE_PORT . ':</strong></td><td><input type="text" name="xremote_port" size="40" value="' . HtmlHelper::escape(_AB_UNKNOWN) . '" /></td></tr>' . "\n";

echo '<tr><td bgcolor="' . $bgcolor2 . '"><strong>' . _AB_REQUEST_METHOD . ':</strong></td><td><input type="text" name="xrequest_method" size="40" value="' . HtmlHelper::escape(_AB_UNKNOWN) . '" /></td></tr>' . "\n";

echo '<tr><td colspan="2" align="center"><input type="checkbox" name="another" value="1" checked="checked" />' . _AB_ADDANOTHERIP . '</td></tr>' . "\n";

echo '<tr><td colspan="2" align="center"><input type="hidden" name="op" value="ABBlockedIPAddSave" /><input type="submit" value="' . _AB_ADDIP . '" /></td></tr>' . "\n";

echo '</table>' . "\n";
echo '</form>' . "\n";

CloseTable();

include("footer.php");
