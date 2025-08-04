<?php
/*
this file shows how to configure a static setup
it must be linked from the head of a page like:
<link rel="stylesheet" type="text/css" href="chili/recipes.css"/>
*/
global $arrSnip_cfg;
?>
<style type="text/css">
.cplusplus .mlcom    { color: #4040c2; }
.cplusplus .com      { color: #008000; }
.cplusplus .string   { color: #008080; }
.cplusplus .keyword  { color: #000080; font-weight: bold; }
.cplusplus .datatype { color: #0000FF; }
.cplusplus .preproc  { color: #FF0000; }
.cplusplus .number   { color: #FF0000; }

.csharp .mlcom    { color: #4040c2; }
.csharp .com      { color: #008000; }
.csharp .string   { color: #008080; }
.csharp .keyword  { color: #000080; font-weight: bold; }
.csharp .preproc  { color: #FF0000; }
.csharp .number   { color: #FF0000; }


.css .mlcom  { color: #4040c2; }
.css .color  { color: #008000; }
.css .string { color: #008080; }
.css .attrib { color: #000080; font-weight: bold; }
.css .value  { color: #0000FF; }
.css .number { color: #FF0000; }

.delphi .mlcom   { color: #4040c2; }
.delphi .com     { color: #008000; }
.delphi .string  { color: #008080; }
.delphi .keyword { color: #000080; font-weight: bold; }
.delphi .direct  { color: #FF0000; }
.delphi .number  { color: #FF0000; }

.html .php    { color: #FF0000; font-weight: bold; }
.html .tag    { color: #000080; font-weight: bold; }
.html .aname  { color: #800080; }
.html .avalue { color: #FF00FF; }
.html .mlcom  { color: #008000; }
.html .entity { color: #008080; }

.java .mlcom   { color: #4040c2; }
.java .com     { color: #008000; }
.java .string  { color: #008080; }
.java .meta    { color: #FF0000; }
.java .keyword { color: #000080; font-weight: bold; }
.java .number  { color: #FF0000; }

.javascript .mlcom    { color: <?php echo '#'.$arrSnip_cfg['js_mlcom']?>; }
.javascript .com      { color: <?php echo '#'.$arrSnip_cfg['js_com']?>; }
.javascript .regexp   { color: <?php echo '#'.$arrSnip_cfg['js_regexp']?>; }
.javascript .string   { color: <?php echo '#'.$arrSnip_cfg['js_string']?>; }
.javascript .keywords { color: <?php echo '#'.$arrSnip_cfg['js_keywords']?>; font-weight: bold; }
.javascript .global   { color: <?php echo '#'.$arrSnip_cfg['js_global']?>; }
.javascript .numbers  { color: <?php echo '#'.$arrSnip_cfg['js_numbers']?>; }

.lotusscript .mlcom	    { color: #4040c2; }
.lotusscript .com       { color: #008000; }
.lotusscript .mlstr     { color: #FF0000; }
.lotusscript .str       { color: #008080; }
.lotusscript .keyd      { color: #FF00FF; }
.lotusscript .keyw      { color: #800000; font-weight: bold; }
.lotusscript .directive { color: #5f5f5f; }
.lotusscript .notes     { color: #000080; }
.lotusscript .notesui   { color: #800080; }

.mysql .function  { color: #e17100; }
.mysql .keyword   { color: #000080; font-weight: bold; }
.mysql .mlcom     { color: #808080; }
.mysql .com       { color: #008000; }
.mysql .number    { color: #FF0000; }
.mysql .hexnum    { color: #FF0000; font-weight: bold; }
.mysql .string    { color: #800080; }
.mysql .quid      { color: #FF00FF; }
.mysql .id        { color: #800000; }
.mysql .value     { color: #808080; font-weight: bold; }
.mysql .variable  { color: #4040c2; }

.php .com       { color: #008000; }
.php .const1    { color: <?php echo '#'.$arrSnip_cfg['php_const1']?>; }
.php .const2    { color: <?php echo '#'.$arrSnip_cfg['php_const2']?>; }
.php .func      { color: <?php echo '#'.$arrSnip_cfg['php_func']?>; }
.php .global    { color: <?php echo '#'.$arrSnip_cfg['php_global']?>; }
.php .keyword   { color: <?php echo '#'.$arrSnip_cfg['php_keyword']?>; font-weight: bold; }
.php .mlcom     { color: #808080; }
.php .name      { color: <?php echo '#'.$arrSnip_cfg['php_name']?>; }
.php .number    { color: <?php echo '#'.$arrSnip_cfg['php_number']?>; }
.php .string1   { color: <?php echo '#'.$arrSnip_cfg['php_string1']?>; }
.php .string2   { color: <?php echo '#'.$arrSnip_cfg['php_string2']?>; }
.php .value     { color: <?php echo '#'.$arrSnip_cfg['php_value']?>; font-weight: bold; }
.php .variable  { color: <?php echo '#'.$arrSnip_cfg['php_variable']?>; }

</style>