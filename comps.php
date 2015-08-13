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
$numoffams = 0;

$explodename = explode(" ", $thename);


$getmyfamilies = mysql_query("SELECT * FROM `ward_members` WHERE `WardID`='$mywardid' AND `QuorumID`='$myquorumid' ORDER BY `Last_Name` ASC");
$getmyfamiliestwo = mysql_query("SELECT * FROM `ward_members` WHERE `WardID`='$mywardid' AND `QuorumID`='$myquorumid' ORDER BY `Last_Name` ASC");
$getmyfamiliesthree = mysql_query("SELECT * FROM `ward_members` WHERE `WardID`='$mywardid' AND `QuorumID`='$myquorumid' ORDER BY `Last_Name` ASC");
$gethtone = mysql_query("SELECT * FROM `ward_members` WHERE `WardID`='$mywardid' AND `QuorumID`='$myquorumid' ORDER BY `Last_Name` ASC");

// This is the one query that needs to be limited to not show jr comps when adding a family to a comp.
$gethttwo = mysql_query("SELECT * FROM `ward_members` WHERE `WardID`='$mywardid' AND `QuorumID`='$myquorumid' ORDER BY `Last_Name` ASC");

$htexisitng = mysql_query("SELECT * FROM `ward_compans` WHERE `WardID`='$mywardid' AND `QuorumID`='$myquorumid' ");

$getdistrictlist = mysql_query("SELECT * FROM `ward_districts` WHERE `WardID`='$mywardid' AND `QuorumID`='$myquorumid'");


$getunassigned = mysql_query("SELECT * FROM `ward_members` WHERE `WardID`='$mywardid' AND `QuorumID`='$myquorumid' AND `Is_Jrcomp`='0' ");

$getmyfamiliessearch = mysql_query("SELECT * FROM `ward_members` WHERE `WardID`='$mywardid' AND `QuorumID`='$myquorumid' ORDER BY `Last_Name` ASC");

include("functions.php");

?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Family</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="actions.js"></script>
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link href='http://fonts.googleapis.com/css?family=Exo+2:400,100' rel='stylesheet' type='text/css'>
</head>

<body onLoad="runallthis()">

<?php
        
                for($i=1;$i<=mysql_num_rows($getmyfamiliessearch);$i++)
                {
                    $row = mysql_fetch_array($getmyfamiliessearch);
                    
                    $storelastname = $row[Last_Name];
					$storefirstname = $row[First_Name];
                    
                    
					$numoffams ++;
					echo '<div style="display:none;" id="searchmem'. $numoffams .'"><div class="searchname">'. $storefirstname .' '. $storelastname .'</div><span>'.$row[MemberID].'</span></div>';
                }
            
            ?>

<div id="topbar">

    <a id="homebtnid" class="topbtn" href="dashboard.php" title="home"><span class="glyphicon glyphicon-home" ></span></a>
    <a class="topbtn" href="notifications.php" title="notifications"><span class="glyphicon glyphicon-bell" ></span></a>
    <a class="topbtn" href="messages.php" title="messages"><span class="glyphicon glyphicon-envelope" ></span></a>
    <a class="topbtn" href="myprofile.php" title="messages"><span class="glyphicon glyphicon-cog" ></span></a>
    <a href="index.php?cmd=logout" class="logout topbtn pushright" href="#" title="logout"><span class="glyphicon glyphicon-log-out" ></span></a></div>
   
