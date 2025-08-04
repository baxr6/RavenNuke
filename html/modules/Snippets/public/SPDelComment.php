<?php

if ( !defined('SNIP_PUBLIC') ) {
  die( "Illegal Access Detected!!!" );
}
  global $db, $prefix, $admin_file;
    include_once ( 'header.php' );

    //snippet_menu();
    OpenTable();
	$comment_id = ( int )$_GET['comment_id'];
    
    echo '<center><font class="title"><b>' . _SNIP_REMOVE_COMMENT . '</b></font></center>';
    CloseTable();
    OpenTable();
	if ($db->sql_query( 'DELETE FROM ' . $prefix . '_dfw_comments WHERE id=\'' . $comment_id . '\' LIMIT 1' )) {
    echo '<br /><center>';
    echo ''._SNIP_REMOVED_SUCCESS.'</center><br />';
	} else {
	echo '<br /><center>';
    echo ''._SNIP_REMOVED_FAILED.'</center><br />';
	}
    CloseTable();
    include_once ( 'footer.php' );


?>