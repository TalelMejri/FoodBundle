<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ligneCommandeOption extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function lignecommande(){
        return $this->belongsTo(ligncommande::class);
     }

}
