<?php

if (!defined('SNIP_PUBLIC')) {
  die("Illegal Access Detected!!!");
}

include ('header.php');
pubMenu();
jBreadCrumb();
OpenTable();
echo '<blockquote style="text-align: center;">' . "\n";
include_once ('modules/' . $module_name . '/includes/wordcloud.class.php');
$cloud = new cWordCloud();
$result = $db->sql_query('SELECT tags FROM ' . $prefix . '_dfw_code');
if ($result) {
  while ($row = $db->sql_fetchrow($result)) {
    $getTags = explode(',', stripslashes($row['tags']));
    foreach ($getTags as $key => $value) {
      $value = trim($value);
      $cloud->addWord($value);
    }
  }
}
$myCloud = $cloud->showCloud('array');
asort($myCloud);
if (is_array($myCloud)) {
  foreach ($myCloud as $key => $value) {
    echo ' <a href="modules.php?name=' . $module_name . '&amp;op=browse_tag&amp;tag=' . urlencode($value['word']) . '" style="font-size: 1.' . $value['range'] . 'em">' . ucwords($value['word']) .
      '</a> &nbsp;' . "\n";
  }
}
echo '</blockquote>' . "\n";
CloseTable();
include ('footer.php');

?>