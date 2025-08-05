<?php

if (!defined('ADMIN_FILE')) {
  die('Access Denied');
}
global $prefix, $db, $admin_file, $currentlang, $language;
$module_name = 'Snippets';

if (file_exists(NUKE_MODULES_DIR . $module_name . '/admin/language/lang-' . $currentlang . '.php')) {
  include_once (NUKE_MODULES_DIR . $module_name . '/admin/language/lang-' . $currentlang . '.php');
} elseif (file_exists(NUKE_MODULES_DIR . $module_name . '/admin/language/lang-' . $language . '.php')) {
  include_once (NUKE_MODULES_DIR . $module_name . '/admin/language/lang-' . $language . '.php');
} else {
  include_once (NUKE_MODULES_DIR . $module_name . '/admin/language/lang-english.php');
}

// Remove the old tabs class include - we'll use jQuery UI instead
// include_once ('./modules/' . $module_name . '/includes/class.jtabs.php');
require_once ('./modules/' . $module_name . '/includes/functions.php');

if ($arrSnip_cfg['right_blocks'] == 1) {
  $index = 1; //Here for compatibility with patches below 3.1
  define('INDEX_FILE', true); //Here for a nuke patched 3.1+
} else {
  $index = 0;
}

$aid = substr("$aid", 0, 25);
$is_AuthenticatedUser = 0;
$sql = "SELECT `name`, `radminsuper` FROM `" . $prefix . "_authors` WHERE `aid`='$aid'";
$result = $db->sql_query($sql);
$row = $db->sql_fetchrow($result);
if ($row['radminsuper'] == 1) {
  $is_AuthenticatedUser = 1;
} else { //Ok, do not have a super admin, so need to check for module admin
  $sql = "SELECT `title`, `admins` FROM `" . $prefix . "_modules` WHERE `title`='$module_name'";
  $result1 = $db->sql_query($sql);
  $row1 = $db->sql_fetchrow($result1);
  $pt_isAdmin = explode(",", $row1['admins']);
  $sAdmin = sizeof($pt_isAdmin);
  for ($i = 0; $i < $sAdmin; $i++) {
    if ($row['name'] == "$pt_isAdmin[$i]" and $row1['admins'] != "") {
      $is_AuthenticatedUser = 1;
    }
  } //End FOR
} //End IF for check of superadmin

if ($is_AuthenticatedUser == 1) {
  switch ($op) {
    case 'snippets':
      snippets();
      break;
    case 'about_snippets':
      about_snippets();
      break;
    case 'snippet_conf':
      snippet_conf();
      break;
    case 'snippet_conf_save':
      snippet_conf_save();
      break;
    case 'snippet_add':
      snippet_add();
      break;
    case 'snippet_list':
      snippet_list();
      break;
    case 'snippet_save':
      snippet_save($id, $title, $code, $desc, $tags = null);
      break;
    case 'snippet_del':
      snippet_del($id, $ok);
      break;
    case 'snippet_edit':
      snippet_edit($id);
      break;
    case 'snippet_edit_save':
      snippet_edit_save($id, $title, $code, $desc, $tags, $lang, $cid);
      break;
    case 'snippet_cat':
      snippet_cat();
      break;
    case 'snippet_del_cat':
      snippet_del_cat($cid, $ok);
      break;
    case 'snippet_edit_cat':
      snippet_edit_cat($cid, $cat, $cdesc, $cimg);
      break;
    case 'snippet_edit_cat_save':
      snippet_edit_cat_save($cid, $cat, $cdesc, $cimg);
      break;
    case 'snippet_cat_save':
      snippet_cat_save($cat, $cdesc, $cimg);
      break;
    case 'snippet_style':
      snippet_style();
      break;
    case 'snippet_style_save':
      snippet_style_save();
      break;
    case 'snippet_comment_del':
      snippet_comment_del($id);
      break;
  }
} else { // not authorized for admin access
  include_once ('header.php');
  GraphicAdmin();
  OpenTable();
  echo '<center><b>' . _ADMIN_DENIED . '</b></center>';
  CloseTable();
  include_once ('footer.php');
}

/**************************************************/
/* START - Functions                              */
/**************************************************/

