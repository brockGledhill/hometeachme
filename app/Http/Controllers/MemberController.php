<?php
namespace app\Http\Controllers;

use App\Http\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class MemberController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function getIndex() {
		$authUser = Auth::user();
		$data['quorumId'] = $authUser->quorum_id;
		$data['wardId'] = $authUser->ward_id;
		$data['families'] = Member::where('ward_id', '=', $authUser->ward_id)->where('quorum_id', '=', $authUser->quorum_id)->orderBy('last_name', 'asc')->get();
		return view('members', $data);
	}

	public function getEdit() {
		$id = Input::get('id');
		if (empty($id)) {
			return Redirect::back()->with('error', 'Invalid Member Requested');
		}
		$Member = Member::find($id);
		if (empty($Member->id)) {
			return Redirect::back()->with('error', 'Invalid Member Requested');
		}
		$data['WardMember'] = $Member;
		return view('members.edit', $data);
	}

	public function postAdd(Request $Request) {
		$Member = new Member();
		$Member->saveMember(Input::get());
		$status = 'Member Added!';
		if ($Request->ajax()) {
			return Response::json(['success' => true, 'status' => $status]);
		}
		return Redirect::back()->with('status', $status);
	}

	public function postUpdate(Request $Request) {
		$Member = Member::find(Input::get('id'));
		$Member->saveMember(Input::get());
		$status = 'Member Updated!';
		if ($Request->ajax()) {
			return Response::json(['success' => true, 'status' => $status]);
		}
		return Redirect::back()->with('status', $status);
	}

	public function postDelete(Request $Request) {
		Member::destroy(Input::get('id'));
		$status = 'Member Removed';
		if ($Request->ajax()) {
			return Response::json(['success' => true, 'status' => $status]);
		}
		return Redirect::back()->with('status', $status);
	}
}