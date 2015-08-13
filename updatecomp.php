<?php 

mysql_connect("ssiuxtools.db.11473969.hostedresource.com", "ssiuxtools", "D!ngd0ng");
mysql_select_db("ssiuxtools");

$phpformcompid = mysql_real_escape_string($_POST[formcompname]);
$phphtnum = mysql_real_escape_string($_POST[formhtnumname]);

if($phphtnum == 1){
	mysql_query("UPDATE `ward_compans` SET `HtOneID`='' WHERE `CompanionID`='$phpformcompid'") or die(mysql_error());
}
else{
	mysql_query("UPDATE `ward_compans` SET `HtTwoID`='' WHERE `CompanionID`='$phpformcompid'") or die(mysql_error());
}

header("Location: comps.php");

exit();

?>