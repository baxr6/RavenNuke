<?php
/********************************************************/
/* NukeSentinel(tm)                                     */
/* By: NukeScripts(tm) (http://www.nukescripts.net)     */
/* Copyright © 2000-2008 by NukeScripts(tm)             */
/* See CREDITS.txt for ALL contributors                 */
/********************************************************/

if (!defined('NUKESENTINEL_ADMIN')) {
    header("Location: ../../../" . $admin_file . ".php");
    exit();
}

$pagetitle = _AB_NUKESENTINEL . ": " . _AB_BLOCKEDIPS;
include("header.php");

OpenTable();
OpenMenu(_AB_BLOCKEDIPS);
mastermenu();
CarryMenu();
blockedipmenu();
CloseMenu();
CloseTable();

echo '<br />' . "\n";
OpenTable();

// Sanitize pagination inputs
$min = isset($_GET['min']) && is_numeric($_GET['min']) ? (int)$_GET['min'] : 0;
$perpage = !empty($ab_config['block_perpage']) && is_numeric($ab_config['block_perpage']) ? (int)$ab_config['block_perpage'] : 25;

// Sanitize and whitelist sorting inputs
$allowed_columns = ['ip_long', 'expires', 'date', 'reason', 'c2c'];
$default_column = $ab_config['block_sort_column'] ?? 'ip_long';
$column = isset($_GET['column']) && in_array($_GET['column'], $allowed_columns) ? $_GET['column'] : $default_column;

$allowed_directions = ['asc', 'desc'];
$default_direction = $ab_config['block_sort_direction'] ?? 'asc';
$direction = isset($_GET['direction']) && in_array(strtolower($_GET['direction']), $allowed_directions) ? strtolower($_GET['direction']) : $default_direction;

// Prepare selected attributes for the sort form
$selcolumn = array_fill_keys($allowed_columns, '');
$selcolumn[$column] = ' selected="selected"';

$seldirection = ['asc' => '', 'desc' => ''];
$seldirection[$direction] = ' selected="selected"';

// Get total count of blocked IPs
$totalResult = $db->sql_query("SELECT COUNT(*) AS total FROM `{$prefix}_nsnst_blocked_ips`");
$totalRow = $db->sql_fetchrow($totalResult);
$totalselected = (int)($totalRow['total'] ?? 0);

