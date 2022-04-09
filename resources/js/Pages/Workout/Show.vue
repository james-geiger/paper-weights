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
                <search ref="searchCommand" @close="searching = !searching" :workout_id="workout.id" :order="numberOfExercises + 1"/>
                <div class="bg-white shadow overflow-hidden rounded-md" v-if="logs.length > 0">
                    <ul role="list" class="divide-y divide-gray-200">
                        <draggable :list="logs" tag="transition-group" handle=".handle" item-key="id" @end="handleDrop">
                            <template #item="{element}">
                                <li class="px-4 py-5 sm:px-6 bg-white divide-y divide-gray-200">
                                    <div class="flex space-x-3">
                                        <div class="min-w-0 flex-1">
                                            <p class="text-lg font-medium text-gray-900 mb-2">
                                                <a :href="route('exercises.show', element.exercise.id)"
                                                    class="hover:underline">{{ element.exercise.name }}</a>
                                            </p>
                                            <div class="inline-flex w-full space-x-6 text-sm text-gray-500">
                                                <span class="inline-flex justify-center items-center">
                                                    <HashtagIcon class="h-4 w-4 mr-2" />
                                                    {{ Math.round(element.sets_sum_sets) }}
                                                </span>
                                                <span class="inline-flex justify-center items-center">
                                                    <CollectionIcon class="h-4 w-4 mr-2" />
                                                    {{ numberOfReps(element.sets)}}
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
                                            <div class="relative z-10 inline-block text-left handle">
                                                    <button type="button" @click="beginDelete(element.id)"
                                                        class="-m-2 p-2 rounded-full flex items-center text-gray-400 hover:text-gray-600">
                                                        <TrashIcon class="h-5 w-5" />
                                                    </button>
                                            </div>
                                            <div class="relative z-10 inline-block text-left handle">
                                                <button type="button"
                                                    class="-m-2 p-2 rounded-full flex items-center text-gray-400 hover:text-gray-600">
                                                    <MenuAlt4Icon class="h-5 w-5" />
                                                </button>
                                            </div>
                                        </div>
                                    </div>
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
            <div class="p-6">
                <div class="pb-5">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Workout Insights</h3>
                </div>
                <div v-for="(group, index) in details" :key="group">
                    <div
                        class="px-3 py-1 border-t border-b border-gray-200 bg-gray-50 text-sm font-medium text-gray-500">
                        <h3>{{ toTitleCase(index) }}</h3>
                    </div>
                    <div class="flow-root">
                        <ul role="list" class="divide-y divide-gray-200">
                            <li v-for="(muscle, index) in group" :key="muscle">
                                <div class="px-3 py-5 relative focus-within:ring-2 focus-within:ring-indigo-500">
                                    <h3 class="text-sm font-semibold text-gray-800">
                                        {{ index }}
                                    </h3>
                                    <div class="mt-1 text-sm text-gray-600 line-clamp-2" v-for="tag in muscle"
                                        :key="tag">
                                        <span>{{ toTitleCase(tag.type) }} Activation:</span>
                                        <ul class="ml-4">
                                            <li>{{ tag.count }} exercises</li>
                                            <li>{{ Number(tag.total_volume)/1000 }}k lbs volume</li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </template>
    </app-layout>
</template>

<script>
    import {
        defineComponent
    } from 'vue'
    import draggable from 'vuedraggable'
    import {
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
        PencilIcon,
        TrashIcon,
        MenuAlt4Icon
    } from '@heroicons/vue/solid'

    const toTitleCase = str => str.replace(/\b\S/g, t => t.toUpperCase());

    export default defineComponent({
        components: {
            draggable,
            AppLayout,
            CollectionIcon,
            HashtagIcon,
            ScaleIcon,
            MenuAlt4Icon,
            PencilIcon,
            TrashIcon,
            LightningBoltIcon,
            ShowHeader,
            Search,
            DeleteAlert,
            Menu,
            MenuButton,
            MenuItem,
            MenuItems,

        },
        props: ['workout', 'logs', 'details'],
        data() {
            return {
                searching: false,
                showDeleting: false,
                modelDeleting: ''
            }
        },
        setup() {
            return {
                toTitleCase
            }
        },
        methods: {
            discard() {
                Inertia.delete(route('workouts.destroy', this.workout.id))
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
                const new_order = this.logs.flatMap((e) => e.id)
                Inertia.patch(route('logs.reorder'), {reordered_logs: new_order})
            },
            numberOfReps(set){
                const reps = _.map(set, (e) => e.sets * e.reps)
                return _.sum(reps)
            },
            weightVolume(set, unit) {
                var volume = 0
                set.forEach(e => {
                    volume += e.sets * e.reps * e.weight
                });
                if (volume >= 1000) {
                    volume = volume / 1000
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
