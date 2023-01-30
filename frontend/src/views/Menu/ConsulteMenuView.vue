<template>
    <div class="all">
      <div class="sidebar_position">    
        <SideBar :etatsidbar="etatsidbar" :border_radius="'no'" @changreetat="changreetat" ></SideBar>
      </div>
     <div  class="content"  :class=" etatsidbar==true ? 'close ' : '' "> 
      <v-card class="header" elavation="3">
        <div class="row ">
                <h3 style="padding:15px"><span style="color:#E84C03;">Food</span>Bundle</h3>
                <v-spacer></v-spacer>
                <div v-if="store.isauth!=null">
                    <InfoClient :nbr_panier="nbr_panier" style="padding:15px;padding-right:40px" :menu="'menu'">
                    </InfoClient>
                </div>
                <div v-else>
                    <v-badge class="mx-5 mt-3" color="red"  :content="nbr_panier==0 ? '0' : nbr_panier">
                       <v-btn text >
                        <router-link style="text-decoration:none !important" to="../PanierView">
                           <v-icon  style="font-size:25px">mdi-cart-outline</v-icon>
                        </router-link>
                       </v-btn>
                    </v-badge>
                </div>
        </div>
    </v-card>
      <div class="content_menu text-center" v-if="loader=false">
          <v-progress-circular
              indeterminate
              color="red"
         ></v-progress-circular>
      </div>
      <div v-else>
        <div class="content_menu">
            <div class="row">
                <div  class="col-lg-2 text-center">
                <v-card
                    style="padding:25px"
                    class="justify-center"
                    max-width="400" elavation="5"> 
              <v-row class="mb-3">
                 <h4>Filter Par </h4>
                 <v-spacer></v-spacer>
                 <v-icon>mdi-menu</v-icon>
              </v-row>
              <div class="mt-5 ">
                    <v-select
                        :items="types"
                        item-text="name"
                        item-value="id"
                        @change="MaxPrix()"
                        v-model="id_category"
                        label="Catégorie"
                    ></v-select>
              </div>
              <div class="mt-3">
                <v-slider
                        v-model="prix"
                         :label="prix +'TND'"
                         :min="min"
                         @change="FetchData()"
                        :max="max"
                        thumb-label
              ></v-slider>
              </div>
              <div class="mt-3">
                <v-select
                :items="Ordered"
                @change="FetchData()"
                v-model="type_Ordered_produdct"
                label="Trier par"
            ></v-select>
              </div>
            </v-card>
        </div>
        <div class="col-lg-10 ">
                <div class="row">
                  
                     <div class="col-lg-3 text-center">
                        <p style="color:#E84C03;font-weight:600" > {{ name_category?.toUpperCase() }}</p>
                     </div>

                     <div class="col-lg-4 text-center">
                        <v-text-field
                            v-model="search"
                            append-icon="mdi-magnify"
                            label="Recherché par Nom Produit"
                            single-line
                            hide-details
                        ></v-text-field>
                     </div>
                     <v-spacer></v-spacer>
                     <div class="col-lg-2 text-center">
                        <v-btn @click="affichage='list'" class="mx-2" :color="affichage=='list' ? 'deep-purple lighten-2' : ''">
                           <v-icon>mdi-format-list-bulleted</v-icon>
                        </v-btn>
                      <v-btn  @click="affichage='card'" :color="affichage=='card' ? 'deep-purple lighten-2' : ''">
                           <v-icon>mdi-view-comfy</v-icon>
                      </v-btn>
                     </div>
                </div>
                          <div class="row mt-4"   >
                             <v-card style="padding:25px;" class="text-center" v-if="Products==''">
                              Aucun produit pour cette catégorie
                             </v-card>
                            <v-card v-else  v-for="product in Products" :key="product.id"
                               class=" mx-2 my-5 col-lg-5"
                                     max-width="300"
                                    >
                                    <div v-if="affichage=='card'">
                                     <v-img
                                       height="200"
                                        :src="product.PhotoProduct"
                                     ></v-img>
                                     <v-card-title>{{product.nameProduct}}
                                        <v-spacer></v-spacer>
                                           <h3>{{ product.PrixProduct}} TND</h3>
                                      </v-card-title>
                                         <v-card-text>
                                        <v-row
                                          align="center"
                                          class="mx-0 mt-3"
                                       >
                                       <v-col>
                                     <v-rating
                                         :value="Nombre_rate_for_products.findIndex((v)=>v.id==product.id)!=-1 ? Nombre_rate_for_products[Nombre_rate_for_products.findIndex((v)=>v.id==product.id)].Avg : 0"
                                         color="amber"
                                         dense
                                         :readonly="true"
                                         size="14"
                                      ></v-rating>
                                      
                                       <div class="grey--text ms-4">
                                       
                                       {{Nombre_rate_for_products.findIndex((v)=>v.id==product.id)!=-1 ? Nombre_rate_for_products[Nombre_rate_for_products.findIndex((v)=>v.id==product.id)].Avg : 0}}
                                       </div>
                                      </v-col>
                                       <v-spacer></v-spacer>
                                     <div class="mb-4 mx-5 mt-2">
                                        <v-btn text  @click="AddFavorite(product.id)">
                                            <v-icon>mdi-{{ All_Liked.find((v)=>v.id==product.id)==undefined ? 'heart-outline' : 'heart' }}</v-icon>
                                          </v-btn>
                                        {{ Nombre_liked_for_products.findIndex((v)=>v.id==product.id)!=-1 ? Nombre_liked_for_products[Nombre_liked_for_products.findIndex((v)=>v.id==product.id)].nbr : 0 }} 
                                    </div>
                                    <v-tooltip bottom>
                                      <template v-slot:activator="{ on, attrs }">
                                        <v-btn 
                                        v-bind="attrs"
                                        v-on="on"
                                        class="mx-2"
                                        fab
                                        dark
                                        small
                                        :disabled="check_rate_user.find((v)=>v.user_id== (store.isauth==null ? 0 : store.user['id'])  && v.product_id==product.id)==undefined ? false : true"
                                         color="yellow"
                                        @click="ShowDialogAddArate(product)"
                                      >
                                       <v-icon color="dark" >
                                          mdi-star-box
                                       </v-icon>
                                       </v-btn>
                                      </template>
                                      <span>Ajouter rate</span>
                                    </v-tooltip>
                                  </v-row>
                                </v-card-text>
                              <v-divider class="mx-4"></v-divider>
                              <v-btn style="width:100%" class="text-center mt-2 mb-1"
                               color="deep-purple lighten-2"
                               @click="InitIndice(product)" 
                              >
                                 Commander
                             </v-btn>
                            </div>
                          <div v-else>
                              <v-list-item >
                                <v-list-item-content>
                                  <v-spacer></v-spacer>
                                  <div class="mb-4">
                                        <v-icon @click="AddFavorite(product.id)">mdi-heart-outline</v-icon>
                                  </div>
                                  <v-list-item-title class="text-h5 mb-1">
                                    {{product.nameProduct}}
                                  </v-list-item-title>
                                    <div class="float-left mt-5">
                                      <p style="display:none">{{ index = All_Prix_With_Option_Array.findIndex((v)=>v.id==product.id) }}</p>   
                                      <h3>{{ index !=-1 ? All_Prix_With_Option_Array[index].prix : product.PrixProduct}} TND</h3>
                                    </div>
                                    <v-rating
                                    :value="Nombre_rate_for_products.findIndex((v)=>v.id==product.id)!=-1 ? Nombre_rate_for_products[Nombre_rate_for_products.findIndex((v)=>v.id==product.id)].Avg : 0"
                                    color="amber"
                                    dense
                                    half-increments
                                    readonly
                                    size="14"
                                  ></v-rating>
                                  
                                   <div class="grey--text ms-4">
                                    <v-tooltip bottom>
                                      <template v-slot:activator="{ on, attrs }">
                                        <v-btn 
                                        v-bind="attrs"
                                        v-on="on"
                                        class="mx-2"
                                        fab
                                        dark
                                        small
                                        :disabled="check_rate_user.find((v)=>v.user_id== (store.isauth==null ? 0 : store.user['id'])  && v.product_id==product.id)==undefined ? false : true"
                                         color="yellow"
                                        @click="ShowDialogAddArate(product)"
                                      >
                                       <v-icon color="dark" >
                                          mdi-star-box
                                       </v-icon>
                                       </v-btn>
                                      </template>
                                      <span>Ajouter rate</span>
                                    </v-tooltip>
                                    {{Nombre_rate_for_products.findIndex((v)=>v.id==product.id)!=-1 ? Nombre_rate_for_products[Nombre_rate_for_products.findIndex((v)=>v.id==product.id)].Avg : 0}} 
                                   </div>
                                  </v-list-item-content>
                                <v-list-item-avatar
                                  tile
                                  size="80"
                                >
                               <img :src="product.PhotoProduct" alt=""> 
                              </v-list-item-avatar>
                              </v-list-item>
                              <v-card-actions>
                                <v-btn style="width:100%" class="text-center mt-2 mb-1"
                                color="deep-purple lighten-2"
                                @click="InitIndice(product)" 
                               >
                                  Commander
                              </v-btn>
                              </v-card-actions>
                            </div>
                      <v-dialog v-model="dialog"
                        transition="dialog-top-transition"
                        max-width="500"
                        v-if="product_selected!=''"
                      >
                        <template >
                          <v-card class="p-5">
                            <v-toolbar
                             color="deep-purple lighten-2"
                              dark
                             >Info Pour {{ product_selected.nameProduct }}
                        </v-toolbar>
                        <div >
                        <v-list-item class="text-center" >
                          <v-list-item-avatar
                            tile
                            size="200"
                          >
                         <img :src="product_selected.PhotoProduct" alt=""> 
                        </v-list-item-avatar>
                          <v-list-item-content>
                            <v-list-item-title  class="mb-1">
                              <h2> {{product_selected.nameProduct}}</h2>
                            </v-list-item-title>
                              <div >
                                <h3> <v-chip  
                                  class="ma-2"
                                  color="orange"
                                  label
                                  outlined
                               >{{ product_selected.PrixProduct }} TND</v-chip></h3>
                              </div>
                            </v-list-item-content>
                        </v-list-item>
                      </div>
                                <h2 class="text-center mb-2 mx-2 mt-2">
                                      Choix
                                </h2>
                                <div class="mx-3 justify-center" v-if="All_Option_Global==''">
                                   Pas le choix
                                </div>
                                <div v-else  class="mx-3  justify-center">
                                  <v-combobox
                                     v-model="OptionsAdded_Selected"
                                      :items="All_Option_Global"
                                      item-text="nameOption"
                                      item-value="id"
                                      label="Option"
                                      multiple
                                      outlined
                                      solo
                                      clearable
                                 ></v-combobox>
                              </div>
                                <h2 class="text-center  mx-2 mt-2">
                                  Supplément
                                </h2>
                                <div class="mx-2  justify-center" v-if="product_selected.optionspecifiques==''">
                                  pas le choix
                                </div>
                                <div v-else>
                                <v-chip-group 
                                  class="mx-3  justify-center mb-3"
                                >
                                  <v-chip 
                                     v-for="i in product_selected.optionspecifiques" :key="i.id"
                                     class="ma-2"
                                        for="id"
                                        label
                                        outlined   
                                        @change="addOption(i.nameOptionSpecifique,i.prixOptionSpecifique)"
                                        :color="OptionsAdded.find((v)=>{ if(v.name==i.nameOptionSpecifique && v.idproduct==product_selected.id){ return true} else { return false } }) ? '#E84C03' :  '' "
                                  >
                                  <v-tooltip bottom>
                                    <template v-slot:activator="{ on, attrs }">
                                      <v-btn
                                        text
                                        v-bind="attrs"
                                        v-on="on"
                                      >
                                      {{ i.nameOptionSpecifique }}
                                      <input   @change="addOption(i.nameOptionSpecifique,i.prixOptionSpecifique)" class="mx-2" type="checkbox" :checked="OptionsAdded.find((v)=>{ if(v.name==i.nameOptionSpecifique && v.idproduct==product_selected.id){ return true} else { return false } }) ? 'checked' :  '' " id="id">
                                      </v-btn>
                                    </template>
                                    <span> {{ i.prixOptionSpecifique }} TND</span>
                                  </v-tooltip>
                                  </v-chip>
                                </v-chip-group>
                              </div>
                              <v-divider></v-divider>
                              <div class="text-center py-4">
                                    <h3> Prix Total : <v-chip  class="ma-2"
                                     color="orange"
                                     label
                                     outlined>
                                    <p style="display:none">{{ index = All_Prix_With_Option_Array.findIndex((v)=>v.id==product_selected.id) }} {{ total= index !=-1 ? All_Prix_With_Option_Array[index].prix + product_selected.PrixProduct : product_selected.PrixProduct  }}</p><input type="hidden" v-model="total">{{ index !=-1 ? All_Prix_With_Option_Array[index].prix + product_selected.PrixProduct : product_selected.PrixProduct}} TND</v-chip></h3>
                                  <h3>Quantité :<v-chip 
                                      color="#E84C03"
                                      label
                                      outlined><v-chip small @click="Qte> 1 ? Qte-=Qte : Qte=1">-</v-chip><input class="input_number text-center" type="text" min="1" v-model="Qte"/><v-chip small @click="Qte+=1">+</v-chip></v-chip> </h3> 
                              </div>
                            <v-card-actions class="justify-center">
                              <v-btn class="mx-2"
                              color="deep-purple lighten-2"
                              @click="AddPanier()"
                            >Commander</v-btn>
                              <v-btn
                                @click="dialog = false"
                              >fermer</v-btn>
                            </v-card-actions>
                       </v-card>
                        </template>
                      </v-dialog>
                  <v-dialog
                      v-if="productrate!=''"
                      persistent
                      max-width="290"
                      v-model="dialog_rate"
                    >
                      <v-card>
                        <v-card-title class="text-h5">
                          {{productrate.nameProduct}}
                        </v-card-title>
                        <v-card-text>ratiez ce product</v-card-text>
                        <v-card-text class="text-center">
                          <v-rating
                          v-model="rating"
                            color="amber"
                            dense
                            size="25"
                       ></v-rating>
                        </v-card-text>
                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn
                            color="black"
                            style="color:#fff !important"
                            @click="addrate(productrate.id,rating)"
                          >
                            Add
                          </v-btn>
                          <v-btn
                            color="gray"
                            @click="productrate = false"
                          >
                            Close
                          </v-btn>
                        </v-card-actions>
                      </v-card>
                    </v-dialog>

                    </v-card>
                </div>
            </div>
        </div>
         <div class="text-center">
              <v-btn class="mx-2" :disabled="pagination.prev_page==null"  @click="changerpage(pagination.current_page-1)">
               <v-icon>mdi-arrow-left</v-icon>
              </v-btn>
              <v-btn  class="mx-2" v-for="num in (Math.ceil(pagination.per_page ? pagination.total/pagination.per_page : 1))" :key="num"
                  :disabled="num==pagination.current_page" @click="changerpage(num)">
                  {{ num }}
              </v-btn>
              <v-btn :disabled="pagination.next_page==null" @click="changerpage(pagination.current_page+1)">
                <v-icon>mdi-arrow-right</v-icon>
              </v-btn>
         </div>
        </div>
        <ServiceVue></ServiceVue>
        <FooterVueVue></FooterVueVue>
      </div>
      </div>
      <v-snackbar 
                 class="v-snack"
                  color="green"
                  top
                 v-model="snackbar_added_panier"
                >
                 votre commande a été bien enregistrer <router-link to="../PanierView">check Panier</router-link>  
                <template >
                  <v-btn
                    color="#fff"
                    text
                   
                    @click="snackbar_added_panier = false"
                  >
                    Fermer
                  </v-btn>
                </template>
              </v-snackbar>
              <v-snackbar
              class="v-snack"
                color="red"
                v-model="snackbar_authentificate"
              >
              Vous devriez créer un compte <router-link to="../signup"><small>Tapez ici</small></router-link>
                  <v-btn
                    color="#fff"
                    text
                  
                    @click="snackbar_authentificate = false"
                  >
                    Fermer
                  </v-btn>
              </v-snackbar>
    </div>
