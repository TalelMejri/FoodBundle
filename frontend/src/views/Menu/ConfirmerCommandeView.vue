<template>
    <div>
      <div class="sidebar_position">    
        <SideBar :etatsidbar="etatsidbar" :border_radius="'no'" @changreetat="changreetat" ></SideBar>
      </div>
      <div  class="content"  :class=" etatsidbar==true ? 'close ' : '' "> 
        <v-card class="header" elavation="3">
            <div class="row">
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
                    height="950px"
                    class="mb-5"
                    color="#FFF9EB"
                >
                 <form @submit.prevent="onSubmit()">
                    <div class="row">
                        <div class="col-lg-6">
                            <v-text-field 
                                  v-model="formdata.adresse_email"
                                  :error-messages="adresse_email_error"
                                  type="text" 
                                  label="adresse email">
                            </v-text-field>
                           
                        </div>
                        <div class="col-lg-6">
                            <v-text-field
                             v-model="formdata.Ville"
                             :error-messages="ville_error"
                              type="text" label="Ville">
                            </v-text-field>
                        </div>
                        <div class="col-lg-6">
                          <v-select
                          :items="region"
                          label="Pays"
                          class="mt-3"
                          v-model="formdata.Pays"
                          :error-messages="pays_error"
                          outlined
                        ></v-select>
                            
                        </div>
                        <div class="col-lg-6">
                            <v-text-field 
                            v-model="formdata.Code"
                            :error-messages="Code_error"
                            type="text" label="Code postale">
                            </v-text-field>
                            
                        </div>
                        <div class="col-lg-6">
                            <v-text-field
                            v-model="formdata.Prenom"
                            :error-messages="prenom_error"
                             type="text" label="Prenom">
                            </v-text-field>
                           
                        </div>
                        <div class="col-lg-6">
                            <v-text-field
                            v-model="formdata.Numero"
                            :error-messages="Numero_error"
                             type="text" label="Numero tlf">
                            </v-text-field>
                           
                        </div>
                        <div class="col-lg-6">
                            <v-text-field 
                            v-model="formdata.Nom"
                            :error-messages="Nom_error"
                             type="text" label="Nom">
                            </v-text-field>
                           
                        </div>
                        <div class="col-lg-6">
                            <v-text-field
                            v-model="formdata.Adresse"
                            :error-messages="Adresse_error"
                             type="text" label="Adresse">
                            </v-text-field>
                       
                        </div>
                    </div>
                    <div class="text-center">
                    <v-btn
                    color="#E84C03"
                    class="mx-2 mb-2"
                    type="submit"
                      @click="e1 = 2 "
                    >
                      continuer
                    </v-btn>
                    <v-btn @click="retourn()" >
                      fermer
                    </v-btn>
                  </div>
                 </form>
                </v-card>
              </v-stepper-content>
              <v-stepper-content step="2">
                <v-card
                  class="mb-12"
                  height="200px"
                  style="padding:25px"
                >
                Mode de paiment :
                 <div style="font-size:18px;font-weight:600" class="mb-2 mt-2 text-center">
                    {{ this.formdata.Nom +' '+ this.formdata.Prenom }} <br>
                    {{this.formdata. Adresse }} <br>
                    {{ this.formdata.Pays }} <br>
                    {{ this.formdata.Numero }}
                 </div>
            </v-card>
            <div class="text-center">
            <v-btn :loading="load" @click="passCommande()" class="mx-5 mb-2" color="#000" style="color:#fff !important">
                Valider Commande
            </v-btn>
                <v-btn @click="e1=1">
                  Fermer
                </v-btn>
              </div>
              </v-stepper-content>
              <v-stepper-content step="3">
                <v-card
                  class="mb-12"
                  height="50%"
                  style="padding:35px"
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
            <div class="text-center">
            <v-btn @click="checkCommande()" class="mx-5 mb-2" color="#000" style="color:#fff !important">
                Check Commande
            </v-btn>
            <router-link style="text-decoration:none" to="/">
            <v-btn class="mx-5 mb-2" color="#000" style="color:#fff !important">
                Continuer Achats
             </v-btn>
            </router-link>
          </div>
              </v-stepper-content>
            </v-stepper-items>
          </v-stepper>
        </div>
        <div class="col-lg-2">
            <v-card style="padding:15px !important"  class="mt-5 py-5 ">
                 <div style="background-color: #E84C03;color:#fff;text-align:center;padding:15px">
                    <p>Resume</p>
                    {{ nbr_panier }} Food Dans panier 
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
 Vous devez créer un compte <router-link to="signup">S'incrire</router-link>
