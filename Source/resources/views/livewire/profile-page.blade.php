@section('title', '4Tube - @' . $user['name'])

<div>
    @if (isset($settings->settings['profile_banner']))
        <img class="w-full h-30 sm:h-50 object-cover mb-5 pointer-events-none"
            src="https://r2.sob.lol/{{ $settings->settings['profile_banner'] }}">
    @endif

    <div class="flex items-center gap-5 pb-5">
        @if (isset($settings->settings['profile_picture']))
            <img class="w-20 h-20 sm:w-30 sm:h-30 rounded-full object-cover pointer-events-none"
                src="https://r2.sob.lol/{{ $settings->settings['profile_picture'] }}">
        @else
            <img class="w-20 h-20 sm:w-30 sm:h-30 rounded-full object-cover pointer-events-none"
                src="{{ asset('storage/default.png') }}">
        @endif
        <div class="flex flex-col">
            <h1 class="text-[25px] font-bold">{{ $user['name'] }}</h1>
            <p class="text-gray-400 text-[13px] mb-2">
                @if ($subscriberCount == 1)
                    {{ formatCount($subscriberCount ?? 0) }} subscriber
                @else
                    {{ formatCount($subscriberCount ?? 0) }} subscribers
                @endif
                <span>•</span>
                @if ($videos->count() == 1)
                    {{ $videos->count() }} video
                @else
                    {{ formatCount($videos->count()) }} videos
                @endif
            </p>
            <form wire:submit.prevent="subscribe">
                <x-subscribebtn :origin="$user['id']" :isSubscribed='$isSubscribed' />
            </form>
        </div>
    </div>

    <div x-data="{ tab: '{{ count($videos) >= 1 ? 'videos' : 'about' }}', videoSort: 'latest' }" class="flex flex-col gap-3">
        <div class="flex items-center gap-8 border-b-1 border-444">
            @if (count($videos) > 0)
                <a href="#" @click.prevent="tab = 'videos'"
                    :class="tab === 'videos'
                        ?
                        'font-bold text-white pb-2 border-b-2 border-white' :
                        'font-bold text-gray-400 pb-2 border-b-2 border-main hover:border-gray-400'">
                    Videos
                </a>
            @endif
            <a href="#" @click.prevent="tab = 'about'"
                :class="tab === 'about'
                    ?
                    'font-bold text-white pb-2 border-b-2 border-white' :
                    'font-bold text-gray-400 pb-2 border-b-2 border-main hover:border-gray-400'">
                About
            </a>
        </div>

        <div x-show="tab === 'videos'" id="videos" class="flex flex-col gap-4">
            <div class="flex gap-2">
                <button wire:click="setVideoSort('latest')"
                    class="text-sm px-3 py-2 {{ $videoSort === 'latest' ? 'bg-white text-main hover:bg-gray-300' : 'bg-272727 hover:bg-third' }} font-bold rounded-lg cursor-pointer transition">
                    Latest
                </button>
                <button wire:click="setVideoSort('popular')"
                    class="text-sm px-3 py-2 {{ $videoSort === 'popular' ? 'bg-white text-main hover:bg-gray-300' : 'bg-272727 hover:bg-third' }} font-bold rounded-lg cursor-pointer transition">
                    Popular
                </button>
                <button wire:click="setVideoSort('oldest')"
                    class="text-sm px-3 py-2 {{ $videoSort === 'oldest' ? 'bg-white text-main hover:bg-gray-300' : 'bg-272727 hover:bg-third' }} font-bold rounded-lg cursor-pointer transition">
                    Oldest
                </button>
            </div>

            <div class="flex gap-5 flex-wrap">
                @foreach ($sortedVideos as $video)
                    <x-video-card :video="$video" :size="'medium'" />
                @endforeach
            </div>
        </div>

        <div x-show="tab === 'about'" id="about" class="flex flex-col gap-4">
            @if ($settings->settings['description'] ?? '' != '')
                <div class="w-full">
                    <h1 class="text-white text-[18px] font-bold">Description</h1>
                    <p class="text-gray-300">{!! nl2br(e($settings->settings['description'] ?? '')) !!}</p>
                </div>
            @endif
            <div class="flex items-center gap-2 w-full">
                <h1 class="text-white text-[18px] font-bold">Joined:</h1>
                <p>{{ \Carbon\Carbon::parse($user['created_at'])->format('d-m-Y') }}</p>
            </div>
        </div>
    </div>
</div>
