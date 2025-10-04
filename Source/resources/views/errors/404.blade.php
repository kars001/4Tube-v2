@section('title', '4Tube - 404 not found')
<x-layouts.auth>
    <div class="flex flex-col items-center justify-center h-screen gap-5">
        <div class="flex flex-col items-center gap-2">
            <h1 class="text-primary font-bold text-7xl">404</h1>
            <h2 class="text-white font-bold text-3xl">Something's missing.</h2>
            <p class="text-gray-300 text-[18px]">Sorry, we can't find that page. You'll find lots to explore on the home page. </p>
        </div>
        <a class="secondary-btn text-white px-5" href="{{ route('home') }}">Back to
            home</a>
    </div>
</x-layouts.auth>
