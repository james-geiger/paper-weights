<template>
  <TransitionRoot :show="show" as="template" @after-leave="query = ''">
    <Dialog as="div" :initialFocus="input" class="fixed inset-0 z-10 p-4 overflow-y-auto sm:p-6 md:p-20" @close="show = false">
      <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-25 dark:bg-zinc-900 dark:bg-opacity-75" />
      </TransitionChild>

      <div class="fixed inset-0 z-10 p-4 overflow-y-auto sm:p-6 md:p-20">
        <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 scale-95" enter-to="opacity-100 scale-100" leave="ease-in duration-200" leave-from="opacity-100 scale-100" leave-to="opacity-0 scale-95">
          <DialogPanel class="max-w-2xl mx-auto overflow-hidden transition-all transform bg-gray-900 divide-y divide-gray-500 shadow-2xl divide-opacity-20 rounded-xl">
            <Combobox @update:modelValue="onSelect">
              <div class="relative">
                <SearchIcon class="pointer-events-none absolute top-3.5 left-4 h-5 w-5 text-gray-500" aria-hidden="true" />
                <ComboboxInput ref="input" class="w-full h-12 pr-4 text-white placeholder-gray-500 bg-transparent border-0 pl-11 focus:ring-0 sm:text-sm" placeholder="Search exercises..." @change="query = $event.target.value" />
              </div>

              <ComboboxOptions v-if="query === '' || results.length > 0" static class="overflow-y-auto divide-y divide-gray-500 max-h-80 scroll-py-2 divide-opacity-20">
                <li class="p-2">
                  <h2 v-if="query === ''" class="px-3 mt-4 mb-2 text-xs font-semibold text-gray-200">Recent workouts</h2>
                  <ul class="text-sm text-gray-400">
                    <ComboboxOption v-for="project in query === '' ? recent : results" :key="project.id" :value="project" as="template" v-slot="{ active }">
                      <li :class="['flex cursor-default select-none items-center rounded-md px-3 py-2', active && 'bg-gray-800 text-white']">
                        <FolderIcon :class="['h-6 w-6 flex-none', active ? 'text-white' : 'text-gray-500']" aria-hidden="true" />
                        <span class="flex-auto ml-3 truncate">{{ project.name }}</span>
                        <span v-if="active" class="flex-none ml-3 text-gray-400">Create...</span>
                      </li>
                    </ComboboxOption>
                  </ul>
                </li>
                <li v-if="query === ''" class="p-2">
                  <h2 class="sr-only">Quick actions</h2>
                  <ul class="text-sm text-gray-400">
                    <ComboboxOption v-for="action in quickActions" :key="action.shortcut" :value="action" as="template" v-slot="{ active }">
                      <li :class="['flex cursor-default select-none items-center rounded-md px-3 py-2', active && 'bg-gray-800 text-white']">
                        <component :is="action.icon" :class="['h-6 w-6 flex-none', active ? 'text-white' : 'text-gray-500']" aria-hidden="true" />
                        <span class="flex-auto ml-3 truncate">{{ action.name }}</span>
                      </li>
                    </ComboboxOption>
                  </ul>
                </li>
              </ComboboxOptions>
              <div v-if="query !== '' && results.length === 0" class="px-6 text-center py-14 sm:px-14">
                <FolderIcon class="w-6 h-6 mx-auto text-gray-500" aria-hidden="true" />
                <p class="mt-4 text-sm text-gray-200">We couldn't find any projects with that term. Please try again.</p>
              </div>
            </Combobox>
          </DialogPanel>
        </TransitionChild>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import { computed, ref, watch } from 'vue'
import { SearchIcon } from '@heroicons/vue/solid'
import { Link } from '@inertiajs/inertia-vue3'
import { FolderIcon, PlusCircleIcon } from '@heroicons/vue/outline'
import { Combobox, ComboboxInput, ComboboxOptions, ComboboxOption, Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { exercisePaletteStore } from '@/Stores/ExercisePalette'
import { storeToRefs } from 'pinia'
import { Inertia } from '@inertiajs/inertia'

const store = exercisePaletteStore()
const { show, workout_id, order } = storeToRefs(store)
const { resetExercisePalette } = store


const input = ref(null)

const projects = [
  { id: 1, name: 'Workflow Inc. / Website Redesign', url: '#' },
  // More projects...
]
const recent = [projects[0]]
const quickActions = [
  { name: 'New blank workout...', icon: PlusCircleIcon, url: route('workouts.store'),  method: "post" }
]

const onSelect = (selected) => {
    const submitData = { 
        exercise_id: selected.id,
        workout_id: workout_id.value,
        order: order.value
    }
    resetExercisePalette()
    Inertia.visit(route('logs.store'), { method: 'POST', data: submitData,  preserveScroll: true })
}

const query = ref('')
const results = ref([])

watch(query, _.debounce((query, prevQuery) => {
        query === ''
        ? results.value = []
        : axios.get(route('exercise.search', {q: query })).then(response => {
                results.value = response.data
        })},150)
    )
</script>