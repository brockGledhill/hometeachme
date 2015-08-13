<?php
session_start();

mysql_connect("ssiuxtools.db.11473969.hostedresource.com", "ssiuxtools", "D!ngd0ng");
mysql_select_db("ssiuxtools");

$phphouseid = mysql_real_escape_string($_POST[thehouseid]);
$phpvisitmonth = mysql_real_escape_string($_POST[thevisitmonth]);
$phpmyyear = date('Y');
	
mysql_query("DELETE FROM `wardcomp_visits` WHERE MemberID='$phphouseid' AND visitmonth='$phpvisitmonth' AND visityear='$phpmyyear' ") or die(mysql_error());

exit();

?>