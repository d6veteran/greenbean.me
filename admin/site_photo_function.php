<?php /*ob_start();	

	session_start();*/
	
	//require_once("../includes/configuration.php");
	//require_once("../includes/classes/class.database.php");
	//require_once("../includes/classes/class.thumbnail.php");
	require_once "../config/functions.inc.php";
	$action = $_GET['action'];
	//$userId = $_REQUEST['userid'];
		
	//print_r($_POST);
	if($action=='upload')
	 {	

		$upload_name = "images";
		$max_file_size_in_bytes = 1024*1024*2;
		$extension_whitelist = array("jpg", "gif", "png");
				
		/* checking extensions */
		$path_info = pathinfo($_FILES[$upload_name]['name']);
		$file_extension = $path_info["extension"];


	 //chcking mime type	

    	if(getimagesize( $_FILES[$upload_name]['tmp_name'] ) == false ){
 
			echo "{";
			echo		"error: 'Invalid Files Type ( jpg, gif, png are allowed! )'\n";
			echo "}";
			exit(0);
		}

	
		$is_valid_extension = false;
		foreach ($extension_whitelist as $extension)
		{
			if (strcasecmp($file_extension, $extension) == 0)
			{
				$is_valid_extension = true;
				break;
			}
		}
		if (!$is_valid_extension)
		{
			echo "{";
			echo		"error: 'Extension not valid ( jpg, gif, png are allowed! )'\n";
			echo "}";
			exit(0);
		}
		
		/* file size check */
		$file_size = filesize($_FILES[$upload_name]["tmp_name"]);
		if ( !$file_size || $file_size > $max_file_size_in_bytes) {
			echo "{";
			echo		"error: 'File Exceeds maximum limit of 2 MB!'\n";
			echo "}";
			exit(0);
		}
		
		
		if(isset($_FILES[$upload_name]))
			if ($_FILES[$upload_name]["error"] > 0)
			{
				echo "error: " . $_FILES["file"]["error"] . "<br />";
			} 
			else
			{
				//$userfile = stripslashes($_FILES[$upload_name]['name']);
				//$path_info = pathinfo($_FILES[$upload_name]['name']);
				$file_ext = $path_info["extension"];
				$file_size = $_FILES[$upload_name]['size'];
				$file_temp = $_FILES[$upload_name]['tmp_name'];
				$file_type = $_FILES[$upload_name]["type"];
				$file_err = $_FILES[$upload_name]['error'];
				
				///////  Convert new image with the random number ///////
				$photo_newname = "0_".$userId."_".rand(1000, 9999).".".$file_ext;
				
				$new_photo_name = "../uploads/".$photo_newname;
					
				 ////// Finding the old photo name to delete. ////////////
				  /*$Database = new DatabaseConnection();
				  $photo_query ="SELECT photo FROM user WHERE userid='{$userId}' LIMIT 1";
				  $Database->Query($photo_query);
				  $oldPhoto=$Database->Result(0,"photo");*/
				  
				////////////////////////////////////////////////////////////////////////

				if(move_uploaded_file($file_temp, $new_photo_name))
				{						
				   /*$objThumbnailClass = new Thumbnail($new_photo_name);
				  
				   $objThumbnailClass->resize(142);
						
				   $objThumbnailClass->cropFromCenter(80);
				   $objThumbnailClass->save(realpath(getcwd()) . $new_photo_name,$quality=100);
				  $objThumbnailClass->show(100,$new_photo_name);*/
				   /*if($oldPhoto!="")
				   	unlink("uploads/".$oldPhoto);	
					
*/


//************************************************************** Cloud file storage for Relationfeed.com *****************************
				/*require_once('../cloudfiles/cloudfiles.php');
				$USER_CLOUDFILES = "relationfeed";
				$API_KEY_CLOUDFILES = "713884f0a9718886503d838e5cfa55be";
				
				$auth = new CF_Authentication($USER_CLOUDFILES, $API_KEY_CLOUDFILES);
				
				$auth->ssl_use_cabundle(); # bypass cURL's old CA bundle
				$getauth=$auth->authenticate();
				$conn = new CF_Connection($auth);
				
				$conn->ssl_use_cabundle();
				
				
				$largerContainer = $conn->get_container("user_uploads");
				$laregerObj = $largerContainer->create_object($photo_newname);
				$laregerObj->load_from_filename("/mnt/stor1-wc1-dfw1/413415/www.relatious.com/web/content/uploads/".$photo_newname);*/

//******************************************************* End of Cloud file storage for Relationfeed.com *****************************
	
					/*$photo_unlink="select photo from user where userid='$userId'";
					$name=mysql_query($photo_unlink)or die(mysql_error());
					$getname=mysql_fetch_array($name);
					if($getname[0]!='')
					{
						unlink("../uploads/".$getname[0]);
					}*/
					
					
					
				   $photo_query ="insert into fd_backgroundimages(name) values('".$photo_newname."')";
				   //executequery($photo_query);
				   mysql_query($photo_query)or die(mysql_error());

					echo "{";
					echo		"msg: '".$photo_newname."'\n";	//"msg: '".$new_photo_name."'\n";				
					echo "}";

					
					
				}
			}	
	 }
?>