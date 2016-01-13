@extends('layouts.default')

@section('content')
@foreach ($families as $key => $family)
	<div style="display:none;" id="searchmem{{ $key }}">
		<div class="searchname">{{ $family->first_name }} {{ $family->last_name }}</div>
		<span>{{ $family->id }}</span>
	</div>
@endforeach
<div style="display:none;" id="familyselector">
	<select onchange="setfaminput(this.value)" class="newfamrow" name="member_id[]">
		<option value="0">Not Selected</option>
		@foreach ($families as $family)
			<option value="{{ $family->id }}">{{ $family->first_name }} {{ $family->last_name }}</option>
		@endforeach
	</select>
</div>

<div class="subcenterbox">
    <h4 class="pagetitles">Create New Companionship</h4>

	<form id="newcompform" action="/companionships/add" method="post">
		{!! csrf_field() !!}
		<input type="hidden" name="quorum_id" value="{{ $quorumId }}"/>
		<input type="hidden" name="ward_id" value="{{ $wardId }}"/>

		<div id="familydiv" class="addcompanrow">
			<span class="familytitle">Family</span>

			<div id="pushfamselectors">
				<select onchange="setfaminput(this.value)" class="newfamrow" id="familyider1" name="member_id[]">
					<option value="0">Not Selected</option>
					@foreach ($families as $family)
						<option value="{{ $family->id }}">{{ $family->last_name }}, {{ $family->first_name }}</option>
					@endforeach
				</select>
				<select onchange="setfaminput(this.value)" class="newfamrow" id="familyider2" name="member_id[]">
					<option value="0">Not Selected</option>
					@foreach ($families as $family)
						<option value="{{ $family->id }}">{{ $family->last_name }}, {{ $family->first_name }}</option>
					@endforeach
				</select>

			</div>
			<a id="additionalfambtn" onclick="onemorefamily()">Additional Family</a>

			<div class="addcompanrow">
				<span class="familytitle">Home Teacher</span>
				<select class="myselect" name="ht_one_id">
					<option value="0">Not Selected</option>
					@foreach ($families as $family)
						<option value="{{ $family->id }}">{{ $family->last_name }}, {{ $family->first_name }}</option>
					@endforeach
				</select>
			</div>
			<div class="addcompanrow">
				<span class="familytitle">Home Teacher</span>

				<div id="useableselect">
					<select class="myselect" name="ht_two_id">
						<option value="0">Not Selected</option>
						@foreach ($families as $family)
							<option value="{{ $family->id }}">{{ $family->last_name }}, {{ $family->first_name }}</option>
						@endforeach
					</select>
				</div>
			</div>

			<input type="submit" class="newsavebtn btn btn-default" value="Add" />
		</div>
	</form>
</div>



