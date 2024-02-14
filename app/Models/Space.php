<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    use HasFactory;

    protected $fillable = ['space_name'];
    public $timestamps = true;
    
    public function links()
{
    return $this->hasMany(Link::class,'spaces_id','id');
}
}
