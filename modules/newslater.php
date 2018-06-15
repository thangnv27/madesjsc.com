<?php

//Nguyen Van Binh

//suongmumc@gmail.com



defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );


$email = clean_value($_POST['email']);
if($email){
	$sql = "SELECT * FROM newsletter WHERE email = '".$email."'";
	$db = $DB->query($sql);
	if(mysql_num_rows($db)<=0){
		$DB->query("INSERT INTO newsletter(email,name) VALUES('".$email."','".$name."')")	;
	}

}

?>

