@extends('layouts.default')

@section('content')
<div class="subcenterbox">

	<h4 class="pagetitles">Add New Member</h4>

	<form id="newmemform" action="/members/add" method="post">
		{!! csrf_field() !!}
		<input type="hidden" name="ward_id" value="{{ $wardId }}"/>

		<div class="addcompanrow">
			<span class="familytitle">First Name</span>
			<input name="first_name" type="text"/>
		</div>
		<div class="addcompanrow">
			<span class="familytitle">Last Name</span>
			<input name="last_name" type="text"/>
		</div>
		<div class="addcompanrow">
			<span class="familytitle">Spouse</span>
			<input name="spouse_name" type="text" placeholder="(first name)"/>
		</div>
		<div class="addcompanrow">
			<span class="familytitle">Phone</span>
			<input name="phone" type="text"/>
		</div>
		<div class="addcompanrow">
			<span class="familytitle">Email</span>
			<input name="email" type="text"/>
		</div>
		<div class="addcompanrow">
			<span class="familytitle">Password</span>
			<input name="password" type="text"/>
		</div>
		<div class="addcompanrow">
			<span class="familytitle">Quorum</span>

			<select name="quorum_id">
				<option value="1">Elder</option>
				<option value="2">High Priest</option>
			</select>
		</div>
		<div class="addcompanrow">
			<span class="familytitle">Admin?</span>

			<select name="adminname">
				<option value="0">No</option>
				<option value="1">Yes</option>
			</select>

		</div>
		<div class="addcompanrow">
			<span class="familytitle">Jr Companion?</span>

			<select id="jrcompid" name="is_jr_comp">
				<option value="0">No</option>
				<option value="1">Yes</option>
			</select>

		</div>

		<input type="submit" class="newsavebtn btn btn-default" value="Add" />
	</form>

</div>

<div class="subcenterbox">
	<h4 class="pagetitles">Current Members</h4>

	@foreach ($families as $family)
		<div class="memberrow">
			<div class="memname">{{ $family['first_name'] }} {{ $family['last_name'] }}</div>
			<div class="mememail">{{ $family['email'] }}</div>
			<div class="memphone">{{ $family['phone'] }}</div>
			<div class="memrowtools">
				<a href="/members/edit?id={{ $family['id'] }}" class="memedit glyphicon glyphicon-pencil"></a>
				<form id="removeMember{{ $family['id'] }}" action="/members/delete?id={{ $family['id'] }}" method="post" style="display: none;">
					{!! csrf_field() !!}
				</form>
				<a onclick="removemember('{{ $family['id'] }}')" class="memdelete glyphicon glyphicon-remove"></a>
			</div>
		</div>
	@endforeach
</div>

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
	$("#removeMember" + thememberid).submit();
}


</script>
@stop