<template>
    <div>
        <template>
            <v-row>
                  <v-badge  class="mx-5 mt-3" color="red"  :content="nbr_panier==0 ? '0' : nbr_panier">
                       <v-btn text :disabled="nbr_panier==0">
                            <router-link to="../PanierView">panier</router-link>
                       </v-btn>
                    <v-icon @click="snackbar_notif = true" style="font-size:25px">mdi-cart-outline</v-icon>
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
                      <v-badge    color="red"
                      content="6">
                      <v-btn @click="snackbar_notif = true">
                        ddd
                      </v-btn>
                    <!--<v-icon color="#000">mdi-bell</v-icon>-->
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
          v-model="snackbar_notif"
            right
            scroll
        >
          <template v-slot:action="{ attrs }">
            <v-btn
              color="indigo"
              text
              v-bind="attrs"
              @click="snackbar_notif = false"
            >
              Close
            </v-btn>
          </template>
        </v-snackbar>
    </div>
</template>

<script>
import {AuthStore} from "@/store/StoreAuth"
import { ProductStore } from "@/store/StoreProducts";
export default{
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
            snackbar_edit:false,
            snackbar_notif:false,
        }
    },
    methods:{
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