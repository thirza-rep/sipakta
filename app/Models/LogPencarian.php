<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogPencarian extends Model
{
    use HasFactory;

    protected $table = 'log_pencarian';

    protected $fillable = [
        'user_id',
        'kata_kunci',
        'hasil_count',
        'waktu',
    ];

    protected $casts = [
        'waktu' => 'datetime',
    ];

    /**
     * Get the user who performed the search
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Create a new search log entry
     */
    public static function log(int $userId, string $keyword, int $resultCount = 0): self
    {
        return self::create([
            'user_id' => $userId,
            'kata_kunci' => $keyword,
            'hasil_count' => $resultCount,
            'waktu' => now(),
        ]);
    }
}
