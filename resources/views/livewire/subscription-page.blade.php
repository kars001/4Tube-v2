@section('title', '4Tube - Subscriptions')

<div>
    <h1 class="text-2xl font-bold mb-6">Subscriptions</h1>

    <div class="flex flex-col gap-5">
        @foreach ($subscribed as $user)
            @php
                $settings = $user->settings;
                $profilePicture = $settings->settings['profile_picture'] ?? null;
                $subscription = $isSubscribed->firstWhere('subscribed_to_id', $user->id);
            @endphp
            <a class="my-3 flex items-center gap-5 sm:gap-15" href="{{ route('profile', ['name' => $user->name]) }}">

                @if ($profilePicture)
                    <img src="https://r2.sob.lol/{{ $profilePicture }}"
                        class="w-20 h-20 sm:w-30 sm:h-30 rounded-full object-cover">
                @else
                    <img src="{{ asset('storage/default.png') }}"
                        class="w-20 h-20 sm:w-30 sm:h-30 rounded-full object-cover">
                @endif

                <div class="flex flex-col sm:flex-row sm:items-center justify-between w-full gap-2">
                    <div class="flex flex-col gap-1">
                        <h2 class="font-bold text-2xl text-white">{{ $user->name }}</h2>
                        <p class="text-gray-400 text-[13px]">
                            @if ($subscribersCount[$user->id] == 1)
                                {{ formatCount($subscribersCount[$user->id] ?? 0) }} subscriber
                            @else
                                {{ formatCount($subscribersCount[$user->id] ?? 0) }} subscribers
                            @endif
                        </p>
                        <p class="text-gray-400 text-[13px] hidden md:block">
                            {!! Str::limit(e($settings->settings['description'] ?? null), 100) !!}
                        </p>
                    </div>

                    <form wire:submit.prevent="unsubscribe({{ $subscription->id }})">
                        <x-subscribebtn :origin="$user['id']" :isSubscribed='$isSubscribed' />
                    </form>
                </div>
            </a>
        @endforeach

        @if (count($subscribed) == 0)
            <p class="mt-2 text-gray-300 text-center">No subscriptions found.</p>
        @endif
    </div>
</div>
