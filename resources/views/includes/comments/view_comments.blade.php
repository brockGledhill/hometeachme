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
			@foreach ($comments as $comment)
				<tr>
					<td>{{ $comment->family->firstName }}@if ($comment->family->spouse_name) & {{ $comment->family->spouse_name }}@endif {{ $comment->family->lastName }}</td>
					<td>{{ $comment->commentText }}</td>
					<td>
						@if (!empty($comment->companionship->htOne->id) || !empty($comment->companionship->htTwo->id))
							{{ $comment->companionship->htOne->firstName }} {{ $comment->companionship->htOne->lastName }}<br />
							{{ $comment->companionship->htTwo->firstName }} {{ $comment->companionship->htTwo->lastName }}
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