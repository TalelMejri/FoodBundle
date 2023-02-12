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
                                <v-toolbar-title >Content de te revoir</v-toolbar-title>
                             </v-toolbar>
                             <v-card-text>
                             <form  @submit.prevent="login()">
                              <v-snackbar
                              color="red"
                              v-model="snackbar_error"
                            >
                              {{ message_error }}
                              <template v-slot:action="{ attrs }">
                                <v-btn
                                  color="#fff"
                                  text
                                  v-bind="attrs"
                                  @click="snackbar_error = false"
                                >
                                  Fermer
                                </v-btn>
                              </template>
                            </v-snackbar>
                                    <v-text-field
                                      v-model="email"
                                      name="email"
                                      label="Email"
                                      :error-messages="email_error"
                                      type="text"
                                      placeholder="Enter Email"
                                    ></v-text-field>
                                    <v-text-field
                                      v-model="password"
                                      name="password"
                                      label="Password"
                                      type="password"
                                      :error-messages="password_error"
                                      placeholder="password"
                                   ></v-text-field>
                                    <div class="mt-3 text-center">
                                        <v-btn type="submit" class="mt-4 mx-2" style="color:#fff !important" color="#E84C03" value="log in" :loading="load">Connexion</v-btn>
                                        <v-btn @click="refresh()" type="button" class="mt-4 " color="gray" value="log in">Fermer</v-btn>
                                        <div class="text-center mt-3">
                                          Vous êtes nouveau ici ?<router-link to="signup" class="text-decoration-none  mx-2">  <span>S'incrire</span></router-link>
                                        </div>
                                        <div class="text-center mt-3">
                                          <router-link to="forgot_password" class="text-decoration-none  mx-2">Mot de passe oublié ?</router-link>
                                        </div>
                                    </div>
                              </form>
                              <v-snackbar
                              color="green"
                              v-model="snackbar"
                            >
                              {{ message }}
                              <template v-slot:action="{ attrs }">
                                <v-btn
                                  color="#E84C03"
                                  text
                                  v-bind="attrs"
                                  @click="snackbar = false"
                                >
                                  Fermer
                                </v-btn>
                              </template>
                            </v-snackbar>
                             </v-card-text>
                          </v-card>
                       </v-flex>
                    </v-layout>
                 </v-container>
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
                          <img class="image" src="../../assets/home-img.png" alt="">
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
import authService from "../../services/auth"
import SideBar from "../../components/SideBar.vue"
import {AuthStore} from "../../store/StoreAuth"
import useVuelidate from '@vuelidate/core'
import { required, email } from '@vuelidate/validators'
    export default{
        name:"login",
        setup(){
            return{
               v$: useVuelidate() 
            }
        },
        validations(){
          return{
            email:{
              required,
              email,

            },
            password:{
              required
            }
          }
        },
        data(){
            return{
                password:'',
                email:'',
                message:'',
                snackbar: false,
                snackbar_error:false,
                message_error:'',
                load:false
            }
        },
        created(){
          if(typeof(this.$route.query.content)!='undefined'){
             this.message = this.$route.query.content;
             this.snackbar=true;
          }
        },
        methods:{
           login(){
             this.v$.$touch();
             if (this.v$.$invalid) {
                this.load = false;
                return;
              }
                // if(this.validate('email') && this.validate('password')){
                  this.load=true;
                    authService.LoginUser(this.email,this.password).then(()=>{
                      this.load=false;
                        const auth=AuthStore();
                        if(auth.getisadmin==1){
                            this.$router.push('dashboard');
                        }else{
                            this.$router.push('/'); 
                        }
                    }).catch((error)=>{
                          this.snackbar_error=true;
                          this.message_error="Utilisateur non trouvé";
                          this.load=false;
                    })
                // }
          },
          refresh(){
              this.$router.push('/');
              this.$router.go();
          },
            // validate(input){
            //     if(input=='email'){
            //         if(this.email==""){
            //             this.email_error="Email Obligatoire";
            //         }else if( !String(this.email)
            //                  .toLowerCase()
            //                  .match(
            //                  /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)){
            //             this.email_error = "Veuillez tapez un email valid";
            //          }else{
            //                  this.email_error ="";
            //                  return true;
            //          }
            //     }else if(input=='password'){
            //         if(this.password==""){
            //             this.password_error="password Obligatoire";
            //         }else {
            //             this.password_error ="";
            //             return true;
            //         }
            //     }
            // }
        },
        computed:{
          email_error(){
            const errors=[];
             if (!this.v$.email.$dirty) return errors;
               !this.v$.email.required && errors.push("الرجاء ادخال اسم");
               !this.v$.email.minLength &&
                errors.push("الرجاء ادخال اسم بحد اقل 5 حروف");
                return errors;
          },
          password_error(){
            return "rrrror";
          }
        },
        components:{
            SideBar
        }
    }
</script>


<style scoped>

small{
    color: #000;
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