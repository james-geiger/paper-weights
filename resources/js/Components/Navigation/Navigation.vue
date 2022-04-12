<template>
    <Disclosure as="nav" class="bg-indigo-600" v-slot="{ open }">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
          <div class="flex items-center">
            <div class="flex-shrink-0">
                <svg class="h-10 w-10" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 500">
                    <path style="fill:#FFFFFF;opacity:0.7" d="M250,0C111.9288,0,0,111.9288,0,250S111.9288,500,250,500,500,388.0712,500,250,388.0712,0,250,0Zm0,456.887C135.9222,456.887,43.113,364.0778,43.113,250S135.9222,43.113,250,43.113,456.887,135.9222,456.887,250,364.0778,456.887,250,456.887Z"/>
                    <path style="fill:#FFFFFF;opacity:0.7" d="M250,86.0487A163.9513,163.9513,0,1,0,413.9513,250,163.9513,163.9513,0,0,0,250,86.0487ZM208.0012,313.6921,172.99,348.7039a15.34,15.34,0,0,1-21.6934-21.6933l35.0117-35.0118a15.34,15.34,0,0,1,21.6933,0h0A15.34,15.34,0,0,1,208.0012,313.6921Zm0-104.1746a15.34,15.34,0,0,1-21.6933,0l-35.0117-35.0117A15.3395,15.3395,0,0,1,172.99,152.8125l35.0117,35.0117A15.34,15.34,0,0,1,208.0012,209.5175ZM250,282.1967A32.1967,32.1967,0,1,1,282.1967,250,32.1967,32.1967,0,0,1,250,282.1967Zm96.6379,66.5071a15.3394,15.3394,0,0,1-21.6933,0l-35.0117-35.0117a15.3395,15.3395,0,0,1,21.6933-21.6933l35.0117,35.0117A15.34,15.34,0,0,1,346.6379,348.7038Zm0-174.1981-35.0116,35.0118a15.34,15.34,0,0,1-21.6933,0h0a15.3394,15.3394,0,0,1,0-21.6933l35.0116-35.0118a15.3395,15.3395,0,1,1,21.6933,21.6933Z"/>
                </svg>
            </div>
            <div class="hidden md:block">
              <div class="ml-10 flex items-baseline space-x-4">
                <a v-for="item in navigation" :key="item.name" :href="item.href" :class="[item.current ? 'bg-indigo-700 text-white' : 'text-white hover:bg-indigo-500 hover:bg-opacity-75', 'px-3 py-2 rounded-md text-sm font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</a>
              </div>
            </div>
          </div>
          <div class="hidden md:block">
            <div class="ml-4 flex items-center md:ml-6">
              <button type="button" class="p-1 bg-indigo-600 rounded-full text-indigo-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-indigo-600 focus:ring-white">
                <span class="sr-only">View notifications</span>
                <BellIcon class="h-6 w-6" aria-hidden="true" />
              </button>

              <!-- Profile dropdown -->
              <Menu as="div" class="ml-3 relative">
                <div>
                  <MenuButton class="max-w-xs bg-indigo-600 rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-indigo-600 focus:ring-white">
                    <span class="sr-only">Open user menu</span>
                    <img class="h-8 w-8 rounded-full" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                  </MenuButton>
                </div>
                <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                  <MenuItems class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                    <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                      <Link :href="item.href" :method="item.method" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">{{ item.name }}</Link>
                    </MenuItem>
                  </MenuItems>
                </transition>
              </Menu>
            </div>
          </div>
          <div class="-mr-2 flex md:hidden">
            <!-- Mobile menu button -->
            <DisclosureButton class="bg-indigo-600 inline-flex items-center justify-center p-2 rounded-md text-indigo-200 hover:text-white hover:bg-indigo-500 hover:bg-opacity-75 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-indigo-600 focus:ring-white">
              <span class="sr-only">Open main menu</span>
              <MenuIcon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
              <XIcon v-else class="block h-6 w-6" aria-hidden="true" />
            </DisclosureButton>
          </div>
        </div>
      </div>

      <DisclosurePanel class="md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
          <DisclosureButton v-for="item in navigation" :key="item.name" as="a" :href="item.href" :class="[item.current ? 'bg-indigo-700 text-white' : 'text-white hover:bg-indigo-500 hover:bg-opacity-75', 'block px-3 py-2 rounded-md text-base font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</DisclosureButton>
        </div>
        <div class="pt-4 pb-3 border-t border-indigo-700">
          <div class="flex items-center px-5">
            <div class="flex-shrink-0">
              <img class="h-10 w-10 rounded-full" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
            </div>
            <div class="ml-3">
              <div class="text-base font-medium text-white">{{ $page.props.user.name }}</div>
              <div class="text-sm font-medium text-indigo-300">{{ $page.props.user.email }}</div>
            </div>
            <button type="button" class="ml-auto bg-indigo-600 flex-shrink-0 p-1 rounded-full text-indigo-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-indigo-600 focus:ring-white">
              <span class="sr-only">View notifications</span>
              <BellIcon class="h-6 w-6" aria-hidden="true" />
            </button>
          </div>
          <div class="mt-3 px-2 space-y-1">
            <Link v-for="item in userNavigation" :key="item.name" as="a" :href="item.href" :method="item.method" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-indigo-500 hover:bg-opacity-75">{{ item.name }}</Link>
          </div>
        </div>
      </DisclosurePanel>
    </Disclosure>
</template>

<script>
import { defineComponent } from 'vue'
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { BellIcon, MenuIcon, XIcon } from '@heroicons/vue/outline'
import { Link } from '@inertiajs/inertia-vue3';

const navigation = [
  { name: 'Workouts', href: route('workouts.list'), current: route().current('workouts.*') || route().current('logs.*') },
  { name: 'Exercises', href: '#', current: false },
  { name: 'Plans', href: route('plans.list'), current: route().current('plans.*') }
]
const userNavigation = [
  { name: 'Your Profile', href: route('profile.show') },
  { name: 'Sign out', href: route('logout'), method: "POST" },
]

export default defineComponent({
    components: {
        Link,
        Disclosure,
        DisclosureButton,
        DisclosurePanel,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        BellIcon,
        MenuIcon,
        XIcon,
    },
    setup() {
        return {
            navigation,
            userNavigation,
        }
    }
})
</script>
