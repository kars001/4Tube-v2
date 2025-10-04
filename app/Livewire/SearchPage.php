<?php

namespace App\Livewire;

use App\Models\Settings;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Videos;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class SearchPage extends Component
{
    public Collection $videoResults;
    public Collection $userResults;
    public $settingsByIds = [];
    public $subscriberCount = [];
    public $isSubscribed = [];

    public function mount()
    {
        $this->videoResults = collect();
        $this->userResults = collect();

        $query = request('query');

        if (empty($query) || trim($query) === '+') {
            $this->dispatch('notify', type: 'error', message: 'A search term cannot be empty.');
            return redirect()->back();
        }

        $this->videoResults = Videos::search($query)->get();
        $this->userResults = User::search($query)->get();

        $userIds = $this->userResults->pluck('id');
        $this->settingsByIds = Settings::whereIn('user_id', $userIds)->get()->keyBy('user_id');
    }

    public function subscribe($subscribe_to_id)
    {
        if (!Auth::check()) {
            return redirect()->route('register');
        }

        $user_id = Auth::id();
        $subscription = Subscription::where('user_id', $user_id)
            ->where('subscribed_to_id', $subscribe_to_id)
            ->first();

        if ($subscription) {
            $subscription->delete();
        } else {
            Subscription::create([
                'user_id' => $user_id,
                'subscribed_to_id' => $subscribe_to_id,
            ]);
        }
    }

    public function render()
    {
        if ($this->userResults) {
            foreach ($this->userResults as $user) {
                $this->subscriberCount[$user->id] = formatCount(
                    Subscription::where('subscribed_to_id', $user->id)->count()
                );
                $this->isSubscribed[$user->id] = Subscription::where('user_id', Auth::id())
                    ->where('subscribed_to_id', $user->id)
                    ->exists();
            }
        }

        return view('livewire.search-page', [
            'userResults' => $this->userResults,
            'videoResults' => $this->videoResults,
            'settingsByIds' => $this->settingsByIds,
            'subscriberCount' => $this->subscriberCount,
            'isSubscribed' => $this->isSubscribed,
        ]);
    }
}
