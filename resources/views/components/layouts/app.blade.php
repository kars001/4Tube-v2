<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description"
        content="A dynamic video platform for uploading, streaming, and sharing content. Connect with creators, explore trends, and enjoy seamless viewing!">
    <meta name="keywords"
        content="video platform, streaming, upload videos, share content, watch online, creators, video sharing, trending videos, entertainment, live streaming.">
    <meta name="author" content="Youtube">
    <meta name="robots" content="index, follow">

    <meta property="og:title" content="4Tube">
    <meta property="og:description"
        content="Watch, upload, and share videos effortlessly on our dynamic platform. Connect with creators and explore trending content worldwide!">
    <meta property="og:image" content="">
    <meta property="og:url" content="http://127.0.0.1:8000/">
    <meta property="og:type" content="website">

    <link rel="shortcut icon" href="{{ asset('storage/fav.png') }}" type="image/x-icon">
    <title>@yield('title', '4Tube')</title>
    @vite('resources/css/app.css')
</head>

@php
    $settings = Auth::user()->settings ?? null;
    $theme = $settings->settings['theme'] ?? 'default';
@endphp

<body class="theme-{{ $theme }}">
    <x-toast />

    <div x-data="{
        open: window.innerWidth > 1075,
        isLarge: window.innerWidth > 1075,
        init() {
            const update = () => {
                this.isLarge = window.innerWidth > 1075;
                this.open = this.isLarge ? true : false;
            };
            window.addEventListener('resize', update);
            update();
        }
    }" class="min-h-screen overflow-hidden">
        <nav class="fixed top-0 left-0 right-0 flex items-center justify-between p-2 bg-main z-50 h-16">
            <div class="flex items-center gap-5">
                <button class="cursor-pointer ml-2" @click="open = !open">
                    <x-heroicon-o-bars-3 class="size-7" />
                </button>
                <a class="flex gap-1 relative" href="{{ route('home') }}">
                    {!! file_get_contents(resource_path('views/svg/logo.svg')) !!}
                    {!! file_get_contents(resource_path('views/svg/small-logo.svg')) !!}
                    <span class="hidden sm:block font-bold absolute top-0 right-0 text-primary">v2</span>
                </a>
            </div>

            <form class="items-center hidden sm:flex" action="{{ route('search') }}" method="get">
                <input
                    class="text-base pl-5 pr-4 py-2 rounded-full rounded-r-none sm:w-45 sm:block md:w-80 lg:w-120 bg-121212 border-1 border-third focus:outline-1"
                    type="text" name="query" placeholder="Search" required>
                <button class="rounded-full rounded-l-none px-4 py-2 bg-second border-1 border-third border-l-0"
                    type="submit">
                    <x-heroicon-o-magnifying-glass class="size-6" />
                </button>
            </form>

            <div class="flex items-center gap-0 md:gap-0 lg:gap-8">
                <div x-data="{ openSearch: false }">
                    <button @click="openSearch = true"
                        class="cursor-pointer rounded-full sm:hidden mr-3 px-4 py-2 bg-second border border-third">
                        <x-heroicon-o-magnifying-glass class="size-6" />
                    </button>

                    <div x-show="openSearch" x-transition
                        class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex items-center justify-center p-3">
                        <form class="bg-second rounded-md p-5 pt-4 w-full max-w-lg shadow-lg "
                            action="{{ route('search') }}" method="get">
                            <h2 class="mb-2 text-lg font-bold">Search</h2>
                            <input class="w-full mb-3" type="text" name="query" required />
                            <div class="flex gap-3">
                                <button class="w-full secondary-btn bg-444 hover:bg-input" type="button"
                                    @click="openSearch = false">Cancel</button>
                                <button class="w-full" type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                </div>

                @auth
                    @php
                        $settings = Auth::user()->settings;
                        $username = Auth::user()->name;
                        $profilePicture = $settings->settings['profile_picture'] ?? null;
                    @endphp
                    <a class="rounded-full py-1.5 px-3 lg:pr-4 lg:gap-2 bg-second text-white border-1 border-third flex items-center hover:bg-third"
                        href="{{ route('upload') }}">
                        <x-heroicon-m-plus class="size-7" />
                        <span class="text-[0px] md:text-[0px] lg:text-[16px]">Upload</span>
                    </a>

                    <div class="flex items-center gap-2" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" class="focus:outline-none">
                            <div class="flex items-center gap-3 cursor-pointer">
                                <span class="text-[0px] md:text-[0px] lg:text-[16px]">{{ $username }}</span>
                                @if ($profilePicture)
                                    <img class="w-10 h-10 rounded-full object-cover"
                                        src="https://r2.sob.lol/{{ $profilePicture }}" alt="pfp">
                                @else
                                    <img class="w-10 h-10 rounded-full object-cover"
                                        src="{{ asset('storage/default.png') }}" alt="pfp">
                                @endif
                            </div>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="bg-second py-1 rounded-md absolute top-full right-0 mr-2 w-48 z-50">
                            <a class="w-full block text-left text-white px-4 py-1.5 text-sm/6 hover:bg-121212"
                                href="{{ route('profile', ['name' => $username]) }}">
                                Profile
                            </a>
                            <a class="w-full block text-left text-white px-4 py-1.5 text-sm/6 hover:bg-121212"
                                href="{{ route('settings') }}">
                                Settings
                            </a>
                            <hr class="border-third border-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="w-full bg-second hover:bg-121212 rounded-[0] text-left px-4 font-medium"
                                    type="submit">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a class="hover:bg-second transition duration-200 border-1 border-customgray flex items-center gap-1.5 px-2.5 py-1.5 rounded-full text-white"
                        href="{{ route('register') }}">
                        <x-heroicon-o-user-circle class="size-6" />
                        <span class="text-[13px] font-semibold">Sign in</span>
                    </a>
                @endauth
            </div>
        </nav>

        <div class="flex pt-16 h-full relative">
            <aside class="bg-main overflow-scroll h-full fixed top-16 left-0 flex flex-col pb-16 z-50"
                :class="{
                    'w-55': isLarge,
                    'w-64': !isLarge,
                    'translate-x-0': open
                }"
                x-show="open">
                <div class="flex flex-col p-3">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')" icon="home">
                        Home
                    </x-nav-link>

                    <x-nav-link :href="route('subscriptions')" :active="request()->routeIs('subscriptions')" icon="inbox">
                        Subscriptions
                    </x-nav-link>

                </div>

                <hr class="w-full border-1 border-second">
                @auth
                    <div class="flex flex-col p-3">
                        <a class="text-[18px] text-white font-bold flex items-center gap-2 mb-2 ml-1 hover:text-gray-300"
                            href="{{ route('profile', ['name' => $username]) }}">
                            <span>You</span>
                            <x-heroicon-o-chevron-right class="size-5" />
                        </a>
                        <x-nav-link :href="route('history')" :active="request()->routeIs('history')" icon="clock">
                            History
                        </x-nav-link>

                        <x-nav-link :href="route('manage')" :active="request()->routeIs('manage')" icon="play">
                            Your videos
                        </x-nav-link>

                        <x-nav-link :href="route('liked')" :active="request()->routeIs('liked')" icon="heart">
                            Liked videos
                        </x-nav-link>
                    </div>
                @else
                    <div class="flex flex-col py-4 px-4">
                        <p class="text-sm">Sign in to like videos, comment, and subscribe.</p>
                        <a class="hover:bg-second w-fit mt-3 transition duration-200 border-1 border-customgray flex items-center gap-1.5 px-2.5 py-1.5 rounded-full text-primary"
                            href="{{ route('register') }}">
                            <x-heroicon-o-user-circle class="size-6" />
                            <span class="text-[13px] font-semibold">Sign in</span>
                        </a>
                    </div>
                @endauth
                <hr class="w-full border-1 border-second">

                <div class="flex flex-col p-3">
                    <a class="text-[18px] text-white font-bold mb-2 ml-1">
                        Explore
                    </a>
                    <x-nav-link :href="route('trending')" :active="request()->routeIs('trending')" icon="fire">
                        Trending
                    </x-nav-link>

                    <x-nav-link :href="route('search', ['query' => 'music'])" :active="request()->fullUrlIs(route('search', ['query' => 'music']))" icon="musical-note">
                        Music
                    </x-nav-link>

                    <x-nav-link :href="route('search', ['query' => 'movies'])" :active="request()->fullUrlIs(route('search', ['query' => 'movies']))" icon="film">
                        Movies
                    </x-nav-link>

                    <x-nav-link :href="route('search', ['query' => 'gaming'])" :active="request()->fullUrlIs(route('search', ['query' => 'gaming']))" icon="puzzle-piece">
                        Gaming
                    </x-nav-link>

                    <x-nav-link :href="route('search', ['query' => 'news'])" :active="request()->fullUrlIs(route('search', ['query' => 'news']))" icon="newspaper">
                        News
                    </x-nav-link>

                    <x-nav-link :href="route('search', ['query' => 'sports'])" :active="request()->fullUrlIs(route('search', ['query' => 'sports']))" icon="trophy">
                        Sports
                    </x-nav-link>

                    <x-nav-link :href="route('search', ['query' => 'podcasts'])" :active="request()->fullUrlIs(route('search', ['query' => 'podcasts']))" icon="signal">
                        Podcasts
                    </x-nav-link>
                </div>

                <hr class="w-full border-1 border-second">

                <div class="flex flex-col p-3">
                    <x-nav-link :href="route('settings')" :active="request()->routeIs('settings')" icon="cog-6-tooth">
                        Settings
                    </x-nav-link>

                    <x-nav-link :target="'_blank'" :href="'https://google.com'" icon="question-mark-circle">
                        Help
                    </x-nav-link>

                    <x-nav-link :href="'mailto:174434@student.talland.nl'" icon="chat-bubble-left-ellipsis">
                        Send feedback
                    </x-nav-link>
                </div>

                <hr class="w-full border-1 border-second">

                <p class="text-[13px] text-customgray px-4 py-4">© @php echo(Carbon\Carbon::now()->format('Y')); @endphp 4Tube LLC 4Tube, a 4Tube company
                </p>
            </aside>

            <div x-show="open && !isLarge" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40"
                @click="open = false">
            </div>

            <main class="flex-1 overflow-y-auto p-6 pt-5"
                :class="{
                    'ml-55': isLarge && open,
                    'ml-0': !isLarge || !open
                }">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>
