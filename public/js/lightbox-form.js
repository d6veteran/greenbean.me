function getXMLHTTP() { //fuction to return the xml http object
var xmlhttp=false;
try{
xmlhttp=new XMLHttpRequest();
}
catch(e) {
try{
xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
}
catch(e){
try{
req = new ActiveXObject("Msxml2.XMLHTTP");
}
catch(e1){
xmlhttp=false;
}
}
}

return xmlhttp;
}


function getEditArtValues(baseUrl,ArtId) {
document.getElementById('boxeditprofile').innerHTML='<img src="images/wait.gif" alt="Please Wait for AJAX Results">';

var strURL=baseUrl+"public/ajex/editartworkvalues.php?ArtId="+ArtId;
var req = getXMLHTTP();

if (req) {

req.onreadystatechange = function() {
if (req.readyState == 4) {document.getElementById('boxeditprofile').innerHTML=req.responseText;
// only if "OK"
/*if (req.status == 200) {
//alert(req.responseText);
document.getElementById('boxeditprofile').innerHTML=req.responseText;
} else {
alert("There was a problem while using XMLHTTP:\n" + req.statusText);
}*/
}
}
req.open("GET", strURL, true);
req.send(null);
}


}


function gradient(id, level)
{
	var box = document.getElementById(id);
	box.style.opacity = level;
	box.style.MozOpacity = level;
	box.style.KhtmlOpacity = level;
	box.style.filter = "alpha(opacity=" + level * 100 + ")";
	box.style.display="block";
	return;
}


function fadein(id) 
{
	var level = 0;
	while(level <= 1)
	{
		setTimeout( "gradient('" + id + "'," + level + ")", (level* 1000) + 10);
		level += 0.01;
	}
}

function openboxalert(formtitle1,fadin)
{

$("#test_message1").replaceWith("<span id='test_message1'>"+formtitle1+"</span>");
var box_alert = document.getElementById('box_alert');
document.getElementById('filter_alert').style.display='block';


if(fadin)
{

gradient("box_alert", 0);
fadein("box_alert");
}
else
{
box_alert.style.display='block';
}

}
function openbox_signin(formtitle, fadin)
{

  var boxsignin = document.getElementById('boxsignin'); 
  document.getElementById('filtersignin').style.display='block';
  
 
  var btitle = document.getElementById('boxsignintitle');
  btitle.innerHTML = formtitle;
  
  if(fadin)
  {
	 gradient("boxsignin", 0);
	 fadein("boxsignin");
  }
  else
  { 	
    boxallfan.style.display='block';
  }  	
}

function openboxallfan(formtitle, fadin)
{

  var boxallfan = document.getElementById('boxallfan'); 
  document.getElementById('filterallfan').style.display='block';
  
 
  var btitle = document.getElementById('boxallfantitle');
  btitle.innerHTML = formtitle;
  
  if(fadin)
  {
	 gradient("boxallfan", 0);
	 fadein("boxallfan");
  }
  else
  { 	
    boxallfan.style.display='block';
  }  	
}

// Open the lightbox
function openboxfan(formtitle, fadin)
{
 
  var boxfan = document.getElementById('boxfan'); 
  document.getElementById('filterfan').style.display='block';
  
  var btitle = document.getElementById('boxfantitle');
  btitle.innerHTML = formtitle;
  
  if(fadin)
  {
	 gradient("boxfan", 0);
	 fadein("boxfan");
  }
  else
  { 	
    boxfan.style.display='block';
  }  	
}



function openbox_leader_signup(formtitle, fadin)
{
  var box = document.getElementById('box'); 
  document.getElementById('filter').style.display='block';
   
  var btitle = document.getElementById('boxtitle');
  btitle.innerHTML = formtitle;
  
  if(fadin)
  {
	 gradient("box", 0);
	 fadein("box");
  }
  else
  { 	
    box.style.display='block';
  }  	
}

function openbox(formtitle, fadin)
{
  var box = document.getElementById('box'); 
  document.getElementById('filter').style.display='block';

  var btitle = document.getElementById('boxtitle');
  btitle.innerHTML = formtitle;
  
  if(fadin)
  {
	 gradient("box", 0);
	 fadein("box");
  }
  else
  { 	
    box.style.display='block';
  }  	
}



function openbox1(formtitle1, fadin)
{
	
  var box1 = document.getElementById('box1'); 
  
 document.getElementById('filter1').style.display='block';

    
  if(fadin)
  {
	  
	 gradient("box1", 0);
	 fadein("box1");
  }
  else
  { 	
    box1.style.display='block';
  } 
  
}

