<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Videos;
use App\Models\User;
use App\Models\Views;
use App\Models\History;
use App\Models\Likes;
use App\Models\Comments;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;

class VideoPage extends Component
{
    public $video;
    public $user;
    public $views;
    public $hasLiked = false;
    public $hasDisliked = false;
    public $likeCount = 0;
    public $dislikeCount = 0;
    public $comment;
    public $editingCommentId = null;
    public $editingCommentContent = '';
    public $isSubscribed;
    public $subscriberCount;

    public function mount()
    {
        $this->video = Videos::where('slug', request()->route('slug'))->firstOrFail();
        $this->user = User::find($this->video->user_id);
        $this->viewVideo($this->video);
        $this->loadReactionState();
        $this->loadReactionCounts();

        $this->isSubscribed = Subscription::where('user_id', Auth::id())
            ->where('subscribed_to_id', $this->user->id)
            ->exists();
    }

    public function loadReactionCounts()
    {
        $likes = Likes::where('video_id', $this->video->id)->get();

        $this->likeCount = formatCount($likes->where('type', 'like')->count());
        $this->dislikeCount = formatCount($likes->where('type', 'dislike')->count());
    }

    public function loadReactionState()
    {
        $like = Likes::where('user_id', Auth::id())
            ->where('video_id', $this->video->id)
            ->first();

        $this->hasLiked = $like && $like->type === 'like';
        $this->hasDisliked = $like && $like->type === 'dislike';
    }

    public function viewVideo($video)
    {
        $ipAddress = request()->ip();
        $userId = Auth::id();

        $hasViewed = Views::where('user_id', $userId)
            ->where('video_id', $video->id)
            ->where('ip_address', $ipAddress)
            ->exists();

        if (!$hasViewed) {
            Views::create([
                'user_id' => $userId ?? null,
                'video_id' => $video->id,
                'ip_address' => $ipAddress,
            ]);
        }

        $history = History::where('user_id', $userId)
            ->where('video_id', $video->id)
            ->first();

        if ($history) {
            $history->touch();
        } else {
            History::create([
                'user_id' => $userId ?? null,
                'video_id' => $video->id,
            ]);
        }
    }

    public function likeVideo()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($this->hasLiked) {
            $this->removeReaction();
            return;
        }

        $this->removeReaction();

        Likes::create([
            'user_id' => Auth::id(),
            'video_id' => $this->video->id,
            'type' => 'like',
        ]);

        $this->hasLiked = true;
        $this->hasDisliked = false;
        $this->loadReactionCounts();
    }

    public function dislikeVideo()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($this->hasDisliked) {
            $this->removeReaction();
            return;
        }

        $this->removeReaction();

        Likes::create([
            'user_id' => Auth::id(),
            'video_id' => $this->video->id,
            'type' => 'dislike',
        ]);

        $this->hasDisliked = true;
        $this->hasLiked = false;
        $this->loadReactionCounts();
    }

    public function removeReaction()
    {
        Likes::where('user_id', Auth::id())
            ->where('video_id', $this->video->id)
            ->delete();

        $this->hasLiked = false;
        $this->hasDisliked = false;
        $this->loadReactionCounts();
    }

    public function postComment()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (strlen($this->comment) > 1000) {
            $this->dispatch('notify', type: 'info', message: 'A comment must not exceed 1000 characters.');
            return;
        }

        $this->validate([
            'comment' => 'required|string|max:1000',
        ]);

        Comments::create([
            'user_id' => Auth::id(),
            'video_id' => $this->video->id,
            'content' => $this->comment,
        ]);

        $this->comment = '';
    }

    public function editComment($commentId)
    {
        $comment = Comments::find($commentId);

        if ($comment && $comment->user_id === Auth::id()) {
            $this->editingCommentId = $commentId;
            $this->editingCommentContent = $comment->content;
        }
    }

    public function updateComment()
    {
        $comment = Comments::find($this->editingCommentId);

        if (strlen($this->editingCommentContent) > 1000) {
            $this->dispatch('notify', type: 'info', message: 'A comment must not exceed 1000 characters.');
            return;
        }

        $this->validate([
            'editingCommentContent' => 'required|string|max:1000',
        ]);

        if ($comment && $comment->user_id === Auth::id()) {
            $comment->update(['content' => $this->editingCommentContent]);
            $this->editingCommentId = null;
            $this->editingCommentContent = '';
        }
    }

    public function deleteComment($commentId)
    {
        $comment = Comments::find($commentId);

        if ($comment && $comment->user_id === Auth::id()) {
            $comment->delete();
        }
    }

    public function downloadVideo()
    {
        if (!Auth::check()) {
            return redirect()->route('register');
        }

        $video = Videos::find($this->video->id);

        if (!$video || !isset($video->settings['video'])) {
            abort(404, 'Video not found');
        }

        $video2Download = 'https://r2.sob.lol/' . $video->settings['video'];

        $filename = preg_replace('/[^A-Za-z0-9_\-]/', '_', $video->settings['title']);

        $headers = [
            'Content-Type' => 'video/mp4',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response()->stream(function () use ($video2Download) {
            readfile($video2Download);
        }, 200, $headers);
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
            session()->flash('message', 'Unsubscribed successfully.');
        } else {
            Subscription::create([
                'user_id' => $user_id,
                'subscribed_to_id' => $subscribe_to_id,
            ]);
            $this->isSubscribed = true;
            session()->flash('message', 'Subscribed successfully.');
        }
    }

    public function render()
    {
        $comments = Comments::where('video_id', $this->video->id)->orderBy('created_at', 'desc')->get();
        $this->views = formatCount(Views::where('video_id', $this->video->id)->count());
        $this->subscriberCount = Subscription::where('subscribed_to_id', $this->user->id)->count();

        return view('livewire.video-page', [
            'video' => $this->video,
            'user' => $this->user,
            'settings' => $this->user->settings,
            'views' => $this->views,
            'hasLiked' => $this->hasLiked,
            'hasDisliked' => $this->hasDisliked,
            'likeCount' => $this->likeCount,
            'dislikeCount' => $this->dislikeCount,
            'comments' => $comments,
            'isSubscribed' => $this->isSubscribed,
            'subscriberCount' => $this->subscriberCount,
        ]);
    }
}
