<template>
    <app-layout title="Workouts">
        <template #header>
            <show-header :workout="workout" @discard="discard" @showSearch="this.$refs.searchCommand.openSearch()" />
        </template>
        <template #main>
            <delete-alert :open="showDeleting"
                message="Are you sure you want to remove this exercise and its associated sets from this workout?"
                title="Delete Exercise" @delete="handleDelete" @cancel="handleCancelDelete" />
            <div>
                <search ref="searchCommand" @close="searching = !searching" @selected="handleSelected" />
                <div class="bg-white shadow overflow-hidden rounded-md" v-if="logs.length > 0">
                    <ul role="list" class="divide-y divide-gray-200">
                        <draggable :list="logs" tag="transition-group" item-key="id" @end="handleDrop">
                            <template #item="{element}">
                                <li class="px-4 py-5 sm:px-6 bg-white divide-y divide-gray-200">
                                        <div class="flex space-x-3">
                                            <div class="min-w-0 flex-1">
                                                <p class="text-lg font-medium text-gray-900 mb-2">
                                                    <a :href="route('exercises.show', element.exercise.id)" class="hover:underline">{{ element.exercise.name }}</a>
                                                </p>
                                                <div class="inline-flex w-full space-x-6 text-sm text-gray-500">
                                                    <span class="inline-flex justify-center items-center">
                                                        <CollectionIcon class="h-4 w-4 mr-2" />
                                                        {{ Math.round(element.sets_count) }}
                                                    </span>
                                                    <span class="inline-flex justify-center items-center">
                                                        <HashtagIcon class="h-4 w-4 mr-2" />
                                                        {{ Math.round(element.sets_sum_reps) }}
                                                    </span>
                                                    <span class="inline-flex justify-center items-center">
                                                        <ScaleIcon class="h-4 w-4 mr-2" />
                                                        {{ weightVolume(element.sets, 'lbs') }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex-shrink-0 self-center flex space-x-4">
                                                <div class="relative z-10 inline-block text-left">
                                                    <a :href="route('logs.show', element.id)">
                                                        <button type="button"
                                                            class="-m-2 p-2 rounded-full flex items-center text-gray-400 hover:text-gray-600">
                                                            <PencilIcon class="h-5 w-5" />
                                                        </button>
                                                    </a>
                                                </div>
                                                <Menu as="div" class="relative z-10 inline-block text-left">
                                                    <div>
                                                        <MenuButton
                                                            class="-m-2 p-2 rounded-full flex items-center text-gray-400 hover:text-gray-600">
                                                            <span class="sr-only">Open options</span>
                                                            <DotsVerticalIcon class="h-5 w-5" aria-hidden="true" />
                                                        </MenuButton>
                                                    </div>

                                                    <transition enter-active-class="transition ease-out duration-100"
                                                        enter-from-class="transform opacity-0 scale-95"
                                                        enter-to-class="transform opacity-100 scale-100"
                                                        leave-active-class="transition ease-in duration-75"
                                                        leave-from-class="transform opacity-100 scale-100"
                                                        leave-to-class="transform opacity-0 scale-95">
                                                        <MenuItems
                                                            class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                                            <div class="py-1">
                                                                <MenuItem v-slot="{ active }">
                                                                <button @click="beginDelete(element.id)"
                                                                    :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'flex px-4 py-2 text-sm w-full']">
                                                                    <TrashIcon class="mr-3 h-5 w-5 text-gray-400"
                                                                        aria-hidden="true" />
                                                                    <span>Delete Exercise</span>
                                                                </button>
                                                                </MenuItem>
                                                            </div>
                                                        </MenuItems>
                                                    </transition>
                                                </Menu>
                                            </div>
                                        </div>
                                    <!--
                                <div class="px-4 py-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                                    <div class="">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                                            {{ element.exercise.name }}</h3>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div class="flex flex-row">
                                            <span class="sm:block">
                                                <button type="button" @click="beginDelete(element.id)"
                                                    class="inline-flex items-center px-2 py-2 border border-white text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    <TrashIcon class="h-5 w-5 text-gray-500" />
                                                </button>
                                            </span>
                                            <span class="sm:block ml-2">
                                                <a :href="route('logs.show', element.id)">
                                                    <button type="button"
                                                        class="inline-flex items-center px-2 py-2 border border-white text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                        <PencilIcon class="h-5 w-5 text-gray-500" />
                                                    </button>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-4 py-5 sm:p-6">
                                    <ol class="ml-4">
                                        <li v-for="set in element.sets" :key="set.id"><span
                                                v-if="set.weight > 0">Weight: {{ set.weight }}, </span>Reps:
                                            {{ set.reps }}</li>
                                    </ol>
                                </div>
                                -->
                                </li>
                            </template>
                        </draggable>
                    </ul>
                </div>
                <div class="text-center" v-else>
                    <button type="button" @click="this.$refs.searchCommand.openSearch()"
                        class="relative block w-full border-2 border-gray-300 border-dashed rounded-lg p-12 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <LightningBoltIcon class="mx-auto h-12 w-12 text-gray-400" />
                        <span class="mt-2 block text-sm font-medium text-gray-900"> Add exercise </span>
                    </button>
                </div>
            </div>
        </template>
        <template #right>
            <div class="p-6"></div>
        </template>
    </app-layout>
