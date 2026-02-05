@extends('layouts.app')

@section('title', 'Create Task')

@section('content')
<div class="max-w-2xl mx-auto">
	<div class="flex items-center justify-between mb-6">
		<h1 class="text-2xl font-bold text-gray-900">Create Task</h1>
		<a href="{{ route('tasks.index') }}" class="text-gray-600 hover:text-gray-900">Back to Tasks</a>
	</div>

	<div class="bg-white rounded-lg shadow p-6">
		<form method="POST" action="{{ route('tasks.store') }}">
			@csrf

			<div class="mb-4">
				<label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
				<input type="text" name="title" id="title" value="{{ old('title') }}" required
					class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('title') border-red-500 @enderror">
				@error('title')
					<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
				@enderror
			</div>

			<div class="mb-4">
				<label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
				<textarea name="description" id="description" rows="4"
					class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
				@error('description')
					<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
				@enderror
			</div>

			<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
				<div>
					<label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
					<select name="category_id" id="category_id"
						class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
						<option value="">No Category</option>
						@foreach($categories as $category)
							<option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
						@endforeach
					</select>
					@error('category_id')
						<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
					@enderror
				</div>

				<div>
					<label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
					<select name="priority" id="priority" required
						class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
						<option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low</option>
						<option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>Medium</option>
						<option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High</option>
					</select>
					@error('priority')
						<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
					@enderror
				</div>
			</div>

			<div class="mb-6">
				<label for="deadline" class="block text-sm font-medium text-gray-700 mb-1">Deadline</label>
				<input type="date" name="deadline" id="deadline" value="{{ old('deadline') }}"
					class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('deadline') border-red-500 @enderror">
				@error('deadline')
					<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
				@enderror
			</div>

			<div class="flex justify-end">
				<button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
					Create Task
				</button>
			</div>
		</form>
	</div>
</div>
@endsection
