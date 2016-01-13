@extends('layouts.default', ['title' => 'Comments'])

@section('content')
	<div class="subcenterbox Comments">
		<h4 class="pagetitles">Comments</h4>

		<div>
			<span class="familytitle">Date</span>

			<select id="viewCommentMonth" name="month">
				@foreach ($months as $num => $month)
					<option value="{{ $num }}" @if ($month === $selectedMonth)selected="selected"@endif>{{ $month }}</option>
				@endforeach
			</select>

			<select id="viewCommentYear" name="year">
				@for ($year = $firstYear; $year <= $nowYear; ++$year)
					<option value="{{ $year }}" @if ($year === $selectedYear)selected="selected"@endif>{{ $year }}</option>
				@endfor
			</select>
		</div>

		<div id="viewCommentContainer">
			@include('includes.comments.view_comments')
		</div>
	</div>
	<script type="text/javascript" src="/js/comments.js"></script>
	<script type="text/javascript">
	$(function() {
		Comments.init();
	});
	</script>
@stop