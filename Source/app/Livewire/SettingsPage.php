<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingsPage extends Component
{
    use WithFileUploads;

    #[Validate('required|min:3|max:25|unique:users,name')]
    public $name;

    #[Validate('nullable|max:1000|string')]
    public $description;

    #[Validate('nullable|image|mimes:png,jpg,gif|max:1024')]
    public $profile_picture;

    #[Validate('nullable|image|mimes:png,jpg,gif|max:1024')]
    public $profile_banner;

    public $profile_picture_preview;

    public $profile_banner_preview;

    #[Validate('required|string|current_password:web')]
    public $current_password;

    #[Validate('required|string|min:8', 'passwordRules')]
    public $new_password;

    #[Validate('required|string|min:8|same:new_password')]
    public $new_password_confirmation;

    public $currentProfilePictureUrl;

    public $currentProfileBannerUrl;

    public $theme;

    public function setData(Settings $settings): void
    {
        foreach ($settings->settings as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function updatedProfilePicture()
    {
        if ($this->profile_picture) {
            $this->profile_picture_preview = $this->profile_picture->temporaryUrl();
        }
    }

    public function updatedProfileBanner()
    {
        if ($this->profile_banner) {
            $this->profile_banner_preview = $this->profile_banner->temporaryUrl();
        }
    }

    public function updateSettings(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'min:3|max:25|unique:users,name,' . Auth::id(),
                'description' => 'nullable|max:1000|string',
            ]);

            if (strlen($this->description) > 1000) {
                $this->dispatch('notify', type: 'info', message: 'Description must not exceed 1000 characters.');
                return;
            }

            if (strlen($this->name) < 3 || strlen($this->name) > 25) {
                $this->dispatch('notify', type: 'info', message: 'Username must be between 3 and 25 characters.');
                return;
            }

            $existingUser = User::where('name', $this->name)
                ->where('id', '!=', Auth::id())
                ->first();

            if ($existingUser) {
                $this->dispatch('notify', type: 'info', message: 'This username is already taken.');
                return;
            }

            $user = User::find(Auth::id());
            $settings = Settings::find(id: Auth::id());

            $profilePicturePath = $settings->settings['profile_picture'] ?? null;
            $profileBannerPath = $settings->settings['profile_banner'] ?? null;

            $disk = Storage::disk('cloudflare');
            $userFolder = '4tubeTesting';

            if ($this->profile_picture && is_object($this->profile_picture)) {
                if ($profilePicturePath && $disk->exists($profilePicturePath)) {
                    $disk->delete($profilePicturePath);
                }

                $shortUniqueName = Str::random(6);
                $extension = $this->profile_picture->getClientOriginalExtension();
                $filename = $shortUniqueName . '.' . $extension;

                $profilePicturePath = $userFolder . '/' . $filename;
                $disk->put($profilePicturePath, file_get_contents($this->profile_picture->getRealPath()), ['name' => $filename]);
            }

            if ($this->profile_banner && is_object($this->profile_banner)) {
                if ($profileBannerPath && $disk->exists($profileBannerPath)) {
                    $disk->delete($profileBannerPath);
                }

                $shortUniqueName = Str::random(6);
                $extension = $this->profile_banner->getClientOriginalExtension();
                $filename = $shortUniqueName . '.' . $extension;

                $profileBannerPath = $userFolder . '/' . $filename;
                $disk->put($profileBannerPath, file_get_contents($this->profile_banner->getRealPath()), ['name' => $filename]);
            }

            $settings->update([
                'settings' => [
                    'description' => $this->description,
                    'profile_picture' => $profilePicturePath,
                    'profile_banner' => $profileBannerPath,
                    'theme' => $this->theme ?? 'default',
                ]
            ]);

            $user->update([
                'name' => $this->name,
            ]);

            $this->dispatch('settingsUpdated');

            if ($this->dispatch('settingsUpdated')) {
                $this->dispatch('notify', type: 'success', message: 'Settings updated successfully.');
            } else {
                $this->dispatch('notify', type: 'error', message: 'Failed to update settings.');
            }
        } catch (\Exception $e) {
            $this->dispatch('notify', type: 'error', message: 'An error occurred while updating settings. Please try again later.');
        }

        redirect()->to(request()->header('Referer'));
    }

    public function updatePassword()
    {
        $user = User::find(Auth::id());

        if (!password_verify($this->current_password, $user->password)) {
            $this->dispatch('notify', type: 'error', message: 'Current password is incorrect.');
            return;
        }

        if (strlen($this->new_password) < 8) {
            $this->dispatch('notify', type: 'info', message: 'New password must be at least 8 characters long.');
            return;
        }

        if ($this->new_password !== $this->new_password_confirmation) {
            $this->dispatch('notify', type: 'error', message: 'New password and confirmation do not match.');
            return;
        }

        if (password_verify($this->new_password, $user->password)) {
            $this->dispatch('notify', type: 'info', message: 'New password must be different from current password.');
            return;
        }

        $user->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->dispatch('passwordUpdated');

        if ($this->dispatch('passwordUpdated')) {
            $this->dispatch('notify', type: 'success', message: 'Password updated successfully.');
        } else {
            $this->dispatch('notify', type: 'error', message: 'Failed to update password.');
        }

        Auth::logout();
        return redirect()->route('login');
    }

    public function deleteAccount()
    {
        $user = User::find(Auth::id());
        $settings = Settings::where('user_id', Auth::id())->first();

        if ($settings) {
            $settings->delete();
        }

        $user->delete();
        Auth::logout();

        return redirect()->route('login');
    }

    public function deleteProfilePicture()
    {
        $settings = Settings::where('user_id', Auth::id())->first();
        $disk = Storage::disk('cloudflare');

        if ($settings && isset($settings->settings['profile_picture'])) {
            $profilePicturePath = $settings->settings['profile_picture'];

            if ($disk->exists($profilePicturePath)) {
                $disk->delete($profilePicturePath);
            }

            $settings->update([
                'settings' => array_merge($settings->settings, [
                    'profile_picture' => null
                ])
            ]);

            $this->dispatch('notify', type: 'success', message: 'Profile picture deleted successfully.');
        }
    }

    public function deleteProfileBanner()
    {
        $settings = Settings::where('user_id', Auth::id())->first();
        $disk = Storage::disk('cloudflare');

        if ($settings && isset($settings->settings['profile_banner'])) {
            $profileBannerPath = $settings->settings['profile_banner'];

            if ($disk->exists($profileBannerPath)) {
                $disk->delete($profileBannerPath);
            }

            $settings->update([
                'settings' => array_merge($settings->settings, [
                    'profile_banner' => null
                ])
            ]);

            $this->dispatch('notify', type: 'success', message: 'Profile banner deleted successfully.');
        }
    }

    public function updateTheme($theme)
    {
        $settings = Settings::where('user_id', Auth::id())->first();
        $settings->update([
            'settings' => array_merge($settings->settings, [
                'theme' => $theme
            ])
        ]);

        $this->dispatch('themeChanged');

        return redirect()->to(request()->header('Referer'));
    }

    public function mount(): void
    {
        $settings = Settings::where('user_id', Auth::id())->first();
        $user = User::find(Auth::id());

        $this->name = $user->name;
        $this->setData($settings);

        $this->currentProfilePictureUrl = $settings && isset($settings->settings['profile_picture'])
            ? asset(Storage::disk('cloudflare')->path($settings->settings['profile_picture']))
            : asset('storage/default.png');

        $this->currentProfileBannerUrl = $settings && isset($settings->settings['profile_picture'])
            ? asset(Storage::disk('cloudflare')->path($settings->settings['profile_picture']))
            : asset('storage/default.png');
    }

    public function render()
    {
        return view('livewire.settings-page', [
            'theme' => $this->theme,
        ]);
    }
}
