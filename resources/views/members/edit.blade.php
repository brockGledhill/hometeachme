@extends('layouts.default')

@section('content')
<div class="subcenterbox">

	<h4 class="pagetitles">Edit Member</h4>

	<form id="editmemform" action="/members/update?id={{ $WardMember->id }}" method="post">
		{!! csrf_field() !!}
		<input type="hidden" name="ward_id" value="{{ $WardMember->ward_id }}"/>

		<div class="addcompanrow">
			<span class="familytitle">First Name</span>
			<input id="firstnameid" name="first_name" type="text" value="{{ $WardMember->first_name }}"/>
		</div>
		<div class="addcompanrow">
			<span class="familytitle">Last Name</span>
			<input id="lastnameid" name="last_name" type="text" value="{{ $WardMember->last_name }}"/>
		</div>
		<div class="addcompanrow">
			<span class="familytitle">Spouse</span>
			<input id="spousenameid" name="spouse_name" type="text" placeholder="(first name)" value="{{ $WardMember->spouse_name }}"/>
		</div>
		<div class="addcompanrow">
			<span class="familytitle">Phone</span>
			<input id="phoneid" name="phone" type="text" value="{{ $WardMember->phone }}"/>
		</div>
		<div class="addcompanrow">
			<span class="familytitle">Email</span>
			<input id="emailid" name="email" type="text" value="{{ $WardMember->email }}"/>
		</div>
		<div class="addcompanrow">
			<span class="familytitle">Password</span>
			<a href="/members/password/reset?id={{ $WardMember->id }}">Reset Password</a>
		</div>
		<div class="addcompanrow">
			<span class="familytitle">Quorum</span>

			<select id="quorumid" name="quorum_id">
				<option value="1">Elder</option>
				<option value="2" @if ($WardMember->quorum_id == 2) selected @endif>High Priest</option>
			</select>
		</div>
		<div class="addcompanrow">
			<span class="familytitle">Admin?</span>

			<select id="adminid" name="is_admin">
				<option value="0">No</option>
				<option value="1" @if ($WardMember->is_admin == true) selected @endif>Yes</option>
			</select>
		</div>
		<div class="addcompanrow">
			<span class="familytitle">Jr Companion?</span>

			<select id="jrcompid" name="is_jr_comp">
				<option value="0">No</option>
				<option value="1" @if ($WardMember->is_jr_comp == true) selected @endif>Yes</option>
			</select>
		</div>

		<input type="submit" class="newchangebtn btn btn-default" value="Save Changes" />
		<a href="/members" class="canceledit btn btn-default">Cancel</a>
	</form>

</div>
@stop