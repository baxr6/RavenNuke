<?php

$pagetitle = $pagename.": ERROR";
@include("header.php");
title("$pagetitle");
OpenTable();
echo "<center><b>Sorry, ONLY super admins may run this script</b><center>\n";
CloseTable();
@include("footer.php");

?>