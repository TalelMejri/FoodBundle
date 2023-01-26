<template>
    <div>
        <v-card class="header" elavation="3">
            <div class="row">
                    <img src="../../assets/logo.png" width="70px" height="70px" alt="FoodBundle logo">
                    <h3 style="padding:15px"><span style="color:#E84C03;">Food</span>Bundle</h3>
                    <v-spacer></v-spacer>
                    <div v-if="store.isauth!=null">
                        <InfoClient :nbr_panier="nbr_panier" style="padding:15px;padding-right:40px" :menu="'menu'">
                        </InfoClient>
                    </div>
                    <div v-else>
                        <v-badge class="mx-5 mt-3" color="red"  :content="nbr_panier">
                                <router-link  to="../PanierView" style="text-decoration:none !important">
                                    <v-icon  style="font-size:25px">mdi-cart-outline</v-icon>
                                </router-link>
                        </v-badge>
                    </div>
            </div>
        </v-card>
        <div class="content_menu">
            <div class="row">
                <div class="col-lg-10">
                <v-stepper v-model="e1">
                <v-stepper-header>
              <v-stepper-step
                :complete="e1 > 1"
                 step="1"
              >
                Livraison
              </v-stepper-step>
              <v-divider></v-divider>
              <v-stepper-step
                :complete="e1 > 2"
                step="2"
              >
              Vérification et paiment
              </v-stepper-step>
              <v-divider></v-divider>
              <v-divider></v-divider>
              <v-stepper-step
                :complete="e1 > 3"
                step="3"
              >
                Check
              </v-stepper-step>
            </v-stepper-header>
            <v-stepper-items>
              <v-stepper-content step="1">
                <v-card
                    style="padding:15px !important"
                  height="400px"
                  class="mb-5"
                  color="#FFF9EB"
                >
                 <v-form v-model="valid">
                    <div class="row">
                        <div class="col-lg-6">
                            <v-text-field 
                                 :rules="adresseEmailRules"
                                 v-model="adresse_email"
                                  type="text" 
                                  label="adresse email">
                            </v-text-field>
                        </div>
                        <div class="col-lg-6">
                            <v-text-field
                            :rules="nameRules"
                            v-model="Ville"
                             type="text" label="Ville">
                            </v-text-field>
                        </div>
                        <div class="col-lg-6">
                            <v-text-field
                            :rules="nameRules"
                            v-model="Pays"
                             type="text" label="Pays">
                            </v-text-field>
                        </div>
                        <div class="col-lg-6">
                            <v-text-field 
                            :rules="nameRules"
                            v-model="Code"
                            type="text" label="Code postale">
                            </v-text-field>
                        </div>
                        <div class="col-lg-6">
                            <v-text-field
                            :rules="nameRules"
                            v-model="Prenom"
                             type="text" label="Prenom">
                            </v-text-field>
                        </div>
                        <div class="col-lg-6">
                            <v-text-field
                            :rules="nameRules"
                            v-model="Numero"
                             type="text" label="Numero tlf">
                            </v-text-field>
                        </div>
                        <div class="col-lg-6">
                            <v-text-field
                            :rules="nameRules"
                            v-model="Nom"
                             type="text" label="Nom">
                            </v-text-field>
                        </div>
                        <div class="col-lg-6">
                            <v-text-field
                            :rules="nameRules"
                            v-model="Adresse"
                             type="text" label="Adresse">
                            </v-text-field>
                        </div>
                    </div>
                    <v-btn
                    color="#E84C03"
                    class="mx-2"
                      @click="valid==true ? e1 = 2 : e1=1"
                    >
                      Continue
                    </v-btn>
                    <v-btn @click="retourn()" >
                      Cancel
                    </v-btn>
                 </v-form>
                </v-card>
              </v-stepper-content>
              <v-stepper-content step="2">
                <v-card
                  class="mb-12"
                  height="200px"
                >
                Mode de paiment :
                 <div style="font-size:18px;font-weight:600" class="mb-2 mt-2 text-center">
                    {{ Nom +' '+ Prenom }} <br>
                    {{ Adresse }} <br>
                    {{ Pays }} <br>
                    {{ Numero }}
                 </div>
            </v-card>
            <v-btn @click="passCommande()" class="mx-5" color="#000" style="color:#fff !important">
                Valider Commande
            </v-btn>
                <v-btn @click="e1=1">
                  Cancel
                </v-btn>
              </v-stepper-content>

              <v-stepper-content step="3">
                <v-card
                  class="mb-12"
                  height="200px"
                >
                Mode de paiment :
                 <div style="font-size:18px;font-weight:600" class="mb-2 mt-2 text-center">
                   MERCI POUR VOTRE COMMANDE !
                  <br>
                Votre commande # est : {{ code_Commande }}.
                  <br>
                  Nous vous enverrons la confirmation de commande avec les détails et les informations de suivi.
                  <br>
                 </div>
            </v-card>
            <v-btn @click="checkCommande()" class="mx-5" color="#000" style="color:#fff !important">
                Check Commande
            </v-btn>
            <router-link to="/">
            <v-btn class="mx-5" color="#000" style="color:#fff !important">
                Continuer Achats
             </v-btn>
            </router-link>
              </v-stepper-content>
            </v-stepper-items>
          </v-stepper>
        </div>
        <div class="col-lg-2">
            <v-card style="padding:15px !important"  class="mt-5 py-5 ">
                 <div style="background-color: #E84C03;color:#fff;text-align:center;padding:15px">
                    <p>Resume</p>
                    {{ nbr_panier }} Food in panier 
                </div>
                <v-expansion-panels>
                    <v-expansion-panel
                      v-for="(item,i) in store_products.Products"
                      :key="i.id"
                    >
                      <v-expansion-panel-header>
                        {{ item.Product.nameProduct}} 
                      </v-expansion-panel-header>
                      <v-expansion-panel-content>
                         <div class="row">
                            <div class="col-lg-4">
                                <img width="40px" :src="item.Product.PhotoProduct" alt="">
                            </div>
                            <div class="col-lg-4">
                                Qte:{{item.Quantity}}
                            </div>
                            <div class="col-lg-4">
                                Prix:{{item.Quantity*item.prix}}
                            </div>
                         </div>
                      </v-expansion-panel-content>
                    </v-expansion-panel>
                  </v-expansion-panels>
            </v-card>
        </div>

    </div>
    </div>
    <v-snackbar
    v-model="snackbar"
