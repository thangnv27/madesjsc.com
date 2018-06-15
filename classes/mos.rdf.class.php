<?php
// $Id: mos.rdf.class.php,v 1.8 2004/01/29 21:09:06 rcastley Exp $
/**
* MOS RDF Class
* @package Mambo Open Source
* @Copyright (C) 2000 - 2003 Miro International Pty Ltd
* @ All rights reserved
* @ Mambo Open Source is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: 1.8 $
**/

defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
require_once($mainframe->getCfg( 'absolute_path' ) . "/classes/rdf.class.php");

class mosRDF extends fase4_rdf {
	var $mosContent = "";
	
	function mosRDF() {
		parent::fase4_rdf();
	}
	
	function cache() {
		global $database;
		
		if($this->_use_dynamic_display == true) {
			$this->_cached_file = md5("dynamic".$this->_remote_file);
			$this->_cache_type = "normal";
		} else {
			$this->_cached_file = md5($this->_remote_file);
			$this->_cache_type = "fast";
		}
		
		$_cache_f = $this->_cached_file;
		$cache_time = $this->_refresh;
		
		// remove outdated items
		$sql =  "DELETE FROM #__newsfeedscache WHERE time < '$cache_time'";
		$database->setQuery($sql);
		
		if(!$result	= $database->query()) {
			die($database->stderr(true));
		}
		
		$sql =  "SELECT filedata,time FROM #__newsfeedscache WHERE cachefile='$_cache_f' and time > '$cache_time'";
		$database->setQuery($sql);
		
		if(!$result	= $database->query()) {
			die($database->stderr(true));
		}
		
		if ( $database->getNumRows($result) == 0) {
			// We have to parse the remote file
			$this->_use_cached_file = false;
			// we want to provide proper Information for Use in get_cache_update_time()
			clearstatcache();
			if($this->_use_dynamic_display == true) {
				$_rdf = @implode(" ", $this->_rdf_data()); // -> proxy
				if(!$_rdf) {
					$this->_throw_exception( $this->_remote_file." is not available" );
				}
				$this->_parse_xRDF( $_rdf );
				$this->_update_cache( $_rdf );
				$data = $this->_output;
			} else {
				$_rdf = @implode(" ", $this->_rdf_data()); // -> proxy
				if(!$_rdf) {
					$this->_throw_exception( $this->_remote_file." is not available" );
				}
				$this->_parse_xRDF( $_rdf );
				$this->_update_cache( $this->_output );
				$data = $this->_output;
			}
		} else {
			// we can use the cached file
			$this->_use_cached_file = true;
			// Get data from DB
			$database->loadObject($row);
			if($this->_use_dynamic_display == true) {
				$this->_parse_xRDF($row->filedata);
				$data = $this->_output;
			} else {
				$data = $row->filedata;
			}
		}
		return trim($data);
	}
	
	
	function _update_cache( $content = "" ) {
		global $database;
		
		$content		= addslashes($content);
		$_cached_file	= $this->_cached_file;
		$currtime = time();
		
		$sql = "INSERT INTO #__newsfeedscache (time,filedata,cachefile) VALUES ('$currtime','$content','$_cached_file') ";
		$database->setQuery($sql);
		if(!$result	= $database->query()) {
			die($database->stderr(true));
		}
		return true;
	}
	
	function parse_RDF( $rdf ) {
		unset($this->_array_item);
		$this->_remote_file = $rdf;
		$this->mosContent = "<!-- http://www.fase4.com/rdf/ -->\n";
		$this->mosContent .= "<table width=\"".$this->_table_width."\">\n";
		$this->mosContent .= $this->cache();
		$this->mosContent .= "</table>\n";
		unset($this->_output);
		$this->_item_count = 0;
		return true;
	}
	
	function getMosContent() {
		return $this->mosContent;
	}
	
	function get_cache_update_time() {
		global $database, $mosConfig_offset;
		$sql	= "SELECT time FROM #__newsfeedscache where cachefile='" . $this->_cached_file . "' ORDER BY time DESC";
		$database->setQuery($sql);
		if(!$result	= $database->query()) {
			die($database->stderr(true));
		}
		return strftime ("%a, %d %b %Y %H:%M", ($database->loadResult()+($mosConfig_offset*60*60)));
	}   // END get_cache_update_time()
	
	function _throw_exception( $msg ) {
		return true;
	}
}
?>
