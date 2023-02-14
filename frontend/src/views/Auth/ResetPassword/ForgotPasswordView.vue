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
                                <v-toolbar-title >Mot de passe oublié</v-toolbar-title>
                             </v-toolbar>
                             <v-card-text>
                             <form  @submit.prevent="CheckEmail()">
                                    <v-text-field
                                      v-model="email"
                                      :error-messages="email_error"
                                      name="email"
                                      label="Email"
                                      type="text"
                                      placeholder="Enter Email"
                                    ></v-text-field>
                                    <!-- <small color="red" v-if="email.error!=''">
                                         {{ email.error }}
                                    </small> -->
                                    <div class="mt-3 text-center">
                                           <v-btn :loading="load" type="submit" class="mt-4 mx-2" style="color:#fff !important" color="#E84C03" value="log in">
                                              Confirmer
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
                     color="pink"
                     text
                     v-bind="attrs"
                     @click="snackbar = false"
                   >
                     fermer
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
import service_reset_password from "@/services/ResetPassword/reset_password.js"
import axios from "axios";
import SideBar from "@/components/SideBar.vue"
import { required, email } from 'vuelidate/lib/validators'
    export default{
        name:"forgot_password",
         validations:{
             email:{
               required,
               email,
               async exists(value) {
                if (value === "") {
                  return true;
                }
                  const response=await axios.get('auth/exist/'+value);
                  return response.status == 201 || value == "";
              },
         
          }
        },
      
        data(){
            return{
             email:'',
             message_success:'',
             snackbar:false,
             load:false
            }
        },
        methods:{
            CheckEmail(){
              this.load=true;
              this.$v.$touch();
             if (this.$v.$invalid) {
                this.load = false;
                return;
              }
                service_reset_password.ForgotPassword({email:this.email}).then((res)=>{
                   this.message_success=res.data.message;
                   this.snackbar=true;
                   this.load=false;
                  // this.email.error='';
                }).catch((error)=>{
                    this.load=false;
                    //this.email.error=error.response.data.errors.email ? error.response.data.errors.email[0] : '';
                })
            },
            refresh(){
              this.$router.push('/');
              this.$router.go();
          },
        },
        computed:{
            email_error(){
               const errors=[];
               if(!this.$v.email.$dirty) return errors;
               !this.$v.email.required && errors.push('email obligatoire');
               !this.$v.email.email && errors.push('email invalid');
               !this.$v.email.exists && errors.push('email n\'est pas exite');
               return errors; 
            }
        },
        components:{
            SideBar
        },

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