<template v-slot:action="{ attrs }">
 <v-btn
   color="pink"
      text
      v-bind="attrs"
      @click="snackbar = false"
 >
   Fermer
  </v-btn>
 </template>
</v-snackbar>
    <FooterVue></FooterVue>
    </div>
    </div>
</template>
<script>
import Vue from 'vue'
import VueConfetti from 'vue-confetti'
Vue.use(VueConfetti)
import SideBar from "@/components/SideBar.vue"
import service_commande from "@/services/GererCommande/Commande.js";
import FooterVue from "@/components/home_page/FooterVue.vue";
import InfoClient from "@/components/Client/InfoClient.vue"
import { AuthStore } from "@/store/StoreAuth";
import { ProductStore } from "@/store/StoreProducts";
import { required, email, minLength,numeric, maxLength } from 'vuelidate/lib/validators'
export default{
    name:'Confirmer',
    created(){
           this.initDonees();
           this.nbr_panier=this.store_products.Products==null ? '0' :this.store_products.Products.length;
    },
    setup(){
        const store=AuthStore();
        const store_products=ProductStore();
        return{
            store,store_products 
        }
    },
    validations: {
  
      formdata:{
               adresse_email:{
                  required,email
               }, 
               Ville:{
                required
               },
               Pays:{
                required
               },
               Code:{
                required,numeric
               },
               Prenom:{
                  required,
                  min: minLength(4),
                  max:maxLength(9)
               },
               Numero:{
                required,
                numeric,
                min:minLength(8),
                max:maxLength(8)
               },
               Nom:{
                required,
                min:minLength(4),
                max:maxLength(8)
               },
               Adresse:{
                required
               },
        },
     },
    data(){
        return{
            valid: false,
            load:false,
            formdata:{
               adresse_email:'',
               Ville:'',
               Pays:'',
               Code:'',
               Prenom:'',
               Numero:'',
               Nom:'',
               Adresse:'',
            },
            code_Commande:0,
            nbr_panier:0,
            snackbar_notif:false,
            search:'',
            region:[
              "Ariane",
              "Béja",
              "Bizerte",
              "Ben Arous",
              "Tataouine",
              "tozeur",
              "Tunisie",
              "Jendouba",
              "Zaghouan",
              "Siliana",
              "Sousse",
              "Sidi Bouzid",
              "Sfax",
              "gabes",
              "gbili",
              "Kasserine",
              "Gafsa",
              "Kairouan",
              "El Kef",
              "Médenine",
              "Monastir",
              "Manouba",
              "Mahdia",
              "Nabeul",
            ],
            product_selected:[],
            dialog_delete:false,
            snackbar_auth:false,
            snackbar:false,
            e1: 1,
            etatsidbar:true
        }
    },
    methods:{
      initDonees(){
        if(this.store.isauth){
          this.formdata.Prenom=this.store.user['name'];
          this.formdata.Nom=this.store.user['lastname'];
          this.formdata.adresse_email=this.store.user['email'];
          this.formdata.Numero=this.store.user['numero_tlf'];
        }
      },
      testnumber(a){
        for(let i=0;i<a.length;i++){
          if((a.charAt[i]<'0')|| (a.charAt[i]>'9')){
              return false;
          }
          return true;
        }
      },
      changreetat(a){
        this.etatsidbar=a;
      },
        retourn(){
            this.$router.push('/');
        },
        onSubmit(){
          this.$v.formdata.$touch();
          if(this.$v.formdata.$invalid){
             this.e1=1;
             return;
          }
        },
        passCommande(){
          this.load=true;
                  let Info_User={
                      name:this.formdata.Nom,prenom:this.formdata.Prenom,
                      ville:this.formdata.Ville,pays:this.formdata.Pays,
                      code:this.formdata.Code,email:this.formdata.adresse_email,
                      tlf:this.formdata.Numero,adresse:this.formdata.Adresse,
                      userid:this.store.isauth!=null ? this.store.user['id'] : null
                  };
                  this.code_Commande=Math.floor(Math.random() * 99999);// nom,prenom,adresse
          service_commande.AddCommande({user:Info_User,Product:this.store_products.Products,code_Commande:this.code_Commande}).then((res)=>{
              this.load=false; 
              this.e1=3;
              this.store_products.ClearProducts();
              this.$confetti.start();
              setTimeout(()=>this.$confetti.stop(),2000);
              setTimeout(()=>this.$router.push('PanierView'),2500);
              setTimeout(()=>this.$router.go(),2800);
          })
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
        InfoClient,FooterVue,SideBar
    },     
    computed:{
            adresse_email_error(){
            const errors=[];
              if (!this.$v.formdata.adresse_email.$dirty) return errors;
                !this.$v.formdata.adresse_email.required && errors.push('adresse Email obligatoire');
                !this.$v.formdata.adresse_email.email && errors.push('email invalid');
                return errors;
            },
            ville_error(){
            const errors=[];
              if (!this.$v.formdata.Ville.$dirty) return errors;
                !this.$v.formdata.Ville.required && errors.push('Ville obligatoire');
                return errors;
            },
            Adresse_error(){
            const errors=[];
              if (!this.$v.formdata.Adresse.$dirty) return errors;
                !this.$v.formdata.Adresse.required && errors.push('Adresse obligatoire');
                return errors;
            },
            pays_error() {
              const errors = [];
              if (!this.$v.formdata.Pays.$dirty) return errors;
              !this.$v.formdata.Pays.required &&
                errors.push("pays obligatoire ");
             return errors;
            },
            Code_error(){
              const errors=[];
              if (!this.$v.formdata.Code.$dirty) return errors;
                !this.$v.formdata.Code.required && errors.push('Code obligatoire');
                !this.$v.formdata.Code.numeric && errors.push('Code doit étre numerique');
                return errors;
            },
            prenom_error(){
              const errors=[];
              if (!this.$v.formdata.Prenom.$dirty) return errors;
                !this.$v.formdata.Prenom.required && errors.push('Code obligatoire');
                !this.$v.formdata.Prenom.max && errors.push('veuillez enter prenom avec maximum de 9 caractéres ');
                !this.$v.formdata.Prenom.min && errors.push('veuillez enter prenom avec minimum de 4 caractéres ');
                return errors;
            },
            Nom_error(){
              const errors=[];
              if (!this.$v.formdata.Nom.$dirty) return errors;
                !this.$v.formdata.Nom.required && errors.push('Nom obligatoire');
                !this.$v.formdata.Nom.max && errors.push('veuillez enter Nom avec maximum de 8 caractéres ');
                !this.$v.formdata.Nom.min && errors.push('veuillez enter Nom avec minimum de 4 caractéres ');
                return errors;
            },
            Numero_error(){
              const errors=[];
             if (!this.$v.formdata.Numero.$dirty) return errors;
               !this.$v.formdata.Numero.required && errors.push('numero obligatoire');
               !this.$v.formdata.Numero.maxLength && errors.push('Veuillez entrer numero avec un maximum de 8 number');
               !this.$v.formdata.Numero.minLength && errors.push('Veuillez entrer numero avec un minimum de 8 number');
               !this.$v.formdata.Numero.numeric && errors.push('numero tlf doit etre entier');
             return errors;
            },
          }
  

}
</script>

<style>
.error {
  border: 1px solid red;
  border-radius: 5px;
  padding: 5px;
  color: white !important;
}
</style>