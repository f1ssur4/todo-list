<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * Class LoginController
 */
class LoginController extends Controller
{
	/**
	 * @return View
	 */
	public function create(): View
	{
		return view('auth.login');
	}

	/**
	 * @param LoginRequest $request
	 * @return RedirectResponse
	 * @throws ValidationException
	 */
	public function store(LoginRequest $request): RedirectResponse
	{
		$request->authenticate();

		$request->session()->regenerate();

		return redirect()->intended(route('dashboard'));
	}
}
