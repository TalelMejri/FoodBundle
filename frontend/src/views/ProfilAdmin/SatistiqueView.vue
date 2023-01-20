<template>
    <div class="py-3 ">
        <v-container class="py-5 mt-5 mb-5">
            <div class="row py-2 mt-4">
                <div  v-for="item in items" :key="item.id" class="col-lg-4" >
                    <v-card
                    class="mx-auto"
                    :max-width="item.id==2 ? '310' : '280'"
                    elavation="4"
                  >
                    <v-list-item three-line>
                        <v-list-item-avatar
                        color="#FBE1D4"
                        size="50"
                      >
                     <v-icon color="#E84C03">mdi-{{item.icon}}</v-icon>
                    </v-list-item-avatar>
                      <v-list-item-content>
                        <v-list-item-title class="text-h5 mb-1">
                          {{item.name}}
                        </v-list-item-title>
                        <v-list-item-subtitle v-if="item.id==0">{{nbrcategory}}</v-list-item-subtitle>
                        <v-list-item-subtitle v-else-if="item.id==1">{{countuser}}</v-list-item-subtitle>
                        <v-list-item-subtitle v-else>2</v-list-item-subtitle>
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
import service from "../../services/GererUser/GererUser.js"
import service_product from "../../services/GererProduct/GererProduct"
 export default{
     name:'view',
     mounted(){
         service.CoutUser().then((response)=>{
             this.countuser=response.data.data;
        });
        service_product.CountCategory().then((response)=>{
             this.nbrcategory=response.data;
        })
     },
     data(){
        return{
            fill: true,
            gradients,
            padding: 8,
            selectedGradient: gradients[0],
            //value: [0, 2, 5, 9, 5, 10, 3, 5, 0, 0, 1, 8, 2, 9, 0],
            width: 2,
            countuser:0,
            nbrcategory:0,
            items:[
                {id:0,name:'Total category',icon:'filter-variant',number:0},
                {id:1,name:'Total Client',icon:'account-group',number:0},
                {id:2,name:'Total Commande',icon:'truck-delivery',number:5}
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