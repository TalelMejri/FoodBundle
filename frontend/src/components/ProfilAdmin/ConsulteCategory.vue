<template>
    <div class="mt-5 py-5">
        <div v-if="AddCategory">
            <AddCategoryView @retour_consult="retour_consult" :addcat="AddCategory"></AddCategoryView>
        </div>
        <div v-else>
      <v-toolbar >
        <div class="row py-3">
             <div class="col-lg-4">
            <v-toolbar-title > List Categories </v-toolbar-title>
            <v-divider
            class="mx-4"
            inset
            vertical
            ></v-divider>
             </div>
             <div class="col-lg-4">
                <v-text-field
                v-model="search"
                @keyup="FetchData()"
                append-icon="mdi-magnify"
                label="Search"
                single-line
                hide-details
          ></v-text-field>
             </div>
             <div class="col-lg-4 text-center">
                <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                        @click="AddCategory=true"
                        class="ma-2"
                        v-bind="attrs"
                        v-on="on"
                        outlined
                        fab
                        color="#E84C03"
                      >
                        <v-icon>mdi-food-fork-drink</v-icon>
                      </v-btn>
                    </template>
                    <span>Add Category</span>
                  </v-tooltip>
             </div>
        </div>
      </v-toolbar>
      <v-simple-table>
        <template v-slot:default>
          <thead>
            <tr>
              <th  class="text-left ">
                Id
              </th>
              <th  class="text-left ">
                Name
              </th>
              <th  class="text-left ">
                Photo
              </th>
              <th  class="text-left ">
                options
              </th>
              <th class="text-left">
                Operation
              </th>
            </tr>
          </thead>
          <tbody v-if="categories==''">
            <tr >
              <td colspan="6" class="text-center">No data available</td>
            </tr>
          </tbody>
          <tbody v-else>
            <tr
              v-for="item in categories"
              :key="item"
            >
              <td>{{ item.id }}</td>
              <td>{{ item.name }}</td>
              <td><img width="80px" height="80px"  :src="item.PhtotoCatg" alt=""></td>
              <td v-if="item.options!=''">
             <v-list>
                  <v-list-group
                      v-for="i in item.options"
                      :key="i.id"
                  >
                    <template v-slot:activator>
                      <v-list-item-content>
                        <v-list-item-title>{{i.nameOption}}</v-list-item-title>
                      </v-list-item-content>
                          <v-btn @click="dialogOption=true" color="red" class="mx-2">
                            <v-icon color="#fff">
                               mdi-delete
                          </v-icon>
                         </v-btn>
                          <v-btn color="yellow" >
                             <v-icon color="#fff">
                            mdi-square-edit-outline
                            </v-icon> 
                        </v-btn>
                        <v-dialog
                        transition="dialog-bottom-transition"
                        max-width="600"
                        v-model="dialogOption"
                      >
                       <template >
                         <v-card>
                           <v-toolbar
                             color="danger"
                             dark
                           >Delete Option</v-toolbar>
                           <v-card-text>
                             <div class="text-h2 pa-12">{{i.nameOption}}</div>
                           </v-card-text>
                           <v-card-actions class="justify-end">
                             <v-btn
                               text
                               @click="deleteOp(i.id)"
                             >Delete</v-btn>
                             <v-btn
                             text
                             @click="dialogOption=false"
                           >close</v-btn>
                           </v-card-actions>
                         </v-card>
                       </template>
                     </v-dialog>
                    </template>
                    <v-list-item
                    >
                      <v-list-item-content>
                        <v-list-item-title >{{i.prixOption}}</v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>


                  </v-list-group>
                </v-list>
              </td>
               <td class="text-center" v-else>
                  No Option
              </td>
              <td>
                 <v-btn @click="dialog=true" class="mx-2">
                      <v-icon>
                         mdi-delete
                      </v-icon>  
                 </v-btn>
                 <v-dialog
                  transition="dialog-bottom-transition"
                  max-width="600"
                  v-model="dialog"
                >
                 <template >
                   <v-card>
                     <v-toolbar
                       color="danger"
                       dark
                     >Delete Category{{item.name}}</v-toolbar>
                     <v-card-text>
                       <div class="text-h2 pa-12">{{item.name}}</div>
                     </v-card-text>
                     <v-card-actions class="justify-end">
                       <v-btn
                         text
                         @click="deleteCat(item.id)"
                       >Delete</v-btn>
                       <v-btn
                       text
                       @click="dialog=false"
                     >close</v-btn>
                     </v-card-actions>
                   </v-card>
                 </template>
               </v-dialog>
                 <v-btn > 
                    <v-icon>
                        mdi-square-edit-outline
                    </v-icon>  
               </v-btn>
              </td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>
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
    </div>
