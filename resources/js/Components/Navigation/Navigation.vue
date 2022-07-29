<!-- This example requires Tailwind CSS v2.0+ -->
<template>
  <Disclosure as="nav" class="bg-indigo-600 dark:bg-gray-800" v-slot="{ open }">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex">
          <div class="flex items-center mr-2 -ml-2 md:hidden">
            <!-- Mobile menu button -->
            <DisclosureButton class="inline-flex items-center justify-center p-2 text-indigo-200 rounded-md hover:text-white hover:bg-indigo-500 hover:bg-opacity-75 dark:hover:bg-opacity-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-indigo-600 dark:focus:ring-inset focus:ring-white">
              <span class="sr-only">Open main menu</span>
              <MenuIcon v-if="!open" class="block w-6 h-6" aria-hidden="true" />
              <XIcon v-else class="block w-6 h-6" aria-hidden="true" />
            </DisclosureButton>
          </div>
          <div class="flex items-center flex-shrink-0">
            <Brandmark></Brandmark>
          </div>
          <div class="hidden md:ml-6 md:flex md:items-center md:space-x-4">
            <Link v-for="item in navigation" :key="item.name" :href="item.href" :class="[item.current ? 'bg-indigo-700 dark:bg-gray-900 text-white' : 'text-white hover:bg-indigo-500 hover:bg-opacity-75 dark:hover:bg-opacity-100 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white', 'px-3 py-2 rounded-md text-sm font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</Link>
          </div>
        </div>
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <button type="button" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-500 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 hover:bg-opacity-75 dark:bg-indigo-500 dark:hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-indigo-500">
              <PlusSmIcon class="w-5 h-5 mr-2 -ml-1" aria-hidden="true" />
              <span>New Workout</span>
            </button>
          </div>
          <div class="hidden md:ml-4 md:flex-shrink-0 md:flex md:items-center">
            <!-- Profile dropdown -->
            <Menu as="div" class="relative ml-3">
              <div>
                <MenuButton class="flex text-sm bg-gray-800 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                  <span class="sr-only">Open user menu</span>
                  <img class="w-8 h-8 rounded-full" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                </MenuButton>
              </div>
              <transition enter-active-class="transition duration-200 ease-out" enter-from-class="transform scale-95 opacity-0" enter-to-class="transform scale-100 opacity-100" leave-active-class="transition duration-75 ease-in" leave-from-class="transform scale-100 opacity-100" leave-to-class="transform scale-95 opacity-0">
                <MenuItems class="absolute right-0 w-48 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                  <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                    <Link :href="item.href" :method="item.method" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">{{ item.name }}</Link>
                  </MenuItem>
                </MenuItems>
              </transition>
            </Menu>
          </div>
        </div>
      </div>
    </div>

    <DisclosurePanel class="md:hidden">
      <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
        <Link v-for="item in navigation" :key="item.name" as="a" :href="item.href" :method="item.method" :class="[item.current ? 'bg-indigo-700 dark:bg-gray-900 text-white' : 'text-white hover:bg-indigo-500 hover:bg-opacity-75 dark:hover:bg-opacity-100 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white', 'block px-3 py-2 rounded-md text-base font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</Link>
      </div>
      <div class="pt-4 pb-3 border-t border-gray-700">
        <div class="flex items-center px-5 sm:px-6">
          <div class="flex-shrink-0">
            <img class="w-10 h-10 rounded-full" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
          </div>
          <div class="ml-3">
            <div class="text-base font-medium text-white">{{ $page.props.user.name }}</div>
            <div class="text-sm font-medium text-indigo-300 dark:text-gray-400">{{ $page.props.user.email }}</div>
          </div>
        </div>
        <div class="px-2 mt-3 space-y-1 sm:px-3">
          <Link v-for="item in userNavigation" :key="item.name" as="a" :href="item.href" :method="item.method" class="block px-3 py-2 text-base font-medium text-white rounded-md hover:bg-indigo-500 hover:bg-opacity-75 dark:hover:bg-opacity-100 dark:text-gray-400 hover:text-white dark:hover:bg-gray-700">{{ item.name }}</Link>
        </div>
      </div>
    </DisclosurePanel>
  </Disclosure>
</template>

<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { BellIcon, MenuIcon, XIcon } from '@heroicons/vue/outline'
import { PlusSmIcon } from '@heroicons/vue/solid'
import { Link } from '@inertiajs/inertia-vue3';
import Brandmark from '@/Components/Brand/Brandmark'

const navigation = [
  { name: 'Workouts', href: route('workouts.list'), current: route().current('workouts.*') || route().current('logs.*') },
  { name: 'Exercises', href: '#', current: false },
]
const userNavigation = [
  { name: 'Your Profile', href: route('profile.show') },
  { name: 'Sign out', href: route('logout'), method: "POST" },
]
</script>