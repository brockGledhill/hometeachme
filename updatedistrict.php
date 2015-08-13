<?php 

mysql_connect("ssiuxtools.db.11473969.hostedresource.com", "ssiuxtools", "D!ngd0ng");
mysql_select_db("ssiuxtools");

$phpdistrictid = mysql_real_escape_string($_POST[thedistrictname]);
$phpcompid = mysql_real_escape_string($_POST[mycompnamer]);


mysql_query("UPDATE `ward_compans` SET `DistrictID`='$phpdistrictid' WHERE `CompanionID`='$phpcompid'") or die(mysql_error());



header("Location: comps.php");

exit();

?>