function snippet_menu() {
  global $db, $prefix, $admin_file, $arrSnip_cfg, $bgcolor1, $bgcolor2, $bgcolor3, $bgcolor4;
  
  // Include jQuery UI CSS and JS
  echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.14.0/themes/ui-lightness/jquery-ui.min.css">' . "\n";
  echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.14.0/jquery-ui.min.js"></script>' . "\n";
  
  OpenTable();
  echo '<div align="center">' . "\n";
  echo '<h4>' . _SNIPPETS . '&nbsp;-&nbsp;' . _SNIP_VER . ':&nbsp;' . $arrSnip_cfg['version'] . '</h4><br />';
  echo '<a href="' . $admin_file . '.php">' . _SNIP_MAINADMIN . '</a><br />' . "\n";
  echo '<a href="' . $admin_file . '.php?op=snippets">' . _SNIP_ADMIN . '</a><br /><br />' . "\n";
  echo '</div>' . "\n";
  CloseTable();
  
  OpenTable();
  
  // Custom CSS for better RavenNuke theme integration
  echo '<style>
    .snippets-tabs {
      margin: 10px 0;
    }
    .snippets-tabs .ui-tabs-nav {
      background: ' . $bgcolor2 . ' !important;
      border: 1px solid #ccc;
      border-radius: 5px 5px 0 0;
      padding: 0 !important;
    }
    .snippets-tabs .ui-tabs-nav li {
      background: ' . $bgcolor3 . ' !important;
      border: 1px solid #ccc !important;
      margin: 2px 2px 0 0 !important;
    }
    .snippets-tabs .ui-tabs-nav li.ui-tabs-active {
      background: ' . $bgcolor1 . ' !important;
      border-bottom: 1px solid ' . $bgcolor1 . ' !important;
    }
    .snippets-tabs .ui-tabs-nav li a {
      color: #333 !important;
      font-weight: bold !important;
      padding: 8px 15px !important;
      text-decoration: none !important;
    }
    .snippets-tabs .ui-tabs-nav li.ui-tabs-active a {
      color: #000 !important;
    }
    .snippets-tabs .ui-tabs-panel {
      background: ' . $bgcolor1 . ' !important;
      border: 1px solid #ccc;
      border-top: none;
      border-radius: 0 0 5px 5px;
      padding: 15px !important;
      min-height: 400px;
    }
    .snippets-tabs .ui-widget {
      font-family: inherit !important;
      font-size: inherit !important;
    }
    .snippets-tabs .ui-widget-content {
      color: inherit !important;
    }
  </style>' . "\n";
  
  // Start the jQuery UI tabs structure
  echo '<div id="snippets-tabs" class="snippets-tabs">' . "\n";
  echo '<ul>' . "\n";
  echo '<li><a href="#tab-about">' . _SNIP_ABOUTSNIP . '</a></li>' . "\n";
  echo '<li><a href="#tab-add">' . _SNIP_ADDSNIP . '</a></li>' . "\n";
  echo '<li><a href="#tab-list">' . _SNIP_LISTSNIPPETS . '</a></li>' . "\n";
  echo '<li><a href="#tab-category">' . _SNIP_ADDMODCAT . '</a></li>' . "\n";
  echo '<li><a href="#tab-style">' . _SNIP_STYLE . '</a></li>' . "\n";
  echo '<li><a href="#tab-config">' . _SNIP_CONFIG . '</a></li>' . "\n";
  echo '</ul>' . "\n";
  
  // Tab content panels
  echo '<div id="tab-about">' . "\n";
  about_snippets();
  echo '</div>' . "\n";
  
  echo '<div id="tab-add">' . "\n";
  snippet_add();
  echo '</div>' . "\n";
  
  echo '<div id="tab-list">' . "\n";
  snippet_list();
  echo '</div>' . "\n";
  
  echo '<div id="tab-category">' . "\n";
  snippet_cat();
  echo '</div>' . "\n";
  
  echo '<div id="tab-style">' . "\n";
  snippet_style();
  echo '</div>' . "\n";
  
  echo '<div id="tab-config">' . "\n";
  snippet_conf();
  echo '</div>' . "\n";
  
  echo '</div>' . "\n"; // End tabs container
  
  // Initialize jQuery UI tabs
  echo '<script>
  $(document).ready(function() {
    $("#snippets-tabs").tabs({
      active: 0,
      heightStyle: "auto",
      show: { effect: "fadeIn", duration: 200 },
      hide: { effect: "fadeOut", duration: 150 },
      activate: function(event, ui) {
        // Update URL hash for direct linking
        var tabId = ui.newPanel.attr("id");
        if (history.replaceState) {
          history.replaceState(null, null, "#" + tabId);
        }
      },
      create: function(event, ui) {
        // Check for hash in URL to open specific tab
        var hash = window.location.hash;
        if (hash) {
          var tabIndex = -1;
          $("#snippets-tabs ul li a").each(function(index) {
            if ($(this).attr("href") === hash) {
              tabIndex = index;
              return false;
            }
          });
          if (tabIndex >= 0) {
            $("#snippets-tabs").tabs("option", "active", tabIndex);
          }
        }
      }
    });
    
    // Handle direct tab linking from other pages
    ' . snippets_handle_direct_links() . '
  });
  </script>' . "\n";
  
  CloseTable();
}

// Function to handle direct tab linking (maintains compatibility with existing links)
function snippets_handle_direct_links() {
  $hash_mapping = '
    // Map old hash patterns to new tab indices
    var hashMap = {
      "#content-snippets-AddModifyCategory": 3,
      "#content-snippets-ListSnippets": 2,
      "#content-snippets-Configuration": 5,
      "#content-snippets-Style": 4
    };
    
    var currentHash = window.location.hash;
    if (hashMap[currentHash] !== undefined) {
      $("#snippets-tabs").tabs("option", "active", hashMap[currentHash]);
    }
  ';
  return $hash_mapping;
}

function about_snippets() {
  global $db, $prefix, $admin_file, $module_name, $bgcolor2;
  // Remove OpenTable/CloseTable since we're inside a tab panel now
?>
<hr />
   <center><h2>Snippets</h2></center>
   <hr />
<p>
   Welcome to Snippets, a code snippet gallery for <a href="http://www.ravenphpscripts.com" target="_blank">RavenNuke(tm)</a> Content Management System.
   Currently, Snippets has the following features:
</p>
   <ul>
      <li>jQuery expand and collapse feature when viewing snippets</li>
      <li>Administration area uses jQuery UI tabs for better user experience</li>
      <li>Configurable color styling for highlighting your code</li>
      <li>Pagination with configuration</li>
      <li>Breadcrumb navigation</li>
      <li>Tags functionality</li>
      <li>Show the number of snippets per category E.g. php Category (4)</li>
      <li>Graphic based Date badge</li>
      <li>User input is filtered and sanitized</li>
      <li>XHTML 1.0 Transitional compliant</li>
   </ul>
   <p>
   Snippets is a <strong>RavenNuke&trade;</strong> module, enhanced with modern jQuery UI tabs for better administration experience. 
   We would greatly appreciate any feedback and feature suggestions for future development.
   </p>
<p>A copy of the GNU General Public License (GPL) is in the root directory of the module archive (GPL.TXT). You may also find more information on the GPL at the <a href="http://www.gnu.org">GNU website</a>.</p>
<?php

  echo '<table border="0" cellpadding="0" cellspacing="0" align="center">' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td width="100%" align="center"><b>Help Support Snippets</b></td>' . "\n";
  echo '  </tr>' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td width="100%" align="center">' . "\n";
  echo '      <form action="https://www.paypal.com/cgi-bin/webscr" method="post">' . "\n";
  echo '        <input type="hidden" name="cmd" value="_s-xclick" />' . "\n";
  echo '        <input type="hidden" name="hosted_button_id" value="4626695" />' . "\n";
  echo '        <input type="image" src="https://www.paypal.com/en_AU/i/btn/btn_donateCC_LG.gif" name="submit" alt="PayPal - The safer, easier way to pay online." />' . "\n";
  echo '        <img alt="" border="0" src="https://www.paypal.com/en_AU/i/scr/pixel.gif" width="1" height="1" />' . "\n";
  echo '      </form></td>' . "\n";
  echo '  </tr>' . "\n";
  echo '</table>' . "\n";
}

