@extends('layouts.default')

@section('content')
<div class="subcenterboxd">

	<h4 class="pagetitles">Add New District</h4>

	<form id="newdistform" action="adddistrict.php" method="post">
		<input style="display:none;" name="thewardidname" value="{{ $wardId }}"/>
		<input style="display:none;" name="thequorumidname" value="{{ $quorumId }}"/>

		<div class="addcompanrow">
			<span class="familytitle">District Leader</span>

			<select name="thehousename">
				<option value="0">Not Selected</option>
				@foreach ($families as $family)
					<option value="{{ $family['id'] }}">{{ $family['first_name'] }} {{ $family['last_name'] }}</option>
				@endforeach
			</select>

		</div>

		<a onclick="submitdist()" class="newsavebtn btn btn-default">Add</a>

	</form>

</div>

<div class="subcenterboxd">
	<h4 class="pagetitles">Current Districts</h4>

	@foreach ($districts as $member)
		<div class="memberrow">
			<div class="memname">
				{{ $member['first_name'] }} {{ $member['last_name'] }}
			</div>
		</div>
	@endforeach

</div>


<form id="removedamember" action="removemember.php" method="post" style="display:none;">
	<input id="memberidbox" name="memberidname" type="text" />
	<input id="memberidbox" name="wardidname" type="text" value="{{ $wardId }}" />
</form>

<form id="editmemberform" action="editmember.php" method="post" style="display:none;">
	<input id="membereditidbox" name="membereditname" type="text" />
</form>

<script type="text/javascript">

var totalfamilies = 0;
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


</script>
@stop