<script type="text/javascript">
<!--
window.onload = function () {initialize();}
// -->
</script>
<? $user_info=$this->functions->getUserInfo($userid);
/*echo "<pre>";
print_r($user_info);
die;*/
  $this->load->Model('Location_model');
  
   $user_update=$this->Location_Model->user_status_update_pagination($userid);

?>

<script type="text/javascript">
		$(document).ready(function() {	
		$(".login_box").fancybox({
				'width'				: '25%',
				'height'			: '25%',
				'autoScale'			: false,
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
		});
	</script>
 <? if (isset($_SESSION['userid'])){?>   
<script type="text/javascript">
 $(document).ready(function(){

$(".bean").click(function() 
{

var id = $(this).attr("id");
var user_id = <?=$_SESSION['userid']?>;
var name = $(this).attr("name");
var location_id=$('#voted_location_id_'+id).val();

var dataString = 'bean_req_id='+ id +"&user_id="+ user_id +"&location_id="+ location_id;
var parent = "show_bean"+id;

if(name=='up')
{

//$(this).fadeIn(200).html('<img src="dot.gif" align="absmiddle">');
$.ajax({
   type: "POST",
   url: "<?=base_url()?>user/do_bean",
   data: dataString,
   cache: false,

   success: function(html)
   {
	   if(html=="error"){
		   
	  	   alert('You have already voted on this bean.');		 
     	 
	   }else{
		$('p#'+ parent).html(html);   
	   }
  }  });
  
}
else
{

$(this).fadeIn(200).html('<img src="dot.gif" align="absmiddle">');
$.ajax({
   type: "POST",
   url: "down_vote.php",
   data: dataString,
   cache: false,

   success: function(html)
   {
       parent.html(html);
  }
   
 });


}
return false;
	});

});
</script>
<? }?>
<script type="text/javascript">
    $(document).ready(function(){
        //  Focus auto-focus fields
        $('.auto-focus:first').focus();
        
        //  Initialize auto-hint fields
        $('INPUT.auto-hint, TEXTAREA.auto-hint').focus(function(){
            if($(this).val() == $(this).attr('title')){ 
                $(this).val('');
                $(this).removeClass('auto-hint');
            }
        });
        
        $('INPUT.auto-hint, TEXTAREA.auto-hint').blur(function(){
            if($(this).val() == '' && $(this).attr('title') != ''){ 
                $(this).val($(this).attr('title'));
                $(this).addClass('auto-hint'); 
            }
        });
        
        $('INPUT.auto-hint, TEXTAREA.auto-hint').each(function(){
            if($(this).attr('title') == ''){ return; }
            if($(this).val() == ''){ $(this).val($(this).attr('title')); }
            else { $(this).removeClass('auto-hint'); } 
        });
    });
</script>
<script type="text/javascript">
  $(document).ready(function(){

	$('#inputField').bind("blur focus keydown keypress keyup", function(){recount();});
	$('input.submitButton').attr('disabled','disabled');

	$('#tweetForm').submit(function(e){

		tweet();
		e.preventDefault();

	});

});

function recount()
{
	var maxlen=100;
	var current = maxlen-$('#inputField').val().length;
	$('.counter').html(current);

	if(current<0 || current==maxlen)
	{
		$('.counter').css('color','#D40D12');
		$('input.submitButton').attr('disabled','disabled').addClass('inact');
	}
	else
		$('input.submitButton').removeAttr('disabled').removeClass('inact');

	if(current<10)
		$('.counter').css('color','#D40D12');

	else if(current<20)
		$('.counter').css('color','#5C0002');

	else
		$('.counter').css('color','#cccccc');

}

function tweet()
{
	var submitData = $('#tweetForm').serialize();

	$('#show_ajax').html('<img src="<?=base_url()?>public/images/ajax-loader.gif" alt="loading" width="16" height="16" />');

	$.ajax({
		type: "POST",
		url: "<?=base_url()?>user/status_update",
		data: submitData,
		dataType: "html",
		success: function(msg){

			if(parseInt(msg)!=0)
			{
				
			
				//$('ul.statuses li:first-child').before(msg);
				location.reload();
				//$("#ajax_result").prepend(msg);
				//
				//$('#lastTweet').html($('#inputField').val());
				//
				//$('#inputField').val('');
				//recount();
			}
		}

	});

}
  </script>
<script type="text/javascript">
       $(document).ready(function(){
               // add to tagger element by index
               $('.tagger').eq(0).addTag();              
        });
   </script>
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

			//document.forms[0].q8.value =place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.LocalityName;

		

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
function show_location()
   {
  
 
  $(".ed-pr-rw").toggle();
  } 
  
  </script> 
   
<script>
   function add_location()
     {
	    
		 var user_location_post=document.getElementById('user_location').value;
		 var q2=document.getElementById('q2').value;
		 var q5=document.getElementById('q5').value;
		  var q3=document.getElementById('q3').value;
		   var q4=document.getElementById('q4').value;
		 
		 
		 
	if(user_location_post!='')
	   {
	    $.post("<?=base_url();?>user/update_location", {user_location:user_location_post,q2:q2,q3:q3,q4:q4,q5:q5},
		   function(data){
			 $(".ed-pr-rw").hide();
			
		
			 
			 var pieces =data.split(",");

			 if(pieces.length==1)
			   {
			     alert("Please enter city name as well!");
				 $(".ed-pr-rw").show();
				 return;
			   }
			
			 var location_new=new Array();
			 
			 var i=0;
			 
			 while (i<=(pieces.length-2))
                  {
					  
					  location_new[i]=pieces[i];
					  i++;
                  }
			
			

			 //alert(pieces[pieces.length-1]);
			var new_loc=location_new.join(",");
			
			$('#location_new').html(new_loc);
			$('#geo_location_id').val(pieces[pieces.length-1]);

		   });
      }
	    else {
		 
		 alert("Please enter location name!");
		
		}
		 
	 }
  

</script>

<div class="content-wp">
  <!--<div class="content-tp"></div>-->
  <div class="content-md">
    <div>
      <div class="content-lt">
        <div class="profile-wp">
          <div class="profile-pic">
            <? if($user_info['user_photo']!=""){?>
            <img src="<?=base_url();?>public/checkresizeimg.php?src=user_image/<?=$user_info['user_photo']?>&w=67&h=&zc=1" border="0" />
            <? }else{ ?>
            <img src="<?=base_url();?>public/images/Greenbean-nopic.png" />
            <? }?>
          </div>
          <div class="profile-txt">
            <h3><a href="<?=base_url();?>user/profile/<?=$user_info['user_userid']?>">
              <?=$user_info['user_username']?>
              </a></h3>
          </div>
        </div>
        <? if(!isset($_SESSION['userid'])){?>
        <div class="cmt-wp" style=" padding-top:10px; padding-bottom:10px;"> <span> <a class='login_box' href="#user_login_box">Log in to request Green Beans</a> </span> </div>
        <? }elseif($_SESSION['userid']==$userid){?>
        <div id="show_request_box_div">
          <div class="cmt-wp" >
            <form id="tweetForm" action="<?=base_url()?>user/status_update" method="post">
              <p style="text-align:right; padding-bottom:5px;"><span id="show_ajax" style="display:inline-block;"></span> Request Green Beans (<span class="counter">100</span>)</p>
              <div class="cmt-bx">
                <textarea name="inputField" id="inputField" cols="45" rows="2" style="border:none; overflow:auto; overflow-x:hidden; padding:5px; width:406px; color:#737373; font-size:12px; font-family:Georgia, 'Times New Roman', Times, serif;" class="auto-hint" title="This is where you enter a new status update. . ."></textarea>
                <input type="hidden" name="user_id"  value="<?=$_SESSION['userid']?>" />
              </div>
              <span id="lastTweet"></span>
              <?
if ($user_info['user_location']!=""){
 $location_info=$this->functions->show_location_name($user_info['user_location']); 
 $location_value=$location_info[0]['city'].", ".$location_info[0]['region_name'].", ".$location_info[0]['country_name'];
}else{
	 $location_value=$geo_location[0]['region_name'].",".$geo_location[0]['city'];
	}
?>

<div style="float:left; position:relative;"><a href="javascript:void(0)" onclick="show_location()"><img src="<?=base_url();?>public/images/edit-loc.jpg" alt="Connect" height="31" border="0" id="fb_login_image"/></a>
<!--<div style="display:none;" id="drop_location">Location:<input type="text"/></div>-->
<div class="ed-pr-rw" style="display: none;">
     <p>Location:</p>

  <?
  if ($user_info['user_location']!=""){
  $location_info=$this->functions->show_location_name($user_info['user_location']); 
  $location_value=$location_info[0]['city'].",".$location_info[0]['region_name'].",".$location_info[0]['country_name'];
  }else{
	  $location_value="";
  }
  ?>
  

    <input type='text' class='inp1' name='user_location' id='user_location' value='<?=$location_value?>' maxlength='100' style="width:265px;" onblur="showLocation1(); " >  
<input type="button" value="Go" name="go"  onclick="return add_location();" />
 
				<input type="hidden"  name="user_username" id="user_username" value="<?=$user_info['user_username']?>" />
				<input type="hidden"  name="user_first_name" id="user_first_name"  value="<?=$user_info['user_first_name']?>" />
				<input type="hidden"  name="user_last_name" id="user_last_name"  value="<?=$user_info['user_last_name']?>" />
                <input type="hidden"  value="<?=$user_info['user_email']?>"  name="user_email" id="user_email" />
				<input type="hidden"  value="<?= $user_info['user_location']?>"  name="user_location_post" id="user_location_post" />
				

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






              <div class="cmt-check-bx">
                <? if($admin_tags){ 
foreach ($admin_tags as $value)
  {?>
                <div class="cmt-check">
                  <input type="checkbox" name="send_tags[]" id="tags_<?=$value->tag_id?>" value="<?=$value->tag_id?>" />
                  <?=$value->label?>
                </div>
                <? }}?>
              </div>
               <p   style="text-align:right; padding-bottom:10px;"><span id="location_new" style="color:#81290D; display:block; padding:2px 0 0 0;">
                <?=$location_value?>
                </span></p>
              <div class="add-tag">
                <div style="float:left;">
                  <input class="tagger inp" type="text" name="tags[]" style="width:295px;" />
                </div>
              </div>
              <div class="add-tag" style="text-align:right;">
                <input type="hidden" name="user_ip" value="<?=$user_ip?>" />
                <? if ($user_info['user_location']!=""){ ?>
                <input type="hidden" name="geo_location_id" value="<?=$user_info['user_location']?>" id="geo_location_id" />
                <? }else{?>
                <input type="hidden" name="geo_location_id" value="<?=$geo_location[0]['id']?>" id="geo_location_id" />
                <? }?>
                <input class="submitButton inact" name="submit" type="image" value="" />
              </div>
            </form>
          </div>
          <div id="ajax_result"></div>
        </div>
        <? }else{?>
        <div class="cmt-wp" style=" padding-top:10px; padding-bottom:10px;"> <span> <a href="<?=base_url();?>user/profile/<?=$_SESSION['userid']?>">Request More Green Beans.</a> </span> </div>
        <? } ?>
        <? if($user_update){ 
foreach ($user_update as $value)
  {?>
        <div class="vote-wp">
          <div class="vote-number">
            <div class="div-number-txt">
              <p id="show_bean<?=$value->update_id;?>">
                <?=$this->functions->count_all("gb_beans","bean_id","request_bean_id=$value->update_id");?>
              </p>
              <? if(!isset($_SESSION['userid'])){?>
              <span> <a class='login_box' href="#user_login_box">VOTE</a> </span>
              <? }else {?>
              <span><a href="javascript:void(0);" class="bean" id="<?=$value->update_id;?>" name="up">VOTE</a></span>
              <? }?>
              <input value="<?=$value->geo_location_id;?>" type="hidden" id="voted_location_id_<?=$value->update_id;?>" name="voted_location_id_<?=$value->update_id;?>" />
            </div>
          </div>
          <div class="vote-right">
            <div class="vote-txt">
              <p>
                <?=$this->functions->bb2html($value->update_body)?>
                <br />
                <span>
                <?=$this->functions->time_since(strtotime($value->status_update_date))?>
                <? 
 $tag_array=$this->functions->status_tags($value->update_id);
 
 if($tag_array){ 
 ?>
                -
                <?
 for($i=0;$i<sizeof($tag_array);$i++) {
 ?>
                <a href="<?=base_url()?>tags/<?=$tag_array[$i]['tag_name']?>/0" id="<?=$tag_array[$i]['tag_id']?>">#
                <?=$tag_array[$i]['tag_name']?>
                </a>
                <? }}?>
                </span> </p>
            </div>
          </div>
        </div>
        <? }}?>
		
		<div class="more-bot" style="padding-bottom:46px;" align="right">
<?php $page=$this->pagination->create_links2($this->uri->segment(3)); if( $page != "") echo "".$this->pagination->create_links2($this->uri->segment(3)); ?>
</div>	
      </div>
      <div style="display: none;">
        <div id="user_login_box"> <a href="javascript:void(0)" onclick="FB.Connect.requireSession(function() { update_user_box(); }); return 
false;" ><img id="fb_login_image" src="<?=base_url();?>public/images/f-connect.gif" alt="Connect" border="0"/></a> <a href="<?=base_url()?>twitter_connect"> <img src="<?=base_url()?>public/images/twitter-connect.jpg" width="150" height="22" /> </a> </div>
      </div>
      <div class="content-right">
        <div class="leaderboard-main">
          <div class="rank-tp">
            <h2>Rank</h2>
          </div>
          <div class="leaderboard-md">
            <div class="leaderboard-inner">
              <div class="leaderboard-li">
                <?
$rank_array=$this->functions->user_rank_bylocation($geo_location[0]['id'],$userid);

$rank_array_bytags=$this->functions->rank_on_top_tags($userid);

?>
                <p>
                  <?
  if ($rank_array==""){
	  echo "0";
  }else{
	  echo $rank_array;
  }
  
  ?>
                  in <a href="<?=base_url()?>locations/<?=$geo_location[0]['id']?>/0">
                  <?=$geo_location[0]['region_name']?>
                  ,
                  <?=$geo_location[0]['city']?>
                  </a></p>
              </div>
              <?
for($i=0;$i<sizeof($rank_array_bytags);$i++) {
	
	if ($i==3){
		break;  
	}
?>
              <div class="leaderboard-li">
                <p>
                  <?=$rank_array_bytags[$i]['rank']?>
                  in <a href="<?=base_url()?>tags/<?=$rank_array_bytags[$i]['label']?>/0">
                  <?=$rank_array_bytags[$i]['label']?>
                  </a></p>
              </div>
              <? } ?>
            </div>
          </div>
          <div class="leaderboard-bt"></div>
        </div>
        <div class="leaderboard-main">
          <div class="rank-tp">
            <h2>Stats</h2>
          </div>
          <div class="leaderboard-md">
            <div class="leaderboard-inner">
              <div class="leaderboard-li">
                <p>
                  <?=$this->functions->bean_earnd($userid);?>
                  Beans Earned</p>
              </div>
              <div class="leaderboard-li">
                <p>
                  <?=$this->functions->count_all("gb_beans","bean_id","user_id=$userid");?>
                  Beans Given</p>
              </div>
              <div class="leaderboard-li">
                <p>
                  <?=$this->functions->count_all("gb_status_update","update_id","user_userid=$userid");?>
                  Bean Requests</p>
              </div>
            </div>
          </div>
          <div class="leaderboard-bt"></div>
        </div>
        <div class="sidebar pb"><img src="<?=base_url();?>public/images/advertisement.png" width="330" height="276" /></div>
      </div>
    </div>
  </div>
  <div class="content-bt"></div>
</div>