function snippet_conf() {
  global $db, $prefix, $admin_file, $arrSnip_cfg, $bgcolor2;
  // Removed OpenTable/CloseTable - content is now inside tab panel
  echo "<form action=\"" . $admin_file . ".php\" method=\"post\">\n";
  echo "<table align=\"center\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\n";
  echo '<tr><td bgcolor="' . $bgcolor2 . '">' . _SNIP_PERCAT . '</td><td><select name="xper_cat">' . "\n";
  echo "<option value='0'";
  if ($arrSnip_cfg['per_cat'] == 0) {
    echo " selected=\"selected\"";
  }
  echo "> " . _NO . " </option>\n<option value='1'";
  if ($arrSnip_cfg['per_cat'] == 1) {
    echo " selected=\"selected\"";
  }
  echo "> " . _YES . " </option>\n";
  echo "</select></td></tr>\n";
  echo "<tr><td bgcolor='$bgcolor2'>" . _SNIP_SELEXP . "</td><td><select name='xselect_expand'>\n";
  echo "<option value='0'";
  if ($arrSnip_cfg['select_expand'] == 0) {
    echo " selected=\"selected\"";
  }
  echo "> " . _NO . " </option>\n<option value='1'";
  if ($arrSnip_cfg['select_expand'] == 1) {
    echo " selected=\"selected\"";
  }
  echo "> " . _YES . " </option>\n";
  echo "</select></td></tr>\n";
  echo "<tr><td bgcolor='$bgcolor2'>" . _SNIP_RIGHTBLOCKS . "</td><td><select name='xright_blocks'>\n";
  echo "<option value='0'";
  if ($arrSnip_cfg['right_blocks'] == 0) {
    echo " selected=\"selected\"";
  }
  echo "> " . _NO . " </option>\n<option value='1'";
  if ($arrSnip_cfg['right_blocks'] == 1) {
    echo " selected=\"selected\"";
  }
  echo "> " . _YES . " </option>\n";
  echo "</select></td></tr>\n";
  echo "<tr><td bgcolor='$bgcolor2'>" . _SNIP_PAGPERPAGE . "</td>";
  echo "<td><input type=\"text\" name=\"xper_page\" value=\"" . $arrSnip_cfg['per_page'] . "\" /></td></tr>\n";
  echo "<tr><td bgcolor='$bgcolor2'>" . _SNIP_WORDWRAP . "</td>";
  echo "<td><input type=\"text\" name=\"xword_wrap\" value=\"" . $arrSnip_cfg['word_wrap'] . "\" /></td></tr>\n";
  echo '<tr><td bgcolor="' . $bgcolor2 . '">' . _SNIP_ALLOWCOMMENTS . '</td><td><select name="xallow_comments">' . "\n";
  echo "<option value='0'";
  if ($arrSnip_cfg['allow_comments'] == 0) {
    echo " selected=\"selected\"";
  }
  echo "> " . _NO . " </option>\n<option value='1'";
  if ($arrSnip_cfg['allow_comments'] == 1) {
    echo " selected=\"selected\"";
  }
  echo "> " . _YES . " </option>\n";
  echo "</select>&nbsp;<strong>" . _SNIP_COMMENTS_REGONLY . "</strong></td></tr>\n";
  echo "<tr><td align='center' colspan='2'><input type='submit' value='" . _SAVECHANGES . "' /></td></tr>\n";
  echo "</table>\n";
  echo "<input type='hidden' name='op' value='snippet_conf_save' />\n";
  echo "</form>\n";
}

// Update the redirect functions to use the new tab hashes
function snippet_conf_save() {
  global $db, $prefix, $admin_file, $bgcolor2, $textcolor2;
  if (isset($_POST['xper_cat'])) {
    $per_cat = (int)$_POST['xper_cat'];
  }
  if (isset($_POST['xselect_expand'])) {
    $select_expand = (int)$_POST['xselect_expand'];
  }
  if (isset($_POST['xright_blocks'])) {
    $right_blocks = (int)$_POST['xright_blocks'];
  }
  if (isset($_POST['xper_page'])) {
    $per_page = (int)$_POST['xper_page'];
  } else {
    $per_page = (int)20;
  }
  if (isset($_POST['xword_wrap'])) {
    $word_wrap = (int)$_POST['xword_wrap'];
  } else {
    $word_wrap = (int)200;
  }
  if (isset($_POST['xallow_comments'])) {
    $allow_comments = (int)$_POST['xallow_comments'];
  } else {
    $allow_comments = (int)0;
  }
  fSnipCfgApply('per_cat', $per_cat);
  fSnipCfgApply('select_expand', $select_expand);
  fSnipCfgApply('right_blocks', $right_blocks);
  fSnipCfgApply('per_page', $per_page);
  fSnipCfgApply('word_wrap', $word_wrap);
  fSnipCfgApply('allow_comments', $allow_comments);
  Header('Location: ' . $admin_file . '.php?op=snippets#tab-config');
}

// [Rest of the functions would need similar modifications - removing OpenTable/CloseTable calls 
// and updating redirect locations to use the new tab hash format]

// Example of how other functions should be modified:
function snippet_list() {
  global $db, $prefix, $admin_file, $module_name, $bgcolor2;
  // Remove OpenTable/CloseTable calls since we're inside a tab panel
  echo '<table align="center" border="0" cellpadding="2" cellspacing="2">' . "\n";
  echo '<tr style="background-color: ' . $bgcolor2 . ';text-align: center;">' . "\n";
  echo '<td><strong>' . _SNIP_TITLE . '</strong></td>';
  echo '<td><strong>' . _SNIP_DESC . '</strong></td>';
  echo '<td><strong>' . _SNIP_TAGS . '</strong></td>';
  echo '<td><strong>' . _SNIP_CAT . '</strong></td>';
  echo '<td colspan="2"><strong>' . _SNIP_FUNC . '</strong></td>';
  echo '</tr>' . "\n";
  $sql = $db->sql_query('SELECT * FROM ' . $prefix . '_dfw_code ORDER BY title');
  while ($codelist = $db->sql_fetchrow($sql)) {
    $id = (int)$codelist['id'];
    $title = stripslashes(check_html($codelist['title'], 'nohtml'));
    $desc = stripslashes(check_html($codelist['desc'], 'nohtml'));
    $tags = stripslashes(check_html($codelist['tags'], 'nohtml'));
    $cid = (int)$codelist['cid'];
    $sql1 = $db->sql_query('SELECT cat FROM ' . $prefix . '_dfw_cat WHERE cid=\'' . $cid . '\' ORDER BY cat');
    $row = $db->sql_fetchrow($sql1);
    $cat = stripslashes(check_html($row['cat'], 'nohtml'));
    echo '<tr style="background-color: ' . $bgcolor2 . ';">';
    echo '<td>' . $title . '</td>';
    echo '<td>' . $desc . '</td>';
    echo '<td>' . $tags . '</td>';
    echo '<td align="center">' . $cat . '</td>';
    echo '<td align="center" width="5%"><a href="' . $admin_file . '.php?op=snippet_edit&amp;id=' . $id . '">';
    echo '<img src="modules/' . $module_name . '/images/Edit.png" width="18" height="18" alt="Edit Snippet" /></a></td>';
    echo '<td align="center" width="5%"><a href="' . $admin_file . '.php?op=snippet_del&amp;id=' . $id . '">';
    echo '<img src="modules/' . $module_name . '/images/Delete.png" width="18" height="18" alt="Delete Snippet" />';
    echo '</a></td></tr>';
  }
  echo '</table>';
}

