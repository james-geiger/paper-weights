<template>
<delete-alert :open="showDeleting"
                message="Are you sure you want to delete this workout and its associated sets?  This can't be undone."
                title="Delete Workout" @delete="handleDelete" @cancel="handleCancelDelete" />
                <div class="text-center" v-if="workouts.length < 1">

    <CollectionIcon class="w-12 h-12 mx-auto text-gray-400"></CollectionIcon>

    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No workouts</h3>
    <p class="mt-1 text-sm text-gray-500 dark:text-gray-200">It doesn't look like you've logged any workouts this week.<br/>Better get after it!</p>
  </div>
  <div class="overflow-hidden bg-white shadow sm:rounded-md" v-else>
<ul role="list" class="divide-y divide-gray-200">
                                <li v-for="workout in workouts" :key="workout.id" class="px-4 py-5 bg-white divide-y divide-gray-200 sm:px-6">
                                    <div class="flex space-x-3">
                                        <div class="flex-1 min-w-0">
                                            <p class="mb-2 text-lg font-medium text-gray-900">
                                                {{ workout.name }}
                                            </p>
                                            <div class="inline-flex w-full space-x-6 text-sm text-gray-500">
                                                <span class="inline-flex items-center justify-center">
                                                    <CalendarIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                                                    <time :datetime="workout.date">{{ workout.human_readable_date }}</time>
                                                </span>
                                                <span v-if="workout.time" class="inline-flex items-center justify-center">
                                                    <ClockIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                                                    <time :datetime="workout.time">{{ workout.human_readable_time }}</time>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex self-center flex-shrink-0 space-x-4">
                                            <div class="relative z-10 inline-block text-left">
                                                <a :href="route('workouts.show', workout.id)">
                                                    <button type="button"
                                                        class="flex items-center p-2 -m-2 text-gray-400 rounded-full hover:text-gray-600">
                                                        <PencilIcon class="w-5 h-5" />
                                                    </button>
                                                </a>
                                            </div>
                                            <div class="relative z-10 inline-block text-left handle">
                                                    <button type="button" @click="beginDelete(workout.id)"
                                                        class="flex items-center p-2 -m-2 text-gray-400 rounded-full hover:text-gray-600">
                                                        <TrashIcon class="w-5 h-5" />
                                                    </button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                    </ul>
  </div>
</template>

<script>
import { PencilIcon, TrashIcon } from '@heroicons/vue/solid'
import { CalendarIcon, ClockIcon, CollectionIcon } from '@heroicons/vue/outline'
import { Link } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import DeleteAlert from '@/Components/Modal/DeleteAlert.vue'
import { ref } from 'vue'
import Pagination from '@/Components/Pagination/CardFooterPagination'

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
    DeleteAlert,
    Pagination,
    CollectionIcon
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
