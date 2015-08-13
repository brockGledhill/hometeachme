<?
session_start();
mysql_connect("ssiuxtools.db.11473969.hostedresource.com", "ssiuxtools", "D!ngd0ng");
mysql_select_db("ssiuxtools");


if (!$_SESSION['ward_logins']['emailaddress']) {
	header("Location: index.php?cmd=logout");
}

$thename;
$numfams = 0;

$famstrings;
$dayear = date('Y');
$mywardid = $_SESSION['ward_logins']['WardID'];
$myquorumid = $_SESSION['ward_logins']['QuorumID'];

$explodename = explode(" ", $thename);

//$queryvisits = mysql_query("SELECT * FROM `ward_visits` WHERE `visitmonth`='Sep' ");
//$queryfamily = mysql_query("SELECT * FROM `ward_houses` WHERE `hometeacher_one`='$thename' OR `hometeacher_two`='$thename' ");
//$queryteachers = mysql_query("SELECT * FROM `ward_houses` WHERE `housename`='$explodename[1]'");

//$getmyfamilies = mysql_query("SELECT * FROM `ward_members` WHERE `WardID`='$mywardid' AND `QuorumID`='$myquorumid' ORDER BY `Last_Name` ASC");
//$gethtone = mysql_query("SELECT * FROM `ward_members` WHERE `WardID`='$mywardid' AND `QuorumID`='$myquorumid' ORDER BY `Last_Name` ASC");
//$gethttwo = mysql_query("SELECT * FROM `ward_members` WHERE `WardID`='$mywardid' AND `QuorumID`='$myquorumid' ORDER BY `Last_Name` ASC");

//$htexisitng = mysql_query("SELECT * FROM `ward_compans` WHERE `WardID`='$mywardid' AND `QuorumID`='$myquorumid' ");

//$queryelders = mysql_query("SELECT * FROM `ward_houses` WHERE `quorum`='elder' ");
//$query = mysql_query("SELECT * FROM `ward_houses` ORDER BY housename ASC");
//$wardhouses = "";
//$wardelders = "";
//$wardnoteachers = "";
//$wardvisits = "";
$adminstatus = $_SESSION['ward_logins']['Is_Admin'];
?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Family</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link href='http://fonts.googleapis.com/css?family=Exo+2:400,100' rel='stylesheet' type='text/css'>
</head>

<body onLoad="runallthis()">

<div id="topbar">
    <a id="homebtnid" class="topbtn" href="dashboard.php" title="home"><span class="glyphicon glyphicon-home" ></span></a>
    <a class="topbtn" href="notifications.php" title="notifications"><span class="glyphicon glyphicon-bell" ></span></a>
    <a class="topbtn selectedtab" href="messages.php" title="messages"><span class="glyphicon glyphicon-envelope" ></span></a>
    <a class="topbtn" href="myprofile.php" title="messages"><span class="glyphicon glyphicon-cog" ></span></a>
    <a href="index.php?cmd=logout" class="logout topbtn pushright" href="#" title="logout"><span class="glyphicon glyphicon-log-out" ></span></a></div>

<div id="mainbox">

<?php include('menu.php'); ?>

	<div class="subcenterbox">
    
    <h4 class="pagetitles">0 Messages</h4>
   
   	<p class="exptext">You have 0 messages at this time</p>
    
    </div>
    
   

</div>

<div id="footer"></div>

<script type="text/javascript">

var totalfamilies = <?php echo $numfams ?>;
var menuopen = false;

function runallthis(){
	for(i = 1; i <= totalfamilies; i++){
	
	//alert(document.getElementById("familynameid" + i).innerHTML);
	//alert("#familynameid" + i);
	
	var famname = document.getElementById("familynameid" + i).innerHTML;
	var famvisits = document.getElementById("visitid" + i).innerHTML;
	var tonumvisits = Number(famvisits);
	
	for(t = 1; t <= tonumvisits; t++)
	{
		var innermonth = document.getElementById(famname + t).innerHTML;
	
		
		$("#" + innermonth + "-" + famname + " a").removeClass("glyphicon-minus").addClass("glyphicon-ok");
		$("#" + innermonth + "-" + famname).css("color","#804d76");
		$("#" + innermonth + "-" + famname).parent().children(".commentbutton").css("display","block");
		
	}
	

}

	$(".comprow:odd").css("background-color", "#f4f4f4");

}

