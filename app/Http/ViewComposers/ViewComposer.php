<?php
namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ViewComposer {
	public function compose(View $view) {
		$authUser = Auth::user();
		if ($authUser) {
			$view->with('adminStatus', $authUser->isAdmin());
		}
	}
}