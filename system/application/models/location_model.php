<?php 

class Location_model extends Model {
	
	function Location_model()
		{
			parent::Model();
			$this->load->library('pagination');
					
			
		}
 
 function get_recent_bean_bylocation($location_id)

			{  
				
				$seg=0;
				if ($this->uri->segment(3)>0)
			    { 
				    $seg=$this->uri->segment(3);
				 }
	         $url =base_url();
				 
				$status_update="SELECT * FROM gb_status_update INNER JOIN gb_users ON gb_status_update.user_userid=gb_users.user_userid WHERE gb_status_update.geo_location_id={$location_id} ORDER BY gb_status_update.status_update_date limit $seg, 10";
				
				
		
				$Q=$this->db->query($status_update);
				
				
				//echo $this->db->last_query(); die;
				$config['base_url'] ="".$url."locations";
				 $config['total_rows'] = $this->countrows($location_id);
				 $config['uri_segment'] = 3;
				 $config['per_page'] = 10; // records per page
				 $this->pagination->initialize($config); 
			 
				$row=$Q->result();		
				if($Q->num_rows() > 0){
				$location_info=$Q->result();
				return $location_info;
		   }else{		
					return 0;	
		
				}
     }
	 
	 
	 
	 
	function countrows($location_id)
          {
		     $query=$this->db->query("SELECT * FROM gb_status_update INNER JOIN gb_users ON gb_status_update.user_userid=gb_users.user_userid WHERE gb_status_update.geo_location_id={$location_id}");
			 $totalrow = $query->num_rows();
			 if($totalrow>0)
			   {
			     return $totalrow;
			    }
			 else{return 0;}
		    
		  }
	 
	 	function pagignation($urlname,$perpage,$location_id)
	{/*         
	         if ($this->uri->segment(3)>0)
			    { 
				    $seg=$this->uri->segment(3);
				 }
	          else 
			     {
				   $seg=0;
				 }
	         $query = $this->db->query("SELECT * FROM gb_status_update INNER JOIN gb_users ON gb_status_update.user_userid=gb_users.user_userid WHERE gb_status_update.geo_location_id=$location_id ORDER BY gb_status_update.status_update_date Limit $seg,$perpage ");
					
	         $totalrow = $query->num_rows();
			 $url =base_url();
			 $config['base_url'] ="".$url."$urlname";
			 $config['total_rows'] = $totalrow;
			 $config['uri_segment'] = 3;
			 $config['per_page'] = $perpage;
			 $this->pagination->initialize($config); 
	*/}
	
	
	function user_status_update($user_id="")

    {	
	
	
	       $seg=0;
				if ($this->uri->segment(1)>0)
			    { 
				    $seg=$this->uri->segment(1);
				 }
	         $url =base_url();
				 
	
	
	

		if($user_id !=""){

		$Q=$this->db->query("SELECT * FROM gb_status_update	where user_userid ='".$user_id."' ORDER BY status_update_date DESC limit $seg, 10" );
		$rows=$this->db->query("SELECT * FROM gb_status_update	where user_userid ='".$user_id."' ORDER BY status_update_date " );

		}else{

		$Q=$this->db->query("SELECT * FROM gb_status_update INNER JOIN gb_users ON gb_status_update.user_userid=gb_users.user_userid ORDER BY gb_status_update.status_update_date DESC limit $seg, 10" );
	 $rows=$this->db->query("SELECT * FROM gb_status_update INNER JOIN gb_users ON gb_status_update.user_userid=gb_users.user_userid ORDER BY gb_status_update.status_update_date DESC ");

		}
                
######################################## PAGINATION#############################################################
               $rows=$this->db->query("SELECT * FROM gb_status_update INNER JOIN gb_users ON gb_status_update.user_userid=gb_users.user_userid ORDER BY gb_status_update.status_update_date DESC ");
               $count_rows=$rows->num_rows();


				 $config['base_url'] ="".$url."";
				 $config['total_rows'] = $count_rows;
				 $config['uri_segment'] = 1;
				 $config['per_page'] = 10; // records per page
				 $this->pagination->initialize($config); 
				 
######################################## PAGINATION#############################################################

		$row=$Q->result();		

		if($Q->num_rows() > 0){		

		return $Q->result(); }else{

		return 0;

		}

    }
	
	
	
		function get_recent_bean_bytags($tags_id)

              {

	          $seg=0;
				if ($this->uri->segment(3)>0)
			    { 
				    $seg=$this->uri->segment(3);
				 }
	           $url =base_url();

		

		$status_update="SELECT gb_status_update.*
						FROM gb_status_update
						LEFT JOIN gb_tags_relation
						ON gb_status_update.update_id=gb_tags_relation.status_id
						WHERE gb_tags_relation.tag_id={$tags_id}
						ORDER BY gb_status_update.status_update_date DESC
						limit $seg, 10";

		$Q=$this->db->query($status_update);
		
		
######################################## PAGINATION#############################################################
               $rows=$this->db->query("SELECT gb_status_update.*
						FROM gb_status_update
						LEFT JOIN gb_tags_relation
						ON gb_status_update.update_id=gb_tags_relation.status_id
						WHERE gb_tags_relation.tag_id={$tags_id}");
               $count_rows=$rows->num_rows();


				 $config['base_url'] ="".$url."tags";
				 $config['total_rows'] = $count_rows;
				 $config['uri_segment'] = 3;
				 $config['per_page'] = 10; // records per page
				 $this->pagination->initialize($config); 
				 
######################################## PAGINATION#############################################################
		

		$row=$Q->result();		

		if($Q->num_rows() > 0){

		$tags_info=$Q->result();

		return $tags_info;

		}else{		

		return 0;	

		}

		

    }
	
	function user_status_update_pagination($user_id="")

    {	
	
	
	       $seg=0;
				if ($this->uri->segment(4)>0)
			    { 
				    $seg=$this->uri->segment(4);
				 }
	         $url =base_url();
				 
	
	
	

		if($user_id !=""){

		$Q=$this->db->query("SELECT * FROM gb_status_update	where user_userid ='".$user_id."' ORDER BY status_update_date DESC limit $seg, 10" );
		$rows=$this->db->query("SELECT * FROM gb_status_update	where user_userid ='".$user_id."' ORDER BY status_update_date DESC" );

		}else{

		$Q=$this->db->query("SELECT * FROM gb_status_update INNER JOIN gb_users ON gb_status_update.user_userid=gb_users.user_userid ORDER BY gb_status_update.status_update_date DESC limit $seg, 10" );
		
     $rows=$this->db->query("SELECT * FROM gb_status_update INNER JOIN gb_users ON gb_status_update.user_userid=gb_users.user_userid ORDER BY gb_status_update.status_update_date DESC ");

		}
                
######################################## PAGINATION#############################################################
               
               $count_rows=$rows->num_rows();
 

				 $config['base_url'] ="".$url."user/profile";
				 $config['total_rows'] = $count_rows;
				 $config['uri_segment'] = 4;
				 $config['per_page'] = 10; // records per page
				 $this->pagination->initialize($config); 
				 
######################################## PAGINATION#############################################################

		$row=$Q->result();		

		if($Q->num_rows() > 0){		

		return $Q->result(); }else{

		return 0;

		}

    }
	 
	 
}
?>