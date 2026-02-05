<template>
	<div>
		<div class="mb-8">
			<h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
			<p class="text-gray-600">Welcome back, {{ userName }}!</p>
		</div>

		<div v-if="loading" class="flex justify-center py-12">
			<svg class="animate-spin h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
				<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
				<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
			</svg>
		</div>

		<template v-else>
			<div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
				<div class="bg-white rounded-lg shadow p-6">
					<div class="text-3xl font-bold text-gray-900">{{ stats.total }}</div>
					<div class="text-sm text-gray-600">Total Tasks</div>
				</div>
				<div class="bg-white rounded-lg shadow p-6">
					<div class="text-3xl font-bold text-yellow-600">{{ stats.pending }}</div>
					<div class="text-sm text-gray-600">Pending</div>
				</div>
				<div class="bg-white rounded-lg shadow p-6">
					<div class="text-3xl font-bold text-blue-600">{{ stats.in_progress }}</div>
					<div class="text-sm text-gray-600">In Progress</div>
				</div>
				<div class="bg-white rounded-lg shadow p-6">
					<div class="text-3xl font-bold text-green-600">{{ stats.completed }}</div>
					<div class="text-sm text-gray-600">Completed</div>
				</div>
				<div class="bg-white rounded-lg shadow p-6">
					<div class="text-3xl font-bold text-red-600">{{ stats.overdue }}</div>
					<div class="text-sm text-gray-600">Overdue</div>
				</div>
			</div>

			<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
				<div class="bg-white rounded-lg shadow">
					<div class="px-6 py-4 border-b border-gray-200">
						<h2 class="text-lg font-semibold text-gray-900">Upcoming Tasks</h2>
					</div>
					<div class="p-6">
						<template v-if="upcomingTasks.length">
							<div
								v-for="(task, index) in upcomingTasks"
								:key="task.id"
								class="flex items-center justify-between py-3"
								:class="{ 'border-b border-gray-100': index !== upcomingTasks.length - 1 }"
							>
								<div>
									<a :href="`/tasks/${task.id}`" class="text-gray-900 hover:text-indigo-600">
										{{ task.title }}
									</a>
									<span
										v-if="task.category"
										class="category-badge-sm ml-2"
										:style="{ '--category-color': task.category.color }"
									>
										{{ task.category.name }}
									</span>
								</div>
								<div class="text-sm text-gray-500">
									{{ formatDate(task.deadline) }}
								</div>
							</div>
						</template>
						<p v-else class="text-gray-500 text-center py-4">No upcoming tasks</p>
					</div>
				</div>

				<div class="bg-white rounded-lg shadow">
					<div class="px-6 py-4 border-b border-gray-200">
						<h2 class="text-lg font-semibold text-gray-900">Recent Tasks</h2>
					</div>
					<div class="p-6">
						<template v-if="recentTasks.length">
							<div
								v-for="(task, index) in recentTasks"
								:key="task.id"
								class="flex items-center justify-between py-3"
								:class="{ 'border-b border-gray-100': index !== recentTasks.length - 1 }"
							>
								<div>
									<a :href="`/tasks/${task.id}`" class="text-gray-900 hover:text-indigo-600">
										{{ task.title }}
									</a>
									<span
										class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium"
										:class="statusClass(task.status)"
									>
										{{ formatStatus(task.status) }}
									</span>
								</div>
								<div class="text-sm text-gray-500">
									{{ timeAgo(task.created_at) }}
								</div>
							</div>
						</template>
						<p v-else class="text-gray-500 text-center py-4">No tasks yet</p>
					</div>
				</div>
			</div>

			<div class="mt-8">
				<a href="/tasks/create" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
					<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
					</svg>
					Create New Task
				</a>
			</div>
		</template>
	</div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps({
	userName: {
		type: String,
		required: true
	}
});

const loading = ref(true);
const stats = ref({
	total: 0,
	pending: 0,
	in_progress: 0,
	completed: 0,
	overdue: 0
});
const upcomingTasks = ref([]);
const recentTasks = ref([]);

/**
 * @param {string} date
 * @returns {string}
 */
const formatDate = (date) => {
	return new Date(date).toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
};

/**
 * @param {string} status
 * @returns {string}
 */
const formatStatus = (status) => {
	return status.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
};

/**
 * @param {string} status
 * @returns {string}
 */
const statusClass = (status) => {
	const classes = {
		completed: 'bg-green-100 text-green-800',
		in_progress: 'bg-blue-100 text-blue-800',
		pending: 'bg-yellow-100 text-yellow-800'
	};
	return classes[status] || '';
};

/**
 * @param {string} date
 * @returns {string}
 */
const timeAgo = (date) => {
	const seconds = Math.floor((new Date() - new Date(date)) / 1000);
	const intervals = {
		year: 31536000,
		month: 2592000,
		week: 604800,
		day: 86400,
		hour: 3600,
		minute: 60
	};

	for (const [unit, secondsInUnit] of Object.entries(intervals)) {
		const interval = Math.floor(seconds / secondsInUnit);
		if (interval >= 1) {
			return `${interval} ${unit}${interval !== 1 ? 's' : ''} ago`;
		}
	}
	return 'just now';
};

/**
 * @returns {Promise<void>}
 */
const fetchDashboardData = async () => {
	try {
		const response = await axios.get('/api/dashboard');
		stats.value = response.data.stats;
		upcomingTasks.value = response.data.upcomingTasks;
		recentTasks.value = response.data.recentTasks;
	} catch (error) {
		console.error('Failed to fetch dashboard data:', error);
	} finally {
		loading.value = false;
	}
};

onMounted(() => {
	fetchDashboardData();
});
</script>
