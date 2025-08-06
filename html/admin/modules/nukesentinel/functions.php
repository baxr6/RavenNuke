<?php

/********************************************************/
/* NukeSentinel(tm)                                     */
/* By: NukeScripts(tm) (http://www.nukescripts.net)     */
/* Copyright � 2000-2008 by NukeScripts(tm)             */
/* See CREDITS.txt for ALL contributors                 */
/********************************************************/

if(!defined('NUKESENTINEL_ADMIN')) { header("Location: ../../../".$admin_file.".php"); }



/********************************************************/
/* NukeSentinel(tm) Modern Functions Library           */
/* By: NukeScripts(tm) (http://www.nukescripts.net)     */
/* Copyright © 2000-2008 by NukeScripts(tm)             */
/* Modernized for PHP 8.3+ with backwards compatibility */
/********************************************************/

// Prevent direct access
if (!defined('NUKESENTINEL_ADMIN') && !defined('NUKESENTINEL_FUNCTIONS')) {
    die("You can't access this file directly...");
}

// Define version constant
if (!defined('NUKESENTINEL_FUNCTIONS_VERSION')) {
    define('NUKESENTINEL_FUNCTIONS_VERSION', '3.0.0');
}

/**
 * HTML output helper with type safety for PHP 8.3+
 * Handles all HTML escaping and type conversion needs
 */
