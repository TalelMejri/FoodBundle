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
                                <v-icon @click="snackbar_notif = true" style="font-size:25px">mdi-cart-outline</v-icon>
                          </router-link>
                        </v-badge>
                    </div>
            </div>
        </v-card>
        <div class="content_menu">
            <div class="row">
                <div  class="col-lg-2 text-center">
                <v-card
                    style="padding:25px"
                    max-width="200" elavation="5"> 
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
                        label="Category"
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
                label="Ordered By"
            ></v-select>
              </div>
            </v-card>
        </div>
        <div class="col-lg-10 ">
                <div class="row">
                  
                     <div class="col-lg-3">
                        <p style="color:#E84C03;font-weight:600" > {{ name_category.toUpperCase() }}</p>
                     </div>

                     <div class="col-lg-4 text-center">
                        <v-text-field
                            v-model="search"
                            append-icon="mdi-magnify"
                            label="Search By NameProduct"
                            single-line
                            hide-details
                        ></v-text-field>
                     </div>
                     <v-spacer></v-spacer>
                     <div class="col-lg-2 text-center">
                        <v-btn @click="affichage='list'" class="mx-2" :color="affichage=='list' ? 'primary' : ''">
                           <v-icon>mdi-format-list-bulleted</v-icon>
                        </v-btn>
                      <v-btn  @click="affichage='card'" :color="affichage=='card' ? 'primary' : ''">
                           <v-icon>mdi-view-comfy</v-icon>
                    </v-btn>
                     </div>
                </div>
                          <div class="row " >
                            <v-card  v-for="product in Products" :key="product.id"
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
                                         <p style="display:none">{{ index = All_Prix_With_Option_Array.findIndex((v)=>v.id==product.id) }}</p>   
                                           <h3>{{ index !=-1 ? All_Prix_With_Option_Array[index].prix+ product.PrixProduct : product.PrixProduct}} TND</h3>
                                      </v-card-title>
                                         <v-card-text>
                                        <v-row
                                          align="center"
                                          class="mx-0"
                                       >
                                     <v-rating
                                        :value="4.5"
                                        color="amber"
                                        dense
                                        half-increments
                                       readonly
                                       size="14"
                                      ></v-rating>
                                       <div class="grey--text ms-4">
                                         4.5 (413)
                                       </div>
                                       <v-spacer></v-spacer>
                                       <v-card-actions >
                                        <v-btn @click="InitIndice(product)" class="text-center "
                                          color="deep-purple lighten-2"
                                        >
                                          Add Option
                                       </v-btn>
                                     </v-card-actions>
                                     <v-spacer></v-spacer>
                                     <div class="mb-4 mx-5 mt-2">
                                      <v-icon @click="AddFavorite(product.id)">mdi-heart-outline</v-icon>
                                  </div>
                                  </v-row>
                                </v-card-text>
                              <v-divider class="mx-4"></v-divider>
                              <v-btn style="width:100%" class="text-center mt-2 mb-1"
                               color="deep-purple lighten-2"
                               @click="AddPanier(product.id)"
                              >
                                Add To carte
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
                                    :value="4.5"
                                    color="amber"
                                    dense
                                    half-increments
                                   readonly
                                   size="14"
                                  ></v-rating>
                                   <div class="grey--text ms-4">
                                     4.5 (413)
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
                                <v-btn
                                  outlined
                                  rounded
                                  type="submit"
                                  text
                                  @click="AddPanier(product.id)"
                                >
                                  Add Card
                                </v-btn>
                                <v-btn
                                outlined
                                rounded
                                text
                                @click="InitIndice(product)" class="text-center "
                                color="deep-purple lighten-2"
                              >
                                Add Option
                              </v-btn>
                              </v-card-actions>
                            </div>
                      <v-dialog v-model="dialog"
                        transition="dialog-top-transition"
                        max-width="600"
                      >
                        <template >
                          <v-card class="p-5">
                            <v-toolbar
                              color="primary"
                              dark
                            >Options</v-toolbar>
                                <h2 class="text-h6 mb-2 mx-2 mt-2">
                                   Option Globale
                                </h2>
                                <div  class="mx-3" v-if="All_Option_Global==''">
                                      No Option
                                </div>
                                <div v-else>
                                <v-chip-group 
                                  column
                                  multiple
                                  class="mx-3"
                                >
                                  <v-chip 
                                  
                                      v-for="n in All_Option_Global" :key="n.id"
                                        @change="addOption(n.nameOption,n.prixOption)"  
                                        :style="OptionsAdded.find((v)=>{ if(v.name==n.nameOption && v.idproduct==product_selected.id){ return true} else { return false } }) ? 'color:#fff;background-color:#E84C03' :  '' "
                                  >
                                        {{ n.nameOption  }} 
                                  </v-chip>
                                </v-chip-group>
                              </div>
                                <h2 class="text-h6  mx-2 mt-2">
                                   Option Specifique
                                </h2>
                                <div class="mx-2" v-if="product.optionspecifiques==''">
                                    No Option
                                </div>
                                <div v-else>
                                <v-chip-group 
                                  column
                                  multiple
                                  class="mx-3"
                                >
                                  <v-chip 
                                     v-for="i in product.optionspecifiques" :key="i.id"
                                        @change="addOption(i.nameOptionSpecifique,i.prixOptionSpecifique)"
                                        :style="OptionsAdded.find((v)=>{ if(v.name==i.nameOptionSpecifique && v.idproduct==product_selected.id){ return true} else { return false } }) ? 'color:#fff;background-color:#E84C03' :  '' "
                                  >
                                        {{ i.nameOptionSpecifique }}
                                  </v-chip>
                                </v-chip-group>
                              </div>
                            <v-card-actions class="justify-end">
                              <v-btn
                                text
                                @click="dialog = false"
                              >Close</v-btn>
                            </v-card-actions>
                       </v-card>
                        </template>
                      </v-dialog>
                    </v-card>
                </div>

                <v-snackbar
                color="red"
                v-model="snackbar_authentificate"
              >
                  You Should Create an Account <router-link to="../signup"><small>Click Here</small></router-link>
                <template v-slot:action="{ attrs }">
                  <v-btn
                    color="#fff"
                    text
                    v-bind="attrs"
                    @click="snackbar_authentificate = false"
                  >
                    Close
                  </v-btn>
                </template>
              </v-snackbar>
             
            </div>
        </div>
        </div>
        <ServiceVue></ServiceVue>
        <FooterVueVue></FooterVueVue>
    </div>
