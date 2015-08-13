<?php 

mysql_connect("ssiuxtools.db.11473969.hostedresource.com", "ssiuxtools", "D!ngd0ng");
mysql_select_db("ssiuxtools");


$phphtnumber= mysql_real_escape_string($_POST[hiddenhtname]);
$phpcompid = mysql_real_escape_string($_POST[hiddencid]);
$phpmemberid = mysql_real_escape_string($_POST[thehttwoname]);

//echo 'compid is ' . $phpcompid . 'home teacher id is ' . $phphtid ;
	
if($phphtnumber == 1){
	mysql_query("UPDATE `ward_compans` SET `HtOneID`='$phpmemberid' WHERE `CompanionID`='$phpcompid'") or die(mysql_error());
}
else{
	mysql_query("UPDATE `ward_compans` SET `HtTwoID`='$phpmemberid' WHERE `CompanionID`='$phpcompid'") or die(mysql_error());
}

header("Location: comps.php");

exit();

?>