</template>
<script>
import SideBar from "@/components/SideBar.vue"
import service_user from "@/services/GererUser/GererUser";
import { AuthStore } from "@/store/StoreAuth";
import { ProductStore } from "@/store/StoreProducts";
import preloaderVue from "@/components/preloader.vue";
import service_category from "@/services/GererCategory/category";
import InfoClient from "@/components/Client/InfoClient.vue";
import ServiceVue from "@/components/home_page/ServiceVue.vue";
import FooterVueVue from "@/components/home_page/FooterVue.vue";
import service_product from "@/services/GererProduct/GererProduct";
import service_option from "@/services/GererOption/option";
import ServiceaddProducts from "@/services/AddProductsInPinia/AddProductsInPinia.js";
export default{
    name:'menu',
    setup(){
        const store=AuthStore();
        const store_products=ProductStore();
        return{
            store,store_products
        }
    },
    mounted(){
      if(this.store.isauth!=null){
          this.get_all_liked();
        }
    },
    created(){
        this.id_category=parseInt(this.$route.params.id);
        service_category.getAllTypeCategory().then((response)=>{
            for(let i=0;i<(response.data).length;i++){
                this.types.push({name:response.data[i].name,id:response.data[i].id});
            }
        });
       this.checkrate();
      
        if(this.store.isauth!=null){
          this.get_all_liked();
        };
        this.panier_product=this.store_products.Products ? this.store_products.Products : [] ;
        this.CoutProduct();
        this.FetchData();
        this.GetOptionGlobal();
        this.MaxPrix();
        this.length_panier();
        this.changerpage(1);
        this.countRate();
    },
    data(){
        return{ 
           Qte:1,
           OptionsAdded:[],
           prix: 0,
           dialog:false,
           check_rate_user:[],
           selected:[],
           search:'',
           Products_max:[],
           All_Liked:[],
           displaySnackBar:true,
           affichage:'card',
           Ordered: ['nameProduct','PrixProduct'],
           types:[],
           nbr_panier:0,
           pagination:{
            current_page:1,
            next_page:0,
            prev_page:0,
            per_page:0,
            total:0
           },
           Products:[],
           Nombre_rate_for_products:[],
           All_Option_Global:[],
           productrate:[],
           OptionsAdded_Selected:[],
           id_category:0,
           nbr_rate:0,
           total:0,
           type_Ordered_produdct:'',
           product_selected:0,
           All_Prix_With_Option_Array:[],
           panier_product:[],
           snackbar_authentificate:false,
           snackbar_added_panier:false,
           loader:false,
           Nombre_liked_for_products:[],
           etatsidbar:true,
           dialog_rate:false
        }
    },
    components:{
        InfoClient,FooterVueVue,ServiceVue,preloaderVue,SideBar
    },
    methods:{
      checkrate(){
        service_product.getrate().then((res)=>{
           this.check_rate_user=res.data;
        });
      },
      ShowDialogAddArate(item){
        if(this.store.isauth!=null){
          this.productrate=item;
          this.dialog_rate=true;
        }else{
          this.snackbar_authentificate=true;
        }
      },
      changerpage(a){
        this.pagination.current_page=a;
        this.FetchData();
      },
      changreetat(a){
        this.etatsidbar=a;
      },
      CoutProduct(){
        for(let i=0;i<this.Products.length;i++){
         service_user.countLiked(this.Products[i].id).then((res)=>{
            let index=this.Nombre_liked_for_products.findIndex((v)=>v.id==this.Products[i].id);
            if(index!=-1){
              this.Nombre_liked_for_products[index].nbr=res.data.data;
            }else{
              this.Nombre_liked_for_products.push(
                 {
                   id:this.Products[i].id,
                   nbr:res.data.data
                 }
             );
            }
          })
        }
      },
      get_all_liked(){
        this.All_Liked=[];
        service_user.GetAllLikedProduct(this.store.user['id']).then((response)=>{
            for(let i=0;i<(response.data).length;i++){
                this.All_Liked.push({id:response.data[i].product_id});
            }
        });
        this.CoutProduct();
      },
      AddPanier(){
          let Option_for_product=[];
          this.OptionsAdded.forEach((v)=>{
             if(v.idproduct==this.product_selected.id){
                Option_for_product.push({name:v.name,prix:v.prix});
             }
          });

          let Option_glob_selected=[];
          this.OptionsAdded_Selected.forEach((v)=>{
            Option_glob_selected.push({name:v.nameOption});
          });
              let id=Math.random(10,99999);
              this.length_panier();
              this.dialog=false;
              this.snackbar_added_panier=true;
              this.panier_product.push({id:id,Product:this.product_selected,option_Supp:Option_for_product,Option_glob:Option_glob_selected,Quantity:this.Qte,prix:this.total});
              ServiceaddProducts.Add(this.panier_product);
              this.nbr_panier=this.panier_product.length;
              setTimeout(()=>this.$router.go(),2000);
              this.total=0;
      },

       AddFavorite(id){
        if(this.store.isauth!=null){
          service_user.checkLiked(id,this.store.user['id']).then((res)=>{
              if(res.data.data.length==0){
                service_user.addLiked({idproduct:id,iduser:this.store.user['id']}).then((res)=>{
                  this.CoutProduct();
                  this.get_all_liked();
                })
              }else{
                service_user.deleteFavorite(id,this.store.user['id']).then((res)=>{
                  this.get_all_liked();
                  this.CoutProduct();
                })
              }
          })
        }else{
           this.snackbar_authentificate=true;
        }
      },

      InitIndice(a){
        this.product_selected=a;
        this.OptionsAdded_Selected=this.All_Option_Global;
        this.dialog=true;
      },

        MaxPrix(){
            service_product.getProductByIdCategory(this.id_category).then((res)=>{
              this.Products_max=res.data;
            })
        },

        GetOptionGlobal(){
          service_option.getOptionByIdCategory({id:this.id_category}).then((res)=>{
              this.All_Option_Global=res.data.data;
              this.OptionsAdded_Selected=this.All_Option_Global;
          }) 
        },

        addOption(name,prix){
            let indexofption=this.OptionsAdded.find((v) => {
                if (v.name==name  && v.idproduct==this.product_selected.id) {
                    return true;
                };
            });
            if(indexofption==undefined){
              this.OptionsAdded.push({name:name,prix:prix,idproduct:this.product_selected.id});
            }else{
              let index=this.OptionsAdded.findIndex((v)=>(v.name==name  && v.idproduct==this.product_selected.id));
              this.OptionsAdded.splice(index,1);
              let index_option=this.All_Prix_With_Option_Array.findIndex((v)=>( v.id==this.product_selected.id));
              this.All_Prix_With_Option_Array.splice(index_option,1);
            }
            this.Total_prix();
        },

        FetchData(){
          service_product.GetProudctOptionSpecifiqueCategory(this.id_category,this.search,this.prix,this.type_Ordered_produdct,this.pagination.current_page).then((response)=>{
              this.Products=response.data.data.data;
              this.pagination.current_page=response.data.data.current_page;
              this.pagination.total=response.data.data.total;
              this.pagination.next_page=response.data.data.next_page_url?.split('=')[1];
              this.pagination.prev_page=response.data.data.prev_page_url?.split('=')[1];
              this.pagination.per_page=response.data.data.per_page;
              this.loader=true;
              this.Total_prix();
              this.CoutProduct();
              this.length_panier();
              this.countRate();
          })
        },

        length_panier(){
           this.nbr_panier=this.store_products.Products==null ? 0 :this.store_products.Products.length;
        },

        Total_prix(){
            let prix=0;
            for(let i=0;i<this.Products.length;i++){
               if(this.OptionsAdded.find((v)=>v.idproduct==this.Products[i].id)){
                   this.OptionsAdded.forEach(element => {
                      if(element.idproduct  == this.Products[i].id){
                           prix+= element.prix;
                      }
                   });
                   let indexofption=this.All_Prix_With_Option_Array.find((v) =>v.id==this.Products[i].id);
                   if(indexofption==undefined){
                      this.All_Prix_With_Option_Array.push({id:this.Products[i].id,prix:prix});
                   }else{
                      let index=this.All_Prix_With_Option_Array.findIndex((v)=>(v.id==this.Products[i].id));
                      this.All_Prix_With_Option_Array[index].prix=prix;
                   }
                   prix=0;
               }
            }
        },
        addrate(id,nbr){
          service_product.Addrate({id:id,nbr_rate:nbr,user_id:this.store.user['id']}).then((res)=>{
              this.checkrate();
              this.countRate();
              this.nbr_rate=0;
              this.productrate=[];
          })
        },
        countRate(){
         for(let i=0;i<this.Products.length;i++){
            service_product.Avgrate(this.Products[i].id).then((res)=>{
             let index=this.Nombre_rate_for_products.findIndex((v)=>v.id==this.Products[i].id);
            if(index!=-1){
              this.Nombre_rate_for_products[index].Avg=res.data==null ? 0 : res.data.data[0];
            }else{
              this.Nombre_rate_for_products.push(
                 {
                   id:this.Products[i].id,
                   Avg:res.data==null ? 0 : res.data.data[0]
                 }
             );
            }
          })
        }
        }
    },
    computed:{
        name_category(){
            this.GetOptionGlobal();
            this.FetchData();
            let indice=this.types.find((v)=>v.id==this.id_category);
            return indice?.name;
        },
        min(){
            if(this.Products_max!=''){
                let prix_min=this.Products_max[0].PrixProduct;
                for(let i=1;i<this.Products_max.length;i++){
                    if(this.Products_max[i].PrixProduct<prix_min){
                        prix_min=this.Products_max[i].PrixProduct;
                     }
                 }
                 return prix_min;
            }else{
                return 0;
             }
        },

        max(){
            if(this.Products_max!=''){
                let prix_max=this.Products_max[0].PrixProduct;
                for(let i=1;i<this.Products_max.length;i++){
                    if(this.Products_max[i].PrixProduct>prix_max){
                         prix_max=this.Products_max[i].PrixProduct;
                     }
                 }
                 return prix_max;
            }else{
                return 0;
             }
        },

    }
  
}
</script>

<style>
.v-snack{
  z-index:9999 !important;
}
.input_number{
  width: 40px !important;
  border: none;
  outline: none;
}
.items{
  margin-left: 20%;
}
.items img{
  border-radius: 25px;
}
.content_menu{
    margin-top: 40px !important;
    margin:25px;
}
.header{
    padding:18px;
    background-color: #FFF9EB !important;
    width:100%;
    z-index: 99;
    max-height: 80px;
}

</style>