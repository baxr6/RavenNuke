<?php

if ( !defined('ADMIN_FILE') ) {
	die('Access Denied');
}

global $currentlang, $language;
$module_name = 'Snippets';

if ( file_exists(NUKE_MODULES_DIR . $module_name. '/admin/language/lang-' . $currentlang . '.php') ) {
    include_once ( NUKE_MODULES_DIR . $module_name. '/admin/language/lang-' . $currentlang . '.php' );
} elseif ( file_exists(NUKE_MODULES_DIR . $module_name. '/admin/language/lang-' . $language . '.php') ) {
    include_once ( NUKE_MODULES_DIR . $module_name. '/admin/language/lang-' . $language . '.php' );
} else {
    include_once ( NUKE_MODULES_DIR . $module_name. '/admin/language/lang-english.php' );
}

switch ( $op ) {
   case 'snippets':
   case 'about_snippets':
   case 'snippet_conf':
   case 'snippet_conf_save':
   case 'snippet_add':
   case 'snippet_list':
   case 'snippet_edit':
   case 'snippet_edit_save':
   case 'snippet_save':
   case 'snippet_del':
   case 'snippet_del_cat':
   case 'snippet_cat':
   case 'snippet_edit_cat':
   case 'snippet_edit_cat_save':
   case 'snippet_cat_save':
   case 'snippet_style':
   case 'snippet_style_save':
  case 'snippet_comment_del':
      include_once 'modules/'.$module_name.'/admin/index.php';
      break;
}

?>
