<template>
    <div class="mt-5 py-5">
        <div v-if="addproduct && !UpdateProduct && !addOption">
             <AddProductView @retourn_consulte="retourn_consulte"></AddProductView>
        </div>
        <div v-else-if="UpdateProduct && !addproduct && !addOption" >
              <UpdateProductView @retourn_consulte_from_update="retourn_consulte_from_update" :id="id_current"></UpdateProductView>
        </div>
        <div v-else-if="!UpdateProduct && !addproduct && addOption" >
              <AddOptionProductView @closeAdd="closeAdd" :id="id_current"></AddOptionProductView>
       </div>
        <div v-else>
         <v-card elevation="6" style="padding:25px">
                <h4 class="text-center py-4">List Produit</h4>
                <div class="row gap-4 p-5 mt-3">
                    <div class="col-lg-3 mx-2 text-center">
                         
                             <v-select
                                  :items="types"
                                  item-text="name"
                                  @change="FetchData()"
                                  item-value="id"
                                 v-model="select_id"
                                 label="Categorie"
                             ></v-select>
                       
                    </div>
                    <div class="col-lg-5 mx-2 text-center">
                       
                              <v-text-field
                                  v-model="search"
                                  append-icon="mdi-magnify"
                                  label="Recherche Par Name"
                                  @keyup="FetchData()"
                                  single-line
                                  hide-details
                            ></v-text-field>
                        
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
                            <span>Ajouter Produit</span>
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
                            Image
                          </th>
                          <th class="text-left">
                            Categorie
                          </th>
                          <th class="text-left">
                            Prix
                          </th>
                          <th class="text-left">
                            Operation
                          </th>
                        </tr>
                      </thead>
                      <tbody v-if="loader"> 
                        <tr class="text-center">
                           <td colspan="6">
                                <v-progress-circular
                                    indeterminate
                                    color="red"
                                 ></v-progress-circular>
                           </td>
                        </tr>
                    </tbody>
                      <tbody v-else-if="Products==''">
                        <tr >
                          <td colspan="6" class="text-center">Pas de données disponibles</td>
                        </tr>
                      </tbody>
                      <tbody v-else>
                        <tr
                          v-for="item in Products"
                          :key="item.id"
                        >
                          <td>{{item.id}}</td>
                          <td>{{ item.nameProduct }}</td>
                          <td><img width="80px" height="80px" :src="item.PhotoProduct" alt=""></td>
                          <td v-if="types.find((v)=>v.id==item.id_category) ? index=types.find((v)=>v.id==item.id_category) :'' ">
                              {{ index.name }} 
                          </td>
                          <td>{{ item.PrixProduct }}</td>
                             <td>
                             <v-tooltip c bottom>
                              <template v-slot:activator="{ on, attrs }">
                                  <v-btn
                                  class="mb-5 mx-2"
                                  v-bind="attrs"
                                  v-on="on"
                                  @click="initIndice(item)"
                                  fab
                                >
                                  <v-icon>mdi-delete</v-icon>
                                </v-btn>
                              </template>
                              <span>Supprimer Produit</span>
                            </v-tooltip>
                               
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
                                   >Supprimer Produit</v-toolbar>
                                   <v-card-text>
                                     <div class="text-h2 pa-12">{{item_selected.nameProduct}}</div>
                                   </v-card-text>
                                   <v-card-actions class="justify-end">
                                     <v-btn 
                                       text
                                       @click="deleteProduct(item_selected.id)"
                                     >Supprimer</v-btn>
                                     <v-btn
                                     text
                                     @click="dialog=false"
                                   >Fermer</v-btn>
                                   </v-card-actions>
                                 </v-card>
                               </template>
                             </v-dialog> 

                             <v-tooltip bottom>
                              <template v-slot:activator="{ on, attrs }">
                                  <v-btn
                                  class="mb-5 mx-2"
                                  v-bind="attrs"
                                  v-on="on"
                                  @click="editProduct(item.id)"
                                  fab
                                >
                                  <v-icon>mdi-square-edit-outline</v-icon>
                                </v-btn>
                              </template>
                              <span>Modifier Produit </span>
                            </v-tooltip>
 
                            <v-tooltip bottom>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                class="mb-5"
                                v-bind="attrs"
                                v-on="on"
                                @click="addOptionProduct(item.id)"
                                fab
                              >
                                <v-icon> mdi-food</v-icon>
                              </v-btn>
                            </template>
                            <span>Ajouter Option </span>
                          </v-tooltip>
                             
                             </td>
                           </tr>
                      </tbody>
                    </template>
                  </v-simple-table>
                  <div class="mt-5 row" style="text-align:center !important">
                     <v-btn class="mb-1" :disabled="pagination.prev_page==null" @click="changerPage(pagination.current_page-1)" small>
                      <v-icon>
                        mdi-chevron-left
                     </v-icon>
                     </v-btn>
                     <v-btn  v-for="num in (Math.ceil (pagination.per_page ? (pagination.total / pagination.per_page) : 1))" :key="num"
                        class="mx-2 mb-1"
                        color="primary"
                        @click="changerPage(num)"
                         small
                         :disabled="pagination.current_page==num"
                         x-small>
                        {{num}}
                     </v-btn>
                        
                     <v-btn :disabled="pagination.next_page==null" small  @click="changerPage(pagination.current_page+1)" >
                      <v-icon>
                        mdi-chevron-right
                     </v-icon>
                     </v-btn>
                  </div>
                  <v-snackbar
                  v-model="snackbar"
                >
                Supprimer avec succès
                  <template v-slot:action="{ attrs }">
                    <v-btn
                      color="indigo"
                      text
                      v-bind="attrs"
                      @click="snackbar = false"
                    >
                      Fermer
                    </v-btn>
                  </template>
                </v-snackbar>
         </v-card>
        </div>
    </div>
