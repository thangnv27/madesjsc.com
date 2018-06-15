<?php 

// Nguyen Binh

// suongmumc@gmail.com 

// error_reporting(E_ALL);

defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );

class dbStatic{

	function getInWhere($inwhere){

		global $DB;

		$sql = "SELECT * FROM static WHERE inwhere='$inwhere'";

		$db = $DB->query($sql);

		$rs = mysql_fetch_array($db);

		return $rs['content'];

	}

        

	function copyright(){

		global $DB;

		$sql = "SELECT * FROM static WHERE inwhere='copyright'";

		$db = $DB->query($sql);

		$rs = mysql_fetch_array($db);

		return $rs;

	}
	
	function page404(){

		global $DB;

		$sql = "SELECT * FROM static WHERE inwhere='page404'";

		$db = $DB->query($sql);

		$rs = mysql_fetch_array($db);

		return $rs;

	}
	function thanhtoan_hotro(){

		global $DB;

		$sql = "SELECT * FROM static WHERE inwhere='thanhtoan_hotro'";

		$db = $DB->query($sql);

		$rs = mysql_fetch_array($db);

		return $rs;

	}
	
	function textFooter(){

		global $DB;

		$sql = "SELECT * FROM static WHERE inwhere='footer'";

		$db = $DB->query($sql);

		$rs = mysql_fetch_array($db);

		return $rs;

	}

	function muahangtuxa(){

		global $DB;

		$sql = "SELECT * FROM static WHERE inwhere='muahangtuxa'";

		$db = $DB->query($sql);

		$rs = mysql_fetch_array($db);

		return $rs;

	}
	function addressphone(){

		global $DB;

		$sql = "SELECT * FROM static WHERE inwhere='addressphone'";

		$db = $DB->query($sql);

		$rs = mysql_fetch_array($db);

		return $rs;

	}
	
	function generalproduct(){

		global $DB;

		$sql = "SELECT * FROM static WHERE inwhere='generalproduct'";

		$db = $DB->query($sql);

		$rs = mysql_fetch_array($db);

		return $rs;

	}


	function fanpage(){

		global $DB;

		$sql = "SELECT * FROM static WHERE inwhere='fanpage'";

		$db = $DB->query($sql);

		$rs = mysql_fetch_array($db);

		return $rs;

	}

	function textChapnhanthanhtoan(){

		global $DB;

		$sql = "SELECT * FROM static WHERE inwhere='thanhtoan'";

		$db = $DB->query($sql);

		$rs = mysql_fetch_array($db);

		return $rs;

	}

}

?>