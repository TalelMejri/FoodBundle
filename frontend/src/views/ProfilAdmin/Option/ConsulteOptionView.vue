<template>
    <div class="mt-5 py-5">
        <v-card  elavation="7" style="padding:25px">
            <div v-if="list=='global'">
                <h4 class="text-center py-4" >List Option Global</h4>
                <div class="text-center">
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                            @click="changer_specifier"
                            class="mb-5"
                            v-bind="attrs"
                            v-on="on"
                            outlined
                            fab
                            color="#E84C03"
                          >
                            <v-icon>mdi-shaker-outline</v-icon>
                          </v-btn>
                        </template>
                        <span>Specifique</span>
                      </v-tooltip>
                </div>
            </div>
            <div  v-else>
                <h4 class="text-center py-4" >List Option Specifique</h4>
                <div class="text-center">
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                            @click="changer_global"
                            class="mb-5"
                            v-bind="attrs"
                            v-on="on"
                            outlined
                            fab
                            color="#E84C03"
                          >
                            <v-icon>mdi-shaker</v-icon>
                          </v-btn>
                        </template>
                        <span>globale</span>
                      </v-tooltip>
                </div>
            </div>

       <div class="row gap-4 p-5 ">
        <div class="col-lg-3 mx-2 text-center">
          <v-text-field
              v-model="search"
              append-icon="mdi-magnify"
              @keyup="serchdata()"
              label="Recherche Option"
              single-line
              hide-details
         ></v-text-field>  
      </div>
      <v-spacer></v-spacer>
      <div class="col-lg-3" v-if="list=='global'">
        <v-select
        :items="types"
        item-text="name"
        item-value="id"
        @change="fetchData_global()"
        v-model="id_category_selected"
        label="Categorie"
    ></v-select>
      </div>
      <div v-else class="col-lg-3">
        <v-select
          :items="products"
          item-text="name"
          @change="fetchData_sepecifique()"
          item-value="id"
          v-model="id_product_selected"
          label="Produit"
        ></v-select>
      </div>
    
      </div>
      <v-simple-table >
        <template v-slot:default>
          <thead>
            <tr>
              <th  class="text-left ">
                Id {{ pagination.current_page }}
              </th>
              <th  class="text-left ">
                Name
              </th>
              <th v-if="list!='global'"  class="text-left ">
                prix
              </th>
              <th v-if="list=='global'" class="text-left ">
               Categorie
              </th>
              <th v-else class="text-left ">
                Produit
              </th>
              <th class="text-left">
                Operation
              </th>
            </tr>
          </thead>
          <tbody v-if="loader==''">
            <tr>
                 <td colspan="5" class="text-center">
                    <v-progress-circular
                    :width="3"
                    color="red"
                    indeterminate
                ></v-progress-circular></td>
            </tr>
          </tbody>
          <tbody v-else-if="Options==''">
            <tr>
                 <td colspan="5" class="text-center">
                  Pas de données disponibles
                 </td>
            </tr>
          </tbody>
          <tbody v-else-if="list=='global' ">
            <tr v-for="option in Options" :key="option.id">
                <td>{{option.id}}</td>
                <td>{{option.nameOption}}</td>
                <td v-if="types.find((v)=>v.id==option.category_id) ? index=types.find((v)=>v.id==option.category_id) :'' ">
                    {{ index.name }} 
                </td>
                <td>

                  <v-tooltip c bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                        class="mb-5 mx-2"
                        v-bind="attrs"
                        v-on="on"
                        @click="initIndice(option)"
                        fab
                      >
                        <v-icon>mdi-delete</v-icon>
                      </v-btn>
                    </template>
                    <span>Supprimer Option</span>
                  </v-tooltip>

          <v-dialog
                  v-if="option_selected_delete!=''"
                  transition="dialog-bottom-transition"
                  max-width="600"
                  v-model="dialogdelete"
            >
             <template  >
               <v-card>
                 <v-toolbar
                   color="danger"
                   dark
                 >Supprimer Option</v-toolbar>
                 <v-card-text>
                   <div class="text-h2 pa-12">{{option_selected_delete.nameOption}}</div>
                 </v-card-text>
                 <v-card-actions class="justify-end">
                   <v-btn
                     text
                     :loading="load"
                     @click="deleteOption(option_selected_delete.id)"
                   >Supprimer</v-btn>
                   <v-btn
                   text
                   @click="option_selected_delete=[]"
                 >Fermer</v-btn>
                 </v-card-actions>
               </v-card>
             </template>
           </v-dialog> 

                  <v-tooltip c bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                        class="mb-5 mx-2"
                        v-bind="attrs"
                        v-on="on"
                        @click="EditIndice(option)"
                        fab
                      >
                      <v-icon>mdi-square-edit-outline</v-icon>
                      </v-btn>
                    </template>
                    <span>Modifier Option</span>
                  </v-tooltip>

              <v-dialog v-if="option_selected!=''"
                  transition="dialog-bottom-transition"
                  max-width="600"
                  v-model="dialogedit"
                >
                 <template >
                   <v-card>
                     <v-toolbar
                       color="yellow"
                       dark
                     >Modifier Option</v-toolbar>
                     <v-card-text>
                      <form @submit.prevent="updateOption()">
                        <div class="mx-5 px-5">
                          <v-text-field
                          name="name"
                          label="name"
                          type="text"
                          :error-messages="name_error"
                          v-model="name"
                          placeholder="Enter Name"
                        ></v-text-field>
                        </div>
                      <v-divider></v-divider>
                     <v-card-actions class="justify-end">
                       <v-btn type="submit"
                         text
                         :loading="load"
                        >Modifier</v-btn>
                       <v-btn
                       text
                       @click="option_selected=[]"
                     >Fermer</v-btn>
                     </v-card-actions>
                     </form>
                    </v-card-text>
                   </v-card>
                 </template>
               </v-dialog> 
                </td>
            </tr>
          </tbody>
          <tbody v-else>
            <tr v-for="option in Options" :key="option.id">
                <td>{{option.id}}</td>
                <td >{{option.nameOptionSpecifique}}</td>
                <td >{{option.prixOptionSpecifique}}</td>
                <td v-if="products.find((v)=>v.id==option.product_id) ? index=products.find((v)=>v.id==option.product_id) : -1">
                    {{ index.name }}
                </td>
                <td>
                  <v-tooltip c bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                        class="mb-5 mx-2"
                        v-bind="attrs"
                        v-on="on"
                        @click="initIndice(option)"
                        fab
                      >
                        <v-icon>mdi-delete</v-icon>
                      </v-btn>
                    </template>
                    <span>Supprimer Option</span>
                  </v-tooltip>

          <v-dialog
                  v-if="option_selected_delete!=''"
                  transition="dialog-bottom-transition"
                  max-width="600"
                  v-model="dialogdelete"
            >
             <template  >
               <v-card>
                 <v-toolbar
                   color="danger"
                   dark
                 >Supprimer Option</v-toolbar>
                 <v-card-text>
                   <div class="text-h2 pa-12">{{option_selected_delete.nameOptionSpecifique}}</div>
                 </v-card-text>
                 <v-card-actions class="justify-end">
                   <v-btn
                     text
                     :loading="load"
                     @click="deleteOption(option_selected_delete.id)"
                   >Supprimer </v-btn>
                   <v-btn
                   text
                   @click="option_selected_delete=[]"
                 >Fermer</v-btn>
                 </v-card-actions>
               </v-card>
             </template>
           </v-dialog> 

                  <v-tooltip c bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                        class="mb-5 mx-2"
                        v-bind="attrs"
                        v-on="on"
                        @click="EditIndice(option)"
                        fab
                      >
                        <v-icon>mdi-square-edit-outline</v-icon>
                      </v-btn>
                    </template>
                    <span>Modifier Option</span>
                  </v-tooltip>
                  <v-dialog v-if="option_selected!=''"
                  transition="dialog-bottom-transition"
                  max-width="600"
                  v-model="dialogedit"
                >
                 <template >
                   <v-card>
                     <v-toolbar
                       color="yellow"
                       dark
                     >Modifier Option</v-toolbar>
                     <v-card-text>
                      <form @submit.prevent="updateOption()">
                        <div class="mx-5 px-5">
                          <v-text-field
                          name="name"
                          label="name"
                          :error-messages="name_error"
                          type="text"
                          v-model="name"
                          placeholder="Enter Name"
                        ></v-text-field>

                          <v-text-field
                          name="prix"
                          label="prix "
                          type="text"
                          :error-messages="prix_error"
                          v-model="prix"
                          placeholder="Enter Prix"
                        ></v-text-field>
                        </div>
                      <v-divider></v-divider>
                     <v-card-actions class="justify-end">
                       <v-btn type="submit"
                         text
                         :loading="load"
                        >Modifier</v-btn>
                       <v-btn
                       text
                       @click="option_selected=[]"
                     >Fermer</v-btn>
                     </v-card-actions>
                     </form>
                    </v-card-text>
                   </v-card>
                 </template>
               </v-dialog> 
                </td>
            </tr>
          </tbody>
          </template>
          </v-simple-table>

          <div v-if="Options!=''" >
                <v-btn class="mx-1" :disabled="pagination.prev_page==null"  @click="changer_page(pagination.current_page-1)" small>
                  <v-icon>
                    mdi-chevron-left
                 </v-icon>
                </v-btn>
                <v-btn class="mx-1"
                    v-for="num in (Math.ceil(pagination.per_page ? (pagination.total/pagination.per_page) : 1))"
                     :key="num" 
                     @click="changer_page(num)" 
                     color="primary"
                     :disabled="num==pagination.current_page"
                     small>
                     {{num}}
                </v-btn>
                <v-btn :disabled="pagination.next_page==null"  @click="changer_page(pagination.current_page+1)" small>
                  <v-icon>
                    mdi-chevron-right
                 </v-icon>
                </v-btn>
          </div>
          <v-snackbar
          v-model="snackbar"
        >
          Supprimer l'option avec succès
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

        <v-snackbar
        v-model="snackbar_edit"
      >
      Mettre à jour l'option avec succès
        <template v-slot:action="{ attrs }">
          <v-btn
            color="indigo"
            text
            v-bind="attrs"
            @click="snackbar_edit = false"
          >
            Fermer
          </v-btn>
        </template>
      </v-snackbar>
    </v-card>
    </div>
