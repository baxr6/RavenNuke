<?php
// Modernized snippet config and utility functions

global $arrSnip_cfg, $admin_file, $arrLang;

$arrLang = ['0' => 'css', '1' => 'html', '2' => 'javascript', '3' => 'mysql', '4' => 'php'];

$arrSnip_cfg = fSnip_Get_Cfg();

function fSnip_Get_Cfg() {
    global $prefix, $db;
    $config = [];
    $configresult = $db->sql_query("SELECT `config_name`, `config_value` FROM `" . $prefix . "_dfw_conf`");
    while (list($config_name, $config_value) = $db->sql_fetchrow($configresult)) {
        // Escape output if needed when rendering; store raw here
        $config[$config_name] = $config_value;
    }
    return $config;
}

function fSnipCfgApply(string $config_name, string $config_value): void {
    global $prefix, $db;

    // Escape inputs to prevent SQL Injection
    $config_name_esc = $db->sql_escape_string($config_name);
    $config_value_esc = $db->sql_escape_string($config_value);

    $result = $db->sql_query("SELECT 1 FROM `" . $prefix . "_dfw_conf` WHERE `config_name` = '$config_name_esc' LIMIT 1");
    if ($db->sql_numrows($result) < 1) {
        $db->sql_query("INSERT INTO `" . $prefix . "_dfw_conf` (`config_name`, `config_value`) VALUES ('$config_name_esc', '$config_value_esc')");
    } else {
        $db->sql_query("UPDATE `" . $prefix . "_dfw_conf` SET `config_value` = '$config_value_esc' WHERE `config_name` = '$config_name_esc'");
    }
}

function pubMenu(): void {
    global $module_name;
    OpenTable();
    echo <<<HTML
<table align="center" width="80%" border="0" cellspacing="0" cellpadding="2">
<tr align="center">
    <td align="center"><a href="modules.php?name=Snippets"><img src="modules/{$module_name}/images/snippet_logo.png" alt="Snippets" /></a></td>
</tr>
</table>
HTML;
    CloseTable();
}

function fSnipAPanel(): void {
    global $admin, $admin_file;
    if (is_admin($admin)) {
        OpenTable();
        echo '<table border="0" cellspacing="10" cellpadding="0" align="center" width="100%"><tr>';
        echo '<td align="center">Admin Options:&nbsp;<a href="' . htmlspecialchars($admin_file) . '.php?op=snippets">' . _SNIP_ADMINPANEL . '</a></td>';
        echo '</tr></table>';
        CloseTable();
    }
}

function jBreadCrumb(): void {
    global $module_name;
    OpenTable();
    include_once('modules/' . $module_name . '/includes/jBreadcrumb.php');
    CloseTable();
}

function Tag2Link(string $tags, string $mod): string {
    $tagsArr = array_map('trim', explode(',', $tags));
    $links = [];

    foreach ($tagsArr as $tag) {
        $urlTag = urlencode($tag);
        $links[] = '<a href="modules.php?name=' . htmlspecialchars($mod) . '&amp;op=browse_tag&amp;tag=' . $urlTag . '">' . ucwords(htmlspecialchars($tag)) . '</a>';
    }

    return implode(', ', $links);
}

function roundsize(float $size): string {
    $i = 0;
    $iec = ["B", "Kb", "Mb", "Gb", "Tb"];
    while (($size / 1024) > 1 && $i < count($iec) - 1) {
        $size /= 1024;
        $i++;
    }
    return round($size, 1) . " " . $iec[$i];
}

function sql_table_exists(string $table): bool {
    global $db, $prefix;
    // sanitize table name strictly
    $table = preg_replace('/[^A-Za-z0-9_]+/', '', $table);
    $result = $db->sql_query("SHOW TABLES LIKE '" . $db->sql_escape_string($prefix . "_" . $table) . "'");
    return (bool)$db->sql_fetchrow($result);
}

function JQOpen(): void {
    echo '<fieldset class="trigger">';
    echo '<legend><a href="#">&nbsp;Expand / Collapse</a></legend>';
    echo '<div style="display: none;">';
}

function JQClose(): void {
    echo '</div></fieldset>';
}

?>
