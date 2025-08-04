<?php

/********************************************************************/
/* NW NukeCrumbs                                                    */
/* ===========================                                      */
/* Copyright (c) 2005 by Jason Gregory                              */
/* http://www.nukeworkz.com                                         */
/*                                                                  */
/* Based on code from PHP-Nuke                                      */
/* Copyright (c) 2002 by Francisco Burzi                            */
/* http://phpnuke.org                                               */
/*                                                                  */
/* This program is free software. You can redistribute it and/or    */
/* modify it under the terms of the GNU General Public License as   */
/* published by the Free Software Foundation; either version 2 of   */
/* the License.                                                     */
/********************************************************************/
/* Credit to unknown author of original forums code in              */
/* includes/dynamic_titles.php.                                     */
/* Credit to Greg Schoper                                           */
/* http://nuke.schoper.net                                          */
/* Credit to unknown author                                         */
/* http://www.netflake.com                                          */
/********************************************************************/

if (stristr(htmlentities($_SERVER['PHP_SELF']), "NW-NukeCrumbs.php")) {
  Header("Location: ../index.php");
  die();
}

$name = preg_replace("/_/", " ", "$name");

/**************************************************/
/*							  */
/*			Begin Customization Here	  */
/*							  */
/**************************************************/
// Item Delimeter, change to whatever you want
$item_delim = " > ";

// Home Link change text 'Home' to whatever you want
$homelink = '<a href="index.php">Home</a>';

// use html for linking
$usecode = 1; // 1 = on, 0 = off, default is on
/**************************************************/
/*							  */
/*			End Customization Here	  */
/*							  */
/**************************************************/
$breadcrumb = '';

global $name, $prefix, $db;
//include ( "config.php" );
//include ( "db/db.php" );


// Forums
if ($name == "Forums") {
  global $p, $t, $forum, $f, $prefix, $file;
  $breadcrumb = "$homelink $item_delim $name";
  $breadcrumb = preg_replace("/\[(\S+)\]/e", "", $breadcrumb);
  $p = $_REQUEST['p'];
  $t = $_REQUEST['t'];
  $f = $_REQUEST['f'];
  $file = $_REQUEST['file'];
  if ($p) {
    $p = $_REQUEST['p'];
    $p = intval($p);
    $sql = "SELECT post_subject, post_id, post_text FROM " . $prefix . "_bbposts_text WHERE post_id='$p'";
    $result = $db->sql_query($sql);
    $row = $db->sql_fetchrow($result);
    $title = $row['post_subject'];
    $post = $row['post_id'];
    $ptext = $row['post_text'];
    $sql = "SELECT forum_id FROM " . $prefix . "_bbposts WHERE post_id='$p'";
    $result = $db->sql_query($sql);
    $row = $db->sql_fetchrow($result);
    $fid = $row['forum_id'];
    $sql = "SELECT forum_name FROM " . $prefix . "_bbforums WHERE forum_id='$fid'";
    $result = $db->sql_query($sql);
    $row = $db->sql_fetchrow($result);
    $forumname = $row['forum_name'];
    $breadcrumb = "$file--$homelink $item_delim <a href=\"modules.php?name=$name\">yo1</a> $item_delim <a href=\"modules.php?name=Forums&file=viewforum&f=$fid\">$forumname</a> $item_delim Topic > $title yo1";
    $breadcrumb = preg_replace("/\[(\S+)\]/e", "", $breadcrumb);
  }
  if ($t) {
    $t = $_REQUEST['t'];
    $t = intval($t);
    $sql = "SELECT forum_id, topic_first_post_id  FROM " . $prefix . "_bbtopics WHERE topic_id='$t'";
    $result = $db->sql_query($sql);
    $row = $db->sql_fetchrow($result);
    $fid = $row['forum_id'];
    $tpid = $row['topic_first_post_id'];

    $sql = "SELECT post_subject, post_id, post_text FROM " . $prefix . "_bbposts_text WHERE post_id='$tpid'";
    $result = $db->sql_query($sql);
    $row = $db->sql_fetchrow($result);
    $title = $row['post_subject'];
    $post = $row['post_id'];
    $ptext = $row['post_text'];

    $sql = "SELECT forum_name FROM " . $prefix . "_bbforums WHERE forum_id='$fid'";
    $result = $db->sql_query($sql);
    $row = $db->sql_fetchrow($result);
    $forumname = $row['forum_name'];

    $breadcrumb = "$file--$homelink $item_delim <a href=\"modules.php?name=$name\">yo2</a> $item_delim <a href=\"modules.php?name=Forums&file=viewforum&f=$fid\">$forumname</a> $item_delim Topic > $title yo2";
    $breadcrumb = preg_replace("/\[(\S+)\]/e", "", $breadcrumb);
  }
  if ($f) {
    $f = $_REQUEST['f'];
    $f = intval($f);
    $sql = "SELECT forum_name FROM " . $prefix . "_bbforums WHERE forum_id='$f'";
    $result = $db->sql_query($sql);
    $row = $db->sql_fetchrow($result);
    $forum = $row['forum_name'];
    $breadcrumb = "$file--$homelink $item_delim <a href=\"modules.php?name=$name\">yo3</a> $item_delim $forum $item_delim $f yo3";
    $breadcrumb = preg_replace("/\[(\S+)\]/e", "", $breadcrumb);
  }
}

