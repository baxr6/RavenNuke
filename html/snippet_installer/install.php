<?php

$pagetitle = $pagename.": Install";
include_once("header.php");
title($pagetitle);

$succeed = '<span style="color: green;font-weight: bold;">SUCCEEDED</span>';
$failed = '<span style="color: red;font-weight: bold;">FAILED</span>';

OpenTable();
echo "Operation Status!<br />\n";
echo "<hr />\n";

$result = $db->sql_query("CREATE TABLE `".$prefix."_dfw_cat` (
  `cid` mediumint(8) NOT NULL AUTO_INCREMENT,
  `cat` varchar(50) NOT NULL,
  `cdesc` varchar(100) DEFAULT '',
  `cimg` varchar(50) NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB;");
if (!$result) { echo "- Create ".$prefix."_dfw_cat ".$failed."<br />\n"; } else { echo "- Create ".$prefix."_dfw_cat ".$succeed."<br />\n"; }

$result = $db->sql_query("INSERT INTO `".$prefix."_dfw_cat` VALUES(1, 'PHP', 'php code', 'php.png');");
if (!$result) { echo "- Insert into ".$prefix."_dfw_cat ".$failed."<br />\n"; } else { echo "- Insert into ".$prefix."_dfw_cat ".$succeed."<br />\n"; }

$result = $db->sql_query("CREATE TABLE `".$prefix."_dfw_code` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `code` text,
  `desc` varchar(255) DEFAULT NULL,
  `tags` varchar(100) NOT NULL,
  `lang` varchar(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cid` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;");
if (!$result) { echo "- Create ".$prefix."_dfw_code ".$failed."<br />\n"; } else { echo "- Create ".$prefix."_dfw_code ".$succeed."<br />\n"; }

$result = $db->sql_query("CREATE TABLE `".$prefix."_dfw_comments` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `code_id` int(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(25) NOT NULL DEFAULT '',
  `comment` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;");
if (!$result) { echo "- Create ".$prefix."_dfw_comments ".$failed."<br />\n"; } else { echo "- Create ".$prefix."_dfw_comments ".$succeed."<br />\n"; }

$result = $db->sql_query("CREATE TABLE `".$prefix."_dfw_conf` (
  `config_name` varchar(255) NOT NULL DEFAULT '',
  `config_value` longtext NOT NULL,
  PRIMARY KEY (`config_name`)
) ENGINE=InnoDB;");
if (!$result) { echo "- Create ".$prefix."_dfw_conf ".$failed."<br />\n"; } else { echo "- Create ".$prefix."_dfw_conf ".$succeed."<br />\n"; }

$result = $db->sql_query("INSERT INTO `".$prefix."_dfw_conf` VALUES('allow_comments', '0');");
if (!$result) { echo "- Insert into ".$prefix."_dfw_conf ".$failed."<br />\n"; } else { echo "- Insert into ".$prefix."_dfw_conf ".$succeed."<br />\n"; }
$result = $db->sql_query("INSERT INTO `".$prefix."_dfw_conf` VALUES('right_blocks', '1');");
if (!$result) { echo "- Insert into ".$prefix."_dfw_conf ".$failed."<br />\n"; } else { echo "- Insert into ".$prefix."_dfw_conf ".$succeed."<br />\n"; }
$result = $db->sql_query("INSERT INTO `".$prefix."_dfw_conf` VALUES('version', '01.00.00');");
if (!$result) { echo "- Insert into ".$prefix."_dfw_conf ".$failed."<br />\n"; } else { echo "- Insert into ".$prefix."_dfw_conf ".$succeed."<br />\n"; }
$result = $db->sql_query("INSERT INTO `".$prefix."_dfw_conf` VALUES('per_cat', '1');");
if (!$result) { echo "- Insert into ".$prefix."_dfw_conf ".$failed."<br />\n"; } else { echo "- Insert into ".$prefix."_dfw_conf ".$succeed."<br />\n"; }
$result = $db->sql_query("INSERT INTO `".$prefix."_dfw_conf` VALUES('select_expand', '1');");
if (!$result) { echo "- Insert into ".$prefix."_dfw_conf ".$failed."<br />\n"; } else { echo "- Insert into ".$prefix."_dfw_conf ".$succeed."<br />\n"; }
$result = $db->sql_query("INSERT INTO `".$prefix."_dfw_conf` VALUES('php_keyword', '000080');");
if (!$result) { echo "- Insert into ".$prefix."_dfw_conf ".$failed."<br />\n"; } else { echo "- Insert into ".$prefix."_dfw_conf ".$succeed."<br />\n"; }
$result = $db->sql_query("INSERT INTO `".$prefix."_dfw_conf` VALUES('submit', 'submit');");
if (!$result) { echo "- Insert into ".$prefix."_dfw_conf ".$failed."<br />\n"; } else { echo "- Insert into ".$prefix."_dfw_conf ".$succeed."<br />\n"; }
$result = $db->sql_query("INSERT INTO `".$prefix."_dfw_conf` VALUES('php_const1', 'FF0000');");
if (!$result) { echo "- Insert into ".$prefix."_dfw_conf ".$failed."<br />\n"; } else { echo "- Insert into ".$prefix."_dfw_conf ".$succeed."<br />\n"; }
$result = $db->sql_query("INSERT INTO `".$prefix."_dfw_conf` VALUES('php_const2', 'FF0000');");
if (!$result) { echo "- Insert into ".$prefix."_dfw_conf ".$failed."<br />\n"; } else { echo "- Insert into ".$prefix."_dfw_conf ".$succeed."<br />\n"; }
$result = $db->sql_query("INSERT INTO `".$prefix."_dfw_conf` VALUES('php_func', '000080');");
if (!$result) { echo "- Insert into ".$prefix."_dfw_conf ".$failed."<br />\n"; } else { echo "- Insert into ".$prefix."_dfw_conf ".$succeed."<br />\n"; }
$result = $db->sql_query("INSERT INTO `".$prefix."_dfw_conf` VALUES('php_global', 'FF0000');");
if (!$result) { echo "- Insert into ".$prefix."_dfw_conf ".$failed."<br />\n"; } else { echo "- Insert into ".$prefix."_dfw_conf ".$succeed."<br />\n"; }
$result = $db->sql_query("INSERT INTO `".$prefix."_dfw_conf` VALUES('php_name', '800000');");
if (!$result) { echo "- Insert into ".$prefix."_dfw_conf ".$failed."<br />\n"; } else { echo "- Insert into ".$prefix."_dfw_conf ".$succeed."<br />\n"; }
$result = $db->sql_query("INSERT INTO `".$prefix."_dfw_conf` VALUES('php_number', 'FF0000');");
if (!$result) { echo "- Insert into ".$prefix."_dfw_conf ".$failed."<br />\n"; } else { echo "- Insert into ".$prefix."_dfw_conf ".$succeed."<br />\n"; }
$result = $db->sql_query("INSERT INTO `".$prefix."_dfw_conf` VALUES('php_string1', '800080');");
if (!$result) { echo "- Insert into ".$prefix."_dfw_conf ".$failed."<br />\n"; } else { echo "- Insert into ".$prefix."_dfw_conf ".$succeed."<br />\n"; }
$result = $db->sql_query("INSERT INTO `".$prefix."_dfw_conf` VALUES('php_string2', 'FF00FF');");
if (!$result) { echo "- Insert into ".$prefix."_dfw_conf ".$failed."<br />\n"; } else { echo "- Insert into ".$prefix."_dfw_conf ".$succeed."<br />\n"; }
$result = $db->sql_query("INSERT INTO `".$prefix."_dfw_conf` VALUES('php_value', '808080');");
if (!$result) { echo "- Insert into ".$prefix."_dfw_conf ".$failed."<br />\n"; } else { echo "- Insert into ".$prefix."_dfw_conf ".$succeed."<br />\n"; }
$result = $db->sql_query("INSERT INTO `".$prefix."_dfw_conf` VALUES('php_variable', '4040C2');");
if (!$result) { echo "- Insert into ".$prefix."_dfw_conf ".$failed."<br />\n"; } else { echo "- Insert into ".$prefix."_dfw_conf ".$succeed."<br />\n"; }
$result = $db->sql_query("INSERT INTO `".$prefix."_dfw_conf` VALUES('per_page', '10');");
if (!$result) { echo "- Insert into ".$prefix."_dfw_conf ".$failed."<br />\n"; } else { echo "- Insert into ".$prefix."_dfw_conf ".$succeed."<br />\n"; }
$result = $db->sql_query("INSERT INTO `".$prefix."_dfw_conf` VALUES('word_wrap', '80');");
if (!$result) { echo "- Insert into ".$prefix."_dfw_conf ".$failed."<br />\n"; } else { echo "- Insert into ".$prefix."_dfw_conf ".$succeed."<br />\n"; }
$result = $db->sql_query("INSERT INTO `nuke_dfw_conf` VALUES('js_mlcom', '4040c2');");
if (!$result) { echo "- Insert into ".$prefix."_dfw_conf ".$failed."<br />\n"; } else { echo "- Insert into ".$prefix."_dfw_conf ".$succeed."<br />\n"; }
$result = $db->sql_query("INSERT INTO `".$prefix."_dfw_conf` VALUES('js_com', '008000');");
if (!$result) { echo "- Insert into ".$prefix."_dfw_conf ".$failed."<br />\n"; } else { echo "- Insert into ".$prefix."_dfw_conf ".$succeed."<br />\n"; }
$result = $db->sql_query("INSERT INTO `".$prefix."_dfw_conf` VALUES('js_regexp', '800000');");
if (!$result) { echo "- Insert into ".$prefix."_dfw_conf ".$failed."<br />\n"; } else { echo "- Insert into ".$prefix."_dfw_conf ".$succeed."<br />\n"; }
$result = $db->sql_query("INSERT INTO `".$prefix."_dfw_conf` VALUES('js_string', '008080');");
if (!$result) { echo "- Insert into ".$prefix."_dfw_conf ".$failed."<br />\n"; } else { echo "- Insert into ".$prefix."_dfw_conf ".$succeed."<br />\n"; }
$result = $db->sql_query("INSERT INTO `".$prefix."_dfw_conf` VALUES('js_keywords', '000080');");
if (!$result) { echo "- Insert into ".$prefix."_dfw_conf ".$failed."<br />\n"; } else { echo "- Insert into ".$prefix."_dfw_conf ".$succeed."<br />\n"; }
$result = $db->sql_query("INSERT INTO `".$prefix."_dfw_conf` VALUES('js_global', '0000FF');");
if (!$result) { echo "- Insert into ".$prefix."_dfw_conf ".$failed."<br />\n"; } else { echo "- Insert into ".$prefix."_dfw_conf ".$succeed."<br />\n"; }
$result = $db->sql_query("INSERT INTO `".$prefix."_dfw_conf` VALUES('js_numbers', 'FF0000');");
if (!$result) { echo "- Insert into ".$prefix."_dfw_conf ".$failed."<br />\n"; } else { echo "- Insert into ".$prefix."_dfw_conf ".$succeed."<br />\n"; }
$result = $db->sql_query("INSERT INTO `".$prefix."_modules` VALUES(NULL, 'Snippets', 'Snippets', 1, 0, '', 1, 0, '');");
if (!$result) { echo "Module Activation ".$failed."<br />\n"; } else { echo "Activate Module ".$succeed."<br />\n";echo "Activate In Menu ".$succeed."<br />\n"; }

echo "<hr />\n";
echo "Operation Complete!<br />\n";
echo _GOBACK."\n";
CloseTable();
include_once("footer.php");

?>
