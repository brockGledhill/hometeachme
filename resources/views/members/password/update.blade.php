@extends('layouts.default')

@section('content')
	<div class="subcenterbox">

		<h4 class="pagetitles">Change Password</h4>

		<form id="editmemform" action="/profile/password/update?id={{ $WardMember->id }}" method="post">
			{!! csrf_field() !!}
			<input type="hidden" name="ward_id" value="{{ $WardMember->ward_id }}"/>

			<div class="addcompanrow">
				<span class="familytitle">Current Password</span>
				<input id="current_password" name="current_password" type="password" />
				<a class="js-show-password">Show Password</a>
			</div>

			<div class="addcompanrow">
				<span class="familytitle">New Password</span>
				<input id="newPassword1" name="new_password_1" type="password" />
				<a class="js-show-password">Show Password</a>
			</div>

			<div class="addcompanrow">
				<span class="familytitle">Repeat Password</span>
				<input id="newPassword2" name="new_password_2" type="password" />
				<a class="js-show-password">Show Password</a>
			</div>

			<input type="submit" class="newchangebtn btn btn-default" value="Save Password" />
			<a href="/profile" class="canceledit btn btn-default">Cancel</a>
		</form>

	</div>
@stop