<?php
namespace App\Http\Controllers;

use App\Http\Models\Comment;
use App\WardCompanions;
use App\Http\Models\WardMember;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class CommentsController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Get the index page for viewing comments
	 *
	 * @param Request $Request The requets
	 *
	 * @return \Illuminate\View\View
	 */
	public function getIndex(Request $Request) {
		$data = [];
		$authUser = Auth::user();
		$year = $curYear = (int)date('Y');
		$monthAbbr = date('M');
		$month = date('F');
		$data['months'] = $this->getMonths();
		$data['monthsAbbr'] = $this->getMonthsAbbreviated();
		$requestData = Input::all();
		if (!empty($requestData['year'])) {
			$year = (int)$requestData['year'];
		}
		if (!empty($requestData['month'])) {
			$month = $data['months'][$requestData['month']];
			$monthAbbr = $data['monthsAbbr'][$requestData['month']];
		}
		$data['comments'] = Comment::where('ward_id', '=', $authUser->ward_id)
										->where('visit_month', '=', $monthAbbr)
										->where('visit_year', '=', $year)
										->get();
		foreach ($data['comments'] as $key => $comment) {
			$data['families'][$key] = WardMember::where('id', '=', $comment->family_id)->first();
			$companions = WardCompanions::where('id', '=', $comment->companion_id)->first();
			if ($companions) {
				$data['homeTeachers'][$key][1] = WardMember::where('id', '=', $companions->ht_one_id)->first();
				$data['homeTeachers'][$key][2] = WardMember::where('id', '=', $companions->ht_two_id)->first();
			}
		}
		$data['firstYear'] = 2015;
		$data['nowYear'] = $curYear;
		$data['selectedYear'] = $year;
		$data['selectedMonth'] = $month;
		if ($Request->ajax()) {
			return view('includes.comments.view_comments', $data);
		}
		return view('comments', $data);
	}

	public function postAdd(Request $Request) {
		$WardComment = Comment::create(array_merge(Input::all(), ['visit_year' => date('Y'), 'ward_id' => Auth::user()->ward_id]));
		$returnData = [
			'success' => true,
			'message' => 'Comment Recorded!',
			'status' => parent::MESSAGE_SUCCESS,
			'id' => $WardComment->id
		];
		if ($Request->ajax()) {
			return Response::json($returnData);
		}
		return Redirect::back()->with($returnData);
	}

	public function postDelete(Request $Request) {
		$count = Comment::destroy(Input::get('id'));
		if ($count > 0) {
			$success = true;
			$message = 'Comment Deleted';
			$status = parent::MESSAGE_SUCCESS;
		} else {
			$success = false;
			$message = 'There was a problem removing the comment...';
			$status = parent::MESSAGE_ERROR;
		}
		$returnData = [
			'success' => $success,
			'message' => $message,
			'status' => $status
		];
		if ($Request->ajax()) {
			return Response::json($returnData);
		}
		return Redirect::back()->with($returnData);
	}
}