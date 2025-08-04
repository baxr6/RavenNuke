<?php

$pagetitle = $pagename;
@include("header.php");
title($pagetitle);
OpenTable();
echo '<form action="'.$_SERVER['PHP_SELF'].'" method="post">' . "\n";
echo '  <table align="center" border="0" cellpadding="2" cellspacing="2">' . "\n";
echo '    <tr><td>Installation for '.$pagename.'.</td>' . "\n";
echo '    </tr>' . "\n";
echo '    <tr><td><b>ALWAYS BACKUP YOUR EXISTING SITE BEFORE PROCEEDING!!!!!</b></td>' . "\n";
echo '    </tr>' . "\n";
echo '    <tr><td>' . "\n";
echo '        <select name="op">' . "\n";
echo '          <option value="">---- Install Options ----' . "\n";
echo '          </option>' . "\n";
echo '          <option value="install">First Time Install of '.$pagename.'' . "\n";
echo '          </option>' . "\n";
echo '          <option value="">---- Un-install Options ----' . "\n";
echo '          </option>' . "\n";
echo '          <option value="uninstall">Un-install '.$pagename.' tables' . "\n";
echo '          </option>' . "\n";
echo '        </select> ' . "\n";
echo '        <input type="submit" value="Go Baby" /></td>' . "\n";
echo '    </tr>' . "\n";
echo '    <tr><td><b>Once you have finished, delete this file and the &quot;snippet_installer&quot; folder from your server!</b></td>' . "\n";
echo '    </tr>' . "\n";
echo '  </table>' . "\n";
echo '</form><br />' . "\n";
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
CloseTable();
@include("footer.php");

?>