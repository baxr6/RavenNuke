<?php
/************************************************************************/
/* nukeFEED
/* http://www.nukeSEO.com
/* Copyright � 2007 by Kevin Guske
/************************************************************************/
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

global $admin_file;
if(!isset($admin_file)) { $admin_file = 'admin'; }
if(!defined('ADMIN_FILE')) {
    Header('Location: ../../../'.$admin_file.'.php');
    die();
}
  # Important for security
  if (empty($fid)) $fid = 0;
  if (empty($cFLID)) $cFLID = 0;
  if (empty($cFHowMany)) $cFHowMany = 0;
  if (empty($cFContent)) $cFContent = '';
  if (empty($contentName)) $contentName = $cFContent;
  if (empty($cFTitle)) $cFTitle = '';
  if (empty($cFDesc)) $cFDesc = '';
  if (empty($subItems)) $subItems = '';
  if (empty($subItems2)) $subItems2 = '';
  if (empty($fBAddress)) $fBAddress = '';
  $error = '';
  $fid = intval($fid);
  $cFLID = intval($cFLID);
  $cFHowMany = intval($cFHowMany);
  # Get configuration
  $seo_config = seoGetConfigs('Feeds');
  # Save feed?
  if ($op == 'nfSaveFeed') {
    if ($cFTitle == '') $error .= _nF_TITLEREQUIRED.'<br />';
    if ($cFContent == '') $error .= _nF_CONTENTREQUIRED.'<br />';
    if ($subItems == '') $error .= _nF_ORDERREQUIRED.'<br />';
    if (intval($cFHowMany) == 0) $error .= _nF_HOWMANYREQUIRED.'<br />';
    if ($subItems2 == '') $error .= _nF_LEVELREQUIRED.'<br />';
    if ($subItems2 != 'module' and $subItems2 != '' and $cFLID == 0) $error .= _nF_LIDREQUIRED.'<br />';
    if ($error == '') {
      $cFContent  = seoCleanString($cFContent);
      $contentName= seoCleanString($contentName);
      $cFTitle    = seoCleanString($cFTitle);
      $cFDesc     = seoCleanString($cFDesc);
      $subItems   = seoCleanString($subItems);
      $subItems2  = seoCleanString($subItems2);
      $fBAddress    = seoCleanString($fBAddress);
      if ($fid > 0) 
      {
        $sql = 'UPDATE `'.$prefix.'_seo_feed` SET `content` = "'.$cFContent.'", `name` = "'.$contentName.'", `level` = "'.$subItems2.'", `lid` = "'.$cFLID.'", `title` = "'.$cFTitle.'", `desc` = "'.$cFDesc.'", `order` = "'.$subItems.'", `howmany` = '.intval($cFHowMany).', `active` = '.intval($cFactive).', `feedburner_address` = "'.$fBAddress.'" WHERE fid = '.$fid.';';
      }
      else
      {
        $sql = 'INSERT INTO `'.$prefix.'_seo_feed` (`content`, `name`, `level`, `lid`, `title`, `desc`, `order`, `howmany`, `active`, `feedburner_address`) VALUES("'.$cFContent.'", "'.$contentName.'", "'.$subItems2.'", "'.$cFLID.'", "'.$cFTitle.'", "'.$cFDesc.'", "'.$subItems.'",'.intval($cFHowMany).','.intval($cFactive).', "'.$fBAddress.'");';
      }
      $res = $db->sql_query($sql);
      header("Location: ".$admin_file.".php?op=nukeFEED");
      die();
    }
  }
  # Delete feed?
  if ($op == 'nfDeleteFeed' and $fid >0) {
    $res = $db->sql_query('DELETE FROM `'.$prefix.'_seo_feed` where fid = "'.$fid.'";');
    header("Location: ".$admin_file.".php?op=nukeFEED");
    die();
  }
  $cFHMHTML = '';
  $inactsel = '';
