<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Link extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'original_url', 'short_url', 'expiration_date'];

    public static function generateShortUrl($originalUrl)
    {
        $hashids = substr(md5($originalUrl), 0, 6);
        $expirationDate = now()->addDays(30);
        $user = auth()->user();

        $link = self::create([
            'original_url' => $originalUrl,
            'short_url' => $hashids,
            'expiration_date' => $expirationDate,
            'user_id' => $user->id,
        ]);

        return $link->short_url;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
