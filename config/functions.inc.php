<?php 

// ob_start("ob_gzhandler");

//error_reporting  (E_ALL);

error_reporting(0);

if(strpos($_SERVER['PHP_SELF'], 'uploaded_files')!==false) {

	echo "Potentail security attack. Your IP address has been logged.";

	exit;

}

//

/*

if($donot_sess){

session_cache_limiter('public'); 

echo  "<br> in donot pass <br>";

$donot_sess=false;

}

*/

session_start();

@extract($_ENV);

@extract($_SESSION);

@extract($_GET);

@extract($_POST);

@extract($_FILES);

@extract($_COOKIE);

@extract($_SERVER);





$ADMIN_EMAIL				= "service@greenbean.me";

$CUSTOMER_CARE_EMAIL		= "support@greenbean.me";

global $SITE_NAME;

$SITE_NAME					= "www.greenbean.me";

$SITE_HTML_TITLE			= "www.greenbean.me";

$ADMIN_HTML_TITLE			= "www.greenbean.me - Administration Suite";

$SITE_NAME_SHORT			= "greenbean.me";

$SESSION_MIN = 10;



$current_year = date('Y');

$DEFAULT_START_DATE = ($current_year-1).'-01-01';

$DEFAULT_END_DATE = ($current_year+1).'2007-01-01';



$arr_month = Array('January' , 'February' , 'March' , 'April' , 'May' , 'June' , 'July' , 'August' , 'September' , 'October' , 'November' , 'December');

$arr_month_short = Array('Jan' , 'Feb' , 'Mar' , 'Apr' , 'May' , 'Jun' , 'Jul' , 'Aug' , 'Sep' , 'Oct' , 'Nov' , 'Dec');



$arr_state_codes=array(

'AL'=>'ALABAMA', 'AK'=>'ALASKA', 'AS'=>'AMERICAN SAMOA', 'AZ'=>'ARIZONA', 'AR'=>'ARKANSAS', 'CA'=>'CALIFORNIA', 'CO'=>'COLORADO', 'CT'=>'CONNECTICUT', 'DE'=>'DELAWARE', 'DC'=>'DISTRICT OF OLUMBIA', 'FL'=>'FLORIDA', 'GA'=>'GEORGIA', 'HI'=>'HAWAII', 'ID'=>'IDAHO', 'IL'=>'ILLINOIS', 'IN'=>'INDIANA', 'IA'=>'IOWA', 'KS'=>'KANSAS', 'KY'=>'KENTUCKY', 'LA'=>'LOUISIANA', 'ME'=>'MAINE', 'MD'=>'MARYLAND', 'MA'=>'MASSACHUSETTS', 'MI'=>'MICHIGAN', 'MN'=>'MINNESOTA', 'MS'=>'MISSISSIPPI', 'MO'=>'MISSOURI', 'MT'=>'MONTANA', 'NE'=>'NEBRASKA', 'NV'=>'NEVADA', 'NH'=>'NEW HAMPSHIRE', 'NJ'=>'NEW JERSEY', 'NM'=>'NEW MEXICO', 'NY'=>'NEW YORK', 'NC'=>'NORTH CAROLINA', 'ND'=>'NORTH DAKOTA', 'OH'=>'OHIO', 'OK'=>'OKLAHOMA', 'OR'=>'OREGON', 'PA'=>'PENNSYLVANIA', 'RI'=>'RHODE ISLAND', 'SC'=>'SOUTH CAROLINA', 'SD'=>'SOUTH DAKOTA', 'TN'=>'TENNESSEE', 'TX'=>'TEXAS', 'UT'=>'UTAH', 'VT'=>'VERMONT', 'VI'=>'VIRGIN ISLANDS', 'VA'=>'VIRGINIA', 'WA'=>'WASHINGTON', 'WV'=>'WEST VIRGINIA', 'WI'=>'WISCONSIN', 'WY'=>'WYOMING');





global $DB;



	$DB["dbName"] = "452917_gb";     //"452917_gb";

	$DB["host"] = "mysql50-46.wc2.dfw1.stabletransit.com";        //"localhost";    

	$DB["user"] = "452917_gb";        // "452917_gb";     

	$DB["pass"] = "Gr33nB3an52556";        





	/*$DB["dbName"] = "ajax_greenbean";

	$DB["host"] = "localhost";    //"mysql50-41.wc1.dfw1.stabletransit.com";

	$DB["user"] =  "root";     //"413415_futerox";

	$DB["pass"] = "";        //"9811195449";*/

	$SITE_PATH = 'http://www.greenbean.me';

	$SSL_PATH = 'https://www.greenbean.me';

	$SITE_FS_PATH = '/usr/local/www/data.default';

	$local_mode = false;







$EMAIL_TPL_PATH = $SITE_FS_PATH.'/email_tpls/';



if($sess_currency==''){

	$sess_currency ='USD';

	session_register('sess_currency');

}



$link = mysql_connect($DB["host"], $DB["user"], $DB["pass"]) or die("<span style='FONT-SIZE:11px; FONT-COLOR: #000000; font-family=tahoma;'><center>An Internal Error has Occured. Please report following error to the webmaster.<br><br>".mysql_error()."'</center>");

mysql_select_db($DB["dbName"]);



//echo("<br>".$_SESSION['sess_userid']);

if($_SESSION['sess_userid']!='' ){

	$sql= "select now() > date_add(session_end, interval $SESSION_MIN minute) as session_expired from vp_user_session where userid='$_SESSION[sess_userid]' and session_id='".session_id()."' order by session_end desc limit 0,1";

	

	$session_expired =getSingleResult($sql);

	if($session_expired) {

		//echo("<br>$sql");

		session_unregister('sess_userid');

		session_destroy();

		unset($_SESSION['sess_userid']);

		$sess_msg = 'Your session has been timed out.';

	} else {

		$sql= "update vp_user_session set session_end=now(), current_page='$_SERVER[REQUEST_URI]' where session_id='".session_id()."' and userid='$_SESSION[sess_userid]'";

		executeupdate($sql);

	}

}



function executeQuery($sql)

{

	$result = mysql_query($sql) or die("<span style='FONT-SIZE:11px; FONT-COLOR: #000000; font-family=tahoma;'><center>An Internal Error has Occured. Please report following error to the webmaster.<br><br>".$sql."<br><br>".mysql_error()."'</center></FONT>");

	return $result;

} 



function getSingleResult($sql)

{

	$response = "";

	$result = mysql_query($sql) or die("<center>An Internal Error has Occured. Please report following error to the webmaster.<br><br>".$sql."<br><br>".mysql_error()."'</center>");

	if ($line = mysql_fetch_array($result)) {

		$response = $line[0];

	} 

	return $response;

} 



function executeUpdate($sql)

{

	mysql_query($sql) or die("<center>An Internal Error has Occured. Please report following error to the webmaster.<br><br>".$sql."<br><br>".mysql_error()."'</center>");

} 







function date_combo($pre, $selected_date = '', $start_date = '', $start_date_unit = '', $start_date_value = '', $end_date = '', $end_date_unit = '', $end_date_value = '')

{

	global $DEFAULT_START_DATE,	$DEFAULT_END_DATE;



	$cur_date = date("Y-m-d");

	$cur_date_day = substr($cur_date, 8, 2);

	$cur_date_month = substr($cur_date, 5, 2);

	$cur_date_year = substr($cur_date, 0, 4);



	if ($start_date == '') {

		if ($start_date_unit == '' || $start_date_value == '') {

			$start_date = $DEFAULT_START_DATE;

		} else if ($start_date_unit == 'y') {

			//echo "<br> ".mktime (0, 0, 0, 8, 25, 2103)." <br>";

			//echo "<br> ".mktime (0,0,0,12,32,1997)." <br>";

			$tmp_year=$cur_date_year + $start_date_value;

			$start_date = date("Y-m-d", mktime (0, 0, 0, $cur_date_month, $cur_date_day, $tmp_year));

			//echo "<br> $start_date <br>";

		} else if ($start_date_unit == 'm') {

			$start_date = date("Y-m-d", mktime (0, 0, 0, $cur_date_month + $start_date_value, $cur_date_day, $cur_date_year));

		} else if ($start_date_unit == 'd') {

			$start_date = date("Y-m-d", mktime (0, 0, 0, $cur_date_month, $cur_date_day + $start_date_value, $cur_date_year));

		} 

	}

	$start_date_day = substr($start_date, 8, 2);

	$start_date_month = substr($start_date, 5, 2);

	$start_date_year = substr($start_date, 0, 4); 

	// echo("$start_date<BR>");

	if ($end_date == '') {

		if ($end_date_unit == '' || $end_date_value == '') {

			// echo("1");

			$end_date = $DEFAULT_END_DATE;

		} else if ($end_date_unit == 'y') {

			$end_date = date("Y-m-d", mktime (0, 0, 0, $start_date_month, $start_date_day, $start_date_year + $end_date_value));

		} else if ($end_date_unit == 'm') {

			$end_date = date("Y-m-d", mktime (0, 0, 0, $start_date_month + $end_date_value, $start_date_day, $start_date_year));

		} else if ($end_date_unit == 'd') {

			$end_date = date("Y-m-d", mktime (0, 0, 0, $start_date_month, $start_date_day + $end_date_value, $start_date_year));

		} 

	} 

	$end_date_day = substr($end_date, 8, 2);

	$end_date_month = substr($end_date, 5, 2);

	$end_date_year = substr($end_date, 0, 4); 

	// echo("$end_date<BR>");

	if ($selected_date != '') {

		$selected_date_day = substr($selected_date, 8, 2);

		$selected_date_month = substr($selected_date, 5, 2);

		$selected_date_year = substr($selected_date, 0, 4);

	} 

	$arr_month = Array('January' , 'February' , 'March' , 'April' , 'May' , 'June' , 'July' , 'August' , 'September' , 'October' , 'November' , 'December');



	$date_combo .= " <select name='" . $pre . "month'> <option value='0'>Month</option>";

	$i = 0;

	for($i = 0;$i <= 11;$i++) {

		$date_combo .= " <option ";

		if ($i + 1 == $selected_date_month) {

			$date_combo .= " selected ";

		} 

		$date_combo .= " value='" . str_pad($i + 1, 2, "0", STR_PAD_LEFT) . "'>$arr_month[$i]</option>";

	} 



	$date_combo .= "</select>";



	$date_combo .= "<select name='" . $pre . "day'>";

	$date_combo .= "<option value='0'>Date</option>";

	for($i = 1;$i <= 31;$i++) {

		$date_combo .= " <option ";

		if ($i  == $selected_date_day) {

			$date_combo .= " selected ";

		} 

		$date_combo .= " value='" . str_pad($i, 2, "0", STR_PAD_LEFT) . "'>" . str_pad($i, 2, "0", STR_PAD_LEFT) . "</option>";

	} 

	$date_combo .= "</select>";



	$date_combo .= "<select name='" . $pre . "year'>";

	$date_combo .= "<option value='0'>Year</option>";

	for($i = $start_date_year; $i <= $end_date_year; $i++) {

		$date_combo .= " <option ";

		if ($i  == $selected_date_year) {

			$date_combo .= " selected ";

		} 

		$date_combo .= " value='" . str_pad($i, 2, "0", STR_PAD_LEFT) . "'>" . str_pad($i, 2, "0", STR_PAD_LEFT) . "</option>";

	} 

	$date_combo .= "</select>";

	return $date_combo;

} 



