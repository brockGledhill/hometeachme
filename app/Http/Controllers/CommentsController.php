<?php
namespace App\Http\Controllers;

use App\Http\Models\Comment;
use App\Http\Models\Companionship;
use App\Http\Models\Member;
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
		$data['comments'] = Comment::with('companionship')
			->with('family')
			->with('companionship.htOne')
			->with('companionship.htTwo')
			->where('visit_month', '=', $monthAbbr)
			->where('visit_year', '=', $year)
			->get();

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
		$WardComment = Comment::create(array_merge(Input::all(), ['visit_year' => date('Y')]));
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