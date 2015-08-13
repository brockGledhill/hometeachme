<?php 

mysql_connect("ssiuxtools.db.11473969.hostedresource.com", "ssiuxtools", "D!ngd0ng");
mysql_select_db("ssiuxtools");

$phpcompid = mysql_real_escape_string($_POST[compidname]);
$phpfamilyid = mysql_real_escape_string($_POST[existingfamsname]);

	
mysql_query("INSERT INTO `ward_comp_members` (CompanionshipID, MemberID) VALUES('$phpcompid', '$phpfamilyid') ") or die(mysql_error());

header("Location: comps.php");

exit();

?>