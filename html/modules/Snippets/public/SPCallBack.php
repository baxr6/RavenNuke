<?php

if ( !defined('SNIP_PUBLIC') ) {
  die( "Illegal Access Detected!!!" );
}

$id = ( int )$_GET['id'];

$query = $db->sql_query( "SELECT id, name, comment FROM " . $prefix . "_dfw_comments WHERE code_id='$id'" );
$numrows = $db->sql_numrows($query);

if ($numrows > 0) {
for ( $x = 0;  $x < $numrows; $x++ ) {
  $row = $db->sql_fetchrow( $query );
  $comment_id = (int) $row["id"];
  $name = stripslashes(check_html($row["name"], 'nohtml'));
  $comms = stripslashes(check_html($row["comment"], 'nohtml'));
  $comments[$x] = array( "id" => "$comment_id", "name" => "$name", "comment" => "$comms" );
}

//echo JSON to page
$response = json_encode( $comments );
echo $response;
}
?>