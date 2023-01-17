<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function options(){
        return $this->hasMany(Option::class);
    }

    public function categorie(){
        return $this->belongsTo(Category::class);
    }
}
