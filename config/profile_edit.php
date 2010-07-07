<?PHP
	session_start();
	
	require_once("includes/configuration.php");
	require_once("includes/classes/class.database.php");
	require_once("includes/classes/class.question.php");
	require_once("includes/classes/class.user.php");
	require_once("includes/classes/class.country.php");
	require_once "includes/fileoperation.php";

	$objMember = new user();
	$objCountry = new country();
	
	if($_SESSION['user_name']==''){ 
			header("location:index.php");
			
		}
	
	

	if($_SESSION['languageid'] == '' || $_SESSION['languageid'] == 0) {
		for($i=0;$i<count($rsLanguage);$i++) {
			if($rsLanguage[$i]->language_name == "English") {
				$language_id = $rsLanguage[$i]->languageId;
			}
		}
	}
	else {
		$language_id = $_SESSION['languageid'];
	}

	if(!$_POST['userid']) {
		$userid1 = $_SESSION['user_id'];
	}
	else {
		$userid1 = $_SESSION['user_id'];
	}

	if($_POST['cmdUpdate']=='Update'){
		$objMember->userId=($userid1);
		
		$objMember->first_name=$_POST['txtfname'];
		$objMember->last_name=$_POST['txtlname'];
		$objMember->emailid=$_POST['txtmail'];
		$objMember->address=$_POST['txtAddress'];
		$objMember->city=$_POST['txtcity'];
		$objMember->state=$_POST['txtstate'];
		$objMember->zipcode=$_POST['txtzip'];
		$objMember->countryid=$_POST['cmbCountry'];
		$objMember->languageid=$_POST['cmbLanguage'];
		$objMember->username=$_POST['txtusername'];
		$objMember->password=$_POST['txtpassword'];

		if($_FILES['txtphoto']['name'] != '') {
			$type = explode("/",$_FILES['txtphoto']['type']);
			if($type[0] == 'image') {
				resizeimage($_FILES['txtphoto'],"uploads/user");
				$objMember->photo=$_FILES['txtphoto']['name'];
			}
		}
		else {
			$objMember->photo = $_POST['txtOldImage'];
		}
		if($_POST['radActive']=='Active'){
			$objMember->status='1';
		}else{
			$objMember->status='1';
		}
		if($_POST['txtpassword']==$_POST['txtRpassword']){
			$objMember->password=$_POST['txtpassword'];
			$_POST['cmdAdd']='';
			$id=$objMember->Save();
			$msg="Record updated successfully.";
			
		}
		else{
			$msg="Retype Password and Password both must be same.";
		}
	}
	$rsEditMember = $objMember->GetList(array(array('user_id','=',$userid1)),'user_name',false);
	//print_r($rsEditMember);

	$rsCountry = $objCountry->GetList(array(array('countrylevel','=',0)),'',true);
?>

		<?php include("includes/header.php");?>
		
        
<script src="js/jquery.validate.js" type="text/javascript"></script>
<script src="js/jquery.hint.js" type="text/javascript"></script>
<script src="js/settings.js" type="text/javascript"></script>     


<script type="text/javascript">
$(document).ready(function() {
	$("#frmCrRegister").validate({
		rules: {
			
			txtusername: { 
                required: true, 
                minlength: 3, 
			    remote: "check_user_edit.php" ,				
            }, 
			
			txtmail: {
				email: true,
				remote: "check_email_edit.php" 
			},
			topic: {
				required: "#newsletter:checked",
				minlength: 2
			},
			captcha: {
				required: true,
				//remote: "captcha_process.php"
			},
			agree: "required"
		},
		messages: {
			
			txtusername: { 
                required: "Enter a username", 
				minlength: jQuery.format("Enter at least {0} characters"),				
                remote: jQuery.format("{0} is already in use or not a valid user name") 
            },
			txtmail: {
				required:"Please enter a valid email address",
				remote: jQuery.format("{0} is already in use") 
			},
			confirm_email: {
				required: "Please provide a valid email address",
				equalTo: "Please enter the same email as above"
			},
			captcha: "Please enter correct captcha",
			agree: "Please accept our policy"
		}
	});
});

 // check for unwanted characters




</script>


<div style="width:100%; float:left; height:100%; background-color:#299dd7; padding-top:15px;">
<div id="innerwrapper">

<div id="inn-bdywrapper">
         <div class="wht_main">
