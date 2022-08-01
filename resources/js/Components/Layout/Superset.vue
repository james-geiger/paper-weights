<template>
	<div class="relative pb-8">
		<!---->
		<div class="relative flex items-center ml-2">
			<div>
				<span class="flex items-center justify-center w-8 h-8 bg-white rounded-full dark:bg-neutral-700 ring-white ring-4 dark:ring-neutral-700">
					<RefreshIcon class="w-5 h-5"></RefreshIcon>
				</span>
			</div>
		<div class="flex flex-col items-start justify-between flex-1 min-w-0 py-4 md:flex-row md:items-center">
			<div>
				<p class="font-medium text-black dark:text-white">
					Superset
				</p>
			</div>
			
		</div>
		</div>
		<span class="absolute left-6 h-full w-0.5 bg-gray-200 dark:bg-zinc-600" aria-hidden="true" />
	</div>
</template>

<script setup>
import { RefreshIcon } from '@heroicons/vue/outline';
</script>