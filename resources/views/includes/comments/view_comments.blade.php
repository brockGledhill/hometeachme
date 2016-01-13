@if (!$comments->isEmpty())
	<table class="Comments__table">
		<thead>
			<tr>
				<th>Family</th>
				<th>Comment</th>
				<th>Home Teachers</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($comments as $key => $comment)
				<tr>
					<td>{{ $families[$key]->first_name }}@if ($families[$key]->spouse_name) & {{ $families[$key]->spouse_name }}@endif {{ $families[$key]->last_name }}</td>
					<td>{{ $comment->comment_text }}</td>
					<td>
						@if (!empty($homeTeachers[$key]))
							@foreach ($homeTeachers[$key] as $homeTeacher)
								{{ $homeTeacher->first_name }} {{ $homeTeacher->last_name }} <br />
							@endforeach
						@else
							Not Assigned
						@endif
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	<div class="Comments__empty">No comments found for {{ $selectedMonth }}, {{ $selectedYear }}</div>
@endif