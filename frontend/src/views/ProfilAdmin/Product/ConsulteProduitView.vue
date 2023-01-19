<template>
    <div class="mt-5 py-5">
        <div v-if="addproduct">
             <AddProductView></AddProductView>
        </div>
        <div v-else>
         <v-card elevation="6" class="p-5">
                <h4 class="text-center py-4">List Produit</h4>
                <div class="row gap-4 p-5 mt-3">
                    <div class="col-lg-3 mx-2 text-center">
                        <form class="text-center" @submit.prevent="SearchData()">
                            <v-select
                                :items="items"
                                label="Chose Type"
                                outlined
                          ></v-select>
                     </form>
                    </div>
                    <div class="col-lg-5 mx-2 text-center">
                        <form @submit.prevent="SearchData()">
                            <v-text-field
                             v-model="search"
                             append-icon="mdi-magnify"
                             label="Search By Name"
                             single-line
                             hide-details
                          ></v-text-field>
                     </form>
                    </div>
                    <div class="col-lg-3 text-center">
                      <div class="row">
                        <div class="col-lg-12 text-center">
                          <v-tooltip bottom>
                            <template v-slot:activator="{ on, attrs }">
                              <v-btn
                                dark
                                color="#E84C03" style="color:#fff"
                                v-bind="attrs"
                                v-on="on"
                                @click="addproduct=true"
                              >
                              <v-icon class="px-2">mdi-plus-box</v-icon>
                              </v-btn>
                            </template>
                            <span>Add Product</span>
                          </v-tooltip>
                    </div>
                        </div> 
                    </div>
                    </div>
                <v-simple-table>
                    <template v-slot:default>
                      <thead>
                        <tr>
                          <th  class="text-left ">
                            Id
                          </th>
                          <th class="text-left">
                            Name
                          </th>
                          <th class="text-left">
                            Photo
                          </th>
                          <th class="text-left">
                            Prix
                          </th>
                          <th class="text-left">
                            Option
                          </th>
                          <th class="text-left">
                            Operation
                          </th>
                        </tr>
                      </thead>
                      <tbody v-if="items==''">
                        <tr >
                          <td colspan="6" class="text-center">No data available</td>
                        </tr>
                      </tbody>
                      <tbody v-else>
                        <tr
                          v-for="item in items"
                          :key="item"
                        >
                          <td>{{ item }}</td>
                          <td>{{ item }}</td>
                        </tr>
                      </tbody>
                    </template>
                  </v-simple-table>
         </v-card>
        </div>
    </div>
</template>

<script>
import AddProductView from './AddProductView.vue';
export default{
    name:'produit',
    data(){
        return{
            search:'',
            items:[],
            addproduct:false,
        }
    },
    methods:{

    },
    components:{
        AddProductView
    }
}
</script>

<style scoped>
th{
    color: #000 !important;
    font-weight: 600 !important;
}
</style>