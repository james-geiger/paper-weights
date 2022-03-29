<template>
    <Link :href="route('workouts.show', workout.id)" as="button"
        class="inline-flex items-center py-2 border border-white hover:underline text-sm leading-4 font-medium rounded-md text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
    <ChevronLeftIcon class="-ml-1 mr-2 h-5 w-5 text-gray-500" aria-hidden="true" />
    Back to Workout
    </Link>
    <div class="lg:flex lg:items-center lg:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="mt-2 text-xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">{{ log.exercise.name }}
            </h2>
        </div>
        <div class="mt-5 flex flex-col sm:flex-row lg:mt-0 lg:ml-4">
            <span class="hidden sm:block">
                <button type="button" v-on:click="discard"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <TrashIcon class="-ml-1 mr-2 h-5 w-5 text-gray-500" aria-hidden="true" />
                    Delete
                </button>
            </span>

            <span class="hidden sm:block sm:ml-3">
                <button type="button" v-on:click="edit"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <PencilIcon class="-ml-1 mr-2 h-5 w-5 text-gray-500" aria-hidden="true" />
                    Edit
                </button>
            </span>

            <!-- Dropdown -->
            <Menu as="span" class="sm:ml-3 relative sm:hidden">
                <MenuButton
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Actions
                    <ChevronDownIcon class="-mr-1 ml-2 h-5 w-5 text-gray-500" aria-hidden="true" />
                </MenuButton>

                <transition enter-active-class="transition ease-out duration-200"
                    enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
                    leave-active-class="transition ease-in duration-75"
                    leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                    <MenuItems
                        class="origin-top-right absolute right-0 mt-2 -mr-1 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                        <MenuItem v-slot="{ active }">
                        <a href="#"
                            :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">Edit</a>
                        </MenuItem>
                        <MenuItem v-slot="{ active }">
                        <a href="#"
                            :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">Delete</a>
                        </MenuItem>
                    </MenuItems>
                </transition>
            </Menu>

        </div>
    </div>
</template>

<script>
    import {
        BriefcaseIcon,
        CalendarIcon,
        CheckIcon,
        ChevronDownIcon,
        ChevronRightIcon,
        ChevronLeftIcon,
        CurrencyDollarIcon,
        LinkIcon,
        LocationMarkerIcon,
        PencilIcon,
        TrashIcon,
        PlusIcon
    } from '@heroicons/vue/outline'
    import {
        Link
    } from '@inertiajs/inertia-vue3'
    import {
        Menu,
        MenuButton,
        MenuItem,
        MenuItems
    } from '@headlessui/vue'

    export default {
        props: ['workout', 'log'],
        components: {
            Menu,
            MenuButton,
            MenuItem,
            MenuItems,
            BriefcaseIcon,
            CalendarIcon,
            CheckIcon,
            ChevronDownIcon,
            ChevronRightIcon,
            ChevronLeftIcon,
            CurrencyDollarIcon,
            LinkIcon,
            LocationMarkerIcon,
            PencilIcon,
            TrashIcon,
            PlusIcon,
            Link
        },
        data() {
            return {
                editing: false
            }
        },
        methods: {
            edit() {
                this.editing = !this.editing
                this.$emit('edit', this.editing)
            },
            discard() {
                this.$emit('discard', true)
            },
            showSearch() {
                this.$emit('showSearch', true)
            }
        }
    }

</script>
