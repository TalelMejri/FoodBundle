<template>
    <div>
        <v-card class="elevation-12">
            <v-toolbar dark color="yellow">
               <v-toolbar-title >
                  <div class="d-flex justify-content-center">
                      <p style="text-align:center !important;color:#000">Update Product  </p>
                  </div>
               </v-toolbar-title>
            </v-toolbar>
            <v-card-text>
                  <form @submit.prevent="update()" >
                    <div class="row">
                        <div class="col-lg-6">
                            <v-text-field
                            name="Name"
                            v-model="name"
                            label="Name"
                            type="text"
                         ></v-text-field>
                        </div>
                        <div class="col-lg-6">
                            <v-text-field
                             name="prix"
                             v-model="prix"
                             label="prix"
                             type="text"
                            ></v-text-field>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <v-select
                                :items="types"
                                item-text="name"
                                item-value="id"
                                v-model="id_category"
                                label="Type"
                       ></v-select>
                 
                        </div>
                    </div>

                         <div class="text-center">
                            <div>
                                <img style="border-radius:25px" width="30%" height="20%" :src="file" :alt="name">
                            </div>
                            <div>
                               <input type="file" @change="base64()" id="file" >
                            </div>
                        </div>
                        <div class="mt-3">
                                 <v-btn type="submit" class="mx-2" color="yellow">
                                        update
                                 </v-btn>
                                 <v-btn @click="close()">
                                        close
                                 </v-btn>
                        </div>
                  </form>
           </v-card-text>
        </v-card>
    </div>
</template>

<script>
import service_category from "@/services/GererCategory/category"
import service from "@/services/GererProduct/GererProduct"
 export default{
    created(){

        service_category.getAllTypeCategory().then((response)=>{
            for(let i=0;i<(response.data).length;i++){
                this.types.push({name:response.data[i].name,id:response.data[i].id});
            }
        });

       service.findProductByIid(this.id).then((response)=>{
              this.name=response.data.data.nameProduct;
              this.file=response.data.data.PhotoProduct;
              this.prix=response.data.data.PrixProduct;
              this.id_category=response.data.data.id_category;
        })
        
    },
     name:'update',
     data(){
        return{
            name:'',
            file:'',
            prix:'',
            types:[],
            id_category:0,
            file_food:'',
            selectIndice:0
        }
     },
     props:{
        id:Number,
     },
     methods:{
        close(){
            this.$emit("retourn_consulte_from_update");
        },
        base64(){
            const filee = document.querySelector("#file").files[0];
            const reader = new FileReader();
            reader.onloadend = () => {
             this.file = reader.result;
           };
           reader.readAsDataURL(filee);
        },
       
        update(){
            service.UpdateProduct(this.id,{
                id:this.id_category,
                prix:this.prix,
                name:this.name,
                file:this.file
            }).then(()=>{
                 this.close();
            }).catch(()=>{
                 console.log("error");
            })
        }
     },
     computed:{
      
     }
 }

</script>