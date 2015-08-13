<?
session_start();
mysql_connect("ssiuxtools.db.11473969.hostedresource.com", "ssiuxtools", "D!ngd0ng");
mysql_select_db("ssiuxtools");
$thename;
$numfams = 0;

$phpmemberid = mysql_real_escape_string($_POST[memberidname]);
$phpmembername = mysql_real_escape_string($_POST[membernamename]);

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

$getspecmember = mysql_query("SELECT * FROM `ward_members` WHERE `WardID`='$mywardid' AND `QuorumID`='$myquorumid' AND `MemberID`='$phpmemberid'");

$gethtexisitng = mysql_query("SELECT * FROM `ward_compans` WHERE `WardID`='$mywardid' AND `QuorumID`='$myquorumid' AND `HtOneID`='$phpmemberid' OR `HtTwoID`='$phpmemberid' ");

include("functions.php");

?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Family</title>
<script src="charts/Chart.js"></script>
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

	<div id="adminnav"><a class="adminbtn" href="comps.php">Companionships</a><a class="adminbtn pushadmin" href="members.php">Members</a><a class="adminbtn pushadmin" href="districts.php">Districts</a><a class="adminbtn pushadmin" href="stats.php">Stats</a></div>

	<div class="subcenterbox">
    
    <h4 class="pagetitles">Results For <?php echo $phpmembername; ?></h4>
    
    	<div id="statscontainer">
       
            <div class="subcenterbox">
        
        <?php
        
              
                    $row = mysql_fetch_array($getspecmember);
                    
                    echo '<div class="memberrow"><div class="memname">'. $row[First_Name] .' '. $row[Last_Name] .'</div><div class="mememail">'. $row[Email] .'</div><div class="memphone">'. $row[Phone] .'</div><div class="memrowtools"><a href="javascript: editmember('. $row[MemberID] .')" class="memedit glyphicon glyphicon-pencil"></a><a href="javascript: removemember('. $row[MemberID] .')" class="memdelete glyphicon glyphicon-remove"></a></div></div>';
               
            
            ?>
          
      
    </div>
    <h4>Hometeaching Assignment</h4>
    <div class="subcenterbox resultbox">
    
     <?php
	
				for($i=1;$i<=mysql_num_rows($gethtexisitng);$i++)
				{
					$row = mysql_fetch_array($gethtexisitng);
					

					$storecompid = $row[CompanionID];
					echo '<div id="fullcomprow'.$storecompid.'" class="comprow">'. organizecomps($row[HtOneID], $row[HtTwoID], $storecompid, $row[DistrictID]) .'</div>';
				}
				
				
			function organizecomps($firsthometeacher, $secondhometeacher, $companoid, $districtid){
				
				$sepfams;
				$getonestraight = mysql_query("SELECT * FROM `ward_members` WHERE `MemberID`='$firsthometeacher'");
				$gettwostraight = mysql_query("SELECT * FROM `ward_members` WHERE `MemberID`='$secondhometeacher'");
				
				
				$rowhtone = mysql_fetch_array($getonestraight);
				$rowhttwo = mysql_fetch_array($gettwostraight);
				
				
				$getfamilystraight = mysql_query("SELECT * FROM `ward_comp_members` WHERE `CompanionshipID`='$companoid'");
				for($v=1;$v<=mysql_num_rows($getfamilystraight);$v++){
					$rowfamily = mysql_fetch_array($getfamilystraight);
					// echo $rowfamily[MemberID]; THIS works. and it gets the IDs of the families
					$familyname = $rowfamily[MemberID];
					$getfmname = mysql_query("SELECT * FROM `ward_members` WHERE `MemberID`='$familyname'");
					$rowname = mysql_fetch_array($getfmname);
					
					$famstrings .= '<div class="familyname"><div class="famlabel">' . $rowname[First_Name][0] .' '. $rowname[Last_Name].'</div><a class="remfamicon glyphicon glyphicon-remove" href="javascript: remfam('. $familyname. ',' .$companoid.')"></a></div>';
					
				}
				
				
				//$famstrings = '<div class="familyname">' . $rowfamily[Last_Name].'<a class="glyphicon glyphicon-minus-sign" href="javascript: remfam('. $familyname. ',' .$companoid.')"></a></div>';
				
				
				
				return  '<div class="rightstuff"><div class="famholder">' .$famstrings .'</div><a class="rowaddbtn" id="addfambtn'.$companoid.'" href="javascript: addfamily('.$companoid.')">+ Add Family</a><form id="famform'.$companoid.'" class="famformclass" action="addFamily.php" method="post"><div class="selectbar" id="selectspot'.$companoid.'"></div><input style="display:none;" id="thefamlist'.$companoid.'" name="existingfamsname" type="text" value="'. $familyname .'"/><input style="display:none;" name="compidname" type="text" value="'.$companoid.'"/><a class="additbtnclass" style="display:none;" id="addfamgo'.$companoid.'" href="javascript: submitfamadd('.$companoid.')">ADD</a></form></div><div class="leftstuff"><a class="delcompbtn glyphicon glyphicon-trash" href="javascript: deletecomprow('. $companoid .')"></a></a><div class="htcontainer"><div class="hter">'. htcheck($rowhtone[First_Name], $rowhtone[Last_Name], $companoid, 1) .'</div><div class="hter">'.htcheck($rowhttwo[First_Name], $rowhttwo[Last_Name], $companoid, 2).'</div>'.  districtcheck($districtid, $companoid) .'<div class="distcontrollclass" id="districtcontrol'.$companoid.'"></div>  </div></div>';
				
			}
			
			function htcheck($fname, $lname, $cid, $htnumber){
				if($fname == "" && $lname == "")
				{return '<div class="addcompbox"><form class="hiddenselectclass" id="hiddenadd'.$cid.'" method="post" action="addtheht.php"></form><div class="addcomptools" style="display:none;" id="addtools'.$cid.'"><a class="addcancelbtn glyphicon glyphicon-remove" href="javascript: nevermind('.$cid.')"></a><a class="glyphicon glyphicon-floppy-disk" href="javascript: savenewcomp('.$cid.')"></a></div><a id="addnewcompbtn'.$cid.'" class="addacompbtn" href="javascript: addnewcomp('.$cid.','.$htnumber.')">+ Add New Comp</a></div>';} 
				else{ return '<a href="javascript: remht('.$cid.','.$htnumber.')" class="glyphicon glyphicon-remove"></a>'.$fname .' '. $lname; }
			}
			
			function districtcheck($indistrictid, $incompanionid){
				
				if($indistrictid !== ""){
					$getdisname = mysql_query("SELECT * FROM `ward_districts` WHERE `DistrictID`='$indistrictid' ");
					$drow = mysql_fetch_array($getdisname);
					
					return districtstring($drow[MemberID], $incompanionid);
				}
				else{
					return '<div class="districtbox"><a class="nodistrict" href="javascript: updistrict('. $incompanionid .')">Assign District</a></div>';
				}
				
					
					// return '<div class="memberrow"><div class="memname">'. $grow[First_Name] .' '. $grow[Last_Name] .'</div></div>';
			}
			
			function districtstring($membaid, $fcompid){
				$getdisname = mysql_query("SELECT * FROM `ward_members` WHERE `MemberID`='$membaid' ");
					$mrow = mysql_fetch_array($getdisname);
				return '<div class="districtbox"><a class="dassigned" href="javascript: updistrict('. $fcompid .')">District: '. $mrow[First_Name] .' '. $mrow[Last_Name].'</a></div>';
			}
		
			?> 
    
    </div>
    
     <h4>Hometeachers</h4>
    <div class="subcenterbox resultbox">
    
    
    </div>
            
       
        
        </div>
    
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

function submitdist(){
	$("#newdistform").submit();
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

function togmonthfamily(themonth){
	$("#hidevisfams" + themonth).toggle("slow");
	if($("#montharrow" + themonth).hasClass("glyphicon-menu-right"))
	{
		$("#montharrow" + themonth).removeClass("glyphicon-menu-right");
		$("#montharrow" + themonth).addClass("glyphicon-menu-down");
	}
	else{
		$("#montharrow" + themonth).removeClass("glyphicon-menu-down");
		$("#montharrow" + themonth).addClass("glyphicon-menu-right");
	}
}


</script>

</body>
</html>