function time_combo($pre, $selected_time = '')

{

	if ($selected_time != '') {

		$selected_hour = substr($selected_time, 0, 2);

		$selected_minute = substr($selected_time, 3, 2);

		if($selected_hour >11){

			$selected_ampm = "PM";

			$selected_hour -= 12;

		}else{

			$selected_ampm = "AM";

		}

		if($selected_hour==0){

			$selected_hour = 12;

		}

	}

		//echo "<br>$selected_hour, $selected_minute $selected_ampm <br>";



	$time_combo .= "<select name='" . $pre . "hour'>";

	$time_combo .= "<option value='0'>Hour</option>";

	for($i =1; $i <= 12; $i++) {

		$time_combo .= " <option ";

		//echo "<br>$i , $selected_hour<br>";

		if ($i == $selected_hour) {

			$time_combo .= " selected ";

		} 

		$time_combo .= " value='" . str_pad($i, 2, "0", STR_PAD_LEFT) . "'>" . str_pad($i, 2, "0", STR_PAD_LEFT) . "</option>";

	} 

	$time_combo .= "</select>";

	

	$time_combo .= "<select name='" . $pre . "minute'>";

	$time_combo .= "<option value='0'>Minute</option>";

	for($i = 0; $i <= 59; $i++) {

		$time_combo .= " <option ";

		

		if (str_pad($i, 2, "0", STR_PAD_LEFT) === strval($selected_minute)) {

			$time_combo .= " selected ";

		} 

		$time_combo .= " value='" . str_pad($i, 2, "0", STR_PAD_LEFT) . "'>" . str_pad($i, 2, "0", STR_PAD_LEFT) . "</option>";

	}

	$time_combo .= "</select>";

	

	$time_combo .= "<select name='" . $pre . "ampm'>";



		$time_combo .= " <option ";

		if ($selected_ampm=='AM') {			$time_combo .= " selected ";		} 

		$time_combo .= " value='AM'>AM</option>";

		

		$time_combo .= " <option ";

		if ($selected_ampm=='PM') {			$time_combo .= " selected ";		} 

		$time_combo .= " value='PM'>PM</option>";

	

	$time_combo .= "</select>";



	return $time_combo;

}



function mysql_time($hour, $minute, $ampm){



	if($ampm=='PM'){ 	$hour += 12;}

	if($ampm=='AM' && $hour=='12'){ 	$hour = '00';}

	$mysql_time	=$hour.':'.$minute.':00';

	return $mysql_time;

}



function getCurrentPath()

{

	global $_SERVER;

	return "http://" . $_SERVER['HTTP_HOST'] . getFolder($_SERVER['PHP_SELF']);

} 



function user_in_session()

{

	global $_SESSION;

	if ($_SESSION['sess_userid'] == null) {

		// /echo "<br> user_in_session in if  <br>".$_SESSION['sess_userid'];

		return false;

	} else {

		// //	echo "<br> user_in_session in else <br>";

		return $_SESSION['sess_userid'];

	} 

} 



function check_user_type($user_type)

{

	global $_SESSION;

	if($_SESSION['sess_user_type']!=$user_type){

		$sess_msg = "You should be registerd as ".ucfirst($user_type)." to access this page";

		session_register('sess_msg');

		$_SESSION['sess_msg']=$sess_msg;

		ms_redirect("msg.php");

	}

} 



function ms_redirect($file, $exit=true, $sess_msg='')

{

	//if($sess_msg!=''){

	//	session_register('sess_msg');

		//var_dump($_SESSION);

		//print_r($sess_msg);

	//}

	header("Location: $file");

	//if($exit){

		exit();

	//}

} 

function curr_sign($currency){

	$arr_curr_sign = array('USD'=>'$','NGN'=>'<s>N</s>');

	return $arr_curr_sign[$currency];

}



function price_format($price,$currency='')

{

	global $sess_currency;

	if($sess_currency==''){

		$sess_currency='USD';

	}

	if($currency==''){

		$currency=$sess_currency;

	}



	/*if($price<0){

		$price = two_zero(-$price);

		return '-$' . $price;

	} else {*/

		$price = number_format($price,2);

	//echo("<br>$price");



		//return  $price .' '.$currency ;

		return  curr_sign($currency).''.$price;

	

	//}

} 



function two_zero($price)

{

	//echo("<br>$price");

	if($price!=''){

		return number_format($price, 2,'.','');

	}

	if($price==0){

		return number_format($price, 2,'.','');

	}

} 



function service_area_checkbox($checkname='service_area', $checksel='', $cols='4', $missit='', $style='', $tableattr=''){



	$manutmp=Array();

	$sql= " select service_area from musician_service_area order by display_order";

	$result= executeQuery($sql);

	while($line=mysql_fetch_array($result)){

		$manutmp[$line['service_area']]=$line['service_area'];

	}

	return makeCheckbox($manutmp, $checkname, $checksel, $cols, $missit, $style, $tableattr);

}







function makeCheckbox($manutmp, $checkname, $checksel='', $cols, $missit, $style='', $tableattr='')

{

	if($style!=""){

		$style="class='".$style."'";

	}



	$colwidth=100/$cols;

	$colwidth=round($colwidth,2);

	$j=1;

	/*

	$manutmp['Any']="Any";

	if($checksel==''){

		$checksel=Array("Any");

	}

	*/

	foreach($manutmp as $key => $value){

		$tochecked="";

		if(is_array($checksel) && in_array( $key,$checksel)) {

			$tochecked="checked";

		}

		if($key!=$missit){

			if($value!=""){

				if($j==1){

					$checkstr.="<table $tableattr><tr>\n";

				}else if(($j%$cols)==1){

					$checkstr.="</tr><tr>\n";

				}

				

				$checkstr.="<td width='".$colwidth."%' $style valign=top><INPUT TYPE='checkbox' $javascript  NAME='$checkname".'[]'."' value='$key' $tochecked     > $value </td>\n";

				$j++;

			}

		}

	}

	$j--;

	//echo "$cols-($j%$cols)=".$cols-($j%$cols);

	//echo "<BR>($j%$cols)=".($j%$cols);

	for($x=$j%$cols;$x<4;$x++){

		if($x!=3){

			$checkstr.="<td>&nbsp;</td>\n";

		}else{

			$checkstr.="<td>&nbsp;</td></tr>\n";

		}

	}

	$checkstr.="</table>";

	return $checkstr;

}



function country_combo($combo_name = 'country', $sel_value = '', $extra = '', $choose_one = '')

{

	global $str_country_combo;

	$sql = "select country, country from vp_country order by display_order";

	//if($str_country_combo==''){

		$str_country_combo  = make_combo($sql, $combo_name, $sel_value, $extra, $choose_one);

	//}

	return $str_country_combo;

}



function question_combo($combo_name = 'secret_question', $sel_value = '', $extra = '', $choose_one = '')

{

	$sql = "select question, question from vp_question order by question_id";

	return make_combo($sql, $combo_name, $sel_value, $extra, $choose_one);

}



function operator_combo($combo_name = 'admin_id', $sel_value = '', $extra = '', $choose_one = 'All')

{

	$sql = "select admin_id, admin_id from vp_admin order by admin_id";

	return make_combo($sql, $combo_name, $sel_value, $extra, $choose_one);

}



function denomination_combo_admin($currency='USD',$combo_name = 'denomination_id', $sel_value = '', $extra = '', $choose_one = '')

