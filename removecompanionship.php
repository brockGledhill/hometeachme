<?php
session_start();

mysql_connect("ssiuxtools.db.11473969.hostedresource.com", "ssiuxtools", "D!ngd0ng");
mysql_select_db("ssiuxtools");

$phpcompid = mysql_real_escape_string($_POST[thecompid]);
$phpwardid = $_SESSION['ward_logins']['WardID'];


mysql_query("DELETE FROM `ward_compans` WHERE CompanionID='$phpcompid' AND WardID='$phpwardid' ") or die(mysql_error());
mysql_query("DELETE FROM `ward_comp_members` WHERE CompanionshipID='$phpcompid' ") or die(mysql_error());

exit();

?>