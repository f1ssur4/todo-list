@extends('layouts.app')

@section('title', $task->title)

@section('content')
<div class="max-w-2xl mx-auto">
	<div class="flex items-center justify-between mb-6">
		<a href="{{ route('tasks.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center">
			<svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
			</svg>
			Back to Tasks
		</a>
		<a href="{{ route('tasks.edit', $task) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Edit Task</a>
	</div>

	<div class="bg-white rounded-lg shadow">
		<div class="p-6 border-b border-gray-200">
			<div class="flex items-start justify-between">
				<h1 class="text-2xl font-bold text-gray-900">{{ $task->title }}</h1>
				<form method="POST" action="{{ route('tasks.toggle-status', $task) }}">
					@csrf
					@method('PATCH')
					<button type="submit" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium cursor-pointer hover:opacity-80
						{{ $task->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
						{{ $task->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : '' }}
						{{ $task->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}">
						{{ ucfirst(str_replace('_', ' ', $task->status)) }}
					</button>
				</form>
			</div>

			<div class="flex items-center mt-4 space-x-4">
				@if($task->category)
					<span class="category-badge" style="--category-color: {{ $task->category->color }}">
						{{ $task->category->name }}
					</span>
				@endif
				<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
					{{ $task->priority === 'high' ? 'bg-red-100 text-red-800' : '' }}
					{{ $task->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : '' }}
					{{ $task->priority === 'low' ? 'bg-green-100 text-green-800' : '' }}">
					{{ ucfirst($task->priority) }} Priority
				</span>
			</div>
		</div>

		<div class="p-6">
			@if($task->description)
				<div class="mb-6">
					<h2 class="text-sm font-medium text-gray-500 mb-2">Description</h2>
					<p class="text-gray-900 whitespace-pre-wrap">{{ $task->description }}</p>
				</div>
			@endif

			<div class="grid grid-cols-2 gap-6">
				<div>
					<h2 class="text-sm font-medium text-gray-500 mb-1">Deadline</h2>
					@if($task->deadline)
						<p class="{{ $task->deadline->isPast() && $task->status !== 'completed' ? 'text-red-600 font-medium' : 'text-gray-900' }}">
							{{ $task->deadline->format('F d, Y') }}
							@if($task->deadline->isPast() && $task->status !== 'completed')
								(Overdue)
							@elseif($task->deadline->isToday())
								(Today)
							@elseif($task->deadline->isTomorrow())
								(Tomorrow)
							@endif
						</p>
					@else
						<p class="text-gray-400">No deadline</p>
					@endif
				</div>

				<div>
					<h2 class="text-sm font-medium text-gray-500 mb-1">Created</h2>
					<p class="text-gray-900">{{ $task->created_at->format('F d, Y') }}</p>
				</div>

				@if($task->completed_at)
					<div>
						<h2 class="text-sm font-medium text-gray-500 mb-1">Completed</h2>
						<p class="text-green-600">{{ $task->completed_at->format('F d, Y') }}</p>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection
