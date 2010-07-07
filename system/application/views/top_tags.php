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
<!--<div class="content-tp"></div>-->
<div class="content-md">
<div class="top-us-wp">
<div class="top-locations-wp">
  <h1>Is Your Community Among<br />
    The Greenest?</h1>
    
    <h2>Top 10 Tags</h2>
    
    <ul>
 	<? if($top_tags){ 
	$j=1;
for($i=0;$i<sizeof($top_tags);$i++)
  {?>  
   <li><span><?=$j?>.</span> <a href="<?=base_url()?>tags/<?=$top_tags[$i]->label?>/0"> <?=$top_tags[$i]->label?> </a> - <?=$top_tags[$i]->totalbeanrequested?></li>
  <? $j++; }}?>   
</ul>
    <h2>Tag Leaders</h2>
    <ul>
	
   <? if($top_users){ 
   $j=1;
foreach ($top_users as $value)
  {?> 
    <li> <span><?=$j?>.</span> <a href="<?=base_url()?>user/profile/<?=$value->user_id?>"><?=$this->functions->getUser_name($value->user_id);?></a> , <a href="<?=base_url()?>tags/<?=$this->functions->show_tags_name($value->tag_id);?>/0"><?=$this->functions->show_tags_name($value->tag_id);?>  </a>  - <?=$value->totalbeanearned;?></li>
  <? $j++; }}?> 
    </ul>
    
    
</div>
<div class="content-right">

<div class="fairfield-txt">
<? if(!isset($_SESSION['userid'])){?>
<p><a class='login_box' href="#user_login_box">Sign up and start earning beans<br />
for this tag</a></p>
<? }else{?>
<p>

<a href="<?=base_url()?>user/profile/<?=$_SESSION['userid']?>">Update your status and earn
beans<br /> for this tag</a>.

</p>
<? }?>
</div>
<div style="display: none;">
		<div id="user_login_box">
				<a href="javascript:void(0)" onclick="FB.Connect.requireSession(function() { update_user_box(); }); return 
false;" ><img id="fb_login_image" src="<?=base_url();?>public/images/f-connect.gif" alt="Connect" border="0"/></a> 
<a href="<?=base_url()?>twitter_connect"><img src="<?=base_url()?>public/images/twitter-connect.jpg" width="150" height="22" /> </a>
		</div>
	</div>
<div class="leaderboard-main">
<div class="rank-tp">
  <h2>Tag Leader Rankings by User</h2>
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
  <p><a href="<?=base_url()?>user/profile/<?=$top_users_tags[$i]['top_users'][$j]->user_userid?>"><?=$top_users_tags[$i]['top_users'][$j]->user_username?></a> - <a href="#"><?=$top_users_tags[$i]['top_users'][$j]->totaltagused?></a></p>
</div>
<? }}?> 

</div>
  <? }}?> 
  <!--<div class="read-arrow">
  <a href="<?=base_url();?>toptags">See more tags</a>
  </div>-->
</div>
<div class="leaderboard-bt"></div>
</div>

<div class="sidebar pb"><img src="<?=base_url()?>public/images/advertisement.png"/></div>



</div>



</div>
</div>
<div class="content-bt"></div>
</div>