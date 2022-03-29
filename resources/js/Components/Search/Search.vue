<template>
  <TransitionRoot :show="show" as="template" @after-leave="query = ''">
    <Dialog as="div" class="fixed inset-0 z-10 overflow-y-auto p-4 sm:p-6 md:p-20" @close="show = false">
      <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
        <DialogOverlay class="fixed inset-0 bg-gray-500 bg-opacity-25 transition-opacity" />
      </TransitionChild>

      <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 scale-95" enter-to="opacity-100 scale-100" leave="ease-in duration-200" leave-from="opacity-100 scale-100" leave-to="opacity-0 scale-95">
        <Combobox as="div" class="mx-auto max-w-xl transform divide-y divide-gray-100 overflow-hidden rounded-xl bg-white shadow-2xl ring-1 ring-black ring-opacity-5 transition-all" @update:modelValue="onSelect">
          <div class="relative">
            <SearchIcon class="pointer-events-none absolute top-3.5 left-4 h-5 w-5 text-gray-400" aria-hidden="true" />
            <ComboboxInput class="h-12 w-full border-0 bg-transparent pl-11 pr-4 text-gray-800 placeholder-gray-400 focus:ring-0 sm:text-sm" placeholder="Search exercises..." @change="query = $event.target.value" />
          </div>

          <ComboboxOptions v-if="filteredResults.length > 0" static class="max-h-72 scroll-py-2 overflow-y-auto py-2 text-sm text-gray-800">
            <ComboboxOption v-for="exercise in filteredResults" :key="exercise.id" :value="exercise" as="template" v-slot="{ active }">
              <li :class="['cursor-default select-none px-4 py-2', active && 'bg-indigo-600 text-white']">
                {{ exercise.name }}
                <span class="inline-flex items-center px-2 py-0.5 mx-1 rounded text-xs font-medium bg-gray-100 text-gray-800">{{ exercise.mechanics }}</span>
                <span class="inline-flex items-center px-2 py-0.5 mx-1 rounded text-xs font-medium bg-gray-100 text-gray-800"> {{ exercise.force }} </span>

              </li>
            </ComboboxOption>
          </ComboboxOptions>

          <p v-if="query !== '' && filteredResults.length === 0" class="p-4 text-sm text-gray-500">No exercises found.</p>
        </Combobox>
      </TransitionChild>
    </Dialog>
  </TransitionRoot>
</template>

<script>
import { ref, watch } from 'vue'
import { SearchIcon } from '@heroicons/vue/solid'
import { CogIcon } from '@heroicons/vue/outline'
import {
  Combobox,
  ComboboxInput,
  ComboboxOptions,
  ComboboxOption,
  Dialog,
  DialogOverlay,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'

export default {
  components: {
    Combobox,
    ComboboxInput,
    ComboboxOptions,
    ComboboxOption,
    Dialog,
    DialogOverlay,
    SearchIcon,
    CogIcon,
    TransitionChild,
    TransitionRoot,
  },
  setup(props, context) {
    const show = ref(false)
    const query = ref('')
    const filteredResults = ref([])

    const onSelect = (exercise) => {
        context.emit('selected', exercise)
    }

    const openSearch = () => {
        show.value = true
    }

    watch(query, _.debounce((query, prevQuery) => {
        query === ''
        ? filteredResults.value = []
        : axios.get(route('exercise.search', {q: query })).then(response => {
                filteredResults.value = response.data
        })},150)
    )

    return {
      show,
      query,
      filteredResults,
      onSelect,
      openSearch
    }
  },
}
</script>

<!--<template>
  <TransitionRoot :show="isOpen" as="template" @after-leave="query = ''">
    <Dialog as="div" class="fixed inset-0 z-10 overflow-y-auto p-4 sm:p-6 md:p-20" @close="open = false">
      <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
        <DialogOverlay class="fixed inset-0 bg-gray-500 bg-opacity-25 transition-opacity" />
      </TransitionChild>

      <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 scale-95" enter-to="opacity-100 scale-100" leave="ease-in duration-200" leave-from="opacity-100 scale-100" leave-to="opacity-0 scale-95">
        <Combobox as="div" class="mx-auto max-w-xl transform divide-y divide-gray-100 overflow-hidden rounded-xl bg-white shadow-2xl ring-1 ring-black ring-opacity-5 transition-all" @update:modelValue="emitSelect">
          <div class="relative">
            <SearchIcon class="pointer-events-none absolute top-3.5 left-4 h-5 w-5 text-gray-400" aria-hidden="true" />
            <ComboboxInput class="h-12 w-full border-0 bg-transparent pl-11 pr-4 text-gray-800 placeholder-gray-400 focus:ring-0 sm:text-sm" placeholder="Search..." @change="filter($event.target.value)" />
          </div>

          <ComboboxOptions v-if="filteredSearch.length > 0" static class="max-h-72 scroll-py-2 overflow-y-auto py-2 text-sm text-gray-800">
            <ComboboxOption v-for="exercise in filteredSearch" :key="exercise.id" :value="exercise" as="template" v-slot="{ active }">
              <li :class="['cursor-default select-none px-4 py-2', active && 'bg-indigo-600 text-white']">
                {{ exercise.name }}
              </li>
            </ComboboxOption>
          </ComboboxOptions>

          <p v-if="query !== '' && filteredSearch.length === 0" class="p-4 text-sm text-gray-500">No exercises found.</p>
        </Combobox>
      </TransitionChild>
    </Dialog>
  </TransitionRoot>
</template>

<script>
import { computed, ref } from 'vue'
import { SearchIcon } from '@heroicons/vue/solid'
import {
  Combobox,
  ComboboxInput,
  ComboboxOptions,
  ComboboxOption,
  Dialog,
  DialogOverlay,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'

export default {
  components: {
    Combobox,
    ComboboxInput,
    ComboboxOptions,
    ComboboxOption,
    Dialog,
    DialogOverlay,
    SearchIcon,
    TransitionChild,
    TransitionRoot,
  },

  setup() {
    const query = ref('')
    const filteredSearch = ref([])
    const isOpen = ref(false)

    return {
        isOpen,
      query,
      filteredSearch
    }
  },
  methods:{
      open(){
          this.isOpen = true
      },
      close(){
          this.open = false
      },
      emitSelect(exercise){
          this.$emit('selected', exercise)
      },
      filter(query){
        axios.get(route('exercise.search', {q: query})).then(response => {
            this.filteredSearch = response.data
        })
      }
  },
}
</script>
-->