if ($op == 'nfEditFeed' && $fid > 0) {
    // FIXED: Use prepared statement to prevent SQL injection
    $sql = 'SELECT * FROM `' . $prefix . '_seo_feed` WHERE fid = ?';
    
    // Assuming you have a prepared statement method, use it:
    if (method_exists($db, 'prepare')) {
        $stmt = $db->prepare($sql);
        $stmt->bind_param('i', $fid);
        $stmt->execute();
        $result = $stmt->get_result();
        $feed = $result->fetch_assoc();
    } else {
        // Fallback: At minimum, cast to integer to prevent injection
        $fid = (int)$fid;
        $sql = 'SELECT * FROM `' . $prefix . '_seo_feed` WHERE fid = ' . $fid;
        $result = $db->sql_query($sql);
        $feed = $db->sql_fetchrow($result);
    }
    
    if ($feed) {
        // FIXED: Use null coalescing operator and proper sanitization
        $cFTitle = htmlspecialchars($feed['title'] ?? '', ENT_QUOTES, 'UTF-8');
        $cFContent = htmlspecialchars($feed['content'] ?? '', ENT_QUOTES, 'UTF-8');
        $contentName = htmlspecialchars($feed['name'] ?? '', ENT_QUOTES, 'UTF-8');
        $subItems = htmlspecialchars($feed['order'] ?? '', ENT_QUOTES, 'UTF-8');
        $cFHowMany = htmlspecialchars($feed['howmany'] ?? '', ENT_QUOTES, 'UTF-8');
        $subItems2 = htmlspecialchars($feed['level'] ?? '', ENT_QUOTES, 'UTF-8');
        $cFLID = (int)($feed['lid'] ?? 0);
        $cFDesc = htmlspecialchars($feed['desc'] ?? '', ENT_QUOTES, 'UTF-8');
        $cFactive = (int)($feed['active'] ?? 1);
        $fBAddress = htmlspecialchars($feed['feedburner_address'] ?? '', ENT_QUOTES, 'UTF-8');
        
        // Create HTML option safely
        $cFHMHTML = '<option value="' . $cFHowMany . '" selected="selected">' . $cFHowMany . '</option>';
        
        // Set inactive selection
        $inactsel = !$cFactive ? 'selected="selected"' : '';
    } else {
        // Handle case where feed is not found
        error_log("Feed with ID {$fid} not found");
        // You might want to redirect or show an error message here
    }
} else {
    // REMOVED: Deprecated magic_quotes_gpc handling (removed in PHP 5.4.0)
    // Instead, properly sanitize input data when processing form submissions
    
    // If this is handling form data, sanitize it properly:
    if ($_POST) {
        $cFContent = isset($_POST['cFContent']) ? htmlspecialchars(trim($_POST['cFContent']), ENT_QUOTES, 'UTF-8') : '';
        $contentName = isset($_POST['contentName']) ? htmlspecialchars(trim($_POST['contentName']), ENT_QUOTES, 'UTF-8') : '';
        $cFTitle = isset($_POST['cFTitle']) ? htmlspecialchars(trim($_POST['cFTitle']), ENT_QUOTES, 'UTF-8') : '';
        $cFDesc = isset($_POST['cFDesc']) ? htmlspecialchars(trim($_POST['cFDesc']), ENT_QUOTES, 'UTF-8') : '';
        $subItems = isset($_POST['subItems']) ? htmlspecialchars(trim($_POST['subItems']), ENT_QUOTES, 'UTF-8') : '';
        $subItems2 = isset($_POST['subItems2']) ? htmlspecialchars(trim($_POST['subItems2']), ENT_QUOTES, 'UTF-8') : '';
        $fBAddress = isset($_POST['fBAddress']) ? htmlspecialchars(trim($_POST['fBAddress']), ENT_QUOTES, 'UTF-8') : '';
    }
}

// Additional validation functions you might want to add:

/**
 * Validate feed ID
 */
function validateFeedId($fid) {
    return is_numeric($fid) && $fid > 0 ? (int)$fid : false;
}

/**
 * Sanitize text input
 */
