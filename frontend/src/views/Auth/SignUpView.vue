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
                            <v-toolbar-title >
                               <div class="d-flex justify-content-center">
                                   <p>Sign Up</p>
                               </div>
                            </v-toolbar-title>
                         </v-toolbar>
                         <v-card-text>
                         <form>

                              <div class="row">
                                 <div class="col-md-6">
                                  <v-text-field
                                  name="Name"
                                  label="Name"
                                  type="text"
                                  placeholder="Enter Name"
                                ></v-text-field>

                                 </div>
                                 <div class="col-md-6">
                                  <v-text-field
                                  name="LastName"
                                  label="LastName"
                                  type="text"
                                  placeholder="Enter LastName"
                                ></v-text-field>

                                 </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12">
                                 <v-text-field
                                 name="Email"
                                 label="Email"
                                 type="text"
                                 placeholder="Enter Email"
                               ></v-text-field>
                                </div>
                             </div>
                             <div class="row">
                              <div class="col-md-12">
                                <v-text-field
                                  name="password"
                                  label="Password"
                                  type="password"
                                  placeholder="password"
                               ></v-text-field>
                              </div>
                           </div>

                           <div class="row">
                            <div class="col-md-6">
                              <v-file-input
                              label="File input"
                              filled
                              prepend-icon="mdi-camera"
                            ></v-file-input>

                            </div>
                            <div class="col-md-6">
                             <v-text-field
                             name="N° Phone"
                             label="N° Phone"
                             type="text"
                             placeholder="+216"
                           ></v-text-field>
                            </div>
                         </div>
                        <v-checkbox v-model="checkbox">
                          <template v-slot:label>
                            <div>
                                I agree to the 
                              <span style="color:blue"> Terms and Conditions </span>  
                                is awesome
                            </div>
                          </template>
                        </v-checkbox> 
                                <div class="mt-3 text-center ">
                                    <v-btn type="submit" class="mt-4 " style="color:#fff !important" color="#E84C03" value="Sign Up">Sign Up</v-btn>
                                    <router-link to="/" class="text-decoration-none  mx-2"> <v-btn type="button" class="mt-4 " color="gray" value="close">Close</v-btn></router-link>
                                </div>
                                <div class="text-center mt-3">
                                    Already have an account ?     <router-link to="login" class="text-decoration-none  mx-2">  <span>Login</span></router-link>
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
        name:"signup",
        data(){
          return{

          }
        },
        components:{
            SideBar
        }
    }
</script>


<style>
.popup-below {
    position: fixed; /* Stay in place */
    z-index: 999999999;
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}
.popup_form{
    position: fixed;
    top: 50%;
    left:50%;
    flex-direction: column;
    transform: translate(-50%,-50%)scale(0.9);
    background: #fff;
    width:70%;
    border-radius: 10px;
    height:60%;
    z-index: 999999999;
    display: flex;
    justify-content: center;
    align-items: center;
    padding:88px;
}
</style>