<?php
// Copyright 2007 Facebook Corp.  All Rights Reserved. 
// 
// Application: Green Bean
// File: 'index.php' 
//   This is a sample skeleton for your application. 
// 

require_once 'facebook.php';

$appapikey = 'f597c47cb01b3bb83b851fc34bb7ed3d';
$appsecret = '5fec40f1f2c36eb19315e74a8855f5fc';
$facebook = new Facebook($appapikey, $appsecret);
$user_id = $facebook->require_login();

// Greet the currently logged-in user!
echo "<p>Hello, <fb:name uid=\"$user_id\" useyou=\"false\" />!</p>";

// Print out at most 25 of the logged-in user's friends,
// using the friends.get API method
echo "<p>Friends:";
$friends = $facebook->api_client->friends_get();
$friends = array_slice($friends, 0, 25);
foreach ($friends as $friend) {
  echo "<br>$friend";
}
echo "</p>";