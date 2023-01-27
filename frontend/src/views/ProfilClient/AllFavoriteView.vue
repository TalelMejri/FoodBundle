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
               <v-card elavation="7" style="padding:25px">
                <h4 class="text-center py-4">List Favorite</h4>
            <v-simple-table>
              <template v-slot:default>
                <thead>
                  <tr>
                    <th  class="text-left ">
                      Name
                    </th>
                    <th  class="text-left ">
                      Photo
                    </th>
                    <th  class="text-left ">
                      Prix
                    </th>
                  </tr>
                </thead>
                  <tbody v-if="loader"> 
                      <tr class="text-center">
                        <td colspan="5">
                              <v-progress-circular
                                  indeterminate
                                  color="red"
                              ></v-progress-circular>
                        </td>
                      </tr>
                  </tbody>
                <tbody v-else-if="All_favorite==''">
                  <tr >
                    <td colspan="6" class="text-center">No data available</td>
                  </tr>
                </tbody>
                <tbody v-else>
                  <tr
                    v-for="item in All_favorite"
                    :key="item.product_id"
                  >
                    <td>{{ item.product.nameProduct }}</td>
                    <td><img width="80px" height="80px"  :src="item.product.PhotoProduct" alt=""></td>
                    <td>{{ item.product.PrixProduct }}</td>
                    <td>
                       <v-btn @click="RemoveProductFavorite(item.product_id,item.user_id)" class="mx-2 mb-2">
                            <v-icon color="red">
                               mdi-heart
                            </v-icon>  
                       </v-btn>
                    </td>
                  </tr>
                </tbody>
                <div class="text-center mt-2">
                  <v-btn small :disabled="pagination.prevpage==null"  @click="changerPage(pagination.curentpage-1)">
                    <v-icon>
                      mdi-chevron-left
                   </v-icon>
                 </v-btn>
                 <v-btn v-for="num in (Math.ceil(pagination.per_page ? pagination.total/pagination.per_page : 1))" :key="num"
                   @click="changerPage(num)"
                    class="mx-2"
                    color="primary"
                    :disabled="num==pagination.curentpage"
                    small
                    x-small
                  >
                 {{num}}
               </v-btn>
                  <v-btn small :disabled="pagination.nextpage==null"  @click="changerPage(pagination.curentpage+1)">
                     <v-icon>
                        mdi-chevron-right
                     </v-icon>
                  </v-btn>
                </div>
              </template>  
            </v-simple-table>
          </v-card>
        </div>
        </div>
    </div>
</template>

<script>
import SideBar from "@/components/SideBar.vue";
import service_user from "@/services/GererUser/GererUser"
import FooterVue from "@/components/home_page/FooterVue.vue";
import InfoClient from "@/components/Client/InfoClient.vue"
import { AuthStore } from "@/store/StoreAuth";
import { ProductStore } from "@/store/StoreProducts";
export default{
    created(){
           this.fetchdata();
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
            pagination:{
                curentpage:1,
                nextpage:0,
                prevpage:0,
                total:0,
                per_page:0,
            },
            loader:false,
            All_favorite:[],
            etatsidbar:true
        }
    },
    methods:{
      changreetat(a){
        this.etatsidbar=a;
      },
     changerPage(num){
        this.pagination.curentpage=num;
        this.fetchdata();
      },
      fetchdata(){
        service_user.getAllProductLiekd(this.store.user['id'],this.pagination.curentpage).then((res)=>{
            this.All_favorite=res.data.data;
            this.pagination.prevpage=res.data.prev_page_url?.split("=")[1];
            this.pagination.nextpage=res.data.next_page_url?.split("=")[1];
            this.pagination.per_page=res.data.per_page;
            this.pagination.total=res.data.total;
        })
      },
      RemoveProductFavorite(idproduct,iduser){
        service_user.deleteFavorite(idproduct,iduser).then((res)=>{
            this.fetchdata();
        })
        this.fetchdata();
      }
    },
    components:{
        FooterVue,
        InfoClient,SideBar
    }
}
</script>