<div id="mainbox">
<div style="display:none;" id="familyselector">
        <select onChange="javascript: setfaminput(this.value)" class="newfamrow">
        	<option value="0">Not Selected</option>
			 <?php
        
                for($i=1;$i<=mysql_num_rows($getmyfamilies);$i++)
                {
                    $row = mysql_fetch_array($getmyfamilies);
                    
                    $storelastname = $row[Last_Name];
					$storefirstname = $row[First_Name];
                    
                    echo '<option value="'. $row[MemberID] .'">'. $storefirstname .' '. $storelastname .'</option>';
                }
            
            ?>
        
        </select>
        </div>

	<div id="adminnav"><a class="adminbtn filledin" href="comps.php">Companionships</a><a class="adminbtn pushadmin" href="members.php">Members</a><a class="adminbtn pushadmin" href="districts.php">Districts</a><a class="adminbtn pushadmin" href="stats.php">Stats</a></div>

	<div class="subcenterbox">
    
    <h4 class="pagetitles">Create New Companionship</h4>
    
    	<form id="newcompform" action="createcomp.php" method="post">
        <input style="display:none;" name="thequorumidname" value="<?php echo  $myquorumid; ?>"/>
        <input style="display:none;" name="thewardidname" value="<?php echo  $mywardid; ?>"/>
        <input id="familypile" style="display:none;" name="thefamilyname" value=""/>
        
        <div id="familydiv" class="addcompanrow">
        <span class="familytitle">Family</span>
        
        <div id="pushfamselectors">
        <select onChange="javascript: setfaminput(this.value)" class="newfamrow" id="familyider1" >
        <option value="0">Not Selected</option>
			 <?php
        
                for($i=1;$i<=mysql_num_rows($getmyfamiliestwo);$i++)
                {
                    $row = mysql_fetch_array($getmyfamiliestwo);
                    
                     $storelastname = $row[Last_Name];
					$storefirstname = $row[First_Name];
                    
                    echo '<option value="'. $row[MemberID] .'">'. $storefirstname .' '. $storelastname .'</option>';
                }
            
            ?>
        
        </select>
        <select onChange="javascript: setfaminput(this.value)" class="newfamrow" id="familyider2" >
        <option value="0">Not Selected</option>
			 <?php
        
                for($i=1;$i<=mysql_num_rows($getmyfamiliesthree);$i++)
                {
                    $row = mysql_fetch_array($getmyfamiliesthree);
                    
                    $storelastname = $row[Last_Name];
					$storefirstname = $row[First_Name];
                    
                    echo '<option value="'. $row[MemberID] .'">'. $storefirstname .' '. $storelastname .'</option>';
                }
            
            ?>
        
        </select>
        
        </div>
        <a id="additionalfambtn" href="javascript: onemorefamily()">Additional Family</a>
        <div class="addcompanrow">
        <span class="familytitle">Home Teacher</span>
        <select class="myselect" name="thehtonename">
        <option value="0">Not Selected</option>
        
        	<?php
	
				for($i=1;$i<=mysql_num_rows($gethtone);$i++)
				{
					$row = mysql_fetch_array($gethtone);
					
					$storelastname = $row[Last_Name];
					$storefirstname = $row[First_Name];
					
					echo '<option value="'. $row[MemberID] .'">'.$storefirstname.' '. $storelastname .'</option>';
				}
		
			?>
        
        </select >
        </div>
        <div class="addcompanrow">
        <span class="familytitle">Home Teacher</span>
        <div id="useableselect">
        <select class="myselect" name="thehttwoname">
        <option value="0">Not Selected</option>
        
        	<?php
	
				for($i=1;$i<=mysql_num_rows($gethttwo);$i++)
				{
					$row = mysql_fetch_array($gethttwo);
					
					$storelastname = $row[Last_Name];
					$storefirstname = $row[First_Name];
					
					echo '<option value="'. $row[MemberID] .'">'.$storefirstname.' '. $storelastname .'</option>';
				}
		
			?>
        
        </select>
        </div>
        </div>
        
        	<a href="javascript: submitcomp()" class="newsavebtn btn btn-default" >Add</a>
        
        </form>
    
    </div>
    
    
    
    </div>
    
    
  <div id="bottomcomps">  
    <div class="subcenterboxleft">
    <h4 class="pagetitles">Unassigned</h4>
    
    	<div class="unbox">
        <span class="unboxtitle">Families</span>
        
        	<?php
			
			for($i=1;$i<=mysql_num_rows($getunassigned);$i++)
				{
					$row = mysql_fetch_array($getunassigned);
					$themember = $row[MemberID];
					
					echo findun($themember);
					
				}
				
				function findun($incomingmember){
					$getcomperfamilies = mysql_query("SELECT * FROM `ward_comp_members` WHERE `MemberID`='$incomingmember' ");
					
					// If family doesn't exist in the comps relationship table
					if(mysql_fetch_array($getcomperfamilies) == NULL){
						$getfamilynamers = mysql_query("SELECT * FROM `ward_members` WHERE `MemberID`='$incomingmember' ");
						$gfrow = mysql_fetch_array($getfamilynamers);
						return $gfrow[First_Name][0] .' '. $gfrow[Last_Name] .'<br />';
					}
					
					
				}
			
			
        	?>
        
        </div>
        
        <div class="unbox"><span class="unboxtitle">Hometeachers</span>
        
        
        	<?php getunhometeachers($mywardid, $myquorumid); ?>
        
        </div>
    
    </div>
    
    <div class="subcenterboxright">
    <div class="pagetitles pagecompstitle"><h4 class="compstitle">Companionships</h4><div id="searchboxcomp"><input type="text" placeholder="search" onkeyup="showResult(this.value, <?php echo $numoffams ?>)"/><div id="livesearch"></div></div></div>
    <div id="compsheader"><span class="leftheadlabel">Hometeachers</span><span class="rightheadlabel">Families</span></div>
        
        <?php
	
				for($i=1;$i<=mysql_num_rows($htexisitng);$i++)
				{
					$row = mysql_fetch_array($htexisitng);
					
					//$storelastname = $row[Last_Name];
					//$storefirstname = $row[First_Name];
					$storecompid = $row[CompanionID];
					//echo 'dumbthing'. $storecompid;
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
    

	</div>

</div>


<form id="removedacomp" action="updatecomp.php" method="post" style="display:none;">

<input id="formcompid" name="formcompname" type="text" value="" />
<input id="formhtnumberid" name="formhtnumname" type="text" value="" />

</form>

<form id="removedafamily" action="removeFamily.php" method="post" style="display:none;">

<input id="famcomperid" name="compidname" type="text" value="" />
<input id="famfamerid" name="famidname" type="text" value="" />

</form>

<div style="display:none;" id="districtchangebox">

<form class="discform" id="dischangeform" action="updatedistrict.php" method="post">

	<input style="display:none;" type="text" id="mycompider" name="mycompnamer" value=""/>
    <input style="display:none;" type="text" id="wardider" name="wardidname" value="<?php echo $mywardid; ?>"/>
    <input style="display:none;" type="text" id="quorumider" name="quorumidname" value="<?php echo $myquorumid; ?>"/>
    
    <select class="myselect" name="thedistrictname">
        <option value="0">Not Selected</option>
        
        	<?php
	
				for($i=1;$i<=mysql_num_rows($getdistrictlist);$i++)
				{
					$row = mysql_fetch_array($getdistrictlist);
					//echo 'district here' . $row[DistrictID];
					//echo $row[MemberID];
					$namedleaders = mysql_query("SELECT * FROM `ward_members` WHERE `MemberID`='$row[MemberID]'");
					$dlrow = mysql_fetch_array($namedleaders);
					echo '<option value="'. $row[DistrictID] .'">'. $dlrow[First_Name] .' '. $dlrow[Last_Name] .'</option>';
				}
				
		
			?>
        
        </select>
        
        <div id="districtbtns"></div>
       

</form>

</div>


<div id="footer"></div>

<form style="display:none;" id="searchmemberform" action="searchmembers.php" method="post">

	<input type="text" id="memberid" name="memberidname" />
    <input type="text" id="membernameid" name="membernamename" />

</form>

<script type="text/javascript">

var namernum = 2;
var totalfamilies = <?php echo $numfams ?>;
var menuopen = false;

function runallthis(){
	for(i = 1; i <= totalfamilies; i++){
	
	//alert(document.getElementById("familynameid" + i).innerHTML);
	//alert("#familynameid" + i);
	
	//alert('ready');
	//onemorefamily();
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

function updistrict(dacompid){
	$("#districtbtns").html("<a href='javascript: submitdistchange(" + dacompid + ")' class='glyphicon glyphicon-floppy-disk'></a><a href='javascript: districtclose(" + dacompid + ")' class='glyphicon glyphicon-remove'></a>");
	$("#districtchangebox form").attr("id","dischangeform" + dacompid);
	$("#dischangeform" + dacompid ).find("#mycompider").attr("value", dacompid);
	$("#districtcontrol" + dacompid).html($("#districtchangebox").html());
	$("#districtcontrol" + dacompid).children("#districtchangebox").css("display","block");
	//$("#districtchangebox").css("display","block");
}

function submitdistchange(yourcompid){
	//$("#dischangeform" + yourcompid + " #mycompider").val(yourcompid);
	$("#dischangeform" + yourcompid).submit();
}

function districtclose(compid){
	$("#districtchangebox").css("display","none");
	$("#districtcontrol" + compid).html("");
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
	var $combined = $("#comperselect" + compidagain).val();
	//alert('here yo');
	$("#thefamlist" + compidagain).val($combined);
	$("#famform" + compidagain).submit();
	
}
function remfam(thefamid, thecompanid){
	$("#famcomperid").val(thecompanid);
	$("#famfamerid").val(thefamid);
	$("#removedafamily").submit();
	
	/*var stringout = String($("#thefamlist" + thecompanid).val());
	var res = stringout.split(",");
	
	for(var i = 0; i <= res.length; i ++)
	{
		if(res[i] == thefamid){
			//alert('found it! ' + thefamid);
			res.splice(i, 1);
			$("#thefamlist" + thecompanid).val(String(res));	
			$("#famform" + thecompanid).submit();
		}
	}*/
	
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

function onemorefamily(){
	if(namernum <= 4)
	{
		namernum ++;
		$("#familyselector").children("select").attr("id","familyider" + namernum);
		var theselect = document.getElementById("familyselector").innerHTML;
		document.getElementById("pushfamselectors").innerHTML += theselect;
	}
	else{
		//document.getElementById("pushfamselectors").innerHTML += theselect;
		$("#additionalfambtn").css("display","none");
	}
	$("#familyselector").children("select").attr("id","familyider" + namernum + 1);
	var theselect = document.getElementById("familyselector").innerHTML;
	document.getElementById("pushfamselectors").innerHTML += theselect;
	$("#pushfamselectors :last-child").css("display","none");
	
}

function setfaminput(incomingvalue){
	$("#familypile").val('');
	var famarray = [];
	//alert(incomingvalue);
	for(var i = 1; i <= namernum; i ++){
		//alert($("#familyider" + i).val());
		if($("#familyider" + i).val() != 0)
		{
			famarray.push($("#familyider" + i).val());
		}
		else{
			//do nothing
		}
				
	}
	
	$("#familypile").val(String(famarray));
	//famarray = [$("#familypile").val()];
	
}

function dumbthing(itnumb){
	alert(itnumb);
	document.getElementById("familypile").value += $("#familyider" + itnumb).val(); 
}

function showResult(str, numrecipes){
//alert(numrecipes);
var listarray = [];
$('#livesearch').show();
if(str == ''){
	$('#livesearch').hide();
	listarray = [];
}
else{
for(r = 1; r <= numrecipes; r++){
	var thedishname = $('#searchmem' + r).children('.searchname').html();
	var therecipesrealid = $('#searchmem' + r).children('span').html();
	var fromthesearch = 1;
	if(thedishname.toLowerCase().indexOf(str) >= 0 || thedishname.indexOf(str) >= 0)
		{
			listarray.push('<a class="searchresultrow" href="javascript: viewresults(' + therecipesrealid + ',&quot;' + thedishname + '&quot;' + ')">' + thedishname + '</a><br />');
		}
}
}
$('#livesearch').html(listarray);

}

function viewresults(theid, membername){
	$("#memberid").val(theid);
	$("#membernameid").val(membername);
	$("#searchmemberform").submit();
}




</script>

</body>
</html>