function snippet_style() {
  global $db, $prefix, $admin_file, $arrSnip_cfg, $bgcolor2;
  // Removed OpenTable/CloseTable - content is now inside tab panel
  
  /* START PHP STYLING */
  echo '<fieldset style="border: 3px solid ' . $bgcolor2 . ';width: 80%;">' . "\n";
  echo '<legend><strong>' . _SNIP_PHPSTYLES . '</strong></legend>' . "\n";
  echo '<form method="post" action="' . $admin_file . '.php">' . "\n";
  echo '<table border="0" cellspacing="0" cellpadding="0">' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td style="width: 50%;">' . _SNIP_CONST1 . '</td>' . "\n";
  echo '    <td><input type="text" name="php_const1" value="' . $arrSnip_cfg['php_const1'] . '" />&nbsp;' . "\n";
  echo '<span style="background-color: #' . $arrSnip_cfg['php_const1'] . ';">&nbsp;&nbsp;&nbsp;</span></td>' . "\n";
  echo '  </tr>' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td>' . _SNIP_CONST2 . '</td>' . "\n";
  echo '    <td><input type="text" name="php_const2" value="' . $arrSnip_cfg['php_const2'] . '" />&nbsp;' . "\n";
  echo '<span style="background-color: #' . $arrSnip_cfg['php_const2'] . ';">&nbsp;&nbsp;&nbsp;</span></td>' . "\n";
  echo '  </tr>' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td>' . _SNIP_FUNC . '</td>' . "\n";
  echo '    <td><input type="text" name="php_func" value="' . $arrSnip_cfg['php_func'] . '" />&nbsp;' . "\n";
  echo '<span style="background-color: #' . $arrSnip_cfg['php_func'] . ';">&nbsp;&nbsp;&nbsp;</span></td>' . "\n";
  echo '  </tr>' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td>' . _SNIP_GLOBAL . '</td>' . "\n";
  echo '    <td><input type="text" name="php_global" value="' . $arrSnip_cfg['php_global'] . '" />&nbsp;' . "\n";
  echo '<span style="background-color: #' . $arrSnip_cfg['php_global'] . ';">&nbsp;&nbsp;&nbsp;</span></td>' . "\n";
  echo '  </tr>' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td>' . _SNIP_KEYWORD . '</td>' . "\n";
  echo '    <td><input type="text" name="php_keyword" value="' . $arrSnip_cfg['php_keyword'] . '" />&nbsp;' . "\n";
  echo '<span style="background-color: #' . $arrSnip_cfg['php_keyword'] . ';">&nbsp;&nbsp;&nbsp;</span></td>' . "\n";
  echo '  </tr>' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td>' . _SNIP_NAME . '</td>' . "\n";
  echo '    <td><input type="text" name="php_name" value="' . $arrSnip_cfg['php_name'] . '" />&nbsp;' . "\n";
  echo '<span style="background-color: #' . $arrSnip_cfg['php_name'] . ';">&nbsp;&nbsp;&nbsp;</span></td>' . "\n";
  echo '  </tr>' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td>' . _SNIP_NUMBER . '</td>' . "\n";
  echo '    <td><input type="text" name="php_number" value="' . $arrSnip_cfg['php_number'] . '" />&nbsp;' . "\n";
  echo '<span style="background-color: #' . $arrSnip_cfg['php_number'] . ';">&nbsp;&nbsp;&nbsp;</span></td>' . "\n";
  echo '  </tr>' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td>' . _SNIP_STRING1 . '</td>' . "\n";
  echo '    <td><input type="text" name="php_string1" value="' . $arrSnip_cfg['php_string1'] . '" />&nbsp;' . "\n";
  echo '<span style="background-color: #' . $arrSnip_cfg['php_string1'] . ';">&nbsp;&nbsp;&nbsp;</span></td>' . "\n";
  echo '  </tr>' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td>' . _SNIP_STRING2 . '</td>' . "\n";
  echo '    <td><input type="text" name="php_string2" value="' . $arrSnip_cfg['php_string2'] . '" />&nbsp;' . "\n";
  echo '<span style="background-color: #' . $arrSnip_cfg['php_string2'] . ';">&nbsp;&nbsp;&nbsp;</span></td>' . "\n";
  echo '  </tr>' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td>' . _SNIP_VALUE . '</td>' . "\n";
  echo '    <td><input type="text" name="php_value" value="' . $arrSnip_cfg['php_value'] . '" />&nbsp;' . "\n";
  echo '<span style="background-color: #' . $arrSnip_cfg['php_value'] . ';">&nbsp;&nbsp;&nbsp;</span></td>' . "\n";
  echo '  </tr>' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td>' . _SNIP_VARIABLE . '</td>' . "\n";
  echo '    <td><input type="text" name="php_variable" value="' . $arrSnip_cfg['php_variable'] . '" />&nbsp;' . "\n";
  echo '<span style="background-color: #' . $arrSnip_cfg['php_variable'] . ';">&nbsp;&nbsp;&nbsp;</span></td>' . "\n";
  echo '  </tr>' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td colspan="2"><input type="submit" name="submit" value="submit" /></td>' . "\n";
  echo '  </tr>' . "\n";
  echo '</table>' . "\n";
  echo '<input type="hidden" name="op" value="snippet_style_save" />' . "\n";
  echo '</form>' . "\n";
  echo '</fieldset><br />' . "\n";
  /* END PHP STYLING */
  
  /* START JS STYLING */
  echo '<fieldset style="border: 3px solid ' . $bgcolor2 . ';width: 80%;">' . "\n";
  echo '<legend><strong>' . _SNIP_JSSTYLES . '</strong></legend>' . "\n";
  echo '<form method="post" action="' . $admin_file . '.php">' . "\n";
  echo '<table border="0" cellspacing="0" cellpadding="0">' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td style="width: 50%;">' . _SNIP_MLCOM . '</td>' . "\n";
  echo '    <td><input type="text" name="js_mlcom" value="' . $arrSnip_cfg['js_mlcom'] . '" />&nbsp;' . "\n";
  echo '<span style="background-color: #' . $arrSnip_cfg['js_mlcom'] . ';">&nbsp;&nbsp;&nbsp;</span></td>' . "\n";
  echo '  </tr>' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td>' . _SNIP_COM . '</td>' . "\n";
  echo '    <td><input type="text" name="js_com" value="' . $arrSnip_cfg['js_com'] . '" />&nbsp;' . "\n";
  echo '<span style="background-color: #' . $arrSnip_cfg['js_com'] . ';">&nbsp;&nbsp;&nbsp;</span></td>' . "\n";
  echo '  </tr>' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td>' . _SNIP_REGEXP . '</td>' . "\n";
  echo '    <td><input type="text" name="js_regexp" value="' . $arrSnip_cfg['js_regexp'] . '" />&nbsp;' . "\n";
  echo '<span style="background-color: #' . $arrSnip_cfg['js_regexp'] . ';">&nbsp;&nbsp;&nbsp;</span></td>' . "\n";
  echo '  </tr>' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td>' . _SNIP_STRING . '</td>' . "\n";
  echo '    <td><input type="text" name="js_string" value="' . $arrSnip_cfg['js_string'] . '" />&nbsp;' . "\n";
  echo '<span style="background-color: #' . $arrSnip_cfg['js_string'] . ';">&nbsp;&nbsp;&nbsp;</span></td>' . "\n";
  echo '  </tr>' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td>' . _SNIP_KEYWORD . '</td>' . "\n";
  echo '    <td><input type="text" name="js_keywords" value="' . $arrSnip_cfg['js_keywords'] . '" />&nbsp;' . "\n";
  echo '<span style="background-color: #' . $arrSnip_cfg['js_keywords'] . ';">&nbsp;&nbsp;&nbsp;</span></td>' . "\n";
  echo '  </tr>' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td>' . _SNIP_GLOBAL . '</td>' . "\n";
  echo '    <td><input type="text" name="js_global" value="' . $arrSnip_cfg['js_global'] . '" />&nbsp;' . "\n";
  echo '<span style="background-color: #' . $arrSnip_cfg['js_global'] . ';">&nbsp;&nbsp;&nbsp;</span></td>' . "\n";
  echo '  </tr>' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td>' . _SNIP_NUMBER . '</td>' . "\n";
  echo '    <td><input type="text" name="js_numbers" value="' . $arrSnip_cfg['js_numbers'] . '" />&nbsp;' . "\n";
  echo '<span style="background-color: #' . $arrSnip_cfg['js_numbers'] . ';">&nbsp;&nbsp;&nbsp;</span></td>' . "\n";
  echo '  </tr>' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td colspan="2"><input type="submit" name="submit" value="submit" /></td>' . "\n";
  echo '  </tr>' . "\n";
  echo '</table>' . "\n";
  echo '<input type="hidden" name="op" value="snippet_style_save" />' . "\n";
  echo '</form>' . "\n";
  echo '</fieldset>' . "\n";
}

