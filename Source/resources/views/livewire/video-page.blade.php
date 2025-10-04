@section('title', '4Tube - ' . $video->settings['title'])

@php $videoUrl = Config::get('app.url') . ':' . Config::get('app.port') . '/watch/' . $video['slug'];  @endphp

<div class="flex flex-col gap-3">
    <video class="w-full h-50 md:h-80 lg:h-140 rounded-md" src="https://r2.sob.lol/{{ $video->settings['video'] }}"
        controls></video>

    <h1 class="font-bold text-xl">{{ $video->settings['title'] }}</h1>

    <div class="flex items-center justify-between flex-wrap gap-3">
        <div class="flex items-center gap-7">
            <a href="{{ '/@' . $user->name }}" class="flex items-center gap-3">
                @if (!($settings->settings['profile_picture'] ?? null))
                    <img class="w-11 h-11 rounded-full" src="{{ asset('storage/default.png') }}">
                @else
                    <img class="w-11 h-11 rounded-full"
                        src="https://r2.sob.lol/{{ $settings->settings['profile_picture'] }}">
                @endif
                <div class="flex flex-col">
                    <p class="text-white font-bold text-[15px]">{{ $user->name }}</p>
                    <p class="text-gray-400 text-[13px]">
                        @if ($subscriberCount == 1)
                            {{ formatCount($subscriberCount ?? 0) }} subscriber
                        @else
                            {{ formatCount($subscriberCount ?? 0) }} subscribers
                        @endif
                    </p>
                </div>
            </a>
            <form wire:submit.prevent="subscribe">
                <x-subscribebtn :origin="$user['id']" :isSubscribed='$isSubscribed' />
            </form>
        </div>

        <div class="flex gap-3">
            <div class="bg-272727 flex gap-4rounded-full rounded-full">
                <!-- Like Button -->
                <button class="flex items-center gap-2 hover:bg-input rounded-l-full py-1.5 px-4 cursor-pointer"
                    wire:click="likeVideo">
                    @if (!$hasLiked)
                        <x-heroicon-o-hand-thumb-up class="size-7" />
                    @else
                        <x-heroicon-s-hand-thumb-up class="size-7" />
                    @endif
                    <span class="text-[17px]">{{ $likeCount }}</span>
                </button>

                <div class="border-1 border-444 rounded-full my-1.5"></div>

                <!-- Dislike Button -->
                <button class="flex items-center gap-2 hover:bg-input rounded-r-full py-1.5 px-4 cursor-pointer"
                    wire:click="dislikeVideo">
                    @if (!$hasDisliked)
                        <x-heroicon-o-hand-thumb-down class="size-7" />
                    @else
                        <x-heroicon-s-hand-thumb-down class="size-7" />
                    @endif

                    <span class="text-[17px]">{{ $dislikeCount }}</span>
                </button>
            </div>

            <div x-data="{
                open: false,
                copyToClipboard() {
                    const urlInput = document.getElementById('video-url');
                    urlInput.select();
                    urlInput.setSelectionRange(0, 99999);
                    navigator.clipboard.writeText(urlInput.value).then(() => {
                        console.log('Copied to clipboard: ', urlInput.value);
                    }).catch(err => {
                        console.error('Failed to copy: ', err);
                    });
                }
            }">
                <div>
                    <button type="button" @click="open = true"
                        class="flex items-center sm:gap-2 bg-272727 cursor-pointer rounded-full py-2 sm:px-4 px-2 hover:bg-input">
                        <x-heroicon-o-share class="size-6" />
                        <p class="text-[0px] sm:text-[16px]">Share</p>
                    </button>
                </div>

                <div x-show="open"
                    class="fixed inset-0 flex items-center justify-center bg-black/50 backdrop-blur-sm z-50 p-3">
                    <div @click.away="open = false"
                        class="bg-272727 flex flex-col gap-3 rounded-md p-5 w-full max-w-md shadow-[0px_9px_15px_-3px_rgba(0,_0,_0,_0.45)]">
                        <div class="flex justify-between">
                            <h2 class="text-xl font-bold">Share</h2>
                            <button @click="open = false" class="cursor-pointer h-fit">
                                <x-heroicon-o-x-mark class="size-7 hover:text-gray-300 transition" />
                            </button>
                        </div>

                        <div class="flex gap-2 overflow-scroll">
                            <a href="https://wa.me/?text={{ $videoUrl }}" target="_blank" rel="noopener"
                                class="flex flex-col items-center gap-2 cursor-pointer hover:bg-[rgba(77,77,77,255)] p-2 rounded-md transition">
                                {!! file_get_contents(resource_path('views/svg/whatsapp.svg')) !!}
                                <span class="text-[13px] text-gray-50">Whatsapp</span>
                            </a>

                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $videoUrl }}" target="_blank"
                                rel="noopener"
                                class="flex flex-col items-center gap-2 cursor-pointer hover:bg-[rgba(77,77,77,255)] p-2 rounded-md transition">
                                {!! file_get_contents(resource_path('views/svg/facebook.svg')) !!}
                                <span class="text-[13px] text-gray-50">Facebook</span>
                            </a>

                            <a href="https://twitter.com/intent/tweet?url={{ $videoUrl }}" target="_blank"
                                rel="noopener"
                                class="flex flex-col items-center gap-2 cursor-pointer hover:bg-[rgba(77,77,77,255)] p-2 rounded-md transition">
                                {!! file_get_contents(resource_path('views/svg/x.svg')) !!}
                                <span class="text-[13px] text-gray-50">X</span>
                            </a>

                            <a href="https://www.reddit.com/submit?url={{ $videoUrl }}" target="_blank"
                                rel="noopener"
                                class="flex flex-col items-center gap-2 cursor-pointer hover:bg-[rgba(77,77,77,255)] p-2 rounded-md transition">
                                {!! file_get_contents(resource_path('views/svg/reddit.svg')) !!}
                                <span class="text-[13px] text-gray-50">Reddit</span>
                            </a>

                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $videoUrl }}"
                                target="_blank" rel="noopener"
                                class="flex flex-col items-center gap-2 cursor-pointer hover:bg-[rgba(77,77,77,255)] p-2 rounded-md transition">
                                {!! file_get_contents(resource_path('views/svg/linkedin.svg')) !!}
                                <span class="text-[13px] text-gray-50">LinkedIn</span>
                            </a>

                            <a href="mailto:?subject={{ $videoUrl }}&body={{ $videoUrl }}" target="_blank"
                                rel="noopener"
                                class="flex flex-col items-center gap-2 cursor-pointer hover:bg-[rgba(77,77,77,255)] p-2 rounded-md transition">
                                {!! file_get_contents(resource_path('views/svg/email.svg')) !!}
                                <span class="text-[13px] text-gray-50">Email</span>
                            </a>

                        </div>

                        <div class="flex gap-2 bg-main rounded-lg border-1 border-third p-2">
                            <input id="video-url" type="text" class="w-full bg-main text-white focus:outline-0"
                                value="{{ $videoUrl }}" readonly>
                            <button @click="copyToClipboard()"
                                class="rounded-full bg-primary cursor-pointer font-bold text-272727 px-4 py-1 hover:bg-primary-hover">Copy</button>
                        </div>
                    </div>
                </div>
            </div>


            <form method="post">
                <button wire:click.prevent="downloadVideo" type="submit"
                    class="flex items-center sm:gap-2 bg-272727 cursor-pointer rounded-full py-2 sm:px-4 px-2 hover:bg-input">
                    <x-heroicon-o-arrow-down-tray class="size-6" />
                    <p class="text-[0px] sm:text-[16px] font-medium">Download</p>
                </button>
            </form>
        </div>
    </div>

    <div class="flex flex-col gap-2 py-2 px-3 bg-272727 rounded-md">
        <p class="font-bold text-[14px] flex gap-3">
            @if ($views == 1)
                <span>{{ $views }} view</span>
            @else
                <span>{{ $views }} views</span>
            @endif
            <span>{{ \Carbon\Carbon::parse($video['created_at'])->diffForHumans() }}</span>
        </p>

        @if ($video->settings['description'] === null)
            <p class="text-gray-200 text-sm italic">No description</p>
        @else
            <div x-data="{ expanded: false }" class="relative">
                <p class="text-gray-200 text-sm break-all overflow-hidden"
                    :class="expanded ? 'line-clamp-none max-h-full' : 'line-clamp-2 max-h-[4.5rem]'" x-ref="desc">
                    {!! nl2br(e($video->settings['description'])) !!}
                </p>

                <button x-show="$refs.desc.scrollHeight > $refs.desc.clientHeight || expanded"
                    @click="expanded = !expanded" class="mt-2 text-white font-bold text-sm cursor-pointer"
                    x-text="expanded ? 'Read less' : 'Read more'"></button>
            </div>
        @endif
    </div>

    <div class="mt-2">
        @switch(count($comments))
            @case(count($comments) === null)
                <h1 class="font-bold text-xl mb-5">No comments</h1>
            @break

            @case(count($comments) == 1)
                <h1 class="font-bold text-xl mb-5">{{ number_format(count($comments)) }} Comment</h1>
            @break

            @default
                <h1 class="font-bold text-xl mb-5">{{ number_format(count($comments)) }} Comments</h1>
        @endswitch

        <form class="mb-10 flex items-center gap-5" wire:submit.prevent="postComment">
            @csrf
            <img class="w-10 h-10 object-cover rounded-full" src="{{ asset('storage/default.png') }}"
                alt="pfp">
            <div class="flex gap-3 w-full">
                <input
                    class="w-full outline-0 bg-main border-b-1 border-444 focus:border-white transition rounded-none pl-0"
                    type="text" wire:model="comment" placeholder="Add a comment...">
                <button class="rounded-full" type="submit">Comment</button>
            </div>
        </form>
        @if ($comments)
            <div class="flex flex-col gap-6">
                @foreach ($comments as $comment)
                    <div class="flex flex-row gap-3">
                        @if (!($comment->user->settings->settings['profile_picture'] ?? null))
                            <a href="{{ '/@' . $comment->user->name }}">
                                <img class="w-10 h-10 rounded-full object-cover"
                                    src="{{ asset('storage/default.png') }}">
                            </a>
                        @else
                            <a href="{{ '/@' . $comment->user->name }}">
                                <img class="w-10 h-10 rounded-full object-cover"
                                    src="https://r2.sob.lol/{{ $comment->user->settings->settings['profile_picture'] }}">
                            </a>
                        @endif
                        <div class="flex gap-2 justify-between w-full">
                            <div class="w-full">
                                <div class="flex gap-2 items-center">
                                    <a href="{{ '/@' . $comment->user->name }}" class="text-white font-bold text-sm">
                                        {{ $comment->user->name }}
                                    </a>
                                    <p class="text-gray-400 text-sm">
                                        {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}
                                    </p>
                                </div>
                                @if ($editingCommentId === $comment->id)
                                    <form class="flex flex-col gap-2 w-full" wire:submit.prevent="updateComment">
                                        <textarea wire:model="editingCommentContent"></textarea>
                                        <div class="flex gap-2">
                                            <button type="submit">Save</button>
                                            <button type="button"
                                                class="cursor-pointer bg-input hover:bg-444 transition p-2 rounded-md"
                                                wire:click="$set('editingCommentId', null)">Cancel</button>
                                        </div>
                                    </form>
                                @else
                                    <div x-data="{ expanded: false }" class="relative">
                                        <p class="text-gray-200 test-sm break-all overflow-hidden"
                                            :class="expanded ? 'line-clamp-none max-h-full' : 'line-clamp-2 max-h-[4.5rem]'"
                                            x-ref="desc">
                                            {!! nl2br(e($comment->content)) !!}
                                        </p>

                                        <button x-show="$refs.desc.scrollHeight > $refs.desc.clientHeight || expanded"
                                            @click="expanded = !expanded"
                                            class="text-white font-bold text-sm cursor-pointer"
                                            x-text="expanded ? 'Read less' : 'Read more'"></button>
                                    </div>
                                @endif
                            </div>
                            @if (Auth::check() && Auth::id() === $comment->user_id)
                                <div class="relative" x-data="{ commentOpen: false }" @click.away="commentOpen = false">
                                    <button @click="commentOpen = !commentOpen"
                                        class="cursor-pointer rounded-full py-1.5 px-1.5 hover:bg-272727">
                                        <x-heroicon-o-ellipsis-vertical class="size-7" />
                                    </button>

                                    <div x-show="commentOpen" x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="bg-second rounded-md absolute top-11 py-1 right-0 w-48 z-50">
                                        <button wire:click="editComment({{ $comment->id }})"
                                            class="cursor-pointer w-full flex items-center gap-2 text-left text-white px-4 py-1.5 text-sm/6 hover:bg-121212">
                                            <x-heroicon-o-pencil-square class="size-5" />
                                            Edit comment
                                        </button>
                                        <button wire:click="deleteComment({{ $comment->id }})"
                                            @click="commentOpen = false"
                                            class="cursor-pointer w-full flex items-center gap-2 text-left text-white px-4 py-1.5 text-sm/6 hover:bg-121212 hover:text-red-500">
                                            <x-heroicon-o-trash class="size-5" />
                                            Delete comment
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
