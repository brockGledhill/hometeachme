<div id="adminnav">
	<a class="adminbtn {{ \App\Http\Helpers\ViewHelper::setActive('companionships', 'filledin') }}" href="/companionships">Companionships</a>
	<a class="adminbtn pushadmin {{ \App\Http\Helpers\ViewHelper::setActive('members', 'filledin') }}" href="/members">Members</a>
	<a class="adminbtn pushadmin {{ \App\Http\Helpers\ViewHelper::setActive('districts', 'filledin') }}" href="/districts">Districts</a>
	<a class="adminbtn pushadmin {{ \App\Http\Helpers\ViewHelper::setActive('stats', 'filledin') }}" href="/stats">Stats</a>
	<a class="adminbtn pushadmin {{ \App\Http\Helpers\ViewHelper::setActive('comments', 'filledin') }}" href="/comments">Comments</a>
</div>