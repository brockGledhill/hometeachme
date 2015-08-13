<?php 

mysql_connect("ssiuxtools.db.11473969.hostedresource.com", "ssiuxtools", "D!ngd0ng");
mysql_select_db("ssiuxtools");

$phpemail = mysql_real_escape_string($_POST[emailname]);
$phpphone = mysql_real_escape_string($_POST[phonename]);
$phpfirstname = mysql_real_escape_string($_POST[firstnamename]);

$phplastname = mysql_real_escape_string($_POST[lastnamename]);
$phpquorum = mysql_real_escape_string($_POST[quorumname]);
$phpward = mysql_real_escape_string($_POST[thewardidname]);

$phpisadmin = mysql_real_escape_string($_POST[adminname]);
$phpisjrcomp = mysql_real_escape_string($_POST[jrcompname]);
$phpspouse = mysql_real_escape_string($_POST[spousename]);
$phppass= mysql_real_escape_string($_POST[passwordname]);

	
mysql_query("INSERT INTO `ward_members` (Email, Password, First_Name, Last_Name, QuorumID, WardID, Phone, Spouse_Name, Is_Admin, Is_Jrcomp) VALUES('$phpemail', '$phppass', '$phpfirstname', '$phplastname', '$phpquorum', '$phpward', '$phpphone', '$phpspouse', '$phpisadmin', '$phpisjrcomp') ") or die(mysql_error());

header("Location: members.php");

exit();

?>