@extends('layouts.app')

@section('title', 'Tasks')

@section('content')
<div class="flex justify-between items-center mb-6">
	<h1 class="text-2xl font-bold text-gray-900">Tasks</h1>
	<a href="{{ route('tasks.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
		<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
			<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
		</svg>
		New Task
	</a>
</div>

<div class="bg-white rounded-lg shadow mb-6">
	<div class="p-4 border-b border-gray-200">
		<form method="GET" action="{{ route('tasks.index') }}" class="flex flex-wrap gap-4">
			<div class="flex-1 min-w-[200px]">
				<input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search tasks..."
					class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
			</div>
			<select name="status" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
				<option value="">All Status</option>
				<option value="pending" {{ ($filters['status'] ?? '') === 'pending' ? 'selected' : '' }}>Pending</option>
				<option value="in_progress" {{ ($filters['status'] ?? '') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
				<option value="completed" {{ ($filters['status'] ?? '') === 'completed' ? 'selected' : '' }}>Completed</option>
			</select>
			<select name="priority" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
				<option value="">All Priority</option>
				<option value="low" {{ ($filters['priority'] ?? '') === 'low' ? 'selected' : '' }}>Low</option>
				<option value="medium" {{ ($filters['priority'] ?? '') === 'medium' ? 'selected' : '' }}>Medium</option>
				<option value="high" {{ ($filters['priority'] ?? '') === 'high' ? 'selected' : '' }}>High</option>
			</select>
			<select name="category_id" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
				<option value="">All Categories</option>
				@foreach($categories as $category)
					<option value="{{ $category->id }}" {{ ($filters['category_id'] ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
				@endforeach
			</select>
			<button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">Filter</button>
			<a href="{{ route('tasks.index') }}" class="px-4 py-2 text-gray-600 hover:text-gray-900">Clear</a>
		</form>
	</div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
	<table class="min-w-full divide-y divide-gray-200">
		<thead class="bg-gray-50">
			<tr>
				<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Task</th>
				<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
				<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
				<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
				<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deadline</th>
				<th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
			</tr>
		</thead>
		<tbody class="bg-white divide-y divide-gray-200">
			@forelse($tasks as $task)
				<tr class="{{ $task->deadline && $task->deadline->isPast() && $task->status !== 'completed' ? 'bg-red-50' : '' }}">
					<td class="px-6 py-4">
						<a href="{{ route('tasks.show', $task) }}" class="text-gray-900 hover:text-indigo-600 font-medium">{{ $task->title }}</a>
						@if($task->description)
							<p class="text-sm text-gray-500 truncate max-w-xs">{{ Str::limit($task->description, 50) }}</p>
						@endif
					</td>
					<td class="px-6 py-4">
						@if($task->category)
							<span class="category-badge" style="--category-color: {{ $task->category->color }}">
								{{ $task->category->name }}
							</span>
						@else
							<span class="text-gray-400">-</span>
						@endif
					</td>
					<td class="px-6 py-4">
						<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
							{{ $task->priority === 'high' ? 'bg-red-100 text-red-800' : '' }}
							{{ $task->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : '' }}
							{{ $task->priority === 'low' ? 'bg-green-100 text-green-800' : '' }}">
							{{ ucfirst($task->priority) }}
						</span>
					</td>
					<td class="px-6 py-4">
						<form method="POST" action="{{ route('tasks.toggle-status', $task) }}" class="inline">
							@csrf
							@method('PATCH')
							<button type="submit" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium cursor-pointer hover:opacity-80
								{{ $task->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
								{{ $task->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : '' }}
								{{ $task->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}">
								{{ ucfirst(str_replace('_', ' ', $task->status)) }}
							</button>
						</form>
					</td>
					<td class="px-6 py-4 text-sm text-gray-500">
						@if($task->deadline)
							<span class="{{ $task->deadline->isPast() && $task->status !== 'completed' ? 'text-red-600 font-medium' : '' }}">
								{{ $task->deadline->format('M d, Y') }}
							</span>
						@else
							<span class="text-gray-400">-</span>
						@endif
					</td>
					<td class="px-6 py-4 text-right text-sm font-medium">
						<a href="{{ route('tasks.edit', $task) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
						<form method="POST" action="{{ route('tasks.destroy', $task) }}" class="inline" onsubmit="return confirm('Are you sure?')">
							@csrf
							@method('DELETE')
							<button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
						</form>
					</td>
				</tr>
			@empty
				<tr>
					<td colspan="6" class="px-6 py-12 text-center text-gray-500">
						No tasks found.
						<a href="{{ route('tasks.create') }}" class="text-indigo-600 hover:text-indigo-500">Create your first task</a>
					</td>
				</tr>
			@endforelse
		</tbody>
	</table>
</div>

<div class="mt-4">
	{{ $tasks->links() }}
</div>
@endsection
