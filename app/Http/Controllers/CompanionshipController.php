<?php
namespace app\Http\Controllers;

use App\WardCompanions;
use App\WardCompanionshipMembers;
use App\WardDistricts;
use App\WardMember;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

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
		$data['existingHomeTeacherCompanion'] = $this->getExistingHomeTeacherCompanionData($data['existingHomeTeachers']);

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

	public function getEdit() {
		$id = Input::get('id');
		if (empty($id)) {
			return Redirect::back()->with('status', 'Invalid member.');
		}
		$data['WardMember'] = WardMember::find($id);
		if (empty($data['WardMember']) || empty($data['WardMember']->id)) {
			return Redirect::to('/members');
		}

		$authUser = Auth::user();
		$data['quorumId'] = $authUser->quorum_id;
		$data['wardId'] = $authUser->ward_id;

		$data['searchResult'] = Input::get('name');
		$data['existingHomeTeachers'] = WardCompanions::where('ward_id' ,'=', $authUser->ward_id)
			->where('quorum_id' ,'=', $authUser->quorum_id)
			->where(function($query) use ($id) {
				$query->where('ht_one_id', '=', $id)->orWhere('ht_two_id', '=', $id);
			})
			->get();

		$data['existingHomeTeacherCompanion'] = $this->getExistingHomeTeacherCompanionData($data['existingHomeTeachers']);
		$data['families'] = WardMember::where('ward_id', '=', $authUser->ward_id)->where('quorum_id', '=', $authUser->quorum_id)->orderBy('last_name', 'asc')->get();
		$data['districtList'] = WardDistricts::where('ward_id', '=', $authUser->ward_id)->where('quorum_id', '=', $authUser->quorum_id)->get();
		$data['districtMembers'] = [];
		foreach ($data['districtList'] as $key => $district) {
			$data['districtMembers'][$key] = WardMember::find($district->member_id);
		}

		return view('companionships.edit', $data);
	}

	public function postAdd(Request $Request) {
		$WardCompanions = WardCompanions::create(Input::except('member_id'));
		foreach (Input::get('member_id') as $memberId) {
			$WardCompanionshipMembers = new WardCompanionshipMembers();
			$WardCompanionshipMembers->member_id = $memberId;
			$WardCompanionshipMembers->companionship_id = $WardCompanions->id;
			$WardCompanionshipMembers->save();
		}
		$status = 'Companionship Added With Families!';
		if ($Request->ajax()) {
			return Response::json(['success' => true, 'status' => $status]);
		}
		return Redirect::back()->with('status', $status);
	}

	public function postUpdate(Request $Request) {
		if ($Request->isMethod('post')) {
			$WardCompanions = WardCompanions::find(Input::get('id'));
			$htOneId = Input::get('ht_one_id');
			if (null !== $htOneId) {
				$WardCompanions->ht_one_id = $htOneId;
			} else {
				$WardCompanions->ht_two_id = Input::get('ht_two_id');
			}
			$WardCompanions->update();
		}
		return Redirect::back()->with('status', 'Companion Removed.');
	}

	public function postDelete(Request $Request) {
		if ($Request->isMethod('post')) {
			$id = Input::get('id');
			WardCompanions::destroy($id);
			WardCompanionshipMembers::where('companionship_id', '=', $id)->first()->delete();
		}
		$status = 'Companionship Removed.';
		if ($Request->ajax()) {
			return Response::json(['success' => true, 'status' => $status]);
		}
		return Redirect::back()->with('status', $status);
	}

	private function getExistingHomeTeacherCompanionData($existingHomeTeachers) {
		$existingHomeTeacherCompanion = [];
		foreach ($existingHomeTeachers as $key => $homeTeachers) {
			$existingHomeTeacherCompanion[$key]['homeTeacher'][1] =  WardMember::find($homeTeachers->ht_one_id);
			$existingHomeTeacherCompanion[$key]['homeTeacher'][2] = WardMember::find($homeTeachers->ht_two_id);
			$families =  WardCompanionshipMembers::where('companionship_id', '=', $homeTeachers->id)->get();
			foreach ($families as $family) {
				$taughtFamily = &$existingHomeTeacherCompanion[$key]['families'][];
				$taughtFamily = WardMember::find($family->member_id);
				$taughtFamily['ward_companionship_member_id'] = $family->id;
			}
			$district = WardDistricts::find($homeTeachers->district_id);
			if ($district) {
				$existingHomeTeacherCompanion[$key]['districtMember'] = WardMember::find($district->member_id);
			}
		}
		return $existingHomeTeacherCompanion;
	}
}