{

	$sql = "select denomination_id, concat(denomination,' (price: ',vprice,')',currency) from vp_card_denom where currency='$currency' order by denomination";



	return make_combo($sql, $combo_name, $sel_value, $extra, $choose_one);

}

function denomination_combo($combo_name = 'denomination_id', $sel_value = '', $extra = '', $choose_one = '')

{

	$sql="select company_country from vp_vendor where vendor_id='".$_SESSION['sess_userid']."'";

	//echo("<br>$sql");

	$country=getsingleresult($sql);

	//if($country!='Nigeria' && $_SESSION['sess_order_currency']!=''){$currency=$_SESSION['sess_order_currency']; }

	//else{ 		$currency=$_SESSION['sess_currency'];	}

	 		$currency=$_SESSION['sess_order_currency'];

			if($currency=='')

							$currency=$_SESSION['sess_currency'];

			

				//echo("<br>$country");

	//$sql="select currency from vp_country where country='$country'";

	//$currency=getsingleresult($sql);

	//echo("<br>$currency");

	$sql = "select denomination_id, concat(denomination,' (price: ',vprice,')',currency) from vp_card_denom where currency='$currency'  order by denomination";

	//echo("<br>$sql");

	return make_combo($sql, $combo_name, $sel_value, $extra, $choose_one);

}



function region_combo($combo_name = 'region_id', $sel_value = '', $extra = '', $choose_one = '')

{

	$sql = "select region_id, region from vp_region order by region";

	return make_combo($sql, $combo_name, $sel_value, $extra, $choose_one);

}



function make_combo($sql, $combo_name, $sel_value = '', $extra = '', $choose_one = '')

{

	$result = executeQuery($sql);

	if (mysql_num_rows($result) > 0) {

		$arrAlbum = Array();

		$strAlbumCombo = "<select name='$combo_name' $extra class='txtfield'>";



		if ($choose_one != '') {

			$strAlbumCombo .= "<option value=''>$choose_one</option>";

		} while ($line = mysql_fetch_array($result)) {

			$strAlbumCombo .= "<option value=\"" . $line[0] . "\"";

			if ($sel_value == $line[0]) {

				$strAlbumCombo .= " selected ";

			} 

			$strAlbumCombo .= ">" . $line[1] . "</option>";

		} 

		$strAlbumCombo .= "</select>";

	} 

	return $strAlbumCombo;

} 

function website_category_combo($name='website_category', $sel_value='', $all=true){

	$arr=array('Clothing'=>'Clothing', 'Business and Services'=>'Business and Services', 'Auction'=>'Auction', 'Books'=>'Books', 'Education'=>'Education', 'Certificate'=>'Certificate', 'Communication'=>'Communication', 'Computer sale'=>'Computer sale', 'Internet subscription '=>'Internet subscription ');

	return array_combo( $arr, $sel_value, $name);

}



function pay_mode_combo($name='pay_mode', $sel_value='', $all=true){

	$arr=array(''=>'All', 'Western Union'=>'Western Union', 'Paypal'=>'Paypal', 'Prepaid Card'=>'Prepaid Card', 'Wire Transfer'=>'Wire Transfer');

	return array_combo( $arr, $sel_value, $name);

}



function admin_acc_type_combo($name='pay_mode', $sel_value='', $all=true){

	$arr=array(''=>'All', 'extra_account_fee'=>'Extra Account Fee', 'loading_fee'=>'Loading Fee', 'transfer_fee'=>'Transfer Fee', 'refund'=>'Refund','order_refund'=>'Order Refund',

		'prepaid_card_order'=>'Prepaid Card Order','reactivation_fee'=>'Reactivation Fee',

		'merchant_order_fee'=>'Merchant Order Fee Refund','Service purchase'=>'Service purchase',

		'processing_fee'=>'Processing Fee','penalty_fee'=>'Penalty Fee','setup_fee'=>'Account Setup Fee','inflation_rate'=>'Inflation Rate','monthly_fee','Monthly Fee','Manual Charge'=>'Manual Charge'

	);

	return array_combo( $arr, $sel_value, $name);

}



function net_income_combo($name='net_income', $sel_value=''){

	$arr=array('$0 to $10000'=>'$0 to $10000', '$10000 to $20000'=>'$10000 to $20000', '$20000 to $50000'=>'$20000 to $50000', '$50000 to $100000'=>'$50000 to $100000', '$100000 and Above'=>'$100000 and Above');

	return array_combo( $arr, $sel_value, $name);

}



function num_employees_combo($name='num_employees', $sel_value='', $all=true){

	$arr=array('0 to 5'=>'0 to 5', '5 to 10'=>'5 to 10', '10 to 20'=>'10 to 20', '20 to 50'=>'20 to 50', '50 to 100'=>'50 to 100', '50 to 100'=>'50 to 100', '100 and Above'=>'100 and Above');

	return array_combo( $arr, $sel_value, $name);

}



function internet_access_combo($name='internet_access', $sel_value='', $all=true){

	$arr=array(''=>'No Connection', 'Dial-Up'=>'Dial-Up', 'ISDN'=>'ISDN', 'Cable'=>'Cable', 'Lease Line'=>'Lease Line', 'T1'=>'T1');

	return array_combo( $arr, $sel_value, $name);

}



function currency_combo($name='currency', $sel_value='', $all=true){

	$arr=array('USD'=>'USD', 'NGN'=>'NGN');

	return array_combo( $arr, $sel_value, $name, 'All');

}



function payment_period_combo($name='payment_period', $sel_value='', $all=true){

	$arr=array('Bi-weekly'=>'Bi-weekly', 'Monthly'=>'Monthly', 'Quarterly'=>'Quarterly');

	return array_combo( $arr, $sel_value, $name);

}

function array_combo( $arr, $sel_value='', $name='', $choose_one='')

{

	$combo="<select name='$name'>";

	if($choose_one!=''){

		$combo.="<option value=''>$choose_one</option>";

	}

	foreach($arr as $key => $value){

		$combo.="<option value='$key'";

		if($sel_value==$key){

			$combo.=" selected ";

		}

		$combo.=" >$value</option>";

	}

	$combo.=" </select>";

	return $combo;

}





function get_qry_str($over_write_key = array(), $over_write_value= array())

{

	global $_GET;

	$m = $_GET;

	if(is_array($over_write_key)){

		$i=0;

		foreach($over_write_key as $key){

			$m[$key] = $over_write_value[$i];

			$i++;

		}

	}else{

		$m[$over_write_key] = $over_write_value;

	}

	$qry_str = qry_str($m);

	return $qry_str;

} 

function qry_str($arr, $skip = '')

{

	$s = "?";

	$i = 0;

	foreach($arr as $key => $value) {

		if ($key != $skip) {

			if ($i == 0) {

				$s .= "$key=$value";

				$i = 1;

			} else {

				$s .= "&$key=$value";

			} 

		} 

	} 



	return $s;

} 

function date_format2($date, $format = 'us', $seperator = '-')

{

	global $arr_month_short;

	if (strlen($date) >= 10) {

		if($date=='0000-00-00' || $date=='0000-00-00 00:00:00'){

			return 'N/A';

		}else{

			if (strtolower($format) == 'us') {

				return $arr_month_short[substr($date, 5, 2)-1] . ' ' . substr($date, 8, 2) . ', ' . substr($date, 0, 4);

			} else if (strtolower($format) == 'eu') {

				return substr($date, 8, 2) . $seperator . substr($date, 5, 2) . $seperator . substr($date, 0, 4);

			} 

		} 

	} else {

		return $s;

	} 

} 

function datetime_format($date, $format = 'us', $seperator = '-')

{

	global $arr_month_short;

	if (strlen($date) >= 10) {

		if($date=='0000-00-00' || $date=='0000-00-00 00:00:00'){

			return 'N/A';

		}else{

			$hour=substr($date, 11, 2);

			if($hour >11){

				$ampm = "PM";

				$hour -= 12;

			}else{

				$ampm = "AM";

			}

			if($hour==0){

				$hour = 12;

			}

			$hour=str_pad($hour, 2, "0", STR_PAD_LEFT);

			if (strtolower($format) == 'us') {

				return $arr_month_short[substr($date, 5, 2)-1] . ' ' . substr($date, 8, 2) . ', ' . substr($date, 0, 4).' '.$hour.':'.substr($date, 14, 2). ' '.$ampm;

			} else if (strtolower($format) == 'eu') {

				return substr($date, 8, 2) . $seperator . substr($date, 5, 2) . $seperator . substr($date, 0, 4).' '.$hour.':'.substr($date, 14, 2). ' '.$ampm;

			} 

		}

	} else {

		return $s;

	} 

}

function time_format($time)

{

	if (strlen($time) >= 5) {

		$hour=substr($time, 0, 2);

		

		if($hour >11){

			$ampm = "PM";

			$hour -= 12;

		}else{

			$ampm = "AM";

		}

		if($hour==0){

			$hour = 12;

		}

		$hour=str_pad($hour, 2, "0", STR_PAD_LEFT);



		return  $hour. ':'.substr($time, 3, 2). ' '.$ampm;

	} else {

		return $s;

	} 

}

function ms_print_r($var)

{

	echo "<pre>";

	print_r($var);

	echo "</pre>";

} 



function strip_slashes($param)

{

	return stripslashes($param);

} 



function add_slashes($param)

{

	$k_param = addslashes(stripslashes($param));

	return $k_param;

} 

function format_db_value($text, $nl2br = false)

