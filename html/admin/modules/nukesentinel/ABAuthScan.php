<?php

declare(strict_types=1);

/********************************************************/
/* NukeSentinel(tm)                                     */
/* By: NukeScripts(tm) (http://www.nukescripts.net)    */
/* Copyright © 2000-2008 by NukeScripts(tm)             */
/* See CREDITS.txt for ALL contributors                 */
/********************************************************/


if (!defined('NUKESENTINEL_ADMIN')) {
    header("Location: ../../../{$admin_file}.php");
    exit;
}

if (!is_god()) {
    header("Location: {$admin_file}.php?op=ABMain");
    exit;
}

$dbWrapper = new DatabaseWrapper($db, $prefix);

$importnamed = $exportnamed = '';
$importadded = $exportadded = 0;

// Import missing authors into admins table
$authors = $dbWrapper->prepareAndExecute("SELECT `aid`, `name`, `pwd` FROM `{$prefix}_authors`");

foreach ($authors as $author) {
    $a_aid = (int)($author['aid'] ?? 0);
    if ($a_aid === 0) {
        continue; // skip invalid aids
    }

    $adminExists = $dbWrapper->prepareSingle(
        "SELECT `aid` FROM `{$prefix}_nsnst_admins` WHERE `aid` = ?",
        [$a_aid],
        'i'
    );

    if (empty($adminExists)) {
        $importadded++;
        $importnamed .= ($importnamed === '') ? (string)$a_aid : ', ' . (string)$a_aid;

        // Generate random 20-character password
        $chars = "abc2def3ghj4kmn5opq6rst7uvw8xyz9";
        $makepass = '';
        for ($x = 0; $x < 20; $x++) {
            $makepass .= $chars[random_int(0, strlen($chars) - 1)];
        }

        // Hashes
        $xpassword_md5 = md5($makepass);
        $xpassword_crypt = crypt($makepass, '');

        $is_god_flag = (strtolower($author['name']) === 'god') ? 1 : 0;

        // Insert new admin row with safe data
        $dbWrapper->executeUpdate(
            "INSERT INTO `{$prefix}_nsnst_admins` (`aid`, `login`, `protected`, `password`, `password_md5`, `password_crypt`) VALUES (?, ?, ?, ?, ?, ?)",
            [
                $a_aid,
                (string)$a_aid,
                $is_god_flag,
                $makepass,
                $xpassword_md5,
                $xpassword_crypt
            ],
            'sissss' // types: int, string, int, string, string, string
        );

        $dbWrapper->optimizeTable("nsnst_admins");

        // Prepare message
        $aidrow = $dbWrapper->prepareSingle("SELECT * FROM `{$prefix}_nsnst_admins` WHERE `aid` = ? LIMIT 1", [$a_aid], 'i');
        $subject = _AB_ACCESSFOR . ' ' . HtmlHelper::escape($nuke_config['sitename']);
        $message = _AB_HTTPONLY . "\n";
        $message .= _AB_LOGIN . ': ' . $aidrow['login'] . "\n";
        $message .= _AB_PASSWORD . ': ' . $aidrow['password'] . "\n";
        $message .= _AB_PROTECTED . ': ' . ($aidrow['protected'] == 0 ? _AB_NO : _AB_YES) . "\n";

        // Optionally send password email - currently disabled by default
        $send_pw_to_admin_email = false;
        if ($send_pw_to_admin_email) {
            $authorEmailRow = $dbWrapper->prepareSingle("SELECT `email` FROM `{$prefix}_authors` WHERE `aid` = ? LIMIT 1", [$a_aid], 'i');
            $amail = $authorEmailRow['email'] ?? '';

            if (!empty($amail)) {
                if (defined('TNML_IS_ACTIVE') && TNML_IS_ACTIVE) {
                    tnml_fMailer($amail, $subject, $message, $nuke_config['adminmail']);
                } else {
                    @mail($amail, $subject, $message, "From: {$nuke_config['adminmail']}\r\nX-Mailer: " . _AB_NUKESENTINEL . "\r\n");
                }
            }
        }
    }
}

// Remove admins no longer authors
$admins = $dbWrapper->prepareAndExecute("SELECT `aid` FROM `{$prefix}_nsnst_admins`");
foreach ($admins as $admin) {
    $a_aid = (int)($admin['aid'] ?? 0);
    if ($a_aid === 0) {
        continue;
    }

    $authorExists = $dbWrapper->prepareSingle(
        "SELECT `aid` FROM `{$prefix}_authors` WHERE `aid` = ? LIMIT 1",
        [$a_aid],
        'i'
    );

    if (empty($authorExists)) {
        $exportadded++;
        $exportnamed .= ($exportnamed === '') ? (string)$a_aid : ', ' . (string)$a_aid;

        $dbWrapper->executeUpdate("DELETE FROM `{$prefix}_nsnst_admins` WHERE `aid` = ? LIMIT 1", [$a_aid], 'i');
        $dbWrapper->optimizeTable("nsnst_admins");
    }
}

// Output result page
$pagetitle = _AB_NUKESENTINEL . ': ' . _AB_SCANADMINS;

include "header.php";
OpenTable();
OpenMenu(_AB_SCANADMINS);
mastermenu();
CarryMenu();
authmenu();
CloseMenu();
CloseTable();

echo '<br />', "\n";
OpenTable();
echo '<div class="text-center"><strong>' . _AB_SCANADMINSDONE . '</strong><br />' . "\n",
    '<strong>' . _AB_ADMINSADDED . ':</strong> ' . $importadded;
if ($importnamed !== '') {
    echo ' (' . HtmlHelper::escape($importnamed) . ')';
}
echo '<br />', "\n",
    '<strong>' . _AB_ADMINSREMOVED . ':</strong> ' . $exportadded;
if ($exportnamed !== '') {
    echo ' (' . HtmlHelper::escape($exportnamed) . ')';
}
echo '<br />', "\n",
    '<a href="' . HtmlHelper::escape($admin_file) . '.php?op=ABAuthList">' . _AB_LISTHTTPAUTH . '</a></div>', "\n";
CloseTable();

include 'footer.php';
