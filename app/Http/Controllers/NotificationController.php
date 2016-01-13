<?php
namespace App\Http\Controllers;

class NotificationController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function getIndex() {
		return view('notifications');
	}
}