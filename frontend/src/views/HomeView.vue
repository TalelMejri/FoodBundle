<template> 
      <div class="all"> 
        <preloader></preloader>   
       <div class="sidebar_position">    
            <SideBar :etatsidbar="etatsidbar" @changreetat="changreetat"></SideBar>
        </div>
        <div  class="content"  :class=" etatsidbar==true ? 'close ' : '' "> 
          <div class="ma-5 pa-5" id="home">
            <v-container>
              <v-row>
                <v-col
                  cols="auto"
                  class="mr-auto"
                >
                 <h2><span style="color:#E84C03;">Food</span>Bundle</h2>
                </v-col>
                <v-col v-if="store.isauth==null" cols="auto">
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
                <v-col v-else cols="auto">
                  <!-- Client Better -->
                    <InfoClient :nbr_panier="nbr_panier"></InfoClient>
                </v-col>
              </v-row>
               <v-content class="home my-5 py-5 d-flex justify-content-center"  >
                <v-container class="mt-5 py-5" >
                  <div class="row mb-6 mt-5 gap-5"
                  >
                    <div class="mt-5 py-5 col-lg-6">
                         <p class="py-5 mt-5 paragh" >
                          Taste Our <br>
                            Delicious Food
                         </p>
                         <p  >
                           Lorem ipsum dolor sit amet, consectetur adipiscing 
                          elit, sed do eiusmod tempor incididunt ut labore et dolor
                           magna aliqua. 
                         </p>
                        </div>
                    <div
                      class="col-lg-6 d-lg-block d-none text-center"
                    >
                        <img class="image" src="../assets/home-img.png" alt="">
                      </div>
                  </div>
                  <v-btn class="btn">See Menu</v-btn>
                </v-container>
               </v-content>
            </v-container>
          </div>

          <div class="ma-5 pa-5 " >
            <v-container class="img_healthy">
                <img  src="../assets/healthy_food.png" alt="">
            </v-container>
          </div>

          <div class="ma-5 pa-5" id="menu">
            <v-container >
                <h2 class="text-center mb-5">Our Menu</h2>
               <div class="row">
                <v-hover v-for="menu in All_Menu" :key="menu.id"  v-slot="{ hover }">
                <div class="col-lg-4">
                  <v-card
                    class="mx-auto"
                    color="grey lighten-4"
                    max-width="300"
                  >
                    <v-img
                      :aspect-ratio="16/9"
                      :src="menu.PhtotoCatg"
                    >
                      <v-expand-transition>
                        <div
                          v-if="hover"
                          class=" white justify-content-center"
                          style="height: 100%;"
                        >
                           <div class="text-center py-5">
                              <div class="mb-2 mt-5"><h2>{{(menu.name).toUpperCase()}}</h2></div>
                              <div>
                              <router-link style="text-decoration:none !important" :to="'/ConsulteMenuView/'+menu.id">
                                <v-btn class="mb-2" color="error">
                                   Check
                                </v-btn>
                              </router-link>
                            </div>
                           </div>
                        </div>
                      </v-expand-transition>
                    </v-img>
                  </v-card>
                  </div>
                </v-hover>
              </div>
            </v-container>
          </div>
          <div class="ma-5 pa-5" id="contact">
            <v-container>
              <v-card
                elevation="19"
                shaped
                >
                  <div class="p-2 m-5">
                      <div class="row">
                         <div class="col-lg-6 text-center premier_partie_contact">
                              <div class="py-5">
                                  <p style="font-size:18px" class="white--text font-weight-black ">Let's Stay in Touch</p>
                                  <v-text-field
                                     label="Entre Email"
                                     v-model="email"
                                     @keyup="validate('email')"
                                     @click="validate('email')"
                                     solo
                                     append-icon= "mdi-send"
                                    ></v-text-field>
                                    <small v-if="email_error!=''">
                                        {{ email_error }}
                                    </small>
                               <v-snackbar
                                  v-model="snackbar"
                                >
                                 {{ text }}
                                  <template v-slot:action="{ attrs }">
                                   <v-btn
                                      color="#E84C03"
                                      text
                                      v-bind="attrs"
                                      @click="snackbar = false"
                                    >
                                      Confirm
                                   </v-btn>
                                  </template>
                                </v-snackbar>
                              </div>
                         </div>
                         <div class="col-lg-6 d-lg-block d-none text-center">
                              <img src="../assets/loader.gif" alt="">
                         </div>
                      </div>
                  </div>
              </v-card>
              <v-snackbar
              v-model="snackbar_edit"
                scroll>
                  {{message}}
              <template v-slot:action="{ attrs }">
                <v-btn
                  color="indigo"
                  text
                  v-bind="attrs"
                  @click="snackbar_edit = false"
                >
                  Close
                </v-btn>
              </template>
            </v-snackbar>
            </v-container>
          </div>
          <ServiceVue></ServiceVue>
          <footerVue></footerVue>
        </div>
     </div>
