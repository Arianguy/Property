<nav x-data="{
    open: false,
    settingsOpen: false,
    timer: null,

    handleMouseEnter() {
        if (this.timer) clearTimeout(this.timer);
        this.settingsOpen = true;
    },

    handleMouseLeave() {
        this.timer = setTimeout(() => {
            this.settingsOpen = false;
        }, 200);
    }
}"
class="bg-white border-gray-200 dark:bg-gray-900">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
            <x-application-logo class="h-8 w-auto fill-current text-gray-800 dark:text-gray-200" />
            {{-- <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">{{ config('app.name') }}</span> --}}
        </a>

        <div class="flex items-center md:order-2">
            <!-- User Menu Button -->
            <button type="button" class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown">
                <span class="sr-only">Open user menu</span>
                <div class="w-8 h-8 rounded-full bg-gray-500 flex items-center justify-center text-white">
                    {{ Auth::user()->name[0] }}
                </div>
            </button>
            <!-- User Dropdown -->
            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown">
                <div class="px-4 py-3">
                    <span class="block text-sm text-gray-900 dark:text-white">{{ Auth::user()->name }}</span>
                    <span class="block text-sm text-gray-500 truncate dark:text-gray-400">{{ Auth::user()->email }}</span>
                </div>
                <ul class="py-2">
                    <li>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                            {{ __('Profile') }}
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                {{ __('Log Out') }}
                            </a>
                        </form>
                    </li>
                </ul>
            </div>
            <!-- Mobile menu button -->
            <button @click="open = !open" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>
        </div>

        <div :class="{'block': open, 'hidden': !open}" class="items-center justify-between w-full md:flex md:w-auto md:order-1">
            <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                <li>
                    <a href="{{ route('dashboard') }}" class="block py-2 px-3 {{ request()->routeIs('dashboard') ? 'text-blue-700 dark:text-blue-500' : 'text-gray-900 dark:text-white' }} rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0">
                        {{ __('Dashboard') }}
                    </a>
                </li>

                <!-- NEW: Add this Transaction menu here -->
@canany(['view property', 'add property', 'edit property', 'delete property', 'manage property'])
<li class="relative" x-data="{ transOpen: false, propOpen: false }">
    <button
        @click="transOpen = !transOpen"
        @click.away="transOpen = false; propOpen = false"
        class="flex items-center py-2 px-3 text-gray-900 dark:text-white rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0"
    >
        {{ __('Transactions') }}
        <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
        </svg>
    </button>

    <!-- Transactions Dropdown -->
    <div
        x-show="transOpen"
        class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 z-50"
    >
        <div class="relative">
                @can('view property')
                <a href="{{ route('properties.index') }}"
                class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 flex items-center justify-between"
                >
                    {{ __('Property') }}
                </a>
                @endcan

                @can('view tenants')
                <a href="{{ route('tenants.index') }}"
                class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 flex items-center justify-between"
                >
                    {{ __('Tenant') }}
                </a>
                @endcan

                @can('view contracts')
                <a href="{{ route('contracts.index') }}"
                class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 flex items-center justify-between"
                >
                    {{ __('Contracts') }}
                </a>
                @endcan

           <button
                @mouseenter="propOpen = true"
                class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 flex items-center justify-between relative"
            >
                {{ __('Receipts') }}
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
            </button>
            <div
                x-show="propOpen"
                @mouseleave="propOpen = false"
                class="absolute left-full top-0 mt-2 ml-2 rounded-md shadow-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5"
            >
                @can('view property')
                <a href="{{ route('properties.index') }}"
                   class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                    {{ __('Cash') }}
                </a>
                @endcan

                @can('create property')  <!-- This is the correct permission name from your seeder -->
                <a href="{{ route('properties.create') }}"
                   class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                    {{ __('Cheques') }}
                </a>
                @endcan

                {{-- @can('edit property')
                <a href="{{ route('properties.edit.search') }}"
                   class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                    {{ __('Update') }}
                </a>
                @endcan --}}
            </div>
        </div>
    </div>
</li>
@endcanany

                @if(auth()->user()->hasRole('Super Admin'))
                    <li class="relative" x-on:mouseenter="handleMouseEnter()" x-on:mouseleave="handleMouseLeave()">
                        <button
                            @click="settingsOpen = !settingsOpen"
                            class="flex items-center py-2 px-3 text-gray-900 dark:text-white rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0"
                            :aria-expanded="settingsOpen"
                        >
                            {{ __('Settings') }}
                            <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        <div
                            x-show="settingsOpen"
                            x-on:mouseenter="handleMouseEnter()"
                            x-on:mouseleave="handleMouseLeave()"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5"
                            style="display: none;"
                        >
                            <div class="py-1">
                                <a href="{{ route('admin.users.index') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                    {{ __('Users') }}
                                </a>
                                <a href="{{ route('admin.roles.index') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                    {{ __('Roles') }}
                                </a>
                                <a href="{{ route('admin.permissions.index') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                    {{ __('Permissions') }}
                                </a>
                            </div>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
