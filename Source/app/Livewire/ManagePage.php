<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Videos;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ManagePage extends Component
{
    use WithFileUploads;

    public $allVideos;
    public $editingVideo = null;
    public $editTitle;
    public $editDescription;
    public $newThumbnail;
    public $thumbnail_preview;

    public function deleteVideo($id)
    {
        $video = Videos::find($id);
        Videos::where('id', $id)->delete();

        if ($this->dispatch('settingsUpdated')) {
            $this->dispatch('notify', type: 'success', message: 'Video deleted successfully.');
        } else {
            $this->dispatch('notify', type: 'error', message: 'Failed to delete video.');
        }
    }

    public function startEditing($videoId)
    {
        $video = Videos::find($videoId);
        $this->editingVideo = $videoId;
        $this->editTitle = $video->settings['title'];
        $this->editDescription = $video->settings['description'];
    }

    public function cancelEditing()
    {
        $this->editingVideo = null;
        $this->editTitle = '';
        $this->editDescription = '';
        $this->newThumbnail = null;
    }

    public function saveVideo()
    {
        try {
            $this->validate([
                'newThumbnail' => 'nullable|file|mimes:png,jpg|max:30720',
                'editTitle' => 'required|string|min:1|max:100',
                'editDescription' => 'nullable|string|max:1000',
            ]);

            $video = Videos::find($this->editingVideo);

            
            if (!$video) {
                $this->dispatch('notify', type: 'error', message: 'Video not found.');
                return;
            }

            $settings = $video->settings;
            $settings['title'] = $this->editTitle;
            $settings['description'] = $this->editDescription;

            if ($this->newThumbnail) {
                try {
                    $disk = Storage::disk('cloudflare');
                    $userFolder = '4tubeTesting';

                    if (isset($settings['thumbnail']) && $disk->exists($settings['thumbnail'])) {
                        $disk->delete($settings['thumbnail']);
                    }

                    $shortUniqueName = Str::random(6);
                    $extension = $this->newThumbnail->getClientOriginalExtension();
                    $filename = $shortUniqueName . '.' . $extension;

                    $thumbnailPath = $userFolder . '/' . $filename;
                    $disk->put($thumbnailPath, file_get_contents($this->newThumbnail->getRealPath()), ['name' => $filename]);

                    $settings['thumbnail'] = $thumbnailPath;
                } catch (\Exception $e) {
                    $this->dispatch('notify', type: 'error', message: 'Failed to upload thumbnail: ' . $e->getMessage());
                    return;
                }
            }

            $video->settings = $settings;
            
            if ($video->save()) {
                $this->cancelEditing();
                $this->newThumbnail = null;
                $this->dispatch('settingsUpdated');
                $this->dispatch('notify', type: 'success', message: 'Video updated successfully.');
            } else {
                $this->dispatch('notify', type: 'error', message: 'Failed to save video settings.');
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = collect($e->errors())->flatten()->implode(', ');
            $this->dispatch('notify', type: 'error', message: 'Validation failed: ' . $errors);
        } catch (\Exception $e) {
            $this->dispatch('notify', type: 'error', message: 'An unexpected error occurred: ' . $e->getMessage());
        }
    }

    public function updatedNewThumbnail()
    {
        if ($this->newThumbnail) {
            $this->thumbnail_preview = $this->newThumbnail->temporaryUrl();
        }
    }

    public function mount()
    {
        if (!Auth::check()) {
            return redirect()->route('register');
        }
    }

    public function render()
    {

        $this->allVideos = Videos::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();

        return view('livewire.manage-page', [
            'videos' => $this->allVideos
        ]);
    }
}