>
 Yous should create an Account <router-link to="signup">Sing Up</router-link>
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
    <FooterVue></FooterVue>
    </div>
</template>

<script>
import service_commande from "@/services/GererCommande/Commande.js";
import FooterVue from "@/components/home_page/FooterVue.vue";
import InfoClient from "@/components/Client/InfoClient.vue"
import { AuthStore } from "@/store/StoreAuth";
import { ProductStore } from "@/store/StoreProducts";
export default{
    name:'Confirmer',
    created(){
           this.nbr_panier=this.store_products.Products==null ? '0' :this.store_products.Products.length;
    },
    setup(){
        const store=AuthStore();
        const store_products=ProductStore();
        return{
            store,store_products
        }
    },

    data(){
        return{
            valid: false,
            nameRules: [
                v => !!v || 'field is required',
                ],
            adresseEmailRules: [
                     v => !!v || 'E-mail is required',
                     v => /.+@.+/.test(v) || 'E-mail must be valid',
            ],
            adresse_email:'',
            code_Commande:0,
            Ville:'',
            Pays:'',
            Code:'',
            Prenom:'',
            Numero:'',
            Nom:'',
            Adresse:'',
            nbr_panier:0,
            snackbar_notif:false,
            search:'',
            product_selected:[],
            dialog_delete:false,
            snackbar_auth:false,
            snackbar:false,
            e1: 1,
        }
    },
    methods:{
        retourn(){
            this.$router.push('/');
        },
        passCommande(){
           let Info_User={
                   name:this.Nom,prenom:this.Prenom,
                   ville:this.Ville,pays:this.Pays,
                   code:this.Code,email:this.adresse_email,
                   tlf:this.Numero,adresse:this.Adresse,
                   userid:this.store.isauth!=null ? this.store.user['id'] : null
                  };
                  this.code_Commande=Math.random(10,99999);
          service_commande.AddCommande({user:Info_User,Product:this.store_products.Products,code_Commande:this.code_Commande}).then((res)=>{
              this.e1=3;
              this.store_products.ClearProducts();
          })
          this.store_products.ClearProducts();
        },
        checkCommande(){
          if(this.store.isauth!=null){
            this.$router.push('../allOrderedProduct');
          }else{
            this.snackbar=true;
          }
        }
    },
    components:{
        InfoClient,FooterVue
    },
  

}
</script>

<style>

</style>