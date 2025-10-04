<?php

namespace App\Livewire;

use App\Models\Subscription;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class SubscriptionPage extends Component
{
    public $user;
    public $isSubscribed;
    public $subscriptionCount;

    public function unsubscribe($subscriptionId)
    {
        $subscription = Subscription::find($subscriptionId);

        if ($subscription && $subscription->user_id === Auth::id()) {
            $subscription->delete();
        }
    }

    public function mount()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('register');
        }
    }

    public function render()
    {

        $this->isSubscribed = Subscription::where('user_id', Auth::id())->get();

        $subscribed = User::whereIn('id', $this->isSubscribed->pluck('subscribed_to_id'))->get();

        $subscribersCount = [];
        foreach ($subscribed as $sub) {
            $subscribersCount[$sub->id] = Subscription::where('subscribed_to_id', $sub->id)->count();
        }

        return view('livewire.subscription-page', [
            'subscribed' => $subscribed,
            'isSubscribed' => $this->isSubscribed,
            'subscriptionCount' => $this->subscriptionCount,
            'subscribersCount' => $subscribersCount,
        ]);
    }
}
