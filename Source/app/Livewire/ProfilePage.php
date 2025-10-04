<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Settings;
use App\Models\Videos;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;

class ProfilePage extends Component
{
    public $user;
    public $settings;
    public $allVideos;
    public $isSubscribed;
    public $subscriberCount;
    public $videoSort = 'latest';

    public function mount()
    {
        $username = request()->route('name');

        $this->user = User::where('name', $username)->firstOrFail();

        $this->settings = Settings::where('user_id', $this->user->id)->first();

        $this->allVideos = Videos::where('user_id', $this->user->id)->orderBy('created_at', 'desc')->get();

        $this->isSubscribed = Subscription::where('user_id', Auth::id())
            ->where('subscribed_to_id', $this->user->id)
            ->exists();
    }

    public function setVideoSort($sort)
    {
        $this->videoSort = $sort;
    }

    public function getSortedVideosProperty()
    {
        return match($this->videoSort) {
            'latest' => $this->allVideos->sortByDesc('created_at'),
            'popular' => $this->allVideos->sortByDesc('views'),
            'oldest' => $this->allVideos->sortBy('created_at'),
            default => $this->allVideos
        };
    }

    public function subscribe()
    {
        if (!Auth::check()) {
            return redirect()->route('register');
        }

        $subscribe_to_id = $this->user->id;
        $user_id = Auth::id();
        $subscription = Subscription::where('user_id', $user_id)
            ->where('subscribed_to_id', $subscribe_to_id)
            ->first();

        if ($subscription) {
            $subscription->delete();
            $this->isSubscribed = false;
        } else {
            Subscription::create([
                'user_id' => $user_id,
                'subscribed_to_id' => $subscribe_to_id,
            ]);
            $this->isSubscribed = true;
        }
    }

    public function render()
    {
        $this->subscriberCount = Subscription::where('subscribed_to_id', $this->user->id)->count();

        return view('livewire.profile-page', [
            'user' => $this->user,
            'settings' => $this->settings,
            'videos' => $this->allVideos,
            'sortedVideos' => $this->sortedVideos,
            'isSubscribed' => $this->isSubscribed,
            'subscriberCount' => $this->subscriberCount,
        ]);
    }
}
