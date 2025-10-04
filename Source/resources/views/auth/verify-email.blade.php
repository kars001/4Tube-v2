@section('title', '4Tube - Verify Email')
<x-layouts.auth>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto w-15" src="{{ asset('storage/fav.png') }}" alt="Logo">
            <h2 class="mt-10 text-center text-2xl/8 font-bold tracking-tight">Almost there!<br>
                Please verify your email.</h2>
            <p class="text-center text-gray-300 mt-3">Verify your email by clicking the link in your inbox. Can't find
                it?
                Check
                your spam folder.</p>
        </div>
    </div>
</x-layouts.auth>
