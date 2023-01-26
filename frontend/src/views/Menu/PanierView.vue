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
                        <v-badge class="mx-5 mt-3" color="red"  :content="nbr_panier==0 ? '0' : nbr_panier">
                                <router-link  to="../PanierView" style="text-decoration:none !important">
                                    <v-icon  style="font-size:25px">mdi-cart-outline</v-icon>
                                </router-link>
                        </v-badge>
                    </div>
            </div>
        </v-card>
        <div class="content_menu mx-5 row">
            <div class="col-lg-10">
             <h1>Panier</h1>
                    <v-card elavation="7" style="padding:25px">
                              <div class="row gap-4 p-5 mt-3">
                                  <div class="col-lg-3 mx-2 text-center">
                                     <v-text-field
                                        v-model="search"
                                        @keyup="FetchData()"
                                        append-icon="mdi-magnify"
                                        label="Search"
                                        single-line
                                        hide-details
                                     ></v-text-field>  
                               </div>
                               <v-spacer></v-spacer>
                               <div class="col-lg-3">
                                <router-link to="/">
                                       <v-btn color="#000" style="color:#fff !important">Home</v-btn>
                                </router-link>
                           </div>
                            </div>
                    <v-simple-table>
                      <template v-slot:default>
                        <thead>
                          <tr>
                            <th  class="text-left">
                                Photo
                            </th>
                            <th  class="text-left ">
                                Name
                            </th>
                            <th  class="text-left ">
                                Prix
                            </th>
                            <th class="text-left">
                                Qte
                            </th>
                            <th class="text-left">
                                Show Option
                            </th>
                            <th class="text-left">
                                Total
                            </th>
                            <th class="text-left">
                                Operation
                            </th>
                          </tr>
                        </thead>
                        <tbody v-if="store_products.Products==null">
                          <tr >
                            <td colspan="6" class="text-center">No data available</td>
                          </tr>
                        </tbody>
                        <tbody v-else>
                          <tr
                                v-for="item in store_products.Products"
                                :key="item.id"
                          >
                            <td><img width="80px" height="80px"  :src="item.Product.PhotoProduct" alt=""></td>
                            <td>{{ item.Product.nameProduct }}</td>
                            <td>{{ item.Product.PrixProduct }}</td>
                            <td> <v-chip @click="minus(item.id)">-</v-chip > {{ item.Quantity }} <v-chip @click="plus(item.id)">+</v-chip> </td>
                            <td>
                                <v-select
                                    :items="item.Option_glob"
                                    item-text="name"
                                 >
                                </v-select>
                                <v-select
                                    :items="item.option_Supp"
                                    item-text="name"
                                    item-value="prix"
                             >
                            </v-select>
                            </td>
                            <td>{{ item.prix*item.Quantity }}</td>
                            <td>
                                <v-btn @click="initIndice(item)" class="mx-2 mb-2">
                                    <v-icon>
                                       mdi-delete
                                    </v-icon>  
                               </v-btn>
                            </td>
                          </tr>
                        </tbody>
                      </template>  
                    </v-simple-table>
                  </v-card>
                </div>
                <div class="col-lg-2 py-5 mt-5">
                    <v-card style="padding:15px !important"  class="mt-5 py-5 ">
                        <v-container>
                        <v-row>
                          <p>
                            Sous Total
                          </p>
                          <v-spacer></v-spacer>
                          <p>
                            {{ Prix_Total }}
                          </p>
                        </v-row>
                     </v-container>
                     <v-container>
                        <v-row>
                          <p>
                             Total de la commande
                          </p>
                          <v-spacer></v-spacer>
                          <p>
                            {{ Prix_Total }}
                          </p>
                        </v-row>
                     </v-container>
                         <v-card color="gray"  class="mt-5 py-5 ">
                            <v-btn @click="verifier()" class="mx-5" color="red" style="color:#fff !important">Commander</v-btn>
                         </v-card>
                        <small text-align="center">Commander avec livraison à plusieurs adresses</small>
                    </v-card>
                </div>
                <v-dialog  
                    transition="dialog-bottom-transition"
                    max-width="600"
                    v-model="dialog_delete"
                >
               <template >
                 <v-card>
                   <v-toolbar
                     color="danger"
                     dark
                   >Delete Product</v-toolbar>
                   <v-card-text>
                     Do You Want Delete Product id : {{ product_selected.id }}
                   </v-card-text>
                   <v-card-actions class="justify-end">
                     <v-btn 
                       text
                       @click="deleteProduct()"
                     >Delete</v-btn>
                     <v-btn
                     text
                     @click="dialog_delete=false"
                   >close</v-btn>
                   </v-card-actions>
                 </v-card>
               </template>
             </v-dialog> 
             <v-snackbar
             v-model="snackbar_auth"
         >
              You shoul Add Product First
         <template v-slot:action="{ attrs }">
          <v-btn
            color="pink"
               text
               v-bind="attrs"
               @click="snackbar_auth = false"
          >
            Close
           </v-btn>
          </template>
         </v-snackbar>
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
      <FooterVue></FooterVue>
    </div>
</template>
<script>
import FooterVue from "@/components/home_page/FooterVue.vue";
import InfoClient from "@/components/Client/InfoClient.vue"
import { AuthStore } from "@/store/StoreAuth";
import { ProductStore } from "@/store/StoreProducts";
export default{
    name:'panier',
    created(){
           this.nbr_panier=this.store_products.Products==null ? 0 : this.store_products.Products.length;
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
            nbr_panier:0,
            snackbar_notif:false,
            search:'',
            product_selected:[],
            dialog_delete:false,
            snackbar_auth:false,
            snackbar:false
        }
    },
    methods:{
        recherche_indice(data,id){
            let index=-1;
            let i=0;
            let trouve=false;
            while(i<data.length && trouve==false){
                if(data[i].id==id){
                    index=i;
                    trouve=true;
                }
                i++;
            }
            return index;
        },
        minus(id){
            let indice=this.recherche_indice(this.store_products.Products,id);
            if(this.store_products.Products[indice].Quantity-1>1){
                this.store_products.Products[indice].Quantity-=1;
            }else {
                this.store_products.Products[indice].Quantity=1;
            }
        },
        plus(id){
            let indice=this.recherche_indice(this.store_products.Products,id);
            this.store_products.Products[indice].Quantity+=1;
        },
        initIndice(item){
            this.product_selected=item;
            this.dialog_delete=true;
        },
        deleteProduct(){
            let indice=this.recherche_indice(this.store_products.Products,this.product_selected.id);
            this.store_products.Products.splice(indice,1);
            this.store_products.ClearProducts();
            this.store_products.AddProduct(this.store_products.Products);
            this.dialog_delete=false;
            this.snackbar=true;
        },
        verifier(){
          if( this.nbr_panier>0){
            this.$router.push('/ConfirmerCommandeView');
          }else{
            this.snackbar_auth=true;
          }
            /*if(this.store.isauth!=null){
                this.$router.push('/ConfirmerCommandeView');
            }else{
                this.snackbar_auth=true;
            }*/
        }
    },
    components:{
        InfoClient,FooterVue
    },
    computed:{
        Prix_Total(){
            let prix=0;
            for(let i=0;i<(this.store_products.Products?.length);i++){
                 prix+=(this.store_products.Products[i].prix*this.store_products.Products[i].Quantity)
            }
            return prix;
        }
    }
}
</script>