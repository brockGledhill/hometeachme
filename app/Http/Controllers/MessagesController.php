<?php
namespace App\Http\Controllers;

class MessagesController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function getIndex() {
		return view('messages');
	}
}