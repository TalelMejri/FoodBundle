<template>
    <div>
        <template>
            <v-row>
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
                        Edit Account
                      </v-btn>
                      </router-link>
                      <router-link v-else to="editProfil" style="text-decoration:none !important;">
                        <v-btn 
                           depressed
                           rounded
                           text
                         >
                       Edit Account
                     </v-btn>
                     </router-link>
                      <v-divider class="my-2"></v-divider>
                      <v-badge  class="mx-5 mt-4"  color="red"
                      :content="All_notif.length==0 ? '0' : All_notif.length">
                  <v-btn  @click="snackbar = true">
                    dd
                  </v-btn>
                      <v-icon  @click="snackbar = true"  color="#000">mdi-bell</v-icon>
                  </v-badge>
                      <v-divider class="my-2"></v-divider>
                      <router-link v-if="menu=='menu'" to="../allOrderedProduct" style="text-decoration:none !important;">
                        <v-btn 
                           depressed
                           rounded
                           text
                         >
                         all Ordered Product
                     </v-btn>
                     </router-link>
                     <router-link v-else to="allOrderedProduct" style="text-decoration:none !important;">
                      <v-btn 
                         depressed
                         rounded
                         text
                       >
                       all Ordered Product
                   </v-btn>
                   </router-link>
                     <v-divider class="my-2"></v-divider>
                     <router-link v-if="menu=='menu'" to="../AllFavoriteProduct" style="text-decoration:none !important;">
                       <v-btn 
                          depressed
                          rounded
                          text
                        >
                        All Favorite Product
                    </v-btn>
                    </router-link>

                    <router-link v-else to="AllFavoriteProduct" style="text-decoration:none !important;">
                      <v-btn 
                         depressed
                         rounded
                         text
                       >
                       All Favorite Product
                   </v-btn>
                   </router-link>
                      <v-divider class="my-2"></v-divider>
                         <v-btn @click="logout()"
                            depressed
                            rounded
                            text
                          >
                           Logout
                          </v-btn>
                    </div>
                  </v-list-item-content>
                </v-card>
              </v-menu>
            </v-row>
          </template>
        <v-snackbar
        v-model="snackbar"
        right
        scroll
      >
          <div v-if="All_notif==''"> 
            No Notification available
        </div>
          <div v-else  class="all_notif" v-for="notif in All_notif" :key="notif.id">
                     <v-btn @click="deleteNotif(notif.id)" text><v-icon>mdi-delete</v-icon></v-btn>
                    {{ notif.message }}
          </div>
        <template v-slot:action="{ attrs }">
          <v-btn
            color="indigo"
            text
            v-bind="attrs"
            @click="snackbar = false"
          >
            Close
          </v-btn>
        </template>
      </v-snackbar>

    </div>
</template>

<script>
import service_notif from "@/services/Notification/notif.js"
import {AuthStore} from "@/store/StoreAuth"
import { ProductStore } from "@/store/StoreProducts";
export default{

  created(){
            this.getnotif();
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
        }
    },
    methods:{
          getnotif(){
              service_notif.getNotification(this.store.user['id']).then((res)=>{
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