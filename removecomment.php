<?php
session_start();

mysql_connect("ssiuxtools.db.11473969.hostedresource.com", "ssiuxtools", "D!ngd0ng");
mysql_select_db("ssiuxtools");

$phpcommentid = mysql_real_escape_string($_POST[thecommentid]);
	
mysql_query("DELETE FROM `ward_comments` WHERE CommentID='$phpcommentid' ") or die(mysql_error());

exit();

?>