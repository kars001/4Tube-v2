<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Videos;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class UploadPage extends Component
{
    use WithFileUploads;

    public $video;
    public $thumbnail;
    public $title;
    public $description;
    public $titleError = '';
    public $descriptionError = '';

    protected $messages = [
        'title.max' => 'The title cannot be longer than 100 characters.',
        'description.max' => 'The description cannot be longer than 1000 characters.',
    ];

    public function updated($propertyName)
    {
        if ($propertyName === 'title') {
            if (strlen($this->title) > 100) {
                $this->dispatch('notify', type: 'error', message: 'The title cannot be longer than 100 characters.');
            } else {
                $this->titleError = '';
            }
        }

        if ($propertyName === 'description') {
            if (strlen($this->description) > 1000) {
                $this->dispatch('notify', type: 'error', message: 'The description cannot be longer than 1000 characters.');
            } else {
                $this->descriptionError = '';
            }
        }
    }

    public function uploadVideo(Request $request)
    {
        $validate = [
            'video' => 'required|file|mimes:mp4,mov,mkv,webm|max:307200',
            'thumbnail' => 'required|file|mimes:png,jpg|max:30720',
            'title' => 'required|string|min:1|max:100',
            'description' => 'nullable|string|max:1000',
        ];

        $this->validate($validate);

        $user = User::find(Auth::id());
        $slug = Str::random(10);

        $disk = Storage::disk('cloudflare');
        $userFolder = '4tubeTesting';

        if ($this->video && is_object($this->video)) {
            $shortUniqueName = Str::random(6);
            $extension = $this->video->getClientOriginalExtension();
            $filename = $shortUniqueName . '.' . $extension;

            $videoPath = $userFolder . '/' . $filename;
            $disk->put($videoPath, file_get_contents($this->video->getRealPath()), ['name' => $filename]);
        }

        if ($this->thumbnail && is_object($this->thumbnail)) {
            $shortUniqueName = Str::random(6);
            $extension = $this->thumbnail->getClientOriginalExtension();
            $filename = $shortUniqueName . '.' . $extension;

            $thumbnailPath = $userFolder . '/' . $filename;
            $disk->put($thumbnailPath, file_get_contents($this->thumbnail->getRealPath()), ['name' => $filename]);
        }

        $videos = Videos::create([
            'user_id' => Auth::id(),
            'slug' => $slug,
            'settings' => [
                'title' => $this->title,
                'description' => $this->description,
                'video' => $videoPath ?? null,
                'thumbnail' => $thumbnailPath ?? null,
            ],
            'uploaded_at' => now(),
        ]);

        $this->dispatch('videoUploaded');
        return redirect()->to('/');
    }

    public function render()
    {
        return view('livewire.upload-page');
    }
}
