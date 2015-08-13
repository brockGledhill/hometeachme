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

$phpmembaid = mysql_real_escape_string($_POST[thememberid]);

	
mysql_query("UPDATE `ward_members` SET Email='$phpemail', Password='$phppass', First_Name='$phpfirstname', Last_Name='$phplastname', QuorumID='$phpquorum', WardID='$phpward', Phone='$phpphone', Spouse_Name='$phpspouse', Is_Admin='$phpisadmin', Is_Jrcomp='$phpisjrcomp' WHERE MemberID='$phpmembaid' AND WardID='$phpward' ") or die(mysql_error());

header("Location: members.php");

exit();

?>