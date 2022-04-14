<template>
<delete-alert :open="showDeleting"
                message="Are you sure you want to delete this workout plan?  This can't be undone."
                title="Delete Workout Plan" @delete="handleDelete" @cancel="handleCancelDelete" />
  <div class="bg-white shadow overflow-hidden sm:rounded-md">
<ul role="list" class="divide-y divide-gray-200">
                                <li v-for="plan in plans.data" :key="plan.id" class="px-4 py-5 sm:px-6 bg-white divide-y divide-gray-200">
                                    <div class="flex space-x-3">
                                        <div class="min-w-0 flex-1">
                                            <p class="text-lg font-medium text-gray-900 mb-2">
                                                {{ plan.name }}
                                            </p>
                                        </div>
                                        <div class="flex-shrink-0 self-center flex space-x-4">
                                            <div class="relative z-10 inline-block text-left">
                                                <a :href="route('plans.show', plan.id)">
                                                    <button type="button"
                                                        class="-m-2 p-2 rounded-full flex items-center text-gray-400 hover:text-gray-600">
                                                        <PencilIcon class="h-5 w-5" />
                                                    </button>
                                                </a>
                                            </div>
                                            <div class="relative z-10 inline-block text-left handle">
                                                    <button type="button" @click="beginDelete(plan.id)"
                                                        class="-m-2 p-2 rounded-full flex items-center text-gray-400 hover:text-gray-600">
                                                        <TrashIcon class="h-5 w-5" />
                                                    </button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                    </ul>
                    <pagination :data="plans" />
  </div>
</template>

<script>
import { PencilIcon, TrashIcon } from '@heroicons/vue/solid'
import { CalendarIcon, ClockIcon } from '@heroicons/vue/outline'
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
        Inertia.delete(route('plans.destroy', modelDeleting.value))
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
    Pagination
  },
  props: ['plans'],
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
