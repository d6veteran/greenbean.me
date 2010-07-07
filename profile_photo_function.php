<?php ob_start();	
	session_start();
	$action = $_GET['action'];
	$userId = $_SESSION['userid'];

	//print_r($_POST);
	if($action=='upload')
	 {	

		$upload_name = "file";
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
				$x = @getimagesize($_FILES[$upload_name]['tmp_name']);
				
				///////  Convert new image with the random number ///////
				$photo_newname = "0_".$userId."_".rand(1000, 9999).".".$file_ext;
				
				$new_photo_name = "uploads/".$photo_newname;
					
				 ////// Finding the old photo name to delete. ////////////
				  $Database = new DatabaseConnection();
				  $photo_query ="SELECT photo FROM user WHERE userid='{$userId}' LIMIT 1";
				  $Database->Query($photo_query);
				  $oldPhoto=$Database->Result(0,"photo");
				  
				////////////////////////////////////////////////////////////////////////

				if(move_uploaded_file($file_temp, $new_photo_name))
				{						
				   $objThumbnailClass = new Thumbnail($new_photo_name);
				   //$objThumbnailClass->save($new_photo_name);
				  if($x[0]>80){	
				  // $objThumbnailClass->resize(142);
						
				   $objThumbnailClass->cropFromCenter(80);
				  // $objThumbnailClass->save(realpath(getcwd()) . $new_photo_name,$quality=100);
				  $objThumbnailClass->show(100,$new_photo_name);
				  }else{
				    $objThumbnailClass->show(100,$new_photo_name);
				  }
				  
//**************************************** Cloud file storage for Relationfeed.com *****************************
				require_once('cloudfiles/cloudfiles.php');
				$USER_CLOUDFILES = $siteKey['cloud_file_user'];
				$API_KEY_CLOUDFILES = $siteKey['cloud_file_api_key'];
				
				$auth = new CF_Authentication($USER_CLOUDFILES, $API_KEY_CLOUDFILES);
				
				// bypass cURL's old CA bundle
				$auth->ssl_use_cabundle(); 
				$getauth=$auth->authenticate();
				$conn = new CF_Connection($auth);
				
				$conn->ssl_use_cabundle();
					
				$largerContainer = $conn->get_container("user_uploads");
				$laregerObj = $largerContainer->create_object($photo_newname);
				$laregerObj->load_from_filename($siteKey['server_doc_root_path']."uploads/".$photo_newname);
				unlink("uploads/".$photo_newname);

//************************************** End of Cloud file storage for Relationfeed.com *****************************
				 if($oldPhoto!=""){
						$largerContainer->delete_object($oldPhoto);
				 }
				  $photo_query ="UPDATE user SET photo='{$photo_newname}' WHERE userid='{$userId}' LIMIT 1";
				  $Database->Query($photo_query);
				   
					echo "{";
					echo		"msg: 'http://c0201361.cdn.cloudfiles.rackspacecloud.com/".$photo_newname."'\n";
					echo "}";
				
				}
			}	
	 }
?>