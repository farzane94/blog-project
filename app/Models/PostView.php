<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostView extends Model
{
    use HasFactory;
    protected $fillable = ['ip'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
