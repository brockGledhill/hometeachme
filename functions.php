<?php

// Main Functions

$familylister = '';


function getunhometeachers($incward, $incquorum){
	$testhome = mysql_query("SELECT * FROM `ward_members` WHERE `WardID`='$incward' AND `QuorumID`='$incquorum' ");
	for($i=1;$i<=mysql_num_rows($testhome);$i++)
				{
					$row = mysql_fetch_array($testhome);
					$themember = $row[MemberID];
					
					echo findunhters($themember);
				}
				
				
}

function findunhters($incomingmember){
					$getcomperfamilies = mysql_query("SELECT * FROM `ward_compans` WHERE `HtOneID`='$incomingmember' OR  `HtTwoID`='$incomingmember'");
					
					// If Member doesn't exist in the companionship table
					if(mysql_fetch_array($getcomperfamilies) == NULL){
						$getfamilynamers = mysql_query("SELECT * FROM `ward_members` WHERE `MemberID`='$incomingmember' ");
						$gfrow = mysql_fetch_array($getfamilynamers);
						return $gfrow[First_Name][0] .' '. $gfrow[Last_Name] .'<br />';
					}
					
}

function retfamnames($themonth, $theward, $thequorum, $visitcount){
	$getmonthfamilies = mysql_query("SELECT * FROM `wardcomp_visits` WHERE `visitmonth`='$themonth' AND  `WardID`='$theward' AND `WardID`='$thequorum'");
	
	echo '<div class="mymonths" id="monthdisplay'. $themonth .'" onClick="javascript: togmonthfamily(\''. $themonth .'\')"><div class="monthstatrow"><span id="montharrow'. $themonth .'" class="visarrow glyphicon glyphicon-menu-right"></span><span>'.$themonth . '</span><span class="visitsnums"> ' . $visitcount.' </span></div><div style="display:none;" id="hidevisfams'. $themonth .'" class="hidesection">';
	
	for($i=1;$i<=mysql_num_rows($getmonthfamilies);$i++)
				{
					$row = mysql_fetch_array($getmonthfamilies);
					$themember = $row[MemberID];
					
					echo '<div class="famvisnames">' . retmembernames($themember) . '</div>';
				} 
				
	echo '</div></div>';			
	
}

function retmembernames($incmemeber){
	$showfamilyname = mysql_query("SELECT * FROM `ward_members` WHERE `MemberID`='$incmemeber' ");
						$sfrow = mysql_fetch_array($showfamilyname);
						return $sfrow[Last_Name];
}

?>