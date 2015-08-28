@extends('layouts.default', ['title' => 'Dashboard'])

@section('content')
<div id="commentslidomatic">
	<div id="commentbar">

		<div id="commentbox">
			<span id="commenttitle"></span>
			<form id="commentformid" method="post" action="savecomment.php">
				<textarea name="commenttextname" id="textcommentbox" placeholder="your comments..."></textarea>
				<input style="display:none;" id="wardinput" name="wardinputname" type="text" />
				<input style="display:none;" id="monthinput" name="monthname" type="text" />
				<input style="display:none;" id="familyinput" name="familyname" type="text" />
				<input style="display:none;" id="hometeacherinput" name="hometeachername" type="text" />
				<input style="display:none;" id="companionshipinput" name="companionshipname" type="text" />
			</form>
			<a class="closecommentbtn" onclick="closecomment();"> < Go Back </a>
			<a class="savecommentbtn" onclick="savedacomment();">Save Comment</a>
		</div>

		<h4 id="commentheaderline">Previous Comments</h4>
		<div id="previouscomments"></div>

	</div>
</div>

<div class="centerbox">
    <h4 class="leftheader">My Families</h4>
    
    <div class="compnameclass">
		<h6>My Companion: {{ $companionName or 'No companion assigned yet' }}</h6>
		<h4 class="companphone">{{ $companionPhone or '' }}</h4>
	</div>

	@forelse ($allFamilies as $index => $family)

		<div onclick="showthemonths('{{ $myFamilies[$index]['family']['last_name'] }}');" class="familyline">
			<div class="visitcontainer">
				<div id="visitid{{ $index }}" style="display:none;">{{ $myFamilies[$index]['visitCount'] }}</div>
				<span id="displayvisitnum{{ $family['id'] }}" class="visitnumber">{{ $myFamilies[$index]['visitCount'] }}</span>
				<span class="visitnumber">/{{ date("n") }}</span>
				<span class="visitstitle">visits</span>
			</div>

			<span id="familynameid{{ $index }}" class="famdisplay">{{ $myFamilies[$index]['family']['last_name'] }}, {{ $myFamilies[$index]['family']['first_name'] }}  {{ $myFamilies[$index]['family']['spouse_name'] ? '& ' . $myFamilies[$index]['family']['spouse_name'] : '' }}</span>
		</div>

		<div style="display:none;" id="hiddenmonths{{ $myFamilies[$index]['family']['last_name'] }}" class="monthrows">

			@foreach ($months as $abbr => $month)
				<div class="monthitem">
					<div class="visitclickitem" onclick="checkvisit('{{ $family['id'] }}' , '{{ $abbr }}' , this.id, '{{ $companion['id'] or '' }}');"  id="{{ $abbr }}-{{ $myFamilies[$index]['family']['last_name'] }}">
						<a class="visiticon glyphicon
							@if (in_array($abbr, $myFamilies[$index]['visitMonth']))
								glyphicon-ok-sign
							@else
								glyphicon-unchecked
							@endif"></a>
						<span class="monthlabel @if (in_array($abbr, $myFamilies[$index]['visitMonth'])) home-taught-month @endif">{{ $month }}</span>
					</div>
					<a class="commentbutton
						@if (in_array($abbr, $myFamilies[$index]['visitMonth']))
							commentbutton--show
						@endif"
					   onclick="monthcomment('{{ $family['id'] }}', '{{ $companion['id'] or '' }}', '{{ $abbr }}');">Add Comment</a>
				</div>
			@endforeach

		</div>

		<div style="display:none;" id="family{{ $family['id'] }}">
			@foreach ($myFamilies[$index]['comments'] as $comment)
				<div id="fullcommentrow{{ $comment['id'] }}" class="famcommentrow">
					<div class="commentcont">
						<div class="commentmonth">{{ $comment['visit_month'] }} {{ $comment['visit_year'] }}</div>
						<div>{{ $comment['comment_text'] }}</div>
					</div>
					<div style="display:none;" id="commentconfirm{{ $comment['id'] }}" class="delcommentbox">
						<span class="delconftitle">Delete Comment?</span>
						<a class="delconfbtn btn btn-primary" onclick="confdelete('{{ $comment['id'] }}');">Yes</a>
						<a class="delconfbtn delright btn btn-danger" onclick="dontdelete('{{ $comment['id'] }}');">No</a>
					</div>
					<a class="delcomment glyphicon glyphicon-remove" onclick="deletecomment('{{ $comment['id'] }}');"></a>
				</div>
			@endforeach
		</div>

	@empty
		<p class="notext">No families assigned yet</p>
	@endforelse
</div>


<div class="centerbox">
	<h4>My Home Teachers</h4>

	@forelse ($myHomeTeachers as $index => $homeTeacher)
		<div class="familylinet">
			<span class="htericon glyphicon glyphicon-user"></span>
			<span class="famdisplayt">{{ $myHomeTeacherFamily[$index]['family']['first_name'] }} {{ $myHomeTeacherFamily[$index]['family']['last_name'] }}</span>
			<br />
			<span class="htphonenum">{{ $myHomeTeacherFamily[$index]['family']['phone'] }}</span>
		</div>
	@empty
		<p class="notext">No home teachers assigned yet</p>
	@endforelse
</div>

<script type="text/javascript">
var totalfamilies = parseInt('{{ $numFamilies }}');
var menuopen = false;
var commentopens = false;

