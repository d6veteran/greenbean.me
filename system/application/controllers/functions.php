<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
if(isset($_SERVER["HTTPS"]))
	define('BASE_URL',base_url('ssl'));
else
	define('BASE_URL',base_url());			
class functions
{
	function functions() {
	
		$this->CI =& get_instance();
	}
	function checkMaintenanceMode()
	{
		$Q=$this->CI->db->get('tb_admin');
		$row=$Q->result_array();
		
		if($row[0]['maintenance_mode']=='1')
			redirect('maintenance');
	}
	function getUserInfo($user_id)
	{
		return $this->CI->User_Model->getUserInfo($user_id);
	}
	

	// THIS METHOD RETURNS A STRING SPECIFYING THE TIME SINCE THE SPECIFIED TIMESTAMP
	// INPUT: $time REPRESENTING A TIMESTAMP
	// OUTPUT: A STRING SPECIFYING THE TIME SINCE THE SPECIFIED TIMESTAMP
	function time_since($time) {
	  global $class_datetime;

	  $now = time();
	  $now_day = date("j", $now);
	  $now_month = date("n", $now);
	  $now_year = date("Y", $now);

	  $time_day = date("j", $time);
	  $time_month = date("n", $time);
	  $time_year = date("Y", $time);
	  $time_since = "";

	  switch(TRUE) {
	  
	    case ($now-$time < 60):
	      // RETURNS SECONDS
	      $seconds = $now-$time;
	      $time_since = "$seconds "."seconds ago";
	      break;
	    case ($now-$time < 3600):
	      // RETURNS MINUTES
	      $minutes = round(($now-$time)/60);
	      $time_since = "$minutes "."minutes ago";
	      break;
	    case ($now-$time < 86400):
	      // RETURNS HOURS
	      $hours = round(($now-$time)/3600);
	      $time_since = "$hours "."hours ago";
	      break;
	    case ($now-$time < 1209600):
	      // RETURNS DAYS
	      $days = round(($now-$time)/86400);
		 	if($days==1){
	      $time_since = "$days ". "day ago";
			}else{
				 $time_since = "$days ". "days ago";
			}
	      break;
	    case (mktime(0, 0, 0, $now_month-1, $now_day, $now_year) < mktime(0, 0, 0, $time_month, $time_day, $time_year)):
	      // RETURNS WEEKS
	      $weeks = round(($now-$time)/604800);
	      $time_since = "$weeks "."weeks ago";
	      break;
	    case (mktime(0, 0, 0, $now_month, $now_day, $now_year-1) < mktime(0, 0, 0, $time_month, $time_day, $time_year)):
	      // RETURNS MONTHS
	      if($now_year == $time_year) { $subtract = 0; } else { $subtract = 12; }
	      $months = round($now_month-$time_month+$subtract);
	      $time_since = "$months "."months ago";
	      break;
	    default:
	      // RETURNS YEARS
	      if($now_month < $time_month) { 
	        $subtract = 1; 
	      } elseif($now_month == $time_month) {
	        if($now_day < $time_day) { $subtract = 1; } else { $subtract = 0; }
	      } else { 
	        $subtract = 0; 
	      }
	      $years = $now_year-$time_year-$subtract;
	      $time_since = "$years ". "years ago";
	      break;

	  }

	  if($time_since == "0 years ago") { $time_since = ""; }

	  return $time_since;
  
	} // END time_since() METHOD




function relativeTime($dt,$precision=2)
{
	$times=array(	365*24*60*60	=> "year",
					30*24*60*60		=> "month",
					7*24*60*60		=> "week",
					24*60*60		=> "day",
					60*60			=> "hour",
					60				=> "minute",
					1				=> "second");
	
	$passed=time()-$dt;
	
	if($passed<5)
	{
		$output='less than 5 seconds ago';
	}
	else
	{
		$output=array();
		$exit=0;
		
		foreach($times as $period=>$name)
		{
			if($exit>=$precision || ($exit>0 && $period<60)) break;
			
			$result = floor($passed/$period);
			if($result>0)
			{
				$output[]=$result.' '.$name.($result==1?'':'s');
				$passed-=$result*$period;
				$exit++;
			}
			else if($exit>0) $exit++;
		}
				
		$output=implode(' and ',$output).' ago';
	}
	
	return $output;
}

function formatTweet($tweet,$dt,$user_status_id)
{
	if(is_string($dt)) $dt=strtotime($dt);

	$tweet=htmlspecialchars(stripslashes($tweet));

	return'
	<div class="vote-wp">
	<div class="vote-number">
	<div class="div-number-txt">
		<p>34</p>
		<span>VOTE</span>
		
		</div>
		
		</div>
		<div class="vote-right">
		  <div class="vote-txt">
			
		<p> '. preg_replace('/((?:http|https|ftp):\/\/(?:[A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?[^\s\"\']+)/i','<a href="$1" rel="nofollow" target="blank">$1</a>',$tweet).'<br />
		 <span>'.$this->relativeTime($dt).'- <a href="#">#bike</a> <a href="#">#commute</a></span></p>
		
		
		</div>
		</div>
		</div>';

}
	
		function user_status_update($user_id="")
    {	
		if($user_id !=""){
		$Q=$this->CI->db->query("SELECT * FROM gb_status_update	where user_userid ='".$user_id."' ORDER BY status_update_date DESC" );
		}else{
		$Q=$this->CI->db->query("SELECT * FROM gb_status_update INNER JOIN gb_users ON gb_status_update.user_userid=gb_users.user_userid ORDER BY gb_status_update.status_update_date DESC limit 10" );
		}
		
		$row=$Q->result();		
		if($Q->num_rows() > 0){		
		return $Q->result(); }else{
		return 0;
		}
    }
	
	
	
	///********************************* Total count Beans ***************************************************
	
		function count_all($table, $fields, $where="", $order="")
    {
      
	   $q = "select $fields from $table";
		if($where) $q .= " where $where";
		if($order) $q .= " order by $order";
    
       	$Q=$this->CI->db->query($q);
        
        if ($Q->num_rows() == 0)
            return '0';

        return $Q->num_rows();
    } 
	
	
	///********************************* End for count Beans *************************************************
	
	///********************************* Total count Beans ***************************************************
	
		function bean_earnd($user_id)
    {
      
	   $query  = "SELECT COUNT(*) AS bean_earned FROM gb_beans WHERE request_bean_id IN (SELECT update_id FROM gb_status_update WHERE user_userid=$user_id)";
		   
       	$Q=$this->CI->db->query($query);
        if ($Q->num_rows() == 0)
            return '0';

        $row = $Q->row();
        return $row->bean_earned;
    } 
	
	
	///********************************* End for count Beans *************************************************
	
	
	function user_pre_tags()
    {	
		$Q=$this->CI->db->query("SELECT * FROM gb_tags	where added_by ='admin' ORDER BY tag_id DESC" );
		$row=$Q->result();		
		if($Q->num_rows() > 0){		
		return $Q->result(); }else{
		return 0;
		}
    }
	
	
	
		function status_tags($status_id)
    {	
		
		$Q=$this->CI->db->query("SELECT tag_id FROM gb_tags_relation where status_id ='".$status_id."' ORDER BY tag_id DESC" );
		$row=$Q->result();		
		if($Q->num_rows() > 0){
		foreach ($Q->result_array() as $stu_tags)
    {
		$tag_id= $row[0]->tag_id;
		$Query_tag=$this->CI->db->query("SELECT * FROM gb_tags	where tag_id ='".$stu_tags['tag_id']."' ORDER BY tag_id DESC" );
		$status_tags=$Query_tag->result();
		
		$tag_array[] = array(
		'tag_id'  => $status_tags[0]->tag_id,					 
        'tag_name'  => $status_tags[0]->label);	
	}
		return $tag_array; 
		
		}else{
		return 0;
		}
    }
	
	
	
function show_tags()
    {
		$Q=$this->CI->db->query("SELECT * FROM gb_tags	where added_by ='admin' ORDER BY tag_id DESC");
		$row=$Q->result();		
		if($Q->num_rows() > 0){
		return $Q->result(); 		
		}else{
		return 0;
		}
    }
	
	
	function show_tags_name($tag_id)
    {
		$Q=$this->CI->db->query("SELECT * FROM gb_tags	where tag_id='".$tag_id."' ORDER BY tag_id DESC");
		$row=$Q->result();		
		if($Q->num_rows() > 0){
		return $row[0]->label; 		
		}else{
		return 0;
		}
    }
	
			function check_geo_location($geo_data)
    {
		$city=$geo_data['city'];
		$Q=$this->CI->db->query("SELECT id FROM gb_geo_location where city ='".$city."' ORDER BY id DESC" );
		$row=$Q->result();		
		if($Q->num_rows() > 0){
		foreach ($Q->result_array() as $stu_geo_location)
    {
		$tag_id= $row[0]->id;
		$Query_location=$this->CI->db->query("SELECT * FROM gb_geo_location	where id ='".$stu_geo_location['id']."' ORDER BY id DESC" );
		$get_geo_location=$Query_location->result();
		
		$geo_location_array[] = array(
		'id'  => $get_geo_location[0]->id,
		'country_code'  => $get_geo_location[0]->country_code,
		'country_name'  => $get_geo_location[0]->country_name,
		'region_name'  => $get_geo_location[0]->region_name ,
		'city'  => $get_geo_location[0]->city,
		'zip_postal_code'  => $get_geo_location[0]->zip_postal_code,
		'latitude'  => $get_geo_location[0]->latitude,
		'longitude'  => $get_geo_location[0]->longitude ,
		'timezone'  => $get_geo_location[0]->timezone,
		'gmtoffset'  => $get_geo_location[0]->gmtoffset,
		'dstoffset'  => $get_geo_location[0]->dstoffset
		);	
	}
		return $geo_location_array; 
		
		}else{
		 $query = $this->CI->db->query("INSERT INTO gb_geo_location (country_code,country_name,region_name,city,zip_postal_code,latitude,longitude,timezone,gmtoffset,dstoffset) 
		    VALUES ('".$geo_data['country_code']."','".$geo_data['country_name']."','".$geo_data['region_name']."','".$geo_data['city']."','".$geo_data['zip_postal_code']."', '".$geo_data['latitude']."','".$geo_data['longitude']."','".$geo_data['timezone']."' , '".$geo_data['gmtoffset']."', '".$geo_data['dstoffset']."' ) ");
		   				
			if($query)
			{
				$geo_location_id = $this->CI->db->insert_id() ;
				
		$Query_location=$this->CI->db->query("SELECT * FROM gb_geo_location	where id ='".$geo_location_id."' ORDER BY id DESC" );
		$get_geo_location=$Query_location->result();
		
		$geo_location_array[] = array(
		'id'  => $get_geo_location[0]->id,
		'country_code'  => $get_geo_location[0]->country_code,
		'country_name'  => $get_geo_location[0]->country_name,
		'region_name'  => $get_geo_location[0]->region_name,
		'city'  => $get_geo_location[0]->city,
		'zip_postal_code'  => $get_geo_location[0]->zip_postal_code,
		'latitude'  => $get_geo_location[0]->latitude,
		'longitude'  => $get_geo_location[0]->longitude,
		'timezone'  => $get_geo_location[0]->timezone,
		'gmtoffset'  => $get_geo_location[0]->gmtoffset,
		'dstoffset'  => $get_geo_location[0]->dstoffset
		);	
	
			}
	return $geo_location_array;
		}
    }
	
	
			function top_user_bylocation($geo_data)
    {
		
		$city=$geo_data['city'];
			
		$Q=$this->CI->db->query("SELECT id FROM gb_geo_location where city ='".$city."' ORDER BY id DESC" );
		$row=$Q->result();		
		if($Q->num_rows() > 0){
	
		$location_id= $row[0]->id;
		$Query_location=$this->CI->db->query("SELECT COUNT(gb_beans.bean_positive) AS num_of_beanearnd, gb_users.user_userid, gb_users.user_username,gb_beans.geo_location_id  FROM gb_beans LEFT JOIN gb_users ON gb_beans.user_id=gb_users.user_userid WHERE gb_beans.geo_location_id='".$location_id."' GROUP BY gb_users.user_userid ORDER BY num_of_beanearnd DESC LIMIT 10" );
	$top_user=$Query_location->result();
	
		return $top_user; 
		
		}else{
		
		return 0;	
		}
    }
	
function top_user($by_days="")
    {
	
	if($by_days=="")
	{
		$Q=$this->CI->db->query("SELECT COUNT(*) AS bean_earned,
									gb_status_update.user_userid
									FROM gb_status_update
									LEFT JOIN gb_beans
									ON gb_status_update.update_id=gb_beans.request_bean_id
									
									GROUP BY gb_status_update.user_userid
									
									ORDER BY bean_earned DESC LIMIT 10" );
	}else{
				
				$Q=$this->CI->db->query("SELECT COUNT(*) AS bean_earned,
										gb_status_update.user_userid
										FROM gb_status_update
										LEFT JOIN gb_beans
										ON gb_status_update.update_id=gb_beans.request_bean_id
										
										WHERE DATE_SUB(CURDATE(),INTERVAL 7 DAY) <= gb_status_update.status_update_date
										
										GROUP BY gb_status_update.user_userid
										
										ORDER BY bean_earned DESC LIMIT 10" );
	}
		
		$row=$Q->result();
		
		if($Q->num_rows() > 0){
		$i=0;
		foreach ($Q->result_array() as $top_user){
		$user_userid= $row[$i]->user_userid;
		$user_info=$this->CI->db->query("SELECT user_userid,user_username FROM gb_users where user_userid='".$user_userid."'" );
		$top_user=$user_info->result();		
		$top_user_array[] = array(
		'user_userid'  => $row[$i]->user_userid,
		'bean_earned'  => $row[$i]->bean_earned,
		'user_username'  => $top_user[0]->user_username
		);	
		$i++;
	}
		return $top_user_array; 
		
		}else{
		
		return 0;	
		}
    }
	
	
	
	function top_location()
    {
	
		$Q=$this->CI->db->query("SELECT COUNT(*) AS totalbeanrequested,
										gb_status_update.geo_location_id
										FROM gb_status_update
										LEFT JOIN gb_geo_location
										ON gb_status_update.geo_location_id=gb_geo_location.id
																			
										GROUP BY gb_status_update.geo_location_id
																			
										ORDER BY totalbeanrequested DESC LIMIT 10" );
		
		$row=$Q->result();
		
		if($Q->num_rows() > 0){
		$i=0;
		foreach ($Q->result_array() as $top_location){
		$geo_location_id= $row[$i]->geo_location_id;
		$location_info=$this->CI->db->query("SELECT region_name,city FROM gb_geo_location where id='".$geo_location_id."'" );
		$top_location=$location_info->result();		
		$location_user_array[] = array(
		'geo_location_id'  => $row[$i]->geo_location_id,
		'totalbeanrequested'  => $row[$i]->totalbeanrequested,
		'region_name'  => $top_location[0]->region_name,
		'city'  => $top_location[0]->city
		);	
		$i++;
	}
		return $location_user_array; 
		
		}else{
		
		return 0;	
		}
    }
	
	
	function top_useri_in_tags()
    {
	
			$Q=$this->CI->db->query("SELECT COUNT(*) AS totalbeanrequested,
									gb_tags_relation.tag_id
									FROM gb_tags_relation
									LEFT JOIN gb_beans
									ON gb_tags_relation.status_id=gb_beans.request_bean_id																			
									GROUP BY gb_tags_relation.tag_id																			
									ORDER BY totalbeanrequested DESC LIMIT 3
									" );
		
		$row=$Q->result();
		
		if($Q->num_rows() > 0){
		$i=0;
		foreach ($Q->result_array() as $top_tags){
		$tag_id= $row[$i]->tag_id;
			$top_user=$this->CI->db->query("SELECT COUNT(*) AS totaltagused,gb_tags_relation.user_id,gb_tags_relation.tag_id,gb_users.user_username FROM gb_tags_relation 
	LEFT JOIN gb_users
	ON gb_tags_relation.user_id=gb_users.user_userid
	
	WHERE gb_tags_relation.tag_id='".$tag_id."'
	
	GROUP BY gb_tags_relation.user_id ORDER BY totaltagused DESC LIMIT 5" );
		$top_user=$top_user->result();		
		$top_user_array[] = array(
		'tag_id'  => $row[$i]->tag_id,
		'top_users'  => $top_user
		);	
		$i++;
	}
		return $top_user_array; 
		
		}else{
		
		return 0;	
		}
    }
	
	
	function top_location_in_tags()
    {
	
			$Q=$this->CI->db->query("SELECT COUNT(*) AS totalbeanrequested,
									gb_tags_relation.tag_id
									FROM gb_tags_relation
									LEFT JOIN gb_beans
									ON gb_tags_relation.status_id=gb_beans.request_bean_id																			
									GROUP BY gb_tags_relation.tag_id																			
									ORDER BY totalbeanrequested DESC LIMIT 3
									" );
		
		$row=$Q->result();
		
		if($Q->num_rows() > 0){
		$i=0;
		foreach ($Q->result_array() as $top_tags){
		$tag_id= $row[$i]->tag_id;
			$top_user=$this->CI->db->query("SELECT COUNT(*) AS totaltagused,gb_tags_relation.geo_location_id,gb_tags_relation.tag_id,gb_geo_location.region_name FROM gb_tags_relation 
	LEFT JOIN gb_geo_location
	ON gb_tags_relation.geo_location_id=gb_geo_location.id
	
	WHERE gb_tags_relation.tag_id='".$tag_id."'
	
	GROUP BY gb_tags_relation.geo_location_id ORDER BY totaltagused DESC LIMIT 5" );
		$top_location=$top_user->result();		
		$top_location_array[] = array(
		'tag_id'  => $row[$i]->tag_id,
		'top_location'  => $top_location
		);	
		$i++;
	}
		return $top_location; 
		
		}else{
		
		return 0;	
		}
    }
	
	

	
	
	
}
?>