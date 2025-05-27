<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function views()
    {
        return $this->hasMany(PostView::class);
    }

    public function recordUniqueView(string $ip): void
    {
        if (! $this->views()->where('ip', $ip)->exists()) {
            $this->views()->create(['ip' => $ip]);
        }
    }

}
