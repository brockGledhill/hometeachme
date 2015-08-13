<?php
session_start();

mysql_connect("ssiuxtools.db.11473969.hostedresource.com", "ssiuxtools", "D!ngd0ng");
mysql_select_db("ssiuxtools");

$phpmemberid = mysql_real_escape_string($_POST[memberidname]);
$phpwardid = mysql_real_escape_string($_POST[wardidname]);

	
mysql_query("DELETE FROM `ward_members` WHERE MemberID='$phpmemberid' AND WardID='$phpwardid'") or die(mysql_error());

header("Location: members.php");

exit();

?>