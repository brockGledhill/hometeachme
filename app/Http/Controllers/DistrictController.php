<?php
namespace app\Http\Controllers;

use App\WardDistricts;
use App\WardMember;
use Illuminate\Support\Facades\Auth;

class DistrictController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function getIndex() {
		$authUser = Auth::user();
		$data['quorumId'] = $authUser->quorum_id;
		$data['wardId'] = $authUser->ward_id;
		$data['families'] = WardMember::where('ward_id', '=', $authUser->ward_id)->where('quorum_id', '=', $authUser->quorum_id)->orderBy('last_name', 'asc')->get();
		$districts = WardDistricts::where('ward_id', '=', $authUser->ward_id)->where('quorum_id', '=', $authUser->quorum_id)->get();
		$data['districts'] = [];
		foreach ($districts as $district) {
			$data['districts'][] = WardMember::find($district->member_id);
		}
		return view('districts', $data);
	}
}