<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ config('app.name', 'Todo List') }} - @yield('title', 'Home')</title>
	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
	<div id="app">
		<nav class="bg-white shadow-sm">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="flex justify-between h-16">
					<div class="flex items-center">
						<a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600">Todo List</a>
						@auth
							<div class="ml-10 flex items-baseline space-x-4">
								<a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-gray-900' }}">Dashboard</a>
								<a href="{{ route('tasks.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('tasks.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-gray-900' }}">Tasks</a>
								<a href="{{ route('categories.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('categories.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-gray-900' }}">Categories</a>
							</div>
						@endauth
					</div>
					<div class="flex items-center">
						@auth
							<span class="text-gray-600 mr-4">{{ auth()->user()->name }}</span>
							<form method="POST" action="{{ route('logout') }}">
								@csrf
								<button type="submit" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900">Logout</button>
							</form>
						@else
							<a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900">Login</a>
							<a href="{{ route('register') }}" class="ml-4 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">Register</a>
						@endauth
					</div>
				</div>
			</div>
		</nav>

		<main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
			@if(session('success'))
				<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
					{{ session('success') }}
				</div>
			@endif

			@if(session('error'))
				<div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
					{{ session('error') }}
				</div>
			@endif

			@yield('content')
		</main>
	</div>
</body>
</html>
