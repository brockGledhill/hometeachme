<? mysql_connect("ssiuxtools.db.11473969.hostedresource.com", "ssiuxtools", "D!ngd0ng");
mysql_select_db("ssiuxtools");


if (!$_SESSION['ward_logins']['emailaddress']) {
	$loginuser = mysql_real_escape_string($_POST['myusername']);
    $loginpassword = mysql_real_escape_string($_POST['mypassword']);
	$query = mysql_query("SELECT * FROM `ward_members` WHERE `Email`= '$loginuser' AND `Password`= '$loginpassword' ");
	$row = mysql_fetch_array($query);
	if ($row['MemberID']) {
		session_start();
		$_SESSION['ward_logins']['emailaddress'] = $row['Email'];
		$_SESSION['ward_logins']['WardID'] = $row['WardID'];
		$_SESSION['ward_logins']['QuorumID'] = $row['QuorumID'];
		$thename = $row['First_Name'] ." ". $row['Last_Name'];
		$theid = $row['MemberID'];
		//echo $_SESSION['ward_logins']['emailaddress'];
		header("Location: dashboard.php");
	}
	else {
		header("Location: index.php?cmd=logout");
	}
}
?>