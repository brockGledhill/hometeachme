@extends('layouts.default')

@section('content')
@foreach ($families as $key => $family)
	<div style="display:none;" id="searchmem{{ $key }}">
		<div class="searchname">{{ $family->first_name }} {{ $family->last_name }}</div>
		<span>{{ $family->id }}</span>
	</div>
@endforeach
<div style="display:none;" id="familyselector">
	<select onChange="javascript: setfaminput(this.value)" class="newfamrow">
		<option value="0">Not Selected</option>
		@foreach ($families as $family)
			<option value="{{ $family->id }}">{{ $family->first_name }} {{ $family->last_name }}</option>
		@endforeach
	</select>
</div>

<div class="subcenterbox">
    <h4 class="pagetitles">Create New Companionship</h4>

	<form id="newcompform" action="createcomp.php" method="post">
		<input style="display:none;" name="thequorumidname" value="{{ $quorumId }}"/>
		<input style="display:none;" name="thewardidname" value="{{ $wardId }}"/>
		<input id="familypile" style="display:none;" name="thefamilyname" value=""/>

		<div id="familydiv" class="addcompanrow">
			<span class="familytitle">Family</span>

			<div id="pushfamselectors">
				<select onChange="javascript: setfaminput(this.value)" class="newfamrow" id="familyider1">
					<option value="0">Not Selected</option>
					@foreach ($families as $family)
						<option value="{{ $family->id }}">{{ $family->last_name }}, {{ $family->first_name }}</option>
					@endforeach
				</select>
				<select onChange="javascript: setfaminput(this.value)" class="newfamrow" id="familyider2">
					<option value="0">Not Selected</option>
					@foreach ($families as $family)
						<option value="{{ $family->id }}">{{ $family->last_name }}, {{ $family->first_name }}</option>
					@endforeach
				</select>

			</div>
			<a id="additionalfambtn" href="javascript: onemorefamily()">Additional Family</a>

			<div class="addcompanrow">
				<span class="familytitle">Home Teacher</span>
				<select class="myselect" name="thehtonename">
					<option value="0">Not Selected</option>
					@foreach ($families as $family)
						<option value="{{ $family->id }}">{{ $family->last_name }}, {{ $family->first_name }}</option>
					@endforeach
				</select>
			</div>
			<div class="addcompanrow">
				<span class="familytitle">Home Teacher</span>

				<div id="useableselect">
					<select class="myselect" name="thehttwoname">
						<option value="0">Not Selected</option>
						@foreach ($families as $family)
							<option value="{{ $family->id }}">{{ $family->last_name }}, {{ $family->first_name }}</option>
						@endforeach

					</select>
				</div>
			</div>

			<a onclick="submitcomp()" class="newsavebtn btn btn-default">Add</a>
		</div>
	</form>
</div>



