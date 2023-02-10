<template>
    <div>
        <div style="z-index:25; !important" class="sidebar_position">
            <SideBar :etatsidbar="true"></SideBar>
        </div>
        <div class="popup-below">
                <v-container fluid fill-height>
                    <v-layout align-center justify-center>
                       <v-flex xs12 sm8 md4>
                          <v-card class="elevation-12">
                             <v-toolbar dark color="#E84C03">
                                <v-toolbar-title >Changer Mot de passe</v-toolbar-title>
                             </v-toolbar>
                             <v-card-text>
                             <form  @submit.prevent="changer_password()">
                                    <v-text-field
                                      v-model="email.value"
                                      name="email"
                                      label="Email"
                                      type="text"
                                      placeholder="Enter Email"
                                    ></v-text-field>
                                    <small color="red" v-if="email.error!=''">
                                        {{ email.error }}
                                   </small>
                                    <v-text-field
                                    v-model="password.value"
                                    name="password"
                                    label="Password"
                                    type="password"
                                    placeholder="Enter Password"
                                  ></v-text-field>
                                  <small color="red" v-if="password.error!=''">
                                    {{ password.error }}
                                  </small>
                                  <v-text-field
                                        name="Confirme"
                                        label="Confirme Password"
                                        type="password"
                                        v-model="v$.confirme.$model"
                                        placeholder="Enter Confirme Password"
                                  ></v-text-field>
                                  <div class="input-errors" v-for="(error, index) of v$.confirme.$errors" :key="index">
                                    <div class="error">{{ error.$message }}</div>
                                </div>
                                  <div class="ma-auto" style="max-width: 260px">
                                    <p>Code </p>
                                    <v-otp-input
                                      v-model="code.value"
                                        type="number"
                                        length="6"
                                        color="#E84C03"
                                    ></v-otp-input>
                                    <small color="red" v-if="code.error!=''">
                                        {{ code.error }}
                                      </small>
                                  </div>
                                    <div class="mt-3 text-center">
                                           <v-btn   :disabled="v$.confirme.$invalid" :loading="load" type="submit" class="mt-4 mx-2" style="color:#fff !important" color="#E84C03" >
                                              Changer
                                            </v-btn>
                                        <v-btn @click="refresh()" type="button" class="mt-4 " color="gray" value="log in">Fermer</v-btn>
                                    </div>
                              </form>
                             </v-card-text>
                          </v-card>
                       </v-flex>
                    </v-layout>
                 </v-container>
            <v-snackbar
                 v-model="snackbar"
               >
                 {{ message_success }}
           
                 <template v-slot:action="{ attrs }">
                   <v-btn
                     color="green"
                     text
                     v-bind="attrs"
                     @click="snackbar = false"
                   >
                     Close
                   </v-btn>
                 </template>
               </v-snackbar>
                </div>
             <div>
        <div style="z-index:2; !important" class="content" >
            <div class="ma-5 pa-5" id="home">
              <v-container >
                <v-row>
                  <v-col
                    cols="auto"
                    class="mr-auto"
                  >
                   <h2> <span style="color:#E84C03;">Food</span>Bundle</h2>
                  </v-col>
                  <v-col cols="auto">
                    <v-row
                    align="center"
                    justify="space-around"
                    gap="4px"
                  >  <router-link  to="login" class="text-decoration-none">
                    <v-btn class="login mx-2"   >
                      Connexion
                    </v-btn>
                  </router-link> 
                  <router-link to="/signup" class="text-decoration-none">
                    <v-btn class="signup" >
                       S'incrire
                    </v-btn>
                  </router-link> 
                  </v-row>
                  </v-col>
                </v-row>
                 <v-content class="home my-5 py-5 d-flex justify-content-center"  >
                  <v-container class="mt-5 py-5" >
                    <div class="row mb-6 mt-5 gap-5"
                    >
                      <div class="mt-5 py-5 col-lg-6">
                           <p class="py-5 mt-5 paragh" >
                            Goûtez notre<br>
                              Nourriture délicieuse
                           </p>
                           <p  >
                            lore"Lorem ipsum dolor sit amet, consectetur adipiscing 
                            elit, sed do eiusmod tempor incididunt ut labore et dolor
                             magna aliqua. 
                           </p>
                          </div>
                      <div
                        class="col-lg-6 d-lg-block d-none text-center"
                      >
                          <img class="image" src="../../../assets/home-img.png" alt="">
                        </div>
                    </div>
                    <v-btn class="btn">Voir Menu</v-btn>
                  </v-container>
                 </v-content>
              </v-container>
            </div>
            </div>
            </div>
    </div>
</template>

<script>
import useVuelidate from '@vuelidate/core'
import { required, sameAs, minLength } from '@vuelidate/validators'
import service_reset_password from "@/services/ResetPassword/reset_password.js"
import SideBar from "@/components/SideBar.vue"
    export default{
        name:"changer_password",
        setup(){
        return{
           v$: useVuelidate() 
        }
    },
        validations() {
         return {
            confirme :{
                required,
                sameAs: sameAs(this.password.value),
             }  
        }
    },
        data(){
            return{
             email:{
                value:'',
                error:''
             },
             password:{
                value:'',
                error:''
             },
             code:{
                value:'',
                error:''
             },
             confirme:'',
             message_success:'',
             snackbar:false,
             load:false
            }
        },
        created(){
                
        },
        methods:{
            changer_password(){
                this.load=true;
                service_reset_password.ChangerPassword({email:this.email.value,password:this.password.value,password_token:this.code.value}).then((res)=>{
                   this.message_success=res.data.message;
                   this.code.error='';
                   this.password.error='';
                   this.email.error='';
                   this.snackbar=true;
                   this.load=false;
                }).catch((error)=>{
                    this.load=false;
                    this.code.error=error.response.data.errors.password_token ? error.response.data.errors.password_token[0] : '';
                    this.password.error=error.response.data.errors.password ? error.response.data.errors.password[0] : '';
                    this.email.error=error.response.data.errors.email ? error.response.data.errors.email[0] : '';
                })
            },
            refresh(){
              this.$router.push('/');
              this.$router.go();
          },
        },
        components:{
            SideBar
        }
    }
</script>

<style scoped>
small{
    color: red !important;
    font-size: 15px;
  }
.popup-below {
    position: fixed; /* Stay in place */
    z-index: 999999999;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}
.popup_form{
    position: fixed;
    flex-direction: column;
    background: #fff;
    width:35% ; 
    border-radius: 10px;
    height:60%;
    z-index: 999999999;
    display: flex;
    justify-content: center;
    align-items: center;
}


</style>