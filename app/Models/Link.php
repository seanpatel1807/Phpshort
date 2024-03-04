<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Http\Request;

class Link extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'original_url', 'short_url', 'expiration_date', 'space_id', 'pixels_id', 'click_limit', 'expiration_date', 'password', 'access_type','is_disabled'];

    public static function generateShortUrl($request, $originalUrl)
    {
        $customAliasSuffix = $request['custom_alias'];


        if ($customAliasSuffix) {
            $customAliasSuffix = self::generateCustomAliasSuffix($customAliasSuffix);
            $hashids = $customAliasSuffix;
        } else {
            $hashids = self::generateHashids($originalUrl);
        }

        $expirationDate = $request['expiration_date'];
        
        $user = auth()->user();
        $clickLimit=$request['click_limit'];
        // dd($request);
        $link = self::create([
            'original_url' => $originalUrl,
            'short_url' => $hashids,
            'expiration_date' => $expirationDate,
            'user_id' => $user->id,
            'space_id' => $request['space_id'],
            'pixels_id' => $request['pixels_id'],
            'click_limit' =>  $clickLimit,
            'password' => $request['password'],
            'access_type' => $request['access_type'],

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
