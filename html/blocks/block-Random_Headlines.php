<?php
/************************************************************************/
/* block-Random_Headlines.php                                          */
/* Updated for PHP 8.3+ Compatibility by ChatGPT                        */
/************************************************************************/

if (!defined('BLOCK_FILE')) {
    header('Location: ../index.php');
    exit;
}

global $prefix, $multilingual, $currentlang, $db, $tipath, $cookie;

// Optional helper: fetch current theme name
$ThemeSel = get_theme();

// Determine layout context
$side = $side ?? '';
$centermode = in_array($side, ['c', 'd', 't']);
$ListClass = $centermode ? 'ul-box-center' : 'ul-box';
if ($centermode) {
    addJSToBody('includes/jquery/haslayout.js', 'file');
}

// Fetch all topic IDs
$topic_array = [];
$sql = "SELECT topicid FROM {$prefix}_topics";
$query = $db->sql_query($sql);
while (list($topicid) = $db->sql_fetchrow($query)) {
    $topic_array[] = (int)$topicid;
}

// Choose a random topic (fallback to topic ID 1)
$topic = 1;
if (count($topic_array) > 1) {
    mt_srand((int)(microtime(true) * 1000000)); // Safe seeding
    $topic = $topic_array[mt_rand(0, count($topic_array) - 1)];
}

// Fetch topic image and title
$sql = "SELECT topicimage, topictext FROM {$prefix}_topics WHERE topicid = '$topic'";
$query = $db->sql_query($sql);
list($topicimage, $topictext) = $db->sql_fetchrow($query);

// Determine topic image path
$localImage = NUKE_THEMES_DIR . $ThemeSel . '/images/topics/' . $topicimage;
$t_image = file_exists($localImage)
    ? "themes/$ThemeSel/images/topics/$topicimage"
    : $tipath . $topicimage;

// Start building block content
$link = "modules.php?name=News&amp;new_topic=$topic";
$content = '<div class="' . $ListClass . ' block-random_headlines">';
$content .= '<div class="text-center padtop-box">';
$content .= "<a href=\"$link\"><img src=\"$t_image\" class=\"centered\" alt=\"$topictext\" title=\"$topictext\" /></a>";
$content .= '</div><div class="padded-box thick text-center">';
$content .= "<a href=\"$link\">$topictext</a></div>";

// Fetch latest stories for the topic
$langFilter = ($multilingual == 1) ? "AND alanguage = '$currentlang'" : '';
$sql = "SELECT sid, title FROM {$prefix}_stories WHERE topic = '$topic' $langFilter ORDER BY sid DESC LIMIT 9";
$result = $db->sql_query($sql);
$numrows = $db->sql_numrows($result);

// Fallback if no stories for this language
if ($numrows === 0 && $multilingual == 1) {
    $sql = "SELECT sid, title FROM {$prefix}_stories WHERE topic = '$topic' AND alanguage = '' ORDER BY sid DESC LIMIT 9";
    $result = $db->sql_query($sql);
    $numrows = $db->sql_numrows($result);
}

// Output story links
if ($numrows > 0) {
    $content .= '<ul class="rn-ul">';
    while (list($sid, $title) = $db->sql_fetchrow($result)) {
        $story_link = "modules.php?name=News&amp;file=article&amp;sid=$sid";
        $content .= "<li><a href=\"$story_link\">$title</a></li>\n";
    }
    $content .= '</ul>';
}

// Finalize block
$content .= '</div><div class="block-spacer">&nbsp;</div>';
