<template>
    <app-layout title="Workouts">
        <template #header>
            <div class="max-w-3xl m-auto">
            <div class="flex items-stretch">
                
      <Link as="button" :href="route('workouts.list', {'date': dates.prevWeek})" class="-my-1.5 flex flex-none items-center justify-center p-1.5 text-gray-400 hover:text-gray-500">
        <span class="sr-only">Previous week</span>
        <ChevronLeftIcon class="w-5 h-5" aria-hidden="true" />
      </Link>
      
      
      <div class="grow">
    <div class="grid grid-cols-7 text-xs leading-6 text-center text-gray-400">
      <div>M</div>
      <div>T</div>
      <div>W</div>
      <div>T</div>
      <div>F</div>
      <div>S</div>
      <div>S</div>
    </div>
    <div class="grid grid-cols-7 text-sm">
      <div v-for="(day, dayIdx) in days" :key="day.date" :class="[dayIdx > 6 && 'border-t border-gray-200', '']">
        <span :class="[day.hasWorkout && 'text-black dark:text-white font-bold', !day.hasWorkout && 'text-gray-400 font-medium', day.isToday && 'border-b-solid border-b-2 border-b-black dark:border-b-white', 'mx-auto flex h-8 w-8 items-center justify-center']">
          <time :datetime="day.date">{{ day.date.split('-').pop().replace(/^0/, '') }}</time>
        </span>
      </div>
    </div>
    </div>
    
    <Link as="button" :href="route('workouts.list', {'date': dates.nextWeek})" class="flex flex-none items-center justify-center p-1.5 text-gray-400 hover:text-gray-500">
        <span class="sr-only">Next week</span>
        <ChevronRightIcon class="w-5 h-5" aria-hidden="true" />
      </Link>
      
      </div>
            </div>
        </template>
            <div v-if="workouts.length > 0">
                <!--<workout-table :workouts="workouts" />-->
                <workout-list :workouts="workouts" :viewing="dates.viewing" />
            </div>
            <div v-else class="max-w-3xl px-6 pt-4 pb-6 mx-auto text-gray-900 md:px-0 dark:text-white">
                <button @click="toggleWorkoutPalette" type="button" class="relative block w-full p-12 text-center border border-dashed rounded-lg border-1 border-zinc-500 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <LightningBoltIcon class="w-12 h-12 mx-auto text-gray-400" />
                    <span class="block mt-2 text-base font-medium"> Better get after it! </span>
                    <span class="block text-sm">You haven't logged any workouts this week.</span>
            </button>
            </div>
    </app-layout>
</template>

<script setup>
    import { Link } from '@inertiajs/inertia-vue3'
    import AppLayout from '@/Layouts/SingleColumnLayout.vue'
    import WorkoutTable from '@/Components/Workout/ListTable.vue'
    import WorkoutList from '@/Components/Workout/CardList'
    import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/solid'
    import { LightningBoltIcon } from '@heroicons/vue/outline'
    import { workoutPaletteStore } from '@/Stores/WorkoutPalette'


    const store = workoutPaletteStore()
    const { toggleWorkoutPalette } = store

const props = defineProps({
  workouts: Array,
  dates: Object,
  days: Array
})
</script>