function snippet_add() {
  global $db, $prefix, $admin_file, $module_name;
  // Removed OpenTable/CloseTable - content is now inside tab panel
  
  echo '<form method="post" action="' . $admin_file . '.php">' . "\n";
  echo '<table width="80%" border="0" cellspacing="0" cellpadding="2">' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td>' . _SNIP_TITLE . ':</td>' . "\n";
  echo '    <td><input type="text" name="title" /></td>' . "\n";
  echo '  </tr>' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td>' . _SNIP_CAT . ':</td>' . "\n";
  echo '    <td>';
  echo '<select name="cat">';
  echo '<option>&nbsp;</option>';
  $sql = $db->sql_query('SELECT * FROM ' . $prefix . '_dfw_cat ORDER BY cat');
  while ($catlist = $db->sql_fetchrow($sql)) {
    $cid = (int)$catlist['cid'];
    $cat = stripslashes(check_html($catlist['cat'], 'nohtml'));
    echo '<option value="' . $cid . '">' . $cat . '</option>';
  }
  echo '</select>';
  echo '</td>' . "\n";
  echo '  </tr>' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td>' . _SNIP_CODELANG . ':</td>' . "\n";
  echo '    <td>';
  echo '<select name="lang">';
  echo '<option>&nbsp;</option>';
  echo '<option value="0">' . _SNIP_CSS . '</option>';
  echo '<option value="1">' . _SNIP_HTML . '</option>';
  echo '<option value="2">' . _SNIP_JS . '</option>';
  echo '<option value="3">' . _SNIP_MYSQL . '</option>';
  echo '<option value="4">' . _SNIP_PHP . '</option>';
  echo '</select>';
  echo '</td>' . "\n";
  echo '  </tr>' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td>' . _SNIP_CODE . ':</td>' . "\n";
  echo '    <td><textarea name="code" cols="45" rows="5"></textarea></td>' . "\n";
  echo '  </tr>' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td>' . _SNIP_DESC . ':</td>' . "\n";
  echo '    <td><textarea name="desc" cols="45" rows="5"></textarea></td>' . "\n";
  echo '  </tr>' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td>' . _SNIP_TAGS . ':</td>' . "\n";
  echo '    <td><input type="text" name="tags" /></td>' . "\n";
  echo '  </tr>' . "\n";
  echo '</table>' . "\n";
  echo '<input type="hidden" name="op" value="snippet_save" />' . "\n";
  echo '<input type="submit" name="submit" value="Submit" />' . "\n";
  echo '</form>' . "\n";
}

