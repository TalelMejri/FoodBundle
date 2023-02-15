<template>
    <div>
        <v-card class="elevation-12">
            <v-toolbar dark color="#E84C03">
               <v-toolbar-title >
                  <div class="d-flex justify-content-center">
                      <p style="text-align:center !important">Ajouter Categorie</p>
                  </div>
               </v-toolbar-title>
            </v-toolbar>
            <v-card-text>
            <form @submit.prevent="AddCategory()" enctype="multipart/form-data"> 
                 <div class="row">
                    <div class="col-md-12">
                     <v-text-field
                        name="Name"
                        v-model="formdata.name"
                        :error-messages="name_error"
                        label="Name "
                        type="text"
                        placeholder="Enter Name"
                      ></v-text-field>
                    
                   </div>
              <div class="col-md-12">
                <v-combobox
                    v-model="formdata.select"
                    :items="items"
                    :error-messages="select_error"
                    @change="fixIndice()"
                    item-text="name"
                    item-value="name"
                    label="Option"
                    multiple
                    outlined
                    dense
                 ></v-combobox>
           </div>
           </div>
           <div class="col-lg-12">
            <input    
                ref="file_identity"
                type="file"
                id="identity"
                class="form-control"
                @change="createBase64Image"
             >
         

         </div>
         <small v-if="file_error!=''">
          {{ file_error[0] }}
        </small>
        <div class="text-center mt-5 ">
            <v-btn :loading="load" class="mx-2" type="submit" style="color:#fff !important" color="#E84C03">
                Ajouter Categorie
           </v-btn>
           <v-btn @click="cancel()"  color="gray">
                Fermer
           </v-btn>
        </div>
             </form>
            </v-card-text>
         </v-card>
         <v-snackbar
         v-model="snackbar"
       >
          Categorie a été ajouter
       <template v-slot:action="{ attrs }">
        <v-btn
          color="green"
             text
             v-bind="attrs"
             @click="snackbar = false"
        >
          Fermer
         </v-btn>
        </template>
       </v-snackbar>
    </div>
</template>

<script>
import { required,numeric }   from 'vuelidate/lib/validators'
import service from "@/services/GererCategory/category";
export default{
  name:"addCategory",
    props:{
      addcat:Boolean
    },
    validations:{
        formdata:{
          name:{
             required
         },
         select:{
             required,
             numeric
         },
         file:{
              required,
                typeFile(val){
                   const tab_ext_dispo=['jpg','gif','png','svg','jpeg'];
                   const extention=val.split(';')[0].split('/')[1];
                   return tab_ext_dispo.find((v)=>v==extention) ? true : false ;
                }
         },
        }
      },
    data(){
        return{ 
          load:false,
          formdata:{
            name:'',
            select: [],
            file:'',
          },
            current_item:0,
            dialog:false,
            items:[],
            snackbar:false,
            categories:[],
            final_items:[],
            selectedImage:''
        }
    },
    methods:{
      cancel(){
        this.$emit('retour_consult');
      },
      createBase64Image(image) {
            const filee = document.querySelector("#identity").files[0];
            const reader = new FileReader();
            let rawImg = this;
            reader.onloadend = () => {
             rawImg.formdata.file = reader.result;
           };
           reader.readAsDataURL(filee);
      },
        fixIndice(){
            this.current_item=this.formdata.select.length-1;
            let index=this.items.findIndex((v)=>v.name==this.formdata.select[this.current_item]);
           // console.log(index +''+this.select[this.current_item]);
            if(index==-1){
              this.items.push({name:this.formdata.select[this.current_item]});
            }
        },
          handleImage(e) {
              const selectedImage = e.target.files[0]; 
              this.createBase64Image(selectedImage);
          },
        AddCategory(){
             this.$v.$touch();
             if (this.$v.$invalid) {
                this.load = false;
                return;
              }
          this.load=true;
          let i=0;
          let j=0;
          while(j<this.formdata.select.length){
            if(this.items[i]['name']!=this.formdata.select[j]){
                i++;
            }else{
              this.final_items.push((this.items[i]));
              j++;
            }
          }
            service.addCategory({
                'name':this.formdata.name,
                'file':this.formdata.file,
                'option':this.final_items
            }).then(()=>{
                 this.snackbar=true;
                 this.final_items=[];
                 this.items=[];
                 this.load=true;
                 this.formdata.select=[];
                 this.formdata.name="";
                 this.formdata.file="";
                 this.cancel();
            }).catch((error)=>{
              this.load=false;
              // this.name_error=error.response.data.errors.name ? error.response.data.errors.name[0] : '';
              // this.file_error=error.response.data.errors.PhtotoCatg ? error.response.data.errors.PhtotoCatg[0] : '';
              // this.option_error=error.response.data.errors.option ? error.response.data.errors.option[0] : '';
            })
        }
    },
    computed:{
            name_error(){
              const errors=[];
              if (!this.$v.formdata.name.$dirty) return errors;
                !this.$v.formdata.name.required && errors.push('name obligatoire');
                return errors;
            },
            select_error(){
              const errors=[];
              if (!this.$v.formdata.select.$dirty) return errors;
                !this.$v.formdata.select.required && errors.push('Option obligatoire');
                return errors;
            },
            file_error(){
              const errors=[];
            if (!this.$v.formdata.file.$dirty) return errors;
                  !this.$v.formdata.file.required && errors.push('image obligatoire');
                   !this.$v.formdata.file.typeFile && errors.push('image doit étre de type ( jpg,jpeg,png,svg,gif) ');
             return errors;
            },
       /*Option_food(){
         if(this.select_type_food=='Pizza'){
             return [
                   {name:'jambon',prix:15},
                   {name:'Thon',prix:25},
                ];
         }else if(this.select_type_food=='Pasta'){
            return [
                    {name:'Formage',prix:15},
                ];
         }else if(this.select_type_food=='Dessert'){
            return [
                    {name:'Chocolate',prix:15},
                ];
         }else if(this.select_type_food=='Drinks'){
            return [
                    {name:'lait',prix:15},
                ];
         }else if(this.select_type_food=='Sandwish'){
            return [ 
                    {name:'Salami',prix:15},
                    {name:'Formage',prix:25}
                ];
         }
        } */
    }
}
</script>

<style scoped>
 small{
  color: red !important;
 }
</style>