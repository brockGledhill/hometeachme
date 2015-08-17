<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class LoginController extends Controller {
	public function getIndex() {
		$data = [];
		$data['title'] = 'Login';
		return view('login', $data);
	}

	public function postIndex() {
		
	}
}