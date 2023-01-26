<template>
    <div class="mt-3 py-5">
        <v-container class="mt-3 mb-5">
            <h4 class="text-center">Commande Demander</h4>
            <v-text-field
            v-model="search_demander"
            @keyup="fetchAllcommandeDemaander()"
            append-icon="mdi-magnify"
            label="Search Commande Demander"
            max-width="100"
            single-line
            hide-details
        ></v-text-field>
            <v-row class="mt-2">
            <v-card class="mt-5"  style="padding:25px 15px;margin:0 auto" v-if="AllCommande==''">
                    No Commande Demander
            </v-card>
            <v-card v-else v-for="commande in AllCommande" :key="commande" class="mx-5" style="padding:15px;" max-width="300">
                 <h4 class="text-center mb-4">{{commande.Nom+' '+commande.Prenom}}</h4>
                 <p class="text-center py-2">Commande N°{{commande.Code_Commande}}</p>
                 <div class="text-center py-2">
                    <v-btn class="text-center" color="primary" @click="initIndice(commande)">More Info</v-btn>
                 </div>
                 <v-container>
                 <v-row class="mt-2">
                        <v-btn @click="AccepterCommande(commande.id,commande.user_id)" class="mx-2" style="color:blue" text outlined>Approve</v-btn>
                        <v-btn type="button" @click="initRegeter(commande)" text outlined style="color:red">Remove</v-btn>
                 </v-row>
                </v-container>
            </v-card>
        </v-row>
        </v-container>

    <v-dialog  v-if="commande_selected!=''"
        transition="dialog-bottom-transition"
        max-width="500"
        v-model="dialog"
      >
       <template >
         <v-card>
           <v-toolbar
             color="primary"
             dark
           >Info Commande</v-toolbar>
           <v-card-text>
             <div class="text-h5 text-center pa-12">N°{{commande_selected.Code_Commande}}</div>
             <v-simple-table>
                <template v-slot:default>
                  <thead>
                    <tr>
                      <th  class="text-left ">
                         Food
                      </th>
                      <th  class="text-left ">
                         Prix
                      </th>
                      <th  class="text-left ">
                          Qte
                      </th>
                      <th  class="text-left ">
                          Prix Total
                      </th>
                      <th  class="text-left ">
                          Option
                      </th>
                    </tr>
                  </thead>
                   <tbody>
                    <tr v-for="i in commande_selected.ligencommandes" :key="i.id">
                      <p style="display: none;"> {{index = All_product.find((v)=>v.id=i.product_id)}} </p>
                      <td><img width="70px" height="60px" :src="index.PhotoProduct" alt=""></td>
                      <td>{{index.PrixProduct}}</td>
                      <td>{{i.Quantity}}</td>
                      <td>{{i.prix_ligne_commande}}</td>
                      <div style="display: none;">
                        {{ option_current=[] }}
                        <div v-for="option in All_option" :key="option.id">
                            {{ option.lign_commande_id==i.id ? option_current.push({nameOption:option.nameOption}) : '' }}
                        </div>
                      </div>
                      <td>
                          <v-select
                              :items="option_current"
                              item-text="nameOption"
                             >
                          </v-select> 
                      </td>
                    </tr>
                  </tbody> 
                </template>  
              </v-simple-table>
            </v-card-text>
           <v-card-text>
              <h2>Info Client</h2>
              <v-simple-table>
                <template v-slot:default>
                  <thead>
                    <tr>
                      <th  class="text-left ">
                         Name
                      </th>
                      <th  class="text-left ">
                         Adresse
                      </th>
                      <th  class="text-left ">
                          Pays
                      </th>
                      <th  class="text-left ">
                          tlf
                      </th>
                    </tr>
                  </thead>
                   <tbody>
                     <tr>
                        <td>{{commande_selected.Nom}}</td>
                        <td>{{commande_selected.Adresse}}</td>
                        <td>{{commande_selected.Pays}}</td>
                        <td>{{commande_selected.Numero_tlf}}</td>
                     </tr>
                  </tbody> 
                </template>  
              </v-simple-table>
           </v-card-text>
           <v-card-actions class="justify-end">
             <v-btn
             text
             @click="dialog=false"
           >close</v-btn>
           </v-card-actions>
         </v-card>
       </template>
     </v-dialog> 
     <div class="mt-5 py-5">
        <h4 class="text-center">Commande Accepted</h4>
        <div class="mt-5">
            <v-card elavation="7" style="padding:25px">
             <v-text-field
                 v-model="search"
                 @keyup="fetchAllcommandeAccepter()"
                 append-icon="mdi-magnify"
                 label="Search"
                 single-line
                 hide-details
             ></v-text-field>
             <v-expansion-panels v-if="AllCommandeAccpted==''" focusable>
                No data
             </v-expansion-panels>
             <v-expansion-panels v-else focusable>
                 <v-expansion-panel class="mt-5"
                 v-for="item in AllCommandeAccpted"
                        :key="item.id"
                   >
                   <v-expansion-panel-header >
                     <v-simple-table>
                         <template v-slot:default>
                           <thead>
                             <tr>
                               <th  class="text-left ">
                                 Code Commande
                               </th>
                               <th  class="text-left ">
                                 Prix Total
                               </th>
                              
                               <th  class="text-left ">
                                   Operation
                               </th>
                             </tr>
                           </thead>
                           <tbody>
                                 <td>
                                     {{ item.Code_Commande }}
                                 </td>
                                 <td>
                                     {{ item.Prix_Total }}
                                 </td>
                                 <td>
                                      <v-btn text @click="initcommande(item)">
                                          <v-icon>mdi-delete</v-icon>
                                      </v-btn>
                                 </td>
                           </tbody>
                           </template>
                           </v-simple-table>
                   </v-expansion-panel-header>
                   <v-expansion-panel-content>
                     <v-simple-table>
                         <template v-slot:default>
                           <thead>
                             <tr>
                               <th  class="text-left ">
                                  Food
                               </th>
                               <th  class="text-left ">
                                  Prix
                               </th>
                               <th  class="text-left ">
                                   Qte
                               </th>
                               <th  class="text-left ">
                                   Prix Total
                               </th>
                               <th  class="text-left ">
                                   Option
                               </th>
                             </tr>
                           </thead>
                            <tbody>
                             <tr v-for="i in item.ligencommandes" :key="i.id">
                               <p style="display: none;"> {{index = All_product.find((v)=>v.id=i.product_id)}} </p>
                               <td><img width="80px" height="80px" :src="index.PhotoProduct" alt=""></td>
                               <td>{{index.PrixProduct}}</td>
                               <td>{{i.Quantity}}</td>
                               <td>{{i.prix_ligne_commande}}</td>
                               <div style="display: none;">
                                 {{ option_current=[] }}
                                 <div v-for="option in All_option" :key="option.id">
                                     {{ option.lign_commande_id==i.id ? option_current.push({nameOption:option.nameOption}) : '' }}
                                 </div>
                               </div>
                               <td>
                                   <v-select
                                       :items="option_current"
                                       item-text="nameOption"
                                      >
                                   </v-select> 
                               </td>
                             </tr>
                           </tbody> 
                         </template>  
                       </v-simple-table>
                   </v-expansion-panel-content>
                 </v-expansion-panel>
               </v-expansion-panels>
       </v-card>
     </div>
     
     <v-dialog  v-if="commande_selected_rejeter!=''"
     transition="dialog-bottom-transition"
     max-width="600"
     v-model="dialog_rejeter"
   >
    <template>
      <v-card>
        <v-toolbar
          color="danger"
          dark
        >Rejeter Commande</v-toolbar>
        <v-card-text>
        
          <div class="text-h4 pa-12">Code :{{commande_selected_rejeter.Code_Commande}}</div>
        </v-card-text>
        <v-card-actions class="justify-end">
          <v-btn 
            text
            @click="RejeterCommande(commande_selected_rejeter.id,commande_selected_rejeter.user_id,commande_selected_rejeter.Code_Commande)"
          >Rejeter</v-btn>
          <v-btn
          text
          @click="dialog_rejeter=false"
        >close</v-btn>
        </v-card-actions>
      </v-card>
    </template>
  </v-dialog> 


   <v-dialog v-if="commande_selected_deleted!=''"
     transition="dialog-bottom-transition"
     max-width="600"
     v-model="dialog_deleted"
   >
    <template >
      <v-card>
        <v-toolbar
          color="danger"
          dark
        >Delete Commande</v-toolbar>
        <v-card-text>
          <div class="text-h4 pa-12">Code :{{commande_selected_deleted.Code_Commande}}</div>
        </v-card-text>
        <v-card-actions class="justify-end">
          <v-btn 
            text
            @click="deleteCommande(commande_selected_deleted.id)"
          >Delete</v-btn>
          <v-btn
          text
          @click="dialog_deleted=false"
        >close</v-btn>
        </v-card-actions>
      </v-card>
    </template>
  </v-dialog> 
     <v-snackbar
     v-model="snackbar"
 >
  Delete Completed With Success
 <template v-slot:action="{ attrs }">
  <v-btn
    color="pink"
       text
       v-bind="attrs"
       @click="snackbar = false"
  >
    Close
   </v-btn>
  </template>
 </v-snackbar>
     </div>
    </div>