class HtmlHelper
{
    /**
     * Escape string for HTML output with type safety
     */
    public static function escape(mixed $value): string
    {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Escape string for HTML attributes with enhanced flags
     */
    public static function escapeAttribute(mixed $value): string
    {
        return htmlspecialchars((string)$value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
    
    /**
     * Safe integer conversion
     */
    public static function toInt(mixed $value): int
    {
        if (is_numeric($value)) {
            return (int)$value;
        }
        return 0;
    }
    
    /**
     * Safe string conversion
     */
    public static function toString(mixed $value): string
    {
        return (string)($value ?? '');
    }

    /**
     * Safe float conversion
     */
    public static function toFloat(mixed $value): float
    {
        if (is_numeric($value)) {
            return (float)$value;
        }
        return 0.0;
    }

    /**
     * Generate HTML select options
     */
    public static function selectOptions(array $options, mixed $selected = null): string
    {
        $html = '';
        $selectedValue = self::toString($selected);
        
        foreach ($options as $value => $text) {
            $isSelected = (self::toString($value) === $selectedValue) ? ' selected="selected"' : '';
            $html .= '<option value="' . self::escape($value) . '"' . $isSelected . '>';
            $html .= self::escape($text) . '</option>' . "\n";
        }
        
        return $html;
    }
}

/**
 * Modern database wrapper with backwards compatibility
 * Supports both MySQLi prepared statements and legacy PHP-Nuke methods
 */
class DatabaseWrapper
{
    private $db;
    private string $prefix;
    private bool $useModernMethods;

    public function __construct($database, string $prefix)
    {
        $this->db = $database;
        $this->prefix = $prefix;
        $this->useModernMethods = ($this->db instanceof mysqli && method_exists($this->db, 'prepare'));
    }

    /**
     * Execute query with parameters and return all results
     */
    public function prepareAndExecute(string $query, array $params = [], string $types = ''): array
    {
        try {
            if ($this->useModernMethods) {
                return $this->executeModernQuery($query, $params, $types);
            }
            
            return $this->executeLegacyQuery($query, $params);
            
        } catch (Exception $e) {
            error_log("Database error in prepareAndExecute: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Execute query and return single row
     */
    public function prepareSingle(string $query, array $params = [], string $types = ''): array
    {
        $result = $this->prepareAndExecute($query, $params, $types);
        return $result[0] ?? [];
    }

    /**
     * Execute query and return number of affected rows
     */
    public function executeUpdate(string $query, array $params = [], string $types = ''): int
    {
        try {
            if ($this->useModernMethods) {
                $stmt = $this->db->prepare($query);
                if (!$stmt) {
                    throw new RuntimeException("Prepare failed: " . $this->db->error);
                }

                if (!empty($params)) {
                    if (empty($types)) {
                        $types = $this->detectTypes($params);
                    }
                    $stmt->bind_param($types, ...$params);
                }

                $stmt->execute();
                $affectedRows = $stmt->affected_rows;
                $stmt->close();
                return $affectedRows;
            }

            // Legacy method
            $escapedQuery = $this->buildLegacyQuery($query, $params);
            $result = $this->db->sql_query($escapedQuery);
            return $this->db->sql_affectedrows() ?? 0;

        } catch (Exception $e) {
            error_log("Database error in executeUpdate: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Delete records with prepared statement
     */
    public function deleteRecord(string $table, string $whereField, mixed $whereValue): bool
    {
        $query = "DELETE FROM `{$this->prefix}_{$table}` WHERE `{$whereField}` = ?";
        return $this->executeUpdate($query, [$whereValue]) > 0;
    }

    /**
     * Optimize table
     */
    public function optimizeTable(string $table): bool
    {
        try {
            $query = "OPTIMIZE TABLE `{$this->prefix}_{$table}`";
            
            if ($this->useModernMethods) {
                return (bool)$this->db->query($query);
            }
            
            return (bool)$this->db->sql_query($query);
            
        } catch (Exception $e) {
            error_log("Database error in optimizeTable: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get blocked IP data
     */
    public function getBlockedIp(string $ipAddr): array
    {
        $query = "SELECT * FROM `{$this->prefix}_nsnst_blocked_ips` WHERE `ip_addr` = ? LIMIT 1";
        return $this->prepareSingle($query, [$ipAddr], 's');
    }

    /**
     * Get blocked IP range data
     */
    public function getBlockedRange(int $ipLo, int $ipHi): array
    {
        $query = "SELECT * FROM `{$this->prefix}_nsnst_blocked_ranges` WHERE `ip_lo` = ? AND `ip_hi` = ? LIMIT 1";
        return $this->prepareSingle($query, [$ipLo, $ipHi], 'ii');
    }

    /**
     * Get countries list
     */
    public function getCountries(): array
    {
        $query = "SELECT * FROM `{$this->prefix}_nsnst_countries` ORDER BY `c2c`";
        return $this->prepareAndExecute($query);
    }

    /**
     * Get blockers list
     */
    public function getBlockers(): array
    {
        $query = "SELECT * FROM `{$this->prefix}_nsnst_blockers` ORDER BY `block_name`";
        return $this->prepareAndExecute($query);
    }

    /**
     * Execute modern MySQLi prepared statement
     */
    private function executeModernQuery(string $query, array $params, string $types): array
    {
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new RuntimeException("Prepare failed: " . $this->db->error);
        }

        if (!empty($params)) {
            if (empty($types)) {
                $types = $this->detectTypes($params);
            }
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        
        $data = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        
        $stmt->close();
        return $data;
    }

    /**
     * Execute legacy query with parameter escaping
     */
    private function executeLegacyQuery(string $query, array $params): array
    {
        $escapedQuery = $this->buildLegacyQuery($query, $params);
        $result = $this->db->sql_query($escapedQuery);
        
        $data = [];
        if ($result) {
            while ($row = $this->db->sql_fetchrow($result)) {
                $data[] = $row;
            }
        }
        
        return $data;
    }

    /**
     * Build legacy query with escaped parameters
     */
    private function buildLegacyQuery(string $query, array $params): string
    {
        $escapedParams = array_map([$this, 'escapeParameter'], $params);
        
        $finalQuery = $query;
        foreach ($escapedParams as $param) {
            $finalQuery = preg_replace('/\?/', $param, $finalQuery, 1);
        }
        
        return $finalQuery;
    }

    /**
     * Escape parameter for legacy queries
     */
    private function escapeParameter(mixed $param): string
    {
        if ($param === null) {
            return 'NULL';
        }
        
        if (is_bool($param)) {
            return $param ? '1' : '0';
        }
        
        if (is_numeric($param)) {
            return (string)$param;
        }
        
        $escaped = $this->escapeString((string)$param);
        return "'{$escaped}'";
    }

    /**
     * Auto-detect parameter types for prepared statements
     */
    private function detectTypes(array $params): string
    {
        $types = '';
        foreach ($params as $param) {
            if (is_int($param)) {
                $types .= 'i';
            } elseif (is_float($param)) {
                $types .= 'd';
            } elseif (is_bool($param)) {
                $types .= 'i';
            } else {
                $types .= 's';
            }
        }
        return $types;
    }

    /**
     * Escape string for database
     */
    private function escapeString(string $string): string
    {
        if ($this->db instanceof mysqli) {
            return $this->db->real_escape_string($string);
        }
        return addslashes($string);
    }
}

/**
 * Enhanced input validator with PHP 8.3+ features and security
 */
class InputValidator
{
    /**
     * Sanitize string input with default fallback
     */
    public static function sanitizeString(mixed $input, string $default = ''): string
    {
        if ($input === null) {
            return $default;
        }
        
        $cleaned = trim((string)$input);
        
        // Use filter_var if available for enhanced sanitization
        if (function_exists('filter_var')) {
            $filtered = filter_var($cleaned, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            return $filtered !== false ? $filtered : $default;
        }
        
        return htmlspecialchars($cleaned, ENT_QUOTES | ENT_HTML5, 'UTF-8') ?: $default;
    }

    /**
     * Validate and convert to integer
     */
    public static function validateInt(mixed $input, int $default = 0, int $min = PHP_INT_MIN, int $max = PHP_INT_MAX): int
    {
        if (is_numeric($input)) {
            $value = (int)$input;
            return max($min, min($max, $value));
        }
        
        if (function_exists('filter_var')) {
            $filtered = filter_var($input, FILTER_VALIDATE_INT, [
                'options' => ['min_range' => $min, 'max_range' => $max]
            ]);
            return $filtered !== false ? $filtered : $default;
        }
        
        return $default;
    }

    /**
     * Validate direction parameter (ASC/DESC)
     */
    public static function validateDirection(mixed $direction): string
    {
        $clean = strtoupper(trim((string)($direction ?? '')));
        return in_array($clean, ['ASC', 'DESC'], true) ? $clean : 'ASC';
    }

    /**
     * Sanitize database column name
     */
    public static function sanitizeColumn(mixed $column): string
    {
        if (empty($column)) {
            return '';
        }
        return preg_replace('/[^a-zA-Z0-9_]/', '', (string)$column);
    }

    /**
     * Sanitize IP address (allow wildcards)
     */
    public static function sanitizeIp(mixed $input): string
    {
        $ip = self::sanitizeString($input);
        
        // Allow IP addresses with wildcards and dots
        if (preg_match('/^[0-9.*]+$/', $ip)) {
            return $ip;
        }
        
        return '';
    }

    /**
     * Validate email address
     */
    public static function validateEmail(mixed $email): string
    {
        $email = self::sanitizeString($email);
        
        if (function_exists('filter_var')) {
            $filtered = filter_var($email, FILTER_VALIDATE_EMAIL);
            return $filtered !== false ? $filtered : '';
        }
        
        // Basic email validation fallback
        if (preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $email)) {
            return $email;
        }
        
        return '';
    }

    /**
     * Validate URL
     */
    public static function validateUrl(mixed $url): string
    {
        $url = self::sanitizeString($url);
        
        if (function_exists('filter_var')) {
            $filtered = filter_var($url, FILTER_VALIDATE_URL);
            return $filtered !== false ? $filtered : '';
        }
        
        return $url;
    }
}

/**
 * IP address handler with modern PHP features
 */
class IpAddressHandler
{
    /**
     * Convert long IP to array of octets
     */
    public static function longToIpArray(mixed $longIp): array
    {
        $ip = long2ip(HtmlHelper::toInt($longIp));
        if ($ip === false) {
            return [0, 0, 0, 0];
        }
        
        $parts = explode('.', $ip);
        return array_pad($parts, 4, 0);
    }

    /**
     * Parse IP string to array
     */
    public static function parseIp(string $ip): array
    {
        $parts = explode(".", $ip);
        return array_pad($parts, 4, '');
    }

    /**
     * Validate IP octet (0-255 or wildcard)
     */
    public static function validateIpOctet(mixed $octet): string
    {
        $value = HtmlHelper::toString($octet);
        
        // Allow wildcards and empty values
        if ($value === '*' || $value === '') {
            return $value;
        }
        
        // Validate numeric range
        if (is_numeric($value)) {
            $num = (int)$value;
            return ($num >= 0 && $num <= 255) ? (string)$num : '';
        }
        
        return '';
    }

    /**
     * Convert IP array back to string
     */
    public static function arrayToIp(array $ipArray): string
    {
        $cleaned = array_map([self::class, 'validateIpOctet'], $ipArray);
        return implode('.', array_slice($cleaned, 0, 4));
    }

    /**
     * Validate complete IP address or pattern
     */
    public static function validateIpPattern(string $ip): bool
    {
        // Allow individual IP addresses
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            return true;
        }

        // Allow partial IP patterns (e.g., "192.168.1.*" or "10.0")
        $parts = explode('.', $ip);
        if (count($parts) <= 4) {
            foreach ($parts as $part) {
                if ($part !== '*' && $part !== '') {
                    if (!is_numeric($part) || (int)$part < 0 || (int)$part > 255) {
                        return false;
                    }
                }
            }
            return true;
        }

        return false;
    }
}

/**
 * .htaccess file manager with enhanced security
 */
class HtaccessManager
{
    private string $htaccessPath;

    public function __construct(string $path)
    {
        $this->htaccessPath = $path;
    }

    /**
     * Remove IP from .htaccess file
     */
    public function removeIpFromHtaccess(string $ip): bool
    {
        if (!$this->validatePath()) {
            return false;
        }

        try {
            $cleanIp = $this->cleanIpFormat($ip);
            
            if (!IpAddressHandler::validateIpPattern($cleanIp)) {
                error_log("Invalid IP pattern provided: " . $ip);
                return false;
            }

            $content = file_get_contents($this->htaccessPath);
            if ($content === false) {
                throw new RuntimeException("Failed to read htaccess file");
            }

            $updatedContent = $this->removeDenyDirectives($content, $cleanIp);
            return $this->atomicFileWrite($this->htaccessPath, $updatedContent);

        } catch (Exception $e) {
            error_log("Htaccess update error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Add IP to .htaccess file
     */
    public function addIpToHtaccess(string $ip): bool
    {
        if (!$this->validatePath()) {
            return false;
        }

        try {
            $cleanIp = $this->cleanIpFormat($ip);
            
            if (!IpAddressHandler::validateIpPattern($cleanIp)) {
                error_log("Invalid IP pattern provided: " . $ip);
                return false;
            }

            $content = file_get_contents($this->htaccessPath);
            if ($content === false) {
                throw new RuntimeException("Failed to read htaccess file");
            }

            $denyDirective = "deny from " . $cleanIp . "\n";
            
            // Check if already exists
            if (strpos($content, $denyDirective) === false) {
                $content .= $denyDirective;
                return $this->atomicFileWrite($this->htaccessPath, $content);
            }

            return true; // Already exists

        } catch (Exception $e) {
            error_log("Htaccess add error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Validate htaccess path
     */
    private function validatePath(): bool
    {
        if (empty($this->htaccessPath) || !file_exists($this->htaccessPath)) {
            error_log("Htaccess file not found: " . $this->htaccessPath);
            return false;
        }

        if (!is_writable($this->htaccessPath)) {
            error_log("Htaccess file not writable: " . $this->htaccessPath);
            return false;
        }

        return true;
    }

    /**
     * Clean IP format (remove trailing .* patterns)
     */
    private function cleanIpFormat(string $ip): string
    {
        $cleanIp = $ip;
        
        // Remove up to 3 trailing .* patterns (as per original logic)
        for ($i = 1; $i <= 3; $i++) {
            if (str_ends_with($cleanIp, ".*")) {
                $cleanIp = substr($cleanIp, 0, -2);
            }
        }

        return $cleanIp;
    }

    /**
     * Remove deny directives from content
     */
    private function removeDenyDirectives(string $content, string $ip): string
    {
        $denyPattern = "deny from " . $ip . "\n";
        $updatedContent = str_replace($denyPattern, "", $content);

        // Also try to remove without newline (in case it's at the end)
        $denyPatternNoNewline = "deny from " . $ip;
        $updatedContent = str_replace($denyPatternNoNewline, "", $updatedContent);

        return $updatedContent;
    }

    /**
     * Atomic file write operation
     */
    private function atomicFileWrite(string $filename, string $content): bool
    {
        $tempFile = $filename . '.tmp.' . uniqid();
        
        try {
            if (file_put_contents($tempFile, $content, LOCK_EX) === false) {
                throw new RuntimeException("Failed to write temporary file");
            }

            if (!rename($tempFile, $filename)) {
                throw new RuntimeException("Failed to rename temporary file");
            }

            return true;

        } catch (Exception $e) {
            if (file_exists($tempFile)) {
                @unlink($tempFile);
            }
            throw $e;
        }
    }
}

/**
 * Query string decoder with security
 */
class QueryStringProcessor
{
    /**
     * Decode and clean base64 encoded query string
     */
    public static function decodeAndClean(mixed $queryString): string
    {
        if (empty($queryString)) {
            return '';
        }
        
        try {
            // Decode base64
            $decoded = base64_decode((string)$queryString, true);
            if ($decoded === false) {
                return 'Invalid base64 data';
            }
            
            // HTML entity decode
            $decoded = html_entity_decode($decoded, ENT_QUOTES, 'UTF-8');
            
            // Clean up common encoded characters
            $decoded = str_replace("%20", " ", $decoded);
            $decoded = str_replace("/**/", "/* */", $decoded);
            
            // Escape for safe HTML display
            return htmlspecialchars($decoded, ENT_QUOTES, 'UTF-8');
            
        } catch (Exception $e) {
            error_log("Error decoding query string: " . $e->getMessage());
            return 'Error decoding query string';
        }
    }

    /**
     * Safely encode query string for storage
     */
    public static function encodeForStorage(string $queryString): string
    {
        return base64_encode($queryString);
    }
}

/**
 * Utility functions for common operations
 */
class NukeSentinelUtils
{
    /**
     * Build redirect URL with parameters
     */
    public static function buildRedirectUrl(string $baseFile, array $params = []): string
    {
        $queryString = http_build_query(array_filter($params, function($value) {
            return $value !== '' && $value !== 0 && $value !== null;
        }));

        $url = $baseFile . ".php";
        if (!empty($queryString)) {
            $url .= "?" . $queryString;
        }

        return $url;
    }

    /**
     * Calculate expiration in days
     */
    public static function calculateExpirationDays(mixed $expirationTimestamp): int
    {
        if (empty($expirationTimestamp) || !is_numeric($expirationTimestamp)) {
            return 0;
        }

        $days = round(((int)$expirationTimestamp - time()) / 86400);
        return max(0, $days);
    }

    /**
     * Format timestamp to readable date
     */
    public static function formatDate(mixed $timestamp, string $format = "Y-m-d H:i:s"): string
    {
        if (empty($timestamp)) {
            return date($format);
        }

        if (is_numeric($timestamp)) {
            return date($format, (int)$timestamp);
        }

        return (string)$timestamp;
    }

    /**
     * Generate expiration options for select dropdown
     */
    public static function generateExpirationOptions(int $currentExpiration = 0): array
    {
        $options = [0 => _AB_PERMENANT ?? 'Permanent'];
        
        for ($i = 1; $i <= 365; $i++) {
            $expireDate = date("Y-m-d", time() + ($i * 86400));
            $options[$i] = $i . ' (' . $expireDate . ')';
        }

        return $options;
    }
}

// Mark functions as loaded
if (!defined('NUKESENTINEL_FUNCTIONS')) {
    define('NUKESENTINEL_FUNCTIONS', true);
}


function abget_country($tempip){
  global $prefix, $db;
  $tempip = str_replace(".*", ".0", $tempip);
  $tempip = sprintf("%u", ip2long($tempip));
  $countryinfo = $db->sql_fetchrow($db->sql_query("SELECT `c2c` FROM `".$prefix."_nsnst_ip2country` WHERE `ip_lo`<='$tempip' AND `ip_hi`>='$tempip' LIMIT 0,1"));
  $ctitle = abget_countrytitle($countryinfo['c2c']);
  $countryinfo['country'] = $ctitle['country'];
  if(!$countryinfo) {
	 $countryinfo['c2c'] = "00";
	 $countryinfo['country'] = _AB_UNKNOWN;
  } else {
	 if(!file_exists("images/nukesentinel/countries/".$countryinfo['c2c'].".png")) { $countryinfo['c2c']="00"; }
  }
  return $countryinfo;
}

function abget_countrytitle($c2c){
  global $prefix, $db;
  $countrytitleinfo = $db->sql_fetchrow($db->sql_query("SELECT * FROM `".$prefix."_nsnst_countries` WHERE `c2c`='$c2c' LIMIT 0,1"));
  if(!$countrytitleinfo) {
	 $countrytitleinfo['c2c'] = "00";
	 $countrytitleinfo['country'] = _AB_UNKNOWN;
  } else {
	 if(!file_exists("images/nukesentinel/countries/".$countrytitleinfo['c2c'].".png")) { $countrytitleinfo['c2c']="00"; }
  }
  return $countrytitleinfo;
}

function absave_config($config_name, $config_value){
  global $prefix, $db;
	 $config_name = addslashes($config_name) ? addslashes($config_name) : '';
	 $config_value = addslashes($config_value) ? addslashes($config_value) : '';
  $resultnum = $db->sql_numrows($db->sql_query("SELECT * FROM `".$prefix."_nsnst_config` WHERE `config_name`='$config_name' LIMIT 0,1"));
  if($resultnum < 1) {
	 $db->sql_query("INSERT INTO `".$prefix."_nsnst_config` (`config_name`, `config_value`) VALUES ('$config_name', '$config_value')");
  } else {
	 $db->sql_query("UPDATE `".$prefix."_nsnst_config` SET `config_value`='$config_value' WHERE `config_name`='$config_name'");
  }
}

function blankmenu() {
  echo '<div class="text-center"><br /><img src="images/nukesentinel/welcome.png" height="200" width="120" alt="" title="" /></div>'."\n";
}

function mastermenu() {
  global $ab_config, $getAdmin, $prefix, $db, $op, $admin, $admin_file;
  $sapi_name = strtolower(php_sapi_name());
  $checkrow = $db->sql_numrows($db->sql_query("SELECT * FROM `".$prefix."_nsnst_ip2country`"));
  if($checkrow > 0) { $tableexist = 1; } else { $tableexist = 0; }
  echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="2" width="90%">'."\n";
  echo '<tr>'."\n";
  echo '<td valign="top" width="50%">'."\n";
  echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="2">'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_023).'</td><td><a href="'.$admin_file.'.php?op=ABMain">'._AB_ADMINISTRATION.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_065).'</td><td><a href="'.$admin_file.'.php?op=ABBlockedIPMenu">'._AB_BLOCKEDIPMENU.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_097).'</td><td><a href="'.$admin_file.'.php?op=ABBlockedRangeMenu">'._AB_BLOCKEDRANGEMENU.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_098).'</td><td><a href="'.$admin_file.'.php?op=ABExcludedMenu">'._AB_EXCLUDEDRANGEMENU.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_099).'</td><td><a href="'.$admin_file.'.php?op=ABProtectedMenu">'._AB_PROTECTEDRANGEMENU.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_066).'</td><td><a href="'.$admin_file.'.php?op=ABTrackedMenu">'._AB_TRACKEDIPMENU.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_117).'</td><td><a href="'.$admin_file.'.php?op=ABCountryList">'._AB_COUNTRYLISTING.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_058).'</td>';
  if(is_god()) {
	 echo '<td><a href="'.$admin_file.'.php?op=ABDBMaintenance">'._AB_DBMAINTENANCE.'</a></td></tr>'."\n";
  } else {
	 echo '<td>'._AB_DBMAINTENANCE.'</td></tr>'."\n";
  }
  echo '</table>'."\n";
  echo '</td>'."\n";
  echo '<td valign="top" width="50%">'."\n";
  echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="2">'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_024).'</td><td><a href="'.$admin_file.'.php?op=ABConfig">'._AB_BLOCKERCONFIG.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_030).'</td><td><a href="'.$admin_file.'.php?op=ABSearch">'._AB_SEARCH.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_077).'</td><td><a href="'.$admin_file.'.php?op=ABIP2CountryMenu">'._AB_IP2COUNTRYMENU.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_075).'</td><td><a href="'.$admin_file.'.php?op=ABTemplate">'._AB_TEMPLATEMENU.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_019).'</td><td><a href="'.$admin_file.'.php?op=ABHarvesterMenu">'._AB_HARVESTERMENU.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_020).'</td><td><a href="'.$admin_file.'.php?op=ABRefererMenu">'._AB_REFERERMENU.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_022).'</td><td><a href="'.$admin_file.'.php?op=ABStringMenu">'._AB_STRINGMENU.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_095).'</td>';
  if(is_god()) {
	 echo '<td><a href="'.$admin_file.'.php?op=ABAuth">'._AB_HTTPAUTHMENU.'</a></td></tr>'."\n";
  } else {
	 echo '<td>'._AB_HTTPAUTHMENU.'</td></tr>'."\n";
  }
  echo '</table>'."\n";
  echo '</td>'."\n";
  echo '</tr>'."\n";
  echo '<tr>'."\n";
  echo '<td align="center" colspan="2">'.help_img(_AB_HELP_025).' <a href="'.$admin_file.'.php">'._AB_SITEADMIN.'</a></td>'."\n";
  echo '</tr>'."\n";
  echo '<tr><td align="center" colspan="2">';
  if($ab_config['help_switch'] > 0) { echo _AB_HELPNOTE1; } else { echo _AB_HELPNOTE0; }
  echo '</td></tr>'."\n";
  echo '</table>'."\n";
}

function authmenu() {
  global $op, $sip, $nuke_config, $admin_file;
  echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="2">'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_031).'</td>';
  if(is_god()) {
	 echo '<td><a href="'.$admin_file.'.php?op=ABAuthList">'._AB_LISTHTTPAUTH.'</a></td></tr>'."\n";
  } else {
	 echo '<td>'._AB_LISTHTTPAUTH.'</td></tr>'."\n";
  }
  echo '<tr><td>'.help_img(_AB_HELP_032).'</td>';
  if(is_god()) {
	 echo '<td><a class="rn_csrf" href="'.$admin_file.'.php?op=ABAuthScan">'._AB_SCANADMINS.'</a></td></tr>'."\n";
  } else {
	 echo '<td>'._AB_SCANADMINS.'</td></tr>'."\n";
  }
  echo '</table>'."\n";
}

function searchmenu() {
  global $op, $sip, $nuke_config, $admin_file;
  echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="2">'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_088).'</td><td><a href="'.$admin_file.'.php?op=ABSearchIPResults">'._AB_SEARCHIPS.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_092).'</td><td><a href="'.$admin_file.'.php?op=ABSearchRangeResults">'._AB_SEARCHRANGES.'</a></td></tr>'."\n";
  echo '</table>'."\n";
}

function configmenu() {
  global $ab_config, $admin_file;
  echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="2" width="90%">'."\n";
  echo '<tr>'."\n";
  echo '<td align="left" valign="top" width="33%">'."\n";
  echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="0">'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_074).'</td><td><a href="'.$admin_file.'.php?op=ABConfigDefault">'._AB_DEFAULTBLOCKER.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_064).'</td><td><a href="'.$admin_file.'.php?op=ABConfigAdmin">'._AB_ADMINBLOCKER.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_033).'</td><td><a href="'.$admin_file.'.php?op=ABConfigAuthor">'._AB_AUTHORBLOCKER.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_034).'</td><td><a href="'.$admin_file.'.php?op=ABConfigClike">'._AB_CLIKEBLOCKER.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_035).'</td><td><a href="'.$admin_file.'.php?op=ABConfigUnion">'._AB_UNIONBLOCKER.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_036).'</td><td><a href="'.$admin_file.'.php?op=ABConfigFilter">'._AB_FILTERBLOCKER.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_120).'</td><td><a href="'.$admin_file.'.php?op=ABConfigFlood">'._AB_FLOODBLOCKER.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_039).'</td><td><a href="'.$admin_file.'.php?op=ABConfigScript">'._AB_SCRIPTBLOCKER.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_037).'</td><td><a href="'.$admin_file.'.php?op=ABConfigHarvester">'._AB_HARVESTBLOCKER.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_038).'</td><td><a href="'.$admin_file.'.php?op=ABConfigReferer">'._AB_REFERERBLOCKER.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_040).'</td><td><a href="'.$admin_file.'.php?op=ABConfigRequest">'._AB_REQUESTBLOCKER.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_041).'</td><td><a href="'.$admin_file.'.php?op=ABConfigString">'._AB_STRINGBLOCKER.'</a></td></tr>'."\n";
  echo '</table>'."\n";
  echo '</td>'."\n";
  echo '</tr>'."\n";
  echo '</table>'."\n";
}

function databasemenu() {
  global $admin, $admin_file;
  echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="2" width="90%">'."\n";
  echo '<tr>'."\n";
  echo '<td align="left" valign="top" width="33%">'."\n";
  echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="0">'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_059).'</td><td><a class="rn_csrf" href="'.$admin_file.'.php?op=ABDBStructure">'._AB_DBSTRUCTURE.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_060).'</td><td><a class="rn_csrf" href="'.$admin_file.'.php?op=ABDBOptimize">'._AB_DBOPTIMIZE.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_061).'</td><td><a class="rn_csrf" href="'.$admin_file.'.php?op=ABDBRepair">'._AB_DBREPAIR.'</a></td></tr>'."\n";
  echo '</table>'."\n";
  echo '</td>'."\n";
  echo '</tr>'."\n";
  echo '</table>'."\n";
}

function ip2cmenu() {
  global $admin, $admin_file;
  echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="2" width="90%">'."\n";
  echo '<tr>'."\n";
  echo '<td align="left" valign="top" width="33%">'."\n";
  echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="0">'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_085).'</td><td><a href="'.$admin_file.'.php?op=ABIP2CountryAdd">'._AB_IP2CADD.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_079).'</td><td><a href="'.$admin_file.'.php?op=ABIP2CountryList">'._AB_IP2CLISTING.'</a></td></tr>'."\n";
	 echo '<tr><td>'.help_img(_AB_HELP_083).'</td><td><a class="rn_csrf" href="'.$admin_file.'.php?op=ABIP2CountryUpdateBlocked">'._AB_IP2CUPDATEBLOCKED.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_084).'</td><td><a class="rn_csrf" href="'.$admin_file.'.php?op=ABIP2CountryUpdateTracked">'._AB_IP2CUPDATETRACKED.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_110).'</td><td><a class="rn_csrf" href="'.$admin_file.'.php?op=ABIP2CountryUpdateBlockedRanges">'._AB_IP2CUPDATEBLOCKEDRANGES.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_111).'</td><td><a class="rn_csrf" href="'.$admin_file.'.php?op=ABIP2CountryUpdateExcludedRanges">'._AB_IP2CUPDATEEXCLUDEDRANGES.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_112).'</td><td><a class="rn_csrf" href="'.$admin_file.'.php?op=ABIP2CountryUpdateProtectedRanges">'._AB_IP2CUPDATEPROTECTEDRANGES.'</a></td></tr>'."\n";
  echo '</table>'."\n";
  echo '</td>'."\n";
  echo '</tr>'."\n";
  echo '</table>'."\n";
}

function excludedmenu() {
  global $admin, $admin_file;
  echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="2" width="90%">'."\n";
  echo '<tr>'."\n";
  echo '<td align="left" valign="top" width="33%">'."\n";
  echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="0">'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_100).'</td><td><a href="'.$admin_file.'.php?op=ABExcludedAdd">'._AB_ADDEXCLUDED.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_102).'</td><td><a href="'.$admin_file.'.php?op=ABExcludedList">'._AB_EXCLUDEDLISTING.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_103).'</td><td><a href="'.$admin_file.'.php?op=ABExcludedListPrint" target="_blank">'._AB_PRINTEXCLUDEDRANGES.'</a></td></tr>'."\n";
  echo '<tr><td>&nbsp;</td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_069).'</td><td><a href="'.$admin_file.'.php?op=ABExcludedOverlapCheck">'._AB_EXCLUDEDOVERLAPCHECK.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_101).'</td><td><a href="'.$admin_file.'.php?op=ABExcludedClear">'._AB_CLEAREXCLUDED.'</a></td></tr>'."\n";
  echo '</table>'."\n";
  echo '</td>'."\n";
  echo '</tr>'."\n";
  echo '</table>'."\n";
}

function harvestermenu() {
  global $admin, $admin_file;
  echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="2" width="90%">'."\n";
  echo '<tr>'."\n";
  echo '<td align="left" valign="top" width="33%">'."\n";
  echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="0">'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_122).'</td><td><a href="'.$admin_file.'.php?op=ABHarvesterAdd">'._AB_ADDHARVESTER.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_123).'</td><td><a href="'.$admin_file.'.php?op=ABHarvesterList">'._AB_HARVESTERLISTING.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_124).'</td><td><a href="'.$admin_file.'.php?op=ABHarvesterListPrint" target="_blank">'._AB_PRINTHARVESTERS.'</a></td></tr>'."\n";
  echo '</table>'."\n";
  echo '</td>'."\n";
  echo '</tr>'."\n";
  echo '</table>'."\n";
}

function referermenu() {
  global $admin, $admin_file;
  echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="2" width="90%">'."\n";
  echo '<tr>'."\n";
  echo '<td align="left" valign="top" width="33%">'."\n";
  echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="0">'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_125).'</td><td><a href="'.$admin_file.'.php?op=ABRefererAdd">'._AB_ADDREFERER.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_126).'</td><td><a href="'.$admin_file.'.php?op=ABRefererList">'._AB_REFERERLISTING.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_127).'</td><td><a href="'.$admin_file.'.php?op=ABRefererListPrint" target="_blank">'._AB_PRINTREFERERS.'</a></td></tr>'."\n";
  echo '</table>'."\n";
  echo '</td>'."\n";
  echo '</tr>'."\n";
  echo '</table>'."\n";
}

function stringmenu() {
  global $admin, $admin_file;
  echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="2" width="90%">'."\n";
  echo '<tr>'."\n";
  echo '<td align="left" valign="top" width="33%">'."\n";
  echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="0">'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_125).'</td><td><a href="'.$admin_file.'.php?op=ABStringAdd">'._AB_ADDSTRING.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_126).'</td><td><a href="'.$admin_file.'.php?op=ABStringList">'._AB_STRINGLISTING.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_127).'</td><td><a href="'.$admin_file.'.php?op=ABStringListPrint" target="_blank">'._AB_PRINTSTRINGS.'</a></td></tr>'."\n";
  echo '</table>'."\n";
  echo '</td>'."\n";
  echo '</tr>'."\n";
  echo '</table>'."\n";
}

function protectedmenu() {
  global $admin, $admin_file;
  echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="2" width="90%">'."\n";
  echo '<tr>'."\n";
  echo '<td align="left" valign="top" width="33%">'."\n";
  echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="0">'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_104).'</td><td><a href="'.$admin_file.'.php?op=ABProtectedAdd">'._AB_ADDPROTECTED.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_106).'</td><td><a href="'.$admin_file.'.php?op=ABProtectedList">'._AB_PROTECTEDLISTING.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_107).'</td><td><a href="'.$admin_file.'.php?op=ABProtectedListPrint" target="_blank">'._AB_PRINTPROTECTEDRANGES.'</a></td></tr>'."\n";
  echo '<tr><td>&nbsp;</td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_070).'</td><td><a href="'.$admin_file.'.php?op=ABProtectedOverlapCheck">'._AB_PROTECTEDOVERLAPCHECK.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_105).'</td><td><a href="'.$admin_file.'.php?op=ABProtectedClear">'._AB_CLEARPROTECTED.'</a></td></tr>'."\n";
  echo '</table>'."\n";
  echo '</td>'."\n";
  echo '</tr>'."\n";
  echo '</table>'."\n";
}

function blockedipmenu() {
  global $admin, $admin_file, $sip;
  echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="2" width="90%">'."\n";
  echo '<tr>'."\n";
  echo '<td align="left" valign="top" width="33%">'."\n";
  echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="0">'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_027).'</td><td><a href="'.$admin_file.'.php?op=ABBlockedIPAdd">'._AB_ADDIP.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_026).'</td><td><a href="'.$admin_file.'.php?op=ABBlockedIPList">'._AB_BLOCKEDIPS.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_062).'</td><td><a href="'.$admin_file.'.php?op=ABBlockedIPListPrint" target="_blank">'._AB_PRINTBLOCKEDIPS.'</a></td></tr>'."\n";
  echo '<tr><td>&nbsp;</td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_028).'</td><td><a href="'.$admin_file.'.php?op=ABBlockedIPClear">'._AB_CLEARIP.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_029).'</td><td><a class="rn_csrf" href="'.$admin_file.'.php?op=ABBlockedIPClearExpired">'._AB_CLEAREXPIRED.'</a></td></tr>'."\n";
  echo '</table>'."\n";
  echo '</td>'."\n";
  echo '</tr>'."\n";
  echo '</table>'."\n";
}

function blockedrangemenu() {
  global $admin, $admin_file;
  echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="2" width="90%">'."\n";
  echo '<tr>'."\n";
  echo '<td align="left" valign="top" width="33%">'."\n";
  echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="0">'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_089).'</td><td><a href="'.$admin_file.'.php?op=ABBlockedRangeAdd">'._AB_ADDRANGE.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_090).'</td><td><a href="'.$admin_file.'.php?op=ABBlockedRangeList">'._AB_BLOCKEDRANGES.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_091).'</td><td><a href="'.$admin_file.'.php?op=ABBlockedRangeListPrint" target="_blank">'._AB_PRINTBLOCKEDRANGES.'</a></td></tr>'."\n";
  echo '<tr><td>&nbsp;</td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_071).'</td><td><a href="'.$admin_file.'.php?op=ABBlockedRangeOverlapCheck">'._AB_BLOCKEDOVERLAPCHECK.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_093).'</td><td><a href="'.$admin_file.'.php?op=ABBlockedRangeClear">'._AB_CLEARRANGE.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_094).'</td><td><a class="rn_csrf" href="'.$admin_file.'.php?op=ABBlockedRangeClearExpired">'._AB_CLEARRANGEEXPIRED.'</a></td></tr>'."\n";
  echo '</table>'."\n";
  echo '</td>'."\n";
  echo '</tr>'."\n";
  echo '</table>'."\n";
}

function trackedmenu() {
  global $admin, $admin_file;
  echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="2" width="90%">'."\n";
  echo '<tr>'."\n";
  echo '<td align="left" valign="top" width="33%">'."\n";
  echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="0">'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_049).'</td><td><a href="'.$admin_file.'.php?op=ABTrackedList">'._AB_TRACKEDIPS.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_076).'</td><td><a href="'.$admin_file.'.php?op=ABTrackedAgentsList">'._AB_TRACKEDAGENTS.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_073).'</td><td><a href="'.$admin_file.'.php?op=ABTrackedRefersList">'._AB_TRACKEDREFERS.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_108).'</td><td><a href="'.$admin_file.'.php?op=ABTrackedUsersList">'._AB_TRACKEDUSERS.'</a></td></tr>'."\n";
  echo '<tr><td>&nbsp;</td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_063).'</td><td><a href="'.$admin_file.'.php?op=ABTrackedListPrint" target="_blank">'._AB_PRINTTRACKEDIPS.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_081).'</td><td><a href="'.$admin_file.'.php?op=ABTrackedAgentsListPrint" target="_blank">'._AB_PRINTTRACKEDAGENTS.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_087).'</td><td><a href="'.$admin_file.'.php?op=ABTrackedRefersListPrint" target="_blank">'._AB_PRINTTRACKEDREFERS.'</a></td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_109).'</td><td><a href="'.$admin_file.'.php?op=ABTrackedUsersListPrint" target="_blank">'._AB_PRINTTRACKEDUSERS.'</a></td></tr>'."\n";
  echo '<tr><td>&nbsp;</td></tr>'."\n";
  echo '<tr><td>'.help_img(_AB_HELP_096).'</td><td><a href="'.$admin_file.'.php?op=ABTrackedClear">'._AB_CLEARTRACKED.'</a></td></tr>'."\n";
  echo '</table>'."\n";
  echo '</td>'."\n";
  echo '</tr>'."\n";
  echo '</table>'."\n";
}

function flag_img($c2c) {
  global $prefix, $db;
  $c2c = strtolower($c2c);
  list($xcountry) = $db->sql_fetchrow($db->sql_query("SELECT `country` FROM `".$prefix."_nsnst_countries` WHERE `c2c`='$c2c' LIMIT 0,1"));
  if(!file_exists("images/nukesentinel/countries/".$c2c.".png")) {
	 return '<img src="images/nukesentinel/countries/00.png" border="0" height="15" width="25" alt="('.$c2c.') '.$xcountry.'" title="('.$c2c.') '.$xcountry.'" />';
  } else {
	 return '<img src="images/nukesentinel/countries/'.$c2c.'.png" border="0" height="15" width="25" alt="('.$c2c.') '.$xcountry.'" title="('.$c2c.') '.$xcountry.'" />';
  }
}

function help_img($abinfo) {
  global $ab_config;
  if($ab_config['help_switch'] > 0) {
	 return "<a href=\"javascript:void(0);\" onclick=\"return overlib('".addslashes($abinfo)."', STICKY, CENTERPOPUP, CAPTION, '"._AB_HELPSYS."', STATUS, '"._AB_HELPSYS."', WIDTH, 400, FGCOLOR, '#ffffff', BGCOLOR, '#000000', TEXTCOLOR, '#000000', CAPCOLOR, '#ffffff', CLOSECOLOR, '#ffffff', CAPICON, 'images/nukesentinel/helpicon.png', BORDER, '2', TEXTFONT, 'Lucida Sans, Arial', TEXTSIZE, '12px', CLOSEFONT, 'Lucida Sans, Arial', CLOSESIZE, '12px', CAPTIONFONT, 'Lucida Sans, Arial', CAPTIONSIZE, '12px');\"><img src='images/nukesentinel/helpicon.png' border='0' height='16' width='16' alt='' title='' /></a>";
  } else {
	 return "<a href=\"javascript:void(0);\" onmouseover=\"return overlib('".addslashes($abinfo)."', STICKY, CENTERPOPUP, CAPTION, '"._AB_HELPSYS."', STATUS, '"._AB_HELPSYS."', WIDTH, 400, FGCOLOR, '#ffffff', BGCOLOR, '#000000', TEXTCOLOR, '#000000', CAPCOLOR, '#ffffff', CLOSECOLOR, '#ffffff', CAPICON, 'images/nukesentinel/helpicon.png', BORDER, '2', TEXTFONT, 'Lucida Sans, Arial', TEXTSIZE, '12px', CLOSEFONT, 'Lucida Sans, Arial', CLOSESIZE, '12px', CAPTIONFONT, 'Lucida Sans, Arial', CAPTIONSIZE, '12px');\" onmouseout=\"return nd();\"><img src='images/nukesentinel/helpicon.png' border='0' height='16' width='16' alt='' title='' /></a>";
  }
}

function info_img($abinfo) {
  global $ab_config;
  if($ab_config['help_switch'] > 0) {
	 return "<a href=\"javascript:void(0);\" onclick=\"return overlib('".addslashes($abinfo)."', STICKY, CENTERPOPUP, CAPTION, '"._AB_INFOSYS."', STATUS, '"._AB_INFOSYS."', WIDTH, 400, FGCOLOR, '#ffffff', BGCOLOR, '#000000', TEXTCOLOR, '#000000', CAPCOLOR, '#ffffff', CLOSECOLOR, '#ffffff', CAPICON, 'images/nukesentinel/infoicon.png', BORDER, '2', TEXTFONT, 'Lucida Sans, Arial', TEXTSIZE, '12px', CLOSEFONT, 'Lucida Sans, Arial', CLOSESIZE, '12px', CAPTIONFONT, 'Lucida Sans, Arial', CAPTIONSIZE, '12px');\"><img src='images/nukesentinel/infoicon.png' border='0' height='16' width='16' alt='' title='' /></a>";
  } else {
	 return "<a href=\"javascript:void(0);\" onmouseover=\"return overlib('".addslashes($abinfo)."', STICKY, CENTERPOPUP, CAPTION, '"._AB_INFOSYS."', STATUS, '"._AB_INFOSYS."', WIDTH, 400, FGCOLOR, '#ffffff', BGCOLOR, '#000000', TEXTCOLOR, '#000000', CAPCOLOR, '#ffffff', CLOSECOLOR, '#ffffff', CAPICON, 'images/nukesentinel/infoicon.png', BORDER, '2', TEXTFONT, 'Lucida Sans, Arial', TEXTSIZE, '12px', CLOSEFONT, 'Lucida Sans, Arial', CLOSESIZE, '12px', CAPTIONFONT, 'Lucida Sans, Arial', CAPTIONSIZE, '12px');\" onmouseout=\"return nd();\"><img src='images/nukesentinel/infoicon.png' border='0' height='16' width='16' alt='' title='' /></a>";
  }
}

function templatemenu($template = '') {
	global $nuke_config, $ab_config, $nsnst_const, $admin_file;
	echo '<form action="' . $admin_file . '.php" method="post" target="templateview">' . "\n";
	echo '<input type="hidden" name="op" value="ABTemplateView" />' . "\n";
	echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="2">' . "\n";
	echo '<tr><td>' . _AB_TEMPLATE . ':</td><td><select name="template">' . "\n";
	$templatelist = '';
	$templatedir = dir('abuse');
	while($func=$templatedir->read()) {
		if(substr($func, -4) == '.tpl') { $templatelist .= $func . ' '; }
	}
	closedir($templatedir->handle);
	$templatelist = explode(' ', $templatelist);
	sort($templatelist);
	for($i=0; $i < sizeof($templatelist); $i++) {
		if($templatelist[$i] != '') {
			$bl = str_ireplace('.tpl', '', $templatelist[$i]);
			$bl = str_replace('_', ' ', $bl);
			echo '<option value="' . $templatelist[$i] . '">' . $bl . '</option>' . "\n";
		}
	}
	echo '</select></td></tr>'."\n";
	echo '<tr><td align="center" colspan="2"><input type="submit" value="' . _AB_VIEWTEMPLATE . '" /></td></tr>' . "\n";
	echo '</table>' . "\n" . '</form>' . "\n";
	echo '<hr noshade="noshade" />' . "\n";
	echo '<form action="' . $admin_file . '.php" method="post">' . "\n";
	echo '<input type="hidden" name="op" value="ABTemplateSource" />' . "\n";
	echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="2">' . "\n";
	echo '<tr><td>' . _AB_TEMPLATE . ':</td><td><select name="template">' . "\n";
	$templatelist = '';
	$templatedir = dir('abuse');
	while($func=$templatedir->read()) {
		if(substr($func, -4) == '.tpl') { $templatelist .= $func . ' ' ; }
	}
	closedir($templatedir->handle);
	$templatelist = explode(' ', $templatelist);
	sort($templatelist);
	for($i=0; $i < sizeof($templatelist); $i++) {
		if($templatelist[$i] != '') {
			$bl = str_ireplace('.tpl', '', $templatelist[$i]);
			$bl = str_replace('_', ' ', $bl);
			echo '<option value="' . $templatelist[$i] . '">' . $bl . '</option>' . "\n";
		}
	}
	echo '</select></td></tr>' . "\n";
	echo '<tr><td align="center" colspan="2"><input type="submit" value="' . _AB_VIEWTEMPLATESOURCE . '" /></td></tr>' . "\n";
	echo '</table>' . "\n" . '</form>' . "\n";
}

function abview_template($template="") {
  global $nuke_config, $ab_config, $nsnst_const, $db, $prefix, $ip;
  if(empty($template)) { $template = "abuse_default.tpl"; }
  $sitename = $nuke_config['sitename'];
  $adminmail = $nuke_config['adminmail'];
  $adminmail = str_replace("@", "(at)", $adminmail);
  $adminmail = str_replace(".", "(dot)", $adminmail);
  $adminmail2 = urlencode($nuke_config['adminmail']);
  $querystring = get_query_string();
  $filename = "abuse/".$template;
  if(!file_exists($filename)) { $filename = "abuse/abuse_default.tpl"; }
  $handle = @fopen($filename, "r");
  $display_page = fread($handle, filesize($filename));
  @fclose($handle);
  $display_page = str_replace("__SITENAME__", $sitename, $display_page);
  $display_page = str_replace("__ADMINMAIL1__", $adminmail, $display_page);
  $display_page = str_replace("__ADMINMAIL2__", $adminmail2, $display_page);
  $display_page = str_replace("__REMOTEPORT__", $nsnst_const['remote_port'], $display_page);
  $display_page = str_replace("__REQUESTMETHOD__", $nsnst_const['request_method'], $display_page);
  $display_page = str_replace("__SCRIPTNAME__", $nsnst_const['script_name'], $display_page);
  $display_page = str_replace("__HTTPHOST__", $nsnst_const['http_host'], $display_page);
  $display_page = str_replace("__USERAGENT__", $nsnst_const['user_agent'], $display_page);
  $display_page = str_replace("__CLIENTIP__", $nsnst_const['client_ip'], $display_page);
  $display_page = str_replace("__FORWARDEDFOR__", $nsnst_const['forward_ip'], $display_page);
  $display_page = str_replace("__REMOTEADDR__", $nsnst_const['remote_addr'], $display_page);
  $display_page = str_replace("__TIMEDATE__", date("Y-m-d \@ H:i:s T \G\M\T O", $nsnst_const['ban_time']), $display_page);
  $display_page = str_replace("__DATEEXPIRES__", _AB_UNKNOWN, $display_page);
  return $display_page;
}

function OpenMenu($adsection="") {
  global $bgcolor1, $bgcolor2, $textcolor1, $ab_config, $getAdmin, $prefix, $db, $op, $admin;
  echo '<script type="text/javascript" src="includes/nukesentinel1.js"><!-- overLIB (c) Erik Bosrup --></script>'."\n";
  echo '<script type="text/javascript" src="includes/nukesentinel2.js"><!-- overLIB_hideform (c) Erik Bosrup --></script>'."\n";
  echo '<script type="text/javascript" src="includes/nukesentinel3.js"><!-- overLIB_centerpopup (c) Erik Bosrup --></script>'."\n";
  echo '<div id="overDiv" style="position:absolute; visibility:hidden; z-index:9999;"></div>'."\n";
  echo '<table summary="" width="100%" border="0" cellspacing="1" cellpadding="4">'."\n";
  $nsnstcopy  = "<strong>Module's Name:</strong> NukeSentinel(tm)<br />";
  $nsnstcopy .= "<strong>License:</strong> Copyright &#169; 2000-2013 NukeSentinel(tm) Team<br />";
  $nsnstcopy .= "<strong>Author's Name:</strong> <a href='http://www.ravenphpscripts.com' title='NukeSentinel(tm) available at Raven PhpScripts(tm)' target='_blank'>Raven PhpScripts(tm)</a><br />";
  $nsnstcopy .= "<strong>Module's Description:</strong> Advanced site security proudly produced by: Raven PHPScripts(tm), NukeScripts(tm), &amp; NukeResources.";
  if($ab_config['disable_switch'] == 1) { $nsnststatus = _AB_DISABLED; } else { $nsnststatus = _AB_ENABLED; }
  if(!empty($adsection)) { $adsection = ": ".$adsection; }
  echo '<tr>'."\n";
  echo '<td align="center" colspan="2"><a href="http://www.ravenphpscripts.com/modules.php?name=Downloads" target="_blank"><span class="title"><strong>'._AB_NUKESENTINEL.'</strong></span></a><span class="title"><strong> '.$ab_config['version_number'].': '.$nsnststatus.$adsection.'</strong></span> ';
  if($ab_config['help_switch'] > 0) {
	 echo "<a href=\"javascript:void(0);\" onclick=\"return overlib('".addslashes($nsnstcopy)."', STICKY, CENTERPOPUP, CAPTION, 'Module Copyright &#169; Information', STATUS, 'NukeSentinel(tm): Copyright Information', WIDTH, 400, FGCOLOR, '#ffffff', BGCOLOR, '#000000', TEXTCOLOR, '#000000', CAPCOLOR, '#ffffff', CLOSECOLOR, '#ffffff', CAPICON, 'images/nukesentinel/copyicon.png', BORDER, '2', TEXTFONT, 'Lucida Sans, Arial', TEXTSIZE, '12px', CLOSEFONT, 'Lucida Sans, Arial', CLOSESIZE, '12px', CAPTIONFONT, 'Lucida Sans, Arial', CAPTIONSIZE, '12px');\"><img src='images/nukesentinel/copyicon.png' border='0' height='16' width='16' alt='' title='' /></a>";
  } else {
	 echo "<a href=\"javascript:void(0);\" onmouseover=\"return overlib('".addslashes($nsnstcopy)."', STICKY, CENTERPOPUP, CAPTION, 'Module Copyright &#169; Information', STATUS, 'NukeSentinel(tm): Copyright Information', WIDTH, 400, FGCOLOR, '#ffffff', BGCOLOR, '#000000', TEXTCOLOR, '#000000', CAPCOLOR, '#ffffff', CLOSECOLOR, '#ffffff', CAPICON, 'images/nukesentinel/copyicon.png', BORDER, '2', TEXTFONT, 'Lucida Sans, Arial', TEXTSIZE, '12px', CLOSEFONT, 'Lucida Sans, Arial', CLOSESIZE, '12px', CAPTIONFONT, 'Lucida Sans, Arial', CAPTIONSIZE, '12px');\" onmouseout=\"return nd();\"><img src='images/nukesentinel/copyicon.png' border='0' height='16' width='16' alt='' title='' /></a>";
  }
  echo '</td>'."\n";
  echo '</tr>'."\n";
  //echo '<tr><td align="center" colspan="3"><strong><a href="http://www.ravenphpscripts.com/versions/nsnst.txt" target="new">'._AB_NEWVER.'</a></strong></td></tr>'."\n";
  $nva = '';
  $nva = '<div class=\'text-center\'><p>'.@file_get_contents('http://www.ravenphpscripts.com/versions/nsnst.txt').'</p></div>';
  echo "<tr><td align=\"center\" colspan=\"3\"><a href=\"javascript:void(0);\" onclick=\"this.blur();return overlib('".addslashes($nva)."', STICKY, CENTERPOPUP, CAPTION, 'Latest Version', STATUS, 'NukeSentinel(tm): Copyright Information', WIDTH, 400, FGCOLOR, '#ffffff', BGCOLOR, '#000000', TEXTCOLOR, '#000000', CAPCOLOR, '#ffffff', CLOSECOLOR, '#ffffff', CAPICON, 'images/nukesentinel/copyicon.png', BORDER, '2', TEXTFONT, 'Lucida Sans, Arial', TEXTSIZE, '12px', CLOSEFONT, 'Lucida Sans, Arial', CLOSESIZE, '12px', CAPTIONFONT, 'Lucida Sans, Arial', CAPTIONSIZE, '12px');\"><img src='images/nukesentinel/copyicon.png' border='0' height='16' width='16' alt='' title='' /><strong>"._AB_NEWVER."</strong></a></td></tr>\n";

  echo '<tr><td align="center" valign="top" width="66%">'."\n";
}

function CarryMenu() {
  echo '</td><td align="center" valign="top" width="34%">'."\n";
}

function CloseMenu() {
  echo '</td></tr></table>'."\n";
}

function abadminpagenums($op, $totalselected, $perpage, $max, $column="", $direction="", $showcountry="", $showmodule="", $tid="") {
  global $admin_file;
  $pagesint = ($totalselected / $perpage);
  $pageremainder = ($totalselected % $perpage);
  if($pageremainder != 0) {
	 $pages = ceil($pagesint);
	 if($totalselected < $perpage) { $pageremainder = 0; }
  } else {
	 $pages = $pagesint;
  }
  if($pages != 1 && $pages != 0) {
	 $counter = 1;
	 $currentpage = ($max / $perpage);
	 echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="2" width="100%">'."\n".'<tr>'."\n";
	 echo '<td width="33%" nowrap="nowrap">';
	 echo '<form action="'.$admin_file.'.php?op='.$op.'" method="post" style="padding: 0px; margin: 0px;">'."\n";
	 echo '<input type="hidden" name="min" value="'.(($max - $perpage) - $perpage).'" />'."\n";
	 if($tid > "") { echo '<input type="hidden" name="tid" value="'.$tid.'" />'."\n"; }
	 if($column > "") { echo '<input type="hidden" name="column" value="'.$column.'" />'."\n"; }
	 if($direction > "") { echo '<input type="hidden" name="direction" value="'.$direction.'" />'."\n"; }
	 if($showcountry > "") { echo '<input type="hidden" name="showcountry" value="'.$showcountry.'" />'."\n"; }
	 if($showmodule > "") { echo '<input type="hidden" name="showmodule" value="'.$showmodule.'" />'."\n"; }
	 if($currentpage <= 1) {
		echo '&nbsp;';
	 } else {
		echo '<input type="submit" value="'._AB_PREVPAGE.'" />';
	 }
	 echo '</form>'."\n";
	 echo '</td>'."\n";
	 echo '<td align="center" width="34%" nowrap="nowrap">'."\n";
	 echo '<form action="'.$admin_file.'.php?op='.$op.'" method="post" style="padding: 0px; margin: 0px;">'."\n";
	 if($tid > "") { echo '<input type="hidden" name="tid" value="'.$tid.'" />'."\n"; }
	 if($column > "") { echo '<input type="hidden" name="column" value="'.$column.'" />'."\n"; }
	 if($direction > "") { echo '<input type="hidden" name="direction" value="'.$direction.'" />'."\n"; }
	 if($showcountry > "") { echo '<input type="hidden" name="showcountry" value="'.$showcountry.'" />'."\n"; }
	 if($showmodule > "") { echo '<input type="hidden" name="showmodule" value="'.$showmodule.'" />'."\n"; }
	 echo '<strong>'._AB_PAGE.':</strong> <select name="min">'."\n";
	 while ($counter <= $pages ) {
		$cpage = $counter;
		$mintemp = ($perpage * $counter) - $perpage;
		echo '<option value="'.$mintemp.'"';
		if($counter == $currentpage) { echo ' selected="selected"'; }
		echo '>'.$counter.'</option>'."\n";
		$counter++;
	 }
	 echo '</select><strong> '._AB_OF.' '.$pages.' '._AB_PAGES.'</strong> <input type="submit" value="'._AB_GO.'" />'."\n";
	 echo '</form>'."\n";
	 echo '</td>'."\n";
	 echo '<td align="right" width="33%">';
	 echo '<form action="'.$admin_file.'.php?op='.$op.'" method="post" style="padding: 0px; margin: 0px;">'."\n";
	 echo '<input type="hidden" name="min" value="'.$max.'" />'."\n";
	 if($tid > "") { echo '<input type="hidden" name="tid" value="'.$tid.'" />'."\n"; }
	 if($column > "") { echo '<input type="hidden" name="column" value="'.$column.'" />'."\n"; }
	 if($direction > "") { echo '<input type="hidden" name="direction" value="'.$direction.'" />'."\n"; }
	 if($showcountry > "") { echo '<input type="hidden" name="showcountry" value="'.$showcountry.'" />'."\n"; }
	 if($showmodule > "") { echo '<input type="hidden" name="showmodule" value="'.$showmodule.'" />'."\n"; }
	 if($currentpage >= $pages) {
		echo '&nbsp;';
	 } else {
		echo '<input type="submit" value="'._AB_NEXTPAGE.'" />';
	 }
	 echo '</form>'."\n";
	 echo '</td>'."\n";
	 echo '</tr>'."\n".'</table>'."\n";
  }
}

function ABCoolSize($size) {
  $kb = 1024;
  $mb = 1024*1024;
  $gb = 1024*1024*1024;
  if( $size > $gb ) {
	 $mysize = sprintf ("%01.2f",$size/$gb)." "._AB_GB;
  } elseif( $size > $mb ) {
	 $mysize = sprintf ("%01.2f",$size/$mb)." "._AB_MB;
  } elseif( $size >= $kb ) {
	 $mysize = sprintf ("%01.2f",$size/$kb)." "._AB_KB;
  } else {
	 $mysize = $size." "._AB_BYTES;
  }
  return $mysize;
}

?>