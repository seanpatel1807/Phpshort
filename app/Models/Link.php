<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Link extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'original_url', 'short_url', 'expiration_date','spaces_id','pixels_id'];

    public static function generateShortUrl($request)
{
    $customAlias = $request['custom_alias'];

    if ($customAlias) {
        // Check if the custom alias already exists
        $existingLink = self::where('short_url', $customAlias)->first();

        if ($existingLink) {
            // Custom alias is already taken, generate a unique one
            $customAlias = $customAlias . '_' . uniqid();
        }

        $hashids = $customAlias;
    } else {
        // Generate short URL using a hash of the original URL
        $hashids = substr(md5($request['original_url']), 0, 6);
    }

    $expirationDate = now()->addDays(30);
    $user = auth()->user();

    $link = self::create([
        'original_url' => $request['original_url'],
        'short_url' => $hashids,
        'expiration_date' => $expirationDate,
        'user_id' => $user->id,
        'spaces_id' => $request['space_id'],
        'pixels_id' => $request['pixels_id'],
    ]);

    return $link->short_url;
}
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
