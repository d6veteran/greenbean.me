<script type="text/javascript">
 $(document).ready(function(){

$(".bean").click(function() 
{

var id = $(this).attr("id");
var user_id = <?=$_SESSION['userid']?>;
var location_id=$('#voted_location_id_'+id).val();
var name = $(this).attr("name");
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
 


  

<?
if (!isset($_SESSION['username'])){	
	header("location: ".base_url()."home");
}else{	
$userid=$_SESSION['userid'];
$user_info=$this->functions->getUserInfo($userid);
}
?>
<div style="width:100%; height:100%;">
<div class="content-wp">
<div class="content-md">
  <div>
  <div class="content-lt">
 <div style="float:left">
  <div class="profile-wp">
  <div class="cmt-wp" style=" padding-top:10px; padding-bottom:10px;">
<span>
<a href="<?=base_url()?>user/profile/<?=$_SESSION['userid']?>">Request Green Beans</a>
 <input type="hidden" name="user_ip" value="<?=$user_ip?>" />
                <? if ($user_info['user_location']!=""){ ?>
                <input type="hidden" name="geo_location_id" value="<?=$user_info['user_location']?>" id="geo_location_id" />
                <? }else{?>
                <input type="hidden" name="geo_location_id" value="<?=$geo_location[0]['id']?>" id="geo_location_id" />
                <? }?>

</span>
</div>
    
  </div>
  

  </div>
  <? if($user_update){ 
foreach ($user_update as $value)
  {?> 
<div class="vote-wp">
<div class="vote-number">
<div class="div-number-txt">
<p id="show_bean<?=$value->update_id;?>"><?=$this->functions->count_all("gb_beans","bean_id","request_bean_id=$value->update_id");?></p>
<? if(!isset($_SESSION['userid'])){?>
<span>
<a class='login_box' href="#user_login_box">VOTE</a>
</span>
<? }else {?>
<span><a href="javascript:void(0);" class="bean" id="<?=$value->update_id;?>" name="up">VOTE</a></span>
<? }?>
</div>
<input value="<?=$value->geo_location_id;?>" type="hidden" id="voted_location_id_<?=$value->update_id;?>" name="voted_location_id_<?=$value->update_id;?>" />
</div>
<div class="vote-right">
<div class="vote-pic">

<? if($value->user_photo!=""){?>
<img src="<?=base_url();?>public/checkresizeimg.php?src=user_image/<?=$value->user_photo?>&w=35&h=35&zc=1" border="0" />
<? }else{ ?>
<img src="<?=base_url();?>public/images/Greenbean-nopic.png" width="35" height="35" />
<? }?>

</div>
<div class="vote-txt">
  <h2><a href="user/profile/<?=$value->user_userid?>"><?=$value->user_username?></a></h2>
<p><?=$this->functions->bb2html($value->update_body)?><br />
 <span><?=$this->functions->time_since(strtotime($value->status_update_date))?> 
  <? 
 $tag_array=$this->functions->status_tags($value->update_id);
 if($tag_array){
?> - <?
 for($i=0;$i<sizeof($tag_array);$i++) {
 ?>  
<a href="<?=base_url()?>/tags/<?=$tag_array[$i]['tag_name']?>" id="<?=$tag_array[$i]['tag_id']?>">#<?=$tag_array[$i]['tag_name']?></a>
 <? }}?>
 </span>
 </p>


</div>
</div>
</div>
<? }}?>

</div>
<div class="content-right">
<div class="leaderboard-main">
<div class="leaderboard-tp">
 <h2>User Location Rankings </h2>
    <br />
    <p><?=$geo_location[0]['region_name']?> <?=$geo_location[0]['city']?></p>
</div>
<div class="leaderboard-md">
<div class="leaderboard-inner">
 <? if($top_users){ 
foreach ($top_users as $value)
  {?> 
<div class="leaderboard-li">
<div class="leaderbord-left">
  <p><a href="<?=base_url()?>user/profile/<?=$value->user_userid;?>"><?=$value->user_username;?></a></p>
</div>
<div class="leaderboard-right">
  <p><?=$value->num_of_beanearnd;?></p>
</div>
</div>

 <? }}?>
</div>

</div>
<div class="leaderboard-bt"></div>
</div>

<div class="sidebar pb"><img src="<?=base_url()?>public/images/advertisement.png" width="330" height="276" /></div>

<div class="sidebar-tag">
  <h2>Tag Rankings</h2>
  <ul>
  <?
   $tags=$this->functions->show_tags();
   if($tags){ 
 foreach ($tags as $value)
  {?> 
  <li class="li_tags"><a href="<?=base_url()?>tags/<?=$value->label;?>/0" id="<?=$value->tag_id;?>"><?=$value->label;?></a> <span>- <?=$this->functions->count_all("gb_tags_relation","tag_id","tag_id=$value->tag_id");?></span></li>
  <? }}?>   
  </ul>
  
</div>





</div>
</div>
</div>
<div class="content-bt"></div>
</div>
</div>