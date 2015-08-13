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


$getvisitmonths = mysql_query("SELECT `visitmonth`, COUNT(*) c From `wardcomp_visits` WHERE `WardID`='$mywardid' AND `QuorumID`='$myquorumid' GROUP BY `visitmonth` HAVING c > 0 ORDER BY FIELD(visitmonth,'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec')");

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

	<div id="adminnav"><a class="adminbtn" href="comps.php">Companionships</a><a class="adminbtn pushadmin" href="members.php">Members</a><a class="adminbtn pushadmin" href="districts.php">Districts</a><a class="adminbtn filledin pushadmin" href="stats.php">Stats</a></div>

	<div class="subcenterbox">
    
    <h4 class="pagetitles">Family Visit Totals</h4>
    
    	<div id="statscontainer">
       
            <div id="famvisits" class="addcompanrow">
           
           
                 <?php
            		$montharray = array();
			
                    for($i=1;$i<=mysql_num_rows($getvisitmonths);$i++)
                    {
                        $row = mysql_fetch_array($getvisitmonths);
                        
                        $storevisitmonth = $row[visitmonth];
                        $storethecount = $row[c];
						array_push($montharray, $storevisitmonth);
                        echo  retfamnames($storevisitmonth, $mywardid, $myquorumid, $storethecount);
                     
                    }
                
                ?>
            
            </div>
            
            <div id="visitschart" class="addcompanrow">
           
           
                <canvas id="myChart" width="650" height="400"></canvas>
            
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
var montharray = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

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

//var January = $("#monthdisplayJan .visitsnums").html();
var Jan = 0;
var Feb = 0;
var Mar = 0;
var Apr = 0;
var May = 0;
var Jun = 0;
var Jul = 0;
var Aug = 0;
var Sep = 0;
var Oct = 0;
var Nov = 0;
var Dec = 0;



for(i = 0; i < 11; i++){
	if( $("#monthdisplay" + montharray[i]).length )
	{
		var insidemonth = montharray[i];
			switch(insidemonth){
				case "Jan":
					Jan = $("#monthdisplay"+ insidemonth + " .visitsnums").html();
					break;
				case "Feb":
					Feb = $("#monthdisplay" + insidemonth + " .visitsnums").html();
					break;
				case "Mar":
					Mar = $("#monthdisplay" + insidemonth + " .visitsnums").html();
					break;
				case "Apr":
					Apr = $("#monthdisplay" + insidemonth + " .visitsnums").html();
					break;
				case "May":
					May = $("#monthdisplay" + insidemonth + " .visitsnums").html();
					break;
				case "Jun":
					Jun = $("#monthdisplay" + insidemonth + " .visitsnums").html();
					break;
				case "Jul":
					Jul = $("#monthdisplay" + insidemonth + " .visitsnums").html();
					break; 
				case "Aug":
					Aug = $("#monthdisplay" + insidemonth + " .visitsnums").html();
					break;
				case "Sep":
					Sep = $("#monthdisplay" + insidemonth + " .visitsnums").html();
					break;
				case "Oct":
					Oct = $("#monthdisplay" + insidemonth + " .visitsnums").html();
					break;
				case "Nov":
					Nov = $("#monthdisplay" + insidemonth + " .visitsnums").html();
					break;
				case "Dec":
					Dec = $("#monthdisplay" + insidemonth + " .visitsnums").html();
					break;
			}
		}
}

	


var data = {
    labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
    datasets: [
        {
            label: "My First dataset",
            fillColor: "rgba(165,243,231,0.2)",
            strokeColor: "rgba(129,78,121,1)",
            pointColor: "rgba(129,78,121,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: [ Jan, Feb, Mar, Apr, May, Jun, Jul, Aug, Sep, Oct, Nov, Dec ]
        },
        
    ]
};

var ctx = document.getElementById("myChart").getContext("2d");


var ctx = $("#myChart").get(0).getContext("2d");
var myNewChart = new Chart(ctx);
new Chart(ctx).Line(data,  {
			responsive: true
		});




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