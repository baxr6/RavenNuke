<?php



require_once("mainfile.php");
global $admin;
if (is_admin($admin)) {
  if(!is_array($admin)) {
    $adm = base64_decode($admin);
    $adm = explode(":", $adm);
    $aname = "$adm[0]";
  } else {
    $aname = "$admin[0]";
  }
}

define('INDEX_FILE', true); //comment this out to hide right blocks
if (defined('INDEX_FILE')) { $index = 1; } else {$index = 0; } // auto set right blocks for pre patch 3.1 compatibility

$adm_info = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_authors WHERE aid='$aname'"));
if ($adm_info['radminsuper']==1) {
$pagename = "Snippets Gallery";
if (!isset($op)) { $op = ''; }
  switch($op) {
    default:@include("snippet_installer/default.php");break;
    case "install":@include("snippet_installer/install.php");break;
    case "copy":@include("snippet_installer/copy.php");break;
    case "uninstall":@include("snippet_installer/uninstall.php");break;
  }
} else {
  @include("snippet_installer/error.php");
}

?>