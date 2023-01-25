<?php

namespace App\Http\Controllers\commande;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\LignCommande;
use App\Models\LignCommandeOption;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function AddCommande(Request $request){

        $total_prix=0;
        for($i=0;$i<count($request->Product);$i++){
            $total_prix+=($request->Product[$i]['prix']*$request->Product[$i]['Quantity']);
        }

        $commade=Commande::create([
            'Nom'=>$request->user['name'],
            'adresse_email'=>$request->user['email'],
            'Ville'=>$request->user['ville'],
            'Pays'=>$request->user['pays'],
            'Code_Postal'=>$request->user['code'],
            'Prenom'=>$request->user['prenom'],
            'Numero_tlf'=>$request->user['tlf'],
            'Adresse'=>$request->user['adresse'],
            'user_id'=>$request->user['userid'],
            'Prix_Total'=>$total_prix
        ]);
        for($i=0;$i<count($request->Product);$i++){
            $ligneCommande=new LignCommande();
            $ligneCommande->Quantity=$request->Product[$i]['Quantity'];
            $ligneCommande->commmandeId=$commade->id;
            $ligneCommande->prix_ligne_commande=$request->Product[$i]['prix'];
            $ligneCommande->ProductId=$request->Product[$i]['Product']['id'];
            $ligneCommande->save();
            for($countopsupp=0;$countopsupp<count($request->Product[$i]['option_Supp']);$countopsupp++){
                $ligneCommandeOptionSupp=new LignCommandeOption();
                $ligneCommandeOptionSupp->nameOption=$request->Product[$i]['option_Supp'][$countopsupp]['name'];
                $ligneCommandeOptionSupp->IdLignCommande=$ligneCommande->id;
                $ligneCommandeOptionSupp->save();
            }
            for($countglobal=0;$countglobal<count($request->Product[$i]['Option_glob']);$countglobal++){
                $ligneCommandeOptionGlobal=new LignCommandeOption();
                $ligneCommandeOptionGlobal->nameOption=$request->Product[$i]['Option_glob'][$countglobal]['name'];
                $ligneCommandeOptionGlobal->IdLignCommande=$ligneCommande->id;
                $ligneCommandeOptionGlobal->save();
            }

        }
        return  response()->json(['commade'=>$commade],200);
    }
}
