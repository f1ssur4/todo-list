@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="flex justify-between items-center mb-6">
	<h1 class="text-2xl font-bold text-gray-900">Categories</h1>
	<a href="{{ route('categories.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
		<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
			<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
		</svg>
		New Category
	</a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
	@forelse($categories as $category)
		<div class="bg-white rounded-lg shadow p-6">
			<div class="flex items-center justify-between mb-4">
				<div class="flex items-center">
					<div class="category-dot" style="--category-color: {{ $category->color }}"></div>
					<h2 class="text-lg font-semibold text-gray-900">{{ $category->name }}</h2>
				</div>
				<span class="text-sm text-gray-500">{{ $category->tasks_count }} tasks</span>
			</div>
			<div class="flex justify-end space-x-3">
				<a href="{{ route('tasks.index', ['category_id' => $category->id]) }}" class="text-sm text-gray-600 hover:text-gray-900">View Tasks</a>
				<a href="{{ route('categories.edit', $category) }}" class="text-sm text-indigo-600 hover:text-indigo-900">Edit</a>
				<form method="POST" action="{{ route('categories.destroy', $category) }}" class="inline" onsubmit="return confirm('Are you sure? Tasks in this category will not be deleted.')">
					@csrf
					@method('DELETE')
					<button type="submit" class="text-sm text-red-600 hover:text-red-900">Delete</button>
				</form>
			</div>
		</div>
	@empty
		<div class="col-span-full bg-white rounded-lg shadow p-12 text-center">
			<svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
			</svg>
			<h3 class="mt-2 text-sm font-medium text-gray-900">No categories</h3>
			<p class="mt-1 text-sm text-gray-500">Get started by creating a new category.</p>
			<div class="mt-6">
				<a href="{{ route('categories.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
					<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
					</svg>
					New Category
				</a>
			</div>
		</div>
	@endforelse
</div>
@endsection
