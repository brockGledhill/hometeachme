<?php 

mysql_connect("ssiuxtools.db.11473969.hostedresource.com", "ssiuxtools", "D!ngd0ng");
mysql_select_db("ssiuxtools");

$phpcommenttext = mysql_real_escape_string($_POST[commenttextname]);
$phpfamilyid = mysql_real_escape_string($_POST[familyname]);
$phpmemberid = mysql_real_escape_string($_POST[hometeachername]);

$phpcompanionid = mysql_real_escape_string($_POST[companionshipname]);
$phpwardid = mysql_real_escape_string($_POST[wardinputname]);
$phpvisitmonth = mysql_real_escape_string($_POST[monthname]);

$phpmyyear = date('Y');
	
mysql_query("INSERT INTO `ward_comments` (CommentText, FamilyID, MemberID, CompanionID, WardID, visitmonth, visityear) VALUES('$phpcommenttext', '$phpfamilyid', '$phpmemberid', '$phpcompanionid', '$phpwardid', '$phpvisitmonth', '$phpmyyear') ") or die(mysql_error());

$rcid = mysql_insert_id();
echo $rcid;

//header("Location: dashboard.php");

exit();

?>