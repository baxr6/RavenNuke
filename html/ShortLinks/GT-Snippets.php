<?php
/************************************************************************
* Script:     TegoNuke(tm) ShortLinks
* Version:    1.2.0
* Author:     Rob Herder (aka: montego) of http://montegoscripts.com
* Contact:    montego@montegoscripts.com
* Copyright:  Copyright © 2007 by Montego Scripts
* License:    GNU/GPL (see provided LICENSE.txt file)
* Comments:   Initial creation for Comments module
************************************************************************/

$urlin = array(
'"(?<!/)modules.php\?name=Snippets&amp;op=browse_tag&amp;tag=([a-zA-Z0-9_-]*)"',
'"(?<!/)modules.php\?name=Snippets&amp;op=pubShow&amp;id=([0-9]*)"',
'"(?<!/)modules.php\?name=Snippets&amp;op=pubViewCat&amp;cid=([0-9]*)"',
'"(?<!/)modules.php\?name=Snippets"'
);

$urlout = array(
'snippet-tag-\\1.html',
'snippet-code-\\1.html',
'snippet-category-\\1.html',
'snippet.html'
);

?>