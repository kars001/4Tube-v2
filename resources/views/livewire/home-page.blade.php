<div>
    @if ($videos->isEmpty())
        <p class="text-center text-gray-500">No videos available.</p>
    @else
        <div class="flex gap-5 flex-wrap">
            @foreach ($videos as $video)
                <x-video-card :video="$video" :size="'medium'" />
            @endforeach
        </div>
    @endif
</div>
