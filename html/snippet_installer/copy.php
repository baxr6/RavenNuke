<?php


$pagetitle = $pagename.": Copy Data";
@include("header.php");
title($pagetitle);
OpenTable();
echo "Operation Status!<br>\n";
echo "<hr>\n";
$cresult = $db->sql_query("SELECT * FROM ".$prefix."_downloads_categories ORDER BY cid");
while($cidinfo = $db->sql_fetchrow($cresult)) {
  if ($cidinfo['active'] == "" || !isset($cidinfo['active'])) { $cidinfo['active'] = "1"; }
  if (!get_magic_quotes_gpc()) {
    $cidinfo['title'] = addslashes($cidinfo['title']);
    $cidinfo['cdescription'] = addslashes($cidinfo['cdescription']);
  }
  $result = $db->sql_query("INSERT INTO ".$prefix."_nsngd_categories VALUES ('".$cidinfo['cid']."', '".$cidinfo['title']."', '".$cidinfo['cdescription']."', '".$cidinfo['parentid']."', 0, '', 0, ".$cidinfo['active'].");");
  if (!$result) { echo "- Insert ".$prefix."_nsngd_categories failed<br>\n"; } else { echo "- Insert ".$prefix."_nsngd_categories succeeded<br>\n"; }
}
$dresult = $db->sql_query("SELECT * FROM ".$prefix."_downloads_downloads ORDER BY lid");
while($lidinfo = $db->sql_fetchrow($dresult)) {
  if ($lidinfo['active'] == "" || !isset($lidinfo['active'])) { $lidinfo['active'] = "1"; }
  if ($lidinfo['sub_ip'] == "" || !isset($lidinfo['sub_ip'])) { $lidinfo['sub_ip'] = "0.0.0.0"; }
  if ($lidinfo['date'] == "" || !isset($lidinfo['date'])) { $lidinfo['date'] = date("Y-m-d H:i:s"); }
  if (!get_magic_quotes_gpc()) {
    $lidinfo['title'] = addslashes($lidinfo['title']);
    $lidinfo['url'] = addslashes($lidinfo['url']);
    $lidinfo['description'] = addslashes($lidinfo['description']);
    $lidinfo['name'] = addslashes($lidinfo['name']);
    $lidinfo['email'] = addslashes($lidinfo['email']);
    $lidinfo['submitter'] = addslashes($lidinfo['submitter']);
    $lidinfo['version'] = addslashes($lidinfo['version']);
    $lidinfo['homepage'] = addslashes($lidinfo['homepage']);
  }
  $result = $db->sql_query("INSERT INTO ".$prefix."_nsngd_downloads VALUES ('".$lidinfo['lid']."', '".$lidinfo['cid']."', '".$lidinfo['sid']."', '".$lidinfo['title']."', '".$lidinfo['url']."', '".$lidinfo['description']."', '".$lidinfo['date']."', '".$lidinfo['name']."', '".$lidinfo['email']."', '".$lidinfo['hits']."', '".$lidinfo['submitter']."', '".$lidinfo['sub_ip']."', '".$lidinfo['filesize']."', '".$lidinfo['version']."', '".$lidinfo['homepage']."', '".$lidinfo['active']."');");
  if (!$result) { echo "- Insert ".$prefix."_nsngd_downloads failed<br>\n"; } else { echo "- Insert ".$prefix."_nsngd_downloads succeeded<br>\n"; }
}
$mresult = $db->sql_query("SELECT * FROM ".$prefix."_downloads_modrequest ORDER BY requestid");
while($midinfo = $db->sql_fetchrow($mresult)) {
  if ($midinfo['sub_ip'] == "" || !isset($midinfo['sub_ip'])) { $midinfo['sub_ip'] = "0.0.0.0"; }
  if (!get_magic_quotes_gpc()) {
    $midinfo['title'] = addslashes($midinfo['title']);
    $midinfo['url'] = addslashes($midinfo['url']);
    $midinfo['description'] = addslashes($midinfo['description']);
    $midinfo['modifysubmitter'] = addslashes($midinfo['modifysubmitter']);
    $midinfo['name'] = addslashes($midinfo['name']);
    $midinfo['email'] = addslashes($midinfo['email']);
    $midinfo['version'] = addslashes($midinfo['version']);
    $midinfo['homepage'] = addslashes($midinfo['homepage']);
  }
  $result = $db->sql_query("INSERT INTO ".$prefix."_nsngd_mods VALUES ('".$midinfo['requestid']."', '".$midinfo['lid']."', '".$midinfo['cid']."', '".$midinfo['sid']."', '".$midinfo['title']."', '".$midinfo['url']."', '".$midinfo['description']."', '".$midinfo['modifysubmitter']."', '".$midinfo['sub_ip']."', '".$midinfo['brokendownload']."', '".$midinfo['name']."', '".$midinfo['email']."', '".$midinfo['filesize']."', '".$midinfo['version']."', '".$midinfo['homepage']."');");
  if (!$result) { echo "- Insert ".$prefix."_nsngd_mods failed<br>\n"; } else { echo "- Insert ".$prefix."_nsngd_mods succeeded<br>\n"; }
}
$nresult = $db->sql_query("SELECT * FROM ".$prefix."_downloads_newdownload ORDER BY lid");
while($nidinfo = $db->sql_fetchrow($nresult)) {
  if ($nidinfo['sub_ip'] == "" || !isset($nidinfo['sub_ip'])) { $nidinfo['sub_ip'] = "0.0.0.0"; }
  if ($nidinfo['date'] == "" || !isset($nidinfo['date'])) { $nidinfo['date'] = date("Y-m-d H:i:s"); }
  if (!get_magic_quotes_gpc()) {
    $nidinfo['title'] = addslashes($nidinfo['title']);
    $nidinfo['url'] = addslashes($nidinfo['url']);
    $nidinfo['description'] = addslashes($nidinfo['description']);
    $nidinfo['name'] = addslashes($nidinfo['name']);
    $nidinfo['email'] = addslashes($nidinfo['email']);
    $nidinfo['submitter'] = addslashes($nidinfo['submitter']);
    $nidinfo['version'] = addslashes($nidinfo['version']);
    $nidinfo['homepage'] = addslashes($nidinfo['homepage']);
  }
  $result = $db->sql_query("INSERT INTO ".$prefix."_nsngd_new VALUES ('".$nidinfo['lid']."', '".$nidinfo['cid']."', '".$nidinfo['sid']."', '".$nidinfo['title']."', '".$nidinfo['url']."', '".$nidinfo['description']."', '".$nidinfo['date']."', '".$nidinfo['name']."', '".$nidinfo['email']."', '".$nidinfo['submitter']."', '".$nidinfo['sub_ip']."', '".$nidinfo['filesize']."', '".$nidinfo['version']."', '".$nidinfo['homepage']."');");
  if (!$result) { echo "- Insert ".$prefix."_nsngd_new failed<br>\n"; } else { echo "- Insert ".$prefix."_nsngd_new succeeded<br>\n"; }
}
echo "<hr>\n";
echo "Operation Complete!<br>\n";
echo _GOBACK."\n";
CloseTable();
@include("footer.php");

?>