<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable =['title', 'description', 'image', 'user_id', 'category_id' ];


    public function Category(){
        return $this->belongsTo('App\Models\Category');
    }


    
}

