<template>
    <div>
        <delete-alert :open="showDeleting" message="Are you sure you want to remove this workout and all its associated exercises and sets?  This cannot be undone." title="Delete Workout" @delete="handleDelete" @cancel="handleCancelDelete"/>
        <Link :href="route('workouts.list')" as="button"
            class="inline-flex items-center py-2 border border-white hover:underline text-sm leading-4 font-medium rounded-md text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <ChevronLeftIcon class="-ml-1 mr-2 h-5 w-5 text-gray-500" aria-hidden="true" />
        Back to Workout List
        </Link>
        <h1 contenteditable="" v-text="workout.name" @blur="update" ref="workoutTitle"
            class="my-2 text-xl leading-6 font-semibold text-gray-900 block w-full sm:truncate rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        </h1>
        <div class="flex flex-col sm:flex-row items-start justify-between">
            <div class="flex-1 min-w-0">
                    <div class="flex items-end text-sm text-gray-500">
                        <div class="relative rounded-md">
                            <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                                <CalendarIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                            </div>
                            <input @change="update" type="date" name="date" id="date" v-model="workout.date"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full border border-white shadow-none pl-7 py-0 sm:text-sm rounded-md" />
                        </div>
                    </div>
            </div>
            <div class="mt-2 sm:flex flex-col sm:flex-row lg:mt-0 lg:ml-4">
                <span class="hidden sm:block">
                    <button type="button" v-on:click="beginDelete"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <TrashIcon class="-ml-1 mr-2 h-5 w-5 text-gray-500" aria-hidden="true" />
                        Delete
                    </button>
                </span>

                <span class="w-full sm:ml-3 hidden sm:block">
                    <button type="button" v-on:click="showSearch"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <PlusIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                        Add Exercise
                    </button>
                </span>
                <Menu as="span" class="sm:ml-3 relative sm:hidden">
                        <MenuButton
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Actions
                            <ChevronDownIcon class="-mr-1 ml-2 h-5 w-5 text-gray-500" aria-hidden="true" />
                        </MenuButton>

                        <transition enter-active-class="transition ease-out duration-200"
                            enter-from-class="transform opacity-0 scale-95"
                            enter-to-class="transform opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="transform opacity-100 scale-100"
                            leave-to-class="transform opacity-0 scale-95">
                            <MenuItems
                                class="origin-top-left absolute left-0 mt-2 -mr-1 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <MenuItem v-slot="{ active }">
                                <a v-on:click="beginDelete"
                                    :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">Delete</a>
                                </MenuItem>
                            </MenuItems>
                        </transition>
                    </Menu>
            </div>
        </div>
        <div class='block fixed bottom-5 right-5 sm:hidden'>
            <button type="button" v-on:click="showSearch"
                class="inline-flex items-center px-3 py-3 border border-transparent rounded-full shadow-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <PlusIcon class="h-6 w-6" aria-hidden="true" />
            </button>
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
        Menu,
        MenuButton,
        MenuItem,
        MenuItems
    } from '@headlessui/vue'
    import {
        Inertia
    } from '@inertiajs/inertia'
    import {
        Link
    } from '@inertiajs/inertia-vue3'
    import DeleteAlert from '@/Components/Modal/DeleteAlert.vue'

    export default {
        props: ['workout'],
        components: {
            Link,
            Menu,
            MenuButton,
            MenuItem,
            MenuItems,
            DeleteAlert,
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
        },
        data() {
            return {
                editing: false,
                showDeleting: false
            }
        },
        methods: {
            edit() {
                this.editing = !this.editing
            },
            beginDelete(){
                this.showDeleting = true
            },
            handleDelete(){
                console.log('deleting...' + this.workout.id)
                Inertia.delete(route('workouts.destroy', this.workout.id))
                this.showDeleting = false
            },
            handleCancelDelete(){
                this.showDeleting = false
            },
            discard() {
                this.$emit('discard', true)
            },
            showSearch() {
                this.$emit('showSearch', true)
            },
            update(e) {
                this.workout.name = this.$refs.workoutTitle.innerHTML
                Inertia.put(route('workouts.update', this.workout.id), {
                    name: this.workout.name,
                    date: this.workout.date
                })
            }
        }
    }

</script>

<style scope>
    input[type=date]::-webkit-clear-button,
    input[type=date]::-webkit-inner-spin-button {
        display: none;
    }

    input[type=date]::-webkit-datetime-edit,
    input[type=date]::-webkit-datetime-edit-fields-wrapper,
    input[type=date]::-webkit-datetime-edit-month-field,
    input[type=date]::-webkit-datetime-edit-text,
    input[type=date]::-webkit-datetime-edit-day-field,
    input[type=date]::-webkit-datetime-edit-year-field {
        padding-top: 0 !important;
        white-space: normal;
    }

    input[type=date]::-webkit-calendar-picker-indicator {
        position: absolute;
        left: 0;
        top: 0;
        width: 1.25rem;
        height: 100%;
        margin: 0;
        padding: 0;
        cursor: pointer;
        background-image: none;
    }

</style>
