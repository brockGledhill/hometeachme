@extends('layouts.default')

@section('content')
<div class="subcenterbox">

	<h4 class="pagetitles">Update My Profile</h4>

	<form id="profileUpdate" method="post">
		{!! csrf_field() !!}
		<input style="display:none;" name="thewardidname" value="'.  $mywardid .'"/>
		<input style="display:none;" name="thememberid" value="'. $row[MemberID] .'"/>

		<div class="addcompanrow">
			<span class="familytitle">First Name</span>
			<input id="firstnameid" name="first_name" type="text" value="{{ $myInfo['first_name'] }}"/>
		</div>
		<div class="addcompanrow">
			<span class="familytitle">Last Name</span>
			<input id="lastnameid" name="last_name" type="text" value="{{ $myInfo['last_name'] }}"/>
		</div>
		<div class="addcompanrow">
			<span class="familytitle">Spouse</span>
			<input id="spousenameid" name="spouse_name" type="text" placeholder="(first name)" value="{{ $myInfo['spouse_name'] }}"/>
		</div>
		<div class="addcompanrow">
			<span class="familytitle">Phone</span>
			<input id="phoneid" name="phone" type="text" value="{{ $myInfo['phone'] }}"/>
		</div>
		<div class="addcompanrow">
			<span class="familytitle">Email</span>
			<input id="emailid" name="email" type="text" value="{{ $myInfo['email'] }}"/>
		</div>
		<div class="addcompanrow">
			<span class="familytitle">Password</span>
			<input id="passwordid" name="password" type="password" value=""/>
		</div>

		@if ($adminStatus)
			<div class="addcompanrow">
				<span class="familytitle">Quorum</span>

				<select id="quorumid" name="quorum_id">
					<option value="1">Elder</option>
					<option value="2" @if ($myInfo['quorum_id'] == 2) selected @endif>High Priest</option>
				</select>
			</div>
			<div class="addcompanrow">
				<span class="familytitle">Admin?</span>

				<select id="adminid" name="is_admin">
					<option value="1">Yes</option>
					<option value="0">No</option>
				</select>

			</div>
		@endif

		<input type="submit" class="newchangebtn btn btn-default" value="Save Changes">
	</form>

</div>
@stop