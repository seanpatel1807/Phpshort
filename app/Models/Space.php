<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    use HasFactory;

    protected $fillable = ['space_name','users_id'];
    public $timestamps = true;
    
    public function links()
{
    return $this->hasMany(Link::class,'space_id','id');
}
public function user()
{
    return $this->belongsTo(User::class);
}
}
