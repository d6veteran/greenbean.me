<?php

if($reccnt!=0){
	
$pagenum=$reccnt/$pagesize;

$PHP_SELF=$HTTP_SERVER_VARS['PHP_SELF'];
$qry_str=$HTTP_SERVER_VARS['argv'][0];

$m=$_GET;
unset($m['start']);

$qry_str=qry_str($m);

//echo "$qry_str : $p<br>";

	if($pagenum>40)
	{
		$j=$start/$pagesize;		
		$k=$j+40;
		if($k>$pagenum)
		{
			$k=$pagenum;
		}
	}
	else
	{
		$j=0;
		$k=$pagenum;
	}

?>
<link rel="stylesheet" href="css/new_css.css" type="text/css">
<?//="$start : $pagesize : $j : $k"?>
<link rel="stylesheet" href="../css/cs.css" type="text/css">
<link rel="stylesheet" href="css/face.css" type="text/css">
<link rel="stylesheet" href="../css/s_green.css" type="text/css">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr> 
    <td class="white" width="20%" align="center" height="20"> <font face="Arial, Helvetica, sans-serif" size="2"><a href="<?=$PHP_SELF?><?=$qry_str?>&start=<?=$start-$pagesize?>" > 
      <?
		if($start!=0)
		{

?>
      &laquo; Previous </a>&nbsp; 
      <?
		}
?>
      </font></td>
    <td class="white" width="66%" align="center" height="20"> <font color="#000000" size="1" face="Arial, Helvetica, sans-serif" class="main"> 
      <?
			
			for($i=$j;$i<$k;$i++)
			{
				if($i==$j)echo "Page:";
			   if(($pagesize*($i))!=$start)
				  {
	  ?>
      <a href="<?=$PHP_SELF?><?=$qry_str?>&start=<?=$pagesize*($i)?>" style="text-decoration:none;" class="white_txt"> 
      <?=$i+1?>
      </a> 
      <?
				  }
	  else{
	  ?>
      <span class="arialWhiteMed"><b> 
      <?=$i+1?>
      </b></span> 
      <?
	  }
 }?>
      </font></td>
    <td class="white" width="14%" align="center" height="20"> <font color="#FFFFFF" face="Arial, Helvetica, sans-serif" size="2"> 
      <?
	if($start+$pagesize < $reccnt){
		?>
      &nbsp;&nbsp; </font><font face="Arial, Helvetica, sans-serif" size="2"><a href="<?=$PHP_SELF?><?=$qry_str?>&start=<?=$start+$pagesize?>">Next 
      &raquo;</a>&nbsp; 
      <?
		}
  ?>
      </font></td>
  </tr>
</table>
<?}
?>
