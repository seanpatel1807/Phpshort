<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Link extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'original_url', 'short_url', 'expiration_date', 'spaces_id', 'pixels_id'];

    public static function generateShortUrl($request, $originalUrl)
    {
        $customAliasSuffix = $request['custom_alias'];

        if ($customAliasSuffix) {
            $customAliasSuffix = self::generateCustomAliasSuffix($customAliasSuffix);
            $hashids = $customAliasSuffix;
        } else {
            $hashids = self::generateHashids($originalUrl);
        }

        $expirationDate = now()->addDays(30);
        $user = auth()->user();

        $link = self::create([
            'original_url' => $originalUrl,
            'short_url' => $hashids,
            'expiration_date' => $expirationDate,
            'user_id' => $user->id,
            'spaces_id' => $request['space_id'],
            'pixels_id' => $request['pixels_id'],
        ]);

        return $link->short_url;
    }

    private static function generateCustomAliasSuffix($suffix)
    {
        $existingLink = self::where('short_url', $suffix)->first();

        if ($existingLink) {
            $suffix = $suffix . '_' . uniqid();
        }

        return $suffix;
    }

    private static function generateHashids($originalUrl)
    {
        return substr(md5($originalUrl), 0, 6);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
