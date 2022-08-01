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
                <div class="overflow-hidden bg-white rounded-md shadow" v-if="logs.length > 0">
                    <ul role="list" class="divide-y divide-gray-200">
                        <draggable :list="logs" tag="transition-group" handle=".handle" item-key="id" @end="handleDrop">
                            <template #item="{element}">
                                <li class="px-4 py-5 bg-white divide-y divide-gray-200 sm:px-6">
                                    <div class="flex space-x-3">
                                        <div class="flex-1 min-w-0">
                                            <p class="mb-2 text-lg font-medium text-gray-900">
                                                <a :href="route('exercises.show', element.exercise.id)"
                                                    class="hover:underline">{{ element.exercise.name }}</a>
                                            </p>
                                            <div class="inline-flex w-full space-x-6 text-sm text-gray-500">
                                                <span class="inline-flex items-center justify-center">
                                                    <HashtagIcon class="w-4 h-4 mr-2" />
                                                    {{ Math.round(element.sets_sum_sets) }}
                                                </span>
                                                <span class="inline-flex items-center justify-center">
                                                    <CollectionIcon class="w-4 h-4 mr-2" />
                                                    {{ numberOfReps(element.sets)}}
                                                </span>
                                                <span class="inline-flex items-center justify-center">
                                                    <ScaleIcon class="w-4 h-4 mr-2" />
                                                    {{ weightVolume(element.sets, 'lbs') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex self-center flex-shrink-0 space-x-4">
                                            <div class="relative z-10 inline-block text-left">
                                                <a :href="route('logs.show', element.id)">
                                                    <button type="button"
                                                        class="flex items-center p-2 -m-2 text-gray-400 rounded-full hover:text-gray-600">
                                                        <PencilIcon class="w-5 h-5" />
                                                    </button>
                                                </a>
                                            </div>
                                            <div class="relative z-10 inline-block text-left handle">
                                                    <button type="button" @click="beginDelete(element.id)"
                                                        class="flex items-center p-2 -m-2 text-gray-400 rounded-full hover:text-gray-600">
                                                        <TrashIcon class="w-5 h-5" />
                                                    </button>
                                            </div>
                                            <div class="relative z-10 inline-block text-left handle">
                                                <button type="button"
                                                    class="flex items-center p-2 -m-2 text-gray-400 rounded-full hover:text-gray-600">
                                                    <MenuAlt4Icon class="w-5 h-5" />
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
                        class="relative block w-full p-12 text-center border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <LightningBoltIcon class="w-12 h-12 mx-auto text-gray-400" />
                        <span class="block mt-2 text-sm font-medium text-gray-900"> Add exercise </span>
                    </button>
                </div>
            </div>
        </template>
        <template #right>
            <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="p-6">
                <div class="pb-5">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Notes</h3>
                </div>
                <div>
                    <label for="note" class="block text-sm font-medium text-gray-700 sr-only">Add a note</label>
                    <div class="mt-1">
                    <textarea v-model="note_body" rows="6" name="note" id="note" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                    </div>
                </div>
            </div>
            </div>
            <div class="mt-4 overflow-hidden bg-white rounded-lg shadow">
            <div class="p-6">
                <div class="pb-5">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Insights</h3>
                </div>
                <div v-for="(group, index) in details" :key="group">
                    <div
                        class="px-3 py-1 text-sm font-medium text-gray-500 border-t border-b border-gray-200 bg-gray-50">
                        <h3>{{ toTitleCase(index) }}</h3>
                    </div>
                    <div class="flow-root">
                        <ul role="list" class="divide-y divide-gray-200">
                            <li v-for="(muscle, index) in group" :key="muscle">
                                <div class="relative px-3 py-5 focus-within:ring-2 focus-within:ring-indigo-500">
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
            </div>
        </template>
    </app-layout>
</template>

<script setup>
import { ref, watch, computed, provide } from 'vue'
import draggable from 'vuedraggable'
import { LightningBoltIcon, CollectionIcon, ScaleIcon, HashtagIcon } from '@heroicons/vue/outline'
import { Inertia } from '@inertiajs/inertia'
import AppLayout from '@/Layouts/TwoColumnLayout'
import ShowHeader from '@/Components/Workout/ShowHeader'
import Search from '@/Components/Search/Search'
import DeleteAlert from '@/Components/Modal/DeleteAlert'
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { PencilIcon, TrashIcon, MenuAlt4Icon } from '@heroicons/vue/solid'

const props = defineProps(['workout', 'logs', 'details'])

provide(/* key */ 'quickAdd', /* value */ false)

const searching = ref(false)
const showDeleting = ref(false)
const modelDeleting = ref('')
const numberOfExercises = computed(() => {
    return props.logs.length
})

const note_body = (props.workout.note) ? ref(props.workout.note.body) : ref('')

const toTitleCase = str => str.replace(/\b\S/g, t => t.toUpperCase());

const discard = () => {
    Inertia.delete(route('workouts.destroy', props.workout.id))
}

const beginDelete = (id) => {
    showDeleting.value = true
    modelDeleting.value = id
}

const handleDelete = () => {
    console.log('deleting...' + modelDeleting.value)
    Inertia.delete(route('logs.destroy', modelDeleting.value))
    showDeleting.value = false
    modelDeleting.value = ''
}

const handleCancelDelete = () => {
    showDeleting.value = false
    modelDeleting.value = ''
}

const handleDrop = (e) => {
    const oldIndex = e.oldIndex
    const newIndex = e.newIndex
    console.log({
        oldIndex,
        newIndex
    })
    const new_order = props.logs.flatMap((e) => e.id)
    Inertia.patch(route('logs.reorder'), {reordered_logs: new_order})
}

const numberOfReps = (set) => {
    const reps = _.map(set, (e) => e.sets * e.reps)
    return _.sum(reps)
}

const weightVolume = (set, unit) => {
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

watch(note_body, _.debounce((note_body, prev_note_body) => {
    axios.post(route('workouts.note.store', props.workout.id), { body: note_body }).then(response => {
        console.log(response.data)
    })},1300)
)
</script>
