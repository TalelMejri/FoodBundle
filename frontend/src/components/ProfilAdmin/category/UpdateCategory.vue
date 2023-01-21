<template>
    <div>
        <v-card class="elevation-12">
            <v-toolbar dark color="#E84C03">
               <v-toolbar-title >
                  <div class="d-flex justify-content-center">
                      <p style="text-align:center !important">Update Category  </p>
                  </div>
               </v-toolbar-title>
            </v-toolbar>
            <v-card-text>
                    <form @submit.prevent="update()" enctype="multipart/form-data"> 
                        <v-text-field
                            name="Name"
                            v-model="name"
                            label="Name"
                            type="text"
                            placeholder="Enter Name"
                      ></v-text-field>

                        <div class="text-center">
                           <img width="150px" style="border-radius:25px" :src="file_category" alt="">
                                <br>
                                     <input    
                                        ref="file_category"
                                        type="file"
                                        id="identity"
                                        class="form-control"
                                        @change="createBase64Image"
                                     >       
                        </div>
                        <div class="text-center mt-2 py-2">
                            <v-btn type="submit" class="mx-2 mb-2" color="yellow">
                                Update
                            </v-btn>
                            <v-btn  @click="close_update()">
                               Close
                           </v-btn>
                       </div>
                    </form>
             </v-card-text>
        </v-card>
    </div>
</template>

<script>
import service from '@/services/GererCategory/category'

export default{
    created(){
       service.findCategoryByIid(this.id).then((response)=>{
            this.name=response.data.data.name;
            this.file_category=response.data.data.PhtotoCatg;
        })
    },
    data(){
        return{
            category:[],
            name:'',
            file:'',
            file_category:'',
            avatarupload:false
        }
    },
    props:{
      updatecat:Boolean,
      id:Number
    },
    name:'updatecat',
    methods:{
        close_update(){
            this.$emit('close_update');
        },
        createBase64Image() {
            const filee = document.querySelector("#identity").files[0];
            const reader = new FileReader();
            let rawImg = this;
            reader.onloadend = () => {
              rawImg.file_category = reader.result;
              console.log(rawImg.file_category);
           };
           reader.readAsDataURL(filee);
      },
      update(){
         service.UpdateCategory(this.id,{name:this.name,file:this.file_category,avatarupload:this.avatarupload}).then(()=>{
             this.$emit('close_update');
         }).catch((error)=>{
            console.log('error');
         })
      }
    }
}
</script>