</template>

<script>

import service from "@/services/GererProduct/GererProduct"
import AddCategoryView from '@/views/ProfilAdmin/Category/AddCategoryView.vue';

export default{
    name:'Category',

    mounted(){
        
    },
    created(){
      this.FetchData();
    },
  data(){
    return{
      search: '',
      dialogOption:false,
      accepter:false,
      categories:[],
      snackbar:false,
      AddCategory:false,
      dialog:false,
      load:true,
      }
    },
    methods:{
      deleteCat(id){
        service.deleteCategory(id).then(()=>{
            this.FetchData();
            this.dialog=false;
            this.snackbar=true;
        })
      },
      deleteOp(id){
        service.deleteOption(id).then(()=>{
            this.FetchData();
            this.dialogOption=false;
            this.snackbar=true;
        })
      },
      FetchData(){
        service.getAllCategorieOptions(this.search).then((response)=>{
            this.categories=response.data[0];
        })
      },
      retour_consult(){
        this.AddCategory=false;
      }
      },
      components:{
        AddCategoryView
      },
      computed:{

      },

}
</script>   



<!-- <template>
  <div class="mt-5 py-5">
      <div v-if="AddCategory">
          <AddCategoryView @retour_consult="retour_consult" :addcat="AddCategory"></AddCategoryView>
      </div>
      <div v-else>
      <v-data-table
          :headers="headers"
          :items="categories"
          :search="search"
          item-key="name"
          class="elevation-1  mt-5 py-5"
          :loading="load==true ? false : true"
          loading-text="Loading... Please wait"
       >

        <template  v-slot:item.actions="{ item }">
          <v-dialog
              transition="dialog-bottom-transition"
              max-width="600"
           >
          <template v-slot:activator="{ on, attrs }">
              <v-icon
              small
              color="red"
              v-bind="attrs"
              v-on="on"
              @click="dialog = true"
            >
                dd
            </v-icon>
          </template>
          <template v-slot:default="dialog">
            <v-card>
              <v-toolbar
                color="red"
                style="color:#fff"
              >Confirmed Delete</v-toolbar>
              <v-card-text>
                <div class="text-h4 pa-12">Do You Want Delete {{ item['name'] }} </div>
              </v-card-text>
              <v-card-actions class="justify-end">
                <v-btn
                  text
                  @click="dialog.value = false"
                >Close</v-btn>
                <v-btn
                text
                color="red"
                @click="deleteItem(item)"
              >Confirmed</v-btn>
              </v-card-actions>
            </v-card>
          </template>
        </v-dialog>
   </template>

  <template v-slot:top >
    
    <v-toolbar flat>
      <div class="row">
           <div class="col-lg-4">
          <v-toolbar-title > List Categories </v-toolbar-title>
          <v-divider
          class="mx-4"
          inset
          vertical
          ></v-divider>
           </div>
           <div class="col-lg-4">
              <v-text-field
              v-model="search"
              append-icon="mdi-magnify"
              label="Search"
              single-line
              hide-details
        ></v-text-field>
           </div>
           <div class="col-lg-4 text-center">
              <v-tooltip bottom>
                  <template v-slot:activator="{ on, attrs }">
                      <v-btn
                      @click="AddCategory=true"
                      class="ma-2"
                      v-bind="attrs"
                      v-on="on"
                      outlined
                      fab
                      color="#E84C03"
                    >
                      <v-icon>mdi-food-fork-drink</v-icon>
                    </v-btn>
                  </template>
                  <span>Add Category</span>
                </v-tooltip>
           </div>
      </div>
    </v-toolbar>
  </template>
  
</v-data-table>
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
  </div>
</template>

<script>

import service from "@/services/GererProduct/GererProduct"
import AddCategoryView from '@/views/ProfilAdmin/Category/AddCategoryView.vue';

export default{
  name:'Category',

  mounted(){
      
  },
  created(){
    this.FetchData();
  },
data(){
  return{
    search: '',
    accepter:false,
    categories:[],
    snackbar:false,
    AddCategory:false,
    dialog:false,
    dialogDelete: false,
    load:true,
    headers: [
      { text: 'id',value:'id'},
      { text: 'name',value:'name' },
      { text: 'Photo',value:'PhtotoCatg'},
      { text: 'Operation',value:'actions'},
    ],

      }
  },
 
  methods:{
    FetchData(){
      service.getAllCategorieOptions().then((response)=>{
          this.categories=response.data;
          console.log(response.data);
      })
    },
    retour_consult(){
      this.AddCategory=false;
    }
    },
    components:{
      AddCategoryView
    },
    computed:{

    },

}
</script>    -->