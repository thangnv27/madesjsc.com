
<div class="wraper-content">
  <div style="max-height:500px; overflow:auto">
    <?php 
defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
error_reporting(0);
	include('../conf.php');
	$dir='';
	$dir.='temp'; 
	$dir_cache_file = '..'.$cache_image_path;
	$cleartime = $clearcachetime;
	//Put the date you want to compare with in the format of:  YYYY-mm-dd hh:mm:ss
	$comparedatestr=date("Y-m-d 23:00:00",$cleartime);
	$comparedate=strtotime($comparedatestr);
	//I run the function here to start the search. 
	directory_tree($dir_cache_file,$comparedate);
//	directory_tree($dir,$comparedate);
	//This is the function which is doing the search...
	function directory_tree($address,$comparedate){ 
	 @$dir = opendir($address); 
	  if(!$dir){ return 0; } 
	  		$i=0;
	        while($entry = readdir($dir)){ 
	                if(is_dir($address.$entry) && ($entry != ".." && $entry != ".")){                             
	                        directory_tree($address.$entry.$comparedate);
	                } 
	                 else   {
	                  if($entry != ".." && $entry != ".") {
	                    $fulldir=$address.$entry;
	                    $last_modified = filemtime($fulldir);
	                    $last_modified_str= date("d/m/Y H:i", $last_modified);
	                       if($comparedate >= $last_modified)  {
							 unlink($fulldir);
	                         echo $fulldir.'=>'.$last_modified_str;
	                         echo "=>Đã xóa <BR>";							 
							 $i++;
	                       }
	
	                 }
	
	            }
	      } 
		  echo "<hr>Đã xóa xong ".$i." files temp !";
	
}

?>
  </div>
</div>