function openbox_leader(formtitle1, fadin)
{
	
  var boxleader = document.getElementById('boxleader'); 
  
 document.getElementById('filterleader').style.display='block';

var btitle = document.getElementById('boxleadertitle');
  btitle.innerHTML = formtitle1;
    
  if(fadin)
  {
	  
	 gradient("boxleader", 0);
	 fadein("boxleader");
  }
  else
  { 	
    boxleader.style.display='block';
  } 
  
}
function forgotpass_leader(formtitle, fadin)
{
var forgotpassId = document.getElementById('forgotpassId'); 
  document.getElementById('filterforgotpass').style.display='block';


  document.getElementById('boxleader').style.display='none';
  document.getElementById('filterleader').style.display='none';

  var btitle = document.getElementById('forgotpasstitle');
  btitle.innerHTML = formtitle;
  
  if(fadin)
  {
	 gradient("forgotpassId", 0);
	 fadein("forgotpassId");
  }
  else
  { 	
    forgotpassId.style.display='block';
  }  		
	
}


function forgotpass(formtitle, fadin)
{
  var forgotpassId = document.getElementById('forgotpassId'); 
  document.getElementById('filterforgotpass').style.display='block';

  var btitle = document.getElementById('forgotpasstitle');
  btitle.innerHTML = formtitle;
  
  if(fadin)
  {
	 gradient("forgotpassId", 0);
	 fadein("forgotpassId");
  }
  else
  { 	
    forgotpassId.style.display='block';
  }  	
}



function addfund(formtitle, fadin)
{

var fundsId = document.getElementById('fundsId'); 
  document.getElementById('filterfunds').style.display='block';


  var btitle = document.getElementById('fundstitle');
  btitle.innerHTML = formtitle;
  
  if(fadin)
  {
	 gradient("fundsId", 0);
	 fadein("fundsId");
  }
  else
  { 	
    fundsId.style.display='block';
  }  		
	
}


// Close the lightbox

function closeboxs()
{
	  $(".formErrorContent").hide();
  $(".formErrorArrow").hide();
   document.getElementById('box').style.display='none';
   document.getElementById('filter').style.display='none';
}

function closebox1()
{
		  $(".formErrorContent").hide();
  $(".formErrorArrow").hide();
   document.getElementById('box1').style.display='none';
   document.getElementById('filter1').style.display='none';
}
function p_closebox()
{
  $(".formErrorContent").hide();
  $(".formErrorArrow").hide();
  document.getElementById('forgotpassId').style.display='none';
   document.getElementById('filterforgotpass').style.display='none';
  
   
}


function closeboxleader()
{
  $(".formErrorContent").hide();
  $(".formErrorArrow").hide();
   document.getElementById('boxleader').style.display='none';
   document.getElementById('filterleader').style.display='none';
}


function funds_closebox()
{
    document.getElementById('fundsId').style.display='none';
   document.getElementById('filterfunds').style.display='none';
}
function forgotpass(formtitle, fadin)
{
var boxforgotpass = document.getElementById('boxforgotpass');
document.getElementById('filterforgotpass').style.display='block';
var btitle = document.getElementById('boxforgotpasstitle');
btitle.innerHTML = formtitle;
if(fadin)
{
gradient("boxforgotpass", 0);
fadein("boxforgotpass");
}
else
{
boxforgotpass.style.display='block';
}
}

function openlightbox(status,sm)
{
	

if(status == 2 && sm == 0)
	{
	
openbox_trackno('Title of Form', 1);
	}

}
function openbox_artcomp(formtitle1, fadin)
{
	var boxartcomp = document.getElementById('boxartcomp'); 
  //alert(boxbet);
  document.getElementById('filterartcomp').style.display='block';

  var btitle = document.getElementById('boxartcomptitle');
  btitle.innerHTML = formtitle1;
    
  if(fadin)
  {
	  
	 gradient("boxartcomp", 0);
	 fadein("boxartcomp");
  }
  else
  { 	
    boxartcomp.style.display='block';
  } 
  
}


function openbox_trackno(formtitle1, fadin)
{
	var boxtrackno = document.getElementById('boxtrackno'); 
  //alert(boxbet);
  document.getElementById('filtertrackno').style.display='block';

  var btitle = document.getElementById('boxtracknotitle');
  btitle.innerHTML = formtitle1;
    
  if(fadin)
  {
	  
	 gradient("boxtrackno", 0);
	 fadein("boxtrackno");
  }
  else
  { 	
    boxtrackno.style.display='block';
  } 
  
}

function openbox_editArtwork(formtitle, fadin)
{
	
var boxeditprofile = document.getElementById('boxeditprofile');
document.getElementById('filtereditprofile').style.display='block';
var btitle = document.getElementById('boxeditprofiletitle');
btitle.innerHTML = formtitle;
if(fadin)
{
gradient("boxeditprofile", 0);
fadein("boxeditprofile");
}
else
{
boxeditprofile.style.display='block';
}
}


