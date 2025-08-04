<?php
// Prevent direct access
if (stripos(htmlentities($_SERVER['PHP_SELF']), 'jBreadcrumb.php') !== false) {
    header('Location: ../index.php');
    exit;
}

global $name, $prefix, $db, $bgcolor2, $op, $cid, $id;

// Sanitize $name and default values
$name = str_replace('_', ' ', (string)$name);
$item_delim = ' > ';
$homelink = '<a href="index.php">Home</a>';
$breadcrumb = '';

function escape_html(string $text): string {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function safe_url(string $text): string {
    return rawurlencode($text);
}

// Helper to get category name by cid safely
function getCategoryName($cid) {
    global $prefix, $db;
    $cid = (int)$cid;
    $sql = "SELECT cat FROM {$prefix}_dfw_cat WHERE cid = '{$cid}' LIMIT 1";
    $result = $db->sql_query($sql);
    if ($result && $row = $db->sql_fetchrow($result)) {
        return $row['cat'];
    }
    return '';
}

// Helper to get code title and category id by code id safely
function getCodeInfo($id) {
    global $prefix, $db;
    $id = (int)$id;
    $sql = "SELECT title, cid FROM {$prefix}_dfw_code WHERE id = '{$id}' LIMIT 1";
    $result = $db->sql_query($sql);
    if ($result && $row = $db->sql_fetchrow($result)) {
        return ['title' => $row['title'], 'cid' => $row['cid']];
    }
    return null;
}

if ($name === 'Snippets') {
    $breadcrumb .= "<li>$homelink</li>";
    $breadcrumb .= "<li><a href=\"modules.php?name=" . escape_html($name) . "\">" . escape_html($name) . "</a></li>";

    if ($op === 'pubViewCat' && !empty($cid)) {
        $cat = getCategoryName($cid);
        if ($cat) {
            $breadcrumb .= "<li><a href=\"modules.php?name=" . escape_html($name) . "&amp;op=pubViewCat&amp;cid=" . safe_url($cid) . "\">" . escape_html($cat) . "</a></li>";
        }
    } elseif ($op === 'pubShow' && !empty($id)) {
        $codeInfo = getCodeInfo($id);
        if ($codeInfo) {
            $cat = getCategoryName($codeInfo['cid']);
            $breadcrumb .= "<li><a href=\"modules.php?name=" . escape_html($name) . "&amp;op=pubViewCat&amp;cid=" . safe_url($codeInfo['cid']) . "\">" . escape_html($cat) . "</a></li>";
            $breadcrumb .= "<li><a href=\"modules.php?name=" . escape_html($name) . "&amp;op=pubShow&amp;id=" . safe_url($id) . "\">" . escape_html($codeInfo['title']) . "</a></li>";
        }
    }
}

// Catchall for other pages
if (empty($breadcrumb)) {
    $name_esc = escape_html($name);
    $breadcrumb = "<li>$homelink $item_delim $name_esc</li>";
}

// Admin pages
if (strpos($_SERVER['REQUEST_URI'], '/admin.php') === 0) {
    $breadcrumb = "<li>$homelink $item_delim Administration</li>";
}

// Main page fallback
if ($_SERVER['REQUEST_URI'] === '/index.php' || $_SERVER['REQUEST_URI'] === '/') {
    $breadcrumb = "<li>$homelink</li>";
}

// Output breadcrumb HTML
echo '<div class="breadCrumbHolder module">';
echo '<div style="background-color: ' . escape_html($bgcolor2) . ';" id="breadCrumb0" class="breadCrumb module">';
echo '<ul>' . $breadcrumb . '</ul>';
echo '</div>';
echo '</div>';
echo '<div class="chevronOverlay main"></div>';

// If you want to revert $name to original underscore form for other uses
$name = str_replace(' ', '_', $name);