function runallthis() {
	/*for (i = 0; i < totalfamilies; i++) {
		var famname = document.getElementById("familynameid" + i).innerHTML;
		console.log(famname);
		var famvisits = document.getElementById("visitid" + i).innerHTML;
		var tonumvisits = Number(famvisits);

		for (t = 1; t <= tonumvisits; t++) {
			var innermonth = document.getElementById(famname + t).innerHTML;

			$("#" + innermonth + "-" + famname + " a").removeClass("glyphicon-unchecked").addClass("glyphicon-ok-sign");
			$("#" + innermonth + "-" + famname).css("color","#5dc0b2");
			$("#" + innermonth + "-" + famname).parent().children(".commentbutton").css("display","block");
		}
	}*/
}

function deletecomment(commentid){
	$("#commentconfirm" + commentid).toggle("slide", {direction:"right"}, 700);
}

function dontdelete(commentid){
	$("#commentconfirm" + commentid).toggle("slide", {direction:"right"}, 700);
}

function confdelete(commentid){
	var thedelfamily = $("#familyinput").val();
	$.ajax({
     	 	url: '/comment/delete',
      		type: 'post',
     	 	data: {'id': commentid},
      		success: function() {
		  		$("#fullcommentrow" + commentid).css("display","none");
				$("#family" + thedelfamily).children("#fullcommentrow" + commentid).css("display","none");
      		},
		}); // end ajax call
}

function showthemonths(familyname){
	$("#hiddenmonths" + familyname).toggle("slow");
}

function checkvisit(houseid, vmonth, currentitem, housename) {
	var visnum = Number(document.getElementById("displayvisitnum" + houseid).innerHTML);
	var url = '';
	var success;
	if ($("#" + currentitem + " a").hasClass("glyphicon-ok-sign")) {
		--visnum;
		url = '/visit/delete';

		success = function (data, status) {
			$("#" + currentitem + " a").removeClass('glyphicon-ok-sign').addClass("glyphicon-unchecked");
			$("#" + currentitem + " a").parent().find('.monthlabel').removeClass('home-taught-month');
			$("#" + currentitem).parent().children(".commentbutton").hide();
			$("#displayvisitnum" + houseid).html(visnum);
		};
	} else {
		++visnum;
		url = '/visit/add';
		success = function(data, status) {
			$("#" + currentitem + " a").removeClass('glyphicon-unchecked').addClass("glyphicon-ok-sign");
			$("#" + currentitem + " a").parent().find('.monthlabel').addClass('home-taught-month');
			$("#" + currentitem).parent().children(".commentbutton").show();
			$("#displayvisitnum" + houseid).html(visnum);
		};
	}
	$.ajax({
		url: url,
		type: 'post',
		data: {
			'member_id': houseid,
			'visit_month': vmonth,
			'comp_id': housename
		},
		success: success
	}); // end ajax call
}

function monthcomment(familyid, companionshipid, themonth){
	$("#commenttitle").html(themonth + ' {{ date('Y') }} comments');
	$("#monthinput").val(themonth);
	$("#companionshipinput").val(companionshipid);
	$("#familyinput").val(familyid);
	$("#hometeacherinput").val('{{ $authId }}');
	$("#wardinput").val('{{ $wardId }}');
	
	$(".centerbox").toggle( "slide", {direction:"left"}, 700);
	$( "#commentslidomatic" ).toggle( "slide", {direction:"right"}, 700 );
	
	$("#previouscomments").html($("#family" + familyid).html());
}

function savedacomment(){
	//$("#commentformid").submit();
	
	var thecurrentfamily = $("#familyinput").val();
	
	$.ajax({
     	 	url: '/comment/add',
      		type: 'post',
     	 	data: {
				'comment_text': $("#textcommentbox").val(),
				'family_id': $("#familyinput").val(),
				'member_id': $("#hometeacherinput").val(),
				'companion_id': $("#companionshipinput").val(),
				'ward_id': $("#wardinput").val(),
				'visit_month': $("#monthinput").val()
			},
      		success: function(response) {
		
				//temporarily add the dom elements of the comment to show it was added
				document.getElementById("previouscomments").innerHTML += '<div id="fullcommentrow' + response.id + '" class="famcommentrow"><div class="commentcont"><div class="commentmonth">'+ $("#monthinput").val() + ' 2015</div><div>'+ $("#textcommentbox").val() +'</div></div><div style="display:none;" id="commentconfirm' + response.id + '" class="delcommentbox"><span class="delconftitle">Delete Comment?</span><a class="delconfbtn btn btn-primary" href="javascript: confdelete(' + response.id + ')">Yes</a><a class="delconfbtn delright btn btn-danger" href="javascript: dontdelete(' + response.id + ')">No</a></div><a class="delcomment glyphicon glyphicon-remove" href="javascript: deletecomment(' + response.id + ')"></a></div>';
				
				document.getElementById("family" + thecurrentfamily).innerHTML += '<div id="fullcommentrow' + response.id + '" class="famcommentrow"><div class="commentcont"><div class="commentmonth">'+ $("#monthinput").val() + ' 2015</div><div>'+ $("#textcommentbox").val() +'</div></div><div style="display:none;" id="commentconfirm' + response.id + '" class="delcommentbox"><span class="delconftitle">Delete Comment?</span><a class="delconfbtn btn btn-primary" href="javascript: confdelete(' + response.id + ')">Yes</a><a class="delconfbtn delright btn btn-danger" href="javascript: dontdelete(' + response.id + ')">No</a></div><a class="delcomment glyphicon glyphicon-remove" href="javascript: deletecomment(' + response.id + ')"></a></div>';

				emptythebox();
      		},
		}); // end ajax call	
}

function closecomment() {
	$( "#commentslidomatic" ).toggle("slide", {direction:"right"}, 700);
	$( ".centerbox" ).toggle("slide", {direction:"left"}, 700);
}

function emptythebox() {
	$("#textcommentbox").val('')
}
runallthis();
</script>
@stop