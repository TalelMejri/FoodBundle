<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionSpecifique extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function products(){
        $this->belongsTo(Product::class);
    }

}
