<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Class RegisterController
 */
class RegisterController extends Controller
{
	/**
	 * @return View
	 */
	public function create(): View
	{
		return view('auth.register');
	}

	/**
	 * @param RegisterRequest $request
	 * @return RedirectResponse
	 */
	public function store(RegisterRequest $request): RedirectResponse
	{
		$user = User::create($request->validated());

		Auth::login($user);

		return redirect()->route('dashboard');
	}
}