function snippet_cat() {
  global $db, $prefix, $admin_file, $module_name, $bgcolor2;
  // Removed OpenTable/CloseTable - content is now inside tab panel
  
  $imagelist = '';
  echo '<script type="text/javascript" language="javascript">' . "\n";
  echo '$(document).ready(function(){' . "\n";
  echo '                           ' . "\n";
  echo '  $("#catimg").bind(\'change\', function() {' . "\n";
  echo '         var update_pic = $(this).val();' . "\n";
  echo '         if (update_pic) {' . "\n";
  echo '             $(\'#NewPic\').attr(\'src\', \'modules/' . $module_name . '/images/categories/\' + update_pic + \'\');' . "\n";
  echo '         }' . "\n";
  echo '  });' . "\n";
  echo '});' . "\n";
  echo '</script>' . "\n";
  
  echo '<table width="90%" align="center" border="0" cellpadding="2" cellspacing="2">' . "\n";
  echo '<tr style="background-color: ' . $bgcolor2 . ';text-align: center;">' . "\n";
  echo '<td><strong>' . _SNIP_IMAGE . '</strong></td>';
  echo '<td><strong>' . _SNIP_TITLE . '</strong></td>';
  echo '<td><strong>' . _SNIP_DESC . '</strong></td>';
  echo '<td colspan="2"><strong>' . _SNIP_FUNC . '</strong></td>';
  echo '</tr>' . "\n";
  $sql = $db->sql_query('SELECT * FROM ' . $prefix . '_dfw_cat ORDER BY cat');
  while ($catlist = $db->sql_fetchrow($sql)) {
    $cid = (int)$catlist['cid'];
    $cat = stripslashes(check_html($catlist['cat'], 'nohtml'));
    $cdesc = stripslashes(check_html($catlist['cdesc'], 'nohtml'));
    $cimg = stripslashes(check_html($catlist['cimg'], 'nohtml'));
    echo '<tr style="background-color: ' . $bgcolor2 . ';">';
    echo '<td align="center"><img src="modules/' . $module_name . '/images/categories/' . $cimg . '" height="20" alt="' . $cimg . '" /></td>';
    echo '<td>' . $cat . '</td>';
    echo '<td>' . $cdesc . '</td>';
    echo '<td align="center" width="5%"><a href="' . $admin_file . '.php?op=snippet_edit_cat&amp;cid=' . $cid . '">';
    echo '<img src="modules/' . $module_name . '/images/Edit.png" width="18" height="18" alt="Edit Category" /></a></td>';
    echo '<td align="center" width="5%"><a href="' . $admin_file . '.php?op=snippet_del_cat&amp;cid=' . $cid . '">';
    echo '<img src="modules/' . $module_name . '/images/Delete.png" width="18" height="18" alt="Delete Category" />';
    echo '</a></td></tr>';
  }
  echo '</table><br />' . "\n";
  
  echo '<font class="content"><b>' . _ADDMAINCATEGORY . '</b></font>' . "\n";
  echo '<br /><br />' . "\n";
  echo '<form method="post" action="' . $admin_file . '.php">' . "\n";
  echo '<table width="75%" align="center" border="0" cellpadding="2" cellspacing="2">' . "\n";
  echo '<tr>' . "\n";
  echo '<td>' . _NAME . ':</td><td> <input type="text" name="cat" size="30" maxlength="100" /></td></tr>' . "\n";
  echo '<tr><td style="vertical-align: top;"> ' . _SNIP_SELCATIMG . ':</td><td><select id="catimg" name="cimg">' . "\n";
  $handle = opendir('modules/' . $module_name . '/images/categories');
  while (false !== ($file = readdir($handle))) {
    if (preg_match('/([0-9_a-z])*(?i).(gif|jpg|png)(?i)/', $file, $matches)) {
      $image = $file;
      $imagelist .= $image . ' ';
    }
  }
  closedir($handle);
  $imagelist = explode(' ', $imagelist);
  sort($imagelist);
  $s = sizeof($imagelist);
  for ($i = 0; $i < $s; $i++) {
    if ($imagelist[$i] != '') {
      echo '<option value="' . $imagelist[$i] . '" ';
      if ($imagelist[$i] == $cimg) {
        echo ' selected="selected"';
      }
      echo '>' . $imagelist[$i] . '</option>';
    }
  }
  echo '  </select>' . "\n";
  echo '<br /><br /><img id="NewPic" src="modules/' . $module_name . '/images/categories/blank.gif" alt="" /></td></tr>' . "\n";
  echo '<tr><td style="vertical-align: top;">' . _DESCRIPTION . ':</td><td><textarea name="cdesc" cols="60" rows="10"></textarea></td></tr>' . "\n";
  echo '<tr><td colspan="2"><input type="submit" value="' . _ADD . '" /></td></tr>' . "\n";
  echo '</table>' . "\n";
  echo '<input type="hidden" name="op" value="snippet_cat_save" />' . "\n";
  echo '</form>' . "\n";
}

