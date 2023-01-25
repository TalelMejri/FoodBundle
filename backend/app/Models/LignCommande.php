<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LignCommande extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function commande(){
        return $this->belongsTo(Commande::class);
     }

    public function product(){
        return $this->belongsTo(Product::class);
     }

     public function ligensOptions(){
        return $this->hasmany(LignCommandeOption::class);
     }



}