if ($totalselected > 0) {
    // Display sort form
    echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="2" width="100%">' . "\n";
    echo '<tr><td align="right" nowrap="nowrap">' . "\n";
    echo '<form action="' . htmlspecialchars($admin_file) . '.php?op=ABBlockedIPList" method="get" style="padding: 0; margin: 0;">' . "\n";
    echo '<input type="hidden" name="op" value="ABBlockedIPList" />' . "\n";
    echo '<strong>' . _AB_SORT . ':</strong> <select name="column">' . "\n";
    echo '<option value="ip_long"' . $selcolumn['ip_long'] . '>' . _AB_IPBLOCKED . '</option>' . "\n";
    echo '<option value="expires"' . $selcolumn['expires'] . '>' . _AB_EXPIRES . '</option>' . "\n";
    echo '<option value="date"' . $selcolumn['date'] . '>' . _AB_DATE . '</option>' . "\n";
    echo '<option value="reason"' . $selcolumn['reason'] . '>' . _AB_REASON . '</option>' . "\n";
    echo '<option value="c2c"' . $selcolumn['c2c'] . '>' . _AB_C2CODE . '</option>' . "\n";
    echo '</select> ' . "\n";
    echo '<select name="direction">' . "\n";
    echo '<option value="asc"' . $seldirection['asc'] . '>' . _AB_ASC . '</option>' . "\n";
    echo '<option value="desc"' . $seldirection['desc'] . '>' . _AB_DESC . '</option>' . "\n";
    echo '</select> ' . "\n";
    echo '<input type="hidden" name="min" value="' . $min . '" />' . "\n";
    echo '<input type="submit" value="' . _AB_SORT . '" />' . "\n";
    echo '</form>' . "\n";
    echo '</td></tr></table>' . "\n";

    // Fetch blockers once to avoid repeated queries in loop
    $blockers = [];
    $blockerRes = $db->sql_query("SELECT `blocker`, `reason` FROM `{$prefix}_nsnst_blockers`");
    while ($row = $db->sql_fetchrow($blockerRes)) {
        $blockers[$row['blocker']] = str_replace('Abuse-', '', $row['reason']);
    }

    // Fetch blocked IPs page
    $sql = "SELECT * FROM `{$prefix}_nsnst_blocked_ips` ORDER BY `$column` $direction LIMIT $min, $perpage";
    $result = $db->sql_query($sql);

    echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="2" bgcolor="' . htmlspecialchars($bgcolor2) . '" width="100%">' . "\n";
    echo '<tr bgcolor="' . htmlspecialchars($bgcolor2) . '">' . "\n";
    echo '<td width="20%"><strong>' . _AB_IPBLOCKED . '</strong></td>' . "\n";
    echo '<td width="2%"><strong>&nbsp;</strong></td>' . "\n";
    echo '<td align="center" width="25%"><strong>' . _AB_DATE . '</strong></td>' . "\n";
    echo '<td align="center" width="25%"><strong>' . _AB_EXPIRES . '</strong></td>' . "\n";
    echo '<td align="center" width="20%"><strong>' . _AB_REASON . '</strong></td>' . "\n";
    echo '<td align="center" width="10%"><strong>' . _AB_FUNCTIONS . '</strong></td>' . "\n";
    echo '</tr>' . "\n";

    while ($getIPs = $db->sql_fetchrow($result)) {
        $reasonKey = $getIPs['reason'];
        $reasonText = $blockers[$reasonKey] ?? $reasonKey;

        $bdate = date("Y-m-d @ H:i:s", (int)$getIPs['date']);
        $lookupip = str_replace("*", "0", $getIPs['ip_addr']);
        $bexpire = ((int)$getIPs['expires'] === 0) ? _AB_PERMENANT : date("Y-m-d @ H:i:s", (int)$getIPs['expires']);

        // Get username
        $userResult = $db->sql_query("SELECT `username` FROM `{$user_prefix}_users` WHERE `user_id`='" . (int)$getIPs['user_id'] . "' LIMIT 1");
        $userRow = $db->sql_fetchrow($userResult);
        $bname = $userRow['username'] ?? '';

        // Decode and escape query, get and post strings
        $qs = htmlentities(base64_decode($getIPs['query_string'] ?? ''), ENT_QUOTES, 'UTF-8');
        $qs = str_replace("%20", " ", $qs);
        $qs = str_replace("/**/", "/* */", $qs);
        $qs = str_replace("&", "<br />&", $qs);

        $gs = htmlentities(base64_decode($getIPs['get_string'] ?? ''), ENT_QUOTES, 'UTF-8');
        $gs = str_replace("%20", " ", $gs);
        $gs = str_replace("/**/", "/* */", $gs);
        $gs = str_replace("&", "<br />&", $gs);

        $ps = htmlentities(base64_decode($getIPs['post_string'] ?? ''), ENT_QUOTES, 'UTF-8');
        $ps = str_replace("%20", " ", $ps);
        $ps = str_replace("/**/", "/* */", $ps);
        $ps = str_replace("&", "<br />&", $ps);

        $ua = htmlentities($getIPs['user_agent'] ?? '', ENT_QUOTES, 'UTF-8');
        $flag_img = flag_img($getIPs['c2c'] ?? '');

        $rowBg = htmlspecialchars($bgcolor1);
        $hoverBg = htmlspecialchars($bgcolor2);

        echo '<tr onmouseover="this.style.backgroundColor=\'' . $hoverBg . '\'" onmouseout="this.style.backgroundColor=\'' . $rowBg . '\'" bgcolor="' . $rowBg . '">' . "\n";
        echo '<td>' . info_img('<strong>' . _AB_USERAGENT . ':</strong> ' . $ua
            . '<br /><br /><strong>' . _AB_QUERY . ':</strong> ' . $qs
            . '<br /><br /><strong>' . _AB_GET . ':</strong> ' . $gs
            . '<br /><br /><strong>' . _AB_POST . ':</strong> ' . $ps)
            . ' <a href="' . htmlspecialchars($ab_config['lookup_link'] . $lookupip, ENT_QUOTES, 'UTF-8') . '" target="_blank">' . 
            htmlspecialchars($getIPs['ip_addr'], ENT_QUOTES, 'UTF-8') . '</a></td>' . "\n";

        echo '<td width="2%">' . $flag_img . '</td>' . "\n";
        echo '<td align="center">' . $bdate . '</td>' . "\n";
        echo '<td align="center">' . $bexpire . '</td>' . "\n";
        echo '<td align="center">' . htmlspecialchars($reasonText, ENT_QUOTES, 'UTF-8') . '</td>' . "\n";

        // Build URL params safely
        $params = [
            'xIPs' => $getIPs['ip_addr'],
            'min' => $min,
            'column' => $column,
            'direction' => $direction,
            'xop' => $op ?? ''
        ];
        $queryString = http_build_query($params);

        echo '<td align="center" nowrap="nowrap">'
            . '<a href="' . htmlspecialchars($admin_file . '.php?op=ABBlockedIPViewPrint&' . $queryString, ENT_QUOTES) . '" target="_blank"><img src="images/nukesentinel/print.png" border="0" alt="' . _AB_PRINT . '" title="' . _AB_PRINT . '" height="16" width="16" /></a>'
            . '<a href="' . htmlspecialchars($admin_file . '.php?op=ABBlockedIPView&' . $queryString, ENT_QUOTES) . '" target="_blank"><img src="images/nukesentinel/view.png" border="0" alt="' . _AB_VIEW . '" title="' . _AB_VIEW . '" height="16" width="16" /></a>'
            . '<a href="' . htmlspecialchars($admin_file . '.php?op=ABBlockedIPEdit&' . $queryString, ENT_QUOTES) . '"><img src="images/nukesentinel/edit.png" border="0" alt="' . _AB_EDIT . '" title="' . _AB_EDIT . '" height="16" width="16" /></a>'
            . '<a href="' . htmlspecialchars($admin_file . '.php?op=ABBlockedIPDelete&' . $queryString, ENT_QUOTES) . '"><img src="images/nukesentinel/unblock.png" border="0" alt="' . _AB_UNBLOCK . '" title="' . _AB_UNBLOCK . '" height="16" width="16" /></a>'
            . '</td>' . "\n";
        echo '</tr>' . "\n";
    }

    echo '</table>' . "\n";

    // Pagination controls
    abadminpagenums($op, $totalselected, $perpage, $min + $perpage, $column, $direction);
} else {
    echo '<div class="text-center"><strong>' . _AB_NOIPS . '</strong></div>' . "\n";
}

CloseTable();
include("footer.php");
