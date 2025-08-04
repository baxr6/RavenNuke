<?php

if (!defined('SNIP_PUBLIC')) {
  die("Illegal Access Detected!!!");
}
global $locale, $prefix, $db, $userinfo, $admin, $user;

include_once ('header.php');
require_once ('modules/' . $module_name . '/includes/ChiliHighlighter.php');
ChiliHighlighter::init('js');
pubMenu();
jBreadCrumb();
OpenTable();
$id = (isset($_GET['id'])) ? (int) $_GET['id'] : '';
$sql = $db->sql_query('SELECT * FROM ' . $prefix . '_dfw_code WHERE id = \'' . $id . '\'');
$sniprow = $db->sql_fetchrow($sql);
$title = stripslashes(check_html($sniprow['title'], 'nohtml'));
$code = stripslashes($sniprow['code']);
$code = wordwrap($code, $arrSnip_cfg['word_wrap'], "\n", true);
$desc = stripslashes(check_html($sniprow['desc'], 'nohtml'));
$tags = stripslashes(check_html($sniprow['tags'], 'nohtml'));
$lang = (int)$sniprow['lang'];
$date = $sniprow['date'];

if (is_user($user)) {
  $sCRegUser = $userinfo['username'];
} else {
  $sCRegUser = '';
}


setlocale(LC_TIME, $locale);
preg_match("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})/", $date, $datetime);
$dateTimeStr = $datetime[1] . '-' . $datetime[2] . '-' . $datetime[3] . ' ' . $datetime[4] . ':' . $datetime[5] . ':' . $datetime[6];
$dateObj = new DateTime($dateTimeStr);

$day = $dateObj->format('d');    // Day with leading zeros (01 to 31)
$month = $dateObj->format('M');  // Short textual month (Jan, Feb, ...)
$year = $dateObj->format('Y');   // Full year (e.g., 2025)
$arrLang = array('css', 'html', 'javascript', 'mysql', 'php');
OpenTable2();
echo '<table width="100%" border="0" cellspacing="0" cellpadding="2">' . "\n";
echo '  <tr>' . "\n";
echo '<td><div style="float: left;display:inline;margin:0;background:#fff;border:1px solid #ccc;">';
echo '<div style="background:#21759b;color:#fff;text-align:center;padding:0 5px;">' . $month . '</div>';
echo '<div style="background:#f1f1f1;color:#21759b;text-align:center;">' . $day . '</div>';
echo '<div style="background:#21759b;color:#fff;text-align:center;padding:0 5px;">' . $year . '</div>';
echo '</div></td>';
echo '    <td><strong>Title:&nbsp;' . $title . '</strong></td>' . "\n";
echo '  </tr>' . "\n";
echo '  </table>' . "\n";
CloseTable2();
OpenTable2();
echo '<table width="80%" border="0" cellspacing="0" cellpadding="2">' . "\n";
echo '  <tr>' . "\n";
echo '    <td><strong>Description:</strong><br />' . $desc . '</td>' . "\n";
echo '  </tr>' . "\n";
echo '  </table>' . "\n";
CloseTable2();
OpenTable2();
echo '<table width="100%" border="0" cellspacing="0" cellpadding="2">' . "\n";
echo '  <tr>' . "\n";
if ($arrSnip_cfg['select_expand'] == 1) {
  echo '<td><div class="trigger">';
  echo '<span><a href="#">&nbsp;Expand / Collapse</a></span>';
  echo '<div style="display: none;">';
} else {
  echo '<td style="font-size: 12px;">' . "\n";
}
ChiliHighlighter::highlightString($code, $arrLang[$lang]);
if ($arrSnip_cfg['select_expand'] == 1) {
  echo '</div></div></td>';
  //echo '</div>';
} else {
  echo '</td>' . "\n";
}
echo '  </tr>' . "\n";
echo '</table><br />' . "\n";
CloseTable2();
OpenTable2();
echo '<table width="80%" border="0" cellspacing="0" cellpadding="2">' . "\n";
echo '  <tr>' . "\n";
echo '    <td>' . "\n";
if (!empty($tags)) {
  echo '<b>' . _SNIP_TAGS . '</b>: ' . Tag2Link($tags, $module_name) . '<br />' . "\n";
} else {
  echo '<b>' . _SNIP_TAGS . '</b>: ' . _SNIP_NONE . '<br />' . "\n";
}
echo '</td>' . "\n";
echo '  </tr>' . "\n";
echo '</table>' . "\n";
CloseTable2();
CloseTable();
fSnipAPanel();

