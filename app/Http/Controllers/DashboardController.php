<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class DashboardController
 */
class DashboardController extends Controller
{
	/**
	 * @param Request $request
	 * @return View
	 */
	public function __invoke(Request $request): View
	{
		return view('dashboard');
	}
}
