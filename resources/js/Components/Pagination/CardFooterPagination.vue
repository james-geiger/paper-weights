<template>
  <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
    <div class="flex-1 flex justify-between sm:hidden">
      <a :href="data.prev_page_url" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Previous </a>
      <a :href="data.next_page_url" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Next </a>
    </div>
    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
      <div>
        <p class="text-sm text-gray-700">
          Showing
          {{ ' ' }}
          <span class="font-medium">{{ data.from }}</span>
          {{ ' ' }}
          to
          {{ ' ' }}
          <span class="font-medium">{{ data.to }}</span>
          {{ ' ' }}
          of
          {{ ' ' }}
          <span class="font-medium">{{ data.total }}</span>
          {{ ' ' }}
          results
        </p>
      </div>
      <div>
        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
          <a :href="data.prev_page_url" :class="[data.prev_page_url == null ? 'cursor-not-allowed ': 'hover:bg-gray-50', 'relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500']">
            <span class="sr-only">Previous</span>
            <ChevronLeftIcon class="h-5 w-5" aria-hidden="true" />
          </a>
          <!-- Current: "z-10 bg-indigo-50 border-indigo-500 text-indigo-600", Default: "bg-white border-gray-300 text-gray-500 hover:bg-gray-50" -->
          <a v-for="(link, index) in links" :key="index" :href="link.url" aria-current="page" :class="[link.active ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50', 'relative inline-flex items-center px-4 py-2 border text-sm font-medium']"> {{ link.label }} </a>
          <a :href="data.next_page_url" :class="[data.next_page_url == null ? 'cursor-not-allowed' : 'hover:bg-gray-50', 'relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500']">
            <span class="sr-only">Next</span>
            <ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
          </a>
        </nav>
      </div>
    </div>
  </div>
</template>

<script>
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/solid'
import { computed } from 'vue'

export default {
    props: ['data'],
    components: {
        ChevronLeftIcon,
        ChevronRightIcon,
    },
    setup (props) {
        const links = computed(() => props.data.links.slice(1, -1))
        return {
            links
        }
    }
}
</script>