{

	if (is_array($text)) {

		$tmp_array = Array();

		foreach($text as $key => $value) {

			$tmp_array[$key] = format_db_value($value);

		} 

		return $tmp_array;

	} else {

		$text = htmlspecialchars(stripslashes($text));

		if ($nl2br) {

			return nl2br($text);

		} else {

			return $text;

		} 

	} 

} 



function ms_stripslashes($text)

{

	if (is_array($text)) {

		$tmp_array = Array();

		foreach($text as $key => $value) {

			$tmp_array[$key] = ms_stripslashes($value);

			//echo($tmp_array[$key]);

		} 

		//ms_print_r($tmp_array);

		return $tmp_array;

	} else {

		return stripslashes($text);

	} 

} 



function ms_addslashes($text)

{

	if (is_array($text)) {

		$tmp_array = Array();

		foreach($text as $key => $value) {

			$tmp_array[$key] = ms_addslashes($value);

		} 

		return $tmp_array;

	} else {

		return addslashes(stripslashes($text));

	} 

} 

function is_image_valid($file_name)

{

	$pos = strrpos($file_name, ".");

	$len = strlen($file_name);

	$ext = substr($file_name , $pos + 1, $len);

	$ext = strtolower($ext);

	if ($ext == "gif" || $ext == "jpg" || $ext == "jpeg" || $ext == "png" || $ext == "bmp") {

		return true;

	} else {

		return false;

	} 

} 



function html2text($html)

{

	$search = array ("'<head[^>]*?>.*?</head>'si", // Strip out javascript

		"'<script[^>]*?>.*?</script>'si", // Strip out javascript

		"'<[\/\!]*?[^<>]*?>'si", // Strip out html tags

		"'([\r\n])[\s]+'", // Strip out white space

		"'&(quot|#34);'i", // Replace html entities

		"'&(amp|#38);'i",

		"'&(lt|#60);'i",

		"'&(gt|#62);'i",

		"'&(nbsp|#160);'i",

		"'&(iexcl|#161);'i",

		"'&(cent|#162);'i",

		"'&(pound|#163);'i",

		"'&(copy|#169);'i",

		"'&#(\d+);'e"); // evaluate as php

	$replace = array ("",

		"",

		"",

		"\\1",

		"\"",

		"&",

		"<",

		">",

		" ",

		chr(161),

		chr(162),

		chr(163),

		chr(169),

		"chr(\\1)");

	$text = preg_replace ($search, $replace, $html); 

	// echo "<br> $text<br>";

	return $text;

} 



function m_echo($str)

{

	global $local_mode;

	if ($local_mode || $debug) {

		echo $str;

	} 

} 





function get_single_rating($feedback_id)

{

	$sql= "	select 

	(sum(feedback_service) + sum(feedback_quality) + sum(feedback_time) + sum(feedback_satisfaction) + sum(feedback_recomend))/5 as rating from music_feedback where feed_back_id='$feedback_id' and buyer_status='1' ";



	//echo "<br> ".$sql;



	//echo getSingleResult($sql);

	return two_zero(getSingleResult($sql));

}



function return_star($final_rating, $pre='')

{

	global $url_prefix2;

	$star="";

	for($i=0;$i<=4;$i++){

		if(($final_rating-$i)>0.5){

			//$star.="<img src='".$url_prefix2."/images/star.gif' border='0'>";

			$star.="<img src='./images/".$pre."star.gif' border='0'>";

		}else if(($final_rating-$i)>0 && ($final_rating-$i)<=0.5){

			//$star.="<img src='".$url_prefix2."/images/star_new.gif' border='0'>";

			$star.="<img src='./images/".$pre."star_new.gif' border='0'>";

		}else{

			//$star.="<img src='".$url_prefix2."/images/star2.gif' border='0'>";

			$star.="<img src='./images/star2.gif' border='0'>";

		}

	}

	//echo "<br> star---".$star;

	return $star;

}





function viewable_col_name($str){

	return ucwords(str_replace('_', ' ', $str));

}



function make_dir($folder){

	global $SSL_PATH;

	/*

	if(strpos($folder, 'uploaded_files')!==false){

		//echo("<br>inside:");

		$folder = str_replace('uploaded_files/', '', $folder);

		echo("<br>$folder");

	}

	echo($SSL_PATH."/scripts/mkdir.pl?folder=$folder");*/

	

	if(!file_exists($folder)){

		if($local_mode){

			@mkdir($folder);

		} else {

			if(strpos($folder, 'uploaded_files')!==false){

				$folder = str_replace('uploaded_files/', '', $folder);

			}

			@file_get_contents($SSL_PATH."/scripts/mkdir.pl?folder=$folder");

		}

	}

}



function getmicrotime()

{ 

	list($usec, $sec) = explode(" ",microtime()); 

	return ((float)$usec + (float)$sec); 

} 



function get_file_ext($file_name){

	$pos	=strrpos($file_name, ".");

	$len	=strlen($file_name);

	$ext	=substr($file_name ,$pos+1, $len-1);

	$ext	=strtolower($ext);

	return $ext;

}



function password_valid($userid, $password, $user_type='customer'){

	$sql="select ".$user_type."_password from music_$user_type where ".$user_type."_userid='$userid' and ".$user_type."_status=1";

	$db_password=getSingleResult($sql);

	if($password!='' && $password==$db_password){

		return true;

	}else{

		return false;

	}

}

function deposit_amount(){

	$sql="select deposit from musician_config";

	return getSingleResult($sql);;

}

function gen_password(){

	$md5=md5(microtime());

	$password=substr($md5, 0 , 8);

	return $password;

}



function cc_encode($s){

	$sql="select encode('$s','nusance')";

	return getSingleResult($sql);

}



function cc_decode($s){

	$s=addslashes($s);

	$sql="select decode('$s','nusance')";

	return getSingleResult($sql);

}



function get_pending_withdrawls($userid){

	$sql="select sum(amount) as pending_withdrawls from music_account where userid='$userid' and status=0 and type='withdrawl'";

	$pending_withdrawls= getSingleResult($sql);

	if($pending_withdrawls==''){

		$pending_withdrawls='0.00';

	}

	return two_zero(-$pending_withdrawls);

}



function get_account_balance($userid,$currency=''){

	if($currency=='')

	{

	$sql="select sum(amount) as balance from vp_account where userid='$userid' and (status=1 or type='withdrawl') and currency='".$_SESSION['sess_currency']."'";

	}

	elseif($currency!=''){

	$sql="select sum(amount) as balance from vp_account where userid='$userid' and (status=1 or type='withdrawl') and currency='$currency'";

	//echo("<br>$sql");

	}

//echo("<br>$sql");

	$account_balance= getSingleResult($sql);

	if($account_balance==''){

		$account_balance='0.00';

	}

	return $account_balance;

}

function get_m_earn_balance($userid,$currency=''){

	if($currency=='')

	{

	$sql="select sum(amount) as balance from vp_merchant_earning where merch_id='$userid' and (status=1 or type='withdrawl') and currency='".$_SESSION['sess_currency']."'";

	}

	elseif($currency!=''){

	$sql="select sum(amount) as balance from vp_merchant_earning where merch_id='$userid' and (status=1 or type='withdrawl') and currency='$currency'";

	//echo("<br>$sql");

	}

//echo("<br>$sql");

	$account_balance= getSingleResult($sql);

	if($account_balance==''){

		$account_balance='0.00';

	}

	return $account_balance;

}

function get_user_currency($vendor_id,$user_type=''){

	$sql="select company_country from vp_vendor where vendor_id='$vendor_id'";

//echo("<br>$sql");

	$country= getSingleResult($sql);

	$sql="select currency from vp_country where country='$country'";

	//echo("<br>$sql");

	$currency = getSingleResult($sql);



	if($currency==''){

		$currency='USD';

	}

	return $currency;

}



function unread_messages($userid){

	$sql="select count(*) from vp_message where userid='$userid' and message_read=0";

	$unread_messages=getSingleResult($sql);

	return $unread_messages;

}





function in_ssl()

{

	if($local_mode){

		return true;

	}else if($_SERVER['HTTPS']=='on') {

		return true;

	}else{

		return false;

	}

}



function authorize_net_data()

{

	$sql="select decode(auth_net_loginid,'nusance'), decode(auth_net_txnkey,'nusance'), decode(yaf,'nusance') from music_config";

	$result=executeQuery($sql);

	while($line=mysql_fetch_array($result)){

		$arr_authorize_net['loginid']	= $line[0];

		$arr_authorize_net['txnkey']	= $line[1];

		$arr_authorize_net['password']	= $line[2];

	}

	return $arr_authorize_net;

}



function ms_file_get_contents($file_name){

	//echo "<br>$file_name<br>";

	return implode ('', file ($file_name));

}



function n_filter($var) {

	return ($var != '');

}



function valid_userid($s)

{

	if(ereg ("^([a-zA-Z0-9_]+)$", $s)) {

		return true;

	} else {

		return false;

	}

}



