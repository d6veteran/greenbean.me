<?php
	class Staticpages_model extends Model
	{
		function Staticpages_model()
		{
			parent::Model();
		}
	
		
		
		function pagedata()
		{
		    $page_alias=$this->uri->segment(2);
			//$page_id=5;
		
			//print_r($page_alias); die;
			
			$page_title=strtr($page_alias,"-"," ");
			//print_r($page_title); die;
		   $grp=$this->db->query("Select page_title,page_content,page_alias from gb_pages where  page_alias LIKE '%$page_title%' LIMIT 1");
		   
		   $num = $grp->num_rows();
		   
		    if($num > 0)
			 {
				  $row2 = $grp->result();
				  
				  return $row2;
			 }
			 else
			 {
			  return false;
			 }
		   
		   
		}
	
 	}
?>