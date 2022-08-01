<template>
        <!-- We've used 3xl here, but feel free to try other max-widths based on your needs -->
        <div class="max-w-3xl px-6 pt-4 pb-6 mx-auto md:px-0 dark:text-white" v-for="workout in workouts">
        <!-- Content goes here -->
        <div class="flex items-end justify-between">
            <div>
                <h3 class="text-sm leading-6 text-gray-700 dark:text-gray-400">{{ workout.human_readable_date }}</h3>
                <h2 class="text-lg font-bold leading-6 text-gray-900 dark:text-white">{{ workout.name }}</h2>
            </div>
            <Menu as="div" class="relative ml-3">
                <div>
                <MenuButton class="flex text-sm bg-transparent rounded-full dark:bg-zinc-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                    <span class="sr-only">Workout Options</span>
                    <DotsHorizontalIcon class="w-5 h-5" />
                </MenuButton>
                </div>
                <transition enter-active-class="transition duration-200 ease-out" enter-from-class="transform scale-95 opacity-0" enter-to-class="transform scale-100 opacity-100" leave-active-class="transition duration-75 ease-in" leave-from-class="transform scale-100 opacity-100" leave-to-class="transform scale-95 opacity-0">

                <MenuItems class="absolute right-0 w-48 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                <MenuItem v-slot="{ active }">
                    <Link :class="[active ? 'bg-zinc-100' : '', 'block px-4 py-2 text-sm text-gray-700']" :href="route('workouts.show', workout.id)">
                    Edit
                    </Link>
                </MenuItem>
                <MenuItem v-slot="{ active }">
                    <a @click="beginDelete(workout.id)" :class="[active ? 'bg-zinc-100' : '', 'block px-4 py-2 text-sm text-gray-700']" href="#">
                    Delete
                    </a>
                </MenuItem>
    
                </MenuItems>
                </transition>
            </Menu>
        </div>

        <div class="mt-4 overflow-hidden bg-white divide-y divide-gray-200 rounded-lg shadow dark:bg-neutral-700 dark:divide-zinc-600">
            <div class="">
                <dl class="grid grid-cols-3 overflow-hidden divide-x divide-y-0 divide-gray-200 rounded-lg dark:divide-zinc-600">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-base font-normal text-gray-900 dark:text-white">
                        Exercises
                        </dt>
                        <dd class="flex items-baseline justify-between mt-1 md:block lg:flex">
                        <div class="flex items-baseline text-lg font-semibold text-indigo-600 dark:text-indigo-400 md:text-2xl">
                            {{ workout.logs_count }}
                        </div>
                        </dd>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-base font-normal text-gray-900 dark:text-white">
                        Reps
                        </dt>
                        <dd class="flex items-baseline justify-between mt-1 md:block lg:flex">
                        <div class="flex items-baseline text-lg font-semibold text-indigo-600 dark:text-indigo-400 md:text-2xl">
                            {{ workout.sets_sum_total_reps }}
                        </div>
                        </dd>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-base font-normal text-gray-900 dark:text-white">
                            Volume
                        </dt>
                        <dd class="flex items-baseline justify-between mt-1 md:block lg:flex">
                        <div class="flex items-baseline text-lg font-semibold text-indigo-600 dark:text-indigo-400 md:text-2xl">
                            {{ volume(workout.sets) }} lb
                        </div>
                        </dd>
                    </div>
                    </dl>
            </div>
            <div class="px-4 py-5 sm:p-6">
                    <div class="flow-root">
                        <ul role="list" class="">
                            <li v-for="(log, logIdx) in workout.logs" class="group">
                                <div class="relative pb-8 group-last:pb-0">
                                <span v-if="logIdx !== workout.logs.length - 1" class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-zinc-600" aria-hidden="true" />
                                <div class="relative flex items-center">
                                    <div>
                                    <span class="flex items-center justify-center w-8 h-8 bg-white border-2 border-gray-200 rounded-full dark:bg-neutral-700 dark:border-zinc-500 ring-white ring-4 dark:ring-neutral-700">
                                        {{ log.order }}
                                    </span>
                                    </div>
                                    <div class="flex flex-col items-start justify-between flex-1 min-w-0 ml-4 md:flex-row md:items-center">
                                        <div>
                                            <p class="font-medium text-black dark:text-white">
                                                {{ log.exercise.name }}
                                            </p>
                                        </div>
                                        <div class="flex space-x-2 text-sm text-gray-600 divide-x divide-gray-600 dark:text-gray-400 md:text-right">
                                            <div class=""><span class="text-gray-900 dark:text-white">{{ volume(log.sets) }}</span><span> lb </span></div>
                                            <div class="pl-2"><span class="text-gray-900 dark:text-white">{{ reps(log.sets) }}</span><span> reps</span></div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </li>
                        </ul>
                    </div>
            </div>
        </div>
    
    
        <!--
            <h2 class="text-lg font-bold">{{ workout.name }}</h2>
            <h2 class="text-lg font-bold">{{ workout.logs_count }}</h2>
            <ul class="text-base">
                <li v-for="log in workout.logs">
                    {{ log.exercise.name }}
                </li>
            </ul>
        -->
    </div>
    <delete-alert :open="showDeleting"
        message="Are you sure you want to delete this workout and its associated sets?  This can't be undone."
        title="Delete Workout" @delete="handleDelete" @cancel="handleCancelDelete" />
</template>

<script setup>

import { ArrowSmDownIcon, ArrowSmUpIcon } from '@heroicons/vue/solid'
import { DotsHorizontalIcon } from '@heroicons/vue/outline';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { Link } from '@inertiajs/inertia-vue3';
import DeleteAlert from '@/Components/Modal/DeleteAlert'
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';


const stats = [
  { name: 'Total Subscribers', stat: '71,897', previousStat: '70,946', change: '12%', changeType: 'increase' },
  { name: 'Avg. Open Rate', stat: '58.16%', previousStat: '56.14%', change: '2.02%', changeType: 'increase' },
  { name: 'Avg. Click Rate', stat: '24.57%', previousStat: '28.62%', change: '4.05%', changeType: 'decrease' },
]

defineProps({
    workouts: Array
})

const showDeleting = ref(false)
const modelDeleting = ref('')

const beginDelete = id => {
    showDeleting.value = true,
    modelDeleting.value = id
}

const handleDelete = () => {
        Inertia.delete(route('workouts.destroy', modelDeleting.value))
        showDeleting.value = false
        modelDeleting.value = ''
}

const handleCancelDelete = () => {
    showDeleting.value = false
    modelDeleting.value = ''
}

const volume = (sets) => {
    var totalVolume = 0
    sets.forEach(set => {
        totalVolume += (set.weight * set.total_reps)
    });
    return totalVolume.toLocaleString(undefined)
}

const reps = (sets) => {
    var totalReps = 0
    sets.forEach(set => {
        totalReps += set.total_reps
    })
    return totalReps.toLocaleString(undefined)
}
</script>