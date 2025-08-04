<?php

if (!defined('SNIP_PUBLIC')) {
  die("Illegal Access Detected!!!");
}
global $pagenum, $usePaginatorControl, $cfgPaginatorControl;
include_once ('header.php');
pubMenu();
jBreadCrumb();
OpenTable();
/*
$result = $db->sql_query( 'SELECT * FROM ' . $prefix . '_dfw_cat WHERE cid = \'' . $cid . '\' LIMIT 0,1');
while ($row = $db->sql_fetchrow($result)) {
$customTitle[] = ''.$row['cat'].' Code Snippets';
}

*/
echo '<div class="content">';
$cid = (int)$cid;

$iNumRowsPerPg = $arrSnip_cfg['per_page'] + 1;
$sql = 'SELECT id FROM ' . $prefix . '_dfw_code WHERE cid = \'' . $cid . '\' LIMIT 0,' . $iNumRowsPerPg;
$iTotSnipCount = $db->sql_numrows($db->sql_query($sql));
if ($iTotSnipCount < $iNumRowsPerPg)
  $usePaginatorControl = false;
if (isset($usePaginatorControl) && $usePaginatorControl) {
  $pagenum = (int)$pagenum;
  list($iSnipCount) = $db->sql_fetchrow($db->sql_query('SELECT COUNT(id) AS iSnipCount FROM ' . $prefix . '_dfw_code WHERE cid = \'' . $cid . '\''));
  include_once NUKE_CLASSES_DIR . 'class.paginator.php';
  include_once NUKE_CLASSES_DIR . 'class.paginator_html.php';
  $oPaginator = new Paginator_html($pagenum, $iSnipCount, $arrSnip_cfg['per_page']);
  $oPaginator->setDefaults($cfgPaginatorControl);
  $oPaginator->set_Limit($arrSnip_cfg['per_page']); // Sets number of stories per page
  $oPaginator->set_Links($cfgPaginatorControl['iMaxPages']); // Sets number of links before and after current page to show
  $oPaginator->setLink('modules.php?name=Snippets&op=pubViewCat&cid=' . $cid);
  $oPaginator->setTotalItems(_PAGINATOR_TOTALSNIPS);
  $sPaginatorHTML = $oPaginator->getPagerHTML() . '<br />';

  // SQL for paginator situation
  $result = $db->sql_query('SELECT * FROM ' . $prefix . '_dfw_code WHERE cid = \'' . $cid . '\' LIMIT ' . $oPaginator->getStartRow() . ',' . $arrSnip_cfg['per_page']);
} else {
  // SQL for non-paginator (could probably combine the two using a variable for the end of the SQL but ... someday
  $result = $db->sql_query('SELECT * FROM ' . $prefix . '_dfw_code WHERE cid = \'' . $cid . '\' LIMIT ' . $arrSnip_cfg['per_page']);
}
echo '<table align="center" cellspacing="5" cellpadding="5">' . "\n";
echo '<tr>' . "\n";
echo '<td style="border: 3px solid ' . $bgcolor2 . ';-moz-border-radius: 6px 6px 6px 6px;">' . _SNIP_TITLE . '</td>' . "\n";
echo '<td style="border: 3px solid ' . $bgcolor2 . ';-moz-border-radius: 6px 6px 6px 6px;">' . _SNIP_DESC . '</td>' . "\n";
echo '<td style="border: 3px solid ' . $bgcolor2 . ';-moz-border-radius: 6px 6px 6px 6px;">' . _SNIP_VIEW . '</td>' . "\n";
echo '</tr>' . "\n";
while ($row = $db->sql_fetchrow($result)) {
  $id = (int)$row['id'];
  $title = stripslashes(check_html($row['title'], 'nohtml'));
  $desc = stripslashes(check_html($row['desc'], 'nohtml'));
  echo '<tr style="background-color: ' . $bgcolor2 . ';">' . "\n";
  echo '<td style="white-space: nowrap;">' . $title . '</td>' . "\n";
  echo '<td>' . $desc . '</td>' . "\n";
  echo '<td><a href="modules.php?name=Snippets&amp;op=pubShow&amp;id=' . $id . '">View</a></td>' . "\n";
  echo '</tr>' . "\n";
}
echo '</table>' . "\n";
if (isset($usePaginatorControl) and $usePaginatorControl) {
  if ($cfgPaginatorControl['iPosition'] == 0 or $cfgPaginatorControl['iPosition'] == 2) {
    echo $sPaginatorHTML;
  }
}
CloseTable();
fSnipAPanel();
include_once ('footer.php');

?>