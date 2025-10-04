@props(['origin', 'isSubscribed'])
@vite('resources/js/confetti.js')

@if (Auth::check() && Auth::id() !== $origin)
    <button id="subscribe"
        class="rounded-full text-[15px] w-fit bg-primary cursor-pointer font-bold text-main px-6 py-2 transition hover:bg-primary-hover">
        {{ $isSubscribed ? 'Unsubscribe' : 'Subscribe' }}
    </button>
@endif
