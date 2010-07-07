<?php 

if(($page_data)!=false)
   
    {
	
	 
	foreach($page_data as $data)
	{
	  $page_title=$data->page_title;
	  $page_content=$data->page_content;
	}
	} 
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

<div class="content-wp">
  <!--<div class="content-tp"></div>-->
  <div class="content-md">
    <div class="static_content">
    <div style="float:left; padding:0 20px;">
      <h1>
        <?=$page_title?>
      </h1>
      <p>
        <?=$page_content?>
      </p>
      </div>
    </div>
    
  </div>
  <div class="content-bt"></div>
</div>
