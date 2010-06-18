<?
ob_start();
include("header.inc.php");?>
<? 
require_once "../config/functions.inc.php";
session_destroy();
header("location: index.php");
?>