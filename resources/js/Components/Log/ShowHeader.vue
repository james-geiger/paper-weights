<template>
<div class="flex items-center justify-between">
    <!--<search ref="searchCommand" @close="searching = !searching" :workout_id="workout.id" :order="log.order + 1"/>-->
    <Link :href="route('workouts.show', workout.id)" as="button"
        class="inline-flex items-center py-2 text-sm font-medium leading-4 text-gray-700 bg-white border border-white rounded-md hover:underline focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
    <ChevronLeftIcon class="w-5 h-5 mr-2 -ml-1 text-gray-500" aria-hidden="true" />
    Back to Workout
    </Link>
    <Menu as="span" class="relative sm:ml-3 sm:hidden">
                <MenuButton
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Actions
                    <ChevronDownIcon class="w-5 h-5 ml-2 -mr-1 text-gray-500" aria-hidden="true" />
                </MenuButton>

                <transition enter-active-class="transition duration-200 ease-out"
                    enter-from-class="transform scale-95 opacity-0" enter-to-class="transform scale-100 opacity-100"
                    leave-active-class="transition duration-75 ease-in"
                    leave-from-class="transform scale-100 opacity-100" leave-to-class="transform scale-95 opacity-0">
                    <MenuItems
                        class="absolute right-0 w-48 py-1 mt-2 -mr-1 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
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
    <div class="lg:flex lg:items-center lg:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="mt-2 text-xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">{{ log.exercise.name }}
            </h2>
        </div>
        <div class="flex flex-row justify-between mt-5 space-x-2 sm:justify-start lg:mt-0 lg:ml-4">
            <span class="block w-1/2 text-left lg:ml-3 lg:w-auto">
                <a :href="pagination.prev" type="button" v-if="pagination.prev" class="w-full">
                    <button
                    class="inline-flex items-center justify-start w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <ChevronLeftIcon class="w-5 h-5 mr-2 -ml-1 text-gray-500" aria-hidden="true" />
                    Previous Exercise
                    </button>
                </a>
                <button type="button" v-else @click="this.$refs.searchCommand.openSearch()"
                    class="inline-flex items-center justify-start w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <PlusIcon class="w-5 h-5 mr-2 -ml-1 text-gray-500" aria-hidden="true" />
                    Add Exercise Before
                </button>
            </span>

            <span class="block w-1/2 text-right lg:ml-3 lg:w-auto">
                <a :href="pagination.next" type="button" v-if="pagination.next" class="w-full">
                <button
                    class="inline-flex items-center justify-end w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Next Exercise
                    <ChevronRightIcon class="w-5 h-5 ml-2 -mr-1 text-gray-500" aria-hidden="true" />
                    </button>
                </a>
                <button type="button" v-else @click="this.$refs.searchCommand.openSearch()"
                    class="inline-flex items-center justify-end w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Add Exercise After
                    <PlusIcon class="w-5 h-5 ml-2 -mr-1 text-gray-500" aria-hidden="true" />
                </button>
            </span>

            <span class="hidden sm:block">
                <button type="button" v-on:click="discard"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <TrashIcon class="w-5 h-5 mr-2 -ml-1 text-gray-500" aria-hidden="true" />
                    Delete
                </button>
            </span>

            <span class="hidden sm:block sm:ml-3">
                <button type="button" v-on:click="edit"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <PencilIcon class="w-5 h-5 mr-2 -ml-1 text-gray-500" aria-hidden="true" />
                    Edit
                </button>
            </span>
        </div>
    </div>
</template>

<script setup>
import { BriefcaseIcon, CalendarIcon, CheckIcon, ChevronDownIcon, ChevronRightIcon, ChevronLeftIcon, CurrencyDollarIcon, LinkIcon, LocationMarkerIcon, PencilIcon, TrashIcon, PlusIcon } from '@heroicons/vue/outline'
import { Link } from '@inertiajs/inertia-vue3'
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'

defineProps(['workout', 'log', 'pagination'])

/*discard() {
                this.$emit('discard', true)
            },
            showSearch() {
                this.$emit('showSearch', true)
            }
*/
</script>