</template>

<script>
import service_category from "@/services/GererCategory/category"
import service_product from "@/services/GererProduct/GererProduct"
import service_option from "@/services/GererOption/option"
import { required,numeric} from 'vuelidate/lib/validators'
export default{
    name:'option',
    validations:{
      name:{
        required
      },
      prix:{
        required,
        numeric
      }
    },
    created(){
        if(this.list=='global'){
            this.fetchData_global();
        }else{
            this.fetchData_sepecifique();
        }
        service_category.getAllTypeCategory().then((response)=>{
            for(let i=0;i<(response.data).length;i++){
                this.types.push({name:response.data[i].name,id:response.data[i].id});
            }
        });
        service_product.getallProduct().then((response)=>{
            for(let i=0;i<(response.data).length;i++){
                this.products.push({name:response.data[i].nameProduct,id:response.data[i].id});
            }
        })
    },
    data(){
        return{
            search:'',
            list:'global',
            pagination:{
               current_page:1,
               prev_page:0,
               next_page:0,
               per_page:0,
               total:0
            },
            Options:[],
            types:[],
            products:[],
            id_product_selected:-1,
            id_category_selected:-1,
            name:'',
            prix:'',
            option_selected:[],
            option_selected_delete:[],
            loader:false,
            load:false,
            snackbar_edit:false,
            snackbar:false
        }
    },
    methods:{
      init(){
            this.option_selected_delete=[];
            this.dialogdelete=false;
      },
      deleteOption(id){
        this.load=true;
        if(this.list=='global'){
          service_option.deleteOption(id).then(()=>{
            this.load=false;
            this.init();
            this.fetchData_global();
          })
        }else{
          service_option.deleteOptionSpecifique(id).then(()=>{
            this.load=false;
            this.init();
            this.fetchData_sepecifique();
          })
        }
        this.snackbar=true;
      },
      initedit(){
          this.option_selected=[];
          this.dialogedit=false;
          this.snackbar_edit=true;
      },
      updateOption(){
        if(this.list=='global'){
             this.$v.name.$touch();
             if (this.$v.name.$invalid) {
                this.load = false;
                return;
              }
              this.load = true;
          service_option.UpdateOption(this.option_selected.id,{name:this.name}).then((r)=>{
            this.initedit();
            this.fetchData_global();
         })
        }else{
             this.$v.name.$touch();
             this.$v.prix.$touch();
             if (this.$v.name.$invalid && this.$v.prix.$invalid ) {
                this.load = false;
                return;
              }
              this.load=true;
         service_option.UpdateOptionSpecifique(this.option_selected.id,{name:this.name,prix:this.prix}).then((r)=>{
            this.initedit();
            this.load=false;
            this.fetchData_sepecifique();
         })
        }
      },
      initIndice(item){
        this.option_selected_delete=item;
        this.dialogdelete=true;
      },
      EditIndice(item){
        if(this.list=='global'){
          this.name=item.nameOption;
          this.prix=item.prixOption;
        }else{
          this.name=item.nameOptionSpecifique;
          this.prix=item.prixOptionSpecifique;
        }
        this.option_selected=item;
        this.dialogedit=true;
      },
        serchdata(){
            if( this.list=='global'){
                this.fetchData_global();
            }else{
                this.fetchData_sepecifique();
            }
        },
        changer_page(a){
            this.pagination.current_page=a;
            if( this.list=='global'){
                this.fetchData_global();
            }else{
                this.fetchData_sepecifique();
            }
        },
       changer_global(){
         this.list='global';
         this.changer_page(1);
         this.fetchData_global();
       },
       changer_specifier(){
         this.list='specifique';
         this.changer_page(1);
         this.fetchData_sepecifique();
       },
       global_pagination(data){
            this.pagination.total=data.total;
            this.pagination.per_page=data.per_page;
            this.pagination.current_page=data.current_page;
            this.pagination.next_page=data.next_page_url?.split("=")[1];
            this.pagination.prev_page=data.prev_page_url?.split("=")[1];
       },
       fetchData_global(){
        service_option.getOptionGlobal(this.id_category_selected,this.search,this.pagination.current_page).then((res)=>{
             this.Options= res.data.data;
             this.global_pagination(res.data);
             this.loader=true;
        }).catch((error)=>{
            console.log("error");
        })
       },
       fetchData_sepecifique(){
        service_option.getOptionSpecifique(this.id_product_selected,this.search,this.pagination.current_page).then((res)=>{
            this.Options= res.data.data; 
            this.global_pagination(res.data);
            this.loader=true;
        })
       }
    },
    computed:{
          name_error(){
              const errors=[];
              if (!this.$v.name.$dirty) return errors;
                !this.$v.name.required && errors.push('name obligatoire');
                return errors;
            },
            prix_error(){
              const errors=[];
              if (!this.$v.prix.$dirty) return errors;
                !this.$v.prix.required && errors.push('prix obligatoire');
                !this.$v.prix.numeric && errors.push('name doit etre numerique');
                return errors;
            },
    }
}
</script>