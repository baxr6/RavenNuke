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

// Validate and sanitize inputs using centralized validator
$xIPs = InputValidator::sanitizeIp($xIPs ?? '');
$sip = InputValidator::sanitizeString($sip ?? '');
$xop = InputValidator::sanitizeString($xop ?? '');
$min = InputValidator::validateInt($min ?? 0);
$column = InputValidator::sanitizeColumn($column ?? '');
$direction = InputValidator::validateDirection($direction ?? '');
$admin_file = InputValidator::sanitizeString($admin_file ?? 'admin');
$bgcolor2 = $bgcolor2 ?? '#EEEEEE';

// Validate required IP parameter
if (empty($xIPs)) {
    echo '<div style="color: red; font-weight: bold; text-align: center; padding: 20px;">';
    echo 'Error: No IP address specified for editing.';
    echo '</div>';
    include("footer.php");
    exit;
}

// Get IP data from database using centralized wrapper
$getIPs = $dbWrapper->getBlockedIp($xIPs);
if (empty($getIPs)) {
    echo '<div style="color: red; font-weight: bold; text-align: center; padding: 20px;">';
    echo 'Error: IP address not found in database.';
    echo '</div>';
    include("footer.php");
    exit;
}

// Process date and expiration using centralized utilities
$currentDate = NukeSentinelUtils::formatDate($getIPs['date'] ?? null);
$expiresInDays = NukeSentinelUtils::calculateExpirationDays($getIPs['expires'] ?? 0);

// Parse IP address using centralized handler
$tipArray = IpAddressHandler::parseIp($xIPs);

// Set up page
$pagetitle = (_AB_NUKESENTINEL ?? 'NukeSentinel') . ": " . (_AB_EDITIP ?? 'Edit IP');
include("header.php");

OpenTable();
OpenMenu(_AB_EDITIP ?? 'Edit IP');
mastermenu();
CarryMenu();
blockedipmenu();
CloseMenu();
CloseTable();
echo '<br />' . "\n";
OpenTable();

?>

