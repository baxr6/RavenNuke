<?php

/********************************************************/
/* NukeSentinel(tm) - Admin Auth Save                   */
/* Modernized for PHP 8.3+                              */
/********************************************************/

if (!defined('NUKESENTINEL_ADMIN')) {
    header("Location: ../../../" . $admin_file . ".php");
    exit;
}

if (!is_god()) {
    header("Location: " . $admin_file . ".php?op=ABMain");
    exit;
}

// Sanitize inputs
$a_aid = InputValidator::sanitizeString($a_aid ?? '');
$xlogin = InputValidator::sanitizeString($xlogin ?? '');
$xpassword = InputValidator::sanitizeString($xpassword ?? '');
$xprotected = InputValidator::validateInt($xprotected ?? 0, 0, 0, 1);

// Compose email content
$subject = _AB_ACCESSCHANGEDON . ' ' . ($nuke_config['sitename'] ?? 'Your Site');
$message  = _AB_HTTPONLY . "\n";
$message .= _AB_LOGIN . ': ' . $xlogin . "\n";
$message .= _AB_PASSWORD . ': ' . $xpassword . "\n";
$message .= _AB_PROTECTED . ': ' . ($xprotected === 0 ? _AB_NO : _AB_YES) . "\n";

// Generate password hashes
$xpassword_md5 = md5($xpassword); // Deprecated but kept for backward compatibility
$xpassword_crypt = crypt($xpassword, ''); // Also legacy
$xpassword_hash = password_hash($xpassword, PASSWORD_DEFAULT); // Modern (store if schema updated)

// Update admin record
$updateQuery = <<<SQL
    UPDATE `{$prefix}_nsnst_admins`
    SET `login` = ?, `password` = ?, `password_md5` = ?, `password_crypt` = ?, `protected` = ?
    WHERE `aid` = ?
SQL;

$updateParams = [$xlogin, $xpassword, $xpassword_md5, $xpassword_crypt, $xprotected, $a_aid];
$dbWrapper = new DatabaseWrapper($db, $prefix);
$dbWrapper->executeUpdate($updateQuery, $updateParams);

// Get author email
$emailRow = $dbWrapper->prepareSingle("SELECT `email` FROM `{$prefix}_authors` WHERE `aid` = ? LIMIT 1", [$a_aid]);
$amail = $emailRow['email'] ?? '';

if (!empty($amail)) {
    if (defined('TNML_IS_ACTIVE') && TNML_IS_ACTIVE === true) {
        tnml_fMailer($amail, $subject, $message, $nuke_config['adminmail']);
    } else {
        @mail(
            $amail,
            $subject,
            $message,
            "From: " . $nuke_config['adminmail'] . "\r\n" .
            "X-Mailer: " . _AB_NUKESENTINEL . "\r\n"
        );
    }
}

// Rewrite staccess file if enabled and writable
$stPath = $ab_config['staccess_path'] ?? '';
if (!empty($stPath) && is_writable($stPath)) {
    $stLines = [];

    $admins = $dbWrapper->prepareAndExecute("SELECT `login`, `password_crypt` FROM `{$prefix}_nsnst_admins` WHERE `password_crypt` != '' ORDER BY `aid`");
    foreach ($admins as $adminRow) {
        $stLines[] = $adminRow['login'] . ':' . $adminRow['password_crypt'];
    }

    $content = implode("\n", $stLines) . "\n";
    file_put_contents($stPath, $content, LOCK_EX);
}

// Redirect to auth list
header("Location: " . $admin_file . ".php?op=ABAuthList");
exit;
