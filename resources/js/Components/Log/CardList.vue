<template>
    <div class="p-6 mb-4 overflow-hidden bg-white divide-y divide-gray-200 rounded-lg shadow dark:bg-neutral-700 dark:divide-zinc-600 dark:text-white">
       <div class="flow-root">
                <ul role="list" class="">
                    
                    <li v-for="(log, logIdx) in logs" class="group">
                        <superset v-if="logIdx == 3"/>
                        <div class="relative pb-8">
                        <div class="relative flex items-center">
                            <div class="flex-1 min-w-0 py-4 ml-4 bg-white md:items-center dark:bg-neutral-700">
                                <div>
                                    <p class="font-medium text-black dark:text-white">
                                        {{ log.exercise.name }}
                                    </p>
                                </div>
                                <div class="flex space-x-2 text-sm text-gray-600 divide-x divide-gray-600 dark:text-gray-400 md:text-right">
                                    <div class=""><span class="text-gray-900 dark:text-white">{{ log.sets.length }}</span><span> sets </span></div>
                                    <!--<div class="pl-2"><span class="text-gray-900 dark:text-white">{{ log.sets. }}</span><span> reps</span></div>-->
                                </div>
                            </div>
                        </div>
                        <span class="absolute left-6 h-1/2 w-0.5 bg-gray-200 dark:bg-zinc-600" aria-hidden="true" />
                        </div>
                    </li>
                </ul>
		<div class="relative flex items-center py-4 ml-2 bg-white dark:bg-neutral-700">
			<div>
				<div class="relative flex justify-center">
      <button type="button" @click="openExercisePalette(workout.id, logs.length + 1)" class="inline-flex items-center shadow-sm px-4 py-1.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <PlusSmIcon class="-ml-1.5 mr-1 h-5 w-5 text-gray-400" aria-hidden="true" />
        <span>Add Exercise</span>
      </button>
    </div>
			</div>
		</div>
		

            </div>

                
    </div>
</template>


<script setup>
import superset from '@/Components/Layout/Superset'
import { PlusSmIcon } from '@heroicons/vue/solid'
import { exercisePaletteStore } from '@/Stores/ExercisePalette'

const props = defineProps({
    logs: Array,
    workout: Object
})

const store = exercisePaletteStore()
const { openExercisePalette } = store
</script>