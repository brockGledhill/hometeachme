<?
session_start();
mysql_connect("ssiuxtools.db.11473969.hostedresource.com", "ssiuxtools", "D!ngd0ng");
mysql_select_db("ssiuxtools");
$thename;
$numfams = 0;

$famstrings;

if (!$_SESSION['ward_logins']['emailaddress']) {
	header("Location: index.php?cmd=logout");
}

//echo $_SESSION['ward_logins']['Is_Admin'];
$adminstatus = $_SESSION['ward_logins']['Is_Admin'];
//echo $adminstatus;

if ($adminstatus != 1) {
	header("Location: index.php?cmd=logout");
}

$dayear = date('Y');
$mywardid = $_SESSION['ward_logins']['WardID'];
$myquorumid = $_SESSION['ward_logins']['QuorumID'];


$getallmembers = mysql_query("SELECT * FROM `ward_members` WHERE `WardID`='$mywardid' AND `QuorumID`='$myquorumid' ORDER BY `Last_Name` ASC");


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
    <a class="topbtn" href="messages.php" title="messages"><span class="glyphicon glyphicon-envelope" ></span></a>
    <a class="topbtn" href="myprofile.php" title="messages"><span class="glyphicon glyphicon-cog" ></span></a>
    <a href="index.php?cmd=logout" class="logout topbtn pushright" href="#" title="logout"><span class="glyphicon glyphicon-log-out" ></span></a></div>
   
<div id="mainbox">

	<div id="adminnav"><a class="adminbtn" href="comps.php">Companionships</a><a class="adminbtn filledin pushadmin" href="members.php">Members</a><a class="adminbtn pushadmin" href="districts.php">Districts</a><a class="adminbtn pushadmin" href="stats.php">Stats</a></div>

	<div class="subcenterbox">
    
    <h4 class="pagetitles">Add New Member</h4>
    
    	<form id="newmemform" action="addmem.php" method="post">
        <input style="display:none;" name="thewardidname" value="<?php echo  $mywardid; ?>"/>
        
        <div class="addcompanrow">
        <span class="familytitle">First Name</span>
        <input name="firstnamename" type="text" />
        </div>
        <div class="addcompanrow">
        <span class="familytitle">Last Name</span>
        <input name="lastnamename" type="text" />
        </div>
        <div class="addcompanrow">
        <span class="familytitle">Spouse</span>
        <input name="spousename" type="text" placeholder="(first name)" />
        </div>
         <div class="addcompanrow">
        <span class="familytitle">Phone</span>
        <input name="phonename" type="text" />
        </div>
         <div class="addcompanrow">
        <span class="familytitle">Email</span>
        <input name="emailname" type="text" />
        </div>
         <div class="addcompanrow">
        <span class="familytitle">Password</span>
        <input name="passwordname" type="text" />
        </div>
        <div class="addcompanrow">
        <span class="familytitle">Quorum</span>
       
        <select name="quorumname"><option value="1">Elder</option><option value="2">High Priest</option></select>
        </div>
        <div class="addcompanrow">
        <span class="familytitle">Admin?</span>
       
        <select name="adminname"><option value="0">No</option><option value="1">Yes</option></select>
        
        </div>
        <div class="addcompanrow">
        <span class="familytitle">Jr Companion?</span>
       
        <select id="jrcompid" name="jrcompname"><option value="0">No</option><option value="1">Yes</option></select>
        
        </div>
        
        	<a href="javascript: submitmem()" class="newsavebtn btn btn-default" >Add</a>
        
        </form>
    
    </div>
    
    <div class="subcenterbox">
    <h4 class="pagetitles">Current Member</h4>
        
        <?php
        
                for($i=1;$i<=mysql_num_rows($getallmembers);$i++)
                {
                    $row = mysql_fetch_array($getallmembers);
                    
                    echo '<div class="memberrow"><div class="memname">'. $row[First_Name] .' '. $row[Last_Name] .'</div><div class="mememail">'. $row[Email] .'</div><div class="memphone">'. $row[Phone] .'</div><div class="memrowtools"><a href="javascript: editmember('. $row[MemberID] .')" class="memedit glyphicon glyphicon-pencil"></a><a href="javascript: removemember('. $row[MemberID] .')" class="memdelete glyphicon glyphicon-remove"></a></div></div>';
                }
            
            ?>
      
    </div>
    
    
    </div>

</div>

<form id="removedamember" action="removemember.php" method="post" style="display:none;">

<input id="memberidbox" name="memberidname" type="text" />
<input id="memberidbox" name="wardidname" type="text" value="<?php echo $mywardid ?>" />

</form>

<form id="editmemberform" action="editmember.php" method="post" style="display:none;">

<input id="membereditidbox" name="membereditname" type="text" />

</form>

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

	$(".memberrow:odd").css("background-color", "#f4f4f4");

}

function showthemonths(familyname){
	$("#hiddenmonths" + familyname).toggle("slow");
}

function submitmem(){
	$("#newmemform").submit();
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

function removemember(thememberid){
	$("#memberidbox").val(thememberid);
	$("#removedamember").submit();
}

function editmember(incomingmemberid){
	$("#membereditidbox").val(incomingmemberid);
	$("#editmemberform").submit();
}


</script>

</body>
</html>