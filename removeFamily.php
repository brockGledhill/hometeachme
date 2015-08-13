<?php 

mysql_connect("ssiuxtools.db.11473969.hostedresource.com", "ssiuxtools", "D!ngd0ng");
mysql_select_db("ssiuxtools");


$phpcompid = mysql_real_escape_string($_POST[compidname]);
$phpfamilyid = mysql_real_escape_string($_POST[famidname]);

	
mysql_query("DELETE FROM `ward_comp_members` WHERE `MemberID`='$phpfamilyid' AND `CompanionshipID`='$phpcompid'") or die(mysql_error());

header("Location: comps.php");

exit();

?>