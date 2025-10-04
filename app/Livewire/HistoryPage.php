<?php

namespace App\Livewire;

use App\Models\Videos;
use App\Models\History;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\helpers;

class HistoryPage extends Component
{
    public $videos;

    public function clearHistory()
    {
        $userId = Auth::id();

        History::where('user_id', $userId)->delete();

        $this->dispatch('notify', type: 'success', message: 'History cleared successfully.');
    }

    public function render()
    {
        $userId = Auth::id();

        $this->videos = Videos::select('videos.*')
            ->join('histories', 'videos.id', '=', 'histories.video_id')
            ->where('histories.user_id', $userId)
            ->orderBy('histories.updated_at', 'desc')
            ->get();

        return view('livewire.history-page', [
            'videos' => $this->videos
        ]);
    }
}
