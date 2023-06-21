<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="node_modules/@material-tailwind/html@latest/scripts/dismissible.js"></script>
        <script src="node_modules/@material-tailwind/html@latest/scripts/ripple.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/@flowbite/components@1.0.0/dist/css/flowbite.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/t-datepicker@latest/dist/css/t-datepicker.min.css">
        <script type="module" src="node_modules/@material-tailwind/html@latest/scripts/popover.js"></script>
        <script type="module" src="node_modules/@material-tailwind/html@latest/scripts/tooltip.js"></script>
   


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body>
        <header>
            <!-- Page Content -->
            <main>
            <nav class="sticky inset-0 z-10 block h-max w-full max-w-full rounded-none border border-white/80 bg-white bg-opacity-80 py-2 px-4 text-white shadow-md backdrop-blur-2xl backdrop-saturate-200 lg:px-8 lg:py-4">
    
        <div class="flex items-center text-gray-900">
        
        <a href="{{ route('mcerts.home') }}" class="flex items-center">
        <img src="/images/bayambang.png" alt="Logo" class="mr-4 h-10 w-10">
        <span class="block cursor-pointer py-1.5 font-sans text-base font-medium leading-relaxed text-inherit antialiased">
            Local Civil Registry
        </span>
        </a>


        <ul class="ml-auto mr-8 hidden items-center gap-6 lg:flex">

        <div class="relative inline-block text-left" x-data="{ isOpen: false }">
                    <button type="button" class="block p-1 font-sans text-sm font-normal leading-normal text-inherit antialiased" id="dropdown-menu-button" aria-expanded="false" aria-haspopup="true" @click="isOpen = !isOpen">
                        Manage Certificate
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" stroke="currentColor" aria-hidden="true" class="inline-block h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>

                    </button>
                    <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5" role="menu" aria-orientation="vertical" aria-labelledby="dropdown-menu-button" tabindex="-1" x-show="isOpen" @click.away="isOpen = false">
                        <div class="py-1" role="none">
                            <a href="{{ route('mcerts.index_file') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" tabindex="-1" id="dropdown-menu-item-1">Marriage Certificate</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" tabindex="-1" id="dropdown-menu-item-2">Birth Certificate</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" tabindex="-1" id="dropdown-menu-item-3">Death Certificate</a>
                        </div>
                    </div>
                    </div>


        @if(request()->routeIs(['mcerts.search_old_file', 'mcerts.search_new_file', 'mcerts.search_file','generate-recent-report', 'generate-legacy-report', 'mcerts.index_file', 'mcerts.pdf', 'mcerts.show_file', 'mcerts.edit_file', 'mcerts.pdf_new', 'mcerts.index_new_file', 'mcerts.show_new_file', 'mcerts.edit_new_file']))
        <li class="block p-1 font-sans text-sm font-normal leading-normal text-inherit antialiased">
            <a href="{{route('mcerts.index_file')}}">
            <button
            data-ripple-light="true"
            data-tooltip-target="tooltip"
            class="flex items-center">
            Legacy Certificates
            </button>
            <div
            data-tooltip="tooltip"
            class="absolute w-max whitespace-normal break-words rounded-lg border border-blue-gray-50 bg-white p-4 font-sans text-sm font-normal text-blue-gray-500 shadow-lg shadow-blue-gray-500/10 focus:outline-none"
            >
            These are old marriage certficates.
            </div>
            </a>
        </li>

        <!-- <li class="block p-1 font-sans text-sm font-normal leading-normal text-inherit antialiased">
            <a href="{{route('mcerts.index_new_file')}}">
            <button
            data-ripple-light="true"
            data-tooltip-target="tooltip2"
            class="flex items-center">
            New Certificates
            </button>
            <div
            data-tooltip="tooltip2"
            class="absolute w-max whitespace-normal break-words rounded-lg border border-blue-gray-50 bg-white p-4 font-sans text-sm font-normal text-blue-gray-500 shadow-lg shadow-blue-gray-500/10 focus:outline-none"
            >
            These are recent marriage certficates.
            </div>
            </a>
        </li> -->

        @elseif(request()->routeIs(['mcerts.index', 'generate-approved-report','mcerts.index_app_file', 'mcerts.pdf_app', 'mcerts.show_app_file', 'mcerts.edit_app_file']))
        <li class="block p-1 font-sans text-sm font-normal leading-normal text-inherit antialiased">
            <a href="{{route('mcerts.index_app_file')}}">
            <button
            data-ripple-light="true"
            data-tooltip-target="tooltip"
            class="flex items-center">
            Marriage License
            </button>
            <div
            data-tooltip="tooltip"
            class="absolute w-max whitespace-normal break-words rounded-lg border border-blue-gray-50 bg-white p-4 font-sans text-sm font-normal text-blue-gray-500 shadow-lg shadow-blue-gray-500/10 focus:outline-none"
            >
            These are old marriage certficates.
            </div>
            </a>
        </li>
        @endif

        @can('manage-users')
        <li class="block p-1 font-sans text-sm font-normal leading-normal text-inherit antialiased">
            <a href="{{route('manage-users')}}">
            <button
            data-ripple-light="true"
            data-tooltip-target="tooltip"
            class="flex items-center">
            Manage Users
            </button>
            <div
            data-tooltip="tooltip"
            class="absolute w-max whitespace-normal break-words rounded-lg border border-blue-gray-50 bg-white p-4 font-sans text-sm font-normal text-blue-gray-500 shadow-lg shadow-blue-gray-500/10 focus:outline-none"
            >
            These user accounts waiting for approval.
            </div>
            </a>
        </li>
        @endcan
        
       


        <li class="block p-1 font-sans text-sm font-normal leading-normal text-inherit antialiased">
            <a class="flex items-center" href="{{ route('mcerts.index') }}">
            Marriage Application
            </a>
        </li>
        
        
        <li class="flex items-center">
                @if(request()->routeIs(['mcerts.index', 'mcerts.search', 'generate-report']))
                <form action="{{ route('mcerts.search')}}" method="GET">
                @csrf
                <div class="mb">
                    <input
                        type="text"
                        class="relative m-0 block w-full min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-transparent bg-clip-padding px-1.1 py-1.3 text-sm font-normal leading-[1.3] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-900 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-900 dark:placeholder:text-neutral-900 dark:focus:border-primary"
                        name="query"
                        placeholder="Search..."
                    />
                </div>
            </form>

                @elseif(request()->routeIs(['mcerts.index_file', 'mcerts.search_file', 'generate-legacy-report']))
                    <form action="{{ route('mcerts.search_file')}}" method="GET">
                    @csrf
                    <div class="mb">
                        <input
                            type="text"
                            class="relative m-0 block w-full min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-transparent bg-clip-padding px-1.1 py-1.3 text-sm font-normal leading-[1.3] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-900 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-900 dark:placeholder:text-neutral-900 dark:focus:border-primary"
                            name="query"
                            placeholder="Search..."
                        />
                    </div>
                </form>

                @elseif(request()->routeIs(['mcerts.index_new_file', 'mcerts.search_new_file', 'generate-recent-report']))
                    <form action="{{ route('mcerts.search_new_file')}}" method="GET">
                    @csrf
                    <div class="mb">
                        <input
                            type="text"
                            class="relative m-0 block w-full min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-transparent bg-clip-padding px-1.1 py-1.3 text-sm font-normal leading-[1.3] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-900 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-900 dark:placeholder:text-neutral-900 dark:focus:border-primary"
                            name="query"
                            placeholder="Search..."
                        />
                    </div>
                </form>
                @elseif(request()->routeIs(['mcerts.index_app_file', 'mcerts.search_app_file', 'generate-approved-report']))
                    <form action="{{ route('mcerts.search_app_file')}}" method="GET">
                    @csrf
                    <div class="mb">
                        <input
                            type="text"
                            class="relative m-0 block w-full min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-transparent bg-clip-padding px-1.1 py-1.3 text-sm font-normal leading-[1.3] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-900 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-900 dark:placeholder:text-neutral-900 dark:focus:border-primary"
                            name="query"
                            placeholder="Search..."
                        />
                    </div>
                </form>
                @elseif(request()->routeIs(['certs.searchall', 'mcerts.home']))
                    <form action="{{ route('certs.searchall')}}" method="GET">
                    @csrf
                    <div class="mb">
                        <input
                            type="text"
                            class="relative m-0 block w-full min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-transparent bg-clip-padding px-1.1 py-1.3 text-sm font-normal leading-[1.3] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-900 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-900 dark:placeholder:text-neutral-900 dark:focus:border-primary"
                            name="query"
                            placeholder="Search..."
                        />
                    </div>
                </form>

            @endif
        </li>
                        @auth
                           <!-- Manage Account Dropdown -->
                            <div class="ml-3 relative">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                            <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                                <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                            </button>
                                        @else
                                            <span class="inline-flex rounded-md">
                                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                                    {{ Auth::user()->name }}

                                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                    </svg>
                                                </button>
                                            </span>
                                        @endif
                                    </x-slot>

                                    <x-slot name="content">
                                        <!-- Account Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Manage Account') }}
                                        </div>

                                        <x-dropdown-link href="{{ route('profile.show') }}">
                                            {{ __('Profile') }}
                                        </x-dropdown-link>

                                        <div class="border-t border-gray-200"></div>

                                        <!-- Authentication -->
                                        <form method="POST" action="{{ route('logout') }}" x-data>
                                            @csrf

                                            <x-dropdown-link href="{{ route('logout') }}"
                                                    @click.prevent="$root.submit();">
                                                {{ __('Log Out') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        @endauth
        </ul>

    @guest
    <!-- Login -->
    <a href="{{ route('login') }}">
    <button
      class="middle none center mr-3 rounded-lg border border-pink-500 py-3 px-6 font-sans text-xs font-bold uppercase text-pink-500 transition-all hover:opacity-75 focus:ring focus:ring-pink-200 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
      type="button"
      data-ripple-light="true"
    >
      <span>Sign In</span>
    </button>
    </a>

    <!-- Register -->
    <a href="{{ route('register') }}">
    <button
      class="middle none center hidden rounded-lg bg-gradient-to-tr from-pink-600 to-pink-400 py-2 px-4 font-sans text-xs font-bold uppercase text-white shadow-md shadow-pink-500/20 transition-all hover:shadow-lg hover:shadow-pink-500/40 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none lg:inline-block"
      type="button"
      data-ripple-light="true"
    >
      <span>Sign Up</span>
    </button>
    </a>
    @endguest


    
    
  </div>
</nav>
<!-- <div class="mx-auto max-w-screen-md py-12">
  <div class="relative mb-12 flex flex-col overflow-hidden rounded-xl bg-white bg-clip-border text-gray-700 shadow-md">
    <img
      alt="nature"
      class="h-[32rem] w-full object-cover object-center"
      src="https://images.unsplash.com/photo-1485470733090-0aae1788d5af?ixlib=rb-4.0.3&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=2717&amp;q=80"
    />
  </div>
  <h2 class="mb-2 block font-sans text-4xl font-semibold leading-[1.3] tracking-normal text-blue-gray-900 antialiased">
    Local Civil Registry
  </h2>
  <p class="block font-sans text-base font-normal leading-relaxed text-gray-700 antialiased">
    Can you help me out? you will get a lot of free exposure doing this can my
    website be in english?. There is too much white space do less with more,
    so that will be a conversation piece can you rework to make the pizza look
    more delicious other agencies charge much lesser can you make the blue
    bluer?. I think we need to start from scratch can my website be in
    english?, yet make it sexy i'll pay you in a week we don't need to pay
    upfront i hope you understand can you make it stand out more?. Make the
    font bigger can you help me out? you will get a lot of free exposure doing
    this that's going to be a chunk of change other agencies charge much
    lesser. Are you busy this weekend? I have a new project with a tight
    deadline that's going to be a chunk of change. There are more projects
    lined up charge extra the next time.
  </p>
</div> -->
            </main>
            </header>
            @yield('content')
        @stack('modals')

        @livewireScripts
    </body>

    <script src="https://unpkg.com/@material-tailwind/html@latest/scripts/dismissible.js"></script>
    <script src="https://unpkg.com/@material-tailwind/html@latest/scripts/ripple.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@flowbite/components@1.0.0/dist/js/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/t-datepicker@latest"></script>
    <script type="module" src="https://unpkg.com/@material-tailwind/html@latest/scripts/popover.js"></script>
    <script type="module" src="https://unpkg.com/@material-tailwind/html@latest/scripts/tooltip.js"></script>
    



</html>
