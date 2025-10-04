@php $profileUrl = '/@' . $video->user->name; @endphp

@if ($size == 'medium')
    <div onclick="location='/watch/{{ $video->slug }}'" class="w-full max-w-[355px] block cursor-pointer select-none">
        <img src="https://r2.sob.lol/{{ $video->settings['thumbnail'] }}"
            class="h-50 w-90 object-cover rounded-md pointer-events-none" alt="{{ $video->settings['title'] }}">

        <div class="pt-3 w-fit flex flex-row gap-3">
            @if (!($settings->settings['profile_picture'] ?? null))
                <div onclick="event.stopPropagation(); location='{{ $profileUrl }}'">
                    <img class="w-10 h-10 rounded-full cursor-pointer object-cover pointer-events-none"
                        src="{{ asset('storage/default.png') }}">
                </div>
            @else
                <div onclick="event.stopPropagation(); location='{{ $profileUrl }}'">
                    <img class="w-10 h-10 rounded-full cursor-pointer object-cover pointer-events-none"
                        src="https://r2.sob.lol/{{ $settings->settings['profile_picture'] }}">
                </div>
            @endif

            <div class="flex flex-col">
                <h1 class="text-white font-bold leading-5">
                    {{ \Illuminate\Support\Str::limit($video->settings['title'], 60) }}
                </h1>

                <p onclick="event.stopPropagation(); location='{{ $profileUrl }}'"
                    class="text-gray-400 text-sm pt-1 cursor-pointer">
                    {{ $video->user->name }}
                </p>

                <p class="text-gray-400 text-sm flex gap-1.5 leading-4.5">
                    @if ($video->views->count() == 1)
                        <span>{{ formatCount($video->views->count()) }} view</span>
                    @else
                        <span>{{ formatCount($video->views->count()) }} views</span>
                    @endif
                    <span>•</span>
                    {{ \Carbon\Carbon::parse($video->created_at)->diffForHumans() }}
                </p>
            </div>
        </div>
    </div>
@elseif ($size == 'small')
    <div onclick="location='/watch/{{ $video->slug }}'"
        class="flex gap-3 flex-col md:flex-row cursor-pointer select-none">
        <img src="https://r2.sob.lol/{{ $video->settings['thumbnail'] }}"
            class="h-50 w-90 object-cover rounded-md pointer-events-none" alt="{{ $video->settings['title'] }}">

        <div class="w-fit flex flex-col">
            <h1 class="text-white font-bold leading-5">
                {{ $video->settings['title'] }}
            </h1>

            <div class="text-gray-400 text-sm flex items-center gap-1.5">
                <span onclick="event.stopPropagation(); location='{{ $profileUrl }}'" class="cursor-pointer">
                    {{ $video->user->name }}
                </span>
                <span>•</span>
                @if ($video->views->count() == 1)
                    <span>{{ formatCount($video->views->count()) }} view</span>
                @else
                    <span>{{ formatCount($video->views->count()) }} views</span>
                @endif
            </div>
        </div>
    </div>
@endif