function snippet_edit($id) {
  global $db, $prefix, $admin_file, $module_name, $arrLang;
  include_once ('header.php');
  $id = (int)$id;
  $sql = $db->sql_query('SELECT * FROM ' . $prefix . '_dfw_code WHERE id=\'' . $id . '\'');
  $editSnip = $db->sql_fetchrow($sql);
  $title = stripslashes(check_html($editSnip['title'], 'nohtml'));
  $code = stripslashes(check_html($editSnip['code'], 'nohtml'));
  $desc = stripslashes(check_html($editSnip['desc'], 'nohtml'));
  $tags = stripslashes(check_html($editSnip['tags'], 'nohtml'));
  $lang = (int)$editSnip['lang'];
  $cid = (int)$editSnip['cid'];
  
  OpenTable();
  echo '<form method="post" action="' . $admin_file . '.php">' . "\n";
  echo '<table width="80%" border="0" cellspacing="0" cellpadding="2">' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td>' . _SNIP_TITLE . ':</td>' . "\n";
  echo '    <td><input type="text" name="title" value="' . $title . '" /></td>' . "\n";
  echo '  </tr>' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td>' . _SNIP_CAT . ':</td>' . "\n";
  echo '    <td>';
  echo '<select name="cid">';
  echo '<option>&nbsp;</option>';
  $sql1 = $db->sql_query('SELECT * FROM ' . $prefix . '_dfw_cat');
  while ($catlist = $db->sql_fetchrow($sql1)) {
    $cid1 = (int)$catlist['cid'];
    $cat1 = stripslashes(check_html($catlist['cat'], 'nohtml'));
    echo '<option value="' . $cid1 . '"';
    if ($cid1 == $cid) {
      echo ' selected="selected"';
    }
    echo '>' . $cat1 . '</option>';
  }
  echo '</select>';
  echo '</td>' . "\n";
  echo '  </tr>' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td>' . _SNIP_CODELANG . ':</td>' . "\n";
  echo '    <td>';
  echo '<select name="lang">';
  echo '<option>&nbsp;</option>';

  foreach ($arrLang as $iLangkey => $sLangValue) {
    if ($iLangkey == $lang) {
      $sel = ' selected="selected"';
    } else {
      $sel = '';
    }
    echo '<option value="' . $iLangkey . '"' . $sel . '>' . $sLangValue . '</option>';
  }
  echo '</select>';
  echo '</td>' . "\n";
  echo '  </tr>' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td>' . _SNIP_CODE . ':</td>' . "\n";
  echo '    <td><textarea name="code" cols="45" rows="5">' . $code . '</textarea></td>' . "\n";
  echo '  </tr>' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td>' . _SNIP_DESC . ':</td>' . "\n";
  echo '    <td><textarea name="desc" cols="45" rows="5">' . $desc . '</textarea></td>' . "\n";
  echo '  </tr>' . "\n";
  echo '  <tr>' . "\n";
  echo '    <td>' . _SNIP_TAGS . ':</td>' . "\n";
  echo '    <td><input type="text" name="tags" value="' . $tags . '" /></td>' . "\n";
  echo '  </tr>' . "\n";
  echo '<tr><td colspan="2"><input type="submit" name="submit" value="Submit" /></td></tr>' . "\n";
  echo '</table>' . "\n";
  echo '<input type="hidden" name="id" value="' . $id . '" />' . "\n";
  echo '<input type="hidden" name="op" value="snippet_edit_save" />' . "\n";
  echo '</form>' . "\n";
  CloseTable();
  include_once ('footer.php');
}

function snippet_edit_cat($cid) {
  global $db, $prefix, $admin_file, $module_name;
  include_once ('header.php');
  echo '<script type="text/javascript" language="javascript">' . "\n";
  echo '$(document).ready(function(){' . "\n";
  echo '                           ' . "\n";
  echo '  $("#catimg").bind(\'change\', function() {' . "\n";
  echo '         var update_pic = $(this).val();' . "\n";
  echo '         if (update_pic) {' . "\n";
  echo '             $(\'#NewPic\').attr(\'src\', \'modules/' . $module_name . '/images/categories/\' + update_pic + \'\');' . "\n";
  echo '         }' . "\n";
  echo '  });' . "\n";
  echo '});' . "\n";
  echo '</script>' . "\n";
  OpenTable();
  $sql = $db->sql_query('SELECT * FROM ' . $prefix . '_dfw_cat WHERE cid=\'' . $cid . '\'');
  $row = $db->sql_fetchrow($sql);
  $cid = (int)$cid;
  $cat = stripslashes(check_html($row['cat'], 'nohtml'));
  $cdesc = stripslashes(check_html($row['cdesc'], 'nohtml'));
  $cimg = stripslashes(check_html($row['cimg'], 'nohtml'));
  echo '<font class="content"><b>' . _SNIP_UPDATECAT . '</b></font>' . "\n";
  echo '<br /><br />' . "\n";
  echo '<form method="post" action="' . $admin_file . '.php">' . "\n";
  echo '<table width="70%" border="0" cellspacing="0" cellpadding="2">' . "\n";
  echo '<tr><td>' . _NAME . ':</td><td><input type="text" name="cat" size="30" value="' . $cat . '" maxlength="100" /></td></tr>' . "\n";
  echo '<tr><td>' . _SNIP_SELCATIMG . '</td><td><select id="catimg" name="cimg">' . "\n";
  $handle = opendir('modules/' . $module_name . '/images/categories');
  while (false !== ($file = readdir($handle))) {
    if (preg_match('/([0-9_a-z])*(?i).(gif|jpg|png)(?i)/', $file, $matches)) {
      $image = $file;
      $imagelist .= $image . ' ';
    }
  }
  closedir($handle);
  $imagelist = explode(' ', $imagelist);
  sort($imagelist);
  $s = sizeof($imagelist);
  for ($i = 0; $i < $s; $i++) {
    if ($imagelist[$i] != '') {
      echo '<option value="' . $imagelist[$i] . '" ';
      if ($imagelist[$i] == $cimg) {
        echo ' selected="selected"';
      }
      echo '>' . $imagelist[$i] . '</option>';
    }
  }
  echo '  </select>' . "\n";
  echo '<img id="NewPic" src="modules/' . $module_name . '/images/categories/' . $cimg . '" alt="" /></td></tr>' . "\n";
  echo '<tr><td style="vertical-align: top;">' . _DESCRIPTION . ':</td>' . "\n";
  echo '<td><textarea name="cdesc" cols="60" rows="10">' . $cdesc . '</textarea></td></tr>' . "\n";
  echo '<tr><td><input type="submit" value="' . _SNIP_UPDATE . '" /></td></tr>' . "\n";
  echo '</table>' . "\n";
  echo '<input type="hidden" name="cid" value="' . $cid . '" />' . "\n";
  echo '<input type="hidden" name="op" value="snippet_edit_cat_save" />' . "\n";
  echo '</form>' . "\n";
  CloseTable();
  include_once ('footer.php');
}

function snippet_cat_save($cat, $cdesc, $cimg) {
  global $prefix, $db, $admin_file;
  $cat = addslashes(check_html($cat, 'nohtml'));
  $cdesc = addslashes(check_html($cdesc, 'nohtml'));
  $cimg = addslashes(check_html($cimg, 'nohtml'));
  $result = $db->sql_query("SELECT cid from " . $prefix . "_dfw_cat where cat='$cat'");
  $numrows = $db->sql_numrows($result);
  if ($numrows > 0) {
    include_once ('header.php');
    GraphicAdmin();
    OpenTable();
    echo "<br /><center><font class=\"content\">" . "<b>" . _ERRORTHECATEGORY . " $title " . _ALREADYEXIST . "</b></font></center><br /><br />" . "" . _GOBACK . "<br /><br />";
    CloseTable();
    include_once ('footer.php');
  } else {
    $db->sql_query("INSERT INTO " . $prefix . "_dfw_cat values (NULL, '$cat', '$cdesc', '$cimg')");
    Header("Location: " . $admin_file . ".php?op=snippets#tab-category");
  }
}