function sanitizeTextInput($input, $maxLength = 255) {
    $input = trim($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    return strlen($input) > $maxLength ? substr($input, 0, $maxLength) : $input;
}

/**
 * Validate URL
 */
function validateUrl($url) {
    return filter_var($url, FILTER_VALIDATE_URL) !== false;
}
  if ($fid > 0)
  {
    $addedit = _nF_EDIT;
    $addedit2= '<a href="'.$admin_file.'.php?op=nukeFEED">'._nF_ADD.'</a>';
  }
  else 
  {
    $addedit = _nF_ADD;
    $addedit2='';
  }
  listFeeds();

  include_once('includes/nukeSEO/forms/CLinkedSelect.php');
  $values = seoGetContentTypes('Select','Not Available');
  $linkedselect = new CLinkedSelect();
  $linkedselect->formName = 'addFeed';
  $linkedselect->primaryFieldName = 'cFContent';
  $linkedselect->secondaryFieldName = 'subItems';
  $linkedselect->secondaryFieldValue = $subItems;
  $linkedselect->thirdFieldName = 'subItems2';
  $linkedselect->thirdFieldValue = $subItems2;
  $linkedselect->fieldValues = $values;
  
  if ($error > '') 
  {
    echo '<h2 align="center">'.$error.'</h2><br />';
  }

  echo '  
  <script type="text/javascript" src="includes/nukeSEO/forms/dhtmlxCombo/js/dhtmlXCommon.js"></script>
  <script type="text/javascript" src="includes/nukeSEO/forms/dhtmlxCombo/js/dhtmlXCombo.js"></script>
  <script type="text/javascript">dhx_globalImgPath="includes/nukeSEO/forms/dhtmlxCombo/imgs/";</script>
  <form name="addFeed" action="'.$admin_file.'.php?op=nfSaveFeed" method="post">
    <table>
    <tr><td><strong>'.$addedit.'</strong></td><td style="text-align: right;">'.$addedit2.'</td></tr>
    <tr>
    <td>'.seoHelp('_nF_TITLE').' '._nF_TITLE.'</td>
    <td><input maxlength="50" size="30" name="cFTitle" type="text" value="'.$cFTitle.'" /></td>
    </tr>
    <tr>
    <td>'.seoHelp('_nF_CONTENT').' '._nF_CONTENT.'</td><td>'.
    $linkedselect->get_function_js ().
    $linkedselect->get_primary_field ().'
    </td>
    <td>'.seoHelp('_nF_CONTENTNAME').' '._nF_CONTENTNAME.'</td><td>
    <input maxlength="20" size="20" name="contentName" type="text" value="'.$contentName.'" />
    </td>
    </tr>
    <tr>
    <td>'.seoHelp('_nF_ORDER').' '._nF_ORDER.'</td> 
    <td>'.$linkedselect->get_secondary_field ('', '', 'Not Available').'
    </td>
    <td>'.seoHelp('_nF_HOWMANY').' '._nF_HOWMANY.'</td>
    <td><select style="width:50px;" id="combo_zone1" name="cFHowMany">
    '.$cFHMHTML.'
    <option value="1">1</option>
    <option value="3">3</option>
    <option value="5">5</option>
    <option value="10">10</option>
    <option value="15">15</option>
    <option value="20">20</option>
    </select>
    <script type="text/javascript">var z=dhtmlXComboFromSelect("combo_zone1");</script>
    </td>
    </tr>
    <tr>
    <td>'.seoHelp('_nF_LEVEL').' '._nF_LEVEL.'</td>
    <td>'.$linkedselect->get_third_field ('', '', 'Not Available').'
    </td>
    <td>'.seoHelp('_nF_LID').' '._nF_LID.'</td>
    <td><input maxlength="6" size="5" name="cFLID" type="text" value="'.$cFLID.'" /></td>
    </tr>
    <tr>
    <td valign="top">'.seoHelp('_nF_DESC').' '._nF_DESC.'</td>
    <td colspan="3"><textarea rows="4" cols="60" name="cFDesc">'.$cFDesc.'</textarea></td>
    </tr>
    <tr>
    <td>'.seoHelp('_nF_STATUS').' '._nF_STATUS.'</td>
    <td><select name="cFactive"><option value="1">'._nF_ACTIVE.'</option><option value="0" '.$inactsel.'>'._nF_INACTIVE.'</option></select></td>
    </tr>
    <tr>
    <td>'.seoHelp('_nF_FEEDBURNER_FEED_ADDRESS').' <img src="images/nukeFEED/icon_status_'.(($seo_config['use_fb']) ? 'green':'red').'.gif" alt="'.(($seo_config['use_fb']) ? _nF_ACTIVE:_nF_INACTIVE).'" title="'.(($seo_config['use_fb']) ? _nF_ACTIVE:_nF_INACTIVE).'" />&nbsp;'._nF_FEEDBURNER_FEED_ADDRESS.'</td>
    <td colspan="3">'.((empty($seo_config['feedburner_url'])) ? 'http://feeds.feedburner.com':$seo_config['feedburner_url']).'/<input maxlength="100" size="30" name="fBAddress" type="text" value="'.$fBAddress.'" style="background: #ffffff url(images/nukeFEED/feedburner.gif) no-repeat 4px 50%; padding:2px 2px 2px 28px; border:1px solid;" /></td>
    </tr>
    </table><input type="hidden" name="fid" value="'.$fid.'" />
  <input type="submit" value="'._nF_SAVE.'" />
  </form>  
  ';
?>