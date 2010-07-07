<script type="text/javascript">
<!--
window.onload = function () {initialize();}
// -->
</script>

<script type="text/javascript">
		$(document).ready(function() {	
		$(".change_user_image").fancybox({
				'width'				: '50%',
				'height'			: '50%',
				'autoScale'			: false,
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
		});
	</script>
    
<script src="<?=base_url();?>public/js/jquery.validate.js" type="text/javascript"></script>


<script type="text/javascript">
$(document).ready(function() {
	// validate signup form on keyup and submit
	$("#profile_settings").validate({
		rules: {
			firstname: "required",
			lastname: "required",
			username: {
				required: true,
				minlength: 5,
				remote: "<?=base_url()?>users.php"
			},			
			user_email: {
				required: true,
				email: true,
				remote: "<?=base_url()?>emails.php"
			}
		},
		messages: {
			firstname: "Please enter your firstname",
			lastname: "Please enter your lastname",
			username: {
				required: "Enter a username",
				minlength: jQuery.format("Enter at least {0} characters"),
				remote: jQuery.format("User Name already in use.")
			},			
			user_email: {
				required: "Please enter a valid email address",
				minlength: "Please enter a valid email address",
				remote: jQuery.format("Email is already in use")
			}
		}
	});
	
	
	
	// propose username by combining first- and lastname
	$("#username").focus(function() {
		var firstname = $("#firstname").val();
		var lastname = $("#lastname").val();
		if(firstname && lastname && !this.value) {
			this.value = firstname + "." + lastname;
		}
	});

});
</script>

<script language="javascript">
 function ajaxPhotoUpload()
	{
			//alert($("#file").val);
			
			$("#loading").ajaxStart(function(){
			$("#loading").show();
		    $("#error_msg_photo").show();
			$("#buttonUpload").hide();
			//$("#uploadImageDiv").show();
		}).ajaxComplete(function(){
			  $("#loading").hide();
			  //$("#uploadImageDiv").hide();
		});
		
		if($("#file").val=="")
			{
				document.getElementById('error_msg_photo').innerHTML="Select file to upload."; 
				$("#buttonUpload").show();
				return false;
			}
			
		$.ajaxFileUpload
		({
				
				url:'<?=base_url()?>profile_photo_function.php?action=upload',
				secureuri:false,
				fileElementId:'file',
				dataType: 'json',

				success: function (data, status)
				{
					if(typeof(data.error) != 'undefined')
					{
						if(data.error != '')
						{
							document.getElementById("error_msg_photo").innerHTML=data.error;
							$("#error_msg_photo").show();
							$("#buttonUpload").show();
							return false;
						}
					}
					document.getElementById("profile_image").src=data.msg;	
					document.getElementById("profile_image1").src=data.msg;	
					document.getElementById("profile_image_loading").src=data.msg;
/*					document.getElementById("loading2").src=data.msg;
					document.getElementById("loading3").src=data.msg;
*/					$("#uploadImageDiv").hide();
					$("#buttonUpload").show();
					return true;
				}		
		})
		
	}
</script>

<SCRIPT TYPE="text/javascript" LANGUAGE=JAVASCRIPT>
<!--
//------------------------------------------/
// Code from http://www.buddyhut.com
//------------------------------------------/
function checkCheckBoxes(ctype) {
	//alert(ctype);
	if(ctype=='facebook'){
	if (document.getElementById("facebook_setting").checked == true)
		{
		FB.Connect.requireSession(function() { facebook_settings(); }); return 
false;
		
		}
	}
if(ctype=='twitter'){
if (document.getElementById("twitter_setting").checked == true)
		{
		window.document.location="<?=base_url()?>twitter_connect.php?act=twitter";
		
		}
}

	}
//-->
</SCRIPT>

<script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=ABQIAAAAbYDMPvPfH01KcEEFs9olPBQZfuxmoXTSFgo5aYWQAfR38m7F5xStHB-0TrfPBXxUIOVqDb1TmZWgew" type="text/javascript"></script>

<script type="text/javascript">



    var map;

    var geocoder;



    function initialize() {

      map = new GMap2(document.getElementById("map_canvas"));

      map.setCenter(new GLatLng(34, 0), 14);

      geocoder = new GClientGeocoder();

    }



    // addAddressToMap() is called when the geocoder returns an

    // answer.  It adds a marker to the map with an open info window

    // showing the nicely formatted version of the address and the country code.

    function addAddressToMap(response) {

      map.clearOverlays();

      if (!response || response.Status.code != 200) {

       // alert("Sorry, we were unable to geocode that address");

		document.forms[0].user_location.value = '';

		document.getElementById('msgCtr').style.display="block";

		document.getElementById('msgCtr').innerHTML='<img align="absmiddle" class="icon" border="0" src="./images/error.gif"/> <strong>The location you provided could not be found. Please try again.</strong>';

		return false;

		

		

		// Sorry, we were unable to geocode that address

      } else {	  

        place = response.Placemark[0];

        point = new GLatLng(place.Point.coordinates[1],

                            place.Point.coordinates[0]);

        marker = new GMarker(point);

        map.addOverlay(marker);	

		document.getElementById('msgCtr').innerHTML='';

		document.forms[0].user_location.value = place.address ;

		document.forms[0].user_location.style.background = 'SpringGreen';
		document.forms[0].q2.value =place.AddressDetails.Country.CountryNameCode;
		document.forms[0].q3.value =place.Point.coordinates[1];
		document.forms[0].q4.value =place.Point.coordinates[0];
		document.forms[0].q5.value =place.AddressDetails.Country.CountryName;
		document.forms[0].city_name.value=place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.SubAdministrativeAreaName;
if(place.AddressDetails.Country.AdministrativeArea != null)

 {
   document.forms[0].q6.value =place.AddressDetails.Country.AdministrativeArea.AdministrativeAreaName;
           if(place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea != null) 

		        {
			document.forms[0].q7.value =place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.SubAdministrativeAreaName;			

			           if(place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality != null) 				   

					   {

			document.forms[0].q8.value =place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.LocalityName;		

		               } 	
					   
					   
					   					   

	        	} 
				else

{
document.getElementById('msgCtr').style.display="block";

document.getElementById('msgCtr').innerHTML='<img align="absmiddle" class="icon" border="0" src="./images/error.gif"/> <strong>Please enter your city or county in addition to your state.</strong>';

return false;

}		

}else{
document.getElementById('msgCtr').style.display="block";
document.getElementById('msgCtr').innerHTML='<img align="absmiddle" class="icon" border="0" src="./images/error.gif"/> <strong>Please enter your city or county in addition to your state.</strong>';
return false;
} marker.openInfoWindowHtml(place.address + '<br>' +

          '<b>Country code:</b> ' + place.AddressDetails.Country.CountryNameCode);
document.frmPost.submit();
}
}
function addAddressToMap1(response) {
	map.clearOverlays();

      if (!response || response.Status.code != 200) {

       // alert("Sorry, we were unable to geocode that address");

		document.forms[0].user_location.value = '';

		document.getElementById('msgCtr').style.display="block";

		document.getElementById('msgCtr').innerHTML='<img align="absmiddle" class="icon" border="0" src="./images/error.gif"/> <strong>The location you provided could not be found. Please try again.</strong>';

		return false;
		} else {
		place = response.Placemark[0];

        point = new GLatLng(place.Point.coordinates[1],

                            place.Point.coordinates[0]);

        marker = new GMarker(point);

        map.addOverlay(marker);

		document.getElementById('msgCtr').innerHTML='';

		document.forms[0].user_location.value = place.address ;

		document.forms[0].user_location.style.background = 'SpringGreen';
		document.forms[0].q2.value =place.AddressDetails.Country.CountryNameCode;
		document.forms[0].q3.value =place.Point.coordinates[1];
		document.forms[0].q4.value =place.Point.coordinates[0];
		document.forms[0].q5.value =place.AddressDetails.Country.CountryName;
		document.forms[0].city_name.value=place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.SubAdministrativeAreaName;
		if(place.AddressDetails.Country.AdministrativeArea != null)

 {
document.forms[0].q6.value =place.AddressDetails.Country.AdministrativeArea.AdministrativeAreaName;
if(place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea != null) 

		        {document.forms[0].q7.value =place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.SubAdministrativeAreaName;
				if(place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality != null) 
				{

			document.forms[0].q8.value =place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.LocalityName;

		

		               } 
					   

			

	        	} 

				else

{



document.getElementById('msgCtr').style.display="block";

document.getElementById('msgCtr').innerHTML='<img align="absmiddle" class="icon" border="0" src="./images/error.gif"/> <strong>Please enter your city or county in addition to your state.</strong>';

return false;

}

}

else

{



document.getElementById('msgCtr').style.display="block";

document.getElementById('msgCtr').innerHTML='<img align="absmiddle" class="icon" border="0" src="./images/error.gif"/> <strong>Please enter your city or county in addition to your state.</strong>';

return false;

}
        marker.openInfoWindowHtml(place.address + '<br>' +

          '<b>Country code:</b> ' + place.AddressDetails.Country.CountryNameCode);
     }

    }



    // showLocation() is called when you click on the Search button

    // in the form.  It geocodes the address entered into the form

    // and adds a marker to the map at that location.

    function showLocation() {

      var address = document.forms[0].user_location.value;

	address=address.split(' ').join('');



	if(address == '')

	{

	

	document.getElementById('msgCtr').style.display="block";

		document.getElementById('msgCtr').innerHTML='<img align="absmiddle" class="icon" border="0" src="./images/error.gif"/> <strong>Please enter your location.</strong>';

		document.frmPost.user_location.focus();

		return;

		

		}

      geocoder.getLocations(address, addAddressToMap);

    }

	

	  function showLocation1() {

	  

      var address = document.forms[0].user_location.value;

	  

	  address=address.split(' ').join('');
	 

      geocoder.getLocations(address, addAddressToMap1);

    }



   // findLocation() is used to enter the sample addresses into the form.

    function findLocation(address) {

      document.forms[0].user_location.value = address;

      showLocation();

    }
</script>

<script type="text/javascript">
<!--
function confirmation() {
	var answer = confirm("Are you sure you want to do this ?.")
	if (answer){
		
		window.location = "<?=base_url();?>user/delete_my_account";
	}
	else{
		alert("Thanks for sticking around!")
	}
}
//-->
</script>


<div class="content-wp">

<div class="content-md">
<div class="edit-profile-wp"><h1>Edit Your Profile</h1>

<span style="text-align:center; color:#900"><?=$this->session->flashdata('success_msg');?></span>
<form name="profile_settings"  id="profile_settings" action="<?=base_url()?>user/updates" method="post">
<div class="ed-pr-in">
<div class="ed-pr-rw">
<div class="ed-pr-lt">
  <p>Username</p>
</div>
<div class="ed-pr-rt">
<input type="text" class="inp1" value="<?=$user_info['user_username']?>"  style="width:265px;" name="username"  id="username"/>

</div>

</div>
<div class="ed-pr-rw">
<div class="ed-pr-lt">
  <p>First Name</p>
</div>
<div class="ed-pr-rt">
<input type="text" class="inp1" value="<?=$user_info['user_first_name']?>"  style="width:265px;" name="firstname"  id="firstname" />
</div>

</div>
<div class="ed-pr-rw">
<div class="ed-pr-lt">
  <p>Last Name</p>
</div>
<div class="ed-pr-rt">
<input type="text" class="inp1" value="<?=$user_info['user_last_name']?>"  style="width:265px;" id="lastname" name="lastname" />
</div>

</div>
<div class="ed-pr-rw">
<div class="ed-pr-lt">
  <p>Email</p>
</div>
<div class="ed-pr-rt">
<input type="text" class="inp1" value="<?=$user_info['user_email']?>" style="width:265px;" name="user_email" id="user_email" />
</div>

</div>
<div class="ed-pr-rw">
  <div class="ed-pr-lt">
    <p>Location</p>
  </div>
  <div class="ed-pr-rt">
  <?
  if ($user_info['user_location']!=""){
  $location_info=$this->functions->show_location_name($user_info['user_location']); 
  $location_value=$location_info[0]['city'].",".$location_info[0]['region_name'].",".$location_info[0]['country_name'];
  }else{
	  $location_value="";
  }
  ?>
  
    <input type='text' class='inp1' name='user_location' id='user_location' value='<?=$location_value?>' maxlength='100' style="width:265px;" onblur="showLocation1(); " >

				

                              <input type="hidden" name="q2"  id="q2" value="" />

                              <input type="hidden" name="q3"  id="q3" value="" />

                              <input type="hidden" name="q4"  id="q4" value="" />

                               <input type="hidden" name="q5"  id="q5" value="" />

                              <input type="hidden" name="q6"  id="q6" value="" />

                              <input type="hidden" name="q7"  id="q7" value="" />

                                <input type="hidden" name="q8"  id="q8" value="" />								

                              <input type="hidden" name="q9"  id="q9" value="" />
                              
                              <input type="hidden" name="city_name"  id="city_name" value="" />

				 <span id="msgCtr" ><strong>  </strong></span>

  <div id="map_canvas" style="width: 300px; height: 250px; display:none;" ></div>
    
  </div>
</div>
<div class="ed-pr-rw">
  <div class="ed-pr-lt">
    <p>
    <img src="<?=base_url();?>public/checkresizeimg.php?src=user_image/<?=$user_info['user_photo']?>&w=67&h=67&zc=1" border="0" />
    </p>
  </div>
  <div class="ed-pr-rt"><a class='change_user_image' href="#user_login_box" style="text-decoration:underline;">Change your photo</a></div>
</div>
<div class="ed-pr-rw">
  <div class="ed-pr-lt">
    <p>Post to</p>
  </div>
  <div class="ed-pr-rt">
  <div class="ed-pr-post">
    <p><span class="gr13 ept">       
      <input type="checkbox" <? if($user_info['twitter_setting']=='Y'){?> checked="checked" <? }?> name="twitter_setting" id="twitter_setting" onchange="return checkCheckBoxes('twitter');"/>
    </span>Twitter</p>
  </div>
  <div class="ed-pr-post">
    <p><span class="gr13 ept">     
      <input type="checkbox" <? if($user_info['facebook_setting']=='Y'){?> checked="checked" <? }?> name="facebook_setting" id="facebook_setting" onchange="return checkCheckBoxes('facebook');" />
    </span>Facebook</p>
  </div>
  </div>
</div>
<div class="ed-pr-rw">
<div class="ed-pr-bt">
<input type="image" src="<?=base_url();?>public/images/update-my-account.jpg" />
<a href="javascript:voide(0);" onclick="confirmation()">
<img src="<?=base_url();?>public/images/delete-my-account.jpg" border="0" />
</a>
</div>
</div>
</div>
</form>
</div>

</div>
<div class="content-bt"></div>
</div>
<div style="display: none;">
<div id="user_login_box">
 <form id="form1" action="" method="post" enctype="multipart/form-data">
<div class="fb-head"><h1>Change your photo</h1></div>
<div class="fb-cnt">
<div class="fb-pic"> <img src="<?=base_url();?>public/checkresizeimg.php?src=user_image/<?=$user_info['user_photo']?>&w=67&h=67&zc=1" border="0" /></div>
<div class="fb-txt">
<input type="file" name="file" id="file" value="" />
<p>File size should not be more than 2MB</p>
<div align="center" id="error_msg_photo" style="display:none; color:#FF0000; font-size:10px;"></div>
</div>
</div>
<div class="fb-up-btn">
<input type="button" id="buttonUpload" value="Upload Image" onClick="ajaxPhotoUpload();" style="cursor:pointer"/>
</div>
</form>
</div>
</div>

<script type="text/javascript">
function facebook_settings()
{
FB.XFBML.Host.parseDomTree();
window.location.href='<?=base_url()?>facebookindexsettings.php';
}
</script>