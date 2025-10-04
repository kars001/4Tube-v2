<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Likes;
use App\Models\Videos;
use Illuminate\Support\Facades\Auth;

class LikedPage extends Component
{
    public $likedVideosIds;
    public $dislikedVideosIds;

    public function mount()
    {
        $likedVideosIds = Likes::where('user_id', Auth::id())
            ->where('type', 'like')
            ->orderBy('created_at', 'desc')
            ->pluck('video_id');

        $dislikedVideosIds = Likes::where('user_id', Auth::id())
            ->where('type', 'dislike')
            ->orderBy('created_at', 'desc')
            ->pluck('video_id');

        $this->dislikedVideosIds = $dislikedVideosIds;

        $this->likedVideosIds = Videos::whereIn('id', $likedVideosIds)->get();
        $this->dislikedVideosIds = Videos::whereIn('id', $dislikedVideosIds)->get();
    }

    public function render()
    {
        return view('livewire.liked-page', [
            'liked' => $this->likedVideosIds,
            'disliked' => $this->dislikedVideosIds,
        ]);
    }
}
