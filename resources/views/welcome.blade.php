@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center">
	<div class="text-center">
		<h1 class="text-4xl font-bold text-gray-900 mb-4">Todo List</h1>
		<p class="text-xl text-gray-600 mb-8">Organize your tasks, boost your productivity</p>

		@guest
			<div class="space-x-4">
				<a href="{{ route('login') }}" class="px-6 py-3 text-indigo-600 border border-indigo-600 rounded-md hover:bg-indigo-50">Sign In</a>
				<a href="{{ route('register') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Get Started</a>
			</div>
		@else
			<a href="{{ route('dashboard') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Go to Dashboard</a>
		@endguest

		<div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto text-left">
			<div class="bg-white rounded-lg shadow p-6">
				<div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
					<svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
					</svg>
				</div>
				<h3 class="text-lg font-semibold text-gray-900 mb-2">Organize Tasks</h3>
				<p class="text-gray-600">Create, categorize, and prioritize your tasks with ease.</p>
			</div>

			<div class="bg-white rounded-lg shadow p-6">
				<div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
					<svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
					</svg>
				</div>
				<h3 class="text-lg font-semibold text-gray-900 mb-2">Categories</h3>
				<p class="text-gray-600">Group your tasks by custom categories with colors.</p>
			</div>

			<div class="bg-white rounded-lg shadow p-6">
				<div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
					<svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
					</svg>
				</div>
				<h3 class="text-lg font-semibold text-gray-900 mb-2">Deadlines</h3>
				<p class="text-gray-600">Set deadlines and never miss an important task.</p>
			</div>
		</div>
	</div>
</div>
@endsection
