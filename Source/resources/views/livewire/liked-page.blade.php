@section('title', '4Tube - Liked videos')

<div>
    <div x-data="{ tab: '{{ !$liked->isEmpty() ? 'liked' : (!$disliked->isEmpty() ? 'disliked' : '') }}' }" class="flex flex-col gap-5">
        <div class="flex items-center gap-8 border-b-1 border-444">
            @if (!$liked->isEmpty())
                <a href="#" @click.prevent="tab = 'liked'"
                    :class="tab === 'liked'
                        ?
                        'font-bold text-white pb-2 border-b-2 border-white' :
                        'font-bold text-gray-400 pb-2 border-b-2 border-main hover:border-gray-400'">
                    Liked
                </a>
            @endif
            @if (!$disliked->isEmpty())
                <a href="#" @click.prevent="tab = 'disliked'"
                    :class="tab === 'disliked'
                        ?
                        'font-bold text-white pb-2 border-b-2 border-white' :
                        'font-bold text-gray-400 pb-2 border-b-2 border-main hover:border-gray-400'">
                    Disliked
                </a>
            @endif
        </div>

        @if (!$liked->isEmpty())
            <div x-show="tab === 'liked'" id="liked" class="mt-4">
                <div class="flex flex-col gap-5">
                    @foreach ($liked as $video)
                        <x-video-card :video="$video" :size="'small'" />
                    @endforeach
                </div>
            </div>
        @endif

        @if (!$disliked->isEmpty())
            <div x-show="tab === 'disliked'" id="disliked" class="mt-4">
                <div class="flex flex-col gap-5">
                    @foreach ($disliked as $video)
                        <x-video-card :video="$video" :size="'small'" />
                    @endforeach
                </div>
            </div>
        @endif

        @if ($liked->isEmpty() && $disliked->isEmpty())
            <p class="mt-2 text-gray-300 text-center">You don't have any liked or disliked videos yet.</p>
        @endif
    </div>
</div>