<div id="bottomcomps">
	<div class="subcenterboxleft">
		<h4 class="pagetitles">Unassigned</h4>

		<div class="unbox">
			<span class="unboxtitle">Families</span>
			@foreach ($unassignedFamilies as $unassigned)
				{{ $unassigned->first_name }} {{ $unassigned->last_name }}<br/>
			@endforeach
		</div>

		<div class="unbox">
			<span class="unboxtitle">Hometeachers</span>
			@foreach ($unassignedHomeTeachers as $unassigned)
				{{ $unassigned->first_name }} {{ $unassigned->last_name }}<br/>
			@endforeach
		</div>
	</div>

	<div class="subcenterboxright">
		<div class="pagetitles pagecompstitle"><h4 class="compstitle">Companionships</h4>
			<div id="searchboxcomp">
				<input type="text" placeholder="search" onkeyup="showResult(this.value, '{{ $numOfFamilies }}')"/>
				<div id="livesearch"></div>
			</div>
		</div>

		<div id="compsheader">
			<span class="leftheadlabel">Hometeachers</span>
			<span class="rightheadlabel">Families</span>
		</div>

        @foreach ($existingHomeTeachers as $key => $homeTeachers)
			<div id="fullcomprow{{ $homeTeachers->id }}" class="comprow">

				<div class="rightstuff">
					<div class="famholder">
						@foreach ($existingHomeTeacherCompanion[$key]['families'] as $family)
							@if (empty($family['first_name']))
								<?php continue; ?>
							@endif
							<div class="familyname">
								<div class="famlabel">{{ $family['first_name'][0] }} {{ $family['last_name'] }}</div>
								<form action="/companionships/members/delete?id={{ $family['ward_companionship_member_id'] }}" method="post">
									{!! csrf_field() !!}
									<a class="remfamicon glyphicon glyphicon-remove" onclick="$(this).closest('form').submit();"></a>
								</form>
							</div>
						@endforeach
					</div>
					<a class="rowaddbtn" id="addfambtn{{ $homeTeachers->id }}" onclick="addfamily('{{ $homeTeachers->id }}')">+ Add Family</a>

					<form id="addfamform{{ $homeTeachers->id }}" class="famformclass" action="/companionships/members/add" method="post" style="display:none;">
						{!! csrf_field() !!}
						<select class="myselect" name="member_id">
							<option value="0">Not Selected</option>
							@foreach ($families as $family)
								<option value="{{ $family->id }}">{{ $family->last_name }}, {{ $family->first_name }}</option>
							@endforeach
						</select>
						<input name="companionship_id" type="hidden" value="{{ $homeTeachers->id }}"/>
						<input class="additbtnclass newsavebtn btn btn-default" id="addfamgo{{ $homeTeachers->id }}" type="submit" value="ADD" />
					</form>
				</div>

				<div class="leftstuff">
					<a class="delcompbtn glyphicon glyphicon-trash" onclick="deletecomprow('{{ $homeTeachers->id }}')"></a></a>
					<div class="htcontainer">
						@foreach ($existingHomeTeacherCompanion[$key]['homeTeacher'] as $num => $homeTeacher)
							<div class="hter">
								@if (empty($homeTeacher['first_name']) && empty($homeTeacher['last_name']))
									<div class="addcompbox">
										<form class="hiddenselectclass" id="hiddenadd{{ $homeTeachers->id }}" method="post" action="/companionships/update?id={{ $homeTeachers->id }}" style="display: none;">
											{!! csrf_field() !!}
											<select class="myselect" name="ht_{{ $num == 1 ? 'one' : 'two' }}_id">
												<option value="0">Not Selected</option>
												@foreach ($families as $family)
													<option value="{{ $family->id }}">{{ $family->last_name }}, {{ $family->first_name }}</option>
												@endforeach
											</select>
											<div class="addcomptools" id="addtools{{ $homeTeachers->id }}">
												<a class="addcancelbtn glyphicon glyphicon-remove" onclick="nevermind('{{ $homeTeachers->id }}');"></a>
												<a class="glyphicon glyphicon-floppy-disk" onclick="savenewcomp('{{ $homeTeachers->id }}');"></a>
											</div>
										</form>
										<a id="addnewcompbtn{{ $homeTeachers->id }}" class="addacompbtn" onclick="addnewcomp('{{ $homeTeachers->id }}');">+ Add New Comp</a>
									</div>
								@else
									<form id="removedacomp{{ $homeTeachers->id }}-{{ $num }}" action="/companionships/update?id={{ $homeTeachers->id }}" method="post" style="display: none;">
										{!! csrf_field() !!}
										<input id="formcompid" name="ht_{{ $num == 1 ? 'one' : 'two' }}_id" type="hidden" value="0"/>
									</form>
									<a onclick="remht('{{ $homeTeachers->id }}', '{{ $num }}');" class="glyphicon glyphicon-remove"></a>
									{{ $homeTeacher['first_name'] }} {{ $homeTeacher['last_name'] }}
								@endif
							</div>
						@endforeach
						@if (!empty($existingHomeTeacherCompanion[$key]['districtMember']))
							<div class="districtbox">
								<a class="dassigned" onclick="updistrict('{{ $homeTeachers->id }}')">
									District:
									{{ $existingHomeTeacherCompanion[$key]['districtMember']['first_name'] }}
									{{ $existingHomeTeacherCompanion[$key]['districtMember']['last_name'] }}
								</a>
							</div>
						@else
							<div class="districtbox">
								<a class="nodistrict" onclick="updistrict('{{ $homeTeachers->id }}');">Assign District</a>
							</div>
						@endif
						<div class="distcontrollclass" id="districtcontrol{{ $homeTeachers->id }}" style="display: none;">
							<form class="discform" id="dischangeform{{ $homeTeachers->id }}" action="/companionships/districts/update?id={{ $homeTeachers->id }}" method="post">
								{!! csrf_field() !!}
								<select id="district_id_select{{ $homeTeachers->id }}" class="myselect" name="district_id">
									<option value="0">Not Selected</option>
									@foreach ($districtList as $key => $district)
										<option value="{{ $district['id'] }}">{{ $districtMembers[$key]['first_name'] }} {{ $districtMembers[$key]['last_name'] }}</option>
									@endforeach
								</select>

								<div id="districtbtns">
									<a onclick="submitdistchange('{{ $homeTeachers->id }}')" class="glyphicon glyphicon-floppy-disk"></a>
									<a onclick="districtclose('{{ $homeTeachers->id }}')" class="glyphicon glyphicon-remove"></a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		@endforeach
    </div>
</div>

<form style="display:none;" id="searchmemberform" action="searchmembers.php" method="post">

	<input type="text" id="memberid" name="memberidname"/>
	<input type="text" id="membernameid" name="membernamename"/>

</form>

<script type="text/javascript">
var namernum = 2;
var totalfamilies = 1;
var menuopen = false;
</script>
@stop