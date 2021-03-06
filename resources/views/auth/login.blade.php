@extends('layouts.pre_login', ['title' => 'Login', 'bodyId' => 'loginpage'])

@section('content')
<div id="loginpanel">
	<div id="loginbox">
		<h3>Hometeach Me</h3>

		<form action="/login" method="post">
			{!! csrf_field() !!}
			<input name="email" type="text" placeholder="email"/>
			<input name="password" type="password" placeholder="password"/>

			<button class="login-button" type="submit" title="login">Login</button>

		</form>
	</div>
</div>

<div class="emptybackcontainer">

	<div class="middlepeice">

		<div class="topside">
			<div class="lightheader">Report on the go</div>
			<div class="lightpara">Now reporting your hometeaching is easier than ever. Simply tap/click the month you
				visited your families and leave comments on how it went.
			</div>
		</div>
		<div class="bottomside"></div>

	</div>

</div>
@stop