<form action="<?= HtmlHelper::escape($admin_file) ?>.php" method="post">
    <!-- Hidden form fields using centralized helper -->
    <?php 
    $hiddenFields = [
        'op' => 'ABBlockedIPEditSave',
        'xop' => $xop,
        'sip' => $sip,
        'old_xIPs' => $xIPs,
        'min' => $min,
        'column' => $column,
        'direction' => $direction
    ];
    
    foreach ($hiddenFields as $name => $value): ?>
        <input type="hidden" name="<?= HtmlHelper::escape($name) ?>" 
               value="<?= HtmlHelper::escape($value) ?>" />
    <?php endforeach; ?>
    
    <table summary="Edit IP Address Form" align="center" border="0" cellpadding="2" cellspacing="2">
        <tr>
            <td align="center" colspan="2">
                <strong><?= HtmlHelper::escape(_AB_EDITIPS ?? 'Edit IP Address') ?></strong>
            </td>
        </tr>
        
        <!-- IP Address Input using centralized handler -->
        <tr>
            <td bgcolor="<?= HtmlHelper::escape($bgcolor2) ?>">
                <strong><?= HtmlHelper::escape(_AB_IPBLOCKED ?? 'IP Blocked') ?>:</strong>
            </td>
            <td>
                <?php for ($i = 0; $i < 4; $i++): ?>
                    <?= $i > 0 ? '. ' : '' ?>
                    <input type="text" 
                           name="xip[<?= $i ?>]" 
                           value="<?= HtmlHelper::escape(IpAddressHandler::validateIpOctet($tipArray[$i] ?? '')) ?>" 
                           size="4" 
                           maxlength="3" 
                           style="text-align: center;" 
                           title="Enter IP octet (0-255) or * for wildcard" />
                <?php endfor; ?>
            </td>
        </tr>
        
        <!-- User ID -->
        <tr>
            <td bgcolor="<?= HtmlHelper::escape($bgcolor2) ?>">
                <strong><?= HtmlHelper::escape(_AB_USERID ?? 'User ID') ?>:</strong>
            </td>
            <td>
                <input type="text" 
                       name="xuser_id" 
                       size="10" 
                       value="<?= HtmlHelper::escape($getIPs['user_id'] ?? '') ?>" />
            </td>
        </tr>
        
        <!-- Username -->
        <tr>
            <td bgcolor="<?= HtmlHelper::escape($bgcolor2) ?>">
                <strong><?= HtmlHelper::escape(_AB_USERNAME ?? 'Username') ?>:</strong>
            </td>
            <td>
                <input type="text" 
                       name="xusername" 
                       size="20" 
                       value="<?= HtmlHelper::escape($getIPs['username'] ?? '') ?>" />
            </td>
        </tr>
        
        <!-- User Agent -->
        <tr>
            <td bgcolor="<?= HtmlHelper::escape($bgcolor2) ?>">
                <strong><?= HtmlHelper::escape(_AB_AGENT ?? 'User Agent') ?>:</strong>
            </td>
            <td>
                <input type="text" 
                       name="xuser_agent" 
                       size="40" 
                       value="<?= HtmlHelper::escape($getIPs['user_agent'] ?? '') ?>" />
            </td>
        </tr>
        
        <!-- Blocked Date/Time using centralized utility -->
        <tr>
            <td bgcolor="<?= HtmlHelper::escape($bgcolor2) ?>">
                <strong><?= HtmlHelper::escape(_AB_BLOCKEDON ?? 'Blocked On') ?>:</strong>
            </td>
            <td>
                <input type="text" 
                       name="xdatetime" 
                       size="30" 
                       value="<?= HtmlHelper::escape($currentDate) ?>"
                       placeholder="YYYY-MM-DD HH:MM:SS" />
            </td>
        </tr>
        
        <!-- Expiration using centralized utility -->
        <tr>
            <td bgcolor="<?= HtmlHelper::escape($bgcolor2) ?>" valign="top">
                <strong><?= HtmlHelper::escape(_AB_EXPIRESIN ?? 'Expires In') ?>:</strong>
            </td>
            <td>
                <select name="xexpires">
                    <?php 
                    $expirationOptions = NukeSentinelUtils::generateExpirationOptions();
                    echo HtmlHelper::selectOptions($expirationOptions, $expiresInDays);
                    ?>
                </select><br />
                <small><?= HtmlHelper::escape(_AB_EXPIRESINS ?? 'Days until expiration') ?></small>
            </td>
        </tr>
        
        <!-- Country Selection using centralized database wrapper -->
        <tr>
            <td bgcolor="<?= HtmlHelper::escape($bgcolor2) ?>">
                <strong><?= HtmlHelper::escape(_AB_COUNTRY ?? 'Country') ?>:</strong>
            </td>
            <td>
                <select name="xc2c">
                    <option value="00"><?= HtmlHelper::escape(_AB_SELECTCOUNTRY ?? 'Select Country') ?></option>
                    <?php 
                    $currentCountry = HtmlHelper::toString($getIPs['c2c'] ?? '');
                    $countries = $dbWrapper->getCountries();
                    
                    $countryOptions = [];
                    foreach ($countries as $countryrow) {
                        $c2c = HtmlHelper::toString($countryrow['c2c'] ?? '');
                        $countryOptions[$c2c] = strtoupper($c2c) . ' - ' . ($countryrow['country'] ?? 'Unknown');
                    }
                    echo HtmlHelper::selectOptions($countryOptions, $currentCountry);
                    ?>
                </select>
            </td>
        </tr>
        
        <!-- Notes -->
        <tr>
            <td bgcolor="<?= HtmlHelper::escape($bgcolor2) ?>" valign="top">
                <strong><?= HtmlHelper::escape(_AB_NOTES ?? 'Notes') ?>:</strong>
            </td>
            <td>
                <textarea name="xnotes" rows="10" cols="60" placeholder="Enter notes about this IP block..."><?= HtmlHelper::escape($getIPs['notes'] ?? '') ?></textarea>
            </td>
        </tr>
        
        <!-- Reason/Blocker using centralized database wrapper -->
        <tr>
            <td bgcolor="<?= HtmlHelper::escape($bgcolor2) ?>">
                <strong><?= HtmlHelper::escape(_AB_REASON ?? 'Reason') ?>:</strong>
            </td>
            <td>
                <select name="xreason">
                    <?php 
                    $currentReason = HtmlHelper::toString($getIPs['reason'] ?? '');
                    $blockers = $dbWrapper->getBlockers();
                    
                    $blockerOptions = [];
                    foreach ($blockers as $blockerrow) {
                        $blocker = HtmlHelper::toString($blockerrow['blocker'] ?? '');
                        $blockerOptions[$blocker] = $blockerrow['reason'] ?? $blocker ?: 'Unknown';
                    }
                    echo HtmlHelper::selectOptions($blockerOptions, $currentReason);
                    ?>
                </select>
            </td>
        </tr>
        
        <!-- Separator -->
        <tr>
            <td bgcolor="<?= HtmlHelper::escape($bgcolor2) ?>" colspan="2">&nbsp;</td>
        </tr>
        
        <!-- Query String using centralized processor -->
        <tr>
            <td bgcolor="<?= HtmlHelper::escape($bgcolor2) ?>">
                <strong><?= HtmlHelper::escape(_AB_QUERY ?? 'Query') ?>:</strong>
            </td>
            <td>
                <?php 
                $queryString = QueryStringProcessor::decodeAndClean($getIPs['query_string'] ?? '');
                if (function_exists('info_img')):
                ?>
                    <?= info_img("<strong>" . (_AB_QUERY ?? 'Query') . ":</strong> " . $queryString) ?>
                <?php else: ?>
                    <span title="<?= HtmlHelper::escape($queryString) ?>" style="cursor: help;">
                        <?= HtmlHelper::escape(substr($queryString, 0, 50) . (strlen($queryString) > 50 ? '...' : '')) ?>
                    </span>
                <?php endif; ?>
            </td>
        </tr>
        
        <!-- Read-only fields using centralized helper -->
        <tr>
            <td bgcolor="<?= HtmlHelper::escape($bgcolor2) ?>">
                <strong><?= HtmlHelper::escape(_AB_X_FORWARDED ?? 'X-Forwarded-For') ?>:</strong>
            </td>
            <td><?= HtmlHelper::escape($getIPs['x_forward_for'] ?? '') ?></td>
        </tr>
        
        <tr>
            <td bgcolor="<?= HtmlHelper::escape($bgcolor2) ?>">
                <strong><?= HtmlHelper::escape(_AB_CLIENT_IP ?? 'Client IP') ?>:</strong>
            </td>
            <td><?= HtmlHelper::escape($getIPs['client_ip'] ?? '') ?></td>
        </tr>
        
        <tr>
            <td bgcolor="<?= HtmlHelper::escape($bgcolor2) ?>">
                <strong><?= HtmlHelper::escape(_AB_REMOTE_ADDR ?? 'Remote Address') ?>:</strong>
            </td>
            <td><?= HtmlHelper::escape($getIPs['remote_addr'] ?? '') ?></td>
        </tr>
        
        <tr>
            <td bgcolor="<?= HtmlHelper::escape($bgcolor2) ?>">
                <strong><?= HtmlHelper::escape(_AB_REMOTE_PORT ?? 'Remote Port') ?>:</strong>
            </td>
            <td><?= HtmlHelper::escape($getIPs['remote_port'] ?? '') ?></td>
        </tr>
        
        <tr>
            <td bgcolor="<?= HtmlHelper::escape($bgcolor2) ?>">
                <strong><?= HtmlHelper::escape(_AB_REQUEST_METHOD ?? 'Request Method') ?>:</strong>
            </td>
            <td><?= HtmlHelper::escape($getIPs['request_method'] ?? '') ?></td>
        </tr>
        
        <!-- Submit Button -->
        <tr>
            <td align="center" colspan="2" style="padding-top: 15px;">
                <input type="submit" value="<?= HtmlHelper::escape(_AB_SAVECHANGES ?? 'Save Changes') ?>" class="button" />
                <input type="button" value="Cancel" onclick="history.back();" class="button" style="margin-left: 10px;" />
            </td>
        </tr>
    </table>
</form>

<?php
CloseTable();
include("footer.php");
?>