function enable_users($arr_userids){

	global $ADMIN_EMAIL, $SITE_NAME, $SSL_PATH;

	$str_userids=implode("','",$arr_userids);

	$str_userids="'".$str_userids."'";

	

	$sql = "update vp_user set status='Active', activation_date=now() where userid in ($str_userids)";

	executeUpdate($sql);





$act_date=date("F j, Y, g:i a");

$subject= "Welcome to $SITE_NAME";

$head  = "Content-type: text/html;\r\nFrom: $SITE_NAME <$ADMIN_EMAIL>\r\n";	

$sql="select *,decode(password,'rajesh') as password from	vp_user where userid in ($str_userids)"; 

$result=executeQuery($sql);

while($line=mysql_fetch_array($result)){

	$line = format_db_value($line);

	@extract($line);

	

	if($email!=""){

$message="<pre>

Welcome to $SITE_NAME. You can login to your account at following link. You will be asked to provide following information.



<a href='$SSL_PATH/user.php'>$SSL_PATH/user.php</a>

User ID: $userid

Password: $password

Account Number: $account_number";

if($country=='Nigeria')

{

$message.="Local Account Number: $lc_account_number";

}

$message.="

Activation Date : $act_date

(If the url above does not appear as link then you can copy the URL above and paste it into your browsers address bar)



</pre>".$SITE_NAME;

		eval ("\$message = \"$message\";");

		@mail($email, $subject, $message, $head);

		//echo("$email, $subject, $message, $head");

	}

}

}



function deposit_status($arr_deposit_ids, $status){



	if(is_array($arr_deposit_ids)){

		if(count($arr_deposit_ids)>0) {

			$str_deposit_ids = implode(",", $arr_deposit_ids);

		}

	}

	$sql = "update vp_deposit set status = $status where deposit_id in ($str_deposit_ids)"; 

	executeUpdate($sql);

	$sql = "update vp_account set status = $status where related_id in ($str_deposit_ids) and type='deposit'"; 

	executeUpdate($sql);

	$sql = "update vp_account set status = $status where related_id in ($str_deposit_ids) and type='setup_fee'";

	executeUpdate($sql);

	$sql = "update vp_account set status = $status where related_id in ($str_deposit_ids) and type='loading_fee'";

	executeUpdate($sql);

	$sql = "update vp_admin_account set status = $status where related_id in ($str_deposit_ids) and type='loading_fee'"; 

	executeUpdate($sql);

	$sql = "update vp_admin_account set status = $status where related_id in ($str_deposit_ids) and type='setup_fee'"; 

	executeUpdate($sql);



	foreach($arr_deposit_ids as $deposit_id){

		$sql=" select * from vp_deposit where deposit_id='$deposit_id'";

		$result=executeQuery($sql);

		if($line=mysql_fetch_array($result)){

			@extract($line);

		}

		if($pay_mode=='Western Union'){

			$sql="update vp_western set status='$status' where western_id='$related_id'";

			executeQuery($sql);

		} else if($pay_mode=='Paypal'){

			$sql="update vp_paypal set status='$status' where paypal_id='$related_id'";

			executeQuery($sql);

		} else if($pay_mode=='Wire Transfer'){

			$sql="update vp_wire set status='$status' where wire_id='$related_id'";

			executeQuery($sql);

		} else if($pay_mode=='Prepaid Card'){

			$sql="update vp_prepaid set status='$status' where prepaid_id='$related_id'";

			executeQuery($sql);

		}

		if($type=='initial_payment'){

		

		}else{

			//Place holder for normal deposit operation

		}



	$sql= "insert into vp_message(userid, posted_date, subject, message, message_read) values('$userid', now(), 'Your deposit has been accepted', 'Your deposit of amount: $amount made through $pay_mode has been accepted', '0')";

	executeupdate($sql);

	}

}



/*function order_status($arr_order_ids, $status){

	if(is_array($arr_order_ids)){

		if(count($arr_order_ids)>0) {

			$str_order_ids = implode(",", $arr_order_ids);

		}

	}

	$sql = "update vp_order set status = $status where order_id in ($str_order_ids)"; 

	executeUpdate($sql);

	$sql = "update vp_account set status = $status where related_id in ($str_order_ids) and type='order'"; 

	executeUpdate($sql);

	$sql = "update vp_account set status = $status where related_id in ($str_order_ids) and type='setup_fee'";

	executeUpdate($sql);

	$sql = "update vp_account set status = $status where related_id in ($str_order_ids) and type='loading_fee'";

	executeUpdate($sql);

	$sql = "update vp_admin_account set status = $status where related_id in ($str_order_ids) and type='loading_fee'"; 

	executeUpdate($sql);



	foreach($arr_order_ids as $order_id){

		$sql=" select * from vp_order where order_id='$order_id'";

		$result=executeQuery($sql);

		if($line=mysql_fetch_array($result)){

			@extract($line);

		}

		if($pay_mode=='Western Union'){

			$sql="update vp_western set status='$status' where western_id='$related_id'";

			executeQuery($sql);

		} else if($pay_mode=='Paypal'){

			$sql="update vp_paypal set status='$status' where paypal_id='$related_id'";

			executeQuery($sql);

		} else if($pay_mode=='Wire Transfer'){

			$sql="update vp_wire set status='$status' where wire_id='$related_id'";

			executeQuery($sql);

		} else if($pay_mode=='Prepaid Card'){

			$sql="update vp_prepaid set status='$status' where prepaid_id='$related_id'";

			executeQuery($sql);

		}

		if($type=='initial_payment'){

		

		}else{

			//Place holder for normal order operation

		}



	$sql= "insert into vp_message(userid, posted_date, subject, message, message_read) values('$userid', now(), 'Your order has been accepted', 'Your order of amount: $amount made through $pay_mode has been accepted', '0')";

	executeupdate($sql);

	}

}

*/





function card_cart_total($card_cart){

	$acc_type = $card_cart['acc_type'];

	$sql="select cost, additional_card_cost, virtual_additional_card_cost from vp_acc_type where acc_type='$acc_type'";

	$result=executeQuery($sql);

	if($line=mysql_fetch_array($result)){

		$cost = $line['cost'];

		$additional_card_cost = $line['additional_card_cost'];

		$virtual_additional_card_cost = $line['virtual_additional_card_cost'];

	}

	$total = $cost;

	$i=0;

	foreach($card_cart['arr_ex_cards'] as $ex_card){

		if($i!=0){

			if($ex_card['type']=='virtual'){

				$total += $virtual_additional_card_cost;

			} else {

				$total += $additional_card_cost;

			}

		}

		$i++;

	}

	return $total;

}



function gen_acc_num(){

	$res='1';

	while($res!='') {

		$rand = mt_rand (1000000000, 9999999999);

		$sql="select account_number from vp_user where account_number='$rand'";

		$res=getSingleResult($sql);

	}

	return $rand;

}



function user_data($userid){

	$sql="select * from	vp_user where userid='$userid'";

	$result=executeQuery($sql);

	$user_data=mysql_fetch_array($result);

	return $user_data;

}

function user_data_reseller($userid){

	$sql="select * from	vp_vendor where vendor_id='$userid'";

	$result=executeQuery($sql);

	$user_data_reseller=mysql_fetch_array($result);

//	print_r($user_data_reseller);

	return $user_data_reseller;

}

function user_data_merchant($merchant_id){

	$sql="select * from	vp_merchant where merchant_id='$merchant_id'";

	$result=executeQuery($sql);

	$user_data_reseller=mysql_fetch_array($result);

//	print_r($user_data_reseller);

	return $user_data_reseller;

}



function vendor_data($userid){

	$sql="select * from	vp_vendor where vendor_id='$userid'";

	$result=executeQuery($sql);

	$user_data=mysql_fetch_array($result);

	return $user_data;

}



function get_charge($charge_code, $amount){

	$sql = "select charge_id, type, charge_amount from vp_charge where charge_code='$charge_code'";

	$result=executeQuery($sql);

	if($line=mysql_fetch_array($result)){

		$charge_id		=$line['charge_id'];

		$type			=$line['type'];

		$charge_amount	=$line['charge_amount'];

	}

//echo($type);

	if($type=='slab'){

		$sql = "select slab_amount from vp_charge_slab where '$amount' > start_amount and ('$amount' <= end_amount or end_amount=0)";

		return getSingleResult($sql);

	} else if($type=='percent'){

		return $amount*$charge_amount/100;

	} else if($type=='fixed'){

		return $charge_amount;

	}

}



function export_delimited_file($sql, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' ){

	//session_cache_limiter('public');

	//header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 

	//header("Content-Type: application/force-download");

	header("Content-type: application/txt");

	header("Content-Disposition: attachment; filename=relationfeed_com.txt");

	$arr_db_cols= array_keys($arr_columns);

	$arr_headers= array_values($arr_columns);

//ms_print_r($arr_columns);

//ms_print_r($arr_db_cols);

//ms_print_r($arr_headers);

//ms_print_r($arr_headers);

//ms_print_r($arr_headers);

	$str_columns = implode(',', $arr_db_cols);

	$sql= "select ".$str_columns." $sql" ;

	//echo("<br>$sql");

	$result= executeQuery($sql);

	$num_cols = count($arr_columns);

	//$i=0;



	foreach($arr_headers as $header){

		//$i++;

		echo $header."\t";

		//if($i!=$num_cols){

		//	echo "\t";

		//}

	}

	while($line=mysql_fetch_array($result, MYSQL_ASSOC))

	{

		echo "\r\n";

		//echo("<br> ");

		foreach($line as $key => $value){

			$value=str_replace("\n","",$value);

			$value=str_replace("\r","",$value);

			$value=str_replace("\t","",$value);

			if(is_array($arr_substitutes[$key])){

				$value = $arr_substitutes[$key][$value];

			}

			if(isset($arr_tpls[$key])){

				$code = str_replace('{1}', $value, $arr_tpls[$key]);

				//echo ("\$value = $code;");

				//echo("<br>");

				eval ("\$value = $code;");

			}

			echo $value."\t";

		}

	}

}



