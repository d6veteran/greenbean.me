function createjsDOMenu() {
	lib_data="Library Manager ";
	job_data="Job Manager";
	absoluteMenu1 = new jsDOMenu(190, "absolute", "", true);
	with (absoluteMenu1) {
    addMenuItem(new menuItem("Admin Home", "item0", "admin_desktop.php"));
	addMenuItem(new menuItem("-"));
	addMenuItem(new menuItem("Home Page Manager", "", "home_content_list.php"));
    addMenuItem(new menuItem("Article Manager", "item2", "article_list.php"));
	addMenuItem(new menuItem(lib_data, "", "function_list.php"));
	//addMenuItem(new menuItem("Resource Manager", "", "resource_list1.php"));
	addMenuItem(new menuItem(job_data, "item4", "job_list.php"));
	addMenuItem(new menuItem("Member Manager", "user", "user_list.php"));
	addMenuItem(new menuItem("Event Manager", "", "event_list.php"));
	addMenuItem(new menuItem("Newsletter/Email Manager", "newsletter", "nl_sub_list.php"));
	addMenuItem(new menuItem("Funding/RFP Manager", "", "fund_list.php"));
	addMenuItem(new menuItem("Poll Manager", "poll", "poll_list.php"));
	//addMenuItem(new menuItem("System Manager", "item5", "#"));
	//addMenuItem(new menuItem("Static Content Manager", "", "static_content_list.php"));
	addMenuItem(new menuItem("Config Manager", "config", "config_addf.php"));
	addMenuItem(new menuItem("Email Manager", "mail", "admin_email_list.php"));
	addMenuItem(new menuItem("Change Admin Password", "pass", "change_passf.php"));
	addMenuItem(new menuItem("-"));
	addMenuItem(new menuItem("Customer Support", "", "mailto:techsupport@marknetgroup.com?CC=gnieves@marknetgroup.com"));
	addMenuItem(new menuItem("-"));
	addMenuItem(new menuItem("Admin Logout", "", "logout.php"));
    moveTo(25, 140);
    show();
  }
  
/*  absoluteMenu1_2 = new jsDOMenu(160, "absolute");
  with (absoluteMenu1_2) {
    addMenuItem(new menuItem("My WorkforceUSA.net", "item1", "#"));
    addMenuItem(new menuItem("Jobs", "item2", "#"));
    addMenuItem(new menuItem("Region", "", "region_list.php"));
    addMenuItem(new menuItem("Incentive Program", "", "point_list.php"));
    addMenuItem(new menuItem("Funding Opportunities", "item3", "region_list.php"));
    addMenuItem(new menuItem("Events", "item4", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Resources", "item5", "#"));
  }
  
  
  
  absoluteMenu1_2_1 = new jsDOMenu(190, "absolute");
  with (absoluteMenu1_2_1) {
    addMenuItem(new menuItem("Organization Type", "", "org_type_list.php"));
    addMenuItem(new menuItem("Developement Areas", "", "dev_area_list.php"));
    addMenuItem(new menuItem("Developement Position", "", "position_list.php"));
  }
  
  absoluteMenu1_2_2 = new jsDOMenu(150, "absolute");
  with (absoluteMenu1_2_2) {
    addMenuItem(new menuItem("Job Type", "", "job_type_list.php"));
    addMenuItem(new menuItem("Job Category", "", "job_cat_list.php"));
  }
  absoluteMenu1_2_3 = new jsDOMenu(150, "absolute");
  with (absoluteMenu1_2_3) {
    addMenuItem(new menuItem("Funding Types", "", "fund_type_list.php"));
  }
  absoluteMenu1_2_4 = new jsDOMenu(150, "absolute");
  with (absoluteMenu1_2_4) {
    addMenuItem(new menuItem("Event Types", "", "event_type_list.php"));
  }
  absoluteMenu1_2_5 = new jsDOMenu(180, "absolute");
  with (absoluteMenu1_2_5) {
    addMenuItem(new menuItem("Resource Type Manager", "", "res_type_list.php"));
    addMenuItem(new menuItem("Organization Manager", "", "organization_list.php"));
    addMenuItem(new menuItem("Population Manager", "", "population_list.php"));
    addMenuItem(new menuItem("Strategy Manager", "", "strategy_list.php"));
    addMenuItem(new menuItem("Industry Manager", "", "industry_list.php"));
  }
  */
  //absoluteMenu1.items.item2.setSubMenu(absoluteMenu1_1);
  //absoluteMenu1.items.item5.setSubMenu(absoluteMenu1_2);
  //absoluteMenu1_2.items.item1.setSubMenu(absoluteMenu1_2_1);
  //absoluteMenu1_2.items.item2.setSubMenu(absoluteMenu1_2_2);
 // absoluteMenu1_2.items.item3.setSubMenu(absoluteMenu1_2_3);
 // absoluteMenu1_2.items.item4.setSubMenu(absoluteMenu1_2_4);
  //absoluteMenu1_2.items.item5.setSubMenu(absoluteMenu1_2_5);
  absoluteMenu1.items.item2.showIcon("edit", "edit");
  absoluteMenu1.items.item4.showIcon("edit", "edit");
  absoluteMenu1.items.item0.showIcon("home", "home");
  absoluteMenu1.items.config.showIcon("config", "config");
  absoluteMenu1.items.user.showIcon("user", "user");
  absoluteMenu1.items.mail.showIcon("mail", "mail");
  absoluteMenu1.items.poll.showIcon("poll", "poll");
  absoluteMenu1.items.newsletter.showIcon("newsletter", "newsletter");
  absoluteMenu1.items.pass.showIcon("pass", "pass");

}