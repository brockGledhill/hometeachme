@extends('layouts.default')

@section('content')
<div class="subcenterbox">

	<h4 class="pagetitles">Family Visit Totals</h4>

	<div id="statscontainer">

		<div id="famvisits" class="addcompanrow">

			@foreach ($visitMonths as $visitMonth)
				<div class="mymonths" id="monthdisplay{{ $visitMonth['visit_month'] }}"
					 onclick="togmonthfamily('{{ $visitMonth['visit_month'] }}')">
					<div class="monthstatrow">
						<span id="montharrow{{ $visitMonth['visit_month'] }}"
							  class="visarrow glyphicon glyphicon-menu-right"></span>
						<span>{{ $visitMonth['visit_month'] }}</span>
						<span class="visitsnums">{{ $visitMonth['count'] }}</span>
					</div>

					<div style="display:none;" id="hidevisfams{{ $visitMonth['visit_month'] }}" class="hidesection">
						@foreach ($members[$visitMonth['visit_month']] as $member)
							<div class="famvisnames">{{ $member['first_name'] }} {{ $member['last_name'] }}</div>
						@endforeach
					</div>

				</div>
			@endforeach
		</div>
		<div id="visitschart" class="addcompanrow">
			<canvas id="myChart" width="650" height="400"></canvas>
		</div>
	</div>
</div>

<form id="removedamember" action="removemember.php" method="post" style="display:none;">
	<input id="memberidbox" name="memberidname" type="text"/>
	<input id="memberidbox" name="wardidname" type="text" value="{{ $wardId }}"/>
</form>

<form id="editmemberform" action="editmember.php" method="post" style="display:none;">
	<input id="membereditidbox" name="membereditname" type="text"/>
</form>

<script type="text/javascript" src="/js/charts/Chart.js"></script>
<script type="text/javascript">

var totalfamilies = 0;
var menuopen = false;
var montharray = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
runallthis();
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
@stop