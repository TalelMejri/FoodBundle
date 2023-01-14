<template>
    <div>
        <div class="sidebar_position">
            <SideBar ></SideBar>
        </div>
        <div class="popup-below">
            <div class="popup_form">
                     
            </div>
        </div>
        <div>
       
        <div class="content "  >
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