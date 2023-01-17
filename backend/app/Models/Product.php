<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function optionspecifiques(){
        return $this->hasMany(OptionSpecifique::class);
    }

    public function categorie(){
        return $this->belongsTo(Category::class);
    }
}
