<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = 'subscriptions';
    
    protected $fillable = [
        'user_id',
        'subscribed_to_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscribedTo()
    {
        return $this->belongsTo(User::class, 'subscribed_to_id');
    }
}
