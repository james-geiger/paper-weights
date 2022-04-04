<template>
    <app-layout title="Exercise Log">
        <template #header>
            <show-header :workout="workout" :log='log' @discard="beginDelete" />
        </template>
        <template #main>
        <div class="px-6 py-6">
        <div class="">
            <div class="border-b border-b-slate-300 pb-6 mb-6">
                <Listbox as="div" v-model="logForm.type" @update:modelValue="beginChangeType" class="z-20">
                    <ListboxLabel class="block text-sm font-medium text-gray-700"> Log Type </ListboxLabel>
                    <div class="mt-1 relative">
                    <ListboxButton class="relative w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <span class="block truncate">{{ logForm.type.name }}</span>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                        <SelectorIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                        </span>
                    </ListboxButton>

                    <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                        <ListboxOptions class="absolute z-20 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                        <ListboxOption as="template" v-for="type in types" :key="type.id" :value="type" v-slot="{ active, selected }">
                            <li :class="[active ? 'text-white bg-indigo-600' : 'text-gray-900', 'cursor-default select-none relative py-2 pl-8 pr-4']">
                            <span :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">
                                {{ type.name }}
                            </span>

                            <span v-if="selected" :class="[active ? 'text-white' : 'text-indigo-600', 'absolute inset-y-0 left-0 flex items-center pl-1.5']">
                                <CheckIcon class="h-5 w-5" aria-hidden="true" />
                            </span>
                            </li>
                        </ListboxOption>
                        </ListboxOptions>
                    </transition>
                    </div>
                </Listbox>
            </div>
            <div class="mt-4">
                <label for="sets" class="block text-sm font-medium text-gray-700">Number of Sets</label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <button type="button" @click="adjustSets(-1)" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-l-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <ChevronDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                    </button>
                    <input type="number" pattern="\d*" v-model="form.sets" name="sets" id="sets" class="-ml-px z-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full rounded-none sm:text-sm border-gray-300 text-center" min=0 />
                    <button type="button" @click="adjustSets(1)" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-r-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <ChevronUpIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                    </button>
                </div>
            </div>
            <div class="mt-4" v-if="visibleColumns.weight">
                <label for="weight" class="block text-sm font-medium text-gray-700">Weight Used</label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <button type="button" @click="adjustWeight(-5)" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-l-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <ChevronDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                    </button>
                    <button type="button" @click="adjustWeight(-10)" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-none text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <span>10</span>
                    </button>
                    <input type="number" pattern="\d*" v-model="form.weight" name="weight" id="weight" class="-ml-px z-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full rounded-none sm:text-sm border-gray-300 text-center" min=0 />
                    <button type="button" @click="adjustWeight(10)" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <span>10</span>
                    </button>
                    <button type="button" @click="adjustWeight(5)" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-r-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <ChevronUpIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                    </button>
                </div>
            </div>
            <div class="mt-4" v-if="visibleColumns.weight_assisted">
                <label for="weight_assisted" class="block text-sm font-medium text-gray-700">Assisted Weight Used</label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <button type="button" @click="adjustWeightAssisted(-5)" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-l-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <ChevronDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                    </button>
                    <button type="button" @click="adjustWeightAssisted(-10)" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-none text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <span>10</span>
                    </button>
                    <input type="number" pattern="\d*" v-model="form.weight_assisted" name="weight_assisted" id="weight_assisted" class="-ml-px z-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full rounded-none sm:text-sm border-gray-300 text-center" min=0 />
                    <button type="button" @click="adjustWeightAssisted(10)" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <span>10</span>
                    </button>
                    <button type="button" @click="adjustWeightAssisted(5)" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-r-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <ChevronUpIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                    </button>
                </div>
            </div>
            <div class="mt-4" v-if="visibleColumns.distance">
                <label for="distance" class="block text-sm font-medium text-gray-700">Distance</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                <input type="number" pattern="\d*" v-model="form.distance" name="distance" id="distance" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pr-12 sm:text-sm border-gray-300 rounded-md" />
                <div class="absolute inset-y-0 right-0 flex items-center">
                    <label for="distance_unit" class="sr-only">Distance Unit</label>
                    <select v-model="form.distance_unit" id="distance_unit" name="distance_unit" class="focus:ring-indigo-500 focus:border-indigo-500 h-full py-0 pl-2 pr-7 border-transparent bg-transparent text-gray-500 sm:text-sm rounded-md">
                        <option selected disabled>unit</option>
                        <option v-for="unit in units" :key="unit.id" :value="unit.id">{{ unit.abbreviation }}</option>
                    </select>
                </div>
                </div>
            </div>
            <div class="mt-4" v-if="visibleColumns.duration">
                <label for="duration" class="block text-sm font-medium text-gray-700">Time</label>
                <div class="flex -space-x-px">
                    <div class="w-1/3 flex-1 min-w-0">
                        <label for="duration_hour" class="sr-only">Hour</label>
                        <input type="number" pattern="\d*" v-model="form.duration_hours" name="duration_hour" id="duration_hour" class="text-center focus:ring-indigo-500 focus:border-indigo-500 relative block w-full rounded-none rounded-l-md bg-transparent focus:z-10 sm:text-sm border-gray-300" placeholder="HH" />
                    </div>
                    <div class="w-1/3 flex-1 min-w-0">
                        <label for="duration_minute" class="sr-only">Minute</label>
                        <input type="number" pattern="\d*" v-model="form.duration_minutes" name="duration_minute" id="duration_minute" class="text-center focus:ring-indigo-500 focus:border-indigo-500 relative block w-full rounded-none bg-transparent focus:z-10 sm:text-sm border-gray-300" placeholder="MM" />
                    </div>
                    <div class="w-1/3 flex-1 min-w-0">
                        <label for="duration_minute" class="sr-only">Second</label>
                        <input type="number" pattern="\d*" v-model="form.duration_seconds" name="duration_second" id="duration_second" class="text-center focus:ring-indigo-500 focus:border-indigo-500 relative block w-full rounded-none rounded-r-md bg-transparent focus:z-10 sm:text-sm border-gray-300" placeholder="SS" />
                    </div>
                </div>
            </div>
            <div class="mt-4" v-if="visibleColumns.reps">
                <label for="reps" class="block text-sm font-medium text-gray-700">Number of Reps</label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <button type="button" @click="adjustReps(-1)" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-l-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <ChevronDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                    </button>
                    <input type="number" pattern="\d*" v-model="form.reps" name="reps" id="reps" class="-ml-px z-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full rounded-none sm:text-sm border-gray-300 text-center" min=0 />
                    <button type="button" @click="adjustReps(1)" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-r-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <ChevronUpIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                    </button>
                </div>
            </div>
            <div class="mt-4">
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
            <div class="mt-4">
                <button type="button" v-on:click="handleAddSet" :disabled="form.processing" class="w-full sm:w-fit inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <RefreshIcon v-if="form.processing" class="ml-auto sm:-ml-1 mr-2 h-5 w-5 animate-spin" aria-hidden="true" />
                    <PlusIcon v-else class="ml-auto sm:-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
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
                        <p class="text-sm">
                            <span class="font-medium text-gray-900 mr-2">{{ set.order }}.</span>
                            <span v-if="set.weight && set.reps">
                                <span class="font-medium text-gray-900 mr-2">{{ Math.round(set.weight) }}<span class="text-gray-500">lbs</span></span>
                                <span class="font-medium text-gray-900">{{ set.sets }}&nbsp;<span class="text-gray-500">x</span>&nbsp;{{ set.reps }}</span>
                            </span>
                            <span v-if="set.weight && set.duration">
                                <span class="font-medium text-gray-900 mr-2">{{ Math.round(set.weight) }}<span class="text-gray-500">lbs</span></span>
                                <span class="font-medium text-gray-900">{{ set.sets }}&nbsp;<span class="text-gray-500">x</span>&nbsp;{{ set.human_readable_duration }}</span>
                            </span>
                            <span v-if="set.duration && set.distance">
                                <span class="font-medium text-gray-900 mr-1">{{ set.sets }}&nbsp;<span class="text-gray-500">x</span></span>
                                <span class="font-medium text-gray-900 mr-2">{{ set.distance }}&nbsp;<span class="text-gray-500">{{ set.unit.abbreviation }}</span></span>
                                <span class="font-medium text-gray-900">{{ set.human_readable_duration }}</span>
                            </span>
                        </p>
                    </div>
                </li>
            </ul>
        </div>
        <delete-alert :open="showDeleting" message="Are you sure you want to remove this exercise and its associated sets from this workout?" title="Delete Exercise" @delete="handleDelete" @cancel="handleCancelDelete"/>
        <warning-alert :open="showWarning" message="Are you sure you want to change the type of loging being used for this exercise? Any sets you've logged for this workout will be removed." title="Change Logging Type" @confirm="handleChangeType" @cancel="handleCancelChangeType"/>
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
    import { PencilIcon, TrashIcon, PlusIcon } from '@heroicons/vue/outline'
    import { ChevronUpIcon, ChevronDownIcon, RefreshIcon, CheckIcon, SelectorIcon } from '@heroicons/vue/solid'
    import { Inertia } from '@inertiajs/inertia'
    import { useForm } from '@inertiajs/inertia-vue3'
    import { defineComponent, ref, reactive, computed, onMounted, watch } from 'vue'
    import { Switch, SwitchGroup, SwitchLabel, Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions } from '@headlessui/vue'
    import AppLayout from '@/Layouts/TwoColumnLayout.vue'
    import ShowHeader from '@/Components/Log/ShowHeader.vue'
    import Search from '@/Components/Search/Search.vue'
    import DeleteAlert from '@/Components/Modal/DeleteAlert.vue'
    import WarningAlert from '@/Components/Modal/WarningAlert.vue'

    export default defineComponent({
        props: ['workout', 'log', 'last_log', 'modifiers', 'units', 'types'],
        components: {
            AppLayout,
            ShowHeader,
            Search,
            PencilIcon,
            TrashIcon,
            DeleteAlert,
            WarningAlert,
            PlusIcon,
            ChevronUpIcon,
            ChevronDownIcon,
            RefreshIcon,
            CheckIcon,
            SelectorIcon,
            Switch,
            SwitchGroup,
            SwitchLabel,
            Listbox,
            ListboxButton,
            ListboxLabel,
            ListboxOption,
            ListboxOptions
        },
        setup (props) {
            const showDeleting = ref(false)
            const showWarning = ref(false)
            const modelDeleting = ref('')
            const mods = reactive({ selected: {} })
            const visibleColumns = reactive({})
            const numberOfSets = computed(() => props.log.sets.length )

            const form = useForm({
                log_id: props.log.id,
                sets: 1,
                reps: null,
                weight: null,
                weight_assisted: null,
                duration_hours: null,
                duration_minutes: null,
                duration_seconds: null,
                distance: null,
                distance_unit: undefined
            })

            const logForm = useForm({
                type: props.log.type
            })

            const handleAddSet = () => {
                form.transform((data) => ({
                    ...data,
                    order: numberOfSets.value + 1
                })).post(route('sets.store', {
                    preserveScroll: true
                }))
            }

            const onSelect = (id) => {
                Inertia.put(route('logs.update', props.log.id), { modifier_id: id })
            }

            const adjustSets = (n) => ((form.sets + n < 1) ? form.sets = 1 : form.sets += n)

            const adjustReps = (n) => ((form.reps + n < 1) ? form.reps = 1 : form.reps += n)

            const adjustWeight = (n) => ((form.weight + n < 0) ? form.weight = 0 : form.weight += n)

            const adjustWeightAssisted = (n) => ((form.weight_assisted + n < 0) ? form.weight_assisted = 0 : form.weight_assisted += n)

            const beginChangeType = () => (showWarning.value = true)

            const handleChangeType = () => {
                logForm.patch(route('logs.update.type', props.log.id), {
                    onSuccess: ()=> {
                        updateVisibleColumns()
                        showWarning.value = false
                    }
                })
            }

            const handleCancelChangeType = () => (showWarning.value = true)


            const beginDelete = () => {
                showDeleting.value = true,
                modelDeleting.value = props.log.id
            }

            const handleDelete = () => {
                Inertia.delete(route('logs.destroy', modelDeleting.value ))
            }

            const handleCancelDelete = () => {
                showDeleting.value = false,
                modelDeleting.value = ''
            }

            const updateVisibleColumns = () => {
                props.log.type.columns.forEach((e) => { visibleColumns[e.column_name]= e.active })
            }

            onMounted(() => {
                props.log.modifiers.forEach(e => {
                    mods.selected[e.id] = true
                });
                updateVisibleColumns();
            });

            return {
                showDeleting,
                showWarning,
                modelDeleting,
                mods,
                form,
                logForm,
                numberOfSets,
                visibleColumns,
                beginChangeType,
                handleChangeType,
                handleCancelChangeType,
                onSelect,
                handleAddSet,
                adjustSets,
                adjustReps,
                adjustWeight,
                adjustWeightAssisted,
                beginDelete,
                handleDelete,
                handleCancelDelete,
                updateVisibleColumns
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
