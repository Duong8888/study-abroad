<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TikTokVideo extends Model
{
    use HasFactory;

    // Link hợp lệ: https://www.tiktok.com/@username/video/1234567890
    const URL_PATTERN = '~tiktok\.com/@([\w.\-]+)/video/(\d+)~i';

    protected $fillable = [
        'video_title',
        'video_url',
        'author_username',
    ];

    protected $appends = ['video_id'];

    public function getVideoIdAttribute()
    {
        return preg_match(self::URL_PATTERN, $this->video_url, $matches) ? $matches[2] : null;
    }
}
