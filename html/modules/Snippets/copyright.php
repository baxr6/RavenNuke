<?php

$author_name = 'Testy1';
$author_copyright = '2009';
$author_user_email = 'egmade@gmail.com';
$author_homepage = 'http://www.dfwcomputer.com.au';
$license = 'GNU/GPL';
$download_location = 'http://www.dfwcomputer.com.au';
$module_version = '1.0.0';
$module_description = 'Code Snippet Gallery';

function show_copyright()
{
    global $author_name, $author_user_email, $author_homepage, $license, $download_location, $module_version, $module_description;
    global $author_copyright;
    if ( $author_name == '' ) {
        $author_name = 'N/A';
    }
    if ( $author_user_email == '' ) {
        $author_user_email = 'N/A';
    }
    if ( $author_homepage == '' ) {
        $author_homepage = 'N/A';
    }
    if ( $license == '' ) {
        $license = 'N/A';
    }
    if ( $module_version == '' ) {
        $module_version = 'N/A';
    }
    if ( $module_description == '' ) {
        $module_description = 'N/A';
    }
    $module_name = basename( dirname(__file__) );
    $module_name = preg_replace( '/_/i', ' ', $module_name );

    $download = '';
    if ( $download_location != '' ) {
        $download = '<a href="' . $download_location . '" target="_blank">Module\'s Download</a> | ';
    }

    echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" ' . '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . '<html xmlns="http://www.w3.org/1999/xhtml">' . "\n" . '<head><title>' . $module_name . ': Copyright Information</title></head>' . "\n" .
        '<body bgcolor="#F6F6EB" link="#363636" alink="#363636" vlink="#363636">' . "\n" . '<center><font size="2" color="#363636" face="Verdana, Helvetica">' . "\n" . $module_name . ' module for <a href="http://phpnuke.org" target="_blank">PHP-Nuke</a><br />' . '<b>&copy; ' . $author_copyright . ' ' . $author_name .
        '</b></font></center>' . "\n" . '<img alt=" " src="../../images/arrow.gif" border="0" />&nbsp;<b>Module\'s Name:</b> ' . $module_name . '<br />' . "\n" . '<img alt=" " src="../../images/arrow.gif" border="0" />&nbsp;<b>Module\'s Version:</b> ' . $module_version . '<br />' . "\n" .
        '<img alt=" " src="../../images/arrow.gif" border="0" />&nbsp;<b>Module\'s Description:</b> ' . $module_description . '<br />' . "\n" . '<img alt=" " src="../../images/arrow.gif" border="0" />&nbsp;<b>License:</b> ' . $license . '<br />' . "\n" .
        '<img alt=" " src="../../images/arrow.gif" border="0" />&nbsp;<b>Author\'s Name:</b> ' . $author_name . '<br />' . "\n" . '<img alt=" " src="../../images/arrow.gif" border="0" />&nbsp;<b>Author\'s Email:</b> ' . $author_user_email . '<br /><br />' . "\n" .
        '<center><font size="2" color="#363636" face="Verdana, Helvetica">[ <a href="' . $author_homepage . '" target="_blank">Author\'s HomePage</a> | ' . $download . '<a href="javascript:void(0)" onclick="javascript:self.close()">Close</a> ]' . "\n" . '</font></center>' . "\n" . '</body>' . "\n" .
        '</html>';
}

show_copyright();

?>