</template>

<script>
import service_category  from "@/services/GererCategory/category"
import service  from "@/services/GererProduct/GererProduct"
import AddProductView from "@/components/ProfilAdmin/Product/AddProduct.vue";
import UpdateProductView from "@/components/ProfilAdmin/Product/UpdateProduct.vue";
import AddOptionProductView from "@/components/ProfilAdmin/option/AddOptionProduct.vue"
export default{
    name:'Consultprodut',
    mounted(){
      this.FetchData();
      this.changerPage(1);
    },

    created(){
      service_category.getAllTypeCategory().then((response)=>{
            for(let i=0;i<(response.data).length;i++){
                this.types.push({name:response.data[i].name,id:response.data[i].id});
            }
        })
    },

    data(){
        return{
            search:'',
            namec:'',
            types:[],
            addproduct:false,
            pagination:{
              next_page:0,
              prev_page:0,
              per_page:0,
              total:0,
              current_page:1
            },
            dialogOptiondelete:false,
            id_current:0,
            SelectedDeleteOption:[],
            Products:[],
            option_selected:[],
            dialogOptionedit:false,
            name_edit:'',
            UpdateProduct:false,
            addOption:false,
            prix_edit:'',
            loader:true,
            select_id:-1,
            dialog:false,   
            item_selected:0
        }
    },
    methods:{
      initIndice(initIndice){
        this.item_selected=initIndice;
        this.dialog=true;
      },
      deleteProduct(id){
        service.deleteProduct(id).then(()=>{
            this.item_selected=[];
            this.dialog=true;
            this.snackbar=true;
            this.FetchData();
        })
      },
      editIndiceDialog(initIndice){
        this.option_selected=initIndice;
        this.dialogOptionedit=true;
        this.name_edit=this.option_selected.nameOptionSpecifique;
        this.prix_edit=this.option_selected.prixOptionSpecifique;
      },
      addOptionProduct(e){
        this.id_current=e;
        this.addOption=true;
      },
      editProduct(e){
        this.id_current=e;
        this.UpdateProduct=true;
      },
      initIndiceOption(a){
        this.SelectedDeleteOption=a;
        this.dialogOptiondelete=true;
      },
      deleteOption(id){
        service.deleteOptionSpecifique(id).then(()=>{
            this.SelectedDeleteOption=[];
            this.dialogOptiondelete=true;
            this.snackbar=true;
            this.FetchData();
        })
      },
      updateOption(){
        service.UpdateOptionSpecifique(this.option_selected.id,{name:this.name_edit,prix:this.prix_edit}).then(()=>{
          this.option_selected=[];
          this.FetchData();
        })
      },
      changerPage(a){
        this.pagination.current_page=a;
        this.FetchData();
      },

      retourn_consulte_from_update(){
        this.UpdateProduct=false;
        this.FetchData();
      },
      retourn_consulte(){
        this.addproduct=false;
        this.FetchData();
      },
      closeAdd(){
          this.addOption=false;
          this.FetchData();
      },
      FetchData(){
        service.GetProductCategoryOption(this.select_id,this.search,this.pagination.current_page).then((response)=>{
            this.Products=response.data.data.data;
            this.pagination.current_page=response.data.data.current_page;
            this.pagination.total=response.data.data.total;
            this.pagination.next_page=response.data.data.next_page_url?.split("=")[1];
            this.pagination.prev_page=response.data.data.prev_page_url?.split("=")[1];
            this.pagination.per_page=response.data.data.per_page;
            this.loader=false;
        })
      },
    },
    computed:{
    
    },
    components:{
        AddProductView,UpdateProductView,AddOptionProductView
    }
}
</script>

<style scoped>
th{
    color: #000 !important;
    font-weight: 600 !important;
}
</style>