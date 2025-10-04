@section('title', '4Tube - Your videos')

<div>
    <h1 class="text-2xl font-bold mb-6">Manage your videos</h1>
    <div class="flex flex-col gap-5">
        @foreach ($videos as $video)
            @php $profileUrl = '/@' . $video->user->name; @endphp

            @if ($editingVideo === $video->id)
                <div class="flex gap-3 flex-col sm:flex-row select-none">
                    <div class="relative h-fit w-fit">
                        <img src="{{ $thumbnail_preview ?? 'https://r2.sob.lol/' . $video->settings['thumbnail'] }}"
                            class="h-30 w-55 max-w-55 object-cover rounded-md pointer-events-none">

                        <label for="thumbnail"
                            class="absolute top-0 left-0 w-full h-full flex items-center justify-center cursor-pointer bg-black/30 rounded-md">
                            <input class="hidden" type="file" wire:model="newThumbnail" id="thumbnail"
                                accept="image/*">
                            <span class="text-white text-md font-bold">Click to upload</span>
                        </label>

                        <div wire:loading wire:target="newThumbnail" class="absolute top-0 left-0 font-bold">
                            Uploading...
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 w-full">
                        <input class="w-full" type="text" wire:model="editTitle" placeholder="Title">
                        <textarea class="h-18" wire:model="editDescription" placeholder="Description"></textarea>

                        <div class="flex gap-3">
                            <button wire:click="saveVideo" type="submit">
                                Save
                            </button>
                            <button wire:click="cancelEditing" class="secondary-btn">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="flex gap-3 flex-col sm:flex-row select-none">
                    <a class="min-w-55" href="{{ 'watch/' . $video->slug }}">
                        <img src="https://r2.sob.lol/{{ $video->settings['thumbnail'] }}"
                        class="h-30 w-full max-w-55 object-cover rounded-md pointer-events-none">
                    </a>

                    <div class="w-full flex flex-col justify-between gap-2">
                        <div>
                            <h1 class="text-white font-bold leading-5">
                                {{ $video->settings['title'] }}
                            </h1>
                            <p class="block break-all md:hidden text-sm text-gray-300">
                                {{ Str::limit($video->settings['description'], 100) }}
                            </p>
                            <p class="hidden break-all text-wrap md:block lg:hidden text-sm text-gray-300">
                                {{ Str::limit($video->settings['description'], 150) }}
                            </p>
                            <p class="hidden break-all text-wrap lg:block text-sm text-gray-300">
                                {{ Str::limit($video->settings['description'], 250) }}
                            </p>
                        </div>

                        <div x-data="{ openDeleteVideo: false }" class="flex gap-3">
                            <button wire:click="startEditing({{ $video->id }})" class="flex items-center gap-2"
                                type="submit">
                                <x-heroicon-o-pencil-square class="size-5" />
                                Edit video
                            </button>
                            <button @click="openDeleteVideo = true"
                                class="flex items-center gap-2 bg-red-600 hover:bg-red-700 transition" type="submit">
                                <x-heroicon-o-trash class="size-5" />
                                Delete video
                            </button>

                            <div x-show="openDeleteVideo"
                                class="fixed inset-0 flex items-center justify-center bg-black/50 backdrop-blur-sm z-50 p-3">
                                <div @click.away="openDeleteVideo = false"
                                    class="bg-272727 rounded-md p-8 w-full max-w-md shadow-lg">
                                    <h2 class="text-xl font-bold mb-2">Confirm deletion of video</h2>
                                    <p class="text-gray-300">The current video will be deleted:</p>
                                    <p class="mb-3 bg-main px-3 py-1.5 rounded-lg border-1 border-444">
                                        {{ $video->settings['title'] }}
                                    </p>

                                    <form wire:submit="deleteVideo({{ $video->id }})">
                                        @csrf
                                        <div class="flex justify-end gap-3">
                                            <button type="button" class="w-full secondary-btn bg-444 hover:bg-input"
                                                @click="openDeleteVideo = false">
                                                Cancel
                                            </button>
                                            <button type="submit" @click="openDeleteVideo = false"
                                                class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">
                                                Delete video
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach

        @if (count($videos) == 0)
            <p class="mt-2 text-gray-300 text-center">You don't have any videos yet.</p>
        @endif
    </div>
</div>
