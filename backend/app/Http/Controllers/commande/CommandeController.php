<?php

namespace App\Http\Controllers\commande;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\LignCommande;
use App\Models\LignCommandeOption;
use App\Models\LigneCommandeOption;
use App\Models\Notification;
use Illuminate\Contracts\Database\Eloquent\Builder;
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
            'Prix_Total'=>$total_prix,
            'Code_Commande'=>$request->code_Commande
        ]);

        for($i=0;$i<count($request->Product);$i++){
            $ligneCommande=new LignCommande();
            $ligneCommande->Quantity=$request->Product[$i]['Quantity'];
            $ligneCommande->commande_id=$commade->id;
            $ligneCommande->prix_ligne_commande=$request->Product[$i]['prix'];
            $ligneCommande->product_id=$request->Product[$i]['Product']['id'];
            $ligneCommande->save();

            for($countopsupp=0;$countopsupp<count($request->Product[$i]['option_Supp']);$countopsupp++){
                $ligneCommandeOptionSupp=new ligneCommandeOption();
                $ligneCommandeOptionSupp->nameOption=$request->Product[$i]['option_Supp'][$countopsupp]['name'];
                $ligneCommandeOptionSupp->lign_commande_id=$ligneCommande->id;
                $ligneCommandeOptionSupp->save();
            }

            for($countglobal=0;$countglobal<count($request->Product[$i]['Option_glob']);$countglobal++){
                $ligneCommandeOptionGlobal=new ligneCommandeOption();
                $ligneCommandeOptionGlobal->nameOption=$request->Product[$i]['Option_glob'][$countglobal]['name'];
                $ligneCommandeOptionGlobal->lign_commande_id=$ligneCommande->id;
                $ligneCommandeOptionGlobal->save();
            }
        }

        $notification=new Notification();
        $notification->user_id=1;
        $notification->commande_id=$commade->id;
        $notification->message="Commande Avec Code : ".$request->code_Commande. "Addeed ";
        $notification->save();

        return  response()->json(['commade'=>$notification],200);
    }

    public function deleteCommande($id){
        $commade=Commande::find($id);
        if($commade){
            $commade->delete();
        }else{
            return  response()->json(['message'=>'Not Found'],404);
        }
    }

    public function CommandeForUser(Request $request){
        if($request->code){
            $commandes=Commande::with('ligencommandes')
                                ->where('user_id',$request->id)
                                ->where('Code_commande','like','%'.$request->code.'%')
                                ->paginate(3);
        }else{
            $commandes=Commande::with('ligencommandes')
                                    ->where('user_id',$request->id)
                                    ->paginate(3);
        }
        return response()->json($commandes,200);
          /*if(isset($request->code)){
                $ligneCommande=LignCommande::with('commande','product','ligensOptions')->get();
            }else{
                $ligneCommande=LignCommande::with('commande','product','ligensOptions')->get();
            }
            return response()->json($ligneCommande,200);*/
    }

    public function AllCommande(Request $request){
        if($request->code){
            $commandes=Commande::with('ligencommandes')
                                ->where('Code_commande','like','%'.$request->code.'%')
                                ->where('statu','=',0)
                                ->paginate(3);
        }else{
            $commandes=Commande::with('ligencommandes')
                                 ->where('statu','=',0)
                                ->paginate(3);
        }
        return response()->json($commandes,200);

    }

    public function AllCommandeAccpted(Request $request){
        if($request->code){
            $commandes=Commande::with('ligencommandes')
                                ->where('Code_commande','like','%'.$request->code.'%')
                                ->where('statu','=',1)
                                ->paginate(3);
        }else{
            $commandes=Commande::with('ligencommandes')
                                 ->where('statu','=',1)
                                ->paginate(3);
        }
        return response()->json($commandes,200);

    }

    public function rejeterCommande(Request $request){
       $commade=Commande::find($request->idcommande);
        if($commade){
            if(isset($request->iduser)){
                $notification=new Notification();
                $notification->user_id=$request->iduser;
                $notification->commande_id=null;
                $notification->message="Commande Avec Code : ".$request->code. "a été Rejeter";
                $notification->save();
            }
            $commade->update([
                'statu'=>2
            ]);
        }else{
            return  response()->json(['message'=>'Not Found'],404);
        }
    }

    public function AccepterCommande(Request $request){
        $commade=Commande::find($request->id);
        if(isset($request->iduser)){
            $notification=new Notification();
            $notification->user_id=$request->iduser;
            $notification->commande_id=$commade->id;
            $notification->message="Commande Avec Code : ".$request->code. "a été Accepter";
            $notification->save();
        }
        if($commade){
            $commade->update([
                'statu'=>1
            ]);
        }else{
            return  response()->json(['message'=>'Not Found'],404);
        }
    }


}
