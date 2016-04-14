@extends('layouts.default', ['title' => 'Dashboard'])

@section('content')
<div id="commentslidomatic">
	<div id="commentbar">

		<div id="commentbox">
			<span id="commenttitle"></span>
			<form id="commentformid" method="post">
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
				<span id="displayvisitnum{{ $myFamilies[$index]['family']['id'] }}" class="visitnumber">{{ $myFamilies[$index]['visitCount'] }}</span>
				<span class="visitnumber">/{{ date("n") }}</span>
				<span class="visitstitle">visits</span>
			</div>

			<span id="familynameid{{ $index }}" class="famdisplay">{{ $myFamilies[$index]['family']['last_name'] }}, {{ $myFamilies[$index]['family']['first_name'] }}  {{ $myFamilies[$index]['family']['spouse_name'] ? '& ' . $myFamilies[$index]['family']['spouse_name'] : '' }}</span>
		</div>

		<div style="display:none;" id="hiddenmonths{{ $myFamilies[$index]['family']['last_name'] }}" class="monthrows">

			@foreach ($months as $abbr => $month)
				<div class="monthitem">
					<div class="visitclickitem">
						<a class="visiticon glyphicon js-dashboard-report-yes
							@if (in_array($abbr, $myFamilies[$index]['visitMonthYes']))
								glyphicon-ok-sign
							@else
								glyphicon-unchecked
							@endif"
						onclick="checkVisitYes('{{ $myFamilies[$index]['family']['id'] }}' , '{{ $abbr }}' , this.id, '{{ $companion['id'] or '' }}');"  id="{{ $abbr }}-{{ $myFamilies[$index]['family']['last_name'] }}-yes">
							<span class="Dashboard__reporting">Yes</span>
						</a>

						<a class="visiticon glyphicon js-dashboard-report-no
							@if (in_array($abbr, $myFamilies[$index]['visitMonthNo']))
								glyphicon-ok-sign
							@else
								glyphicon-unchecked
							@endif"
						onclick="checkVisitNo('{{ $myFamilies[$index]['family']['id'] }}' , '{{ $abbr }}' , this.id, '{{ $companion['id'] or '' }}');"  id="{{ $abbr }}-{{ $myFamilies[$index]['family']['last_name'] }}-no">
							<span class="Dashboard__reporting">No</span>
						</a>

						<span class="monthlabel @if (in_array($abbr, $myFamilies[$index]['visitMonth'])) home-taught-month @endif">{{ $month }}</span>
					</div>
					<a class="commentbutton
						@if (in_array($abbr, $myFamilies[$index]['visitMonth']))
							commentbutton--show
						@endif"
					   onclick="monthcomment('{{ $myFamilies[$index]['family']['id'] }}', '{{ $companionship->id or '' }}', '{{ $authId }}', '{{ $wardId }}', '{{ $abbr }}', '{{ $year }}');">Add Comment</a>
				</div>
			@endforeach

		</div>

		<div style="display:none;" id="family{{ $myFamilies[$index]['family']['id'] }}">
			@foreach ($myFamilies[$index]['comments'] as $comment)
				<div id="fullcommentrow{{ $comment->id }}" class="famcommentrow">
					<div class="commentcont">
						<div class="commentmonth">{{ $comment->visitMonth }} {{ $comment->visitYear }}</div>
						<div>{{ $comment->commentText }}</div>
					</div>
					<div style="display:none;" id="commentconfirm{{ $comment->id }}" class="delcommentbox">
						<span class="delconftitle">Delete Comment?</span>
						<a class="delconfbtn btn btn-primary" onclick="confdelete('{{ $comment->id }}');">Yes</a>
						<a class="delconfbtn delright btn btn-danger" onclick="dontdelete('{{ $comment->id }}');">No</a>
					</div>
					<a class="delcomment glyphicon glyphicon-remove" onclick="deletecomment('{{ $comment->id }}');"></a>
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
			<span class="famdisplayt">{{ $homeTeacher->first_name }} {{ $homeTeacher->last_name }}</span>
			<br />
			<span class="htphonenum">{{ $homeTeacher->phone }}</span>
		</div>
	@empty
		<p class="notext">No home teachers assigned yet</p>
	@endforelse
</div>

<script type="text/javascript">
var totalfamilies = parseInt('{{ $numFamilies }}');
var menuopen = false;
var commentopens = false;
</script>
@stop