<?php

/*
Requires;
jQuery UI Core 
jQuery UI Tabs http://stilbuero.de/jquery/tabs_3/
*/
/**
 * jtabs
 * 
 * @package jTabs  
 * @version 1.0.0
 * @access public
 */

class tabs {
  var $name;
  var $tabs;
  var $active;
  var $current;

  function __construct($name) {
    $this->name = $name;
  }

  function start($name) {
    if (empty($this->active)) {
      $this->active = $name;
    }
    $this->current = $name;
    ob_start();
  }

  function end() {
    $this->tabs[$this->current] = ob_get_contents();
    ob_end_clean();
  }

  function run() {
    if (count($this->tabs) > 0) {
      $jsClear = "";
      //$tabname = preg_replace('/[^a-zA-Z0-9]/', '', $tabname);
      echo "<script type=\"text/javascript\">\n";
      echo "$(function() {\n";
      echo "$('#" . $this->name . "').tabs();\n";
      echo "});\n";
      echo "</script>\n";
      echo '<div id="' . $this->name . '">' . "\n";
      echo '<ul>' . "\n";
      foreach ($this->tabs as $tabname => $tabcontent) {
        $tabid = preg_replace('/[^a-zA-Z0-9]/', '', $this->name);
        $tabname1 = preg_replace('/[^a-zA-Z0-9]/', '', $tabname);
        $contentid = 'content-' . $tabid . '-' . $tabname1 . '';
        echo '<li><a href="#' . $contentid . '"><span>' . $tabname . '</span></a></li>' . "\n";
      }
      echo '</ul>' . "\n";
      foreach ($this->tabs as $tabname => $tabcontent) {
        $tabid = preg_replace('/[^a-zA-Z0-9]/', '', $this->name);
        $tabname = preg_replace('/[^a-zA-Z0-9]/', '', $tabname);
        $contentid = 'content-' . $tabid . '-' . $tabname . '';
        echo '<div id="' . $contentid . '">' . $tabcontent . '</div>' . "\n";
      }
      echo '</div>' . "\n"; // End Main Container
      echo '<div style="clear: both;"></div>' . "\n";
    }
  }
}

// Example Implementation
/*
$tabs->start( 'Tab1' );
echo 'Some Content';
$tabs->end();
$tabs->run();

*/

?>