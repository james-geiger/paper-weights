<template>
    <app-layout title="Workouts">
        <template #header>
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                        <h1 class="text-xl leading-6 font-semibold text-gray-900">Workouts</h1>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                    <Link as="button" :href="route('workouts.store')" method="post" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">New Workout</Link>
                </div>
            </div>
        </template>
            <div>
                <workout-table :workouts="workouts" />
            </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3'
    import AppLayout from '@/Layouts/SingleColumnLayout.vue'
    import WorkoutTable from '@/Components/Workout/ListTable.vue'

    export default defineComponent({
        components: {
            AppLayout,
            WorkoutTable,
            Link
        },
        props: ['workouts']
    })
</script>
