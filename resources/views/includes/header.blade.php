<div id="topbar">
	<a href="/dashboard" id="homebtnid" class="topbtn {{ \App\Http\Helpers\ViewHelper::setActive('dashboard') }}" title="home">
		<span class="glyphicon glyphicon-home"></span>
	</a>
	<a href="/notifications" class="topbtn {{ \App\Http\Helpers\ViewHelper::setActive('notifications') }}" title="notifications">
		<span class="glyphicon glyphicon-bell"></span>
	</a>
	<a href="messages.php" class="topbtn {{ \App\Http\Helpers\ViewHelper::setActive('messages') }}" title="messages">
		<span class="glyphicon glyphicon-envelope"></span>
	</a>
	<a href="myprofile.php" class="topbtn {{ \App\Http\Helpers\ViewHelper::setActive('profile') }}" title="profile">
		<span class="glyphicon glyphicon-cog"></span>
	</a>
	<a href="/logout" class="logout topbtn pushright" title="logout">
		<span class="glyphicon glyphicon-log-out"></span>
	</a>
</div>