function closebox(box1)
{
  $(".formErrorContent").hide();
  $(".formErrorArrow").hide();
   document.getElementById('box'+box1).style.display='none';
   document.getElementById('filter'+box1).style.display='none';
}


/****************FUNCTIONS CREATED BY GAGAN FOR CLOSING CREATE GROUP LIGHTBOX*********************************/
function creategroup_openbox_groups(formtitle, fadin)
{
	
  var boxgroup = document.getElementById('creategroup_boxgroup'); 
  document.getElementById('creategroup_filtergroup').style.display='block';
  
 alert("Gagan");

  var btitle = document.getElementById('creategroup_boxgrouptitle');
  btitle.innerHTML = formtitle;
  
  if(fadin)
  {
	 gradient("creategroup_boxgroup", 0);
	 fadein("creategroup_boxgroup");
  }
  else
  { 	
    box.style.display='block';
  }  	
}

function closeCreateGroup(box1)
{
  $(".formErrorContent").hide();
  $(".formErrorArrow").hide();
   document.getElementById('creategroup_box'+box1).style.display='none';
   document.getElementById('creategroup_filter'+box1).style.display='none';
}


/****************END FUNCTIONS CREATED BY GAGAN FOR CLOSING CREATE GROUP LIGHTBOX 5MAY*********************************/


/* coded by venktesh 7 april         */
function openboximage(formtitle1,fadin)
{	
  var box_image = document.getElementById('box_image'); 
  
 document.getElementById('filter_image').style.display='block';
var btitle = document.getElementById('boxpasstitle');
btitle.innerHTML = formtitle1;
    
  if(fadin)
  {
	  
	 gradient("box_image", 0);
	 fadein("box_image");
  }
  else
  { 	
    box_image.style.display='block';
  } 
  
}

function closeboximage()
{
		  $(".formErrorContent").hide();
  $(".formErrorArrow").hide();
   document.getElementById('box_image').style.display='none';
   document.getElementById('filter_image').style.display='none';
}
function edit_user_profile(formtitle,fadin)
{
var boxeditprofile = document.getElementById('box_edit_user_profile');
document.getElementById('filter_edit_user_profile').style.display='block';
var btitle = document.getElementById('boxedit_user_profiletitle');
btitle.innerHTML = formtitle;
if(fadin)
{
gradient("box_edit_user_profile", 0);
fadein("box_edit_user_profile");
}
else
{
box_edit_user_profile.style.display='block';
}
}



function closeboxedit_user_profile()
{
$(".formErrorContent").hide();
  $(".formErrorArrow").hide();
   document.getElementById('box_edit_user_profile').style.display='none';
   document.getElementById('filter_edit_user_profile').style.display='none';
}



function edit_plan_mangement(formtitle,fadin)
{
var boxeditprofile = document.getElementById('box_plan');
document.getElementById('filter_plan').style.display='block';
var btitle = document.getElementById('boxplantitle');
btitle.innerHTML = formtitle;
if(fadin)
{
gradient("box_plan", 0);
fadein("box_plan");
}
else
{
box_edit_user_profile.style.display='block';
}
}



function closeedit_plan_mangement()
{
$(".formErrorContent").hide();
  $(".formErrorArrow").hide();
   document.getElementById('box_plan').style.display='none';
   document.getElementById('filter_plan').style.display='none';
}

///////////////////////////////////////coded by venktesh
function contacttoamt(formtitle,fadin)
{
var boxeditprofile = document.getElementById('box_contact');
document.getElementById('filter_contact').style.display='block';
var btitle = document.getElementById('boxcontacttitle');
btitle.innerHTML = formtitle;
if(fadin)
{
gradient("box_contact", 0);
fadein("box_contact");
}
else
{
box_edit_user_profile.style.display='block';
}
}



function closeecontacttoamt()
{
$(".formErrorContent").hide();
  $(".formErrorArrow").hide();
   document.getElementById('box_contact').style.display='none';
   document.getElementById('filter_contact').style.display='none';
}


function sendmessage(formtitle,fadin)
{
var boxeditprofile = document.getElementById('box_sendmessage');
document.getElementById('filter_sendmessage').style.display='block';
var btitle = document.getElementById('boxsendmessagetitle');
btitle.innerHTML = formtitle;
if(fadin)
{
gradient("box_sendmessage", 0);
fadein("box_sendmessage");
}
else
{
box_sendmessage.style.display='block';
}
}



function closesendmessage()
{
$(".formErrorContent").hide();
  $(".formErrorArrow").hide();
   document.getElementById('box_sendmessage').style.display='none';
   document.getElementById('filter_sendmessage').style.display='none';
}




