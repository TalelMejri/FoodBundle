<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    public function user(){
       return  $this->belongsTo(User::class);
    }

    public function product(){
        return  $this->belongsTo(Product::class);
     }

}
