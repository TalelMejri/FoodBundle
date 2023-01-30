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

    public function Favorites(){
        return $this->hasMany(favorite::class);
    }

    public function rates(){
        return $this->hasMany(Rate::class);
    }

    public function lignecommandes(){
        return $this->hasMany(lignecommande::class);
    }

    public function categorie(){
        return $this->belongsTo(Category::class);
    }
}
