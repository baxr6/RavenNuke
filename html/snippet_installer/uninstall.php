<?php

$pagetitle = $pagename.": uninstall";
@include("header.php");
title($pagetitle);

$succeed = '<span style="color: green;font-weight: bold;">SUCCEEDED</span>';
$failed = '<span style="color: red;font-weight: bold;">FAILED</span>';


OpenTable();
echo "Operation Status!<br>\n";
echo "<hr>\n";
$result = $db->sql_query("DROP TABLE ".$prefix."_dfw_cat");
if (!$result) { echo "- uninstall ".$prefix."_dfw_cat ".$failed."<br />\n"; } else { echo "- uninstall ".$prefix."_dfw_cat ".$succeed."<br />\n"; }

$result = $db->sql_query("DROP TABLE ".$prefix."_dfw_code");
if (!$result) { echo "- uninstall ".$prefix."_dfw_code ".$failed."<br />\n"; } else { echo "- uninstall ".$prefix."_dfw_code ".$succeed."<br />\n"; }

$result = $db->sql_query("DROP TABLE ".$prefix."_dfw_comments");
if (!$result) { echo "- uninstall ".$prefix."_dfw_comments ".$failed."<br />\n"; } else { echo "- uninstall ".$prefix."_dfw_comments ".$succeed."<br />\n"; }

$result = $db->sql_query("DROP TABLE ".$prefix."_dfw_conf");
if (!$result) { echo "- uninstall ".$prefix."_dfw_conf ".$failed."<br />\n"; } else { echo "- uninstall ".$prefix."_dfw_conf ".$succeed."<br />\n"; }


echo "<hr>\n";
echo "Operation Complete!<br>\n";
echo _GOBACK."\n";
CloseTable();
@include("footer.php");

?>