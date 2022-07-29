<template>
  <Head :title="title" />
  <div class="min-h-full">
    <Navigation />
    <header class="bg-white shadow-sm">
      <div class="px-4 py-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Header Content --->
        <slot name="header"></slot>
        <!-- /Header Content --->
      </div>
    </header>
    <main scroll-region>
      <div class="pt-4 pb-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
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
import Navigation from '@/Components/Navigation/Navigation'


export default defineComponent({
    props: {
            title: String,
        },
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