// News

/* chage for nuke 7.9 */
$home = defined('HOME_FILE');

if ($name == "News" and $home) {
  $breadcrumb = "$homelink";
} else {
  /* end chage for nuke 7.9 */
  global $file, $sid, $new_topic, $topic, $slogan, $prefix;
  $breadcrumb = preg_replace("/\[(\S+)\]/e", "", $breadcrumb);
  $breadcrumb = "$homelink $item_delim $name";
  if ($new_topic != "") {
    $sql = "SELECT topictext FROM " . $prefix . "_topics WHERE topicid='$new_topic'";
    $result = $db->sql_query($sql);
    $row = $db->sql_fetchrow($result);
    $top = $row['topictext'];
    $breadcrumb = "$homelink $item_delim <a href=\"modules.php?name=$name\">$name</a> $item_delim <a href=\"modules.php?name=News&new_topic=$top\">$top</a>";
  }
  if ($topic != "") {
    $sql = "SELECT topictext FROM " . $prefix . "_topics WHERE topicid='$topic'";
    $result = $db->sql_query($sql);
    $row = $db->sql_fetchrow($result);
    $top = $row['topictext'];
    $breadcrumb = "$homelink $item_delim <a href=\"modules.php?name=$name\">$name</a> $item_delim <a href=\"modules.php?name=News&new_topic=$top\">$top</a>";
  }
  if ($file == "article") {
    $sql = "SELECT title, topic FROM " . $prefix . "_stories WHERE sid='$sid'";
    $result = $db->sql_query($sql);
    $row = $db->sql_fetchrow($result);
    $art = $row[title];
    $top = $row[topic];
    $sql = "SELECT topictext FROM " . $prefix . "_topics WHERE topicid='$top'";
    $result = $db->sql_query($sql);
    $row = $db->sql_fetchrow($result);
    $top = $row[topictext];
    $breadcrumb = "$homelink $item_delim <a href=\"modules.php?name=$name\">$name</a> $item_delim <a href=\"modules.php?name=News&new_topic=$top\">$top</a> $item_delim Article > $art";
  }
}

// Topics
if ($name == "Topics") {
  $breadcrumb = "$homelink $item_delim " . _ACTIVETOPICS . "";
}

