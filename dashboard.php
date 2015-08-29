<?php
session_start();
mysql_connect("ssiuxtools.db.11473969.hostedresource.com", "ssiuxtools", "D!ngd0ng");
mysql_select_db("ssiuxtools");

if (!isset($_SESSION['ward_logins']['emailaddress'])) {
	$loginuser = mysql_real_escape_string($_POST['myusername']);
    $loginpassword = mysql_real_escape_string($_POST['mypassword']);
	$query = mysql_query("SELECT * FROM `ward_members` WHERE `Email`= '$loginuser' AND `Password`= '$loginpassword' ");
	$row = mysql_fetch_array($query);
	if ($row['MemberID']) {
		session_start();
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
}

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

?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Family</title>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link href='http://fonts.googleapis.com/css?family=Exo+2:400,100' rel='stylesheet' type='text/css'>
</head>

<body onLoad="runallthis()">

<div id="topbar">
    <a id="homebtnid" class="topbtn selectedtab" href="#" title="home"><span class="glyphicon glyphicon-home" ></span></a>
    <a class="topbtn" href="notifications.php" title="notifications"><span class="glyphicon glyphicon-bell" ></span></a>
    <a class="topbtn" href="messages.php" title="messages"><span class="glyphicon glyphicon-envelope" ></span></a>
    <a class="topbtn" href="myprofile.php" title="messages"><span class="glyphicon glyphicon-cog" ></span></a>
    <a href="index.php?cmd=logout" class="logout topbtn pushright" href="#" title="logout"><span class="glyphicon glyphicon-log-out" ></span></a></div>

<div id="commentslidomatic">
    <div id="commentbar">
    
    <div id="commentbox">
    <span id="commenttitle"></span>
    <form id="commentformid" method="post" action="savecomment.php">
        <textarea name="commenttextname" id="textcommentbox" placeholder="your comments..."></textarea>
        <input style="display:none;" id="wardinput" name="wardinputname" type="text" />
        <input style="display:none; "id="monthinput" name="monthname" type="text" />
        <input style="display:none; "id="familyinput" name="familyname" type="text" />
        <input style="display:none; "id="hometeacherinput" name="hometeachername" type="text" />
        <input style="display:none; "id="companionshipinput" name="companionshipname" type="text" />
    </form>
    <a class="closecommentbtn" href="javascript: closecomment()"> < Go Back </a><a class="savecommentbtn" href="javascript: savedacomment()">Save Comment</a></div>
    
    <h4 id="commentheaderline">Previous Comments</h4>
    <div id="previouscomments"></div>
    
    
    </div> 
</div>      
   
<div id="mainbox">
	
    <?php include('menu.php'); ?>

	<div class="centerbox">
    
    <h4 class="leftheader">My Families</h4>
    
    <?php
	
		
		$row = mysql_fetch_array($queryfamily);
		$thecompanionid = $row[CompanionID];
		if($row[HtOneID] == $theid){
			$querycompname = mysql_query("SELECT * FROM `ward_members` WHERE `MemberID`='$row[HtTwoID]'");
			
			for($i=1;$i<=mysql_num_rows($querycompname);$i++)
		{
			$rowcomp = mysql_fetch_array($querycompname);
			echo '<div class="compnameclass"><h6>My Companion: '.$rowcomp[First_Name] .' ' . $rowcomp[Last_Name].'</h6><h4 class="companphone">'.$rowcomp[Phone] .'</h4></div>';
		}
		
		
		}
		else{
			$querycompname = mysql_query("SELECT * FROM `ward_members` WHERE `MemberID`='$row[HtOneID]'");
		for($i=1;$i<=mysql_num_rows($querycompname);$i++)
		{
			$rowcomp = mysql_fetch_array($querycompname);
			echo '<div class="compnameclass"><h6>My Companion: '.$rowcomp[First_Name] .' ' . $rowcomp[Last_Name].'</h6><h4 class="companphone">'.$rowcomp[Phone] .'</h4></div>';
		}
		
		}
		
		
		$querymyfams = mysql_query("SELECT * FROM `ward_comp_members` WHERE `CompanionshipID`='$thecompanionid'");
		
		for($i=1;$i<=mysql_num_rows($querymyfams);$i++)
		{
			$row = mysql_fetch_array($querymyfams);
			array_push($allfamilies, $row[MemberID]);
			
		}
		
		
		//$familyloop = explode(",", $allfamilies);
		
		// Figure out my companions ID so I can go get his info
		
		
		//  Loop through my families assigned in the companionship table
		if(count($allfamilies) !== 0){
			for($v=0; $v<= count($allfamilies) - 1; $v++){
			
			$queryfamilynames = mysql_query("SELECT * FROM `ward_members` WHERE `MemberID`='$allfamilies[$v]'");
			$famrow = mysql_fetch_array($queryfamilynames);
			
			
			$storehousename = $famrow[Last_Name];
			$storehouseid = $famrow[MemberID];
			
			$storevisitnum = visitnum($famrow[MemberID], $storehousename);
			
			
				echo '<div onClick="showthemonths(\''. $storehousename .'\')" class="familyline"><div class="visitcontainer"><div id="visitid'.$v.'" style="display:none;">'.$storevisitnum.'</div><span id="displayvisitnum'.$storehouseid.'" class="visitnumber">' .$storevisitnum . '</span><span class="visitnumber">/'. date("n") .'</span><span class="visitstitle">visits</span></div> <span id="familynameid'.$v.'" class="famdisplay">'. $storehousename .'</span></div>
		
		<div style="display:none;" id="hiddenmonths'. $storehousename .'" class="monthrows">
		
			<div class="monthitem">
			<div class="visitclickitem" onClick="javascript: checkvisit('.$storehouseid.' , \'Jan\' , this.id, \''.$thecompanionid.'\')"  id="Jan-'.$storehousename.'"><a href="#" class="visiticon glyphicon glyphicon-unchecked"></a><span class="monthlabel">January</span> </div>
			<a class="commentbutton" href="javascript: monthcomment('.$storehouseid.','.$thecompanionid.', \'Jan\')">Add Comment</a>
			</div>
			
			<div class="monthitem">
			<div class="visitclickitem" onClick="javascript: checkvisit('.$storehouseid.' , \'Feb\' , this.id, \''.$thecompanionid.'\')"  id="Feb-'.$storehousename.'"><a href="#" class="visiticon glyphicon glyphicon-unchecked"></a><span class="monthlabel">February</span> </div>
			<a class="commentbutton" href="javascript: monthcomment('.$storehouseid.','.$thecompanionid.', \'Feb\')">Add Comment</a>
			</div>
			
			<div class="monthitem">
			<div class="visitclickitem" onClick="javascript: checkvisit('.$storehouseid.' , \'Mar\' , this.id, \''.$thecompanionid.'\')"  id="Mar-'.$storehousename.'"><a href="#" class="visiticon glyphicon glyphicon-unchecked"></a><span class="monthlabel">March</span> </div>
			<a class="commentbutton" href="javascript: monthcomment('.$storehouseid.','.$thecompanionid.', \'Mar\')">Add Comment</a>
			</div>
			
			<div class="monthitem">
			<div class="visitclickitem" onClick="javascript: checkvisit('.$storehouseid.' , \'Apr\' , this.id, \''.$thecompanionid.'\')"  id="Apr-'.$storehousename.'"><a href="#" class="visiticon glyphicon glyphicon-unchecked"></a><span class="monthlabel">April</span> </div>
			<a class="commentbutton" href="javascript: monthcomment('.$storehouseid.','.$thecompanionid.', \'Apr\')">Add Comment</a>
			</div>
			
			<div class="monthitem">
			<div class="visitclickitem" onClick="javascript: checkvisit('.$storehouseid.' , \'May\' , this.id, \''.$thecompanionid.'\')"  id="May-'.$storehousename.'"><a href="#" class="visiticon glyphicon glyphicon-unchecked"></a><span class="monthlabel">May</span> </div>
			<a class="commentbutton" href="javascript: monthcomment('.$storehouseid.','.$thecompanionid.', \'May\')">Add Comment</a>
			</div>
			
			<div class="monthitem">
			<div class="visitclickitem" onClick="javascript: checkvisit('.$storehouseid.' , \'Jun\' , this.id, \''.$thecompanionid.'\')"  id="Jun-'.$storehousename.'"><a href="#" class="visiticon glyphicon glyphicon-unchecked"></a><span class="monthlabel">June</span> </div>
			<a class="commentbutton" href="javascript: monthcomment('.$storehouseid.','.$thecompanionid.', \'Jun\')">Add Comment</a>
			</div>
			
			<div class="monthitem">
			<div class="visitclickitem" onClick="javascript: checkvisit('.$storehouseid.' , \'Jul\' , this.id, \''.$thecompanionid.'\')"  id="Jul-'.$storehousename.'"><a href="#" class="visiticon glyphicon glyphicon-unchecked"></a><span class="monthlabel">July</span> </div>
			<a class="commentbutton" href="javascript: monthcomment('.$storehouseid.','.$thecompanionid.', \'Jul\')">Add Comment</a>
			</div>
			
			<div class="monthitem">
			<div class="visitclickitem" onClick="javascript: checkvisit('.$storehouseid.' , \'Aug\' , this.id, \''.$thecompanionid.'\')"  id="Aug-'.$storehousename.'"><a href="#" class="visiticon glyphicon glyphicon-unchecked"></a><span class="monthlabel">August</span> </div>
			<a class="commentbutton" href="javascript: monthcomment('.$storehouseid.','.$thecompanionid.', \'Aug\')">Add Comment</a>
			</div>
			
			<div class="monthitem">
			<div class="visitclickitem" onClick="javascript: checkvisit('.$storehouseid.' , \'Sep\' , this.id, \''.$thecompanionid.'\')"  id="Sep-'.$storehousename.'"><a href="#" class="visiticon glyphicon glyphicon-unchecked"></a><span class="monthlabel">September</span> </div>
			<a class="commentbutton" href="javascript: monthcomment('.$storehouseid.','.$thecompanionid.', \'Sep\')">Add Comment</a>
			</div>
			
			<div class="monthitem">
			<div class="visitclickitem" onClick="javascript: checkvisit('.$storehouseid.' , \'Oct\' , this.id, \''.$thecompanionid.'\')"  id="Oct-'.$storehousename.'"><a href="#" class="visiticon glyphicon glyphicon-unchecked"></a><span class="monthlabel">October</span></div>
			<a class="commentbutton" href="javascript: monthcomment('.$storehouseid.','.$thecompanionid.', \'Oct\')">Add Comment</a>
			</div>
			
			<div class="monthitem">
			<div class="visitclickitem" onClick="javascript: checkvisit('.$storehouseid.' , \'Nov\' , this.id, \''.$thecompanionid.'\')"  id="Nov-'.$storehousename.'"><a href="#" class="visiticon glyphicon glyphicon-unchecked"></a><span class="monthlabel">November</span></div>
			<a class="commentbutton" href="javascript: monthcomment('.$storehouseid.','.$thecompanionid.', \'Nov\')">Add Comment</a>
			</div>

			<div class="monthitem noborder">
			<div class="visitclickitem" onClick="javascript: checkvisit('.$storehouseid.' , \'Dec\' , this.id, \''.$thecompanionid.'\')"  id="Dec-'.$storehousename.'"><a href="#" class="visiticon glyphicon glyphicon-unchecked"></a><span class="monthlabel">December</span></div>
			<a class="commentbutton" href="javascript: monthcomment('.$storehouseid.','.$thecompanionid.', \'Dec\')">Add Comment</a>
			</div>
			
		
		</div>';
		$numfams ++;
			
			
			
		
		
				
			}
		}
		else{
				echo '<p class="notext">No families assigned yet</p>';
			}
		

	
	function visitnum($famid, $housename){
		$thevisitnum = 0;
		$queryvisits = mysql_query("SELECT * FROM `wardcomp_visits` WHERE `MemberID`='$famid' AND `visityear`='2015'");
		
			for($v=1;$v<=mysql_num_rows($queryvisits);$v++){
			
				$row = mysql_fetch_array($queryvisits);
				$thevisitnum ++;
				echo '<div id="'.$housename. $v . '" style="display:none;">'.$row[visitmonth].'</div>';
		}
		
		return $thevisitnum;
	}
	
	function getmycompinfo($mycompsid){
		//echo 'hey'. $topcomp;
		
	}
	?>
    </div>
    
    <div class="centerbox">
    <h4>My Hometeachers</h4>
    
    <?php
		
		
		$queryteachers = mysql_query("SELECT * FROM `ward_comp_members` WHERE `MemberID`='$theid'");
		
		
		$trow = mysql_fetch_array($queryteachers);
		$myhtcompid = $trow[CompanionshipID];
		echo retrieveht($myhtcompid);
		
		function retrieveht($inhtid){
			$complist = '';
			$queryteachername = mysql_query("SELECT * FROM `ward_compans` WHERE `CompanionID`='$inhtid'");
			$mrow = mysql_fetch_array($queryteachername);
			
			$hometeachers = $mrow[HtOneID].','. $mrow[HtTwoID];
			$htexplode = explode(',', $hometeachers);
			
			//echo count($htexplode) counting these out to hide the bars when there aren't hometeachers assigned yet;
			for($b=0;$b<=count($htexplode)-1;$b++){
				$querynames = mysql_query("SELECT * FROM `ward_members` WHERE `MemberID`='$htexplode[$b]'");
				
				$brow = mysql_fetch_array($querynames);
				
					$complist .= '<div class="familylinet"><span class="htericon glyphicon glyphicon-user"></span><span class="famdisplayt">'. $brow[First_Name] .' ' . $brow[Last_Name] .'</span><br /><span class="htphonenum">' . $brow[Phone] .'</span></div>';
				
	
			}
			return $complist;
			
			
		}
		
		$queryteachername = mysql_query("SELECT * FROM `ward_compans` WHERE `CompanionID`='$myhtcompid'");
			
			$mrow = mysql_fetch_array($queryteachername);
			
			//$hometone = $mrwo[HtOneID];
			$homettwo = $mrwo[HtTwoID];
			echo $mrwo[HtOneID];
			echo $homettwo;
			
			if($hometone != ""){
				myhometeachersnames($hometone);
			}
			if($homettwo != ""){
				myhometeachersnames($homettwo);
			}
				
			  
		function myhometeachersnames($htid){
			//echo $htid;
			$myhtquery = mysql_query("SELECT * FROM `ward_members` WHERE `MemberID`='$htid'");
			$myhtrow = mysql_fetch_array($myhtquery);
			
			echo '<div class="familylinet"><span class="htericon glyphicon glyphicon-user"></span><span class="famdisplayt">'. $myhtrow[First_Name] .' ' . $myhtrow[Last_Name] .'</span><br /><span class="htphonenum">' . $myhtrow[Phone] .'</span></div>';
		}
	?>
    </div>
    
    
    </div>

</div>

<?php 

for($c=0; $c<= count($allfamilies) - 1; $c++){
	
	$commentcount = 0;
	$currentfamily;
	$querycomments = mysql_query("SELECT * FROM `ward_comments` WHERE `MemberID`='$theid' AND `FamilyID`='$allfamilies[$c]' ");
	
	
	for($v=1;$v<=mysql_num_rows($querycomments);$v++){
		$commentrow = mysql_fetch_array($querycomments);
				
				$commentcount ++;
				$commentfamily = $commentrow[FamilyID];
				$currentfamily = $commentfamily;
	
			}
	
	$queryindv = mysql_query("SELECT * FROM `ward_comments` WHERE `MemberID`='$theid' AND `FamilyID`='$currentfamily;' ");
	echo '<div style="display:none;" id="family'. $currentfamily .'">';
	
			for($t=1;$t<=$commentcount;$t++){
				$mycrow = mysql_fetch_array($queryindv);
				
				echo '<div id="fullcommentrow'. $mycrow[CommentID] .'" class="famcommentrow"><div class="commentcont"><div class="commentmonth">'. $mycrow[visitmonth] .' ' . $dayear .'</div><div>'. $mycrow[CommentText] .'</div></div><div style="display:none;" id="commentconfirm'. $mycrow[CommentID] .'" class="delcommentbox"><span class="delconftitle">Delete Comment?</span><a class="delconfbtn btn btn-primary" href="javascript: confdelete('. $mycrow[CommentID] .')">Yes</a><a class="delconfbtn delright btn btn-danger" href="javascript: dontdelete('. $mycrow[CommentID] .')">No</a></div><a class="delcomment glyphicon glyphicon-remove" href="javascript: deletecomment('. $mycrow[CommentID] .')"></a></div>';
			}
			
			
	echo '</div>';
}


?>


<div id="footer"></div>

<script type="text/javascript">

var totalfamilies = <?php echo $numfams ?>;
var menuopen = false;
var commentopens = false;

var runningvisitupdate = false;

function runallthis(){
	
	for(i = 0; i <= totalfamilies; i++){
	
	//alert(document.getElementById("familynameid" + i).innerHTML);
	//alert("#familynameid" + i);
	
	var famname = document.getElementById("familynameid" + i).innerHTML;
	var famvisits = document.getElementById("visitid" + i).innerHTML;
	var tonumvisits = Number(famvisits);
	
	for(t = 1; t <= tonumvisits; t++)
	{
		var innermonth = document.getElementById(famname + t).innerHTML;
	
		
		$("#" + innermonth + "-" + famname + " a").removeClass("glyphicon-unchecked").addClass("glyphicon-ok-sign");
		$("#" + innermonth + "-" + famname).css("color","#5dc0b2");
		$("#" + innermonth + "-" + famname).parent().children(".commentbutton").css("display","block");
		
	}
	

}

}

function deletecomment(commentid){
	//$("#commentconfirm" + commentid).css("display","block");
	$( "#commentconfirm" + commentid ).toggle( "slide", {direction:"right"}, 700 );
}
function dontdelete(commentid){
	//$("#commentconfirm" + commentid).css("display","none");
	$( "#commentconfirm" + commentid ).toggle( "slide", {direction:"right"}, 700 );
}
function confdelete(commentid){
	var thedelfamily = $("#familyinput").val();
	$.ajax({
     	 	url: 'removecomment.php',
      		type: 'post',
     	 	data: {'thecommentid': commentid},
      		success: function(data, status) {
				
				
		  		$("#fullcommentrow" + commentid).css("display","none");
				$("#family" + thedelfamily).children("#fullcommentrow" + commentid).css("display","none");
				
      		},
		}); // end ajax call
}

function showthemonths(familyname){
	$("#hiddenmonths" + familyname).toggle("slow");
}

function checkvisit(houseid, vmonth, currentitem, housename){
	
	if ($("#" + currentitem + " a").hasClass("glyphicon-ok-sign")){
		var themonthstring = $("#" + currentitem + " span").html();
		$("#" + currentitem + " span").html('updating...');
		//alert($("#" + currentitem ).html();
		var visnum = Number(document.getElementById("displayvisitnum" + houseid).innerHTML);
		//alert('yep');
		visnum --;
		
		if(!runningvisitupdate)
		{
			runningvisitupdate = true;
			$.ajax({
				url: 'removevisit.php',
				type: 'post',
				data: {'thehouseid': houseid, 'thevisitmonth': vmonth},
				success: function(data, status) {
			
					$("#" + currentitem + " a").removeClass('glyphicon-ok-sign').addClass("glyphicon-unchecked");
					$("#" + currentitem).css("color","#CCCCCC");
					$("#" + currentitem).parent().children(".commentbutton").css("display","none");
					$("#displayvisitnum" + houseid).html(visnum);
					$("#" + currentitem + " span").html(themonthstring);
					runningvisitupdate = false;
					
				},
			}); // end ajax call
		}
	}
	else{
		
		var themonthstring = $("#" + currentitem + " span").html();
		$("#" + currentitem + " span").html('updating...');
		var visnum = Number(document.getElementById("displayvisitnum" + houseid).innerHTML);
		//alert('yep');
		visnum ++;
		
		if(!runningvisitupdate)
		{
			runningvisitupdate = true;
			$.ajax({
				url: 'addvisit.php',
				type: 'post',
				data: {'thehouseid': houseid, 'thevisitmonth': vmonth, 'thehousename': housename},
				success: function(data, status) {
			
					$("#" + currentitem + " a").removeClass('glyphicon-unchecked').addClass("glyphicon-ok-sign");
					$("#" + currentitem).css("color","#5dc0b2");
					$("#" + currentitem).parent().children(".commentbutton").css("display","block");
					$("#displayvisitnum" + houseid).html(visnum);
					$("#" + currentitem + " span").html(themonthstring);
					runningvisitupdate = false;
				},
			}); // end ajax call
		}
		
	}
	
	
	
}

function monthcomment(familyid, companionshipid, themonth){
	
	$("#commenttitle").html(themonth + ' <?php echo $dayear; ?> comments');
	$("#monthinput").val(themonth);
	$("#companionshipinput").val(companionshipid);
	$("#familyinput").val(familyid);
	$("#hometeacherinput").val(<?php echo $theid; ?>);
	$("#wardinput").val(<?php echo $myward; ?>);
	//$( "#commentbar" ).css("display","block");
	
	$( "#mainbox" ).toggle( "slide", {direction:"left"}, 700 );
	$( "#commentslidomatic" ).toggle( "slide", {direction:"right"}, 700 );
	
	$("#previouscomments").html($("#family" + familyid).html());
	//alert(familyid);
	//$( "#mainbox" ).css("width","70%");
	//$( "#mainbox" ).animate({ "right": "+=20%" }, "slow" );
	//commentopens = true;
	
	
	
}

function savedacomment(){
	//$("#commentformid").submit();
	
	var thecurrentfamily = $("#familyinput").val();
	
	$.ajax({
     	 	url: 'savecomment.php',
      		type: 'post',
     	 	data: {'commenttextname': $("#textcommentbox").val(), 'familyname': $("#familyinput").val(), 'hometeachername': $("#hometeacherinput").val(), 'companionshipname': $("#companionshipinput").val(), 'wardinputname': $("#wardinput").val(), 'monthname': $("#monthinput").val() },
      		success: function(rcid) {
		
				//temporarily add the dom elements of the comment to show it was added
				document.getElementById("previouscomments").innerHTML += '<div id="fullcommentrow' + rcid + '" class="famcommentrow"><div class="commentcont"><div class="commentmonth">'+ $("#monthinput").val() + ' 2015</div><div>'+ $("#textcommentbox").val() +'</div></div><div style="display:none;" id="commentconfirm' + rcid + '" class="delcommentbox"><span class="delconftitle">Delete Comment?</span><a class="delconfbtn btn btn-primary" href="javascript: confdelete(' + rcid + ')">Yes</a><a class="delconfbtn delright btn btn-danger" href="javascript: dontdelete(' + rcid + ')">No</a></div><a class="delcomment glyphicon glyphicon-remove" href="javascript: deletecomment(' + rcid + ')"></a></div>';
				
				document.getElementById("family" + thecurrentfamily).innerHTML += '<div id="fullcommentrow' + rcid + '" class="famcommentrow"><div class="commentcont"><div class="commentmonth">'+ $("#monthinput").val() + ' 2015</div><div>'+ $("#textcommentbox").val() +'</div></div><div style="display:none;" id="commentconfirm' + rcid + '" class="delcommentbox"><span class="delconftitle">Delete Comment?</span><a class="delconfbtn btn btn-primary" href="javascript: confdelete(' + rcid + ')">Yes</a><a class="delconfbtn delright btn btn-danger" href="javascript: dontdelete(' + rcid + ')">No</a></div><a class="delcomment glyphicon glyphicon-remove" href="javascript: deletecomment(' + rcid + ')"></a></div>';
				
				
				
				emptythebox();
      		},
		}); // end ajax call
	
}

function closecomment(){
	$( "#commentslidomatic" ).toggle( "slide", {direction:"right"}, 700 );
	 $( "#mainbox" ).toggle( "slide", {direction:"left"}, 700 ); 		
}

function emptythebox(){
	$("#textcommentbox").val('')
}


</script>

</body>
</html>
