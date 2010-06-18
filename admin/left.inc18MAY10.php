<script type="text/javascript" src="js/jq4menu.js"></script>
<link rel="stylesheet" href="css/css.css" type="text/css">
<style>
a { color:#03C; text-decoration:none; font-family:"Lucida Sans Unicode", "Lucida Grande", "sans-serif" }
ul {font-family:"Lucida Sans Unicode", "Lucida Grande", "sans-serif"; margin:0; padding:0;}
li {border-bottom:thin #69C }
.sub li li a{width:190px;}
.sub-a{color: #000; display:block; border-bottom: solid #CCC 1px; border-right: solid #CCC 1px; border-left: solid #CCC 1px; font-size:12px; width:213px; padding:4px 0 4px 7px; }
.sub-a img{border:none; vertical-align:middle}
.sub-a:hover{ background-color: #eeeeee }
.head-a{color: #000; display:block; border-bottom: solid #CCC 1px; border-right: solid #CCC 1px; border-left: solid #CCC 1px; font-size:12px;}
</style>

<table width="220px" border="0" cellpadding="0" cellpadding="0" bgcolor="#f2f2f2" style="margin:7px 0 0 20px;">
  <tr>
    <td align="left">
     <!--<div id="static"><a href="#">Admin Left Menu </a></div>
            <div id="static"><a href="user_list.php">View User </a></div>-->
                  <ul id="identifier" style="list-style-type:none; line-height:15px;">
                 <li style="list-style:none;" ><a href="#" style="background-color:#d5d5d5;  display:block;  text-align: center; padding-top:8px; padding-bottom:8px; color:#666; font-weight: bolder; font-size:14px; border-bottom:solid #666 3px;">Manage Users</a>
                  	<ul style="list-style-type:none; line-height:20px;">
                    	<li><a href="user_list.php"  class="sub-a"><img src="images/category.gif" alt="" />&nbsp;&nbsp;View Users </a></li>
                        <!--<li><a href="user_addf.php"  class="sub-a"><img src="images/post.gif" alt="" />&nbsp;&nbsp;Add New User </a></li>-->
                    </ul>
                  </li>
                  
                  <br />
                  <li ><a href="#" style="background-color:#d5d5d5;  display:block;  text-align: center; padding-top:8px; padding-bottom:8px; color:#666; font-weight: bolder; font-size:14px; border-bottom:solid #666 3px;">Add Tag</a>
                  	<ul style="list-style-type:none; line-height:20px;">
                    	  <li><a href="category_addf.php"  class="sub-a"><img src="images/category.gif" alt="" />&nbsp;&nbsp;View Tag </a></li>
                   <li><a href="tag_add.php"  class="sub-a"><img src="images/post.gif" alt="" />&nbsp;&nbsp;Add New Tag</a></li>
                    </ul>
                  </li>
                   <br />
                  
                  <li style="list-style:none;"><a href="javascript:void(0)" style="background-color:#d5d5d5; display:block;  text-align: center; padding-top:8px; padding-bottom:8px; color:#666; font-weight: bolder; font-size:14px; border-bottom:solid #666 3px;">Actions</a>
                  	<ul style="list-style-type:none; line-height:20px">
                    <!--<li><a href="welcome.php"  class="sub-a"><img src="images/sysinfo.png" alt="" />&nbsp;&nbsp;Admin Dashboard </a></li>-->  
                    <li></li> 
                     <li><a href="logoff.php"  class="sub-a"><img src="images/sysinfo.png" alt="" />&nbsp;&nbsp;LogOff </a></li>                     
                    </ul>
                  </li>
                  </ul>
    </td>
  </tr>
  
 
</table>

<script type="text/javascript">
$(document).ready(function(){
   $('#identifier').hoverAccordion({
      activateitem: '1',
      speed: 'fast',
   });
});


</script>