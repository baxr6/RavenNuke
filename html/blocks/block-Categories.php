<?php

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2002 by Francisco Burzi                                */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/
/*         Additional security & Abstraction layer conversion           */
/*                           2003 chatserv                              */
/*      http://www.nukefixes.com -- http://www.nukeresources.com        */
/************************************************************************/
/************************************************************************/
/* Additional code clean-up, performance enhancements, and W3C and      */
/* XHTML compliance fixes by Raven and Montego.                         */
/* Updated for PHP 8.4 compatibility                                    */
/************************************************************************/

if (!defined('BLOCK_FILE')) {
    header('Location: ../index.php');
    die();
}

global $cat, $language, $prefix, $multilingual, $currentlang, $db, $name;

// Initialize variables with proper defaults
$name = $name ?? '';
$cat = $cat ?? 0;
$multilingual = $multilingual ?? 0;
$currentlang = $currentlang ?? '';
$side = $side ?? '';

// Ensure variables are properly typed
$cat = (int)$cat;
$multilingual = (int)$multilingual;

if ($multilingual == 1) {
    $querylang = 'AND (`alanguage`=\'' . $db->sql_escape_string($currentlang) . '\' OR `alanguage`=\'\')'; /* the OR is needed to display stories who are posted to ALL languages */
} else {
    $querylang = '';
}

if ($side == 'c' || $side == 'd' || $side == 't') {
    $ListClass = 'ul-box-center';
    addJSToBody('includes/jquery/haslayout.js', 'file');
} else {
    $ListClass = 'ul-box';
}

$sql = 'SELECT `catid`, `title` FROM `' . $prefix . '_stories_cat` ORDER BY `title`';
$result = $db->sql_query($sql);
$numrows = $db->sql_numrows($result);

if ($numrows == 0) {
    // No categories exist yet
    $content = '<div class="' . htmlspecialchars($ListClass, ENT_QUOTES, 'UTF-8') . ' block-categories">
                    <div class="no-categories">No categories available</div>
                </div>';
} else {
    $boxstuff = '<div class="' . htmlspecialchars($ListClass, ENT_QUOTES, 'UTF-8') . ' block-categories"><ul class="rn-ul">';
    $n = 1;
    $a = 0;
    
    while ($row = $db->sql_fetchrow($result)) {
        $catid = (int)$row['catid']; // Use array access instead of list()
        $title = stripslashes($row['title']);
        
        // Escape title for safe output
        $title_escaped = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
        
        // Build secure query with proper escaping
        $count_sql = 'SELECT COUNT(*) as count FROM `' . $prefix . '_stories` WHERE `catid`=' . $catid . ' ' . $querylang . ' LIMIT 1';
        $count_result = $db->sql_query($count_sql);
        $count_row = $db->sql_fetchrow($count_result);
        $story_count = (int)($count_row['count'] ?? 0);
        
        $column = 'li-first';
        
        if ($story_count > 0) {
            if ($cat == 0 && !$a && $name == 'News') {
                $boxstuff .= '<li class="' . $column . '"><span class="thick" title="' . htmlspecialchars(_ALLCATEGORIES, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars(_ALLCATEGORIES, ENT_QUOTES, 'UTF-8') . '</span></li>';
                $a = 1;
                ++$n;
            } elseif (($cat != 0 && !$a) || ($name != 'News' && !$a)) {
                $boxstuff .= '<li class="' . $column . '"><a href="modules.php?name=News" title="' . htmlspecialchars(_ALLCATEGORIES, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars(_ALLCATEGORIES, ENT_QUOTES, 'UTF-8') . '</a></li>';
                $a = 1;
                ++$n;
            }
            
            if ($n > 1 && $n % 2) {
                $column = 'li-odd';
            } else if ($n > 1) {
                $column = 'li-even';
            } else {
                $column = 'li-first';
            }
            
            if ($cat == $catid && $name == 'News') {
                $boxstuff .= '<li class="' . $column . '"><span class="thick" title="' . $title_escaped . '">' . $title_escaped . '</span></li>';
                ++$n;
            } else {
                $boxstuff .= '<li class="' . $column . '"><a href="modules.php?name=News&amp;file=categories&amp;op=newindex&amp;catid=' . $catid . '" title="' . $title_escaped . '">' . $title_escaped . '</a></li>';
                ++$n;
            }
        }
    }
    $boxstuff .= '</ul></div>';
    // make sure content does not float outside the block
    $boxstuff .= '<div class="block-spacer">&nbsp;</div>';
}

if ($n > 1) {
    $content = $boxstuff;
} else {
    // Categories exist but none have published stories
    $content = '<div class="' . htmlspecialchars($ListClass, ENT_QUOTES, 'UTF-8') . ' block-categories">
                    <div class="no-content">No published stories in categories</div>
                </div>';
}
?>