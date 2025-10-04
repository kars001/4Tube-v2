@section('title', '4Tube - Register')
<x-layouts.auth>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto w-15" src="{{ asset('storage/fav.png') }}" alt="Logo">
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight">Make an account today!</h2>
        </div>

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <p class="text-red-500 text-center">{{ $error }}</p>
            @endforeach
        @endif

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" method="POST" action="{{ route('register') }}">
                @csrf
                <div>
                    <label for="name" class="block text-sm/6 font-medium">Username</label>
                    <div class="mt-1">
                        <input type="text" name="name" id="name" autocomplete="username" required autofocus
                            class="block w-full">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm/6 font-medium">Email address</label>
                    <div class="mt-1">
                        <input type="email" name="email" id="email" autocomplete="email" required
                            class="block w-full">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm/6 font-medium">Password</label>
                    <div class="mt-1">
                        <input type="password" name="password" id="password" autocomplete="password" required
                            class="block w-full">
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm/6 font-medium">Repeat Password</label>
                    <div class="mt-1">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            autocomplete="password" required class="block w-full">
                    </div>
                </div>

                <div class="mt-5">
                    <button type="submit"
                        class="flex w-full justify-center focus-visible:outline-2 focus-visible:outline-offset-2">Register</button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm/6 text-gray-200">
                Already have an account?
                <a href="/login" class="font-semibold">Login here</a>
            </p>
        </div>
    </div>
</x-layouts.auth>
