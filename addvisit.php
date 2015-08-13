<?php 
session_start();
mysql_connect("ssiuxtools.db.11473969.hostedresource.com", "ssiuxtools", "D!ngd0ng");
mysql_select_db("ssiuxtools");

$phphouseid = mysql_real_escape_string($_POST[thehouseid]);
$phpvisitmonth = mysql_real_escape_string($_POST[thevisitmonth]);
$phpcompanionid = mysql_real_escape_string($_POST[thehousename]);

$phpwardid = $_SESSION['ward_logins']['WardID'];
$phpquorumid = $_SESSION['ward_logins']['QuorumID'];

$phpmyyear = date('Y');
	
mysql_query("INSERT INTO `wardcomp_visits` (CompID, MemberID, visitmonth, visityear, WardID, QuorumID) VALUES('$phpcompanionid', '$phphouseid', '$phpvisitmonth', '$phpmyyear', '$phpwardid', '$phpquorumid') ") or die(mysql_error());

exit();

?>