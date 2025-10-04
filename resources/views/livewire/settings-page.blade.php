@section('title', '4Tube - Settings')

<div class="w-full max-w-[800px]">
    <form class="flex gap-10 w-full flex-wrap md:flex-nowrap" wire:submit.prevent="updateSettings" method="post"
        enctype="multipart/form-data">
        @csrf
        <div class="flex flex-col w-full max-w-[300px] gap-2">
            <h1 class="text-[18px] font-bold">Personal Information</h1>
            <p class="text-[15px] text-gray-300">This information is public so choose wizely.</p>
        </div>
        <div class="flex flex-col gap-5 w-full">
            <div class="flex items-center gap-5">
                <div class="flex flex-col items-center gap-2">
                    <img class="w-20 h-20 rounded-full object-cover"
                        src="{{ $profile_picture_preview ? $profile_picture_preview : ($this->profile_picture ? 'https://r2.sob.lol/' . $this->profile_picture : asset('storage/default.png')) }}"
                        alt="Profile Picture">
                </div>

                <div class="flex flex-col gap-2">
                    <div class="flex gap-2">
                        <label class="w-max secondary-btn" for="profile_picture">Change avatar</label>
                        <button wire:click="deleteProfilePicture"
                            class="rounded-md bg-input hover:bg-red-700 transition p-1 cursor-pointer">
                            <x-heroicon-o-trash class="size-5" />
                        </button>
                    </div>
                    <p class="text-gray-300 text-xs">PNG, JPG or GIF. 10MB max.</p>
                    <div wire:loading wire:target="profile_picture">
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
                </div>
                <input class="hidden" type="file" accept="image/*" id="profile_picture" wire:model="profile_picture">
            </div>

            <div>
                <label for="name" class="block text-sm/6 font-medium">Username</label>
                <div
                    class="mt-1 flex items-center rounded-md bg-input pl-3 -outline-offset-1 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-primary">
                    <div class="shrink-0 text-base select-none sm:text-sm/6">@</div>
                    <input type="text" wire:model="name" id="name" name="name"
                        class="block min-w-0 grow py-1.5 pr-3 pl-0 text-base focus:outline-none sm:text-sm/6">
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm/6 font-medium">Description</label>
                <div class="mt-1">
                    <textarea id="description" type="text" wire:model="description" class="block w-full"></textarea>
                </div>
            </div>

            <div class="flex flex-col gap-2">
                <img class="rounded-md h-[150px] object-cover"
                    src="{{ $profile_banner_preview ? $profile_banner_preview : ($this->profile_banner ? 'https://r2.sob.lol/' . $this->profile_banner : asset('storage/banner-preview.png')) }}"
                    alt="Profile Banner">
                <div class="flex gap-3 items-center">
                    <div class="flex gap-2">
                        <label class="secondary-btn w-max" for="profile_banner">Change banner</label>
                        <button wire:click="deleteProfileBanner"
                            class="rounded-md bg-input hover:bg-red-700 transition p-1 cursor-pointer">
                            <x-heroicon-o-trash class="size-5" />
                        </button>
                    </div>
                    <p class="text-gray-300 text-xs">PNG or JPG. 30MB max.</p>
                    <div wire:loading wire:target="profile_banner">
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
                </div>
                <input class="hidden" type="file" accept="image/*" id="profile_banner" wire:model="profile_banner">
            </div>
            <button class="w-max" type="submit">Save</button>
        </div>
    </form>

    <form class="mt-25 flex gap-10 flex-wrap md:flex-nowrap" wire:submit="updateTheme" method="post">
        @csrf
        <div class="flex flex-col w-full max-w-[300px] gap-2">
            <h1 class="text-[18px] font-bold">Appearance</h1>
            <p class="text-[15px] text-gray-300">Change the look and feel of the website. Currently using the <span
                    class="font-bold">{{ $theme }}</span> theme.</p>
        </div>
        <div class="flex flex-wrap gap-5">
            <div class="group relative cursor-pointer h-fit">
                <div class="{{ $theme === 'default' ? 'outline-primary' : 'outline-gray-400' }} outline-[1.5px] outline-offset-2 w-15 h-15 rounded-md"
                    style="background: linear-gradient(45deg, #4c52ff 50%, #0f0f0f 50%);"
                    wire:click="updateTheme('default')">
                </div>

                @if ($theme === 'default')
                    <x-heroicon-m-check
                        class="size-6 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" />
                @endif
                <span
                    class="absolute -top-8 left-1/2 -translate-x-1/2 hidden group-hover:block bg-gray-900 text-white text-sm rounded px-2 py-1">Default</span>
            </div>

            <div class="group relative cursor-pointer h-fit">
                <div class="{{ $theme === 'gold' ? 'outline-primary' : 'outline-gray-400' }} outline-[1.5px] outline-offset-2 w-15 h-15 rounded-md"
                    style="background: linear-gradient(45deg, #e79735 50%, #0f0f0f 50%);"
                    wire:click="updateTheme('gold')">
                </div>

                @if ($theme === 'gold')
                    <x-heroicon-m-check
                        class="size-6 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" />
                @endif
                <span
                    class="absolute -top-8 left-1/2 -translate-x-1/2 hidden group-hover:block bg-gray-900 text-white text-sm rounded px-2 py-1">Gold</span>
            </div>

            <div class="group relative cursor-pointer h-fit">
                <div class="{{ $theme === 'purple' ? 'outline-primary' : 'outline-gray-400' }} outline-[1.5px] outline-offset-2 w-15 h-15 rounded-md"
                    style="background: linear-gradient(45deg, #8b5cf6 50%, #120f1f 50%);"
                    wire:click="updateTheme('purple')">
                </div>

                @if ($theme === 'purple')
                    <x-heroicon-m-check
                        class="size-6 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" />
                @endif
                <span
                    class="absolute -top-8 left-1/2 -translate-x-1/2 hidden group-hover:block bg-gray-900 text-white text-sm rounded px-2 py-1">Purple</span>
            </div>

            <div class="group relative cursor-pointer h-fit">
                <div class="{{ $theme === 'teal' ? 'outline-primary' : 'outline-gray-400' }} outline-[1.5px] outline-offset-2 w-15 h-15 rounded-md"
                    style="background: linear-gradient(45deg, #14b8a6 50%, #061e1d 50%);"
                    wire:click="updateTheme('teal')">
                </div>

                @if ($theme === 'teal')
                    <x-heroicon-m-check
                        class="size-6 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" />
                @endif
                <span
                    class="absolute -top-8 left-1/2 -translate-x-1/2 hidden group-hover:block bg-gray-900 text-white text-sm rounded px-2 py-1">Teal</span>
            </div>

        </div>
    </form>

    <form class="mt-25 flex gap-10 flex-wrap md:flex-nowrap" wire:submit="updatePassword" method="post">
        @csrf
        <div class="flex flex-col w-full max-w-[300px] gap-2">
            <h1 class="text-[18px] font-bold">Change password</h1>
            <p class="text-[15px] text-gray-300">Update your password to secure your account. This will log out all
                devices.</p>
        </div>
        <div class="flex flex-col gap-5 w-full">
            <div>
                <label for="old_password" class="block text-sm/6 font-medium">Old Password</label>
                <div class="mt-1">
                    <input id="old_password" type="password" wire:model="current_password" class="block w-full"
                        required>
                </div>
            </div>

            <div>
                <label for="new_password" class="block text-sm/6 font-medium">New Password</label>
                <div class="mt-1">
                    <input id="new_password" type="password" wire:model="new_password" class="block w-full"
                        required>
                </div>
            </div>

            <div>
                <label for="new_password_confirm" class="block text-sm/6 font-medium">Confirm New Password</label>
                <div class="mt-1">
                    <input id="new_password_confirm" type="password" wire:model="new_password_confirmation"
                        class="block w-full" required>
                </div>
            </div>

            <button class="w-max" type="submit">Reset Password</button>
        </div>
    </form>

    <div class="mt-25 flex gap-10 flex-wrap md:flex-nowrap">
        <div class="flex flex-col w-full max-w-[300px] gap-2">
            <h1 class="text-[18px] font-bold">2FA Authentication</h1>
            <p class="text-[15px] text-gray-300">
                {{ auth()->user()->two_factor_confirmed
                    ? 'Two-factor authentication is enabled on your account.'
                    : (auth()->user()->two_factor_secret
                        ? 'Two-factor authentication setup is in progress. Please confirm with your code.'
                        : 'Enable two-factor authentication to secure your account.') }}
            </p>
        </div>

        <div x-data="{ show2FAModal: false }">

            @if (auth()->user()->two_factor_confirmed)
                <form action="/user/two-factor-authentication" method="post">
                    @csrf
                    @method('delete')
                    <button class="bg-red-600 hover:bg-red-700 transition" type="submit">Disable 2FA</button>
                </form>
            @elseif(auth()->user()->two_factor_secret)
                <div x-init="show2FAModal = true"></div>

                <div x-show="show2FAModal" x-transition
                    class="overflow-scroll p-3 fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50">
                    <div class="bg-272727 rounded-md p-5 w-full max-w-lg shadow-lg relative">
                        <div class="flex justify-between gap-2 mb-3">
                            <h2 class="text-lg font-bold mb-3">Enable Authenticator App</h2>
                            <form id="cancel-2fa-form" action="/user/two-factor-authentication" method="POST">
                                @csrf
                                @method('delete')
                                <button class="px-0 py-0 bg-272727" type="submit">
                                    <x-heroicon-m-x-mark class="size-7 hover:text-gray-300 transition" />
                                </button>
                            </form>
                        </div>

                        <div class="flex gap-5 items-center">
                            <div class="justify-center w-full max-w-30 hidden sm:flex">
                                <img class="pointer-events-none w-25" src="{{ asset('storage/auth.png') }}"
                                    alt="Auth-app">
                            </div>
                            <div>
                                <h2 class="font-bold text-md">Download an Authenticator app</h2>
                                <p class="text-sm text-gray-300">
                                    Download and install
                                    <a class="text-blue-500 hover:text-blue-600" target="_blank"
                                        href="https://www.authy.com/">Authy</a>
                                    or
                                    <a class="text-blue-500 hover:text-blue-600" target="_blank"
                                        href="https://support.google.com/accounts/answer/1066447?hl=en">
                                        Google authenticator
                                    </a>
                                    for your phone or tablet.
                                </p>
                            </div>
                        </div>

                        <hr class="border-1 border-third my-5">

                        <div class="flex gap-5 items-center">
                            <div class="flex justify-center w-full max-w-30">
                                {!! str_replace('<svg', '<svg class="w-30 p-2 rounded bg-white h-fit"', auth()->user()->twoFactorQrCodeSvg()) !!}
                            </div>
                            <div>
                                <h2 class="font-bold text-md">Scan the QR code</h2>
                                <p class="text-sm text-gray-300">
                                    Open your preferd authentication app and scan the image to the left.
                                </p>
                            </div>
                        </div>

                        <hr class="border-1 border-third my-5">

                        <div class="flex gap-5 items-center">
                            <div class="justify-center w-full max-w-30 hidden sm:flex">
                                <img class="pointer-events-none" src="{{ asset('storage/phone.svg') }}"
                                    alt="Phone">
                            </div>
                            <div class="flex flex-col gap-2">
                                <div>
                                    <h2 class="font-bold text-md">Login with your code</h2>
                                    <p class="text-sm text-gray-300">
                                        Enter the 6-digit verification code generated.
                                    </p>
                                </div>
                                <form action="{{ route('two-factor.confirm') }}" method="post" class="flex gap-2">
                                    @csrf
                                    <input placeholder="000 000" id="code" type="text" name="code"
                                        required />
                                    <button type="submit">Activate</button>
                                </form>

                                @if (session()->has('error'))
                                    <div class="text-red-500 text-sm">
                                        {{ session('error') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <form action="/user/two-factor-authentication" method="post">
                    @csrf
                    <button class="btn btn-primary" type="submit">Activate 2FA</button>
                </form>
            @endif
        </div>
    </div>


    <div x-data="{ openDelete: false }" class="mt-25 flex gap-10 flex-wrap md:flex-nowrap">
        <div class="flex flex-col w-full max-w-[300px] gap-2">
            <h1 class="text-[18px] font-bold">Delete account</h1>
            <p class="text-[15px] text-gray-300">
                This action is not reversible. All information related to this account will be deleted permanently.
            </p>
        </div>
        <div>
            <button type="button" @click="openDelete = true"
                class="font-bold cursor-pointer text-[14px] px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded transition">
                Yes, delete my account
            </button>
        </div>

        <div x-show="openDelete" x-transition
            class="fixed inset-0 flex items-center justify-center bg-black/50 backdrop-blur-sm z-50 p-3">
            <div @click.away="openDelete = false" class="bg-272727 rounded-md p-8 w-full max-w-md shadow-lg">
                <h2 class="text-xl font-bold mb-2">Confirm Deletion</h2>
                <p class="mb-6 text-gray-300">
                    This action is not reversible. All information related to this account will be deleted permanently!
                </p>

                <form wire:submit="deleteAccount" method="post">
                    @csrf
                    <div class="flex justify-end gap-3">
                        <button type="button" class="w-full secondary-btn bg-444 hover:bg-input"
                            @click="openDelete = false">
                            Cancel
                        </button>
                        <button type="submit"
                            class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">
                            Delete account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
