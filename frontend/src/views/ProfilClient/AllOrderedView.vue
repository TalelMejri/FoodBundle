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
               <v-card elavation="7" style="padding:25px">
                <h4 class="text-center py-4">List Ordered</h4>
                <v-text-field
                    v-model="search"
                    @keyup="fetchdata()"
                    append-icon="mdi-magnify"
                    label="Search"
                    single-line
                    hide-details
                ></v-text-field>
                <v-expansion-panels v-if="All_Commande==''" focusable>
                   No data
                </v-expansion-panels>
                <v-expansion-panels v-else focusable>
                    <v-expansion-panel class="mt-5"
                    v-for="item in All_Commande"
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
                                    statu
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
                                   <td v-if="item.statu==1">
                                            Valider 
                                   </td>
                                   <td v-else-if="item.statu==0">
                                           En Cours 
                                  </td>
                                  <td v-else>
                                           Rejeter 
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
        <v-dialog  v-if="commande_selected!=''"
        transition="dialog-bottom-transition"
        max-width="600"
        v-model="dialog"
      >
       <template >
         <v-card>
           <v-toolbar
             color="danger"
             dark
           >Delete Commande</v-toolbar>
           <v-card-text>
             <div class="text-h4 pa-12">Code :{{commande_selected.Code_Commande}}</div>
           </v-card-text>
           <v-card-actions class="justify-end">
             <v-btn 
               text
               @click="deleteCommande(commande_selected.id)"
             >Delete</v-btn>
             <v-btn
             text
             @click="dialog=false"
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
        <div class="py-5 mt-5">
          <FooterVue class="py-5 mt-5"></FooterVue>
        </div>
    </div>
</template>

<script>
import service_commande from "@/services/GererCommande/Commande.js";
import service_product from "@/services/GererProduct/GererProduct";
import service_option from "@/services/GererOption/option";
import FooterVue from "@/components/home_page/FooterVue.vue";
import InfoClient from "@/components/Client/InfoClient.vue";
import { AuthStore } from "@/store/StoreAuth";
import { ProductStore } from "@/store/StoreProducts";
export default{
    created(){
           this.fetchdata();
           service_product.getProducts().then((res)=>{
              this.All_product=res.data;
           });
           service_option.getAllOption().then((res)=>{
              this.All_option=res.data;
           });
           this.changerPage(1);
           this.nbr_panier=this.store_products.Products==null ? 0 :this.store_products.Products.length;
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
            commande_selected:[],
            snackbar:false,
            pagination:{
                curentpage:1,
                nextpage:0,
                prevpage:0,
                total:0,
                per_page:0,
            },
            loader:false,
            search:'',
            All_option:[],
            All_Commande:[],
            dialog:false,
            All_product:[],
        }
    },
    methods:{
     changerPage(num){
        this.pagination.curentpage=num;
        this.fetchdata();
      },
      fetchdata(){
        service_commande.CommandeForUser(this.store.user['id'],this.search,this.pagination.curentpage).then((res)=>{
            this.All_Commande=res.data.data;
            this.pagination.prevpage=res.data.prev_page_url?.split("=")[1];
            this.pagination.nextpage=res.data.next_page_url?.split("=")[1];
            this.pagination.per_page=res.data.per_page;
            this.pagination.total=res.data.total;
        })
      },
      initcommande(item){
        this.commande_selected=item;
        this.dialog=true;
      },
      deleteCommande(id){
        service_commande.deleteCommande(id).then((res)=>{
           console.log(res.data);
           this.commande_selected=[];
           this.dialog=false;
           this.snackbar=true;
        })
      }
    },
    components:{
        FooterVue,InfoClient
    }
}
</script>