$(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		}
	});
	//On successful ajax requests, show the banner if there is a message and a status.
	$(document).ajaxSuccess(function(event, xhr, settings) {
		if (xhr.responseJSON && xhr.responseJSON.message && '' !== xhr.responseJSON.message && xhr.responseJSON.status && '' !== xhr.responseJSON.status) {
			Message.display(xhr.responseJSON.status, xhr.responseJSON.message);
		}
	});
	$('.js-show-password').click(function() {
		var $this = $(this);
		var $input = $this.siblings('input');
		if ('password' === $input.attr('type')) {
			$input.attr('type', 'text');
			$this.text('Hide Password');
		} else {
			$input.attr('type', 'password');
			$this.text('Show Password');
		}
	});
});

function deletecomprow(compid) {
	$.ajax({
		url: '/companionships/delete?id=' + compid,
		type: 'post',
		data: {'thecompid': compid},
		success: function(data, status) {
			$("#fullcomprow" + compid).slideUp();
		},
	}); // end ajax call
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
		url: '/comments/delete',
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

function checkVisitYes(houseid, vmonth, currentitem, housename) {
	checkvisit(houseid, vmonth, currentitem, housename, 'yes');
}

function checkVisitNo(houseid, vmonth, currentitem, housename) {
	checkvisit(houseid, vmonth, currentitem, housename, 'no');
}

var runningvisitupdate = false;
function checkvisit(houseid, vmonth, currentitem, housename, yesNo) {
	var $curItem = $("#" + currentitem);
	var yesnostring = $("#" + currentitem + " span").html();
	var $curItemSpan = $curItem.find("span");
	$curItemSpan.html('updating...');
	var visnum = Number(document.getElementById("displayvisitnum" + houseid).innerHTML);
	var other = '';
	if ($curItem.hasClass("js-dashboard-report-no")) {
		other = '.js-dashboard-report-yes';
		if ($curItem.hasClass('glyphicon-ok-sign') || $curItem.closest('.monthitem').find(other).hasClass('glyphicon-ok-sign')) {
			--visnum;
		}
	} else {
		++visnum;
		other = '.js-dashboard-report-no';
	}
	if (!runningvisitupdate) {
		runningvisitupdate = true;
		$.ajax({
			url: '/visit/add',
			type: 'post',
			data: {
				'member_id': houseid,
				'visit_month': vmonth,
				'comp_id': housename,
				'visited': yesNo
			},
			success: function (data, status) {
				$curItem.removeClass('glyphicon-unchecked').addClass("glyphicon-ok-sign");
				$curItem.closest('.visitclickitem').find('.monthlabel').addClass('home-taught-month');
				$curItem.closest('.monthitem').find(".commentbutton").show();
				$curItem.closest('.monthitem').find(other).removeClass('glyphicon-ok-sign').addClass("glyphicon-unchecked");
				$("#displayvisitnum" + houseid).html(visnum);
				$curItemSpan.html(yesnostring);
				runningvisitupdate = false;
			},
			error: function() {
				runningvisitupdate = false;
			}
		}); // end ajax call
	}
}

function monthcomment(familyid, companionshipid, memberId, wardId, themonth, year) {
	$("#commenttitle").html(themonth + ' ' + year + ' comments');
	$("#monthinput").val(themonth);
	$("#companionshipinput").val(companionshipid);
	$("#familyinput").val(familyid);
	$("#hometeacherinput").val(memberId);
	$("#wardinput").val(wardId);

	$(".centerbox").toggle( "slide", {direction:"left"}, 700);
	$( "#commentslidomatic" ).toggle( "slide", {direction:"right"}, 700 );

	$("#previouscomments").html($("#family" + familyid).html());
}

function savedacomment() {
	var thecurrentfamily = $("#familyinput").val();

	$.ajax({
		url: '/comments/add',
		type: 'post',
		data: {
			'comment_text': $("#textcommentbox").val(),
			'family_id': $("#familyinput").val(),
			'companionship_id': $("#companionshipinput").val(),
			'visit_month': $("#monthinput").val()
		},
		success: function(response) {
			//temporarily add the dom elements of the comment to show it was added
			document.getElementById("previouscomments").innerHTML += '<div id="fullcommentrow' + response.id + '" class="famcommentrow"><div class="commentcont"><div class="commentmonth">'+ $("#monthinput").val() + ' 2015</div><div>'+ $("#textcommentbox").val() +'</div></div><div style="display:none;" id="commentconfirm' + response.id + '" class="delcommentbox"><span class="delconftitle">Delete Comment?</span><a class="delconfbtn btn btn-primary" href="javascript: confdelete(' + response.id + ')">Yes</a><a class="delconfbtn delright btn btn-danger" href="javascript: dontdelete(' + response.id + ')">No</a></div><a class="delcomment glyphicon glyphicon-remove" href="javascript: deletecomment(' + response.id + ')"></a></div>';
			document.getElementById("family" + thecurrentfamily).innerHTML += '<div id="fullcommentrow' + response.id + '" class="famcommentrow"><div class="commentcont"><div class="commentmonth">'+ $("#monthinput").val() + ' 2015</div><div>'+ $("#textcommentbox").val() +'</div></div><div style="display:none;" id="commentconfirm' + response.id + '" class="delcommentbox"><span class="delconftitle">Delete Comment?</span><a class="delconfbtn btn btn-primary" href="javascript: confdelete(' + response.id + ')">Yes</a><a class="delconfbtn delright btn btn-danger" href="javascript: dontdelete(' + response.id + ')">No</a></div><a class="delcomment glyphicon glyphicon-remove" href="javascript: deletecomment(' + response.id + ')"></a></div>';
			$("#textcommentbox").val('')
		},
	}); // end ajax call
}

function closecomment() {
	$("#commentslidomatic").toggle("slide", {direction:"right"}, 700);
	$(".centerbox").toggle("slide", {direction:"left"}, 700);
}

function updistrict(dacompid) {
	$("#districtcontrol" + dacompid).show();
}

function submitdist() {
	$("#newdistform").submit();
}

function submitdistchange(yourcompid) {
	$("#dischangeform" + yourcompid).submit();
}

function districtclose(compid) {
	$("#districtcontrol" + compid).hide();
}

function addfamily(thecompid) {
	$("#selectspot" + thecompid).html($("#useableselect").html());
	$("#addfambtn" + thecompid).css("display","none");
	$("#addfamform" + thecompid).show();
}

function remht(cmpid, htnum) {
	$("#removedacomp" + cmpid + '-' + htnum).submit();
}

function addnewcomp(cid) {
	$("#addnewcompbtn" + cid).hide();
	$("#hiddenadd" + cid).show();
}

function nevermind(thecid) {
	$("#hiddenadd" + thecid).html('');
	$("#addnewcompbtn" + thecid).css("display","block");
	$("#addtools" + thecid).css("display","none");
}

function savenewcomp(savecid) {
	$("#hiddenadd" + savecid).submit();
}

function onemorefamily() {
	if (namernum <= 4) {
		namernum ++;
		$("#familyselector").children("select").attr("id","familyider" + namernum);
		var theselect = document.getElementById("familyselector").innerHTML;
		document.getElementById("pushfamselectors").innerHTML += theselect;
	} else {
		$("#additionalfambtn").hide();
	}
	$("#familyselector").children("select").attr("id","familyider" + namernum + 1);
	var theselect = document.getElementById("familyselector").innerHTML;
	document.getElementById("pushfamselectors").innerHTML += theselect;
	$("#pushfamselectors :last-child").hide();
}

function setfaminput(incomingvalue) {
	$("#familypile").val('');
	var famarray = [];
	for (var i = 1; i <= namernum; ++i) {
		if($("#familyider" + i).val() != 0) {
			famarray.push($("#familyider" + i).val());
		}
	}
	$("#familypile").val(String(famarray));
}

function showResult(str, numrecipes) {
	var listarray = [];
	$('#livesearch').show();
	if (str == '') {
		$('#livesearch').hide();
		listarray = [];
	} else {
		for(r = 1; r < parseInt(numrecipes); r++){
			var thedishname = $('#searchmem' + r).children('.searchname').html();
			var therecipesrealid = $('#searchmem' + r).children('span').html();
			var fromthesearch = 1;
			if(thedishname.toLowerCase().indexOf(str) >= 0 || thedishname.indexOf(str) >= 0) {
				listarray.push('<a class="searchresultrow" href="/companionships/edit?id=' + therecipesrealid + '&name=' + encodeURI(thedishname) +'">' + thedishname + '</a><br />');
			}
		}
	}
	$('#livesearch').html(listarray);
}

function removemember(thememberid) {
	$("#removeMember" + thememberid).submit();
}

function togmonthfamily(themonth) {
	$("#hidevisfams" + themonth).toggle("slow");
	if ($("#montharrow" + themonth).hasClass("glyphicon-menu-right")) {
		$("#montharrow" + themonth).removeClass("glyphicon-menu-right");
		$("#montharrow" + themonth).addClass("glyphicon-menu-down");
	} else{
		$("#montharrow" + themonth).removeClass("glyphicon-menu-down");
		$("#montharrow" + themonth).addClass("glyphicon-menu-right");
	}
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