if ($arrSnip_cfg['allow_comments'] == 1) { // Check Comments enabled and is user
  if (is_user($user) || is_admin($admin)) {
    OpenTable();
    echo '   <div id="com_comments" style="background-color: ' . $bgcolor2 . ';">' . "\n";
    echo '<h2>' . _SNIP_READER_COMMENTS . '</h2>		' . "\n";
    echo '    </div>		' . "\n";
    echo '    <div id="com_leaveComment" style="background-color: ' . $bgcolor2 . ';">' . "\n";
    echo '<h2>' . _SNIP_LEAVE_COMMENT . '</h2>			' . "\n";
    echo '      <div class="com_row">' . "\n";
    echo '        <label>' . _SNIP_NAME . '' . "\n";
    echo '        </label>' . "\n";
    echo '        <input type="text" value="' . $sCRegUser . '">' . "\n";
    echo '      </div>			' . "\n";
    echo '      <div class="com_row">' . "\n";
    echo '        <label>' . _SNIP_COMMENT . '' . "\n";
    echo '        </label>' . "\n";
    echo '<textarea cols="10" rows="5"></textarea>' . "\n";
    echo '      </div>			' . "\n";
    echo '      <button id="com_add">' . _SNIP_ADD . '' . "\n";
    echo '      </button>		' . "\n";
    echo '    </div>		' . "\n";
    echo '<script type="text/javascript">' . "\n";
    echo '/*<![CDATA[*/' . "\n";
    echo '			$(function() {' . "\n";
    echo '				' . "\n";
    echo '				//retrieve comments to display on page' . "\n";
    echo '				$.getJSON("modules.php?name=Snippets&op=SPCallBack&id=' . $id . '&jsoncallback=", function(data) {' . "\n";
    echo '				 ' . "\n";
    echo '					//loop through all items in the JSON array' . "\n";
    echo '					for (var x = 0; x < data.length; x++) {' . "\n";
    echo '					' . "\n";
    echo '						//create a container for each comment' . "\n";
    echo '						var div = $("<div>").addClass("rowComment").appendTo("#com_comments");' . "\n";
    echo '						' . "\n";
    echo '						//add author name and comment to container' . "\n";
    echo '						$("<label>").text(data[x].name).appendTo(div);' . "\n";
    echo '						$("<div>").addClass("com_comment").text(data[x].comment).appendTo(div);' . "\n";
    echo '						var div = $("<div>").addClass("com_rightbox").appendTo("#com_comments");' . "\n";
    echo '$("<div>").addClass("com_link").html("<a href=\"modules.php?name=Snippets&op=SPDelComment&comment_id=" + data[x].id + "\">Delete</a>").appendTo(div);' . "\n";
    echo '					}' . "\n";
    echo '				});	' . "\n";
    echo '				' . "\n";
    echo '				//add click handler for button' . "\n";
    echo '				$("#com_add").click(function() {' . "\n";
    echo '				' . "\n";
    echo '					//define ajax config object' . "\n";
    echo '					var ajaxOpts = {' . "\n";
    echo '						type: "post",' . "\n";
    echo '						url: "modules.php?name=Snippets&op=SPAddComment",' . "\n";
    echo '						data: "&id=' . $id . '&author=" + $("#com_leaveComment").find("input").val() + "&comment=" + $("#com_leaveComment").find("textarea").val(),' . "\n";
    echo '						success: function(data) {' . "\n";
    echo '							' . "\n";
    echo '							//create a container for the new comment' . "\n";
    echo '							var div = $("<div>").addClass("rowComment").appendTo("#com_comments");' . "\n";
    echo '						' . "\n";
    echo '							//add author name and comment to container' . "\n";
    echo '							$("<label>").text($("#com_leaveComment").find("input").val()).appendTo(div);' . "\n";
    echo '							$("<div>").addClass("com_comment").text($("#com_leaveComment").find("textarea").val()).appendTo(div);' . "\n";
    echo '							' . "\n";
    echo '							//empty inputs' . "\n";
    echo '							$("#com_leaveComment").find("input").val("");' . "\n";
    echo '							$("#com_leaveComment").find("textarea").val("");' . "\n";
    echo '						}' . "\n";
    echo '					};' . "\n";
    echo '					' . "\n";
    echo '					$.ajax(ajaxOpts);' . "\n";
    echo '				' . "\n";
    echo '				});		' . "\n";
    echo '			});			' . "\n";
    echo '/*]]>*/' . "\n";
    echo '		</script>' . "\n";
    CloseTable();
  }
} // End User check
include_once ('footer.php');

?>