<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Link extends Model
{
    use HasFactory;

    protected $fillable = ['original_url', 'short_url'];

    public static function generateShortUrl($originalUrl)
    {
        $hashids = substr(md5($originalUrl), 0, 6);
        $link = self::create([
            'original_url' => $originalUrl,
            'short_url' => $hashids,
        ]);
        return $link->short_url;
    }
}
