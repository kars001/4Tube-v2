@section('title', '4Tube - History')

<div>
    <div class="mb-6 gap-2 flex justify-between flex-col sm:flex-row sm:items-center">
        <h1 class="text-2xl font-bold">Watch history</h1>

        <form wire:submit.prevent="clearHistory">
            @csrf
            <button class="flex items-center gap-3 cursor-pointer hover:text-red-400 transition">
                <x-heroicon-o-trash class="size-5" />
                <span>Delete all history</span>
            </button>
        </form>
    </div>

    <div class="flex flex-col gap-5">
        @foreach ($videos as $video)
            <x-video-card :video="$video" :size="'small'" />
        @endforeach
    </div>

    @if (count($videos) == 0)
        <p class="mt-2 text-gray-300 text-center">You don't have any history yet.</p>
    @endif
</div>
