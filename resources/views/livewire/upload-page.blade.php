@section('title', '4Tube - Upload')

<form class="flex flex-col gap-5" wire:submit.prevent="uploadVideo" method="post" enctype="multipart/form-data">
    @csrf
    <div class="flex gap-5 flex-wrap md:flex-nowrap lg:flex-nowrap">
        <div class="flex items-center justify-center w-full">
            @if ($video)
                <div class="w-full">
                    <video class="w-full h-64 rounded-lg border-2 border-primary" controls>
                        <source src="{{ $video->temporaryUrl() }}" type="video/mp4">
                    </video>
                </div>
            @else
                <label for="video"
                    class="hover:bg-second hover:border-gray-600 bg-input transition flex flex-col items-center justify-center w-full h-64 border-2 border-gray-400 border-dashed rounded-lg cursor-pointer">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6 ">
                        <x-heroicon-o-video-camera class="w-8 h-8 mb-4 text-gray-400" />
                        <p class="mb-2 text-sm text-gray-400"><span class="font-semibold">Click to upload</span> or drag
                            and
                            drop</p>
                        <p class="text-xs text-gray-400">MP4, MOV, MKV or WEBM (MAX. 300MB)</p>
                    </div>
                    <input wire:model="video" accept="video/*" id="video" required type="file" class="hidden" />
                    <div wire:loading wire:target="video">
                        {{-- loading indicator --}}
                        <div
                            class="grid w-full place-items-center overflow-x-scroll rounded-lg p-6 lg:overflow-visible">
                            <svg class="text-gray-300 animate-spin" viewBox="0 0 64 64" fill="none"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24">
                                <path
                                    d="M32 3C35.8083 3 39.5794 3.75011 43.0978 5.20749C46.6163 6.66488 49.8132 8.80101 52.5061 11.4939C55.199 14.1868 57.3351 17.3837 58.7925 20.9022C60.2499 24.4206 61 28.1917 61 32C61 35.8083 60.2499 39.5794 58.7925 43.0978C57.3351 46.6163 55.199 49.8132 52.5061 52.5061C49.8132 55.199 46.6163 57.3351 43.0978 58.7925C39.5794 60.2499 35.8083 61 32 61C28.1917 61 24.4206 60.2499 20.9022 58.7925C17.3837 57.3351 14.1868 55.199 11.4939 52.5061C8.801 49.8132 6.66487 46.6163 5.20749 43.0978C3.7501 39.5794 3 35.8083 3 32C3 28.1917 3.75011 24.4206 5.2075 20.9022C6.66489 17.3837 8.80101 14.1868 11.4939 11.4939C14.1868 8.80099 17.3838 6.66487 20.9022 5.20749C24.4206 3.7501 28.1917 3 32 3L32 3Z"
                                    stroke="currentColor" stroke-width="5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path
                                    d="M32 3C36.5778 3 41.0906 4.08374 45.1692 6.16256C49.2477 8.24138 52.7762 11.2562 55.466 14.9605C58.1558 18.6647 59.9304 22.9531 60.6448 27.4748C61.3591 31.9965 60.9928 36.6232 59.5759 40.9762"
                                    stroke="currentColor" stroke-width="5" stroke-linecap="round"
                                    stroke-linejoin="round" class="text-gray-900">
                                </path>
                            </svg>
                        </div>
                    </div>
                </label>
            @endif
        </div>

        <div class="flex items-center justify-center w-full">
            @if ($thumbnail)
                <div class="w-full">
                    <img class="w-full h-64 rounded-lg object-contain border-2 border-primary"
                        src="{{ $thumbnail->temporaryUrl() }}" alt="Thumbnail Preview">
                </div>
            @else
                <label for="thumbnail"
                    class="hover:bg-second hover:border-gray-600 bg-input transition flex flex-col items-center justify-center w-full h-64 border-2 border-gray-400 border-dashed rounded-lg cursor-pointer">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6 ">
                        <x-heroicon-o-photo class="w-8 h-8 mb-4 text-gray-400" />
                        <p class="mb-2 text-sm text-gray-400"><span class="font-semibold">Click to upload</span> or drag
                            and
                            drop</p>
                        <p class="text-xs text-gray-400">PNG or JPG (MAX. 30MB)</p>
                    </div>
                    <input wire:model="thumbnail" accept="image/*" id="thumbnail" required type="file"
                        class="hidden" />
                    <div wire:loading wire:target="thumbnail">
                        {{-- loading indicator --}}
                        <div
                            class="grid w-full place-items-center overflow-x-scroll rounded-lg p-6 lg:overflow-visible">
                            <svg class="text-gray-300 animate-spin" viewBox="0 0 64 64" fill="none"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24">
                                <path
                                    d="M32 3C35.8083 3 39.5794 3.75011 43.0978 5.20749C46.6163 6.66488 49.8132 8.80101 52.5061 11.4939C55.199 14.1868 57.3351 17.3837 58.7925 20.9022C60.2499 24.4206 61 28.1917 61 32C61 35.8083 60.2499 39.5794 58.7925 43.0978C57.3351 46.6163 55.199 49.8132 52.5061 52.5061C49.8132 55.199 46.6163 57.3351 43.0978 58.7925C39.5794 60.2499 35.8083 61 32 61C28.1917 61 24.4206 60.2499 20.9022 58.7925C17.3837 57.3351 14.1868 55.199 11.4939 52.5061C8.801 49.8132 6.66487 46.6163 5.20749 43.0978C3.7501 39.5794 3 35.8083 3 32C3 28.1917 3.75011 24.4206 5.2075 20.9022C6.66489 17.3837 8.80101 14.1868 11.4939 11.4939C14.1868 8.80099 17.3838 6.66487 20.9022 5.20749C24.4206 3.7501 28.1917 3 32 3L32 3Z"
                                    stroke="currentColor" stroke-width="5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path
                                    d="M32 3C36.5778 3 41.0906 4.08374 45.1692 6.16256C49.2477 8.24138 52.7762 11.2562 55.466 14.9605C58.1558 18.6647 59.9304 22.9531 60.6448 27.4748C61.3591 31.9965 60.9928 36.6232 59.5759 40.9762"
                                    stroke="currentColor" stroke-width="5" stroke-linecap="round"
                                    stroke-linejoin="round" class="text-gray-900">
                                </path>
                            </svg>
                        </div>
                    </div>
                </label>
            @endif
        </div>
    </div>

    <div>
        <label class="block text-sm/6 font-medium" for="title">Title</label>
        <div class="mt-1">
            <input class="block w-full" type="text" wire:model.live="title" id="title" required>
            @error('title') 
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
            @if($titleError)
                <span class="text-red-500 text-sm">{{ $titleError }}</span>
            @endif
        </div>
    </div>

    <div>
        <label class="block text-sm/6 font-medium" for="description">Description</label>
        <div class="mt-1">
            <textarea rows="5" class="block w-full" wire:model.live="description" id="description"></textarea>
            @error('description')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
            @if($descriptionError)
                <span class="text-red-500 text-sm">{{ $descriptionError }}</span>
            @endif
        </div>
    </div>

    <button class="w-fit px-5" type="submit">Upload Video</button>

    <!-- Loading Indicator -->
    <div wire:loading class="mt-5 text-center text-gray-200">
        Uploading... Please wait.
    </div>
</form>