function enable_vendors($arr_vendor_ids){

	global $ADMIN_EMAIL, $SITE_NAME, $SSL_PATH;

	$str_vendor_ids=implode("','",$arr_vendor_ids);

	$str_vendor_ids="'".$str_vendor_ids."'";

	

	$sql = "update vp_vendor set status='Active', activation_date=now() where vendor_id in ($str_vendor_ids)";

	executeUpdate($sql);



	$subject= "Welcome to $SITE_NAME";

	$message="

	<pre>Welcome to .$SITE_NAME. Your account has been activated. You can login to your account at following link.



	<a href='$SSL_PATH/vendor_main.php'>$SSL_PATH/vendor_main.php</a>



	(If the url above does not appear as link then you can copy the URL above and paste it into your browsers address bar)



	</pre>".$SITE_NAME;

	

	

	$head  = "Content-type: text/html;\r\nFrom: $SITE_NAME <$ADMIN_EMAIL>\r\n";	

	

	$sql="select *,decode(password,'rajesh') as password from	vp_vendor where vendor_id in ($str_vendor_ids)"; 

	$result=executeQuery($sql);

	while($line=mysql_fetch_array($result)){

		$line = format_db_value($line);

		@extract($line);

		

		if($email!=""){

						/*$message="<pre>

Welcome to $SITE_NAME. You can login to your account at following link. You will be asked to provide following information.



<a href='$SSL_PATH/user.php'>$SSL_PATH/user.php</a>

User ID: $vendor_id

Password: $password

Account Number: $account_number";

if($company_country=='Nigeria')

{

$message.="Local Account Number: $lc_account_number";

}*/

$message.="

(If the url above does not appear as link then you can copy the URL above and paste it into your browsers address bar)



</pre>".$SITE_NAME;

			eval ("\$message = \"$message\";");

			//@mail($email, $subject, $message, $head);

			//echo("$email, $subject, $message, $head");

		}

	}

}



function enable_merchant($arr_merchant_ids){

	global $ADMIN_EMAIL, $SITE_NAME, $SSL_PATH;

	$str_merchant_ids=implode("','",$arr_merchant_ids);

	$str_merchant_ids="'".$str_merchant_ids."'";

	

	$sql = "update vp_merchant set status='Active', activation_date=now() where merchant_id in ($str_merchant_ids)";

	executeUpdate($sql);



	$subject= "Welcome to $SITE_NAME";

	$message="<pre>

	Welcome to $SITE_NAME Your account has been activated. You can login to your account at following link.



	<a href='$SSL_PATH/merchant_main.php'>$SSL_PATH/merchant_main.php</a>



	(If the url above does not appear as link then you can copy the URL above and paste it into your browsers address bar)



	".$SITE_NAME."<pre>";

	

	

	$head  = "Content-type: text/html;\r\nFrom: $SITE_NAME <$ADMIN_EMAIL>\r\n";	

	

	$sql="select *,decode(password,'rajesh') as password from	vp_merchant where merchant_id in ($str_merchant_ids)"; 

	$result=executeQuery($sql);

	while($line=mysql_fetch_array($result)){

		$line = format_db_value($line);

		@extract($line);



		

		if($email!=""){

			$message="<pre>

Welcome to $SITE_NAME. You can login to your account at following link. You will be asked to provide following information.



<a href='$SSL_PATH/user.php'>$SSL_PATH/user.php</a>

User ID: $merchant_id

Password: $password

Account Number: $account_number";

if($company_country=='Nigeria')

{

$message.="Local Account Number: $lc_account_number";

}

$message.="

(If the url above does not appear as link then you can copy the URL above and paste it into your browsers address bar)



</pre>".$SITE_NAME;

			eval ("\$message = \"$message\";");

			@mail($email, $subject, $message, $head);

			//echo("$email, $subject, $message, $head");

		}

	}

}









function approve_vendors($arr_vendor_ids){

	global $ADMIN_EMAIL, $SITE_NAME, $SSL_PATH;

	$str_vendor_ids=implode("','",$arr_vendor_ids);

	$str_vendor_ids="'".$str_vendor_ids."'";





	

	

	$head  = "Content-type: text/html;\r\nFrom: $SITE_NAME <$ADMIN_EMAIL>\r\n";	

	

	$sql="select * from	vp_vendor where vendor_id in ($str_vendor_ids)"; 

	$result=executeQuery($sql);

	while($line=mysql_fetch_array($result)){

		$line = format_db_value($line);

		@extract($line);

		$sql="select country_iso_code_2 from vp_country where country='$country'";

		$result=executeQuery($sql);

		if($line=mysql_fetch_array($result)){

			$country_iso_code_2	=$line['country_iso_code_2']; 

		}

		$reseller_id = gen_reseller_id($first_name, $last_name, $country_iso_code_2);

		$account_number = gen_acc_num();

		$lc_account_number = gen_acc_num();

		if($country=='Nigeria' || $company_country=='Nigeria'){

			//$lc_account_number = gen_acc_num();

		}	

		$sql = "update vp_vendor set approved='1', approval_date=now(), reseller_id='$reseller_id', account_number='$account_number', lc_account_number='$lc_account_number' where vendor_id in ($str_vendor_ids)";

		executeUpdate($sql);

$subject= "Welcome to $SITE_NAME";

$message="<pre>

Welcome to $SITE_NAME You can login to your account at following link. You will be asked to provide following information to login and activate your account.



<a href='$SSL_PATH/vverifyf.php'>$SSL_PATH/vverifyf.php</a>



Reseller ID: $reseller_id

Account Number: $account_number



(If the url above does not appear as link then you can copy the URL above and paste it into your browsers address bar)



</pre>".$SITE_NAME;



$message_for_n_user="

<pre>

Welcome to $SITE_NAME You can login to your account at following link. You will be asked to provide following information to login and activate your account.



<a href='$SSL_PATH/vverifyf.php'>$SSL_PATH/vverifyf.php</a>



Reseller ID: $reseller_id

Account Number: $account_number

Local Account Number: $lc_account_number



(If the url above does not appear as link then you can copy the URL above and paste it into your browsers address bar)



</pre>".$SITE_NAME;

	

		if($email!=""){

			eval ("\$message_for_n_user = \"$message_for_n_user\";");

			eval ("\$message = \"$message\";");

			//ms_print_r($company_country);

			if($company_country=='Nigeria'){

				@mail($email, $subject, $message_for_n_user, $head);

				//echo("$email, $subject, $message_for_n_user, $head");

			}else{

				@mail($email, $subject, $message, $head);

				//echo("$email, $subject, $message, $head");

			}

			

		}

	}

}

function approve_merchant($arr_vendor_ids){

	global $ADMIN_EMAIL, $SITE_NAME, $SSL_PATH;

	$str_vendor_ids=implode("','",$arr_vendor_ids);

	$str_vendor_ids="'".$str_vendor_ids."'";



	

	

	$head  = "Content-type: text/html;\r\nFrom: $SITE_NAME <$ADMIN_EMAIL>\r\n";	

	

	$sql="select *, decode(password,'rajesh') as dec_password from	vp_merchant where merchant_id in ($str_vendor_ids)"; 

	$result=executeQuery($sql);

	while($line=mysql_fetch_array($result)){

		$line = format_db_value($line);

		@extract($line);

		$country = $company_country;

		$sql="select country_iso_code_2 from vp_country where country='$country'";

		$result=executeQuery($sql);

		if($line=mysql_fetch_array($result)){

			$country_iso_code_2	=$line['country_iso_code_2']; 

		}

		$merch_id = gen_reseller_id($first_name, $last_name, $country_iso_code_2);

		$account_number = gen_acc_num();

		$lc_account_number = gen_acc_num();

		if($country=='Nigeria'){

		//	$lc_account_number = gen_acc_num();

		}	

		$sql = "update vp_merchant set approved='1', approval_date=now(), merch_id='$merch_id', account_number='$account_number', lc_account_number='$lc_account_number' where merchant_id in ($str_vendor_ids)";

		executeUpdate($sql);

		$subject= "Welcome to $SITE_NAME";

$message="<pre>

Welcome to $SITE_NAME You can login to your account at following link. You will be asked to provide following information to login and activate your account.



<a href='$SSL_PATH/mverifyf.php'>$SSL_PATH/mverifyf.php</a>



Merchant Id: $merch_id

Account Number: $account_number



(If the url above does not appear as link then you can copy the URL above and paste it into your browsers address bar)



</pre>".$SITE_NAME;



$message_for_n_user="<pre>

Welcome to $SITE_NAME You can login to your account at following link. You will be asked to provide following information to login and activate your account.



<a href='$SSL_PATH/mverifyf.php'>$SSL_PATH/mverifyf.php</a>



Merchant Id: $merch_id

Account Number: $account_number

Local Account Number: $lc_account_number



(If the url above does not appear as link then you can copy the URL above and paste it into your browsers address bar)



</pre>".$SITE_NAME;

	



		if($email!=""){

			eval ("\$message_for_n_user = \"$message_for_n_user\";");

			eval ("\$message = \"$message\";");

			//ms_print_r($company_country);

			if($company_country=='Nigeria'){

				@mail($email, $subject, $message_for_n_user, $head);

				//echo("$email, $subject, $message_for_n_user, $head");

			}else{

				@mail($email, $subject, $message, $head);

				//echo("$email, $subject, $message, $head");

			}

			

		}

	}

}





