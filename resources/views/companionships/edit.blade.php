@extends('layouts.default')

@section('content')
<div class="subcenterbox">

	<h4 class="pagetitles">Results For {{ $searchResult }}</h4>

	<div id="statscontainer">

		<div class="subcenterbox">

			<div class="memberrow">
				<div class="memname">{{ $WardMember->first_name }} {{ $WardMember->last_name }}</div>
				<div class="mememail">{{ $WardMember->email }}</div>
				<div class="memphone">{{ $WardMember->phone }}</div>
				<div class="memrowtools">
					<a href="/members/edit?id={{ $WardMember->id }}" class="memedit glyphicon glyphicon-pencil"></a>
					<form id="removeMember{{ $WardMember->id }}" action="/members/delete?id={{ $WardMember->id }}" method="post" style="display: none;">
						{!! csrf_field() !!}
					</form>
					<a onclick="removemember('{{ $WardMember->id }}')" class="memdelete glyphicon glyphicon-remove"></a>
				</div>
			</div>

		</div>

		<h4>Hometeaching Assignment</h4>

		<div class="subcenterbox resultbox">

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

		<h4>Hometeachers</h4>

		<div class="subcenterbox resultbox">

		</div>

	</div>

</div>

<script type="text/javascript">
var totalfamilies = 0;
var menuopen = false;
</script>
@stop