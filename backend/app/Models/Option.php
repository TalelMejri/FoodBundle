<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function products(){
        return $this->belongsTo(Product::class);
    }

    public function categories(){
        return $this->belongsTo(Category::class);
    }


}