function gen_reseller_id( $first_name, $last_name, $country_iso_code_2){

	

	$rand = rand (10000, 99999);

	$name_abbr = substr($first_name, 0,2).substr($last_name, 0,2);

	return $country_iso_code_2.$rand.$name_abbr;

}



/*

function gen_reseller_id( $first_name, $last_name, $country_iso_code_2){

	



	$rand = rand (10000, 99999);

	$name_abbr = substr($first_name, 0,2).substr($last_name, 0,2);

	return $country_iso_code_2.$rand.$name_abbr;

}

*/

function userid_exists($userid){



	$sql="select userid from vp_user where userid='$userid'";

	//echo("<br>$sql");

	$res=getSingleResult($sql);

	$sql="select userid from vp_user_deleted where userid='$userid'";

	$res2=getSingleResult($sql);

	

	$sql="select vendor_id from vp_vendor where vendor_id='$userid'";

	$res3=getSingleResult($sql);

	$sql="select vendor_id from vp_vendor_deleted where vendor_id='$userid'";

	$res4=getSingleResult($sql);

	

	$sql="select merchant_id from vp_merchant where merchant_id='$userid'";

	$res5=getSingleResult($sql);

	//$sql="select email from vp_vendor_deleted where merchant_id='$userid'";

	//$res4=getSingleResult($sql);

	

	$s = $res.$res2.$res3.$res4.$res5;

	//echo("<br>:s------$s:");

	if($s==''){

		return false;

	} else{

		return true;

	}

}





function email_exists($email){



	$sql="select userid from vp_user where email='$email'";

	//echo("<br>$sql");

	$res=getSingleResult($sql);

	//$sql="select userid from vp_user_deleted where email='$email'";

	//$res2=getSingleResult($sql);

	

	$sql="select vendor_id from vp_vendor where email='$email'";

	$res3=getSingleResult($sql);

	//$sql="select vendor_id from vp_vendor_deleted where email='$email'";

	//$res4=getSingleResult($sql);

	

	$sql="select merchant_id from vp_merchant where email='$email'";

	$res5=getSingleResult($sql);



	//$s = $res.$res2.$res3.$res4.$res5;

	$s = $res.$res3.$res5;

	//echo("<br>:$s:");

	if($s==''){

		return false;

	} else{

		return true;

	}

}



function sort_arrows($column){

	global $_SERVER;

	return '<div align="right"><A HREF="'.$_SERVER['PHP_SELF'].get_qry_str(array('order_by','order_by2'), array($column,'asc')).'"><IMG SRC="images/uparrow.png" WIDTH="9" HEIGHT="7" BORDER="0"></A><br /><A HREF="'.$_SERVER['PHP_SELF'].get_qry_str(array('order_by','order_by2'), array($column,'desc')).'"><IMG SRC="images/downarrow.png" WIDTH="9" HEIGHT="7" BORDER="0"></A></div>';

}



function check_radio($s, $s2){

	if(is_array($s2)){

		if(in_array($s,$s2)){

			echo " checked ";

		}

	} else if($s==$s2){

		echo " checked ";

	}

}



function gen_prepaid_card_pin($pin=''){

	

	//$sql="select pin from vp_prepaid_card where pin='$pin'";

	//$p=getSingleResult($sql);

//	echo $p."<br>";

	//if($p!=""){

	//	$pin_no=md5(now());

//		validate_pin($pin_no);

	//}else{

	$pin=substr(md5(microtime()), 16, 8);

	//}

//	echo "<br>$pin_no<br>";

	return $pin;	

}



function gen_transaction_num($transaction_id=''){

	$sql="select transaction_id from vp_gate_trans where transaction_id='$transaction_id'";

	$p=getSingleResult($sql);

	$transaction_id=rand(1000000000,getrandmax());

	if($p==$transaction_id){

		

		while($p==$transaction_id)

		{

			$transaction_id=rand(1000000000,getrandmax());

		}

	}

	return $transaction_id;

}



function gen_prepaid_card_id($prepaid_card_id=''){

	//$sql="select prepaid_card_id from vp_prepaid_card where prepaid_card_id='$prepaid_card_id'";

	//$p=getSingleResult($sql);

	//if($p!=""){

	//	$p_c=md5(now());

//		validate_p_card($p_c);

	//}else{

	//	$prepaid_card_id=substr(md5(microtime()), 0, 16);

	//list($usec, $sec) = explode(' ', microtime());

    //$prepaid_card_id=(float) $sec + ((float) $usec * 100000);

    $prepaid_card_id=rand(10000,getrandmax());

	//}



//	echo "<br>$p_c_id<br>";

	return $prepaid_card_id;	

}

function validate_account_with_currency()

{

	//if($_SESSION['sess_account_number']=='' || $_SESSION['sess_lc_account_number']==''){

//		ms_redirect("acc_numf.php?back=".$_SERVER['REQUEST_URI']);

//	}

	if(($_SESSION['sess_currency']=='USD' && $_SESSION['sess_account_number']=='')||($_SESSION['sess_currency']=='NGN' && $_SESSION['sess_lc_account_number']==''))

	{

		$sess_msg_acc='Please fill Account number';

		session_register('sess_msg_acc');

		$_SESSION['sess_msg_acc']=$sess_msg_acc;

		ms_redirect("acc_numf.php?back=".urlencode($_SERVER['REQUEST_URI']));

	}

}



//function make_seed() {

    

//}

//mt_srand(make_seed());

function get_conversion_rate($amount='1.00', $from_code='USD', $from_name='US Dollar', $to_code='NGN', $to_name='Nigerian Naira', $language='en'){

$today= strtotime(date("Y-m-d"));

$sql="select * from vp_config where config_category_id='26'";

$result=executeQuery($sql);

while($line=mysql_fetch_array($result)){

$arr_exp[$line['name']] = $line['value'];

}

$date= $arr_exp['Conversion Date'];

$str = $arr_exp['Conversion Value'];

$date= strtotime($arr_exp['Conversion Date']);

if($date==$today && intval($str)!=0){

	return $str;

}

else{

	$sql="SELECT cache_value FROM vp_cache where cache_name='Conversion Date' and date_format(cache_value,'%Y-%m-%d')=curdate()";

	//echo("<br>$sql");

	$res=getsingleresult($sql);

	if($res== ''){

		$html = @implode ('', file ("http://www.oanda.com/convert/classic?exch=$from_code&expr=$to_code&value=$amount&language=$language"));



		//$html = implode ('', file ('Noname1.html'));

		$start_str = '<!-- conversion result starts  -->';

		$end_str = '<!-- conversion result ends  -->';

		$pos_start = strpos($html, $start_str);

		$str = substr($html, $pos_start);

		$pos_end = strpos($str, $end_str);

		$str = substr($str, 0, $pos_end);

		$str = html2text($str);

		$str = str_replace($amount,'',$str);

		$str = str_replace($from_name,'',$str);

		$str = str_replace('=','',$str);

		$str = str_replace($to_name,'',$str);

		$str = trim($str);

		if($str==''||$str==0)

		{

		$sql="SELECT cache_value FROM vp_cache where cache_name='Conversion Value'";

		$str=getsingleresult($sql);

		}

		$sql="update vp_cache set cache_value=curdate() where cache_name='Conversion Date'";

		executeQuery($sql);

		$sql="update vp_cache set cache_value='$str' where cache_name='Conversion Value'";

		executeQuery($sql);

		return $str;

	} else {

		$sql="SELECT cache_value FROM vp_cache where cache_name='Conversion Value'";

		$res=getsingleresult($sql);

		if($res=='0.000' ||$res=='')

		{

		header("Location: cannot_process.php");

		exit();

		}

		return $res;

	}

}

}



function hide_card_number($card_number){

	return substr($card_number,0,3).'*******'.substr($card_number,10,2);

}

$file_name=basename($PHP_SELF);

//echo("<br>$file_name<br>");

if(is_array($not_auth_admin_user))

{

//echo("<br>sql<br>");

if(in_array($file_name,$not_auth_admin_user) && $from_admin==1) ms_redirect("not_auth.php");

}

function validate_user()

{

	global $sess_user_data;

	if($_SESSION['sess_userid']=='')

	{

	if($_SESSION['sess_user_type']=='vendor' ){		

	ms_redirect("vendor_loginf.php");	

	}

	else if($_SESSION['sess_user_type']=='Merchant'){

		ms_redirect("merchant_loginf.php");

	}

	else{

		ms_redirect("loginf.php");

	}

	}

	

	

	// validate_account_with_currency();

	//if()

	if($_SESSION['sess_user_type']=='vendor'){		

	$sess_user_data = user_data_reseller($_SESSION['sess_userid']);

		if($_SESSION['from_admin']!=1)

		{

			if($sess_user_data['status']!="Active")

			{

			$sql= "update vp_user_session set logged_out=1 where session_id='".session_id()."' and userid='$_SESSION[sess_userid]'";

			executeupdate($sql);

			session_start();

			session_destroy();

			session_unset();

			}

		}

	}

	if($_SESSION['sess_user_type']=='Merchant'){		

	$sess_user_data = user_data_merchant($_SESSION['sess_userid']);

		if($_SESSION['from_admin']!=1)

		{

			if($sess_user_data['status']!="Active")

			{

				$sql= "update vp_user_session set logged_out=1 where session_id='".session_id()."' and userid='$_SESSION[sess_userid]'";

				executeupdate($sql);

				session_start();

				session_destroy();

				session_unset();

			}

		}

	}

	if($_SESSION['sess_user_type']=='normal'){		

	$sess_user_data = user_data($_SESSION['sess_userid']);

	if($_SESSION['from_admin']!=1)

	{

	if($sess_user_data['status']!="Active" && $sess_user_data['paid_status']!=0)

	{

		

		$sql= "update vp_user_session set logged_out=1 where session_id='".session_id()."' and userid='$_SESSION[sess_userid]'";

		executeupdate($sql);

		session_start();

		session_destroy();

		session_unset();

		

	}

	}

	}

}