</template>

<script>
    import {
        defineComponent
    } from 'vue'
    import draggable from 'vuedraggable'
    import {
        TrashIcon,
        LightningBoltIcon,
        CollectionIcon,
        ScaleIcon,
        HashtagIcon
    } from '@heroicons/vue/outline'
    import {
        Inertia
    } from '@inertiajs/inertia'
    import AppLayout from '@/Layouts/TwoColumnLayout.vue'
    import ShowHeader from '@/Components/Workout/ShowHeader.vue'
    import Search from '@/Components/Search/Search.vue'
    import DeleteAlert from '@/Components/Modal/DeleteAlert.vue'
    import {
        Menu,
        MenuButton,
        MenuItem,
        MenuItems
    } from '@headlessui/vue'
    import {
        CodeIcon,
        PencilIcon,
        DotsVerticalIcon,
        FlagIcon,
        StarIcon
    } from '@heroicons/vue/solid'

    export default defineComponent({
        components: {
            draggable,
            AppLayout,
            CollectionIcon,
            HashtagIcon,
            ScaleIcon,
            ShowHeader,
            Search,
            PencilIcon,
            TrashIcon,
            DeleteAlert,
            LightningBoltIcon,
            Menu,
            MenuButton,
            MenuItem,
            MenuItems,
            CodeIcon,
            DotsVerticalIcon,
            FlagIcon,
            StarIcon,
        },
        props: ['workout', 'logs'],
        data() {
            return {
                searching: false,
                showDeleting: false,
                modelDeleting: ''
            }
        },
        methods: {
            discard() {
                Inertia.delete(route('workouts.destroy', this.workout.id))
            },
            handleSelected(selected) {
                console.log(selected.id)
                Inertia.post(route('logs.store', {
                    exercise_id: selected.id,
                    workout_id: this.workout.id,
                    order: this.numberOfExercises + 1
                }))
            },
            beginDelete(id) {
                this.showDeleting = true
                this.modelDeleting = id
            },
            handleDelete() {
                console.log('deleting...' + this.modelDeleting)
                Inertia.delete(route('logs.destroy', this.modelDeleting))
                this.showDeleting = false
                this.modelDeleting = ''
            },
            handleCancelDelete() {
                this.showDeleting = false
                this.modelDeleting = ''
            },
            handleDrop(e) {
                const oldIndex = e.oldIndex
                const newIndex = e.newIndex
                console.log({
                    oldIndex,
                    newIndex
                })
                console.log(e)
            },
            numberOfReps(set){
                return _.sumBy(set, 'reps');
            },
            weightVolume(set, unit){
                var volume = 0
                set.forEach(e => {
                    volume += e.reps * e.weight
                });
                if (volume >= 1000) {
                    volume = volume/1000
                    return volume + 'k ' + unit
                } else {
                    return volume + ' ' + unit
                }
            }
        },
        computed: {
            numberOfExercises() {
                return this.logs.length
            }
        }
    })

</script>
