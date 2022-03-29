<template>
  <div class="bg-white shadow overflow-hidden sm:rounded-md">
    <ul role="list" class="divide-y divide-gray-200">
      <li v-for="workout in workouts" :key="workout.id" class="group hover:bg-gray-50 cursor-pointer">
          <div class="flex flex-row items-center justify-between">
              <Link :href="route('workouts.show', workout.id)" class="grow block px-4 py-4 sm:px-6">
            <div class="flex items-center justify-between">
              <p class="text-md font-medium text-indigo-600 truncate" v-if="workout.name">
                {{ workout.name }}
              </p>
            </div>
            <div class="mt-2 sm:flex sm:justify-between">
              <div class="sm:flex">
                <p class="flex items-center text-sm text-gray-500">
                  <CalendarIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                  <time :datetime="workout.date">{{ workout.human_readable_date }}</time>
                </p>
                <p v-if="workout.time" class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                  <ClockIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                  <time :datetime="workout.time">{{ workout.human_readable_time }}</time>
                </p>
              </div>
            </div>
          </Link>
          <div class="px-4 py-4 sm:px-6">
              <div class="flex items-center justify-between space-x-2">
                <button @click="handleDelete(workout.id)" type="button" class="inline-flex items-center p-1.5 border border-gray-300 rounded-full shadow-sm text-gray-700 bg-white hover:bg-gray-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <TrashIcon class="h-5 w-5" aria-hidden="true" />
                </button>
              </div>
          </div>
          </div>
      </li>
    </ul>
  </div>
</template>

<script>
import { CalendarIcon, ClockIcon, PencilIcon } from '@heroicons/vue/solid'
import { TrashIcon } from '@heroicons/vue/outline'
import { Link } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'

const handleDelete = (id) => {
    console.log('deleting...' + id)
    Inertia.delete(route('workouts.destroy', id))
}

export default {
  components: {
    Link,
    CalendarIcon,
    ClockIcon,
    PencilIcon,
    TrashIcon
  },
  props: ['workouts'],
  setup() {
    return {
        handleDelete
    }
  },
}
</script>
