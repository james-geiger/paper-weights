<template>
    <div class="p-6 mb-4 overflow-hidden bg-white divide-y divide-gray-200 rounded-lg shadow dark:bg-neutral-700 dark:divide-zinc-600 dark:text-white">
       <div class="flow-root">
                <ul role="list" class="">
                    
                    <li v-for="(log, logIdx) in logs" class="group">
                        <superset v-if="logIdx == 3"/>
                        <div class="relative pb-8 group-last:pb-0">
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
                        <span v-if="logIdx !== logs.length - 1 && logIdx != 2 " class="absolute left-6 h-full w-0.5 bg-gray-200 dark:bg-zinc-600" aria-hidden="true" />
                        </div>
                    </li>
                </ul>
            </div>

                
    </div>
</template>


<script setup>
import superset from '@/Components/Layout/Superset'
defineProps({
    logs: Array
})
</script>