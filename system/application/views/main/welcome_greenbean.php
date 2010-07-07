<script type="text/javascript">
function show_loging(id){
		$(document).ready(function() {			
			$("#login_"+id).fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});			
		});
}
	</script>
	
<script type="text/javascript">
 $(document).ready(function(){

$(".bean").click(function() 
{

var id = $(this).attr("id");
var user_id = <?=$_SESSION['userid']?>;
var name = $(this).attr("name");
var dataString = 'bean_req_id='+ id +"&user_id="+ user_id;
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
  <div style="position:relative; width:814px;">
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
<a id="login_<?=$value->update_id;?>" href="#inline1" title="Lorem ipsum dolor sit amet" onclick="show_loging();">VOTE</a>
</span>
<? }else {?>
<span><a href="javascript:void(0);" class="bean" id="<?=$value->update_id;?>" name="up">VOTE</a></span>
<? }?>
</div>

</div>
<div class="vote-right">
<div class="vote-pic"><img src="<?=base_url();?>public/user_image/<?=$value->user_photo?>" width="35" height="35" /></div>
<div class="vote-txt">
  <h2><a href="user/profile/<?=$value->user_userid?>"><?=$value->user_username?></a></h2>
<p><?=$value->update_body?><br />
 <span><?=$this->functions->time_since(strtotime($value->status_update_date))?> - 
  <? 
 $tag_array=$this->functions->status_tags($value->update_id);
 if($tag_array){
 for($i=0;$i<sizeof($tag_array);$i++) {
 ?>  
 <a href="#" id="<?=$tag_array[$i]['tag_id']?>">#<?=$tag_array[$i]['tag_name']?></a>
 <? }}?>
 </span>
 </p>


</div>
</div>
</div>
<? }}?>

</div>

<div style="display: none;">
		<div id="inline1" style="width:400px;height:100px;overflow:auto;">
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis mi eu elit tempor facilisis id et neque. Nulla sit amet sem sapien. Vestibulum imperdiet porta ante ac ornare. Nulla et lorem eu nibh adipiscing ultricies nec at lacus. Cras laoreet ultricies sem, at blandit mi eleifend aliquam. Nunc enim ipsum, vehicula non pretium varius, cursus ac tortor. Vivamus fringilla congue laoreet. Quisque ultrices sodales orci, quis rhoncus justo auctor in. Phasellus dui eros, bibendum eu feugiat ornare, faucibus eu mi. Nunc aliquet tempus sem, id aliquam diam varius ac. Maecenas nisl nunc, molestie vitae eleifend vel, iaculis sed magna. Aenean tempus lacus vitae orci posuere porttitor eget non felis. Donec lectus elit, aliquam nec eleifend sit amet, vestibulum sed nunc.
		</div>
	</div>
	
<div class="content-right">
<div class="leaderboard-main">
<div class="leaderboard-tp">
 <h2>Leader Board</h2>
    for<br />
    <p>Cleveland Ohio</p>
</div>
<div class="leaderboard-md">
<div class="leaderboard-inner">
<div class="leaderboard-li">
<div class="leaderbord-left">
  <p><a href="#">Jeff Finley</a></p>
</div>
<div class="leaderboard-right">
  <p>12,322</p>
</div>
</div>
<div class="leaderboard-li">
<div class="leaderbord-left">
  <p><a href="#">Beth Dean</a></p>
</div>
<div class="leaderboard-right">
  <p>10,333</p>
</div>
</div><div class="leaderboard-li">
<div class="leaderbord-left">
  <p><a href="#">Eric Meyer</a></p>
</div>
<div class="leaderboard-right">
  <p>8,455</p>
</div>
</div><div class="leaderboard-li">
<div class="leaderbord-left">
  <p><a href="#">Bradford Deilman</a></p>
</div>
<div class="leaderboard-right">
  <p>5,322</p>
</div>
</div><div class="leaderboard-li">
<div class="leaderbord-left">
  <p><a href="#">Josh Walsh</a></p>
</div>
<div class="leaderboard-right">
  <p>2,991</p>
</div>
</div>
</div>

</div>
<div class="leaderboard-bt"></div>
</div>

<div class="sidebar pb"><img src="images/advertisement.png" width="330" height="276" /></div>
<div class="sidebar-tag">
  <h2>Green Bean Tags</h2>
  <ul>
  <li><a href="#">commute</a> <span>-  200,943</span></li>
   <li><a href="#">bike </a> <span>- 180,430</span></li>
  <li><a href="#">organic</a> <span>- 175,933</span></li>
  <li><a href="#">garden</a> <span>- 134,888</span></li>
  <li><a href="#">carpool</a> <span>- 89,400</span></li>
   <li><a href="#">solar</a> <span>- 65,832</span></li>
    <li><a href="#">reuse</a> <span>- 50,411</span></li>
  </ul>
  
</div>


</div>
</div>
</div>
<div class="content-bt"></div>
</div>