<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Videos;
use App\Models\Likes;
use Illuminate\Support\Facades\DB;

class TrendingPage extends Component
{
    public $videos;

    public function render()
    {
        $this->videos = Videos::select('videos.*')
            ->leftJoin('likes', function ($join) {
                $join->on('videos.id', '=', 'likes.video_id')
                    ->where('likes.type', '=', 'like');
            })
            ->groupBy('videos.id')
            ->orderByRaw('COUNT(likes.id) DESC')
            ->take(10)
            ->get();

        return view('livewire.trending-page', [
            'videos' => $this->videos
        ]);
    }
}
