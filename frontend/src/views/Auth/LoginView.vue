<template>
    <div>
        <div class="sidebar_position">
            <SideBar></SideBar>
        </div>
        <div class="popup-below">
                <v-container fluid fill-height>
                    <v-layout align-center justify-center>
                       <v-flex xs12 sm8 md4>
                          <v-card class="elevation-12">
                             <v-toolbar dark color="#E84C03">
                                <v-toolbar-title >Welcome Back</v-toolbar-title>
                             </v-toolbar>
                             <v-card-text>
                             <form  @submit.prevent="login()">

                                    <v-text-field
                                      v-model="email"
                                      name="email"
                                      label="Email"
                                      type="text"
                                      placeholder="Enter Email"
                                      @click="validate('email')"
                                      @keyup="validate('email')"
                                    ></v-text-field>
                                    <small v-if="email_error!=''">
                                        {{ email_error }}
                                    </small>
                                   
                                    <v-text-field
                                      v-model="password"
                                      name="password"
                                      label="Password"
                                      type="password"
                                      placeholder="password"
                                      @click="validate('password')"
                                      @keyup="validate('password')"
                                   ></v-text-field>

                                   <small v-if="password_error!=''">
                                         {{ password_error }}
                                    </small>
                                    <div class="mt-3  ">
                                     
                                        <v-btn type="submit" class="mt-4 " style="color:#fff !important" color="#E84C03" value="log in">Login</v-btn>
                                        <router-link to="/" class="text-decoration-none  mx-2"> <v-btn type="button" class="mt-4 " color="gray" value="log in">Close</v-btn></router-link>
                                    </div>

                              </form>
                             </v-card-text>
                          </v-card>
                       </v-flex>
                    </v-layout>
                 </v-container>
                </div>
             <div>
        <div class="content" >
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
                      Login
                    </v-btn>
                  </router-link> 
                  <router-link to="/signup" class="text-decoration-none">
                    <v-btn class="signup" >
                       Sign Up
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
                            Taste Our <br>
                              Delicious Foods
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
                    <v-btn class="btn">See Menu</v-btn>
                  </v-container>
                 </v-content>
              </v-container>
            </div>
            </div>
            </div>
    </div>
</template>

<script>
import SideBar from "../../components/SideBar.vue"
    export default{
        name:"login",
        data(){
            return{
                password:'',
                password_error:'',
                email:'',
                email_error:''
            }
        },
        methods:{
            validate(input){
                if(input=='email'){
                    if(this.email==""){
                        this.email_error="Email required";
                    }else if( !String(this.email)
                             .toLowerCase()
                             .match(
                             /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)){
                        this.email_error = "Please enter a valid email";
                     }else{
                             this.email_error ="";
                             return true;
                     }
                }else if(input=='password'){
                    if(this.password==""){
                        this.password_error="password required";
                    }else {
                        this.password_error ="";
                        return true;
                    }
                }
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