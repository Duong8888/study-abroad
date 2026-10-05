<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationRequest extends Model
{
    use HasFactory;

    // Giá trị 0 và 1 giữ nguyên ý nghĩa cũ để không ảnh hưởng dữ liệu đã có
    const STATUS_NEW = 0;
    const STATUS_DONE = 1;
    const STATUS_PROCESSING = 2;
    const STATUS_UNREACHABLE = 3;

    const STATUSES = [
        self::STATUS_NEW,
        self::STATUS_PROCESSING,
        self::STATUS_DONE,
        self::STATUS_UNREACHABLE,
    ];

    protected $fillable = [
        'name',
        'phone_number',
        'content',
        'email',
        'status',
        'note',
        'source',
        'handled_at',
    ];

    protected $casts = [
        'status' => 'integer',
        'handled_at' => 'datetime',
    ];
}
