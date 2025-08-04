<?php

if (!defined('MODULE_FILE')) {
  die('You can\'t access this file directly...');
}
require_once ('mainfile.php');

$module_name = basename(dirname(__file__));
get_lang($module_name);
//define( 'RN_MODULE_CSS', 'snippets.css' );
define('SNIP_PUBLIC', true);

global $prefix, $db, $module_name, $name, $admin_file, $arrSnip_cfg, $bgcolor2;
include_once ('./modules/' . $module_name . '/includes/functions.php');

if ($arrSnip_cfg['right_blocks'] == 1) {
  $index = 1; //Here for compatibility with patches below 3.1
  define('INDEX_FILE', true); //Here for a nuke patched 3.1+
} else {
  $index = 0;
}

if (!isset($order)) {
  $orderby = 'title ASC';
}

if (!isset($op)) {
  $op = 'pubMain';
}
switch ($op) {
  case 'pubMain':
    include_once ('modules/' . $module_name . '/public/SPIndex.php');
    break;
  case 'browse_tags':
    include_once ('modules/' . $module_name . '/public/SPBrowseTags.php');
    break;
  case 'browse_tag':
    $order = isset($order) ? $order : '';
    include_once ('modules/' . $module_name . '/public/SPViewTags.php');
    break;
  case 'pubShow':
    include_once ('modules/' . $module_name . '/public/SPShow.php');
    break;
  case 'pubSnippets':
    pubSnippets();
    break;
  case 'pubViewCat':
    include_once ('modules/' . $module_name . '/public/SPCategories.php');
    break;
  case 'jBreadCrumb':
    jBreadCrumb();
    break;
  case 'pubComments':
    pubComments();
    break;
  case 'SPAddComment':
    include_once ('modules/' . $module_name . '/public/SPAddComment.php');
    break;
  case 'SPDelComment':
    include_once ('modules/' . $module_name . '/public/SPDelComment.php');
    break;
  case 'SPCallBack':
    include_once ('modules/' . $module_name . '/public/SPCallBack.php');
    break;

  default: // either "all" case
    include_once ('modules/' . $module_name . '/public/SPIndex.php');
    break;
}
die();

?>