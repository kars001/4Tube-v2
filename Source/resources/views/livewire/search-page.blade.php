@section('title', '4Tube - ' . e(request('query')))

<div class="flex flex-col gap-3">
    @foreach ($userResults as $user)
        @php
            $settings = $user->settings;
            $profilePicture = $settings->settings['profile_picture'] ?? null;
        @endphp
        <a class="my-3 flex items-center gap-5 sm:gap-15" href="{{ route('profile', ['name' => $user->name]) }}">

            @if ($profilePicture)
                <img src="https://r2.sob.lol/{{ $profilePicture }}"
                    class="w-20 h-20 sm:w-30 sm:h-30 rounded-full object-cover">
            @else
                <img src="{{ asset('storage/default.png') }}" class="w-20 h-20 sm:w-30 sm:h-30 rounded-full object-cover">
            @endif

            <div class="flex flex-col sm:flex-row sm:items-center justify-between w-full gap-2">
                <div class="flex flex-col gap-1">
                    <h2 class="font-bold text-2xl text-white">{{ $user->name }}</h2>
                    <p class="text-gray-400 text-[13px]">
                        @if ($subscriberCount[$user->id] == 1)
                            {{ formatCount($subscriberCount[$user->id] ?? 0) }} subscriber
                        @else
                            {{ formatCount($subscriberCount[$user->id] ?? 0) }} subscribers
                        @endif
                    </p>
                    <p class="text-gray-400 text-[13px] hidden md:block">
                        {!! Str::limit(e($settings->settings['description'] ?? null), 100) !!}
                    </p>
                </div>
                <form wire:submit.prevent="subscribe({{ $user->id }})">
                    <x-subscribebtn :origin="$user['id']" :isSubscribed="$isSubscribed[$user->id] ?? false" />
                </form>
            </div>
        </a>
    @endforeach

    @foreach ($videoResults as $video)
        <x-video-card :video="$video" :size="'small'" />
    @endforeach

    @if ($videoResults->isEmpty() && $userResults->isEmpty())
        <div class="flex flex-col items-center justify-center w-full h-full">
            <h1 class="text-2xl font-bold">No results found</h1>
            <p class="mt-2 text-gray-300">Try different keywords or check your spelling.</p>
        </div>
    @endif
</div>
