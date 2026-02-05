@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center">
	<div class="max-w-md w-full bg-white rounded-lg shadow-md p-8">
		<h2 class="text-2xl font-bold text-center text-gray-900 mb-8">Sign in to your account</h2>

		<form method="POST" action="{{ route('login') }}">
			@csrf

			<div class="mb-4">
				<label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
				<input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
					class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('email') border-red-500 @enderror">
				@error('email')
					<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
				@enderror
			</div>

			<div class="mb-4">
				<label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
				<input type="password" name="password" id="password" required
					class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('password') border-red-500 @enderror">
				@error('password')
					<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
				@enderror
			</div>

			<div class="mb-6">
				<label class="flex items-center">
					<input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
					<span class="ml-2 text-sm text-gray-600">Remember me</span>
				</label>
			</div>

			<button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
				Sign in
			</button>
		</form>

		<p class="mt-6 text-center text-sm text-gray-600">
			Don't have an account?
			<a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-500">Register</a>
		</p>
	</div>
</div>
@endsection
