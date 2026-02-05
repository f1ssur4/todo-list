@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
<div class="max-w-2xl mx-auto">
	<div class="flex items-center justify-between mb-6">
		<h1 class="text-2xl font-bold text-gray-900">Edit Task</h1>
		<a href="{{ route('tasks.index') }}" class="text-gray-600 hover:text-gray-900">Back to Tasks</a>
	</div>

	<div class="bg-white rounded-lg shadow p-6">
		<form id="update-form" method="POST" action="{{ route('tasks.update', $task) }}">
			@csrf
			@method('PUT')

			<div class="mb-4">
				<label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
				<input type="text" name="title" id="title" value="{{ old('title', $task->title) }}" required
					class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('title') border-red-500 @enderror">
				@error('title')
					<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
				@enderror
			</div>

			<div class="mb-4">
				<label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
				<textarea name="description" id="description" rows="4"
					class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('description') border-red-500 @enderror">{{ old('description', $task->description) }}</textarea>
				@error('description')
					<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
				@enderror
			</div>

			<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
				<div>
					<label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
					<select name="category_id" id="category_id"
						class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
						<option value="">No Category</option>
						@foreach($categories as $category)
							<option value="{{ $category->id }}" {{ old('category_id', $task->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
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
						<option value="low" {{ old('priority', $task->priority) === 'low' ? 'selected' : '' }}>Low</option>
						<option value="medium" {{ old('priority', $task->priority) === 'medium' ? 'selected' : '' }}>Medium</option>
						<option value="high" {{ old('priority', $task->priority) === 'high' ? 'selected' : '' }}>High</option>
					</select>
					@error('priority')
						<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
					@enderror
				</div>

				<div>
					<label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
					<select name="status" id="status" required
						class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
						<option value="pending" {{ old('status', $task->status) === 'pending' ? 'selected' : '' }}>Pending</option>
						<option value="in_progress" {{ old('status', $task->status) === 'in_progress' ? 'selected' : '' }}>In Progress</option>
						<option value="completed" {{ old('status', $task->status) === 'completed' ? 'selected' : '' }}>Completed</option>
					</select>
					@error('status')
						<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
					@enderror
				</div>
			</div>

			<div class="mb-6">
				<label for="deadline" class="block text-sm font-medium text-gray-700 mb-1">Deadline</label>
				<input type="date" name="deadline" id="deadline" value="{{ old('deadline', $task->deadline?->format('Y-m-d')) }}"
					class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('deadline') border-red-500 @enderror">
				@error('deadline')
					<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
				@enderror
			</div>

		</form>

		<div class="flex justify-between items-center mt-6 pt-6 border-t border-gray-200">
			<form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Are you sure you want to delete this task?')">
				@csrf
				@method('DELETE')
				<button type="submit" class="px-4 py-2 text-red-600 hover:text-red-800">Delete Task</button>
			</form>

			<button type="submit" form="update-form" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
				Update Task
			</button>
		</div>
	</div>
</div>
@endsection