</template>

<script>
import service_product from "@/services/GererProduct/GererProduct";
import service_option from "@/services/GererOption/option";
import service_commande from "@/services/GererCommande/Commande"
export default{
    name:'commande',
    created(){
        this.fetchAllcommandeDemaander();
        this.fetchAllcommandeAccepter();
        service_product.getProducts().then((res)=>{
              this.All_product=res.data;
           });
           service_option.getAllOption().then((res)=>{
              this.All_option=res.data;
           });
    },
    data(){
        return{
            AllCommande:[],
            AllCommandeAccpted:[],
            commande_selected_deleted:[],
            search:'',
            commande_selected:[],
            commande_selected_rejeter:[],
            dialog_rejeter:false,
            All_option:[],
            dialog_deleted:false,
            All_product:[],
            search_demander:'',
            snackbar:false,
        }
    },
    methods:{
        initRegeter(item){
            this.commande_selected_rejeter=item;
            this.dialog_rejeter=true;
        },
        RejeterCommande(icommande,iduser,code){
           service_commande.rejeterCommande(icommande,iduser,code).then((res)=>{
                this.commande_selected_rejeter=[];
                this.dialog_rejeter=false;
                this.fetchAllcommandeDemaander();
           })
        },
        AccepterCommande(id,iduser){
            service_commande.AccepterCommande(id,iduser).then((res)=>{
                console.log(res);
                this.fetchAllcommandeDemaander();
                this.fetchAllcommandeAccepter();
            })
        },
        initcommande(item){
             this.commande_selected_deleted=item;
             this.dialog_deleted=true;
        },
        deleteCommande(id){
        service_commande.deleteCommande(id).then((res)=>{
           this.commande_selected_deleted=[];
           this.dialog_deleted=false;
           this.snackbar=true;
           this.fetchAllcommandeAccepter();
        })
      },
        initIndice(item){
            this.commande_selected=item;
            this.dialog=true;
        },
        fetchAllcommandeDemaander(){
            service_commande.AllCommande(this.search_demander,1).then((res)=>{
                 this.AllCommande=res.data.data;
            })
        },
        fetchAllcommandeAccepter(){
            service_commande.AllCommandeAccpted(this.search,1).then((res)=>{
                 this.AllCommandeAccpted=res.data.data;
            })
        },
    }
}
</script>