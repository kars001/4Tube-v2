<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Views;
use Laravel\Scout\Searchable;

class Videos extends Model
{
    use Searchable;

    protected $table = 'videos';

    protected $fillable = [
        'user_id',
        'slug',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function views()
    {
        return $this->hasMany(Views::class, 'video_id');
    }

    public function history()
    {
        return $this->hasMany(History::class, 'video_id');
    }

    public function toSearchableArray()
    {
        return [
            'settings' => $this->settings,
            'slug' => $this->slug,
        ];
    }
}
