<?php

/********************************************************/
/* NukeSentinel(tm)                                     */
/* By: NukeScripts(tm) (http://www.nukescripts.net)     */
/* Updated for PHP 8.3+ and modern class system         */
/********************************************************/

if (!defined('NUKESENTINEL_ADMIN')) {
    header("Location: ../../../" . $admin_file . ".php");
    exit;
}

if (is_god()) {
    $pagetitle = _AB_NUKESENTINEL . ": " . _AB_EDITADMINS;
    include_once 'header.php';

    $sapi_name = strtolower(php_sapi_name());

    OpenTable();
    OpenMenu(_AB_EDITADMINS);
    mastermenu();
    CarryMenu();
    authmenu();
    CloseMenu();
    CloseTable();

    echo '<br />' . PHP_EOL;

    OpenTable();

    $a_aid = HtmlHelper::toString($a_aid ?? '');
    $admin_row = abget_admin($a_aid);

    echo '<form action="' . HtmlHelper::escape("{$admin_file}.php") . '" method="post">' . PHP_EOL;
    echo '<input type="hidden" name="a_aid" value="' . HtmlHelper::escape($a_aid) . '" />' . PHP_EOL;
    echo '<input type="hidden" name="op" value="ABAuthEditSave" />' . PHP_EOL;

    echo '<table summary="" align="center" border="0" cellpadding="2" cellspacing="2">' . PHP_EOL;

    echo '<tr><td bgcolor="' . HtmlHelper::escape($bgcolor2) . '"><strong>' . _AB_ADMIN . ':</strong></td>';
    echo '<td><strong>' . HtmlHelper::escape($a_aid) . '</strong></td></tr>' . PHP_EOL;

    echo '<tr><td bgcolor="' . HtmlHelper::escape($bgcolor2) . '"><strong>' . _AB_AUTHLOGIN . ':</strong></td>';
    echo '<td><input type="text" name="xlogin" size="20" maxlength="25" value="' . HtmlHelper::escape($admin_row['login'] ?? '') . '" /></td></tr>' . PHP_EOL;

    echo '<tr><td bgcolor="' . HtmlHelper::escape($bgcolor2) . '"><strong>' . _AB_PASSWORD . ':</strong></td>';
    echo '<td><input type="text" name="xpassword" size="20" maxlength="20" value="' . HtmlHelper::escape($admin_row['password'] ?? '') . '" /></td></tr>' . PHP_EOL;

    echo '<tr><td bgcolor="' . HtmlHelper::escape($bgcolor2) . '"><strong>' . _AB_PROTECTED . ':</strong></td>';
    echo '<td><select name="xprotected">' . PHP_EOL;

    $isProtected = (int)($admin_row['protected'] ?? 0);
    $options = [
        '0' => _AB_NOTPROTECTED,
        '1' => _AB_ISPROTECTED,
    ];
    echo HtmlHelper::selectOptions($options, $isProtected);

    echo '</select></td></tr>' . PHP_EOL;

    echo '<tr><td align="center" colspan="2"><input type="submit" value="' . _AB_SAVECHANGES . '" /></td></tr>' . PHP_EOL;

    echo '</table>' . PHP_EOL;
    echo '</form>' . PHP_EOL;

    CloseTable();
    include_once 'footer.php';

} else {
    header("Location: " . HtmlHelper::escape("{$admin_file}.php?op=ABMain"));
    exit;
}