<div id="bottomcomps">
	<div class="subcenterboxleft">
		<h4 class="pagetitles">Unassigned</h4>

		<div class="unbox">
			<span class="unboxtitle">Families</span>
			@foreach ($unassignedFamilies as $unassigned)
				{{ $unassigned->first_name }} {{ $unassigned->last_name }}<br/>
			@endforeach
		</div>

		<div class="unbox">
			<span class="unboxtitle">Hometeachers</span>
			@foreach ($unassignedHomeTeachers as $unassigned)
				{{ $unassigned->first_name }} {{ $unassigned->last_name }}<br/>
			@endforeach
		</div>
	</div>

	<div class="subcenterboxright">
		<div class="pagetitles pagecompstitle"><h4 class="compstitle">Companionships</h4>
			<div id="searchboxcomp">
				<input type="text" placeholder="search" onkeyup="showResult(this.value, '{{ $numOfFamilies }}')"/>
				<div id="livesearch"></div>
			</div>
		</div>

		<div id="compsheader">
			<span class="leftheadlabel">Hometeachers</span>
			<span class="rightheadlabel">Families</span>
		</div>

        @foreach ($existingHomeTeachers as $key => $homeTeachers)
			<div id="fullcomprow{{ $homeTeachers->id }}" class="comprow">

				<div class="rightstuff">
					<div class="famholder">
						@foreach ($existingHomeTeacherCompanion[$key]['families'] as $family)
							<div class="familyname">
								<div class="famlabel">{{ $family['first_name'][0] }} {{ $family['last_name'] }}</div>
								<a class="remfamicon glyphicon glyphicon-remove" onclick="remfam('{{ $family['id'] }}', '{{ $homeTeachers->id }}')"></a>
							</div>
						@endforeach
					</div>
					<a class="rowaddbtn" id="addfambtn'.$companoid.'" onclick="addfamily('{{ $homeTeachers->id }}')">+ Add Family</a>

					<form id="famform{{ $homeTeachers->id }}" class="famformclass" action="addFamily.php" method="post">
						<div class="selectbar" id="selectspot{{ $homeTeachers->id }}"></div>
						<input style="display:none;" id="thefamlist{{ $homeTeachers->id }}" name="existingfamsname" type="text" value="{{ $family['id'] }}" />
						<input style="display:none;" name="compidname" type="text" value="{{ $homeTeachers->id }}"/>
						<a class="additbtnclass" style="display:none;" id="addfamgo{{ $homeTeachers->id }}" onclick="submitfamadd('{{ $homeTeachers->id }}');">ADD</a>
					</form>
				</div>

				<div class="leftstuff">
					<a class="delcompbtn glyphicon glyphicon-trash" onclick="deletecomprow('{{ $homeTeachers->id }}')"></a></a>
					<div class="htcontainer">
						@foreach ($existingHomeTeacherCompanion[$key]['homeTeacher'] as $num => $homeTeacher)
							<div class="hter">
								@if (empty($homeTeacher['first_name']) && empty($homeTeacher['last_name']))
									<div class="addcompbox">
										<form class="hiddenselectclass" id="hiddenadd{{ $homeTeachers->id }}" method="post" action="addtheht.php"></form>
										<div class="addcomptools" style="display:none;" id="addtools{{ $homeTeachers->id }}">
											<a class="addcancelbtn glyphicon glyphicon-remove" onclick="nevermind('{{ $homeTeachers->id }}');"></a>
											<a class="glyphicon glyphicon-floppy-disk" onclick="savenewcomp('{{ $homeTeachers->id }}');"></a>
										</div>
										<a id="addnewcompbtn{{ $homeTeachers->id }}" class="addacompbtn" onclick="addnewcomp('{{ $homeTeachers->id }}', '{{ $num }}');">+ Add New Comp</a>
									</div>
								@else
									<a onclick="remht('{{ $homeTeachers->id }}', '{{ $num }}')" class="glyphicon glyphicon-remove"></a>
									{{ $homeTeacher['first_name'] }} {{ $homeTeacher['last_name'] }}
								@endif
							</div>
						@endforeach
						@if (!empty($existingHomeTeacherCompanion[$key]['districtMember']))
							<div class="districtbox">
								<a class="dassigned" onclick="updistrict('{{ $homeTeachers->id }}')">
									District:
									{{ $existingHomeTeacherCompanion[$key]['districtMember']['first_name'] }}
									{{ $existingHomeTeacherCompanion[$key]['districtMember']['last_name'] }}
								</a>
							</div>
						@else
							<div class="districtbox">
								<a class="nodistrict" onclick="updistrict('{{ $homeTeachers->id }}');">Assign District</a>
							</div>
						@endif
						<div class="distcontrollclass" id="districtcontrol{{ $homeTeachers->id }}"></div>
					</div>
				</div>
			</div>
		@endforeach
    </div>
</div>


<form id="removedacomp" action="updatecomp.php" method="post" style="display:none;">
	<input id="formcompid" name="formcompname" type="text" value=""/>
	<input id="formhtnumberid" name="formhtnumname" type="text" value=""/>
</form>

<form id="removedafamily" action="removeFamily.php" method="post" style="display:none;">
	<input id="famcomperid" name="compidname" type="text" value=""/>
	<input id="famfamerid" name="famidname" type="text" value=""/>
</form>

<div style="display:none;" id="districtchangebox">
	<form class="discform" id="dischangeform" action="updatedistrict.php" method="post">
		<input style="display:none;" type="text" id="mycompider" name="mycompnamer" value=""/>
		<input style="display:none;" type="text" id="wardider" name="wardidname" value="{{ $wardId }}"/>
		<input style="display:none;" type="text" id="quorumider" name="quorumidname" value="{{ $quorumId }}"/>

		<select class="myselect" name="thedistrictname">
			<option value="0">Not Selected</option>
			@foreach ($districtList as $key => $district)
				<option value="{{ $district['id'] }}">{{ $districtMembers[$key]['first_name'] }} {{ $districtMembers[$key]['last_name'] }}</option>
			@endforeach
		</select>

		<div id="districtbtns"></div>
	</form>
</div>

<form style="display:none;" id="searchmemberform" action="searchmembers.php" method="post">

	<input type="text" id="memberid" name="memberidname"/>
	<input type="text" id="membernameid" name="membernamename"/>

</form>

<script type="text/javascript">

var namernum = 2;
var totalfamilies = 1;
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
for(r = 1; r < parseInt(numrecipes); r++){
	var thedishname = $('#searchmem' + r).children('.searchname').html();
	var therecipesrealid = $('#searchmem' + r).children('span').html();
	var fromthesearch = 1;
	if(thedishname.toLowerCase().indexOf(str) >= 0 || thedishname.indexOf(str) >= 0)
		{
			listarray.push('<a class="searchresultrow" onclick="viewresults(\'' + therecipesrealid + '\',&quot;' + thedishname + '&quot;' + ')">' + thedishname + '</a><br />');
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
@stop