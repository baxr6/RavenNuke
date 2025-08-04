<?php

if ( !defined('SNIP_PUBLIC') ) {
  die( "Illegal Access Detected!!!" );
}

global $bgcolor4, $multilingual;
for ( $i = 0; $i <= 6; $i++ ) {
  $selected[$i] = '';
}
if ( !empty($order) ) {
  if ( $order == '1' ) {
    $orderby = 'date DESC';
    $selected[1] = 'selected="selected"';
  }
  if ( $order == '2' ) {
    $orderby = 'date ASC';
    $selected[2] = 'selected="selected"';
  }
  if ( $order == '3' ) {
    $orderby = 'title ASC';
    $selected[3] = 'selected="selected"';
  }
  if ( $order == '4' ) {
    $orderby = 'title DESC';
    $selected[4] = 'selected="selected"';
  }
  if ( $order == '5' ) {
    $orderby = 'counter DESC';
    $selected[5] = 'selected="selected"';
  }
  if ( $order == '6' ) {
    $orderby = 'counter ASC';
    $selected[6] = 'selected="selected"';
  }
} else {
  $orderby = 'title ASC';
}
include ( 'header.php' );
pubMenu();
jBreadCrumb();
OpenTable();
echo '<h2 style="text-align: center;">' . $tag . '</h2>' . "\n";
echo '<script type="text/javascript" language="javascript">' . "\n";
echo '	function cp_GoTo(url){location.href = url;}' . "\n";
echo '</script>' . "\n";
echo '<table width="100%" align="center" cellpadding="4" cellspacing="1" border="0">' . "\n";
echo '	<tr>' . "\n";
echo '		<td width="80%" align="right" colspan="2"><b>' . _SNIP_SORTBY . '</b>' . "\n";
echo '			<form action="" style="display: inline;"><select onchange="cp_GoTo(this.value)">' . "\n";
echo '				<option value="#" >' . _SNIP_SELECT . '</option>' . "\n";
echo '				<option value="modules.php?name=' . $module_name . '&amp;op=BrowseTag&amp;tag=' . $tag . '&amp;order=1" ' . $selected[1] . '>' . _SNIP_DATEDESC . '</option>' . "\n";
echo '				<option value="modules.php?name=' . $module_name . '&amp;op=BrowseTag&amp;tag=' . $tag . '&amp;order=2" ' . $selected[2] . '>' . _SNIP_DATEASC . '</option>' . "\n";
echo '				<option value="modules.php?name=' . $module_name . '&amp;op=BrowseTag&amp;tag=' . $tag . '&amp;order=3" ' . $selected[3] . '>' . _SNIP_TITLEASC . '</option>' . "\n";
echo '				<option value="modules.php?name=' . $module_name . '&amp;op=BrowseTag&amp;tag=' . $tag . '&amp;order=4" ' . $selected[4] . '>' . _SNIP_TITLEDESC . '</option>' . "\n";
echo '				<option value="modules.php?name=' . $module_name . '&amp;op=BrowseTag&amp;tag=' . $tag . '&amp;order=5" ' . $selected[5] . '>' . _SNIP_COUNTERDESC . '</option>' . "\n";
echo '				<option value="modules.php?name=' . $module_name . '&amp;op=BrowseTag&amp;tag=' . $tag . '&amp;order=6" ' . $selected[6] . '>' . _SNIP_COUNTERASC . '</option>' . "\n";
echo '			</select></form>' . "\n";
echo '		</td>' . "\n";
echo '	</tr>' . "\n";
$result = $db->sql_query( 'SELECT * FROM ' . $prefix . '_dfw_code WHERE (tags like \'%' . $tag . '%\') ORDER BY ' . $orderby . '' );
while ( $row = $db->sql_fetchrow($result) ) {
  $id = ( int )$row['id'];
  $title = stripslashes( check_html($row['title'], 'nohtml') );
  echo '<tr bgcolor="' . $bgcolor4 . '">' . "\n";
  echo '<td width="85%">' . "\n";
  echo '<a href="modules.php?name=' . $module_name . '&amp;op=pubShow&amp;id=' . $id . '">' . $title . '</a> ' . "\n";
  echo '</td>' . "\n";
  echo '</tr>' . "\n";
}
echo '</table>' . "\n";
CloseTable();
include ( 'footer.php' );

?>