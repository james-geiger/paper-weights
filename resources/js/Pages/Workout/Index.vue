<template>
    <app-layout title="Workouts">
        <template #header>
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
        <button type="button" :class="[day.hasWorkout && 'text-white font-bold', !day.hasWorkout && 'text-gray-400 font-medium', day.isToday && 'border-b-solid border-b-2 border-b-white', day.isSelected && day.isToday && 'bg-indigo-600', day.isSelected && !day.isToday && 'bg-gray-900', !day.isSelected && 'hover:bg-gray-200 hover:text-black', (day.isSelected || day.isToday) && 'font-semibold', 'mx-auto flex h-8 w-8 items-center justify-center']">
          <time :datetime="day.date">{{ day.date.split('-').pop().replace(/^0/, '') }}</time>
        </button>
      </div>
    </div>
    </div>
    
    <Link as="button" :href="route('workouts.list', {'date': dates.nextWeek})" class="flex flex-none items-center justify-center p-1.5 text-gray-400 hover:text-gray-500">
        <span class="sr-only">Next week</span>
        <ChevronRightIcon class="w-5 h-5" aria-hidden="true" />
      </Link>
      
      </div>
        </template>
            <div>
                <workout-table :workouts="workouts" />
            </div>
    </app-layout>
</template>

<script setup>
    import { Link } from '@inertiajs/inertia-vue3'
    import AppLayout from '@/Layouts/SingleColumnLayout.vue'
    import WorkoutTable from '@/Components/Workout/ListTable.vue'
    import { ChevronLeftIcon, ChevronRightIcon, CalendarIcon } from '@heroicons/vue/solid'

const props = defineProps({
  workouts: Array,
  dates: Object,
  days: Array
})
</script>
