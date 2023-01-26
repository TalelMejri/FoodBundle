<template>
    <div>   
        <div class="sidebar_position">
            <SideBar @changerView="changerView" :ViewCurrent="ViewCurrent" :admin_dashboard="admin_dashboard" :etatsidbar="etatsidbar" @changreetat="changreetat"></SideBar>
        </div>
      <transition name="fade" mode="out-in">
        <div class="content" :class=" etatsidbar==true ? 'close ' : '' "> 
          <div class="ma-5 pa-5" id="home">
  <v-container>
    <v-row>
     <h2> <span style="color:#E84C03;">{{(ViewCurrent.toUpperCase().substring(0,ViewCurrent.length-3))}}</span>{{(ViewCurrent.toUpperCase().substring(ViewCurrent.length,ViewCurrent.length-3))}}</h2>
        <v-spacer></v-spacer>
    <div class="mx-5">
      <v-badge  class="mx-5 mt-4"  color="red"
          :content="All_notif.length==0 ? '0' : All_notif.length">
      <v-btn  @click="snackbar = true">
        dd
      </v-btn>
          <v-icon  @click="snackbar = true"  color="#000">mdi-bell</v-icon>
      </v-badge>
    </div>

  <v-snackbar
    dark
    v-model="snackbar_edit"
    scroll
  >
      edit With Success
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

  <v-snackbar
    v-model="snackbar"
    right
    scroll
  >
      <div v-if="All_notif==''"> 
        No Notification available
    </div>
      <div v-else  class="all_notif" v-for="notif in All_notif" :key="notif.id">
                 <v-btn @click="deleteNotif(notif.id)" text><v-icon>mdi-delete</v-icon></v-btn>
                {{ notif.message }}
      </div>
    <template v-slot:action="{ attrs }">
      <v-btn
        color="indigo"
        text
        v-bind="attrs"
        @click="snackbar = false"
      >
        Close
      </v-btn>
    </template>
  </v-snackbar>
      <v-menu>
        <template v-slot:activator="{ on }">
          <v-btn
            icon
            x-large
            v-on="on"
          >
            <v-avatar
              size="48"
            >
            <img :src="'http://127.0.0.1:8000'+store.user['Photo']" alt="">
            </v-avatar>
          </v-btn>
        </template>
        <v-card>
          <v-list-item-content class="justify-center">
            <div class="mx-auto text-center">
              <v-avatar>
                 <img :src="'http://127.0.0.1:8000'+store.user['Photo']" alt="">
              </v-avatar>
              <h3>{{store.user['name']}}</h3>
              <p class="text-caption mt-1">
                {{store.user['lastname']}}
              </p>
              <v-divider class="my-3"></v-divider>
              <v-btn
                depressed
                rounded
                text
                @click="ViewCurrent='edit'"
              >
                Edit Account
              </v-btn>
              <v-divider class="my-3"></v-divider>
              <v-btn @click="logout()"
                depressed
                rounded
                text
              >
                Logout
              </v-btn>
            </div>
          </v-list-item-content>
        </v-card>
      </v-menu>
    
    </v-row>
                  <div v-if="ViewCurrent=='state'">
                    <SatistiqueView></SatistiqueView>
                  </div>
                  <div v-else-if="ViewCurrent=='edit'">
                    <EditAcountVue @returnstate="returnstate" :direction="'not'"></EditAcountVue>
                  </div>
                  <div  v-else-if="ViewCurrent=='client'">
                    <clientView></clientView>
                  </div>
                  <div  v-else-if="ViewCurrent=='produit'">
                    <ConsulteProduitView></ConsulteProduitView>
                  </div>
                  <div  v-else-if="ViewCurrent=='category'">
                    <CategoryView></CategoryView>
                  </div>
                  <div  v-else-if="ViewCurrent=='option'">
                    <ConsulteOptionView></ConsulteOptionView>
                  </div>
                  <div  v-else-if="ViewCurrent=='commande'">
                    <CommandeView></CommandeView>
                  </div>
            </v-container>
            </div>
       </div>
      </transition>  
    </div>
</template>
<script>

 /** 
  *  test better comment
  *  !sqdsqsqdq
  *  ? dsdsdsd
  *  TODO:dsdsdsd
 */
    import service_notif from "@/services/Notification/notif.js"
    import ConsulteOptionView from "@/views/ProfilAdmin/Option/ConsulteOptionView.vue";
    import SatistiqueView from "@/views/ProfilAdmin/dashboard/SatistiqueView.vue"
    import SideBar from "@/components/SideBar.vue"
    import EditAcountVue from "@/components/ProfilAdmin/EditAcount.vue";
    import CategoryView from "@/views/ProfilAdmin/Category/ConsulteCategoryView.vue"
    import clientView from "@/views/ProfilAdmin/Client/ConsulteClientView.vue"
    import CommandeView from "@/views/ProfilAdmin/Commande/CommandeView.vue";
    import ConsulteProduitView from "@/views/ProfilAdmin/Product/ConsulteProduitView.vue";
    import { AuthStore } from '@/store/StoreAuth';

    export default{
        name:'dashboard',
        created(){
            this.getnotif();
        },
        setup() {
             const store = AuthStore();
             return {
                 store,
             };
        },
        data(){
            return{
                etatsidbar:false,
                admin_dashboard:true,
                snackbar:false,
                ViewCurrent:'state',
                snackbar_edit:false,
                All_notif:[]
            }
        },
        methods:{
            getnotif(){
              service_notif.getNotification(this.store.user['id']).then((res)=>{
                 this.All_notif=res.data;
              })
            },
            deleteNotif(id){
              service_notif.deleteNotification(id).then((res)=>{
                 this.getnotif();
              })
            },
            changreetat(a){
                this.etatsidbar=a;
            },
            changerView(a){
                this.ViewCurrent=a;
            },
            returnstate(){
              this.ViewCurrent='state';
              this.snackbar_edit=true;
            },
            logout(){
                this.store.logout();
                this.$router.push('/login');
            }
        },
        components:{
            SideBar,ConsulteOptionView,SatistiqueView,clientView,EditAcountVue,CommandeView,ConsulteProduitView,CategoryView
        }
    }
</script>

<style scoped>

.all_notif{
  scroll-behavior: smooth;
  max-height:400px;
  overflow-y: scroll;
}
.fade-enter,.fade-leave-to{
  opacity: 0; 
  transform: translateX(2em);
}
.fade-enter-active,.fade-leave-active{
  transition: all .3s ease;
}
</style>