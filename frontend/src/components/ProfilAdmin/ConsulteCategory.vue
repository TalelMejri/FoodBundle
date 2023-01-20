<template>
    <div class="mt-5 py-5">
        <div v-if="AddCategory && !UpdateCategory && !addOption">
            <AddCategoryView @retour_consult="retour_consult"  :addcat="AddCategory"></AddCategoryView>
        </div>
        <div v-else-if="UpdateCategory && !AddCategory && !addOption">
           <UpdateCategory @retour_consult="retour_consult" @close_update="close_update" :id="selectIdCategory" :updatecat="UpdateCategory"></UpdateCategory>
       </div>
       <div v-else-if="addOption && !AddCategory &&!UpdateCategory">
        <addOptionVue   :id="idForCategory" @closeAdd="closeAdd"></addOptionVue>
      </div>
        <div v-else>
      <v-toolbar class="py-3">
        <div class="row  ">
             <div class="col-lg-4 ">
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
                        class="mb-5"
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
          <tbody v-else-if="categories==''">
            <tr >
              <td colspan="6" class="text-center">No data available</td>
            </tr>
          </tbody>
          <tbody v-else>
            <tr
              v-for="item in categories"
              :key="item.id"
            >
         
              <td>{{ item.id }}</td>
              <td>{{ item.name }}</td>
              <td><img width="80px" height="80px"  :src="item.PhtotoCatg" alt=""></td>
              <td v-if="item.options!=''">
             <v-list>
                  <v-list-group
                      v-for="(i) in item.options"
                      :key="i.id"
                  >

                  <v-dialog
                      v-if="SelectedDeleteOption!=''"
                      transition="dialog-bottom-transition"
                      max-width="600"
                      v-model="dialogOptiondelete"
                >
                 <template  >
                   <v-card>
                     <v-toolbar
                       color="danger"
                       dark
                     >Delete Option</v-toolbar>
                     <v-card-text>
                       <div class="text-h2 pa-12">{{SelectedDeleteOption.nameOption}}</div>
                     </v-card-text>
                     <v-card-actions class="justify-end">
                       <v-btn
                         text
                         @click="deleteOp(SelectedDeleteOption.id)"
                       >Delete</v-btn>
                       <v-btn
                       text
                       @click="SelectedDeleteOption=[]"
                     >close</v-btn>
                     </v-card-actions>
                   </v-card>
                 </template>
               </v-dialog>

                <v-dialog v-if="option_selected!=''"
                  transition="dialog-bottom-transition"
                  max-width="600"
                  v-model="dialogOptionedit"
                >
                 <template >
                   <v-card>
                     <v-toolbar
                       color="yellow"
                       dark
                     >Edit Option</v-toolbar>
                     <v-card-text>
                      <form @submit.prevent="updateOption()">
                        <div class="mx-5 px-5">
                          <v-text-field
                          name="name"
                          label="name"
                          type="text"
                          v-model="name_edit"
                          placeholder="Enter Name"
                        ></v-text-field>

                          <v-text-field
                          name="prix"
                          label="prix "
                          type="text"
                          v-model="prix_edit"
                          placeholder="Enter Prix"
                        ></v-text-field>
                        </div>
                      <v-divider></v-divider>
                     <v-card-actions class="justify-end">
                       <v-btn type="submit"
                         text
                        >Update</v-btn>
                       <v-btn
                       text
                       @click="option_selected=[]"
                     >close</v-btn>
                     </v-card-actions>
                     </form>
                    </v-card-text>
                   </v-card>
                 </template>
               </v-dialog> 

                    <template  v-slot:activator>
                      <v-list-item-content>
                        <v-list-item-title>{{i.nameOption}}</v-list-item-title>
                      </v-list-item-content>
                          <v-btn  @click="deleteOption(i)" color="red" class="mx-2">
                            <v-icon color="#fff">
                               mdi-delete 
                          </v-icon>
                         </v-btn>
                          <v-btn  @click="editIndiceDialog(i)" color="yellow" >
                             <v-icon color="#fff">
                                mdi-square-edit-outline
                            </v-icon> 
                        </v-btn>
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
                 <v-btn @click="initIndice(item)" class="mx-2 mb-2">
                      <v-icon>
                         mdi-delete
                      </v-icon>  
                 </v-btn>
                 <v-btn class="mx-2 mb-2" @click="editCategory(item.id)"> 
                    <v-icon>
                        mdi-square-edit-outline
                    </v-icon>  
               </v-btn>
               <v-btn class="mx-2 mb-2" @click="MoveToOptionWithId(item.id)"> 
                <v-icon>
                    mdi-food
                </v-icon>  
           </v-btn>
              </td>
            </tr>
          </tbody>
          <div class="text-center mt-2">

            <v-btn :disabled="pagination.prevpage==null"  @click="changerPage(pagination.curentpage-1)">
              prev
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
            <v-btn :disabled="pagination.nextpage==null"  @click="changerPage(pagination.curentpage+1)">
               suivant
            </v-btn>
          </div>
        </template>  
        
      </v-simple-table>

      <v-dialog  v-if="item_selected!=''"
              transition="dialog-bottom-transition"
              max-width="600"
              v-model="dialog"
            >
             <template >
               <v-card>
                 <v-toolbar
                   color="danger"
                   dark
                 >Delete Category</v-toolbar>
                 <v-card-text>
                   <div class="text-h2 pa-12">{{item_selected.name}}</div>
                 </v-card-text>
                 <v-card-actions class="justify-end">
                   <v-btn 
                     text
                     @click="deleteCat(item_selected.id)"
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
    </div>
   
    </div>
