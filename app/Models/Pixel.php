<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pixel extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'type','users_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
