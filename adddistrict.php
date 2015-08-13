<?php 

mysql_connect("ssiuxtools.db.11473969.hostedresource.com", "ssiuxtools", "D!ngd0ng");
mysql_select_db("ssiuxtools");

$phpquorum = mysql_real_escape_string($_POST[thequorumidname]);
$phpward = mysql_real_escape_string($_POST[thewardidname]);
$phpmember = mysql_real_escape_string($_POST[thehousename]);
	
mysql_query("INSERT INTO `ward_districts` (QuorumID, WardID, MemberID) VALUES('$phpquorum', '$phpward', '$phpmember') ") or die(mysql_error());

header("Location: districts.php");

exit();

?>