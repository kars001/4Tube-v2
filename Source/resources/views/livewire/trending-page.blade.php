@section('title', '4Tube - Trending')

<div>
    <h1 class="text-2xl font-bold mb-6">Trending</h1>

    <div class="flex flex-col gap-5">
        @foreach ($videos as $video)
            <div class="flex items-center gap-4 relative">
                @switch($loop->iteration)
                    @case($loop->iteration == 1)
                        <span class="absolute flex items-center gap-2 top-0 text-xl font-bold bg-amber-400 px-2 rounded-tl-md text-main">
                            <x-heroicon-o-trophy class="size-5" />
                            #{{ $loop->iteration }}
                        </span>
                    @break

                    @case($loop->iteration == 2)
                        <span class="absolute top-0 text-xl font-bold bg-slate-400 px-2 rounded-tl-md text-main">
                            #{{ $loop->iteration }}
                        </span>
                    @break

                    @case($loop->iteration == 3)
                        <span class="absolute top-0 text-xl font-bold bg-amber-900 px-2 rounded-tl-md text-main">
                            #{{ $loop->iteration }}
                        </span>
                    @break

                    @default
                        <span class="absolute top-0 text-xl font-bold bg-primary px-2 rounded-tl-md text-main">
                            #{{ $loop->iteration }}
                        </span>
                @endswitch

                <x-video-card :video="$video" :size="'small'" />
            </div>
        @endforeach
    </div>
</div>