</template>

<script>

import service from "@/services/GererProduct/GererProduct"
import AddCategoryView from '@/views/ProfilAdmin/Category/AddCategoryView.vue';
import UpdateCategory from "@/views/ProfilAdmin/Category/UpdateCategory.vue";
import addOptionVue from "@/components/ProfilAdmin/AddOption.vue"
export default{
    name:'Category',
    mounted(){
      this.FetchData();
      this.changerPage(1);
      this.option_selected=[];
      this.item_selected=[];
    },
  data(){
    return{
      search: '',
      dialogOption:false,
      name_edit:'',
      prix_edit:'',
      categories:[],
      item_selected:[],
      option_selected:[],
      SelectedDeleteOption:[],
      snackbar:false,
      addOption:false,
      loaddeletecat:false,
      pagination:{
        curentpage:1,
        nextpage:0,
        prevpage:0,
        total:0,
        per_page:0,
      },
      AddCategory:false,
      UpdateCategory:false,
      dialog:false,
      loader:true,
      selectIdCategory:0,
      dialogOptiondelete:false,
      idForCategory:0,
      dialogaddoption:false
      }
    },
    methods:{
      changerPage(num){
        this.pagination.curentpage=num;
        this.FetchData();
      },
      MoveToOptionWithId(id){
        this.idForCategory=id;
        this.addOption=true;
      },
      deleteOption(a){
        this.SelectedDeleteOption=a;
        this.dialogOptiondelete=true;
      },
      editIndiceDialog(initIndice){
        this.option_selected=initIndice;
        this.dialogOptionedit=true;
        this.name_edit=this.option_selected.nameOption;
        this.prix_edit=this.option_selected.prixOption;
      },
      initIndice(initIndice){
        this.item_selected=initIndice;
        this.dialog=true;
      },
      initIndiceOption(initIndice){
        this.option_selected=initIndice;
        this.dialogOption=true;
      },
      editCategory(id){
          this.selectIdCategory=id;
          this.UpdateCategory=true;
      },
      updateOption(){
        service.UpdateOption(this.option_selected.id,{name:this.name_edit,prix:this.prix_edit}).then(()=>{
          this.option_selected=[];
        })
      },
      deleteCat(id){
        service.deleteCategory(id).then(()=>{
            this.FetchData();
            this.loaddeletecat=true;
            this.dialog=true;
            this.snackbar=true;
        })
      },
      deleteOp(id){
        service.deleteOption(id).then(()=>{
            this.FetchData();
            this.SelectedDeleteOption=[];
            this.dialogOptiondelete=false;
            this.snackbar=true;
        })
      },
      FetchData(){
        service.getAllCategorieOptions(this.search,this.pagination.curentpage).then((response)=>{
            this.pagination.prevpage=response.data[0].prev_page_url?.split("=")[1];
            this.pagination.nextpage=response.data[0].next_page_url?.split("=")[1];
            this.pagination.per_page=response.data[0].per_page;
            this.pagination.total=response.data[0].total;
            this.categories=response.data[0].data;
            console.log(response.data[0]);
            this.loader=false;
        })
      },
      retour_consult(){
        this.FetchData();
        this.AddCategory=false;
      },
      closeAdd(){
        this.FetchData();
        this.addOption=false;
      },
      close_update(){
        this.FetchData();
        this.UpdateCategory=false;
      }
      },
      components:{
        AddCategoryView,UpdateCategory,addOptionVue
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