<div class="wm-tl"><div class="wm-tr"></div></div>
<div class="wm-area1">	
			<form name="frmCrRegister" id="frmCrRegister" method="post" enctype="multipart/form-data" action="profile_edit.php" >
			<div id="myaccount-lft">
            <div class="wht2_top2"><div class="wht2_tl"><div class="wht2_tr"></div><?=$msg;?></div></div>
            <div class="wht2_body2 ">
              	<div class="inhead">
                	<h2 class="blk18">Fill-out the form below</h2>
                </div>
                <div class="regi_row_d1">
                  <div class="reg-formlft2">Full name: </div>
            
                <div class="telephone-new">
                <input type="text" name="txtfname" id="txtfname" value="<?=$rsEditMember[0]->first_name;?>"  class="inp_shad3" title="Full name"/>
                 
               
                </div>
                
                </div>
                <div class="regi_row_d1">
                  <div class="reg-formlft2">
                    <div>
                      <div>User name </div>
                    </div>
                  </div>
            
                <div class="telephone-new">
                  <input type="text" name="txtusername" id="txtusername" value="<?=$rsEditMember[0]->username;?>"  class="inp_shad3" onKeyUp="twitter.updateUrl(this.value)" title="User name"/>
                            <br>
							   <span class="gry11d">Your URL:</span><span class="gry11"> http://Frendli.com/<span id="username_url"  style="color:#006600; font-weight:bold;"><?=$rsEditMember[0]->username;?></span></span>
               
                </div>
                
                </div>
                <div class="regi_row_d1">
                  <div class="reg-formlft2">
                    <div>
                      <div>Email</div>
                    </div>
                  </div>
            
                <div class="telephone-new">
                    <input type="text" name="txtmail" id="txtmail" value="<?=$rsEditMember[0]->emailid;?>" class="inp_shad3" title="Please enter a valid email address" />
               
                </div>
                
                </div>
                <div class="regi_row_d1">
                  <div class="reg-formlft2">
                    <div>
                      <div>City</div>
                    </div>
                  </div>
            
                <div class="telephone-new">
                     <input type="text" name="txtcity" id="txtcity" value="<?=$rsEditMember[0]->city;?>" class="inp_shad3"/>
               
                </div>
                
                </div>
                <div class="regi_row_d1">
                  <div class="reg-formlft2">
                    <div>
                      <div>State</div>
                    </div>
                  </div>
            
                <div class="telephone-new">
                      <input type="text" name="txtstate" id="txtstate" value="<?=$rsEditMember[0]->state;?>" class="inp_shad3"/>
               
                </div>
                
                </div>
                
                
                <div class="regi_row_d1">
                  <div class="reg-formlft2">
                    <div>
                      <div>Country</div>
                    </div>
                  </div>
            
                <div class="telephone-new">
                    <select name="cmbCountry" class="inp_shad3">
                        <?PHP 
								for($i=0;$i<count($rsCountry);$i++){
									if($rsCountry[$i]->countryId==$rsEditMember[0]->countryid){
								?>
                        <option value="<?=$rsCountry[$i]->countryId;?>" selected="selected"><?=$rsCountry[$i]->countryname;?></option>
                        <?PHP 
									}else{?>
                        <option value="<?=$rsCountry[$i]->countryId;?>"><?=$rsCountry[$i]->countryname;?></option>
                        <?PHP 
									}					  
								} ?>
                      </select>
               
                </div>
                
                </div>
                
              <div class="regi_row_d1">
                  <div class="reg-formlft2">
                    <div>
                      <div></div>
                    </div>
                  </div>
            
                <div class="telephone-new">
                
                <input type="hidden" name="cmdUpdate" value="Update" id="cmdUpdate" />
                <input type="image" src="images/submit.gif" alt="create-password" width="104" height="29" />
                </div>
                
                </div>
            
            </div>
            <div class="wht2_bot2"><div class="wht2_bl"><div class="wht2_br"></div></div></div>
            </div>
            </form>
        	<?php include("includes/right.php");?>    
            
           </div>

          </div>
          <div class="wm-bl"> <div class="wm-br"> </div></div>

            </div>
</div>

      <script type="text/javascript">


      $( function () {
        
  twitter.screenNameKeyUp();
  $('#user_screen_name').focus();

      });
    

</script>
	<?php include("includes/footer.php");?>