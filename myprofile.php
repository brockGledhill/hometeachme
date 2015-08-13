<?
session_start();
mysql_connect("ssiuxtools.db.11473969.hostedresource.com", "ssiuxtools", "D!ngd0ng");
mysql_select_db("ssiuxtools");

if (!$_SESSION['ward_logins']['emailaddress']) {
	header("Location: index.php?cmd=logout");
}

$dayear = date('Y');
$mywardid = $_SESSION['ward_logins']['WardID'];
$myquorumid = $_SESSION['ward_logins']['QuorumID'];
$mymemberid = $_SESSION['ward_logins']['MemberID'];;

$phpmemeditid = mysql_real_escape_string($_POST[membereditname]);

$myfirstname;

$getmemberinfo = mysql_query("SELECT * FROM `ward_members` WHERE MemberID='$mymemberid' AND WardID='$mywardid'");

$row = mysql_fetch_array($getmemberinfo);
$myfirstname = $row[First_Name];
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
    <a class="topbtn" href="messages.php" title="messages"><span class="glyphicon glyphicon-envelope" ></span></a>
    <a class="topbtn selectedtab" href="myprofile.php" title="messages"><span class="glyphicon glyphicon-cog" ></span></a>
    <a href="index.php?cmd=logout" class="logout topbtn pushright" href="#" title="logout"><span class="glyphicon glyphicon-log-out" ></span></a></div>
   
<div id="mainbox">

	<?php include('menu.php'); ?>

	<div class="subcenterbox">
    
    <h4 class="pagetitles">Update My Profile</h4>
    
       	<?php 
		
			if($adminstatus){
				echo ' 
				
				<form id="editmemform" action="updatemyprofile.php" method="post">
          <input style="display:none;" name="thewardidname" value="'.  $mywardid .'"/>
        <input style="display:none;" name="thememberid" value="'. $row[MemberID] .'"/>
        
        <div class="addcompanrow">
        <span class="familytitle">First Name</span>
        <input id="firstnameid" name="firstnamename" type="text" value="'. $myfirstname .'" />
        </div>
        <div class="addcompanrow">
        <span class="familytitle">Last Name</span>
        <input id="lastnameid" name="lastnamename" type="text" value="'. $row[Last_Name] .'" />
        </div>
        <div class="addcompanrow">
        <span class="familytitle">Spouse</span>
        <input id="spousenameid" name="spousename" type="text" placeholder="(first name)" value="'. $row[Spouse_Name].'" />
        </div>
         <div class="addcompanrow">
        <span class="familytitle">Phone</span>
        <input id="phoneid" name="phonename" type="text" value="'. $row[Phone] .'" />
        </div>
         <div class="addcompanrow">
        <span class="familytitle">Email</span>
        <input id="emailid" name="emailname" type="text" value="'. $row[Email] .'"  />
        </div>
         <div class="addcompanrow">
        <span class="familytitle">Password</span>
        <input id="passwordid" name="passwordname" type="password" value="'. $row[Password] .'" />
        </div>
				<div class="addcompanrow">
        <span class="familytitle">Quorum</span>
       
        <select id="quorumid" name="quorumname"><option value="1">Elder</option><option value="2">High Priest</option></select>
        </div>
        <div class="addcompanrow">
        <span class="familytitle">Admin?</span>
       
        <select id="adminid" name="adminname"><option value="0">No</option><option value="1">Yes</option></select>
        
        </div>
		
		<a href="javascript: updatemember('. $phpmemeditid . ')" class="newchangebtn btn btn-default" >Save Changes</a>';
			}
			else{
				echo '<form id="editnamember" action="noadminprofileupdate.php" method="post">
        <input style="display:none;" name="thewardidname" value="'.  $mywardid .'"/>
        <input style="display:none;" name="thememberid" value="'. $row[MemberID] .'"/>
        
        <div class="addcompanrow">
        <span class="familytitle">First Name</span>
        <input id="firstnameid" name="firstnamename" type="text" value="'. $myfirstname .'" />
        </div>
        <div class="addcompanrow">
        <span class="familytitle">Last Name</span>
        <input id="lastnameid" name="lastnamename" type="text" value="'. $row[Last_Name] .'" />
        </div>
        <div class="addcompanrow">
        <span class="familytitle">Spouse</span>
        <input id="spousenameid" name="spousename" type="text" placeholder="(first name)" value="'. $row[Spouse_Name].'" />
        </div>
         <div class="addcompanrow">
        <span class="familytitle">Phone</span>
        <input id="phoneid" name="phonename" type="text" value="'. $row[Phone] .'" />
        </div>
         <div class="addcompanrow">
        <span class="familytitle">Email</span>
        <input id="emailid" name="emailname" type="text" value="'. $row[Email] .'"  />
        </div>
         <div class="addcompanrow">
        <span class="familytitle">Password</span>
        <input id="passwordid" name="passwordname" type="password" value="'. $row[Password] .'" />
        </div>
		
		<a href="javascript: updatenamember('. $phpmemeditid . ')" class="newchangebtn btn btn-default" >Save Changes</a>';
			}
		
		  ?>
        
        
        </form>
    
    </div>
    
    
    </div>

</div>

<div id="footer"></div>

<script type="text/javascript">

$("#quorumid").val(<?php echo $row[QuorumID]; ?>);
$("#adminid").val(<?php echo $row[Is_Admin]; ?>);

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

function updatemember(membid){
	$("#editmemform").submit();
}

function updatenamember(membid){
	$("#editnamember").submit();
}


</script>

</body>
</html>