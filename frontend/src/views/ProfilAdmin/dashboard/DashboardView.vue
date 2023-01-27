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
 
    <v-menu offset-y>
     <template v-slot:activator="{ on, attrs }">
    <v-badge 
     class="mx-5 mt-4"  color="red"
     :content="All_notif_yet.length==0 ? '0' : All_notif_yet.length">
     <v-btn     v-bind="attrs"
      v-on="on">   ddd
    <v-icon   
  
       color="#000">
        mdi-bell
      </v-icon></v-btn>
   
    </v-badge>
  </template>
      <v-toolbar dark color="#E84C03">
       <v-toolbar-title >Welcome Back</v-toolbar-title>
      </v-toolbar>
      <v-list   style="overflow-y:scroll;max-height:300px">
        <v-list-item v-if="All_notif==''">
          <v-list-item-title class="mb-1" > No Datat available</v-list-item-title>
      </v-list-item>
        <v-list-item v-else
          v-for="(item) in All_notif"
          :key="item.id"
        >
          <v-list-item-title class="mb-1" :style=" item.etat==0 ? 'background-color:gray;padding:15px;border-radius:25px;cursor:pointer' : 'cursor:pointer;background-color:#fff;padding:15px;border-radius:25px'" @click="Seenotification(item.id)">{{ item.message }} <v-btn  text @click="deleteNotif(item.id)"> <v-icon color="red">mdi-delete</v-icon></v-btn></v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>
  <!--
<v-menu 
  bottom
  origin="center center"
  transition="scale-transition"
>
 
  <v-list   style="overflow-y:scroll;max-height:300px">
    <v-list-item v-if="All_notif==''">
      <v-list-item-title class="mb-1" > No Datat available</v-list-item-title>
  </v-list-item>
    <v-list-item v-else
      v-for="(item) in All_notif"
      :key="item.id"
    >
      <v-list-item-title class="mb-1" :style=" item.etat==0 ? 'background-color:gray;padding:15px;border-radius:25px;cursor:pointer' : 'cursor:pointer;background-color:#fff;padding:15px;border-radius:25px'" @click="Seenotification(item.id)">{{ item.message }} <v-btn  text @click="deleteNotif(item.id)"> <v-icon color="red">mdi-delete</v-icon></v-btn></v-list-item-title>
    </v-list-item>
  </v-list>
</v-menu> -->
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
      <v-snackbar
      v-model="snackbar"
  >
   Delete Notification Completed With Success
  <template v-slot:action="{ attrs }">
   <v-btn
     color="pink"
        text
        v-bind="attrs"
        @click="snackbar = false"
   >
     Close
    </v-btn>
   </template>
  </v-snackbar>
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
            this.getNotif();
            this.getNotifNotyet();
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
                All_notif:[],
                All_notif_yet:[]
            }
        },
        methods:{
             Seenotification(id){
              service_notif.changeretat(id).then((res)=>{
                  this.getNotif();
                  this.getNotifNotyet();
                  this.changerView('commande');
              })
            },
             getNotifNotyet(){
              service_notif.getNotification(this.store.user['id']).then((res)=>{
                 this.All_notif_yet=res.data;
              })
            },
             getNotif(){
              service_notif.getAllNotification(this.store.user['id']).then((res)=>{
                 this.All_notif=res.data;
              })
            },
            deleteNotif(id){
              service_notif.deleteNotification(id).then((res)=>{
                 this.getNotif();
                 this.getNotifNotyet();
                 this.snackbar=true;
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