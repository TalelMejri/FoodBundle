<template>
    <div>
        <v-card class="header" elavation="3">
            <div class="row">
                    <img src="../../assets/logo.png" width="70px" height="70px" alt="FoodBundle logo">
                    <h3 style="padding:15px"><span style="color:#E84C03;">Food</span>Bundle</h3>
                    <v-spacer></v-spacer>
                    <div v-if="store.isauth!=null">
                        <InfoClient style="padding:15px;padding-right:40px" :menu="'menu'">
                        </InfoClient>
                    </div>
                    <div v-else>
                        <v-badge class="mx-5 mt-3" color="red" content="6">
                            <v-btn text @click="snackbar_notif = true">
                                ddd
                            </v-btn>
                              <!--<v-icon color="#000">mdi-bell</v-icon>-->
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
              <div>
                 <h4>Filter Par <v-icon>mdi-menu</v-icon></h4>
              </div>
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
                        <v-btn class="mx-2" :color="affichage=='list' ? 'primary' : ''">
                            list
                        </v-btn>
                      <v-btn :color="affichage=='card' ? 'primary' : ''">
                           card
                    </v-btn>
                     </div>
                </div>

                          <div class="row " >
                            <v-card  v-for="product in Products" :key="product.id"
                               class=" mx-2 my-5 col-lg-5"
                                     max-width="300"
                                    >
                                     <v-img
                                       height="200"
                                        :src="product.PhotoProduct"
                                     ></v-img>
                                     <v-card-title>{{product.nameProduct}}<v-spacer></v-spacer>
                                         <h3>{{product.PrixProduct}} TND</h3> </v-card-title>
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
                                  </v-row>
                                </v-card-text>

                              <v-divider class="mx-4"></v-divider>

                              <v-btn style="width:100%" class="text-center mt-2 mb-1"
                               color="deep-purple lighten-2"
                              >
                                Add To carte
                             </v-btn>
                      

                      <v-dialog v-model="dialog"
                        transition="dialog-top-transition"
                        max-width="600"
                      >
                        <template >
                          <v-card class="p-5">
                            <v-toolbar
                              color="primary"
                              dark
                            >Options </v-toolbar>
                                <h2 class="text-h6 mb-2">
                                   Option Globale
                                </h2>
                                <v-chip-group 
                                  column
                                  multiple
                                >
                                  <v-chip 
                                     v-for="n in All_Option_Global" :key="n.id"
                                        @change="addOption(n.id,n.prixOption)"
                                  >
                                    <p :style="((OptionsAdded[OptionsAdded.findIndex((v)=>(v.id==n.id))]?.idproduct==product_selected.id) ||  OptionsAdded.findIndex((v)=>(v.id==n.id)!=-1) )   ? 'color:red' :  '' ">
                                        {{ n.nameOption  }} 
                                    </p>
                                  </v-chip>
                                </v-chip-group>
                                <h2 class="text-h6 mb-2">
                                  Option Specifique
                                </h2>
                                <v-chip-group 
                                  column
                                  multiple
                                >
                                  <v-chip 
                                     v-for="i in product.optionspecifiques" :key="i.id"
                                        @change="addOption(i.id,i.prixOptionSpecifique)"
                                  >
                                    {{ i.nameOptionSpecifique }}
                                  </v-chip>
                                </v-chip-group>
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
                {{ OptionsAdded }}
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
    },
    data(){
     
        return{ 
           OptionsAdded:[],
           id:0,
           prix: 0,
           dialog:false,
           search:'',
           Products_max:[],
           affichage:'card',
           Ordered: ['nameProduct','PrixProduct'],
           types:[],
           pagination:{
            current_page:1,
            next_page:0,
            prev_page:0,
            per_page:0,
            total:0
           },
           Products:[],
           All_Option_Global:[],
           All_Option_Specifique:[],
           id_category:0,
           type_Ordered_produdct:'',
           product_selected:0
        }
    },
    components:{
        InfoClient,FooterVueVue,ServiceVue
    },
    methods:{
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
        addOption(id,prix){
          let indexofption=this.OptionsAdded.findIndex((v)=>(v.id==id));
          let testIDproduct=(this.OptionsAdded[indexofption]?.idproduct==this.product_selected.id) ? 1 :-1;
          if(indexofption==-1 && testIDproduct==-1){
            this.OptionsAdded.push({id:id,prix:prix,idproduct:this.product_selected.id});
          }else if(indexofption!=-1 && testIDproduct==1){
             this.OptionsAdded.splice(indexofption,1);
          }else if(indexofption!=1 && testIDproduct!=1){
            this.OptionsAdded.push({id:id,prix:prix,idproduct:this.product_selected.id});
          }
        },
        FetchData(){
          service_product.GetProudctOptionSpecifiqueCategory(this.id_category,this.search,this.prix,this.type_Ordered_produdct,this.pagination.current_page).then((response)=>{
              this.Products=response.data.data.data;
          })
        }
    },
    computed:{
      verifier(a){
          let indexofption=this.OptionsAdded.findIndex((v)=>(v.id==a));
          let testIDproduct=(this.OptionsAdded[indexofption]?.idproduct==this.product_selected.id) ? 1 :-1;
          if(indexofption!=-1 && testIDproduct==1){
            return true;
          }
          return false;
      },
        name_category(){
            this.GetOptionGlobal();
            this.FetchData();
            let indice=this.types.find((v)=>v.id==this.id_category);
            return indice.name;
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
        
        }
    }
  
}
</script>

<style>
.content_menu{
    margin-top: 5% !important;
    margin: 25px;
}
.header{
    padding:18px;
    background-color: #FFF9EB !important;
    /*margin-bottom: 500px !important;*/
   /* position:fixed !important;*/
 
    width:100%;
}

</style>