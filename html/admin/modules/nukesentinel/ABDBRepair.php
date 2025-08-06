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


$pagetitle = _AB_NUKESENTINEL . ": " . _AB_DBREPAIR . " - " . $dbname;
include("header.php");

OpenTable();
OpenMenu(_AB_DBREPAIR . " - " . $dbname);
mastermenu();
CarryMenu();
databasemenu();
CloseMenu();
CloseTable();

echo '<br />' . "\n";
OpenTable();

echo '<table summary="" width="100%" border="0" cellpadding="2" cellspacing="2" align="center" bgcolor="' . $bgcolor2 . '">' . "\n";
echo '<tr>' . "\n";
echo '<td width="40%"><strong>' . _AB_TABLE . '</strong></td>' . "\n";
echo '<td align="center" width="15%"><strong>' . _AB_TYPE . '</strong></td>' . "\n";
echo '<td align="center" width="15%"><strong>' . _AB_STATUS . '</strong></td>' . "\n";
echo '<td align="right" width="15%"><strong>' . _AB_RECORDS . '</strong></td>' . "\n";
echo '<td align="right" width="15%"><strong>' . _AB_SIZE . '</strong></td>' . "\n";
echo '</tr>' . "\n";

$tot_records = 0;
$total_size = 0;

$result = $db->sql_query("SHOW TABLE STATUS FROM `" . $dbname . "`");
$tables = $db->sql_numrows($result);

if ($tables > 0) {
    while ($row = $db->sql_fetchrow($result)) {
        $tableName = $row['Name'];
        $engine = !empty($row['Engine']) ? strtoupper($row['Engine']) : strtoupper($row['Type']);

        $status = checkAndRepairTable($db, $tableName, $engine);

        $records = (int)$row['Rows'];
        $tot_records += $records;

        $size = (int)$row['Data_length'] + (int)$row['Index_length'];
        $total_size += $size;

        $sizeFormatted = ABCoolSize($size);

        echo '<tr onmouseover="this.style.backgroundColor=\'' . $bgcolor2 . '\'" onmouseout="this.style.backgroundColor=\'' . $bgcolor1 . '\'" bgcolor="' . $bgcolor1 . '">' . "\n";
        echo '<td>' . htmlspecialchars($tableName) . '</td>' . "\n";
        echo '<td align="center">' . htmlspecialchars($engine) . '</td>' . "\n";
        echo '<td align="center">' . htmlspecialchars($status) . '</td>' . "\n";
        echo '<td align="right">' . number_format($records) . '</td>' . "\n";
        echo '<td align="right">' . $sizeFormatted . '</td>' . "\n";
        echo '</tr>' . "\n";
    }

    $total_sizeFormatted = ABCoolSize($total_size);

    echo '<tr>' . "\n";
    echo '<td><strong>' . $tables . ' ' . _AB_TABLES . '</strong></td>' . "\n";
    echo '<td align="center"><strong>&nbsp;</strong></td>' . "\n";
    echo '<td align="right"><strong>&nbsp;</strong></td>' . "\n";
    echo '<td align="right"><strong>' . number_format($tot_records) . '</strong></td>' . "\n";
    echo '<td align="right"><strong>' . $total_sizeFormatted . '</strong></td>' . "\n";
    echo '</tr>' . "\n";
}

echo '</table>' . "\n";

CloseTable();

include("footer.php");