// Downloads
if ($name == "Downloads") {
  global $d_op, $cid, $lid;
  $breadcrumb = "$homelink $item_delim $name";
  if ($d_op == "viewdownload") {
    $sql = "SELECT title, parentid FROM " . $prefix . "_downloads_categories WHERE cid='$cid'";
    $result = $db->sql_query($sql);
    $row = $db->sql_fetchrow($result);
    $cat = $row[title];
    $parent = $row[parentid];
    if ($parent == "0") {
      $breadcrumb = "$homelink $item_delim <a href=\"modules.php?name=$name\">$name</a> $item_delim $cat";
    } else {
      $sql = "SELECT title FROM " . $prefix . "_downloads_categories WHERE cid='$parent'";
      $result = $db->sql_query($sql);
      $row = $db->sql_fetchrow($result);
      $parent = $row[title];
      $breadcrumb = "$homelink $item_delim <a href=\"modules.php?name=$name\">$name</a> $item_delim <a href=\"modules.php?name=Downloads&d_op=viewdownload&cid=$cid\">$parent</a> $item_delim $cat";
    }
  }
  if ($d_op == "viewdownloaddetails" || $d_op == "getit") {
    if ($lid) {
      $lid = intval($lid);
      $sql = "SELECT cid, title FROM " . $prefix . "_downloads_downloads WHERE lid='$lid'";
      $result = $db->sql_query($sql);
      $row = $db->sql_fetchrow($result);
      $dl = $row[title];
      $cid = $row[cid];
      $sql = "SELECT parentid FROM " . $prefix . "_downloads_categories WHERE cid='$lid'";
      $result = $db->sql_query($sql);
      $row = $db->sql_fetchrow($result);
      $pid = $row[parentid];
      $sql = "SELECT title FROM " . $prefix . "_downloads_categories WHERE cid='$pid'";
      $result = $db->sql_query($sql);
      $row = $db->sql_fetchrow($result);
      $cat = $row[title];
      $sql = "SELECT title FROM " . $prefix . "_downloads_categories WHERE cid='$cid'";
      $result = $db->sql_query($sql);
      $row = $db->sql_fetchrow($result);
      $subcat = $row[title];
      if (!$cat) {
        $breadcrumb = "$homelink $item_delim <a href=\"modules.php?name=$name\">$name</a> $item_delim <a href=\"modules.php?name=Downloads&d_op=viewdownload&cid=$cid\">$subcat</a> $item_delim $dl";
      } else {
        $breadcrumb = "$homelink $item_delim <a href=\"modules.php?name=$name\">$name</a> $item_delim <a href=\"modules.php?name=Downloads&d_op=viewdownload&cid=$pid\">$cat</a> $item_delim <a href=\"modules.php?name=Downloads&d_op=viewdownload&cid=$cid\">$subcat</a> $item_delim $dl";
      }
    } else {
      $sql = "SELECT cid, title FROM " . $prefix . "_downloads_downloads WHERE lid='$lid'";
      $result = $db->sql_query($sql);
      $row = $db->sql_fetchrow($result);
      $dl = $row[title];
      $cid = $row[cid];
      $sql = "SELECT title FROM " . $prefix . "_downloads_categories WHERE cid='$cid'";
      $result = $db->sql_query($sql);
      $row = $db->sql_fetchrow($result);
      $cat = $row[title];
      $breadcrumb = "$homelink $item_delim <a href=\"modules.php?name=$name\">$name</a> $item_delim $cat $item_delim $dl";
    }
  }
}

// Web Links
if ($name == "Web_Links") {
  global $l_op, $cid, $lid;
  $name = ereg_replace("_", " ", "$name");
  $breadcrumb = "$homelink $item_delim $name";
  if ($l_op == "viewlink") {
    $sql = "SELECT title, parentid FROM " . $prefix . "_links_categories WHERE cid='$cid'";
    $result = $db->sql_query($sql);
    $row = $db->sql_fetchrow($result);
    $cat = $row[title];
    $parent = $row[parentid];
    if ($parent == "0") {
      $breadcrumb = "$homelink $item_delim $name $item_delim $cat";
    } else {
      $sql = "SELECT title FROM " . $prefix . "_links_categories WHERE cid='$parent'";
      $result = $db->sql_query($sql);
      $row = $db->sql_fetchrow($result);
      $cat = $row[title];
      $breadcrumb = "$homelink $item_delim $name $item_delim $parent $item_delim $cat";
    }
  }
}

// Content
if ($name == "Content") {
  global $pa, $cid, $pid, $name;
  $breadcrumb = "$name";
  if ($pa == "list_pages_categories") {
    $sql = "SELECT title FROM " . $prefix . "_pages_categories WHERE cid='$cid'";
    $result = $db->sql_query($sql);
    $row = $db->sql_fetchrow($result);
    $cat = $row[title];
    $breadcrumb = "$homelink $item_delim $name $item_delim $cat";
  }
  if ($pa == "showpage") {
    $sql = "SELECT title, cid FROM " . $prefix . "_pages WHERE pid='$pid'";
    $result = $db->sql_query($sql);
    $row = $db->sql_fetchrow($result);
    $page = $row[title];
    $cid = $row[cid];
    $sql = "SELECT title FROM " . $prefix . "_pages_categories WHERE cid='$cid'";
    $result = $db->sql_query($sql);
    $row = $db->sql_fetchrow($result);
    $cat = $row[title];
    $breadcrumb = "$homelink $item_delim $name $item_delim $cat $item_delim $page";
  }
}

