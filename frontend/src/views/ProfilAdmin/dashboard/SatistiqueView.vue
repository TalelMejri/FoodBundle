<template>
    <div class="py-3 ">
        <v-container class="py-5 mt-5 mb-5">
            <div class="row py-2 mt-4">
                <div  v-for="item in items" :key="item.id" class="col-lg-4" >
                    <v-card
                    class="mx-auto"
                    :max-width="500"
                    elavation="4"
                    >
                    <v-list-item >  
                        <v-list-item-avatar
                        color="#FBE1D4"
                      >
                     <v-icon color="#E84C03">mdi-{{item.icon}}</v-icon>
                    </v-list-item-avatar>
                      <v-list-item-content>
                        <v-list-item-title class="text-h mb-1">
                            {{item.name}}
                        </v-list-item-title>
                        <v-list-item-subtitle v-if="item.id==0">{{nbrcategory}}</v-list-item-subtitle>
                        <v-list-item-subtitle v-else-if="item.id==1">{{countuser}}</v-list-item-subtitle>
                        <v-list-item-subtitle v-else-if="item.id==2">{{countProduct}}</v-list-item-subtitle>
                        <v-list-item-subtitle v-else-if="item.id==3">{{countoption}}</v-list-item-subtitle>
                        <v-list-item-subtitle v-else-if="item.id==4">{{CountOptionSpecifique}}</v-list-item-subtitle>
                        <v-list-item-subtitle v-else>{{countcommande}}</v-list-item-subtitle>
                    </v-list-item-content>
                    </v-list-item>
                  </v-card>
                </div>
        </div>
        </v-container>

        <v-container class="mt-5 py-4">
            <v-card elavation="4 mt-5 py-5">
                <v-sparkline
                 class="mt-5 py-5"
                 :fill="fill"
                 :gradient="selectedGradient"
                 line-width="2"
                 smooth="10"
                 :value="value"
                 auto-draw
                 ></v-sparkline> 
             </v-card>
          </v-container>
    </div>
</template>

<script>
const gradients = [
    ['#E86325'],
  ]

import service from "@/services/GererUser/GererUser"
import service_category from "@/services/GererCategory/category"
import service_product from "@/services/GererProduct/GererProduct"
import service_option from "@/services/GererOption/option"
import service_command from "@/services/GererCommande/Commande"
 export default{
     name:'view',
     mounted(){
        service.CoutUser().then((response)=>{
             this.countuser=response.data.data;
        });
        service_category.CountCategory().then((response)=>{
             this.nbrcategory=response.data;
        });
        service_product.countproduct().then((response)=>{
            this.countProduct=response.data.data;
        });
        service_option.countOption().then((response)=>{
            this.countoption=response.data.data;
        });
        service_option.CountOptionSpecifique().then((response)=>{
            this.CountOptionSpecifique=response.data.data;
        });
        service_command.countCommande().then((response)=>{
            this.countcommande=response.data.data;
        });
     },
     data(){
        return{
            fill: true,
            gradients,
            padding: 8,
            selectedGradient: gradients[0],
            width: 2,
            countuser:0,
            CountOptionSpecifique:0,
            nbrcategory:0,
            countProduct:0,
            countoption:0,
            countcommande:0,
            items:[
                {id:0,name:' Categorie',icon:'filter-variant'},
                {id:1,name:' Client',icon:'account-group'},
                {id:2,name:' Produit',icon:'hamburger'},
                {id:3,name:' Option Global',icon:'shaker'},
                {id:4,name:' Option Specifique',icon:'shaker-outline'},
                {id:5,name:' Commandes',icon:'truck-delivery'}
            ]
        }
     },
     computed:{
        value(){
            return [0,1,2,this.countuser]
        }
     }

 }
</script>

<style>
</style>