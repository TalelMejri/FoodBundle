<template>
    <div class="mt-5 py-5">
        <div v-if="AddCategory && !UpdateCategory && !addOption">
            <AddCategoryView @retour_consult="retour_consult"
                               :addcat="AddCategory">
            </AddCategoryView>
        </div>
        <div v-else-if="UpdateCategory && !AddCategory && !addOption">

            <UpdateCategory @retour_consult="retour_consult"
                                 @close_update="close_update" 
                                :id="selectIdCategory" 
                                :updatecat="UpdateCategory"
            ></UpdateCategory>

       </div>
       <div v-else-if="addOption && !AddCategory &&!UpdateCategory">
            <addOptionVue :id="idForCategory" 
                            @closeAdd="closeAdd"
            ></addOptionVue>
      </div>
        <div v-else>
          <v-card elavation="7" style="padding:25px">
          <h4 class="text-center py-4">List Categories</h4>
                <div class="row gap-4 p-5 mt-3">
                    <div class="col-lg-3 mx-2 text-center">
                      <v-text-field
                          v-model="search"
                          @keyup="FetchData()"
                          append-icon="mdi-magnify"
                          label="Search"
                          single-line
                          hide-details
                     ></v-text-field>  
                  </div>
                    <v-spacer></v-spacer>
                    <div class="col-lg-3  text-center">
                      <div class="row">
                        <div class="col-lg-12 text-center">
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
                    </div>
                    </div>
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
import service_category from "@/services/GererCategory/category"
import AddCategoryView from '@/components/ProfilAdmin/category/AddCategory.vue';
import UpdateCategory from "@/components/ProfilAdmin/category/UpdateCategory.vue";
import addOptionVue from "@/components/ProfilAdmin/option/AddOption.vue"
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
        service_category.deleteCategory(id).then(()=>{
            this.FetchData();
            this.dialog=false;
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
        service_category.getAllCategorieOptions(this.search,this.pagination.curentpage).then((response)=>{
            this.pagination.prevpage=response.data[0].prev_page_url?.split("=")[1];
            this.pagination.nextpage=response.data[0].next_page_url?.split("=")[1];
            this.pagination.per_page=response.data[0].per_page;
            this.pagination.total=response.data[0].total;
            this.categories=response.data[0].data;
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

