<?php

if ( !defined('SNIP_PUBLIC') ) {
  die( "Illegal Access Detected!!!" );
}

include_once ( 'header.php' );
pubMenu();
jBreadCrumb();
$maincode = 0;
$dum = 0;
$cid = 0;
OpenTable();
echo '<div align="center"><b>Snippet Categories</b></div><br /><br />';
echo '<table align="center" cellspacing="2" cellpadding="10" width="80%">';
$sql = 'SELECT cid, cat, cdesc, cimg FROM ' . $prefix . '_dfw_cat ORDER BY cat';
$result = $db->sql_query( $sql );
$count = 0;
while ( $row = $db->sql_fetchrow($result) ) {
  $cid = ( int )$row['cid'];
  $cat = stripslashes(check_html( $row['cat'], 'nohtml' ));
  $cdesc = stripslashes(check_html( $row['cdesc'], 'nohtml' ));
  $sDesc = isset( $cdesc ) ? stripslashes(check_html($cdesc, 'nohtml')) : '';
  $cimg = stripslashes(check_html( $row['cimg'], 'nohtml' ));
  if ( $arrSnip_cfg['per_cat'] == 1 ) {
    $cnumrows = $db->sql_numrows( $db->sql_query('SELECT * FROM ' . $prefix . '_dfw_code WHERE cid=\'' . $cid . '\'') );
    $cnumm = ' (' . (int) $cnumrows . ')';
  } else {
    $cnumm = '';
  }
  echo '<tr style="background-color: ' . $bgcolor2 . ';text-align: center;">';
  echo '<td><img src="modules/' . $module_name . '/images/categories/' . $cimg . '" alt="" /></td>';
  echo '<td><a href="modules.php?name=' . $module_name . '&amp;op=pubViewCat&amp;cid=' . $cid . '"><b>' . $cat . '</b></a>' . $cnumm . '</td><td>' . $sDesc . '</td></tr>';
}
echo '</table>';
CloseTable();
fSnipAPanel();
include_once ( 'footer.php' );

?>