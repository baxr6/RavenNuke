<?php

/********************************************************/
/* NukeSentinel(tm) - Edit Blocked Range                */
/********************************************************/

if (!defined('NUKESENTINEL_ADMIN')) {
    header("Location: ../../../" . $admin_file . ".php");
    exit;
}

$pagetitle = _AB_NUKESENTINEL . ": " . _AB_EDITRANGE;
include("header.php");

OpenTable();
OpenMenu(_AB_EDITRANGE);
mastermenu();
CarryMenu();
blockedrangemenu();
CloseMenu();
CloseTable();
echo '<br />' . "\n";

// Use modern DB wrapper
$nsDb = new DatabaseWrapper($db, $prefix);

// Validate input (assume $ip_lo and $ip_hi are provided externally)
$ipLo = InputValidator::validateInt($ip_lo);
$ipHi = InputValidator::validateInt($ip_hi);
$getIPs = $nsDb->getBlockedRange($ipLo, $ipHi);

$ip_lo = IpAddressHandler::longToIpArray($getIPs['ip_lo'] ?? 0);
$ip_hi = IpAddressHandler::longToIpArray($getIPs['ip_hi'] ?? 0);

// Defaults for navigation
$sip = $sip ?? '';
$min = $min ?? '';
$column = $column ?? '';
$direction = $direction ?? '';
$xop = $xop ?? '';

// Form Start
OpenTable();
echo '<form action="' . HtmlHelper::escape($admin_file) . '.php" method="post">' . "\n";
echo '<input type="hidden" name="op" value="ABBlockedRangeEditSave" />' . "\n";
echo '<input type="hidden" name="xop" value="' . HtmlHelper::escape($xop) . '" />' . "\n";
echo '<input type="hidden" name="sip" value="' . HtmlHelper::escape($sip) . '" />' . "\n";
echo '<input type="hidden" name="old_ip_lo" value="' . HtmlHelper::escape($getIPs['ip_lo']) . '" />' . "\n";
echo '<input type="hidden" name="old_ip_hi" value="' . HtmlHelper::escape($getIPs['ip_hi']) . '" />' . "\n";
echo '<input type="hidden" name="min" value="' . HtmlHelper::escape($min) . '" />' . "\n";
echo '<input type="hidden" name="column" value="' . HtmlHelper::escape($column) . '" />' . "\n";
echo '<input type="hidden" name="direction" value="' . HtmlHelper::escape($direction) . '" />' . "\n";

echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="2">' . "\n";
echo '<tr><td align="center" colspan="2"><strong>' . _AB_EDITRANGES . '</strong></td></tr>' . "\n";

// IP LO
echo '<tr><td bgcolor="' . $bgcolor2 . '"><strong>' . _AB_IPLO . ':</strong></td><td>';
for ($i = 0; $i < 4; $i++) {
    echo ($i > 0 ? '. ' : '') .
        '<input type="text" name="xip_lo[' . $i . ']" size="4" maxlength="3" value="' . HtmlHelper::escape($ip_lo[$i]) . '" style="text-align: center;" />';
}
echo '</td></tr>' . "\n";

// IP HI
echo '<tr><td bgcolor="' . $bgcolor2 . '"><strong>' . _AB_IPHI . ':</strong></td><td>';
for ($i = 0; $i < 4; $i++) {
    echo ($i > 0 ? '. ' : '') .
        '<input type="text" name="xip_hi[' . $i . ']" size="4" maxlength="3" value="' . HtmlHelper::escape($ip_hi[$i]) . '" style="text-align: center;" />';
}
echo '</td></tr>' . "\n";

// Expiration Dropdown
$expires = (int)($getIPs['expires'] ?? 0);
echo '<tr><td bgcolor="' . $bgcolor2 . '" valign="top"><strong>' . _AB_EXPIRESIN . ':</strong></td><td>';
echo '<select name="xexpires">';
echo '<option value="0"' . ($expires === 0 ? ' selected="selected"' : '') . '>' . (_AB_PERMENANT ?? 'Permanent') . '</option>';
for ($i = 1; $i <= 365; $i++) {
    $expiredate = date("Y-m-d", time() + ($i * 86400));
    $selected = ($expires === $i) ? ' selected="selected"' : '';
    echo '<option value="' . $i . '"' . $selected . '>' . $i . ' (' . $expiredate . ')</option>';
}
echo '</select><br />' . _AB_EXPIRESINS . '</td></tr>' . "\n";

// Notes
$notes = HtmlHelper::escape($getIPs['notes'] ?? '');
echo '<tr><td bgcolor="' . $bgcolor2 . '" valign="top"><strong>' . _AB_NOTES . ':</strong></td>';
echo '<td><textarea name="xnotes" rows="10" cols="60">' . $notes . '</textarea></td></tr>' . "\n";

// Reason dropdown
echo '<tr><td bgcolor="' . $bgcolor2 . '"><strong>' . _AB_REASON . ':</strong></td><td><select name="xreason">';
foreach ($nsDb->getBlockers() as $blocker) {
    $isSelected = ($getIPs['reason'] ?? '') === $blocker['blocker'] ? ' selected="selected"' : '';
    echo '<option value="' . HtmlHelper::escape($blocker['blocker']) . '"' . $isSelected . '>' . HtmlHelper::escape($blocker['reason']) . '</option>';
}
echo '</select></td></tr>' . "\n";

// Country dropdown
echo '<tr><td bgcolor="' . $bgcolor2 . '"><strong>' . _AB_COUNTRY . ':</strong></td><td><select name="xc2c">';
foreach ($nsDb->getCountries() as $country) {
    $c2c = $country['c2c'];
    $selected = ($getIPs['c2c'] ?? '') === $c2c ? ' selected="selected"' : '';
    echo '<option value="' . HtmlHelper::escape($c2c) . '"' . $selected . '>' .
        strtoupper(HtmlHelper::escape($c2c)) . ' - ' . HtmlHelper::escape($country['country']) . '</option>';
}
echo '</select></td></tr>' . "\n";

// Submit button
echo '<tr><td align="center" colspan="2"><input type="submit" value="' . _AB_SAVECHANGES . '" /></td></tr>';
echo '</table>';
echo '</form>';
CloseTable();

include("footer.php");
