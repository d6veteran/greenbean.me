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
<div class="content-inner">  
<div class="content-wp">

<!--<div class="content-tp"></div>-->
<div class="content-md">

<div class="top-us-wp">
<div class="top-locations-wp">
  <h1>Most Popular Greenbean Locations</h1>
    
    <h2>Top 10 Locations</h2>
    
    <ul>
 	<? if($top_location){ 
	$j=1;
	
for($i=0;$i<sizeof($top_location);$i++)
  {?>  
   <li><span><?=$j?>.</span> <a href="<?=base_url()?>locations/<?=$top_location[$i]['geo_location_id']?>/0"><?=$top_location[$i]['region_name']?> ,  <?=$top_location[$i]['city']?> </a> - <?=$top_location[$i]['totalbeanrequested']?></li>
  <? $j++; }}?>   
</ul>
    <h2>Location Leaders</h2>
    <ul>
	
   <? if($top_users){ 
   $j=1;
foreach ($top_users as $value)
  {
	 $location_info=$this->functions->show_location_name($value->geo_location_id);
	  
	  ?> 
    <li><span><?=$j?>.</span> <a href="<?=base_url()?>user/profile/<?=$value->user_userid;?>"><?=$value->user_username;?></a> , <a href="<?=base_url()?>locations/<?=$location_info[0]['id'];?>/0"><?=$location_info[0]['region_name'];?>-<?=$location_info[0]['city'];?></a> - <?=$value->num_of_beanearnd;?></li>
  <? $j++; }}?> 
    </ul>
    
    
</div>
<div class="sidebar">

<div class="top-message">
<? if(!isset($_SESSION['userid'])){?>
<p><a class='login_box' href="#user_login_box">Sign up and start earning beans <br /> for</a>
<? }else{?>
<p><a href="<?=base_url()?>user/profile/<?=$_SESSION['userid']?>">Update your status and earn beans<br /> for </a>
<? }?>
<span><?=$geo_location['city']?>, <?=$geo_location['region_name']?></span></p></div>

<div style="display: none;">
		<div id="user_login_box">
				<a href="javascript:void(0)" onclick="FB.Connect.requireSession(function() { update_user_box(); }); return 
false;" ><img id="fb_login_image" src="<?=base_url();?>public/images/f-connect.gif" alt="Connect" border="0"/></a> 
<a href="<?=base_url()?>twitter_connect"><img src="<?=base_url()?>public/images/twitter-connect.jpg" width="150" height="22" /> </a>
		</div>
	</div>

<div class="leader-box">
<div class="leader-box-header">
  <h2>Tag Leader Rankings by Location</h2>
</div>
<div class="leader-box-middle">
	<? if($top_location_tags){ 	
for($i=0;$i<sizeof($top_location_tags);$i++)
  {?>  
<div class="leader-box-listing">
 <h2><?=$this->functions->show_tags_name($top_location_tags[$i]['tag_id'])?></h2>
 <?
 if($top_location_tags[$i]['top_location']){
 for($j=0;$j<sizeof($top_location_tags[$i]['top_location']);$j++)
  {?> 
<div class="leader-box-listing-item">
  <p><a href="<?=base_url()?>locations/<?=$top_location_tags[$i]['top_location'][$j]->geo_location_id?>/0">
  <?=$top_location_tags[$i]['top_location'][$j]->region_name?> , <?=$top_location_tags[$i]['top_location'][$j]->city?>
  </a> - <a href="#"><?=$top_location_tags[$i]['top_location'][$j]->totaltagused?></a></p>
</div>
<? }}?> 

</div>
  <? }}?> 

<div class="read-arrow">
  <a href="<?=base_url();?>toptags">See more tags</a>
  </div> 
</div>

<div class="leader-box-bottom"></div>
</div>

<div class="ad-300x250"><iframe src="http://rcm.amazon.com/e/cm?t=greenbean.me-20&o=1&p=12&l=ur1&category=earthday&banner=1DG5GKFX1JWFXRYVV9R2&f=ifr" width="300" height="250" scrolling="no" border="0" marginwidth="0" style="border:none;" frameborder="0"></iframe>
</div>

</div>
</div></div>
<div class="content-bt"></div>
</div>
</div>