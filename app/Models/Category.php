<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable =['name', 'description', 'cover_image'];

    public function contents(){
        return $this->hasMany('App\Models\Content');
    }
}
