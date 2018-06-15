<?php
error_reporting(0);
$modified = 0;
//$files = 'style.css';
$files = array(
	  './flexslider.css',
	  './jquery.mmenu.all.css',
	  './hover.css',
	  './binh_style.css',
	   './style.css'
	  
	);

    

foreach($files as $file) {        
    $age = filemtime($files);
    if($age > $modified) {
        $modified = $age;
    }
}

header ('Expires: ' . gmdate ("D, d M Y H:i:s", time() + $offset) . ' GMT');
header ('Cache-Control: max-age=' . $offset);
    header ('Content-type: text/css; charset=UTF-8');
    header ('Pragma:');
    header ("Last-Modified: ".gmdate("D, d M Y H:i:s", $modified )." GMT");
  header('Content-type: text/css');
  ob_start("compress");
  function compress($buffer) {
    /* remove comments */
   // $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
    /* remove tabs, spaces, newlines, etc. */
    //$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
	$buffer = preg_replace("/((?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:\/\/.*))/", "", $buffer);
        /* remove tabs, spaces, newlines, etc. */
        $buffer = str_replace(array("\r\n","\r","\t","\n"), '', $buffer);
        /* remove other spaces before/after ) */
        $buffer = preg_replace(array('(( )+\))','(\)( )+)'), ')', $buffer);
    return $buffer;
  }
	
  /* your css files */
  //	include($files);
	foreach($files as $file) {
		include($file);
	}

  ob_end_flush();
?>