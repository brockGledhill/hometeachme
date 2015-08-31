@extends('layouts.default')

@section('content')
	<div class="subcenterbox">

		<h4 class="pagetitles">Reset Password</h4>

		<form class="ResetPassword" action="/members/password/reset?id={{ $WardMember->id }}" method="post">
			{!! csrf_field() !!}
			<div class="addcompanrow">
				Are you sure you want to reset the password for {{ $WardMember->first_name }} {{ $WardMember->last_name }}?
			</div>

			<input type="submit" class="Btn__Primary btn btn-default" value="Yes" />
			<a href="/members/edit?id={{ $WardMember->id }}" class="btn btn-default">No</a>
		</form>

	</div>
@stop