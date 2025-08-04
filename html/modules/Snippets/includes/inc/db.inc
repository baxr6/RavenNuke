<?php

global $arrSnip_cfg, $admin_file, $arrLang;

$arrLang = array( '0' => 'css', '1' => 'html', '2' => 'javascript', '3' => 'mysql', '4' => 'php' );


$arrSnip_cfg = fSnip_Get_Cfg();

function fSnip_Get_Cfg()
{
    global $prefix, $db;
    $configresult = $db->sql_query( "SELECT `config_name`, `config_value` FROM `" . $prefix . "_dfw_conf`" );
    while ( list($config_name, $config_value) = $db->sql_fetchrow($configresult) ) {
        if ( !get_magic_quotes_runtime() ) {
            $config_name = stripslashes( $config_name );
            $config_value = stripslashes( $config_value );
        }
        $config[$config_name] = $config_value;
    }
    return $config;
}

function fSnipCfgApply( $config_name, $config_value )
{
    global $prefix, $db;
    if ( !get_magic_quotes_runtime() ) {
        $config_name = addslashes( $config_name );
        $config_value = addslashes( $config_value );
    }
    $result = $db->sql_numrows( $db->sql_query("SELECT * FROM `" . $prefix . "_dfw_conf` WHERE `config_name`='$config_name' LIMIT 0,1") );
    if ( $result < 1 ) {
        $db->sql_query( "INSERT INTO `" . $prefix . "_dfw_conf` (`config_name`, `config_value`) VALUES ('$config_name', '$config_value')" );
    } else {
        $db->sql_query( "UPDATE `" . $prefix . "_dfw_conf` SET `config_value`='$config_value' WHERE `config_name`='$config_name'" );
    }
}

function sql_table_exists($table) {
	global $db, $prefix;
	$table = preg_replace('/[^A-Za-z0-9_]+/', '', $table);
  return (bool) $db->sql_fetchrow($db->sql_query("SHOW TABLES LIKE '" . $prefix . "_". $table ."'"));
}
	

?>