function unlink_file( $file_name , $folder_name )

{

	$file_path = $folder_name."/".$file_name;

	@chmod ($foleder_name , 0777);

	@unlink($file_path);

	return true;	

}

function create_email( $userid , $password )

{

	if($_ENV['OS']=='Windows_NT')

	{

	system ("net user $userid $password /add");

	//exit();

	return true;

	}

	elseif($_ENV['TERM']=="linux"){

	system ("user add $userid $password");

	//exit();

	return true;

	}

}

function complaint_combo($combo_name = 'complaint_cat', $sel_value = '', $extra = '', $choose_one = '')

{

	global $str_complaint_combo;

	$sql = "select cat_name, cat_name from vp_complaint_category";

	//if($str_country_combo==''){

		$str_complaint_combo  = make_combo($sql, $combo_name, $sel_value, $extra, $choose_one);

	//}

	return $str_complaint_combo;

}



function conversion_usd_to_ngn($userid,$needed_amount,$is_vendor)

{

	$conversion_rate=get_conversion_rate();

	$inflation_rate = get_charge('inflation_rate_usd_to_ngn', $needed_amount);

	

	$sql= "INSERT INTO vp_account (userid, particular, amount, datetime, type, related_id, status,currency,is_vendor) VALUES ('$sess_userid', 'Conversion from USD to NGN', ".-($needed_amount/$conversion_rate).", now(), 'to_conversion', '', 1,'USD',$is_vendor)";

		//echo("<br>$sql");

	executeQuery($sql);

	$sql= "INSERT INTO vp_account (userid, particular, amount, datetime, type, related_id, status,currency,is_vendor) VALUES ('$sess_userid', 'Conversion from USD to NGN', '$needed_amount', now(), 'from_conversion', '', 1,'NGN',$is_vendor)";

		//echo("<br>$sql");

	executeQuery($sql);

	$sql= "INSERT INTO vp_account (userid, particular, amount, datetime, type, related_id, status,currency,is_vendor) VALUES ('$userid', 'Inflation Rate', '-$inflation_rate', now(), 'inflation_rate', '', 1,'NGN',$is_vendor)";

	executeQuery($sql);



	//echo("<br>$sql");

	$sql= "INSERT INTO vp_admin_account ( userid, particular, amount, datetime, type, related_id, status, currency, is_vendor) VALUES ('$userid', 'Inflation Rate', '$inflation_rate', now(), 'monthly_fee', '', 1,'NGN', $is_vendor)";

	executeQuery($sql);







}

function conversion_ngn_to_usd($userid,$needed_amount,$is_vendor)

{

	$conversion_rate=get_conversion_rate();

	$inflation_rate = get_charge('inflation_rate_ngn_to_usd', $merchant_monthly_fee_ngn);

	$sql= "INSERT INTO vp_account (userid, particular, amount, datetime, type, related_id, status,currency,is_vendor) VALUES ('$userid', 'Conversion from NGN to USD', ".-($needed_amount*$conversion_rate).", now(), 'to_conversion', '', 1,'NGN',$is_vendor)";

	executeQuery($sql);

	//echo("<br>$sql");

	$sql= "INSERT INTO vp_account (userid, particular, amount, datetime, type, related_id, status,currency,is_vendor) VALUES ('$userid', 'Conversion from  NGN to USD', '$needed_amount', now(), 'from_conversion', '', 1,'USD',$is_vendor)";

	executeQuery($sql);

	$sql= "INSERT INTO vp_account (userid, particular, amount, datetime, type, related_id, status,currency,is_vendor) VALUES ('$userid', 'Inflation Rate', '-$inflation_rate', now(), 'inflation_rate', '', 1,'USD',$is_vendor)";

	executeQuery($sql);



	//echo("<br>$sql");

	$sql= "INSERT INTO vp_admin_account ( userid, particular, amount, datetime, type, related_id, status, currency, is_vendor) VALUES ('$userid', 'Inflation Rate', '$inflation_rate', now(), 'monthly_fee', '', 1,'USD', $is_vendor)";

	executeQuery($sql);

}



function mail_successfull($email,$merchant_id,$CUSTOMER_CARE_EMAIL){

	global $SITE_NAME,$ADMIN_EMAIL;

	$subject="$SITE_NAME: Monthly Fees has been made";

	$head  = "Content-type: text/html;\r\nFrom: $SITE_NAME <$ADMIN_EMAIL>\r\n";

	$message="Dear $merchant_id, 

	<br>The Monthly Fees has been made from your account. 

	<br>$SITE_NAME";

	@mail($email,$subject,$message);

	@mail($ADMIN_EMAIL,$subject,$message,$head);

	echo("$email,$subject,$message");

	

}

function mail_unsuccessfull($email,$merchant_id,$CUSTOMER_CARE_EMAIL){

	global $SITE_NAME,$ADMIN_EMAIL;

	$subject="$SITE_NAME: Monthly Fees has been made";

	$head  = "Content-type: text/html;\r\nFrom: $SITE_NAME <$ADMIN_EMAIL>\r\n";

	$message="Dear $merchant_id, 

	<br>The Monthly Fees could not be made due to insuffient funds in the account. 

	<br>Please Load Amount in your account.

	<br>your account tempararly deactivated, Please contact to customer care

	<br>$SITE_NAME";

	@mail($email,$subject,$message,$head);

	@mail($ADMIN_EMAIL,$subject,$message,$head);

	echo("$email,$subject,$message");



}





function get_expiry_date()

{

	/*********************************** old code*************************

		$sql="select * from vp_config where config_category_id='11'";

	$result=executeQuery($sql);

	$arr_exp= array();

	while($line=mysql_fetch_array($result)){

		$arr_exp[$line['name']] = $line['value'];

	}

	date_add(curdate(), INTERVAL {$arr_exp['Time Value']} {$arr_exp['Time Unit']}) 

	**********/

	$sql="select * from vp_config where config_id in (88, 89)";

	$result=executeQuery($sql);

	while($line=mysql_fetch_array($result)){

	if($line['config_id']==88){

	$minimum_days = $line['value'];

	} else if($line['config_id']==89){

	$maximum_days = $line['value'];

	}

	}

	$days=rand($minimum_days,$maximum_days);

	$sql="select date_add(curdate(), INTERVAL $days day)";

	$res=getsingleresult($sql);

	return $res;

}

function module_checkbox($checkname='module', $checksel='', $cols='3', $missit='', $style='', $tableattr=''){

	global $ARR_ADMIN_MODULES;

	return makeCheckbox($ARR_ADMIN_MODULES, $checkname, $checksel, $cols, $missit, $style, $tableattr);

}

function module_user_checkbox($checkname='module', $checksel='', $cols='4', $missit='', $style='', $tableattr=''){

	global $ARR_USER_ADMIN_MODULES;

	return makeCheckbox($ARR_USER_ADMIN_MODULES, $checkname, $checksel, $cols, $missit, $style, $tableattr);

}

function module_reseller_checkbox($checkname='module', $checksel='', $cols='4', $missit='', $style='', $tableattr=''){

	global $ARR_RESELLER_ADMIN_MODULES;

	return makeCheckbox($ARR_RESELLER_ADMIN_MODULES, $checkname, $checksel, $cols, $missit, $style, $tableattr);

}

function module_merchant_checkbox($checkname='module', $checksel='', $cols='4', $missit='', $style='', $tableattr=''){

	global $ARR_MERCHANT_ADMIN_MODULES;

	return makeCheckbox($ARR_MERCHANT_ADMIN_MODULES, $checkname, $checksel, $cols, $missit, $style, $tableattr);

}





function new_emails($userid){

	

	$host = 'relationfeed.com';

	$con = '{'.$host.":143/imap/tls/novalidate-cert}";

	echo("<br>checking new emails: $con:$userid:".strrev($userid));

	$mbox = imap_open($con, $userid.'@'.$host, strrev($userid));

	$status = imap_status($mbox,'{'.$host.'}'."INBOX",SA_ALL);

	print_r($status);

	if($status) {

	  return $status->unseen;

	} else {

		return false;

	}

}



function check_availability($qid,$uid)

{

	

	$sql="select question_id, user_id from feedlike where question_id=$qid and user_id=$uid";

	$result=mysql_query($sql);

	$res=mysql_num_rows($result);

	return $res;

}



function check_p($uid)

{

	

	$sql="select count(user_id) from feedlike where user_id=$uid";

	$result=mysql_query($sql);

	$res=mysql_fetch_array($result);

	return $res[0];

}



function check_c($uid)

{

	

	$sql="select count(userid) from answer where userid=$uid";

	$result=mysql_query($sql);

	$res=mysql_fetch_array($result);

	return $res[0];

}





function validate_admin()

{



}

?>