function snippet_edit_cat_save($cid, $cat, $cdesc, $cimg) {
  global $prefix, $db, $admin_file;
  $cid = (int)$cid;
  $cat = addslashes(check_html($cat, 'nohtml'));
  $cdesc = addslashes(check_html($cdesc, 'nohtml'));
  $cimg = addslashes(check_html($cimg, 'nohtml'));
  $db->sql_query("UPDATE " . $prefix . "_dfw_cat SET cat='$cat', cdesc='$cdesc', cimg='$cimg' WHERE cid='$cid' LIMIT 1;");
  Header("Location: " . $admin_file . ".php?op=snippets#tab-category");
}

function snippet_del_cat($cid, $ok = 0) {
  global $prefix, $db, $admin_file;
  if ($ok) {
    $cid = (int)$cid;
    $db->sql_query('DELETE FROM ' . $prefix . '_dfw_cat WHERE cid=\'' . $cid . '\' LIMIT 1');
    $db->sql_query('DELETE FROM ' . $prefix . '_dfw_code WHERE cid=\'' . $cid . '\'');
    Header('Location: ' . $admin_file . '.php?op=snippets#tab-category');
  } else {
    include_once ('header.php');
    GraphicAdmin();
    OpenTable();
    echo '<center><font class="title"><b>' . _REMOVECAT . '</b></font></center>';
    CloseTable();
    OpenTable();
    echo '<center>' . _SURETODELCAT;
    echo '<br /><br />[ <a href="javascript:history.go(-1)">' . _NO . '</a> | <a href="' . $admin_file . '.php?op=snippet_del_cat&amp;cid=' . $cid . '&amp;ok=1">' . _YES . '</a> ]</center>';
    CloseTable();
    include_once ('footer.php');
  }
}

function snippet_del($id, $ok = 0) {
  global $db, $prefix, $admin_file;
  if ($ok) {
    $id = (int)$id;
    $db->sql_query('DELETE FROM ' . $prefix . '_dfw_code WHERE id=\'' . $id . '\' LIMIT 1');
    Header('Location: ' . $admin_file . '.php?op=snippets#tab-list');
  } else {
    include_once ('header.php');
    GraphicAdmin();
    OpenTable();
    echo '<center><font class="title"><b>' . _SNIP_REMOVESNIP . '</b></font></center>';
    CloseTable();
    OpenTable();
    echo '<center>' . _SNIP_SUREDELSNIPPET;
    echo '<br /><br />[ <a href="javascript:history.go(-1)">' . _NO . '</a> | <a href="' . $admin_file . '.php?op=snippet_del&amp;id=' . $id . '&amp;ok=1">' . _YES . '</a> ]</center>';
    CloseTable();
    include_once ('footer.php');
  }
}

function snippet_save($title, $code, $cdesc, $tags = null) {
  global $db, $prefix, $admin_file, $bgcolor2, $textcolor2;
  if (isset($_POST['title'])) {
    $title = addslashes(check_html($_POST['title'], 'nohtml'));
  } else {
    $title = '';
  }
  if (isset($_POST['cat'])) {
    $cat = (int)$_POST['cat'];
  } else {
    $cat = '';
  }
  if (isset($_POST['lang'])) {
    $lang = (int)$_POST['lang'];
  } else {
    $lang = '';
  }
  if (isset($_POST['code'])) {
    $code_output = htmlentities($_POST['code'], ENT_QUOTES);
    $code = addslashes($code_output);
  } else {
    $code = '';
  }
  $desc = isset($_POST['desc']) ? addslashes(check_html($_POST['desc'], 'nohtml')) : '';
  if (isset($_POST['tags'])) {
    $tags = addslashes(check_html($_POST['tags'], 'nohtml'));
  } else {
    $tags = '';
  }
  $db->sql_query('INSERT INTO ' . $prefix . '_dfw_code VALUES (NULL, \'' . $title . '\', \'' . $code . '\', \'' . $desc . '\', \'' . $tags . '\', \'' . $lang . '\', now(), \'' . $cat . '\')');
  Header('Location: ' . $admin_file . '.php?op=snippets#tab-list');
}

function snippet_edit_save($id, $title, $code, $desc, $tags, $lang, $cid) {
  global $db, $prefix, $admin_file, $bgcolor2, $textcolor2;
  $id = (int)$id;
  $title = addslashes(check_html($title, 'nohtml'));
  $code = addslashes(htmlentities($code, ENT_QUOTES));
  $desc = addslashes(check_html($desc, 'nohtml'));
  $tags = addslashes(check_html($tags, 'nohtml'));
  $lang = (int)$_POST['lang'];
  $cid = (int)$cid;
  $db->sql_query('UPDATE ' . $prefix . '_dfw_code SET title=\'' . $title . '\', code=\'' . $code . '\', `desc`=\'' . $desc . '\', tags=\'' . $tags . '\', lang=\'' . $lang . '\', cid=\'' . $cid . '\' WHERE id=\'' . $id . '\'');
  Header('Location: ' . $admin_file . '.php?op=snippets#tab-list');
}

function snippet_style_save() {
  global $db, $prefix, $admin_file, $bgcolor2, $textcolor2;
  foreach ($_POST as $arrStringKey => $arrStringValue) {
    if (strlen($arrStringValue) == 6) {
      fSnipCfgApply($arrStringKey, $arrStringValue);
    }
  }
  Header('Location: ' . $admin_file . '.php?op=snippets#tab-style');
}

function snippet_comment_del($id) {
  global $db, $prefix, $admin_file;
  $id = (int)$id;
  $db->sql_query('DELETE FROM ' . $prefix . '_dfw_comments WHERE id=\'' . $id . '\' LIMIT 1');
  Header('Location: ' . $admin_file . '.php?op=snippets');
}

function snippets() {
  global $db, $prefix, $admin_file;
  include_once ('header.php');
  GraphicAdmin();
  snippet_menu();
  include_once ('footer.php');
}

?>