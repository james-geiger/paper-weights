<template>
  <Head :title="title" />
  <div class="min-h-full">
    <Navigation />
    <header class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <!-- Header Content --->
        <slot name="header"></slot>
        <!-- /Header Content --->
      </div>
    </header>
    <main>
      <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Main Content -->
        <slot></slot>
        <!-- /Main Content -->
      </div>
    </main>
  </div>
</template>

<script>
import { defineComponent } from 'vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
import Navigation from '@/Components/Navigation/Navigation.vue'


export default defineComponent({
  components: {
    Navigation,
    Head,
    Link
  },
  setup() {
    return {

    }
  },
})
</script>
