<?php 

mysql_connect("ssiuxtools.db.11473969.hostedresource.com", "ssiuxtools", "D!ngd0ng");
mysql_select_db("ssiuxtools");

$phpfamilyid = mysql_real_escape_string($_POST[thefamilyname]);
$phphtone = mysql_real_escape_string($_POST[thehtonename]);
$phphttwo = mysql_real_escape_string($_POST[thehttwoname]);
$phpquorumid = mysql_real_escape_string($_POST[thequorumidname]);
$phpwardid = mysql_real_escape_string($_POST[thewardidname]);
	

mysql_query("INSERT INTO `ward_compans` (HtOneID, HtTwoID, WardID, QuorumID) VALUES('$phphtone', '$phphttwo', '$phpwardid', '$phpquorumid') ") or die(mysql_error());

//$phpfixhtone = explode("-", $phphtone);
//$phpfixhttwo = explode("-", $phphttwo);
//$phpfixfamily = explode("-", $phpfamilyid);

$companionshipid = mysql_insert_id();
$phpfamarray = explode(",", $phpfamilyid);
$phpfamcount = count($phpfamarray);

for($x = 0; $x <= $phpfamcount - 1; $x++){
	mysql_query("INSERT INTO `ward_comp_members` (MemberID, CompanionshipID) VALUES('$phpfamarray[$x]', '$companionshipid') ") or die(mysql_error());
	//echo $phpfamarray[$x];
}

header("Location: comps.php");

//exit();

?>