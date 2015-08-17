<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class DashboardController extends Controller {
	public function getIndex() {
		$data = [];
		$data['title'] = 'Dashboard';
		
		/*mysql_connect("ssiuxtools.db.11473969.hostedresource.com", "ssiuxtools", "D!ngd0ng");
		mysql_select_db("ssiuxtools");

		if (!isset($_SESSION['ward_logins']['emailaddress'])) {
			$loginuser = mysql_real_escape_string($_POST['myusername']);
			$loginpassword = mysql_real_escape_string($_POST['mypassword']);
			$query = mysql_query("SELECT * FROM `ward_members` WHERE `Email`= '$loginuser' AND `Password`= '$loginpassword' ");
			$row = mysql_fetch_array($query);
			if ($row['MemberID']) {
				$_SESSION['ward_logins']['emailaddress'] = $row['Email'];
				$_SESSION['ward_logins']['WardID'] = $row['WardID'];
				$_SESSION['ward_logins']['QuorumID'] = $row['QuorumID'];
				$_SESSION['ward_logins']['MemberID'] = $row['MemberID'];
				$_SESSION['ward_logins']['Is_Admin'] = $row['Is_Admin'];
				//echo 'admin' . $row['Is_Admin'];
				$thename = $row['First_Name'] ." ". $row['Last_Name'];
				//echo $_SESSION['ward_logins']['emailaddress'];
			}
			else {
				header("Location: index.php?cmd=logout");
			}
		}*/

		$thename;
		$theid;
		$numfams = 0;
		$thecompanionid;
		$mycompanionsid;
		$mycompanionsname;
		$dayear = date('Y');
		$explodename = explode(" ", $thename);
		$theid = $_SESSION['ward_logins']['MemberID'];
		$adminstatus = $_SESSION['ward_logins']['Is_Admin'];
		$myward = $_SESSION['ward_logins']['WardID'];
		$allfamilies = array();
		$topcomp;

		$queryfamily = mysql_query("SELECT * FROM `ward_compans` WHERE `HtOneID`='$theid' OR `HtTwoID`='$theid' ");

		return view('dashboard', $data);
	}

	public function postIndex() {
		
	}
}