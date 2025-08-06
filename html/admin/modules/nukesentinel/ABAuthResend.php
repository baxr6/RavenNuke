<?php

declare(strict_types=1);

/********************************************************/
/* NukeSentinel(tm)                                     */
/* By: NukeScripts(tm) (http://www.nukescripts.net)    */
/* Copyright © 2000-2008 by NukeScripts(tm)             */
/* See CREDITS.txt for ALL contributors                 */
/********************************************************/


if (!defined('NUKESENTINEL_ADMIN')) {
    header('Location: ../../../' . $admin_file . '.php');
    exit;
}

if (!is_god()) {
    header('Location: ' . $admin_file . '.php?op=ABMain');
    exit;
}

$dbWrapper = new DatabaseWrapper($db, $prefix);

// Sanitize $a_aid to integer to prevent injection
$a_aid_safe = (int)($a_aid ?? 0);

// Fetch admin row
$aidRow = $dbWrapper->prepareSingle("SELECT * FROM `{$prefix}_nsnst_admins` WHERE `aid` = ? LIMIT 1", [$a_aid_safe], 'i');

if (empty($aidRow)) {
    // Admin not found - redirect or error
    header("Location: {$admin_file}.php?op=ABAuthList");
    exit;
}

$subject = _AB_ACCESSFOR . ' ' . HtmlHelper::escape($nuke_config['sitename']);
$message = _AB_HTTPONLY . "\n";
$message .= _AB_LOGIN . ': ' . $aidRow['login'] . "\n";
$message .= _AB_PASSWORD . ': ' . $aidRow['password'] . "\n";
$message .= _AB_PROTECTED . ': ' . ($aidRow['protected'] == 0 ? _AB_NO : _AB_YES) . "\n";

// Fetch author's email safely
$authorRow = $dbWrapper->prepareSingle("SELECT `email` FROM `{$prefix}_authors` WHERE `aid` = ? LIMIT 1", [$a_aid_safe], 'i');
$amail = $authorRow['email'] ?? '';

if (!empty($amail)) {
    if (defined('TNML_IS_ACTIVE') && TNML_IS_ACTIVE) {
        tnml_fMailer($amail, $subject, $message, $nuke_config['adminmail']);
    } else {
        @mail($amail, $subject, $message, 'From: ' . $nuke_config['adminmail'] . "\r\nX-Mailer: " . _AB_NUKESENTINEL . "\r\n");
    }
}

header('Location: ' . $admin_file . '.php?op=ABAuthList');
exit;
