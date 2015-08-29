@extends('layouts.default')

@section('content')
<div class="subcenterbox">

	<h4 class="pagetitles">Family Visit Totals</h4>

	<div id="statscontainer">

		<div id="famvisits" class="addcompanrow">

			@foreach ($visitMonths as $visitMonth)
				<div class="mymonths" id="monthdisplay{{ $visitMonth['visit_month'] }}"
					 onclick="togmonthfamily('{{ $visitMonth['visit_month'] }}')">
					<div class="monthstatrow">
						<span id="montharrow{{ $visitMonth['visit_month'] }}"
							  class="visarrow glyphicon glyphicon-menu-right"></span>
						<span>{{ $visitMonth['visit_month'] }}</span>
						<span class="visitsnums">{{ $visitMonth['count'] }}</span>
					</div>

					<div style="display:none;" id="hidevisfams{{ $visitMonth['visit_month'] }}" class="hidesection">
						@foreach ($members[$visitMonth['visit_month']] as $member)
							<div class="famvisnames">{{ $member['first_name'] }} {{ $member['last_name'] }}</div>
						@endforeach
					</div>

				</div>
			@endforeach
		</div>
		<div id="visitschart" class="addcompanrow">
			<canvas id="myChart" width="650" height="400"></canvas>
		</div>
	</div>
</div>

<form id="editmemberform" action="editmember.php" method="post" style="display:none;">
	<input id="membereditidbox" name="membereditname" type="text"/>
</form>

<script type="text/javascript" src="/js/charts/Chart.js"></script>
<script type="text/javascript">
var totalfamilies = 0;
var menuopen = false;
var montharray = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
runallthis();
function runallthis() {
	var Jan = 0;
	var Feb = 0;
	var Mar = 0;
	var Apr = 0;
	var May = 0;
	var Jun = 0;
	var Jul = 0;
	var Aug = 0;
	var Sep = 0;
	var Oct = 0;
	var Nov = 0;
	var Dec = 0;

	for(i = 0; i < 12; i++){
		if( $("#monthdisplay" + montharray[i]).length) {
			var insidemonth = montharray[i];
			switch(insidemonth) {
				case "Jan":
					Jan = $("#monthdisplay"+ insidemonth + " .visitsnums").html();
					break;
				case "Feb":
					Feb = $("#monthdisplay" + insidemonth + " .visitsnums").html();
					break;
				case "Mar":
					Mar = $("#monthdisplay" + insidemonth + " .visitsnums").html();
					break;
				case "Apr":
					Apr = $("#monthdisplay" + insidemonth + " .visitsnums").html();
					break;
				case "May":
					May = $("#monthdisplay" + insidemonth + " .visitsnums").html();
					break;
				case "Jun":
					Jun = $("#monthdisplay" + insidemonth + " .visitsnums").html();
					break;
				case "Jul":
					Jul = $("#monthdisplay" + insidemonth + " .visitsnums").html();
					break;
				case "Aug":
					Aug = $("#monthdisplay" + insidemonth + " .visitsnums").html();
					break;
				case "Sep":
					Sep = $("#monthdisplay" + insidemonth + " .visitsnums").html();
					break;
				case "Oct":
					Oct = $("#monthdisplay" + insidemonth + " .visitsnums").html();
					break;
				case "Nov":
					Nov = $("#monthdisplay" + insidemonth + " .visitsnums").html();
					break;
				case "Dec":
					Dec = $("#monthdisplay" + insidemonth + " .visitsnums").html();
					break;
			}
		}
	}

	var data = {
		labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
		datasets: [
			{
				label: "My First dataset",
				fillColor: "rgba(165,243,231,0.2)",
				strokeColor: "rgba(129,78,121,1)",
				pointColor: "rgba(129,78,121,1)",
				pointStrokeColor: "#fff",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(220,220,220,1)",
				data: [ Jan, Feb, Mar, Apr, May, Jun, Jul, Aug, Sep, Oct, Nov, Dec ]
			},

		]
	};

	var ctx = document.getElementById("myChart").getContext("2d");
	var ctx = $("#myChart").get(0).getContext("2d");
	var myNewChart = new Chart(ctx);
	new Chart(ctx).Line(data,  {
		responsive: true
	});
}
</script>
@stop