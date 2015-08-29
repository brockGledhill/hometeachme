@extends('layouts.default')

@section('content')
<div class="subcenterbox">

	<h4 class="pagetitles">Add New District</h4>

	<form id="newdistform" method="post">
		{!! csrf_field() !!}
		<input style="display:none;" name="ward_id" value="{{ $wardId }}"/>
		<input style="display:none;" name="quorum_id" value="{{ $quorumId }}"/>

		<div class="addcompanrow">
			<span class="familytitle">District Leader</span>

			<select name="member_id">
				<option value="0">Not Selected</option>
				@foreach ($families as $family)
					<option value="{{ $family['id'] }}">{{ $family['first_name'] }} {{ $family['last_name'] }}</option>
				@endforeach
			</select>

		</div>

		<a onclick="submitdist()" class="newsavebtn btn btn-default">Add</a>

	</form>

</div>

<div class="subcenterbox">
	<h4 class="pagetitles">Current Districts</h4>

	@foreach ($districts as $member)
		<div class="memberrow">
			<div class="memname">
				{{ $member['first_name'] }} {{ $member['last_name'] }}
			</div>
		</div>
	@endforeach

</div>

<script type="text/javascript">
var totalfamilies = 0;
var menuopen = false;
</script>
@stop