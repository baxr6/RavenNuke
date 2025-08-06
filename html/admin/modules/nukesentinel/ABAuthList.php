<?php

declare(strict_types=1);

/**
 * NukeSentinel(tm)
 * By: NukeScripts(tm) (http://www.nukescripts.net)
 * Copyright © 2000-2008 by NukeScripts(tm)
 * See CREDITS.txt for ALL contributors
 */


if (!defined('NUKESENTINEL_ADMIN')) {
    header('Location: ../../../' . $admin_file . '.php');
    exit;
}

if (!is_god()) {
    header('Location: ' . $admin_file . '.php?op=ABMain');
    exit;
}

$pagetitle = _AB_NUKESENTINEL . ': ' . _AB_LISTHTTPAUTH;
include 'header.php';

OpenTable();
OpenMenu(_AB_LISTHTTPAUTH);
mastermenu();
CarryMenu();
authmenu();
CloseMenu();
CloseTable();
echo '<br />' . PHP_EOL;

OpenTable();
echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="2" bgcolor="' . $bgcolor2 . '" width="80%">' . PHP_EOL;

if (!empty($ab_config['staccess_path']) && is_writable($ab_config['staccess_path'])) {
    echo '<tr bgcolor="' . $bgcolor1 . '"><td align="center" colspan="5"><strong>' . _AB_BUILDCGI . ': <a href="' . $admin_file . '.php?op=ABCGIBuild">' . HtmlHelper::escape($ab_config['staccess_path']) . '</a></strong></td></tr>' . PHP_EOL;
}

echo '<tr bgcolor="' . $bgcolor2 . '">';
echo '<td width="30%"><strong>' . _AB_ADMIN . '</strong></td>';
echo '<td width="25%"><strong>' . _AB_AUTHLOGIN . '</strong></td>';
echo '<td width="25%" align="center"><strong>' . _AB_PASSWORD . '</strong></td>';
echo '<td width="10%" align="center"><strong>' . _AB_PROTECTED . '</strong></td>';
echo '<td width="10%" align="center"><strong>' . _AB_FUNCTIONS . '</strong></td>';
echo '</tr>' . PHP_EOL;

$adminresult = $db->sql_query("SELECT * FROM `{$prefix}_nsnst_admins` ORDER BY `aid`");

while ($adminrow = $adminresult->fetch_assoc()) {

    $passwordStatus = !empty($adminrow['password']) ? _AB_SET : _AB_UNSET;
    $protectedStatus = $adminrow['protected'] == 0
        ? "<span class='italic'>" . _AB_NO . "</span>"
        : _AB_YES;

    echo '<tr onmouseover="this.style.backgroundColor=\'' . $bgcolor2 . '\'" onmouseout="this.style.backgroundColor=\'' . $bgcolor1 . '\'" bgcolor="' . $bgcolor1 . '">' . PHP_EOL;
    echo '<td>' . HtmlHelper::escape($adminrow['aid']) . '</td>' . PHP_EOL;
    echo '<td>' . HtmlHelper::escape($adminrow['login']) . '</td>' . PHP_EOL;
    echo '<td align="center">' . $passwordStatus . '</td>' . PHP_EOL;
    echo '<td align="center">' . $protectedStatus . '</td>' . PHP_EOL;
    echo '<td align="center" nowrap="nowrap">';
    echo '<a class="rn_csrf" href="' . $admin_file . '.php?op=';
    echo ($passwordStatus === _AB_SET) ? 'ABAuthResend' : 'ABAuthEdit';
    echo '&amp;a_aid=' . urlencode($adminrow['aid']) . '">';
    echo '<img src="images/nukesentinel/resend.png" height="16" width="16" border="0" alt="' . _AB_RESEND . '" title="' . _AB_RESEND . '" /></a> ';
    echo '<a href="' . $admin_file . '.php?op=ABAuthEdit&amp;a_aid=' . urlencode($adminrow['aid']) . '">';
    echo '<img src="images/nukesentinel/edit.png" height="16" width="16" border="0" alt="' . _AB_EDIT . '" title="' . _AB_EDIT . '" /></a>';
    echo '</td>' . PHP_EOL;
    echo '</tr>' . PHP_EOL;
}

echo '</table>' . PHP_EOL;
CloseTable();
include 'footer.php';
