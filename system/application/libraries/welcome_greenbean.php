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
	
<script type="text/javascript">
 $(document).ready(function(){

$(".bean").click(function() 
{

var id = $(this).attr("id");
var user_id = <?=$_SESSION['userid']?>;
var location_id=<?=$geo_location[0]['id']?>;
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

	$('.counter').html('<img style="padding:12px" src="<?=base_url()?>public/images/ajax-loader.gif" alt="loading" width="16" height="16" />');

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
      
<div class="content-wp">
<div class="content-tp"></div>
<div class="content-md">
  <div>
  <div class="content-lt">
 
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
 <a href="user/tags/<?=$tag_array[$i]['tag_id']?>" id="<?=$tag_array[$i]['tag_id']?>"> #<?=$tag_array[$i]['tag_name']?></a>
 <? }}?>
 </span>
 </p>


</div>
</div>
</div>
<? }}?>

</div>

<div style="display: none;">
		<div id="user_login_box">
				<a href="javascript:void(0)" onclick="FB.Connect.requireSession(function() { update_user_box(); }); return 
false;" ><img id="fb_login_image" src="<?=base_url();?>public/images/f-connect.gif" alt="Connect" border="0"/></a> <a href="<?=base_url()?>twitter_connect"><img src="<?=base_url()?>public/images/twitter-connect.jpg" width="150" height="22" /></a>
		</div>
	</div>
	
<div class="content-right">
<div class="leaderboard-main">
<div class="leaderboard-tp">
 <h2>Leader Board</h2>
    for<br />
    <p><?=$geo_location[0]['region_name']?> <?=$geo_location[0]['city']?></p>
</div>
<div class="leaderboard-md">
<div class="leaderboard-inner">
 <? if($top_users){ 
foreach ($top_users as $value)
  {?> 
<div class="leaderboard-li">
<div class="leaderbord-left">
  <p><a href="#"><?=$value->user_username;?></a></p>
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
  <h2>Green Bean Tags</h2>
  <ul>
  <?
   $tags=$this->functions->show_tags();
   if($tags){ 
 foreach ($tags as $value)
  {?> 
  <li><a href="<?=base_url()?>user/tags/<?=$value->tag_id;?>" id="<?=$value->tag_id;?>"><?=$value->label;?></a> <span>- <?=$this->functions->count_all("gb_tags_relation","tag_id","tag_id=$value->tag_id");?></span></li>
  <? }}?>   
  </ul>
  
</div>


</div>
</div>
</div>
<div class="content-bt"></div>
</div>