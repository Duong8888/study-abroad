<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TikTokVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'video_title',
        'video_url',
        'author_username',
    ];
}
