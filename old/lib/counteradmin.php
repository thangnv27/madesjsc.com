<?php

	$counter=array();
	$day=date("j");
	
	$sql="SELECT * FROM today";
	$db=$DB->query($sql);
	if($rs=mysql_fetch_array($db)){
		$counter['today']=number_format($rs['value'],0,'.','.');
	}
	$sql="SELECT * FROM yesterday";
	$db=$DB->query($sql);
	if($rs=mysql_fetch_array($db)){
		$counter['yesterday']=number_format($rs['value'],0,'.','.');
	}
	$sql="SELECT * FROM count";
	$db=$DB->query($sql);
	if($rs=mysql_fetch_array($db)){
		$counter['total']=number_format($rs['value'],0,'.','.');
	}
?>