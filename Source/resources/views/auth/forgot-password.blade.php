@section('title', '4Tube - Reset Password')
<x-layouts.auth>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto w-15" src="{{ asset('storage/fav.png') }}" alt="Logo">
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight">Reset your password</h2>
            <p class="text-center text-gray-300">Enter your email and we'll send you a link to reset your password.</p>
        </div>

        @if (session('status'))
            <p class="text-center">{{ session('status') }}</p>
        @endif

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div>
                    <label for="email" class="block text-sm/6 font-medium">Email address</label>
                    <div class="mt-1">
                        <input type="email" name="email" id="email" autocomplete="email" required
                            class="block w-full">
                    </div>
                </div>

                <div class="mt-5">
                    <button type="submit"
                        class="flex w-full justify-center focus-visible:outline-2 focus-visible:outline-offset-2">Reset
                        password</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.auth>