</template>

<script>
import { AuthStore } from "@/store/StoreAuth";
import service_category from "@/services/GererCategory/category";
import InfoClient from "@/components/Client/InfoClient.vue";
import ServiceVue from "@/components/home_page/ServiceVue.vue";
import FooterVueVue from "@/components/home_page/FooterVue.vue";
import service_product from "@/services/GererProduct/GererProduct"
import service_option from "@/services/GererOption/option"
export default{
    name:'menu',
    setup(){
        const store=AuthStore();
        return{
            store
        }
    },
    created(){
        this.id_category=parseInt(this.$route.params.id);
        service_category.getAllTypeCategory().then((response)=>{
            for(let i=0;i<(response.data).length;i++){
                this.types.push({name:response.data[i].name,id:response.data[i].id});
            }
        });
        this.FetchData();
        this.GetOptionGlobal();
        this.MaxPrix();
        this.length_panier();
    },
    data(){
     
        return{ 
           OptionsAdded:[],
           prix: 0,
           dialog:false,
           search:'',
           Products_max:[],
           affichage:'card',
           Ordered: ['nameProduct','PrixProduct'],
           types:[],
           nbr_panier:'O',
           pagination:{
            current_page:1,
            next_page:0,
            prev_page:0,
            per_page:0,
            total:0
           },
           Products:[],
           All_Option_Global:[],
           id_category:0,
           type_Ordered_produdct:'',
           product_selected:0,
           All_Prix_With_Option_Array:[],
           panier_product:[],
           snackbar_authentificate:false
        }
    },
    components:{
        InfoClient,FooterVueVue,ServiceVue
    },
    methods:{
      AddPanier(id){
          let Option_for_product=[];
          this.OptionsAdded.forEach((v)=>{
             if(v.idproduct==id){
                Option_for_product.push({name:v.name,prix:v.prix});
             }
          });
           let tab=[];
           tab=JSON.parse(localStorage.getItem('ProductPanier'));
           if(tab==null){
              this.panier_product.push({idProduct:id,option:Option_for_product,Quantity:1});
              localStorage.setItem('ProductPanier',JSON.stringify(this.panier_product));
           }else{

               let indexfind=this.panier_product.find((v)=>{
                  if(v.idProduct==id && v.option.length==0){
                      return true;
                  }
               });

            if(Option_for_product.length==0){
               if(indexfind==undefined){
                   this.panier_product.push({idProduct:id,option:Option_for_product,Quantity:1});
                   localStorage.setItem('ProductPanier',JSON.stringify(this.panier_product));
               }else{
                  let indexfindlast=this.panier_product.findLastIndex((v)=>v.idProduct==id);
                  this.panier_product[indexfindlast].Quantity+=1;
                  localStorage.setItem('ProductPanier',JSON.stringify(this.panier_product));
               }
              }else{
                
               let indexfind_multiple=this.panier_product.find((v)=>{
                  if(v.idProduct==id && v.option.length==Option_for_product.length){
                      return true;
                   }
                });

                if(indexfind_multiple==undefined){
                   this.panier_product.push({idProduct:id,option:Option_for_product,Quantity:1});
                   localStorage.setItem('ProductPanier',JSON.stringify(this.panier_product));
                }else{
                   let indexfindlast=this.panier_product.findLastIndex((v)=>v.idProduct==id && v.option.length==Option_for_product.length);
                   let trouve=0;
                   let i=0;
                   while(i<Option_for_product.length && trouve==0){
                      let index=(this.panier_product[indexfindlast].option).find((v)=>
                        v.name==Option_for_product[i].name && v.prix==Option_for_product[i].prix);
                      if(index==undefined){
                         i++;
                      }else{
                        trouve=1;
                      }
                   }

                  if(trouve==0){
                    this.panier_product.push({idProduct:id,option:Option_for_product,Quantity:1});
                   localStorage.setItem('ProductPanier',JSON.stringify(this.panier_product));
                  }else{
                    this.panier_product[indexfindlast].Quantity+=1;
                    localStorage.setItem('ProductPanier',JSON.stringify(this.panier_product));
                  }
                }
              }
               this.length_panier();
           }
    },
      AddFavorite(id){
        if(this.store.isauth!=null){
            //add favorite or remove favorite migration favorite
        }else{
           this.snackbar_authentificate=true;
        }
      },
      InitIndice(a){
        this.product_selected=a;
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
            }
            this.Total_prix();
        },
        FetchData(){
          service_product.GetProudctOptionSpecifiqueCategory(this.id_category,this.search,this.prix,this.type_Ordered_produdct,this.pagination.current_page).then((response)=>{
              this.Products=response.data.data.data;
              this.Total_prix();
          })
        },
        length_panier(){
           this.nbr_panier=JSON.parse(localStorage.getItem('ProductPanier'))==null ? 'O' : JSON.parse(localStorage.getItem('ProductPanier')).length;
        },
        Total_prix(){
            let prix=0;
            for(let i=0;i<this.Products.length;i++){
               if(this.OptionsAdded.find((v)=>v.idproduct==this.Products[i].id)){
                   this.OptionsAdded.forEach(element => {
                      if(element.idproduct==this.Products[i].id){
                           prix+=element.prix;
                      }
                   });
                   let indexofption=this.All_Prix_With_Option_Array.find((v) =>v.id==this.Products[i].id);
                   if(indexofption==undefined){
                    this.All_Prix_With_Option_Array.push({id:this.Products[i].id,prix:prix});
                   }else{
                    let index=this.All_Prix_With_Option_Array.findIndex((v)=>(v.id==indexofption.id));
                    this.All_Prix_With_Option_Array[index].prix=prix;
                   }
                   prix=0;
               }
            }
        },
        
    },
    computed:{
    
        name_category(){
            this.GetOptionGlobal();
            this.FetchData();
            let indice=this.types.find((v)=>v.id==this.id_category);
            if(indice!=-1){
              return indice.name;
            }
            return 'menu';
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
                console.log(this.Products_max.length);
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
.content_menu{
    margin-top: 140px !important;
    margin: 25px;
}
.header{
    padding:18px;
    background-color: #FFF9EB !important;
    position:fixed !important;
    width:100%;
    z-index: 99;
    max-height: 80px;

}

</style>