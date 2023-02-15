<template>
    <div>
        <v-card class="elevation-12">
            <v-toolbar dark color="#E84C03">
               <v-toolbar-title >
                  <div class="d-flex justify-content-center">
                      <p style="text-align:center !important">Modifier Categorie  </p>
                  </div>
               </v-toolbar-title>
            </v-toolbar>
            <v-card-text>
                    <form @submit.prevent="update()" enctype="multipart/form-data"> 
                        <v-text-field
                            name="Name"
                            v-model="formdata.name"
                            :error-messages="name_error"
                            label="Name"
                            type="text"
                            placeholder="Enter Name"
                      ></v-text-field>

                        <div class="text-center">
                           <img width="150px" style="border-radius:25px" :src="formdata.file_category" alt="">
                                <br>
                                     <input    
                                        ref="file_category"
                                        type="file"
                                        id="identity"
                                        class="form-control"
                                        @change="createBase64Image"
                                     >    
                                     <small style="color:red" v-if="file_error!=''">
                                        {{  file_error }}
                                     </small>   
                        </div>
                        <div class="text-center mt-2 py-2">
                            <v-btn :loading="load" type="submit" class="mx-2 mb-2" color="yellow">
                                Modifier
                            </v-btn>
                            <v-btn  @click="close_update('fermer')">
                               Fermer
                           </v-btn>
                       </div>
                    </form>
             </v-card-text>
        </v-card>
    </div>
</template>

<script>
import service from '@/services/GererCategory/category'
import { required,numeric }   from 'vuelidate/lib/validators'
export default{
    created(){
       service.findCategoryByIid(this.id).then((response)=>{
            this.formdata.name=response.data.data.name;
            this.formdata.file_category=response.data.data.PhtotoCatg;
        })
    },
    validations:{
        formdata:{
          name:{
             required
         },
         file_category:{
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
            category:[],
            load:false,
            formdata:{
                name:'',
                file_category:'',
            },
            avatarupload:false
        }
    },
    props:{
      updatecat:Boolean,
      id:Number
    },
    name:'updatecat',
    methods:{
        close_update(check){
            this.$emit('close_update',check);
        },
        createBase64Image() {
            const filee = document.querySelector("#identity").files[0];
            const reader = new FileReader();
            let rawImg = this;
            reader.onloadend = () => {
              rawImg.formdata.file_category = reader.result;
              console.log(rawImg.formdata.file_category);
           };
           reader.readAsDataURL(filee);
      },
      update(){
             this.$v.formdata.$touch();
             if (this.$v.formdata.$invalid) {
                this.load = false;
                return;
              }
              this.load = true;
         service.UpdateCategory(this.id,{
                    name:this.formdata.name,
                    file:this.formdata.file_category,
                    avatarupload:this.avatarupload
                }).then(()=>{
                    this.load = false;
             this.$emit('close_update','updated');
         }).catch((error)=>{
            this.load = false;
            console.log('error');
         })
      }
    },
    computed:{
        file_error(){
              const errors=[];
            if (!this.$v.formdata.file_category.$dirty) return errors;
                  !this.$v.formdata.file_category.required && errors.push('image obligatoire');
                   !this.$v.formdata.file_category.typeFile && errors.push('image doit étre de type ( jpg,jpeg,png,svg,gif) ');
             return errors;
            },
            name_error(){
            const errors=[];
              if (!this.$v.formdata.name.$dirty) return errors;
                !this.$v.formdata.name.required && errors.push('name obligatoire');
                return errors;
            },
    }
}
</script>