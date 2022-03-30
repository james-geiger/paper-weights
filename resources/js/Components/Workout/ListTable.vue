<template>
<delete-alert :open="showDeleting"
                message="Are you sure you want to delete this workout and its associated sets?  This can't be undone."
                title="Delete Workout" @delete="handleDelete" @cancel="handleCancelDelete" />
  <div class="bg-white shadow overflow-hidden sm:rounded-md">
<ul role="list" class="divide-y divide-gray-200">

                                <li v-for="workout in workouts" :key="workout.id" class="px-4 py-5 sm:px-6 bg-white divide-y divide-gray-200">
                                    <div class="flex space-x-3">
                                        <div class="min-w-0 flex-1">
                                            <p class="text-lg font-medium text-gray-900 mb-2">
                                                {{ workout.name }}
                                            </p>
                                            <div class="inline-flex w-full space-x-6 text-sm text-gray-500">
                                                <span class="inline-flex justify-center items-center">
                                                    <CalendarIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                                                    <time :datetime="workout.date">{{ workout.human_readable_date }}</time>
                                                </span>
                                                <span v-if="workout.time" class="inline-flex justify-center items-center">
                                                    <ClockIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                                                    <time :datetime="workout.time">{{ workout.human_readable_time }}</time>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 self-center flex space-x-4">
                                            <div class="relative z-10 inline-block text-left">
                                                <a :href="route('workouts.show', workout.id)">
                                                    <button type="button"
                                                        class="-m-2 p-2 rounded-full flex items-center text-gray-400 hover:text-gray-600">
                                                        <PencilIcon class="h-5 w-5" />
                                                    </button>
                                                </a>
                                            </div>
                                            <div class="relative z-10 inline-block text-left handle">
                                                    <button type="button" @click="beginDelete(workout.id)"
                                                        class="-m-2 p-2 rounded-full flex items-center text-gray-400 hover:text-gray-600">
                                                        <TrashIcon class="h-5 w-5" />
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
import DeleteAlert from '@/Components/Modal/DeleteAlert.vue'
import { ref } from 'vue'

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

export default {
  components: {
    Link,
    CalendarIcon,
    ClockIcon,
    PencilIcon,
    TrashIcon,
    DeleteAlert
  },
  props: ['workouts'],
  setup() {
    return {
        showDeleting,
        modelDeleting,
        beginDelete,
        handleDelete,
        handleCancelDelete
    }
  }
}
</script>
