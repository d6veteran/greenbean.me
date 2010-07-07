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
    
<div class="content-wp">
<div class="content-tp"></div>
<div class="content-md">
<div class="top-locations-wp">
  <h1>What are your doing to Save<br />
    the Planet?</h1>
    
    <h2>Top 10 Users</h2>
    
    <ul>
 	<? if($top_users){ 
	$j=1;
for($i=0;$i<sizeof($top_users);$i++)
  {?>  
    <li><a href="<?=base_url()?>user/profile/<?=$top_users[$i]['user_userid']?>"><span><?=$j?>.</span> <?=$top_users[$i]['user_username']?></a> - <?=$top_users[$i]['bean_earned']?></li>
  <? $j++; }}?>   
</ul>
    <h2>Top Users Past 7 Days</h2>
    <ul>
	
    <? if($top_users_past_days){ 
	$j=1;
for($i=0;$i<sizeof($top_users_past_days);$i++)
  {?>  
    <li><a href="<?=base_url()?>user/profile/<?=$top_users_past_days[$i]['user_userid']?>"><span><?=$j?>.</span> <?=$top_users_past_days[$i]['user_username']?></a> - <?=$top_users_past_days[$i]['bean_earned']?></li>
  <? $j++; }}?> 
    </ul>
    
    
</div>
<div class="content-right">

<div class="fairfield-txt">
<? if(!isset($_SESSION['userid'])){?>
<p><a class='login_box' href="#user_login_box">Sign up and start earning bean for</a></p>
<? }?>
<h2><?=$geo_location['region_name']?> , <?=$geo_location['city']?></h2></div>
<div style="display: none;">
		<div id="user_login_box">
				<a href="javascript:void(0)" onclick="FB.Connect.requireSession(function() { update_user_box(); }); return 
false;" ><img id="fb_login_image" src="<?=base_url();?>public/images/f-connect.gif" alt="Connect" border="0"/></a> <a href="<?=base_url()?>twitter_connect"><img src="<?=base_url()?>public/images/twitter-connect.jpg" width="150" height="22" />
		</div>
	</div>
<div class="leaderboard-main">
<div class="rank-tp">
  <h2>Tag Leaders</h2>
</div>
<div class="leaderboard-md">
	<? if($top_users_tags){ 	
for($i=0;$i<sizeof($top_users_tags);$i++)
  {?>  
<div class="leaderboard-inner">
 <h2><?=$this->functions->show_tags_name($top_users_tags[$i]['tag_id'])?></h2>
 <?
 if($top_users_tags[$i]['top_users']){
 for($j=0;$j<sizeof($top_users_tags[$i]['top_users']);$j++)
  {?> 
<div class="leaderboard-li">
  <p><?=$top_users_tags[$i]['top_users'][$j]->user_username?> - <a href="#"><?=$top_users_tags[$i]['top_users'][$j]->totaltagused?></a></p>
</div>
<? }}?> 

</div>
  <? }}?> 
</div>
<div class="leaderboard-bt"></div>
</div>

<div class="sidebar pb"><img src="images/advertisement.png" width="330" height="276" /></div>



</div>



</div>
<div class="content-bt"></div>
</div>