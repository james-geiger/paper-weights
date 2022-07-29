


    <template>
    <div>
        <Head :title="title" />

        <jet-banner />
        <slot name="modals"></slot>

        <div class="min-h-full">
            <Navigation />
            <!-- Page Heading -->
            <header class="bg-white shadow-sm">
                <div class="px-4 py-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <!-- Header Content --->
                    <slot name="header"></slot>
                    <!-- /Header Content --->
                </div>
            </header>

            <!-- Page Content -->
                <main class="pb-8 mt-4">
      <div class="max-w-3xl mx-auto sm:px-6 lg:max-w-7xl lg:px-8">
        <h1 class="sr-only">Page title</h1>
        <!-- Main 3 column grid -->
        <div class="grid items-start grid-cols-1 gap-4 lg:grid-cols-3 lg:gap-8">
          <!-- Left column -->
          <div class="grid grid-cols-1 gap-4 lg:col-span-2">
            <section aria-labelledby="section-1-title">
              <h2 class="sr-only" id="section-1-title">Section title</h2>
              <div class="overflow-visible bg-white rounded-lg shadow" scroll-region="">
                <slot name="main"></slot>
              </div>
            </section>
          </div>

          <!-- Right column -->
          <div class="grid grid-cols-1 gap-4">
            <section aria-labelledby="section-2-title">
              <h2 class="sr-only" id="section-2-title">Section title</h2>
                <slot name="right"></slot>
            </section>
          </div>
        </div>
      </div>
    </main>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import JetBanner from '@/Jetstream/Banner.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import Navigation from '@/Components/Navigation/Navigation'

    export default defineComponent({
        props: {
            title: String,
        },

        components: {
            Navigation,
            Head,
            JetBanner,
            Link,
        },
    })
</script>