function showthemonths(familyname){
	$("#hiddenmonths" + familyname).toggle("slow");
}

function checkvisit(houseid, vmonth, currentitem, housename){
	
	if ($("#" + currentitem + " a").hasClass("glyphicon-ok")){
		var visnum = Number(document.getElementById("displayvisitnum" + houseid).innerHTML);
		//alert('yep');
		visnum --;
		
		$.ajax({
     	 	url: 'removevisit.php',
      		type: 'post',
     	 	data: {'thehouseid': houseid, 'thevisitmonth': vmonth},
      		success: function(data, status) {
		
		  		$("#" + currentitem + " a").removeClass('glyphicon-ok').addClass("glyphicon-minus");
		  		$("#" + currentitem).css("color","#CCCCCC");
				$("#" + currentitem).parent().children(".commentbutton").css("display","none");
				$("#displayvisitnum" + houseid).html(visnum);
				
      		},
		}); // end ajax call
	}
	else{
		var visnum = Number(document.getElementById("displayvisitnum" + houseid).innerHTML);
		//alert('yep');
		visnum ++;
		$.ajax({
     	 	url: 'addvisit.php',
      		type: 'post',
     	 	data: {'thehouseid': houseid, 'thevisitmonth': vmonth, 'thehousename': housename},
      		success: function(data, status) {
		
		  		$("#" + currentitem + " a").removeClass('glyphicon-minus').addClass("glyphicon-ok");
		  		$("#" + currentitem).css("color","#804d76");
				$("#" + currentitem).parent().children(".commentbutton").css("display","block");
				$("#displayvisitnum" + houseid).html(visnum);
      		},
		}); // end ajax call
		
	}
	
	
	
}

function menuslide(){
	//$("#menu").slideRight("slow");
	if(!menuopen){
	$( "#menu" ).animate({ "left": "+=20%" }, "slow" );
	$( "#menu" ).css("width","20%");
	$( "#mainbox" ).css("width","80%");
	$( "#mainbox" ).animate({ "left": "+=20%" }, "slow" );
	$("#homebtnid").removeClass("selectedtab");
	menuopen = true;
	}
	else{
		$( "#menu" ).animate({ "left": "-=20%" }, "slow" );
		$( "#mainbox" ).animate({ "left": "-=20%" }, "slow" );
		$( "#mainbox" ).css("width","100%");
		menuopen = false;
		//$("#homebtnid").addClass("selectedtab");
	}
	
}


function submitcomp(){
	$("#newcompform").submit();
}

function addfamily(thecompid){
	$("#selectspot" + thecompid).html($("#useableselect").html());
	$("#addfambtn" + thecompid).css("display","none");
	$("#selectspot" + thecompid).children(".myselect").attr("id","comperselect" + thecompid);
	$("#addfamgo" + thecompid).css("display","block");
}
function submitfamadd(compidagain){
	var $combined = $("#thefamlist" + compidagain).val() + ',' + $("#comperselect" + compidagain).val();
	$("#thefamlist" + compidagain).val($combined);
	$("#famform" + compidagain).submit();
	
}
function remfam(thefamid, thecompanid){
	var stringout = String($("#thefamlist" + thecompanid).val());
	var res = stringout.split(",");
	
	for(var i = 0; i <= res.length; i ++)
	{
		if(res[i] == thefamid){
			//alert('found it! ' + thefamid);
			res.splice(i, 1);
			$("#thefamlist" + thecompanid).val(String(res));	
			$("#famform" + thecompanid).submit();
		}
	}
	
}

function remht(cmpid, htnum){
	$("#formcompid").val(cmpid);
	$("#formhtnumberid").val(htnum);
	
	$("#removedacomp").submit();
	
}

function addnewcomp(cid, htnumber){
	$("#hiddenadd" + cid).html($("#useableselect").html() + "<input style='display:none;' name='hiddenhtname' type='text' value='"+ htnumber+"' />" + "<input style='display:none;' name='hiddencid' type='text' value='"+ cid +"' />");
	$("#addnewcompbtn" + cid).css("display","none");
	$("#addtools" + cid).css("display","block");
}

function nevermind(thecid){
	$("#hiddenadd" + thecid).html('');
	$("#addnewcompbtn" + thecid).css("display","block");
	$("#addtools" + thecid).css("display","none");
}

function savenewcomp(savecid){
	$("#hiddenadd" + savecid).submit();
}


</script>

</body>
</html>