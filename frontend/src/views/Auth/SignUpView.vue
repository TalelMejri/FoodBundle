<template>
  <div>
    <div style="z-index:25; !important" class="sidebar_position">
        <SideBar :etatsidbar="true"></SideBar>
    </div>
    <div class="popup-below">
            <v-container fluid fill-height>
                <v-layout class="mt-5 py-5" align-center justify-center>
                   <v-flex  sm8 md4>
                      <v-card class="elevation-12">
                         <v-toolbar dark color="#E84C03">
                            <v-toolbar-title >
                               <div class="d-flex justify-content-center mt-5">
                                   <p>S'incrire</p>
                               </div>
                            </v-toolbar-title>
                         </v-toolbar>
                         <v-card-text>
                         <form  @submit.prevent="Rgister()" enctype="multipart/form-data">

                              <div class="row">
                                 <div class="col-md-6">
                                  <v-text-field
                                  :color="name.error!='' ? 'red': ''"
                                  name="Name"
                                  label="Name"
                                  :messages="name.error!='' ? name.error : ''"
                                  :class="name.error!='' ? 'move_input' : ''"
                                  v-model="name.value"
                                  type="text"
                                  
                                  placeholder="Tapez Nom"
                                ></v-text-field>
                             
                                 </div>
                                 <div class="col-md-6">
                                  <v-text-field
                                  :color="lastname.error!='' ? 'red': ''"
                                  name="LastName"
                                  :messages="lastname.error!='' ? lastname.error : ''"
                                  :class="lastname.error!='' ? 'move_input' : ''"
                                  label="LastName"
                                  v-model="lastname.value"
                                  type="text"
                                  placeholder="Tapez Prenom"
                                ></v-text-field>

                                 </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12">
                                 <v-text-field
                                 :messages="email.error!='' ? email.error : ''"
                                 :class="email.error!='' ? 'move_input' : ''"
                                 :color="email.error!='' ? 'red': ''"
                                 name="Email"
                                 label="Email"
                                 type="text"
                                 v-model="email.value"
                                 placeholder="Enter Email"
                               ></v-text-field>
                                </div>
                             </div>
                             <div class="row">
                              <div class="col-md-12">
                                <v-text-field
                                :messages="password.error!='' ? password.error : ''"
                                 :class="password.error!='' ? 'move_input' : ''"
                                :color="password.error!='' ? 'red': ''"
                                  name="password"
                                  label="Password"
                                  type="password"
                                  v-model="password.value"
                                  placeholder="Mot de passe"
                               ></v-text-field>
                              </div>
                           </div>
                           <div class="row">
                            <div class="col-md-12">
                              <input    
                                                :class="photo.error!='' ? 'move_input ': ''"
                                                class="form-control"
                                                 type="file" ref="photo"
                                                 @change="uploadFile">
                                                 <small v-if="photo.error!=''">
                                                  {{ photo.error }}
                                              </small>
                            </div>
                            
                            <div class="col-md-12">
                             <v-text-field
                             name="N° Phone"
                             :messages="numero_tlf.error!='' ? numero_tlf.error : ''"
                             :class="numero_tlf.error!='' ? 'move_input' : ''"
                             :color="numero_tlf.error!='' ? 'red': ''" 
                             label="N° Télephone"
                             v-model="numero_tlf.value"
                             type="text"
                             placeholder="+216"
                           ></v-text-field>
                            </div>
                         </div>
                        <v-checkbox v-model="check.value" >
                          <template v-slot:label>
                            <div>
                           je suis d'accord avec le
                              <span style="color:blue"> Termes et conditions </span>  
                                est génial
                            </div>
                            <div>
                             
                            </div>
                          </template>
                      
                        </v-checkbox> 
                        <div>
                          <small  v-if="check.error!=''">
                            {{ check.error }}
                        </small>
                        </div>
                                <div class="mt-3 text-center ">
                                    <v-btn :loading="load" type="submit" class="mt-4 " style="color:#fff !important" color="#E84C03" value="Sign Up">S'incrire</v-btn>
                                    <router-link to="/" class="text-decoration-none  mx-2"> <v-btn type="button" class="mt-4 " color="gray" value="close">Fermer</v-btn></router-link>
                                </div>
                                <div class="text-center mt-3">
                                  Vous avez déjà un compte ?<router-link to="login" class="text-decoration-none  mx-2">  <span>Connexion</span></router-link>
                                </div>
                          </form>
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
import service from "../../services/auth";
import SideBar from "../../components/SideBar.vue"
    export default{
        name:"signup",
        data(){
          return{
            checkbox: false,
            load:false,
              name:{
                 value:'',
                 error:''
              },
              check:{
                 value:0,
                 error:''
             },
              email:{
                 value:'',
                 error:''
              },
              password:{
                 value:'',
                 error:''
              },
              lastname:{
                 value:'',
                 error:''
              },
              numero_tlf:{
                 value:'',
                 error:''
              },
              photo:{
                 value:'',
                 error:''
              },
          }
        },
        components:{
            SideBar
        },
        methods:{
          uploadFile(){
            //this.photo.value =e.target.files[0];
            this.photo.value =this.$refs.photo.files[0];
          },
          Rgister(){
            this.load=true;
            service.CreateUser({
               name:this.name.value,
               photo:this.photo.value,
               email:this.email.value,
               password:this.password.value,
               lastname:this.lastname.value,
               numero_tlf:this.numero_tlf.value
            }).then((response)=>{
              this.name.value="";
              this.photo.value="";
              this.email.value="";
              this.password.value="";
              this.lastname.value="";
              this.numero_tlf.value="";
              this.check.value="";
              this.load=false;
              this.$router.push({name:"login", query: {content: 'Inscrivez-vous avec succès'}});
            }).catch((error)=>{
              this.name.error=error.response.data.errors.name ? error.response.data.errors.name[0] : '';
              this.photo.error=error.response.data.errors.Photo ? error.response.data.errors.Photo[0] : '';
              this.email.error=error.response.data.errors.email ? error.response.data.errors.email[0] : '';
              this.password.error=error.response.data.errors.password ? error.response.data.errors.password[0] : '';
              this.lastname.error=error.response.data.errors.lastname ? error.response.data.errors.lastname[0] : '';
              this.numero_tlf.error=error.response.data.errors.numero_tlf ? error.response.data.errors.numero_tlf[0] : '';
              this.check.error=this.check.value==false ? 'check Agree obligatoire' : '' ;
              this.load=false;
            })
          }
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

small{
  color:gray !important;
  font-size: 13px !important;
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
</style>