<template>
    <div>
        <template>
            <v-row>
              <v-menu class="overflow-y-auto"
              max-height="400" 
              transition="slide-x-transition"
              style="z-index:9999 !important" offset-y>
       <template v-slot:activator="{ on: menu, attrs }">
      <v-badge 
       class="mx-5 mt-4"  color="red"
       :content="All_notif_yet.length==0 ? '0' : All_notif_yet.length">
       <v-tooltip bottom>
        <template v-slot:activator="{ on: tooltip }">
          <v-btn  text   v-bind="attrs"
          v-on="{ ...tooltip, ...menu }"> 
            <v-icon  color="#000">
                mdi-bell
            </v-icon>
           </v-btn>
        </template>
        <span>Notification</span>
      </v-tooltip>
      </v-badge>
    </template>
        <v-toolbar>
            <v-toolbar-title class="row gap-5" style="font-size:15px">
                    <div class="col-lg-6">
                      <v-btn :disabled="All_notif_yet.length==0" text>
                          View Read    ({{  All_notif_yet.length }} ) 
                      </v-btn>
                    </div>
                    <v-spacer></v-spacer>
                    <div class="col-lg-3">
                      <v-btn @click="DeleteAllNotif()">
                        <v-icon>mdi-delete</v-icon>
                      </v-btn>
                    </div>
            </v-toolbar-title>
        </v-toolbar>
        <v-list  style="overflow-y:scroll;max-height:300px">
          <v-list-item v-if="All_notif==''">
            <v-list-item-title class="mb-1">Pas de notification</v-list-item-title>
         </v-list-item>
          <v-list-item
            v-else
            v-for="(item) in All_notif"
            :key="item.id"
          >
            <v-list-item-title  class="mb-1" :style=" item.etat==0 ? 'font-weight:600;cursor:pointer' : 'color:gray' "  @click="Seenotification(item.id)">{{ item.message }} <v-btn  text @click="deleteNotif(item.id)"> <v-icon color="red">mdi-delete</v-icon></v-btn></v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
                  <v-badge  class="mx-5 mt-3" color="red"  :content="nbr_panier==0 ? '0' : nbr_panier">
                       <v-btn text >
                            <router-link style="text-decoration:none !important" to="../PanierView">
                                <v-icon  style="font-size:25px">mdi-cart-outline</v-icon>
                              </router-link>
                       </v-btn>
              </v-badge>
              <v-menu>
                <template v-slot:activator="{ on }">
                  <v-btn
                    icon
                    x-large
                    v-on="on"
                  >
                    <v-avatar
                      size="48"
                    >
                    <img :src="'http://127.0.0.1:8000'+store.user['Photo']" alt="">
                    </v-avatar>
                  </v-btn>
                </template>
                <v-card>
                  <v-list-item-content class="justify-center">
                    <div class="mx-auto text-center">
                      <v-avatar>
                         <img :src="'http://127.0.0.1:8000'+store.user['Photo']" alt="">
                      </v-avatar>
                      <h3>{{store.user['name']}}</h3>
                      <p class="text-caption mt-1">
                        {{store.user['lastname']}}
                      </p>
                      <v-divider class="my-2"></v-divider>
                      <router-link v-if="menu=='menu'" to="../editProfil" style="text-decoration:none !important;">
                         <v-btn 
                            depressed
                            rounded
                            text
                          >
                          Modifier le compte
                      </v-btn>
                      </router-link>
                      <router-link v-else to="editProfil" style="text-decoration:none !important;">
                        <v-btn 
                           depressed
                           rounded
                           text
                         >
                         Modifier le compte
                     </v-btn>
                     </router-link>
                      <v-divider class="my-2"></v-divider>
                      <router-link v-if="menu=='menu'" to="../allOrderedProduct" style="text-decoration:none !important;">
                        <v-btn 
                           depressed
                           rounded
                           text
                         >
                         Liste Produit commandé
                     </v-btn>
                     </router-link>
                     <router-link v-else to="allOrderedProduct" style="text-decoration:none !important;">
                      <v-btn 
                         depressed
                         rounded
                         text
                       >
                       Liste Produit commandé
                   </v-btn>
                   </router-link>
                     <v-divider class="my-2"></v-divider>
                     <router-link v-if="menu=='menu'" to="../AllFavoriteProduct" style="text-decoration:none !important;">
                       <v-btn 
                          depressed
                          rounded
                          text
                        >
                        Liste Produits préféré
                    </v-btn>
                    </router-link>

                    <router-link v-else to="AllFavoriteProduct" style="text-decoration:none !important;">
                      <v-btn 
                         depressed
                         rounded
                         text
                       >
                       Liste Produits préféré
                   </v-btn>
                   </router-link>
                      <v-divider class="my-2"></v-divider>
                         <v-btn @click="logout()"
                            depressed
                            rounded
                            text
                          >
                          Se déconnecter
                          </v-btn>
                    </div>
                  </v-list-item-content>
                </v-card>
              </v-menu>
            </v-row>
          </template>
      

    </div>
</template>

<script>
import service_notif from "@/services/Notification/notif.js"
import {AuthStore} from "@/store/StoreAuth"
import { ProductStore } from "@/store/StoreProducts";
export default{
      mounted(){
        window.Echo.channel('public').listen('notif',(e)=>{
            this.getnotif();
            this.getNotifNotyet();
          })
      },
  created(){
            this.getnotif();
            this.getNotifNotyet();
        },
  props:{
    menu:String,
    nbr_panier:Number
  },
    setup() {
    const store = AuthStore();
    const Store_Product = ProductStore();
    return {
      store,Store_Product
    };
  },
    data(){
        return{
            snackbar:false,
            All_notif:[],
            snackbar_edit:false,
            snackbar_notif:false,
            All_notif_yet:[]
        }
    },
    methods:{
          getNotifNotyet(){
              service_notif.getNotification(this.store.user['id']).then((res)=>{
                 this.All_notif_yet=res.data;
              })
            },
            Seenotification(id){
              service_notif.changeretat(id).then((res)=>{
                  this.getnotif();
                  this.getNotifNotyet();
                  this.$router.push('allOrderedProduct');
              })
            },
            DeleteAllNotif(){
              service_notif.deleteAllNotif(this.store.user['id']).then((res)=>{
                  console.log('delete');
                  this.getNotif();
                  this.getNotifNotyet();
              })
          },
          
          getnotif(){
              service_notif.getAllNotification(this.store.user['id']).then((res)=>{
                 this.All_notif=res.data;
              })
            },
            deleteNotif(id){
              service_notif.deleteNotification(id).then((res)=>{
                 this.getnotif();
              })
            },
         logout(){
           this.store.logout();
           this.Store_Product.ClearProducts();
          if(this.menu=='menu'){
            this.$router.push('../login');
          }else{
            this.$router.push('login');
          }
        
        },
    }
}
</script>