function getEditCommision(baseUrl,CommId) {
	
document.getElementById('boxeditprofile').innerHTML='<img src="public/images/loader_NOT.gif" alt="Please Wait for AJAX Results">';

var strURL=baseUrl+"public/ajex/editCommisionValue.php?CommId="+CommId;
var req = getXMLHTTP();

if (req) {

req.onreadystatechange = function() {
if (req.readyState == 4) {
	document.getElementById('boxeditprofile').innerHTML=req.responseText;

// only if "OK"
if (req.status == 200) {

document.getElementById('boxeditprofile').innerHTML=req.responseText;
} else {
alert("There was a problem while using XMLHTTP:\n" + req.statusText);
}
}
}
req.open("GET", strURL, true);
req.send(null);
}


}





////////////////////////////////////coded by venktesh///////////////////////////////////////////////////

function readMessage(formtitle,fadin)
{
var boxeditprofile = document.getElementById('box_readmessage');
document.getElementById('filter_readmessage').style.display='block';
var btitle = document.getElementById('boxreadmessagetitle');
btitle.innerHTML = formtitle;
if(fadin)
{
gradient("box_readmessage", 0);
fadein("box_readmessage");
}
else
{
box_readmessage.style.display='block';
}
}



function closereadMessage()
{
$(".formErrorContent").hide();
  $(".formErrorArrow").hide();
   document.getElementById('box_readmessage').style.display='none';
   document.getElementById('filter_readmessage').style.display='none';
}
//////////////////////////////////////////////////////////////////////////////
function sendmessage1(formtitle,fadin)
{
var boxeditprofile = document.getElementById('box_sendmessage1');
document.getElementById('filter_sendmessage1').style.display='block';
var btitle = document.getElementById('boxsendmessagetitle1');
btitle.innerHTML = formtitle;
if(fadin)
{
gradient("box_sendmessage1", 0);
fadein("box_sendmessage1");
}
else
{
box_sendmessage.style.display='block';
}
}



function closesendmessage1()
{
$(".formErrorContent1").hide();
  $(".formErrorArrow1").hide();
   document.getElementById('box_sendmessage1').style.display='none';
   document.getElementById('filter_sendmessage1').style.display='none';
}





<!-- added by Gagan for visit group-->

function startbox_groups(formtitle, fadin)
{
  var startboxgroup = document.getElementById('startboxgroup'); 
  document.getElementById('startfiltergroup').style.display='block';
  
 

  var btitle = document.getElementById('startboxgrouptitle');
  btitle.innerHTML = formtitle;
  
  if(fadin)
  {
	 gradient("startboxgroup", 0);
	 fadein("startboxgroup");
  }
  else
  { 	
    box.style.display='block';
  }  	
}


/* coded by Gagan 30 april 2010        */
function startclosebox(box1)
{
  $(".formErrorContent").hide();
  $(".formErrorArrow").hide();
   document.getElementById('startbox'+box1).style.display='none';
   document.getElementById('startfilter'+box1).style.display='none';
}

function openbox_groups(formtitle, fadin)
{
  var boxgroup = document.getElementById('boxgroup'); 
  document.getElementById('filtergroup').style.display='block';
  
 

  var btitle = document.getElementById('boxgrouptitle');
  btitle.innerHTML = formtitle;
  
  if(fadin)
  {
	 gradient("boxgroup", 0);
	 fadein("boxgroup");
  }
  else
  { 	
    box.style.display='block';
  }  	
}








function displayArtwork(baseUrl,ArtId) {
	

document.getElementById('group_list').innerHTML='<img src="public/images/loader_NOT.gif" alt="Please Wait for AJAX Results">';

var strURL=baseUrl+"public/ajex/displayArtwork.php?ArtId="+ArtId;
var req = getXMLHTTP();

if (req) {

req.onreadystatechange = function() {
if (req.readyState == 4) {
	document.getElementById('group_list').innerHTML=req.responseText;

// only if "OK"
if (req.status == 200) {

document.getElementById('group_list').innerHTML=req.responseText;
} else {
alert("There was a problem while using XMLHTTP:\n" + req.statusText);
}
}
}
req.open("GET", strURL, true);
req.send(null);
}


}




function displayArtworkJoin(baseUrl,ArtId) {
	

document.getElementById('boxgroup').innerHTML='<img src="public/images/loader_NOT.gif" alt="Please Wait for AJAX Results">';

var strURL=baseUrl+"public/ajex/displayArtwork.php?ArtId="+ArtId;
var req = getXMLHTTP();

if (req) {

req.onreadystatechange = function() {
if (req.readyState == 4) {
	document.getElementById('boxgroup').innerHTML=req.responseText;

// only if "OK"
if (req.status == 200) {

document.getElementById('boxgroup').innerHTML=req.responseText;
} else {
alert("There was a problem while using XMLHTTP:\n" + req.statusText);
}
}
}
req.open("GET", strURL, true);
req.send(null);
}


}