</template>
<script>
  import { ProductStore } from "@/store/StoreProducts";
  import {AuthStore} from "../store/StoreAuth"
  import footerVue from "../components/home_page/FooterVue.vue"
  import ServiceVue from "../components/home_page/ServiceVue.vue"
  import SideBar from "../components/SideBar.vue"
  import preloader from "@/components/preloader.vue"
  import service_category from "@/services/GererCategory/category"
  import InfoClient from "@/components/Client/InfoClient.vue"
  export default {
    name: 'Home', 
    setup() {
    const store = AuthStore();
    const Store_Product = ProductStore();
    return {
      store,Store_Product
    };
  },
    created(){
      if(typeof(this.$route.query.content)!='undefined'){
             this.message = this.$route.query.content;
             this.snackbar_edit=true;
      };
      service_category.getAllCategorie().then((res)=>{
         this.All_Menu=res.data[0];
      })
      this.nbr_panier=this.Store_Product.Products==null ? 0 : this.Store_Product.Products.length;
    },
    data(){
        return{
          snackbar_edit:false,
          model:[],
          nbr_panier:0,
          All_Menu:[],
                items:[
                   {id:0,name:'all Ordered Product',icon:'home',link:'allOrderedProduct'},
                   {id:1,name:'all Favorite Product',icon:'favorite',link:'AllFavoriteProduct'},
                   {id:2,name:'Logout',icon:'logout'}
                ],
          etatsidbar:false,
          message:'',
          email:'',
          email_error:'',
          snackbar: false,
          snackbar_notif:false,
          text: `Thank you for sending us  your mail one of our agents
                          will get back to you soon`,
          /*All_Menu:[
            {id:1,name:'Dessert',src_back:require('../assets/Menu/dessert.jpg'),src_hover:require('../assets/Menu/dessertt.png')},
            {id:2,name:'Drinks',src_back:require('../assets/Menu/drinks.jpg'),src_hover:require('../assets/Menu/d.png')},
            {id:3,name:'Pasta',src_back:require('../assets/Menu/pasta.jpg'),src_hover:require('../assets/Menu/pastaa.png')},
            {id:4,name:'Pizza',src_back:require('../assets/Menu/pizza.jpg'),src_hover:require('../assets/Menu/p.png')},
            {id:5,name:'Sandwish',src_back:require('../assets/Menu/sandwish.jpg'),src_hover:require('../assets/Menu/s-1.png')}
          ]*/
        }
    },
    components:{
        SideBar,footerVue,ServiceVue,preloader,InfoClient
    },
 
    methods:{
      logout(){
          this.store.logout();
          this.$router.push('/login');

      },
      changreetat(a){
        this.etatsidbar=a;
      },
      validate(input){
        if(input=="email"){
           if(this.email==""){
             this.email_error="email required"
           }else if( !String(this.email)
            .toLowerCase()
            .match(
              /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)){
                  this.email_error = "Please enter a valid email";
              }else{
              this.email_error = "";
              this.snackbar=true;
              this.email="";
              return true;
        }
        }
      }
    }
  }
</script>

<style>

.login{
  color: #fff !important;
  background: #E84C03 !important;
}

.login:hover{
  color: #E84C03 !important;
  background: #fff !important;
}

.signup{
  color: #E84C03;
  background: #fff;
}

.signup:hover{
  color: #fff;
  background: #E84C03 !important;
}

small{
  color: red;
  font-size: 18px;
}
.move_input {
  animation: animate 0.5s;
}
@keyframes animate {
  0% {
    transform: translateX(10px);
  }
  50% {
    transform: translateX(-10px);
  }
  100% {
    transform: translateX(0);
  }
}

.premier_partie_contact{
  background: #E84C03;
  border-radius: 1px 500px 100px 1px;
}

/*
.v-card--reveal {
  align-items: center;
  bottom: 0;
  justify-content: center;
  opacity: .5;
  position: absolute;
  width: 100%;
}
*/

.sidebar_position{
  position: fixed;
  z-index: 999999;
}

.btn{
  color: #fff !important;
  background: #E84C03 !important; 
}

.btn:hover{
  color: #E84C03 !important;
  background: #fff !important; 
}

.content.close{
  width: calc(100%-90px) !important;
  margin-left: 90px;
  transition: all 0.2s ease-in-out;
  scroll-behavior: smooth;
}

.content {
  width: calc(100%-280px) !important;
  margin-left: 280px;
  position: relative;
  scroll-behavior: smooth;
  transition: all 0.2s ease-in-out;
}

.image{
  width: 500px;
  height: 400px;
  position: relative;
  transition: all 0.2 ease-in-out;
  animation: animate 8s infinite;
}

.img_healthy img{
    width: 100%;
    height: 100%;
    border-radius: 10px 40px 40px 10px;
}

@keyframes animate {
    0%{
      transform: translateY(-20px);
    }
    100%{
      transform: translateY(20px);
    }  
}

.paragh{
  color: #000;
  font-family: 'Times New Roman', Times, serif;
  font-size: 60px;
}

@media screen and (max-width:750px) {
  .content{
      position:relative;
      transition: all 0.2s ease-in-out;
      z-index: 1 !important;
      scroll-behavior: smooth;
      margin-left: 69px;  
  }
}

@media screen and (max-width:624px) {
  .paragh{
    color: #000;
    font-family: 'Times New Roman', Times, serif;
    font-size: 25px !important;
  }

  h2{
    font-size: 18px;
  }
}

</style>
