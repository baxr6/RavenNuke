<?php
/**
 * RavenNuke getGDInfo() — PHP 8+ Compatible Rewrite
 * --------------------------------------------------
 * RavenNuke's original getGDInfo() scraped phpinfo() output to obtain a
 * "FreeType Version" string. Changes in phpinfo() formatting across PHP
 * versions (especially PHP 8.x) caused Undefined array key warnings and
 * Deprecated notices (e.g., passing null to explode()/trim()).
 *
 * This rewrite:
 *   • Uses gd_info() directly (never scrapes phpinfo()).
 *   • Provides a backwards-compatible interface: getGDInfo($type = 'all').
 *   • Gracefully handles the legacy request for 'FreeType Version'.
 *   • Normalizes/augments returned keys so old RavenNuke code keeps working.
 *   • Avoids die() after return statements (unreachable code in original).
 *
 * Behavioural compatibility notes:
 * --------------------------------
 * 1. getGDInfo('all') returns an associative array similar to gd_info(), but
 *    with additional compatibility keys ensured to exist (see $defaultKeys).
 * 2. getGDInfo('FreeType Version') returns:
 *        - The 'FreeType Linkage' string if available (e.g., 'with freetype').
 *        - Otherwise 'Enabled' if FreeType support is TRUE.
 *        - Otherwise 'Not available'.
 * 3. Key lookup is case-insensitive; common aliases (JPEG/JPG, Freetype/FreeType)
 *    are supported.
 *
 * Safe to include multiple times: guarded by function_exists().
 */

if (!function_exists('getGDInfo')) {
    function getGDInfo($type = 'all') {
        // Collect raw GD info if available.
        if (!function_exists('gd_info')) {
            $gd = [];
        } else {
            // @ silence rare E_WARNING variants from some custom builds.
            $gd = @gd_info();
        }

        // Start with raw array and extend to ensure expected keys exist.
        $gdExt = $gd;

        // Some builds use 'JPEG Support' instead of 'JPG Support'. Add alias.
        if (!array_key_exists('JPG Support', $gdExt) && array_key_exists('JPEG Support', $gdExt)) {
            $gdExt['JPG Support'] = $gdExt['JPEG Support'];
        }
        // And the other way, just in case ancient code checks JPEG Support.
        if (!array_key_exists('JPEG Support', $gdExt) && array_key_exists('JPG Support', $gdExt)) {
            $gdExt['JPEG Support'] = $gdExt['JPG Support'];
        }

        // Some builds report 'Freetype Support' (lower t); others 'FreeType Support'.
        if (!array_key_exists('FreeType Support', $gdExt) && array_key_exists('Freetype Support', $gdExt)) {
            $gdExt['FreeType Support'] = $gdExt['Freetype Support'];
        }
        if (!array_key_exists('Freetype Support', $gdExt) && array_key_exists('FreeType Support', $gdExt)) {
            $gdExt['Freetype Support'] = $gdExt['FreeType Support'];
        }

        // Guarantee all documented keys exist so legacy code doesn't throw notices.
        $defaultKeys = [
            'GD Version'         => 'Unknown',
            'FreeType Support'   => false,
            'Freetype Support'   => false,
            'FreeType Linkage'   => '',
            'T1Lib Support'      => false,
            'GIF Read Support'   => false,
            'GIF Create Support' => false,
            'JPG Support'        => false,
            'JPEG Support'       => false,
            'PNG Support'        => false,
            'WBMP Support'       => false,
            'XBM Support'        => false,
        ];
        foreach ($defaultKeys as $k => $v) {
            if (!array_key_exists($k, $gdExt)) {
                $gdExt[$k] = $v;
            }
        }

        // Return everything?
        if ($type === 'all') {
            return $gdExt;
        }

        $lower = strtolower($type);

        // Legacy special case: 'FreeType Version'
        if ($lower === 'freetype version') {
            // Historically parsed out of phpinfo(). Instead, approximate.
            if (!empty($gdExt['FreeType Linkage'])) {
                return $gdExt['FreeType Linkage'];
            }
            $ftEnabled = !empty($gdExt['FreeType Support']) || !empty($gdExt['Freetype Support']);
            return $ftEnabled ? 'Enabled' : 'Not available';
        }

        // Direct key match (case-insensitive)
        foreach ($gdExt as $k => $v) {
            if (strtolower($k) === $lower) {
                return $v;
            }
        }

        // Alias map for common lookups.
        $aliases = [
            'freetype support' => 'FreeType Support',
            'freetype linkage' => 'FreeType Linkage',
            'gd version'       => 'GD Version',
            'jpg support'      => 'JPG Support',
            'jpeg support'     => 'JPEG Support',
        ];
        if (isset($aliases[$lower]) && array_key_exists($aliases[$lower], $gdExt)) {
            return $gdExt[$aliases[$lower]];
        }

        return false; // not found
    }
}

