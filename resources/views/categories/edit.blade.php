@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="max-w-md mx-auto">
	<div class="flex items-center justify-between mb-6">
		<h1 class="text-2xl font-bold text-gray-900">Edit Category</h1>
		<a href="{{ route('categories.index') }}" class="text-gray-600 hover:text-gray-900">Back to Categories</a>
	</div>

	<div class="bg-white rounded-lg shadow p-6">
		<form id="update-form" method="POST" action="{{ route('categories.update', $category) }}">
			@csrf
			@method('PUT')

			<div class="mb-4">
				<label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
				<input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
					class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('name') border-red-500 @enderror">
				@error('name')
					<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
				@enderror
			</div>

			<div class="mb-6">
				<label for="color" class="block text-sm font-medium text-gray-700 mb-1">Color</label>
				<div class="flex items-center">
					<input type="color" name="color" id="color" value="{{ old('color', $category->color) }}"
						class="h-10 w-20 border border-gray-300 rounded-md cursor-pointer">
					<span class="ml-3 text-sm text-gray-500">Choose a color for this category</span>
				</div>
				@error('color')
					<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
				@enderror
			</div>
		</form>

		<div class="flex justify-between items-center mt-6 pt-6 border-t border-gray-200">
			<form method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('Are you sure? Tasks in this category will not be deleted.')">
				@csrf
				@method('DELETE')
				<button type="submit" class="px-4 py-2 text-red-600 hover:text-red-800">Delete Category</button>
			</form>

			<button type="submit" form="update-form" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
				Update Category
			</button>
		</div>
	</div>
</div>
@endsection
