<?php

if (!defined('BLOCK_FILE')) {
    header('Location: ../index.php');
    exit;
}

global $cat, $language, $prefix, $multilingual, $currentlang, $db, $name;

// Ensure $name is always set as a string
if (!isset($name)) {
    $name = '';
}

if ($multilingual == 1) {
    $querylang = "AND (`alanguage` = '" . $db->sql_escape($currentlang) . "' OR `alanguage` = '')"; // Prevent SQL injection with proper escaping
} else {
    $querylang = '';
}

// Defensive default for $side
if (!isset($side)) {
    $side = '';
}

if (in_array($side, ['c', 'd', 't'], true)) {
    $ListClass = 'ul-box-center';
    addJSToBody('includes/jquery/haslayout.js', 'file');
} else {
    $ListClass = 'ul-box';
}

$sql = 'SELECT `catid`, `title` FROM `' . $prefix . '_stories_cat` ORDER BY `title`';
$result = $db->sql_query($sql);
$numrows = $db->sql_numrows($result);

if ($numrows == 0) {
    $content = defined('_BLOCKPROBLEM2') ? _BLOCKPROBLEM2 : 'No categories available.';
} else {
    $boxstuff = '<div class="' . htmlspecialchars($ListClass, ENT_QUOTES) . ' block-categories"><ul class="rn-ul">';
    $n = 1;
    $a = 0;

    // Use safer while loop with explicit fetch and check
    while (is_array($row = $db->sql_fetchrow($result))) {
        [$catid, $title] = $row;
        $catid = (int)$catid;
        // stripslashes usually unnecessary; remove if not needed
        $title = stripslashes($title);

        // Use prepared statement or proper escaping inside your sql_numrows check if possible
        $countSql = 'SELECT 1 FROM `' . $prefix . '_stories` WHERE `catid`=' . $catid . ' ' . $querylang . ' LIMIT 1';
        $numrowsStories = $db->sql_numrows($db->sql_query($countSql));
        if ($numrowsStories > 0) {
            // Determine list item class
            if ($cat == 0 && !$a && $name === 'News') {
                $boxstuff .= '<li class="li-first"><span class="thick" title="' . htmlspecialchars(_ALLCATEGORIES, ENT_QUOTES) . '">' . _ALLCATEGORIES . '</span></li>';
                $a = 1;
                $n++;
            } elseif ((($cat !== 0 && !$a) || ($name !== 'News' && !$a))) {
                $boxstuff .= '<li class="li-first"><a href="modules.php?name=News" title="' . htmlspecialchars(_ALLCATEGORIES, ENT_QUOTES) . '">' . _ALLCATEGORIES . '</a></li>';
                $a = 1;
                $n++;
            }

            // Odd/even class for subsequent items
            if ($n > 1) {
                $column = ($n % 2) ? 'li-odd' : 'li-even';
            } else {
                $column = 'li-first';
            }

            if ($cat === $catid && $name === 'News') {
                $boxstuff .= '<li class="' . $column . '"><span class="thick" title="' . htmlspecialchars($title, ENT_QUOTES) . '">' . htmlspecialchars($title) . '</span></li>';
                $n++;
            } else {
                $urlCatId = urlencode($catid);
                $boxstuff .= '<li class="' . $column . '"><a href="modules.php?name=News&amp;file=categories&amp;op=newindex&amp;catid=' . $urlCatId . '" title="' . htmlspecialchars($title, ENT_QUOTES) . '">' . htmlspecialchars($title) . '</a></li>';
                $n++;
            }
        }
    }

    $boxstuff .= '</ul></div>';
    $boxstuff .= '<div class="block-spacer">&nbsp;</div>';

    $content = ($n > 1) ? $boxstuff : (defined('_BLOCKPROBLEM2') ? _BLOCKPROBLEM2 : 'No categories to display.');
}
