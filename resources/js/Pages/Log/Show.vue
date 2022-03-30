<template>
    <app-layout title="Exercise Log">
        <template #header>
            <show-header :workout="workout" :log='log' @edit="editing = $event" @discard="discard" @showSearch="searching = $event"/>
        </template>
        <template #main>
        <div class="px-6 py-6">
        <div class="">
            <div class="">
                <label for="modifiers" class="block text-sm font-medium text-gray-700">Modifiers</label>
                <div v-for="modifier in modifiers" :key="modifier.id" class="mt-2">
                    <SwitchGroup as="div" class="flex items-center justify-start">
                        <Switch v-model="mods.selected[modifier.id]" @update:modelValue="onSelect(modifier.id, $event)" class="flex-shrink-0 group relative rounded-full inline-flex items-center justify-center h-5 w-10 cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span class="sr-only">Use setting</span>
                            <span aria-hidden="true" class="pointer-events-none absolute bg-white w-full h-full rounded-md" />
                            <span aria-hidden="true" :class="[mods.selected[modifier.id] ? 'bg-indigo-600' : 'bg-gray-200', 'pointer-events-none absolute h-4 w-9 mx-auto rounded-full transition-colors ease-in-out duration-200']" />
                            <span aria-hidden="true" :class="[mods.selected[modifier.id] ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none absolute left-0 inline-block h-5 w-5 border border-gray-200 rounded-full bg-white shadow transform ring-0 transition-transform ease-in-out duration-200']" />
                        </Switch>
                        <SwitchLabel as="span" class="ml-2 text-sm font-medium text-gray-900">{{ modifier.name }}</SwitchLabel>
                    </SwitchGroup>
                </div>
            </div>
            <div class="mt-4" v-if="showWeight">
                <label for="weight" class="block text-sm font-medium text-gray-700">Weight Used</label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <button type="button" @click="decreaseWeight(1)" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-l-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <ChevronDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                    </button>
                    <button type="button" @click="decreaseWeight(5)" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-none text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <span>5</span>
                    </button>
                    <button type="button" @click="decreaseWeight(10)" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-none text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <span>10</span>
                    </button>
                    <input type="number" v-model="weight" name="weight" id="weight" class="-ml-px z-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full rounded-none sm:text-sm border-gray-300 text-center" min=0 />
                    <button type="button" @click="increaseWeight(10)" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <span>10</span>
                    </button>
                    <button type="button" @click="increaseWeight(5)" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-none text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <span>5</span>
                    </button>
                    <button type="button" @click="increaseWeight(1)" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-r-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <ChevronUpIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                    </button>
                </div>
            </div>
            <div class="mt-4">
                <label for="reps" class="block text-sm font-medium text-gray-700">Number of Reps</label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <button type="button" @click="decreaseReps(1)" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-l-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <ChevronDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                    </button>
                    <button type="button" @click="decreaseReps(8)" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-none text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <span>8</span>
                    </button>
                    <button type="button" @click="decreaseReps(10)" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-none text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <span>10</span>
                    </button>
                    <input type="number" v-model="reps" name="reps" id="reps" class="-ml-px z-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full rounded-none sm:text-sm border-gray-300 text-center" min=0 />
                    <button type="button" @click="increaseReps(10)" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <span>10</span>
                    </button>
                    <button type="button" @click="increaseReps(8)" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-none text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <span>8</span>
                    </button>
                    <button type="button" @click="increaseReps(1)" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-r-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <ChevronUpIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                    </button>
                </div>
            </div>
            <div class="mt-4">
                <button type="button" v-on:click="handleAddSet" class="w-full sm:w-fit inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <PlusIcon class="ml-auto sm:-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                    <span class="mr-auto">Add Set</span>
                </button>
            </div>
        </div>
        <div class="mt-6">
            <div class="pb-5 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">This Workout</h3>
            </div>
            <ul role="list" class="divide-y divide-gray-200">
                <li v-for="set in log.sets" :key="set.id" class="py-4 flex">
                <div class="ml-3">
                    <p class="text-sm"><span class="font-medium text-gray-900">{{ Math.round(set.weight) }}</span>&nbsp;<span class="text-gray-500">lbs</span></p>
                    <p class="text-sm"><span class="font-medium text-gray-900">{{ Math.round(set.reps) }}</span>&nbsp;<span class="text-gray-500">Reps</span></p>                </div>
                </li>
            </ul>
        </div>
        <delete-alert :open="showDeleting" message="Are you sure you want to remove this exercise and its associated sets from this workout?" title="Delete Exercise" @delete="handleDelete" @cancel="handleCancelDelete"/>
        </div>
        </template>
        <template #right>
            <div class="px-6 py-6">
                <div class="pb-5 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Past Workout Insights</h3>
                </div>
                <ul role="list" class="divide-y divide-gray-200" v-if="last_log.length > 0">
                <li v-for="set in last_log[0].sets" :key="set.id" class="py-4 flex">
                <div class="ml-3">
                    <p class="text-sm"><span class="font-medium text-gray-900">{{ Math.round(set.weight) }}</span>&nbsp;<span class="text-gray-500">lbs</span></p>
                    <p class="text-sm"><span class="font-medium text-gray-900">{{ Math.round(set.reps) }}</span>&nbsp;<span class="text-gray-500">Reps</span></p>                </div>
                </li>
            </ul>
            <span class="ml-2" v-else>No prior workouts have been logged for this exercise.</span>
            </div>
        </template>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import { PencilIcon, TrashIcon, PlusIcon } from '@heroicons/vue/outline'
    import { PlusSmIcon, MinusSmIcon, ChevronUpIcon, ChevronDownIcon } from '@heroicons/vue/solid'
    import { Inertia } from '@inertiajs/inertia'
    import { Switch, SwitchGroup, SwitchLabel } from '@headlessui/vue'
    import AppLayout from '@/Layouts/TwoColumnLayout.vue'
    import ShowHeader from '@/Components/Log/ShowHeader.vue'
    import Search from '@/Components/Search/Search.vue'
    import DeleteAlert from '@/Components/Modal/DeleteAlert.vue'

    export default defineComponent({
        components: {
            AppLayout,
            ShowHeader,
            Search,
            PencilIcon,
            TrashIcon,
            DeleteAlert,
            PlusIcon,
            PlusSmIcon,
            MinusSmIcon,
            ChevronUpIcon,
            ChevronDownIcon,
            Switch,
            SwitchGroup,
            SwitchLabel
        },
        props: ['workout', 'log', 'last_log', 'modifiers'],
        data(){
            return {
                reps: 0,
                weight: 0,
                editing: false,
                searching: false,
                showDeleting: false,
                modelDeleting: '',
                enabled: false,
                mods: {
                    selected: {}
                }
            }
        },
        mounted(){
            this.$props.log.modifiers.forEach(e => {
                this.mods.selected[e.id] = true
            });
        },
        methods:{
            discard(){
                window.alert('discarding')
            },
            onSelect(id, value){
                Inertia.put(route('logs.update', this.log.id), { modifier_id: id })
            },
            handleAddSet(){
                Inertia.post(route('sets.store', {log_id: this.log.id, order: this.numberOfSets + 1, weight: this.weight, reps: this.reps }))
            },
            beginDelete(id){
                this.showDeleting = true
                this.modelDeleting = id
            },
            handleDelete(){
                console.log('deleting...' + this.modelDeleting)
                Inertia.delete(route('logs.destroy', this.modelDeleting))
                this.showDeleting = false
                this.modelDeleting = ''
            },
            handleCancelDelete(){
                this.showDeleting = false
                this.modelDeleting = ''
            },
            increaseReps(n){
                this.reps = this.reps + n
            },
            decreaseReps(n){
                if (this.reps - n < 0){
                    this.reps = 0
                } else {
                    this.reps = this.reps - n
                }
            },
            increaseWeight(n){
                this.weight = this.weight + n
            },
            decreaseWeight(n){
                if (this.weight - n < 0){
                    this.weight = 0
                } else {
                    this.weight = this.weight - n
                }
            }
        },
        computed: {
            numberOfSets(){
                return this.log.sets.length
            },
            showWeight(){
                return !this.mods.selected['5252eab0-a9a0-11ec-a5d4-2d2b9afa987a']
            }
        }
    })
</script>

<style scoped>
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
</style>
