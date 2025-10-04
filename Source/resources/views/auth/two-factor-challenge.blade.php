@section('title', '4Tube - 2FA')
<x-layouts.auth>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto w-15" src="{{ asset('storage/fav.png') }}" alt="Logo">
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight">Two Factor Authentication</h2>
            <p class="text-center text-gray-300">Enter the authentication code provided by your authenticator app.</p>
        </div>

        @if (session('status'))
            <p class="text-center">{{ session('status') }}</p>
        @endif

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" method="POST" action="{{ route('two-factor.login') }}">
                @csrf
                <div>
                    <label for="email" class="block text-sm/6 font-medium">Authentication Code</label>
                    <div class="mt-1">
                        <input type="text" name="code" id="code" autocomplete="off" required
                            class="block w-full">
                    </div>
                </div>

                @error('code')
                    <div class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </div>
                @enderror

                <div class="mt-5">
                    <button type="submit"
                        class="flex w-full justify-center focus-visible:outline-2 focus-visible:outline-offset-2">Submit</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.auth>
