<?php
namespace App\Http\Controllers;

class NotificationsController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function getIndex() {
		return view('notifications');
	}
}