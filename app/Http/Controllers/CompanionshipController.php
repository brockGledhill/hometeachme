<?php
namespace app\Http\Controllers;

use App\WardCompanions;
use App\WardCompanionshipMembers;
use App\WardDistricts;
use App\WardMember;
use Illuminate\Support\Facades\Auth;

class CompanionshipController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function getIndex() {
		$authUser = Auth::user();
		$data['quorumId'] = $authUser->quorum_id;
		$data['wardId'] = $authUser->ward_id;

		$data['families'] = WardMember::where('ward_id', '=', $authUser->ward_id)->where('quorum_id', '=', $authUser->quorum_id)->orderBy('last_name', 'asc')->get();
		$data['numOfFamilies'] = count($data['families']);
		$data['districtList'] = WardDistricts::where('ward_id', '=', $authUser->ward_id)->where('quorum_id', '=', $authUser->quorum_id)->get();
		$data['districtMembers'] = [];
		foreach ($data['districtList'] as $key => $district) {
			$data['districtMembers'][$key] = WardMember::find($district->member_id);
		}

		$data['existingHomeTeachers'] = WardCompanions::where('ward_id', '=', $authUser->ward_id)->where('quorum_id', '=', $authUser->quorum_id)->get();
		$data['existingHomeTeacherCompanion'] = [];
		foreach ($data['existingHomeTeachers'] as $key => $homeTeachers) {
			$data['existingHomeTeacherCompanion'][$key]['homeTeacher'][1] =  WardMember::find($homeTeachers->ht_one_id);
			$data['existingHomeTeacherCompanion'][$key]['homeTeacher'][2] = WardMember::find($homeTeachers->ht_two_id);
			$families =  WardCompanionshipMembers::where('companionship_id', '=', $homeTeachers->id)->get();
			foreach ($families as $family) {
				$data['existingHomeTeacherCompanion'][$key]['families'][] = WardMember::find($family->member_id);
			}
			$district = WardDistricts::find($homeTeachers->district_id);
			if ($district) {
				$data['existingHomeTeacherCompanion'][$key]['districtMember'] = WardMember::find($district->member_id);
			}
		}

		$checkForUnassignedMembers = WardMember::where('ward_id', '=', $authUser->ward_id)->where('quorum_id', '=', $authUser->quorum_id)->where('is_jr_comp', '=', false)->get();
		$data['unassignedFamilies'] = [];
		foreach ($checkForUnassignedMembers as $unassigned) {
			$companionshipFamily = WardCompanionshipMembers::where('member_id', '=', $unassigned->id)->get();

			// If family doesn't exist in the comps relationship table
			if ($companionshipFamily->isEmpty()) {
				$data['unassignedFamilies'][] = WardMember::find($unassigned->id);
			}
		}

		$data['unassignedHomeTeachers'] = [];
		foreach ($data['families'] as $family) {
			$companionshipFamily = WardCompanions::where('ht_one_id', '=', $family->id)->orWhere('ht_two_id', '=', $family->id)->first();
			if (empty($companionshipFamily) || empty($companionshipFamily->id)) {
				$data['unassignedHomeTeachers'][] = WardMember::find($family->id);
			}
		}

		return view('companionships', $data);
	}
}