if ($name == "Snippets") {
  global $op, $cid, $id, $name;
  $breadcrumb = "$homelink $item_delim $name";
  if ($op == "pubViewCat") {
    $sql = 'SELECT cat FROM ' . $prefix . '_dfw_cat WHERE cid = \'' . $cid . '\'';
    $result = $db->sql_query($sql);
    $row = $db->sql_fetchrow($result);
    $cat = $row['cat'];
    $breadcrumb = "$homelink $item_delim <a href=\"modules.php?name=$name\">$name</a> $item_delim <a href=\"modules.php?name=$name&op=pubViewCat&cid=$cid\">$cat</a>";
  }
  if ($op == "pubShow") {

    $sql = "SELECT * FROM " . $prefix . "_dfw_code WHERE id='$id'";
    $result = $db->sql_query($sql);
    $row = $db->sql_fetchrow($result);
    $page = $row['title'];
    $cid = $row['cid'];
    $sql = 'SELECT cat FROM ' . $prefix . '_dfw_cat WHERE cid = \'' . $cid . '\'';
    $result = $db->sql_query($sql);
    $row = $db->sql_fetchrow($result);
    $cat = $row['cat'];
    $breadcrumb = "$homelink $item_delim <a href=\"modules.php?name=$name\">$name</a> $item_delim <a href=\"modules.php?name=$name&op=pubViewCat&cid=$cid\">$cat</a> $item_delim <a href=\"modules.php?name=$name&op=pubShow&id=$id\">$page</a>";
  }
}


// Reviews
if ($name == "Reviews") {
  global $rop, $id, $name;
  $breadcrumb = "$name";
  if ($rop == "showcontent") {
    $sql = "SELECT title FROM " . $prefix . "_reviews WHERE id='$id'";
    $result = $db->sql_query($sql);
    $row = $db->sql_fetchrow($result);
    $rev = $row[title];
    $breadcrumb = "$homelink $item_delim $name $item_delim $rev";
  }
}

// Stories Archive
if ($name == "Stories_Archive") {
  global $sa, $year, $month_l, $name;
  $name = ereg_replace("_", " ", "$name");
  $breadcrumb = "$name";
  if ($sa == "show_month") {
    $breadcrumb = "$homelink $item_delim $name $item_delim $month_l, $year";
  }
}

// Sections
if ($name == "Sections") {
  global $op, $secid, $artid, $name;
  $breadcrumb = "$name";
  if ($op == "listarticles") {
    $sql = "SELECT secname FROM " . $prefix . "_sections WHERE secid='$secid'";
    $result = $db->sql_query($sql);
    $row = $db->sql_fetchrow($result);
    $sec = $row[secname];
    $breadcrumb = "$homelink $item_delim $name $item_delim $sec";
  }
  if ($op == "viewarticle") {
    $sql = "SELECT title, secid FROM " . $prefix . "_seccont WHERE artid='$artid'";
    $result = $db->sql_query($sql);
    $row = $db->sql_fetchrow($result);
    $art = $row[title];
    $cid = $row[secid];
    $sql = "SELECT secname FROM " . $prefix . "_sections WHERE secid='$cid'";
    $result = $db->sql_query($sql);
    $row = $db->sql_fetchrow($result);
    $sec = $row[secname];
    $breadcrumb = "$homelink $item_delim $name $item_delim $sec $item_delim $art";
  }
}

// Catchall for anything we don't have custom coding for
if ($breadcrumb == "") {
  $name = ereg_replace("_", " ", "$name");
  $breadcrumb = "$homelink $item_delim $name";
}

// Admin Pages
if (substr($_SERVER['REQUEST_URI'], 0, 10) == "/admin.php") {
  $breadcrumb = "$homelink $item_delim Administration";
}

// If we're on the main page let's use our site slogan
if ($_SERVER['REQUEST_URI'] == "/index.php" || $_SERVER['REQUEST_URI'] == "/") {
  $breadcrumb = "$homelink";
}

// We're Done! Place the breadcrumb on the page
if ($usecode == 1) {
  echo "$breadcrumb\n";
} else {
  $breadcrumb = addslashes(check_html($breadcrumb, nohtml); echo "$breadcrumb\n"; }

$name = preg_replace("/\s/", "_", "$name");

?>