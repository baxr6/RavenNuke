<?php

if ( !defined('SNIP_PUBLIC') ) {
  die( "Illegal Access Detected!!!" );
}

$name = check_html( $_POST["author"], 'nohtml' );
$comment = check_html( $_POST["comment"], 'nohtml' );
$code_id = ( int )$_POST['id'];
//add new comment to database
if ( !empty($name) && !empty($comment) && !empty($code_id) ) {
  $db->sql_query( "INSERT INTO " . $prefix . "_dfw_comments VALUES(NULL, '$code_id', 'now()', '$name','$comment')" );
}

?>