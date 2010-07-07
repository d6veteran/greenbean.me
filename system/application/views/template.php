<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GreenBean.me:
<?=$head_title?>
</title>
<link href="<?=base_url();?>public/css/styles.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url();?>public/css/lightbox-form.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url();?>public/css/demo.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>public/js/jquery.labelify.js"></script>
<script type="text/javascript" src="<?=base_url();?>public/js/lightbox-form.js"></script>
<script type="text/javascript" src="<?=base_url();?>public/js/jquery.tagger.js"></script>
<script type="text/javascript" src="<?=base_url();?>public/js/ajaxfileupload.js"></script>
<script type="text/javascript" src="<?=base_url();?>public/fancybox/jquery.mousewheel-3.0.2.pack.js"></script>
<script type="text/javascript" src="<?=base_url();?>public/fancybox/jquery.fancybox-1.3.1.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>public/fancybox/jquery.fancybox-1.3.1.css" media="screen" />
</head>

<body>

<script type="text/javascript" src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php"></script>
<script type="text/javascript">
		FB.init("<?=$this->config->item('facebook_api_key')?>", "<?=base_url();?>xd_receiver.htm");
</script>
<div id="wrapper">
  <!--  *********************************** HEADER STARTS HERE         *******************************-->
  <div class="header">
    <div class="top-nav-wp">
      <div class="top-nav">
        <div class="top-nav-left">
          <ul>
            <li><a href="<?=base_url()?>toptags">Top Tags</a></li>
            <li><a href="<?=base_url()?>topuser">Top Users</a></li>
            <li><a href="<?=base_url()?>toplocation">Top Locations</a></li>
          </ul>
        </div>
        <? if(!isset($_SESSION['userid'])){?>
        <a href="<?=base_url();?>" class="logo"><img src="<?=base_url();?>public/images/logo.png" width="269" height="142" /></a>
        <? }else{?>
        <a href="<?=base_url();?>user_home" class="logo"><img src="<?=base_url();?>public/images/logo.png" width="269" height="142" /></a>
        <? }?>
        <div class="top-nav-right">
          <? if(!isset($_SESSION['userid'])){?>
          <a href="javascript:void(0)" onclick="FB.Connect.requireSession(function() { update_user_box(); }); return 
false;" ><img id="fb_login_image" src="<?=base_url();?>public/images/facebook_connect.gif" alt="Connect" border="0"/></a>       
          
          <a href="<?=base_url()?>twitter_connect"><img src="<?=base_url()?>public/images/twitter-connect.jpg" width="150" height="22" /></a>
          <? }else{?>
          <a href="<?=base_url()?>user/profile/<?=$_SESSION['userid']?>">
          <?=$_SESSION['username']?>
          </a> <a href="<?=base_url()?>user/settings">settings</a>
          <?php if(isset($_SESSION['user_facebook_id'])) { ?>
          <a onclick="FB.Connect.logoutAndRedirect('<?=base_url()?>user/logout')" class="blue14" href="javascript:void(0)">Logout</a>
          </li>
          <?php }else { ?>
          <a  href="<?=base_url()?>user/logout" class="blue14">Logout</a>
          <?php } ?>
          <? }?>
        </div>
      </div>
      <div class="content-tp"></div>
    </div>
  </div>
  <!--  *********************************** MIDDLE PART STARTS HERE  *********************************-->
  <div style="width:100%; height:100%; float:left;">
  <?=$this->load->view($file);?>
  </div>
  <!--  *********************************** End HERE *********************************-->
  <!--  *********************************** Footer start *********************************-->
  
<div class="footer-wp">
<div class="footer-inner">

<?php 

$sql=mysql_query("SELECT page_title,page_id,page_alias FROM gb_pages WHERE status='Active'");

$num_rows=mysql_num_rows($sql);




?>

<ul>
<?php
if($num_rows>0)
   {  while($page_data=mysql_fetch_array($sql))
     {
	 $page_alias=strtr($page_data['page_alias']," ","-");
    ?>
    
      
   <li><a href="<?=base_url();?>pages/<?=$page_alias?>"><?=$page_data['page_title']?></a></li>
 <?php  }}
?>



</ul>
 </div>
</div>  
  
</div>
<script type="text/javascript">
function update_user_box()
{
FB.XFBML.Host.parseDomTree();
window.location.href='<?=base_url()?>user/fb_reg';
}
</script>
</body>
</html>
