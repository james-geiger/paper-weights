<template>
    <app-layout title="Exercise Log">
        <template #header>
            <show-header :workout="workout" :log='log' @discard="beginDelete" :pagination="pagination" />
        </template>
        <template #main class="overflow-visible">
        <div class="px-4 py-6">
        <div class="">
            <div class="pb-6 mb-6 border-b border-b-slate-300">
                <Listbox as="div" v-model="logForm.type" @update:modelValue="beginChangeType" class="z-20">
                    <ListboxLabel class="block text-sm font-medium text-gray-700"> Log Type </ListboxLabel>
                    <div class="relative mt-1">
                    <ListboxButton class="relative w-full py-2 pl-3 pr-10 text-left bg-white border border-gray-300 rounded-md shadow-sm cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <span class="block truncate">{{ logForm.type.name }}</span>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                        <SelectorIcon class="w-5 h-5 text-gray-400" aria-hidden="true" />
                        </span>
                    </ListboxButton>

                    <transition leave-active-class="transition duration-100 ease-in" leave-from-class="opacity-100" leave-to-class="opacity-0">
                        <ListboxOptions class="absolute z-20 w-full py-1 mt-1 overflow-auto text-base bg-white rounded-md shadow-lg max-h-60 ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                        <ListboxOption as="template" v-for="type in types" :key="type.id" :value="type" v-slot="{ active, selected }">
                            <li :class="[active ? 'text-white bg-indigo-600' : 'text-gray-900', 'cursor-default select-none relative py-2 pl-8 pr-4']">
                            <span :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">
                                {{ type.name }}
                            </span>

                            <span v-if="selected" :class="[active ? 'text-white' : 'text-indigo-600', 'absolute inset-y-0 left-0 flex items-center pl-1.5']">
                                <CheckIcon class="w-5 h-5" aria-hidden="true" />
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
                <div class="flex mt-1 rounded-md shadow-sm">
                    <button type="button" @click="adjustSets(-1)" class="relative inline-flex items-center px-4 py-2 -ml-px space-x-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-l-md bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <ChevronDownIcon class="w-5 h-5 text-gray-400" aria-hidden="true" />
                    </button>
                    <input type="number" pattern="\d*" v-model="form.sets" name="sets" id="sets" class="z-10 block w-full -ml-px text-center border-gray-300 rounded-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" min=0 />
                    <button type="button" @click="adjustSets(1)" class="relative inline-flex items-center px-4 py-2 -ml-px space-x-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-r-md bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <ChevronUpIcon class="w-5 h-5 text-gray-400" aria-hidden="true" />
                    </button>
                </div>
            </div>
            <div class="mt-4" v-if="visibleColumns.weight">
                <label for="weight" class="block text-sm font-medium text-gray-700">Weight Used</label>
                <div class="flex mt-1 rounded-md shadow-sm">
                    <button type="button" @click="adjustWeight(-5)" class="relative inline-flex items-center px-4 py-2 -ml-px space-x-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-l-md bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <ChevronDownIcon class="w-5 h-5 text-gray-400" aria-hidden="true" />
                    </button>
                    <button type="button" @click="adjustWeight(-10)" class="relative inline-flex items-center px-4 py-2 -ml-px space-x-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-none bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <span>10</span>
                    </button>
                    <input type="number" pattern="\d*" v-model="form.weight" name="weight" id="weight" class="z-10 block w-full -ml-px text-center border-gray-300 rounded-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" min=0 />
                    <button type="button" @click="adjustWeight(10)" class="relative inline-flex items-center px-4 py-2 -ml-px space-x-2 text-sm font-medium text-gray-700 border border-gray-300 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <span>10</span>
                    </button>
                    <button type="button" @click="adjustWeight(5)" class="relative inline-flex items-center px-4 py-2 -ml-px space-x-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-r-md bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <ChevronUpIcon class="w-5 h-5 text-gray-400" aria-hidden="true" />
                    </button>
                </div>
            </div>
            <div class="mt-4" v-if="visibleColumns.weight_added">
                <label for="weight_added" class="block text-sm font-medium text-gray-700">Additional Weight Used</label>
                <div class="flex mt-1 rounded-md shadow-sm">
                    <button type="button" @click="adjustWeightAdded(-5)" class="relative inline-flex items-center px-4 py-2 -ml-px space-x-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-l-md bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <ChevronDownIcon class="w-5 h-5 text-gray-400" aria-hidden="true" />
                    </button>
                    <button type="button" @click="adjustWeightAdded(-10)" class="relative inline-flex items-center px-4 py-2 -ml-px space-x-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-none bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <span>10</span>
                    </button>
                    <input type="number" pattern="\d*" v-model="form.weight_added" name="weight_added" id="weight_added" class="z-10 block w-full -ml-px text-center border-gray-300 rounded-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" min=0 />
                    <button type="button" @click="adjustWeightAdded(10)" class="relative inline-flex items-center px-4 py-2 -ml-px space-x-2 text-sm font-medium text-gray-700 border border-gray-300 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <span>10</span>
                    </button>
                    <button type="button" @click="adjustWeightAdded(5)" class="relative inline-flex items-center px-4 py-2 -ml-px space-x-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-r-md bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <ChevronUpIcon class="w-5 h-5 text-gray-400" aria-hidden="true" />
                    </button>
                </div>
            </div>
            <div class="mt-4" v-if="visibleColumns.weight_assisted">
                <label for="weight_assisted" class="block text-sm font-medium text-gray-700">Assisted Weight Used</label>
                <div class="flex mt-1 rounded-md shadow-sm">
                    <button type="button" @click="adjustWeightAssisted(-5)" class="relative inline-flex items-center px-4 py-2 -ml-px space-x-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-l-md bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <ChevronDownIcon class="w-5 h-5 text-gray-400" aria-hidden="true" />
                    </button>
                    <button type="button" @click="adjustWeightAssisted(-10)" class="relative inline-flex items-center px-4 py-2 -ml-px space-x-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-none bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <span>10</span>
                    </button>
                    <input type="number" pattern="\d*" v-model="form.weight_assisted" name="weight_assisted" id="weight_assisted" class="z-10 block w-full -ml-px text-center border-gray-300 rounded-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" min=0 />
                    <button type="button" @click="adjustWeightAssisted(10)" class="relative inline-flex items-center px-4 py-2 -ml-px space-x-2 text-sm font-medium text-gray-700 border border-gray-300 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <span>10</span>
                    </button>
                    <button type="button" @click="adjustWeightAssisted(5)" class="relative inline-flex items-center px-4 py-2 -ml-px space-x-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-r-md bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <ChevronUpIcon class="w-5 h-5 text-gray-400" aria-hidden="true" />
                    </button>
                </div>
            </div>
            <div class="mt-4" v-if="visibleColumns.distance">
                <label for="distance" class="block text-sm font-medium text-gray-700">Distance</label>
                <div class="relative mt-1 rounded-md shadow-sm">
                <input type="number" pattern="\d*" v-model="form.distance" name="distance" id="distance" class="block w-full pr-12 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                <div class="absolute inset-y-0 right-0 flex items-center">
                    <label for="distance_unit" class="sr-only">Distance Unit</label>
                    <select v-model="form.distance_unit" id="distance_unit" name="distance_unit" class="h-full py-0 pl-2 text-gray-500 bg-transparent border-transparent rounded-md focus:ring-indigo-500 focus:border-indigo-500 pr-7 sm:text-sm">
                        <option disabled :value="undefined">unit</option>
                        <option v-for="unit in units" :key="unit.id" :value="unit.id">{{ unit.name }}</option>
                    </select>
                </div>
                </div>
            </div>
            <div class="mt-4" v-if="visibleColumns.duration">
                <label for="duration" class="block text-sm font-medium text-gray-700">Time</label>
                <div class="flex -space-x-px">
                    <div class="flex-1 w-1/3 min-w-0">
                        <label for="duration_hour" class="sr-only">Hour</label>
                        <input type="number" pattern="\d*" v-model="form.duration_hours" name="duration_hour" id="duration_hour" class="relative block w-full text-center bg-transparent border-gray-300 rounded-none focus:ring-indigo-500 focus:border-indigo-500 rounded-l-md focus:z-10 sm:text-sm" placeholder="HH" />
                    </div>
                    <div class="flex-1 w-1/3 min-w-0">
                        <label for="duration_minute" class="sr-only">Minute</label>
                        <input type="number" pattern="\d*" v-model="form.duration_minutes" name="duration_minute" id="duration_minute" class="relative block w-full text-center bg-transparent border-gray-300 rounded-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="MM" />
                    </div>
                    <div class="flex-1 w-1/3 min-w-0">
                        <label for="duration_minute" class="sr-only">Second</label>
                        <input type="number" pattern="\d*" v-model="form.duration_seconds" name="duration_second" id="duration_second" class="relative block w-full text-center bg-transparent border-gray-300 rounded-none focus:ring-indigo-500 focus:border-indigo-500 rounded-r-md focus:z-10 sm:text-sm" placeholder="SS" />
                    </div>
                </div>
            </div>
            <div class="mt-4" v-if="visibleColumns.reps">
                <label for="reps" class="block text-sm font-medium text-gray-700">Number of Reps</label>
                <div class="flex mt-1 rounded-md shadow-sm">
                    <button type="button" @click="adjustReps(-1)" class="relative inline-flex items-center px-4 py-2 -ml-px space-x-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-l-md bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <ChevronDownIcon class="w-5 h-5 text-gray-400" aria-hidden="true" />
                    </button>
                    <input type="number" pattern="\d*" v-model="form.reps" name="reps" id="reps" class="z-10 block w-full -ml-px text-center border-gray-300 rounded-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" min=0 />
                    <button type="button" @click="adjustReps(1)" class="relative inline-flex items-center px-4 py-2 -ml-px space-x-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-r-md bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <ChevronUpIcon class="w-5 h-5 text-gray-400" aria-hidden="true" />
                    </button>
                </div>
            </div>
            <div class="mt-4">
                <label for="modifiers" class="block text-sm font-medium text-gray-700">Modifiers</label>
                <div v-for="modifier in modifiers" :key="modifier.id" class="mt-2">
                    <SwitchGroup as="div" class="flex items-center justify-start">
                        <Switch v-model="mods.selected[modifier.id]" @update:modelValue="onSelect(modifier.id, $event)" class="relative inline-flex items-center justify-center flex-shrink-0 w-10 h-5 rounded-full cursor-pointer group focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span class="sr-only">Use setting</span>
                            <span aria-hidden="true" class="absolute w-full h-full bg-white rounded-md pointer-events-none" />
                            <span aria-hidden="true" :class="[mods.selected[modifier.id] ? 'bg-indigo-600' : 'bg-gray-200', 'pointer-events-none absolute h-4 w-9 mx-auto rounded-full transition-colors ease-in-out duration-200']" />
                            <span aria-hidden="true" :class="[mods.selected[modifier.id] ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none absolute left-0 inline-block h-5 w-5 border border-gray-200 rounded-full bg-white shadow transform ring-0 transition-transform ease-in-out duration-200']" />
                        </Switch>
                        <SwitchLabel as="span" class="ml-2 text-sm font-medium text-gray-900">{{ modifier.name }}</SwitchLabel>
                    </SwitchGroup>
                </div>
            </div>
            <div class="mt-4">
                <button type="button" v-on:click="handleAddSet" :disabled="form.processing" class="inline-flex items-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm sm:w-fit hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <RefreshIcon v-if="form.processing" class="w-5 h-5 ml-auto mr-2 sm:-ml-1 animate-spin" aria-hidden="true" />
                    <PlusIcon v-else class="w-5 h-5 ml-auto mr-2 sm:-ml-1" aria-hidden="true" />
                    <span class="mr-auto">Add Set</span>
                </button>
            </div>
        </div>
        <delete-alert :open="showDeleting" message="Are you sure you want to remove this exercise and its associated sets from this workout?" title="Delete Exercise" @delete="handleDelete" @cancel="handleCancelDelete"/>
        <warning-alert :open="showWarning" message="Are you sure you want to change the type of loging being used for this exercise? Any sets you've logged for this workout will be removed." title="Change Logging Type" @confirm="handleChangeType" @cancel="handleCancelChangeType"/>
        </div>
        </template>
        <template #right>
            <div class="overflow-hidden bg-white rounded-lg shadow">
                <div class="px-6 py-6">
                    <div class="pb-5 border-b border-gray-200">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Log - This Workout</h3>
                    </div>
                    <ul role="list" class="divide-y divide-gray-200" v-if="log.sets.length > 0">
                <li v-for="set in log.sets" :key="set.id" class="flex justify-between py-4">
                    <div class="ml-3">
                        <!--<p class="mr-2 text-sm text-red-600" v-if="setDeleting == set.id">Are you sure?  Again to delete, or <span class="text-gray-600 underline cursor-pointer" @click="handleCancelSetDelete">cancel.</span></p>-->
                        <p :class="[ setDeleting == set.id ? 'opacity-30 text-sm' : 'text-sm']">
                            <span class="mr-2 font-medium text-gray-900">{{ set.order }}.</span>
                            <span v-if="set.weight && set.reps">
                                <span class="mr-2 font-medium text-gray-900">{{ Math.round(set.weight) }}<span class="text-gray-500">lbs</span></span>
                                <span class="font-medium text-gray-900">{{ set.sets }}&nbsp;<span class="text-gray-500">x</span>&nbsp;{{ set.reps }}</span>
                            </span>
                            <span v-if="set.weight && set.duration">
                                <span class="mr-2 font-medium text-gray-900">{{ Math.round(set.weight) }}<span class="text-gray-500">lbs</span></span>
                                <span class="font-medium text-gray-900">{{ set.sets }}&nbsp;<span class="text-gray-500">x</span>&nbsp;{{ set.human_readable_duration }}</span>
                            </span>
                            <span v-if="set.weight_added && set.reps">
                                <span class="mr-2 font-medium text-gray-900">{{ Math.round(set.weight_added) }}<span class="text-gray-500">lbs (additional)</span></span>
                                <span class="font-medium text-gray-900">{{ set.sets }}&nbsp;<span class="text-gray-500">x</span>&nbsp;{{ set.reps }}</span>
                            </span>
                            <span v-if="set.weight_assisted && set.reps">
                                <span class="mr-2 font-medium text-gray-900">{{ Math.round(set.weight_assisted) }}<span class="text-gray-500">lbs (assisted)</span></span>
                                <span class="font-medium text-gray-900">{{ set.sets }}&nbsp;<span class="text-gray-500">x</span>&nbsp;{{ set.reps }}</span>
                            </span>
                            <span v-if="set.weight && set.distance">
                                <span class="mr-2 font-medium text-gray-900">{{ Math.round(set.weight) }}<span class="text-gray-500">lbs</span></span>
                                <span class="mr-1 font-medium text-gray-900">{{ set.sets }}&nbsp;<span class="text-gray-500">x</span></span>
                                <span class="mr-2 font-medium text-gray-900">{{ set.distance }}&nbsp;<span class="text-gray-500">{{ set.unit.abbreviation }}</span></span>
                                <span class="font-medium text-gray-900">{{ set.human_readable_duration }}</span>
                            </span>
                            <span v-if="set.duration && set.distance">
                                <span class="mr-1 font-medium text-gray-900">{{ set.sets }}&nbsp;<span class="text-gray-500">x</span></span>
                                <span class="mr-2 font-medium text-gray-900">{{ set.distance }}&nbsp;<span class="text-gray-500">{{ set.unit.abbreviation }}</span></span>
                                <span class="font-medium text-gray-900">{{ set.human_readable_duration }}</span>
                            </span>
                        </p>
                    </div>
                    <div class="inline-flex">
                        <span class="mr-4 text-sm text-gray-600 underline cursor-pointer" v-if="setDeleting == set.id" @click="handleCancelSetDelete">Cancel</span>
                        <button type="button" @click="handleSetDelete(set.id)" :class="[ setDeleting == set.id ? 'text-red-400 hover:text-red-600' : 'text-gray-400 hover:text-gray-600', '-m-2 p-2 rounded-full flex items-center']">
                            <TrashIcon class="w-5 h-5" />
                        </button>
                    </div>
                </li>
            </ul>
            <p class="mt-4 text-gray-600" v-else>You haven't logged any sets for this exercise.</p>
                </div>
            </div>
            <div class="mt-6 overflow-hidden bg-white rounded-lg shadow">
            <div class="px-6 py-6">
                <div class="pb-5 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Log - Last Workout</h3>
                </div>
                <ul role="list" class="divide-y divide-gray-200" v-if="last_log.length > 0">
                <li v-for="set in last_log[0].sets" :key="set.id" class="flex py-4">
                <div class="ml-3">
                        <p class="text-sm">
                            <span class="mr-2 font-medium text-gray-900">{{ set.order }}.</span>
                            <span v-if="set.weight && set.reps">
                                <span class="mr-2 font-medium text-gray-900">{{ Math.round(set.weight) }}<span class="text-gray-500">lbs</span></span>
                                <span class="font-medium text-gray-900">{{ set.sets }}&nbsp;<span class="text-gray-500">x</span>&nbsp;{{ set.reps }}</span>
                            </span>
                            <span v-if="set.weight && set.duration">
                                <span class="mr-2 font-medium text-gray-900">{{ Math.round(set.weight) }}<span class="text-gray-500">lbs</span></span>
                                <span class="font-medium text-gray-900">{{ set.sets }}&nbsp;<span class="text-gray-500">x</span>&nbsp;{{ set.human_readable_duration }}</span>
                            </span>
                            <span v-if="set.weight_added && set.reps">
                                <span class="mr-2 font-medium text-gray-900">{{ Math.round(set.weight_added) }}<span class="text-gray-500">lbs (additional)</span></span>
                                <span class="font-medium text-gray-900">{{ set.sets }}&nbsp;<span class="text-gray-500">x</span>&nbsp;{{ set.reps }}</span>
                            </span>
                            <span v-if="set.weight_assisted && set.reps">
                                <span class="mr-2 font-medium text-gray-900">{{ Math.round(set.weight_assisted) }}<span class="text-gray-500">lbs (assisted)</span></span>
                                <span class="font-medium text-gray-900">{{ set.sets }}&nbsp;<span class="text-gray-500">x</span>&nbsp;{{ set.reps }}</span>
                            </span>
                            <span v-if="set.weight && set.distance">
                                <span class="mr-2 font-medium text-gray-900">{{ Math.round(set.weight) }}<span class="text-gray-500">lbs</span></span>
                                <span class="mr-1 font-medium text-gray-900">{{ set.sets }}&nbsp;<span class="text-gray-500">x</span></span>
                                <span class="mr-2 font-medium text-gray-900">{{ set.distance }}&nbsp;<span class="text-gray-500">{{ set.unit.abbreviation }}</span></span>
                                <span class="font-medium text-gray-900">{{ set.human_readable_duration }}</span>
                            </span>
                            <span v-if="set.duration && set.distance">
                                <span class="mr-1 font-medium text-gray-900">{{ set.sets }}&nbsp;<span class="text-gray-500">x</span></span>
                                <span class="mr-2 font-medium text-gray-900">{{ set.distance }}&nbsp;<span class="text-gray-500">{{ set.unit.abbreviation }}</span></span>
                                <span class="font-medium text-gray-900">{{ set.human_readable_duration }}</span>
                            </span>
                        </p>
                    </div>
                </li>
            </ul>
            <p class="mt-4 text-gray-600" v-else>No prior sets have been logged for this exercise.</p>
            </div>
            </div>
            <div class="mt-6 overflow-hidden bg-white rounded-lg shadow">
                <div class="px-6 py-6">
                    <div class="pb-5 border-b border-gray-200">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Intensity Insights</h3>
                    </div>
                    <ul role="list" class="">
                        <li v-for="(value, index) in one_rep_max" :key="index" class="py-4">
                            <div class="flex flex-row ml-3">
                                <p class="text-sm text-gray-900">{{ value }} lbs</p>
                                <p class="text-sm font-medium text-gray-500">&nbsp;-&nbsp;{{ index }}</p>
                            </div>
                        </li>
                    </ul>
                    <!--<p class="mt-4 text-gray-600" v-else>No insights are available for this exercise.</p>-->
                </div>
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
    import { Switch, SwitchGroup, SwitchLabel, Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions, Popover, PopoverButton, PopoverPanel } from '@headlessui/vue'
    import AppLayout from '@/Layouts/TwoColumnLayout.vue'
    import ShowHeader from '@/Components/Log/ShowHeader.vue'
    import DeleteAlert from '@/Components/Modal/DeleteAlert.vue'
    import WarningAlert from '@/Components/Modal/WarningAlert.vue'

    export default defineComponent({
        props: ['workout', 'log', 'pagination', 'last_log', 'modifiers', 'units', 'types', 'one_rep_max'],
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
            ListboxOptions,
            Popover,
            PopoverButton,
            PopoverPanel
        },
        setup (props) {
            const searching = ref(false)
            const showDeleting = ref(false)
            const showWarning = ref(false)
            const setDeleting = ref('')
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
                weight_added: null,
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

            const adjustWeightAdded = (n) => ((form.weight_added + n < 0) ? form.weight_added = 0 : form.weight_added += n)

            const beginChangeType = () => ((numberOfSets.value > 0) ? showWarning.value = true : handleChangeType())

            const handleChangeType = () => {
                logForm.patch(route('logs.update.type', props.log.id), {
                    onSuccess: ()=> {
                        updateVisibleColumns()
                        showWarning.value = false
                        form.sets = 1,
                        form.reps = null,
                        form.weight = null,
                        form.weight_added = null,
                        form.weight_assisted = null,
                        form.duration_hours = null,
                        form.duration_minutes = null,
                        form.duration_seconds = null,
                        form.distance = null,
                        form.distance_unit = undefined
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

            const handleSetDelete = (id) => {
                (setDeleting.value == id) ? Inertia.delete(route('sets.destroy', id)): setDeleting.value = id
            }

            const handleCancelSetDelete = () => setDeleting.value = ''

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
                searching,
                showDeleting,
                showWarning,
                modelDeleting,
                setDeleting,
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
                handleCancelSetDelete,
                adjustSets,
                adjustReps,
                adjustWeight,
                adjustWeightAdded,
                adjustWeightAssisted,
                beginDelete,
                handleDelete,
                handleCancelDelete,
                handleSetDelete,
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
