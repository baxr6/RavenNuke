<?php

/********************************************************/
/* NukeSentinel(tm)                                     */
/* By: NukeScripts(tm) (http://www.nukescripts.net)     */
/* Copyright © 2000-2008 by NukeScripts(tm)             */
/* See CREDITS.txt for ALL contributors                 */
/* Updated for PHP 8.3+ with full backwards compat     */
/********************************************************/

// Security check with early exit
if (!defined('NUKESENTINEL_ADMIN')) {
    header("Location: ../../../" . ($admin_file ?? 'admin') . ".php");
    exit;
}

/**
 * HTML output helper with type safety for PHP 8.3+
 */
class HtmlHelper
{
    public static function escape(mixed $value): string
    {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
    
    public static function escapeAttribute(mixed $value): string
    {
        return htmlspecialchars((string)$value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
    
    public static function toInt(mixed $value): int
    {
        if (is_numeric($value)) {
            return (int)$value;
        }
        return 0;
    }
}

/**
 * Modern database wrapper with backwards compatibility
 */
class DatabaseWrapper
{
    private $db;
    private string $prefix;

    public function __construct($database, string $prefix)
    {
        $this->db = $database;
        $this->prefix = $prefix;
    }

    public function prepareAndExecute(string $query, array $params = [], string $types = ''): array
    {
        // PHP 8.3+ with modern MySQLi
        if ($this->db instanceof mysqli && method_exists($this->db, 'prepare')) {
            try {
                $stmt = $this->db->prepare($query);
                if (!$stmt) {
                    throw new RuntimeException("Prepare failed: " . $this->db->error);
                }

                if (!empty($params)) {
                    if (empty($types)) {
                        // Auto-detect types for PHP 8.3+
                        $types = '';
                        foreach ($params as $param) {
                            if (is_int($param)) $types .= 'i';
                            elseif (is_float($param)) $types .= 'd';
                            else $types .= 's';
                        }
                    }
                    $stmt->bind_param($types, ...$params);
                }

                $stmt->execute();
                $result = $stmt->get_result();
                $data = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
                $stmt->close();
                return $data;
            } catch (Exception $e) {
                error_log("Modern DB Error: " . $e->getMessage());
                return [];
            }
        }

        // Backwards compatibility for older systems
        return $this->legacyQuery($query, $params);
    }

    public function prepareSingle(string $query, array $params = [], string $types = ''): array
    {
        $result = $this->prepareAndExecute($query, $params, $types);
        return $result[0] ?? [];
    }

    private function legacyQuery(string $query, array $params): array
    {
        try {
            // For older PHP-Nuke systems - escape parameters manually
            $escapedParams = [];
            foreach ($params as $param) {
                if (is_string($param)) {
                    // Use mysqli_real_escape_string if available, else addslashes
                    if ($this->db instanceof mysqli) {
                        $escapedParams[] = $this->db->real_escape_string($param);
                    } else {
                        $escapedParams[] = addslashes($param);
                    }
                } else {
                    $escapedParams[] = (string)$param;
                }
            }

            // Simple parameter replacement for backwards compatibility
            $finalQuery = $query;
            foreach ($escapedParams as $param) {
                $finalQuery = preg_replace('/\?/', "'{$param}'", $finalQuery, 1);
            }

            if (method_exists($this->db, 'sql_query')) {
                $result = $this->db->sql_query($finalQuery);
                $data = [];
                if ($result) {
                    while ($row = $this->db->sql_fetchrow($result)) {
                        $data[] = $row;
                    }
                }
                return $data;
            }

            return [];
        } catch (Exception $e) {
            error_log("Legacy DB Error: " . $e->getMessage());
            return [];
        }
    }
}

/**
 * Enhanced input validator with PHP 8.3+ features
 */
class InputValidator
{
    public static function sanitizeString(mixed $input, string $default = ''): string
    {
        if ($input === null) return $default;
        
        // PHP 8.3+ str_* functions with fallback
        if (function_exists('filter_var')) {
            $filtered = filter_var(trim((string)$input), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            return $filtered !== false ? $filtered : $default;
        }
        
        return htmlspecialchars(trim((string)$input), ENT_QUOTES | ENT_HTML5, 'UTF-8') ?: $default;
    }

    public static function validateInt(mixed $input, int $default = 0): int
    {
        if (is_numeric($input)) {
            return (int)$input;
        }
        
        if (function_exists('filter_var')) {
            $filtered = filter_var($input, FILTER_VALIDATE_INT);
            return $filtered !== false ? $filtered : $default;
        }
        
        return $default;
    }

    public static function validateDirection(mixed $direction): string
    {
        $clean = strtoupper(trim((string)($direction ?? '')));
        return in_array($clean, ['ASC', 'DESC'], true) ? $clean : 'ASC';
    }

    public static function sanitizeColumn(mixed $column): string
    {
        if (empty($column)) return '';
        return preg_replace('/[^a-zA-Z0-9_]/', '', (string)$column);
    }
}

/**
 * IP address handler with modern PHP features
 */
class IpAddressHandler
{
    public static function longToIpArray(mixed $longIp): array
    {
        $ip = long2ip(HtmlHelper::toInt($longIp));
        if ($ip === false) {
            return [0, 0, 0, 0];
        }
        
        $parts = explode('.', $ip);
        return array_pad($parts, 4, 0);
    }

    public static function validateIpOctet(mixed $octet): int
    {
        $value = HtmlHelper::toInt($octet);
        return max(0, min(255, $value));
    }
}

// Initialize modern components
$dbWrapper = new DatabaseWrapper($db, $prefix);

// Process inputs with enhanced validation
$sip = InputValidator::sanitizeString($_POST['sip'] ?? null);
$min = InputValidator::validateInt($_POST['min'] ?? null);
$column = InputValidator::sanitizeColumn($_POST['column'] ?? null);
$direction = InputValidator::validateDirection($_POST['direction'] ?? null);
$xop = InputValidator::sanitizeString($xop ?? null);

// Get IP parameters from GET/POST with type safety
$ip_lo_param = InputValidator::validateInt($_GET['ip_lo'] ?? $_POST['ip_lo'] ?? null);
$ip_hi_param = InputValidator::validateInt($_GET['ip_hi'] ?? $_POST['ip_hi'] ?? null);

// Page setup
$pagetitle = (_AB_NUKESENTINEL ?? 'NukeSentinel') . ": " . (_AB_EDITRANGE ?? 'Edit Range');
include("header.php");

OpenTable();
OpenMenu(_AB_EDITRANGE ?? 'Edit Range');
mastermenu();
CarryMenu();
blockedrangemenu();
CloseMenu();
CloseTable();
echo '<br />' . "\n";
OpenTable();

// Fetch IP range data with modern error handling
$getIPs = [];
if ($ip_lo_param > 0 && $ip_hi_param > 0) {
    $query = "SELECT * FROM `{$prefix}_nsnst_blocked_ranges` WHERE `ip_lo` = ? AND `ip_hi` = ? LIMIT 1";
    $getIPs = $dbWrapper->prepareSingle($query, [$ip_lo_param, $ip_hi_param], 'ii');
}

// Error handling for missing data
if (empty($getIPs)) {
    echo '<div style="color: red; font-weight: bold; text-align: center; padding: 20px;">';
    echo 'Error: IP range data not found or invalid parameters provided.';
    echo '</div>';
    CloseTable();
    include("footer.php");
    exit;
}

// Process IP addresses with modern array handling
$ip_lo = IpAddressHandler::longToIpArray($getIPs['ip_lo'] ?? 0);
$ip_hi = IpAddressHandler::longToIpArray($getIPs['ip_hi'] ?? 0);

// Safe access to potentially undefined variables
$bgcolor2 = $bgcolor2 ?? '#EEEEEE';
$admin_file = $admin_file ?? 'admin';

?>

<form action="<?= HtmlHelper::escape($admin_file) ?>.php" method="post">
    <!-- Hidden fields with proper type conversion -->
    <?php 
    $hiddenFields = [
        'op' => 'ABBlockedRangeEditSave',
        'xop' => $xop,
        'sip' => $sip,
        'old_ip_lo' => $getIPs['ip_lo'] ?? '',
        'old_ip_hi' => $getIPs['ip_hi'] ?? '',
        'min' => $min,
        'column' => $column,
        'direction' => $direction
    ];
    
    foreach ($hiddenFields as $name => $value): ?>
        <input type="hidden" name="<?= HtmlHelper::escape($name) ?>" 
               value="<?= HtmlHelper::escape($value) ?>" />
    <?php endforeach; ?>
    
    <table summary="Edit IP Range Form" align="center" border="0" cellpadding="2" cellspacing="2">
        <tr>
            <td align="center" colspan="2">
                <strong><?= HtmlHelper::escape(_AB_EDITRANGES ?? 'Edit IP Ranges') ?></strong>
            </td>
        </tr>
        
        <!-- IP Low Range -->
        <tr>
            <td bgcolor="<?= HtmlHelper::escape($bgcolor2) ?>">
                <strong><?= HtmlHelper::escape(_AB_IPLO ?? 'IP Low') ?>:</strong>
            </td>
            <td>
                <?php for ($i = 0; $i < 4; $i++): 
                    $ipValue = IpAddressHandler::validateIpOctet($ip_lo[$i] ?? 0);
                ?>
                    <?= $i > 0 ? '. ' : '' ?>
                    <input type="text" 
                           name="xip_lo[<?= $i ?>]" 
                           size="4" 
                           maxlength="3" 
                           value="<?= $ipValue ?>" 
                           style="text-align: center;" 
                           pattern="^([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$"
                           title="Enter a number between 0-255" />
                <?php endfor; ?>
            </td>
        </tr>
        
        <!-- IP High Range -->
        <tr>
            <td bgcolor="<?= HtmlHelper::escape($bgcolor2) ?>">
                <strong><?= HtmlHelper::escape(_AB_IPHI ?? 'IP High') ?>:</strong>
            </td>
            <td>
                <?php for ($i = 0; $i < 4; $i++): 
                    $ipValue = IpAddressHandler::validateIpOctet($ip_hi[$i] ?? 0);
                ?>
                    <?= $i > 0 ? '. ' : '' ?>
                    <input type="text" 
                           name="xip_hi[<?= $i ?>]" 
                           size="4" 
                           maxlength="3" 
                           value="<?= $ipValue ?>" 
                           style="text-align: center;" 
                           pattern="^([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$"
                           title="Enter a number between 0-255" />
                <?php endfor; ?>
            </td>
        </tr>
        
        <!-- Expiration -->
        <tr>
            <td bgcolor="<?= HtmlHelper::escape($bgcolor2) ?>" valign="top">
                <strong><?= HtmlHelper::escape(_AB_EXPIRESIN ?? 'Expires In') ?>:</strong>
            </td>
            <td>
                <select name="xexpires">
                    <option value="0"<?= HtmlHelper::toInt($getIPs['expires'] ?? 0) === 0 ? ' selected="selected"' : '' ?>>
                        <?= HtmlHelper::escape(_AB_PERMENANT ?? 'Permanent') ?>
                    </option>
                    <?php 
                    $currentExpires = HtmlHelper::toInt($getIPs['expires'] ?? 0);
                    for ($i = 1; $i <= 365; $i++): 
                        $expireDate = date("Y-m-d", time() + ($i * 86400));
                        $selected = $currentExpires === $i ? ' selected="selected"' : '';
                    ?>
                        <option value="<?= $i ?>"<?= $selected ?>>
                            <?= $i ?> (<?= HtmlHelper::escape($expireDate) ?>)
                        </option>
                    <?php endfor; ?>
                </select><br />
                <small><?= HtmlHelper::escape(_AB_EXPIRESINS ?? 'Days until expiration') ?></small>
            </td>
        </tr>
        
        <!-- Notes -->
        <tr>
            <td bgcolor="<?= HtmlHelper::escape($bgcolor2) ?>" valign="top">
                <strong><?= HtmlHelper::escape(_AB_NOTES ?? 'Notes') ?>:</strong>
            </td>
            <td>
                <textarea name="xnotes" rows="10" cols="60" placeholder="Enter notes about this IP range..."><?= HtmlHelper::escape($getIPs['notes'] ?? '') ?></textarea>
            </td>
        </tr>
        
        <!-- Reason/Blocker -->
        <tr>
            <td bgcolor="<?= HtmlHelper::escape($bgcolor2) ?>">
                <strong><?= HtmlHelper::escape(_AB_REASON ?? 'Reason') ?>:</strong>
            </td>
            <td>
                <select name="xreason">
                    <option value="">-- Select Reason --</option>
                    <?php
                    $currentReason = (string)($getIPs['reason'] ?? '');
                    $blockers = $dbWrapper->prepareAndExecute("SELECT * FROM `{$prefix}_nsnst_blockers` ORDER BY `block_name`");
                    
                    foreach ($blockers as $blockerrow): 
                        $blockerValue = (string)($blockerrow['blocker'] ?? '');
                        $selected = $currentReason === $blockerValue ? ' selected="selected"' : '';
                    ?>
                        <option value="<?= HtmlHelper::escape($blockerValue) ?>"<?= $selected ?>>
                            <?= HtmlHelper::escape($blockerrow['reason'] ?? $blockerValue ?: 'Unknown') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        
        <!-- Country -->
        <tr>
            <td bgcolor="<?= HtmlHelper::escape($bgcolor2) ?>">
                <strong><?= HtmlHelper::escape(_AB_COUNTRY ?? 'Country') ?>:</strong>
            </td>
            <td>
                <select name="xc2c">
                    <option value="">-- Select Country --</option>
                    <?php
                    $currentCountry = (string)($getIPs['c2c'] ?? '');
                    $countries = $dbWrapper->prepareAndExecute("SELECT * FROM `{$prefix}_nsnst_countries` ORDER BY `c2c`");
                    
                    foreach ($countries as $countryrow): 
                        $c2c = (string)($countryrow['c2c'] ?? '');
                        $selected = $currentCountry === $c2c ? ' selected="selected"' : '';
                    ?>
                        <option value="<?= HtmlHelper::escape($c2c) ?>"<?= $selected ?>>
                            <?= strtoupper(HtmlHelper::escape($c2c)) ?> - 
                            <?= HtmlHelper::escape($countryrow['country'] ?? 'Unknown') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        
        <!-- Submit -->
        <tr>
            <td align="center" colspan="2" style="padding-top: 15px;">
                <input type="submit" 
                       value="<?= HtmlHelper::escape(_AB_SAVECHANGES ?? 'Save Changes') ?>" 
                       class="button" />
                <input type="button" 
                       value="Cancel" 
                       onclick="history.back();" 
                       class="button" 
                       style="margin-left: 10px;" />
            </td>
        </tr>
    </table>
</form>

<?php
CloseTable();
include("footer.php");
?>