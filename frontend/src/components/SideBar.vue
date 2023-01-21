<template>
      <nav  :class="etatsidbar==false ? 'close' : '' ">
        <ul v-if="!admin_dashboard">
          <li >
               <div href="#"  :class="etatsidbar==true ? 'close' : '' " class="logo">
                 <img src="../assets/logo.png" alt="">
               </div>
          </li>
          <li>
            <a  href="#home">
              <v-icon   class="icon">mdi-home</v-icon>
               <span  class="nav-item"> Home</span>
            </a>
          </li>
          <li>
            <a  href="#menu">
              <v-icon  class="icon">mdi-menu</v-icon>
              <span class="nav-item">Menu</span>
            </a>
          </li>
          <li>
            <a  href="#contact">
              <v-icon class="icon">mdi-message-bulleted</v-icon>
              <span class="nav-item">Contact</span>
            </a>
          </li>
          <li class="logout"  :class="etatsidbar==true ? 'close' : '' ">
                <v-btn  fab  @click="changer()">
                     <v-icon style="color:#E84C03" v-if="etatsidbar" class="px-1">mdi-arrow-right-bold</v-icon>
                     <v-icon   style="color:#E84C03" v-else class="px-1">mdi-arrow-left-bold</v-icon>
               </v-btn>
          </li>
        </ul>

        <ul v-else >
            <li class="mb-5">
                 <div href="#"  :class="etatsidbar==true ? 'close' : '' " class="logo">
                     <img src="../assets/logo.png" alt="">
                 </div>
            </li>
            <li class="mt-5">
              <a    @click="changerView('state')" href="#">
                <v-icon :color="ViewCurrent=='state' ? '#000' : ''" class="icon">mdi-view-dashboard</v-icon>
                 <span :style="ViewCurrent=='state' ? 'color:#000;font-size:20px;font-wieght:700' : ''"  class="nav-item">View</span>
              </a>
            </li>
            <li >
              <a @click="changerView('produit')" href="#">
                <v-icon :color="ViewCurrent=='produit' ? '#000' : ''" class="icon">mdi-food</v-icon>
                <span :style="ViewCurrent=='produit' ? 'color:#000;font-size:20px;font-wieght:700' : ''" class="nav-item">Produit</span>
              </a>
            </li>
            <li >
              <a @click="changerView('category')" href="#">
                <v-icon :color="ViewCurrent=='category' ? '#000' : ''" class="icon">mdi-view-grid-plus</v-icon>
                <span :style="ViewCurrent=='category' ? 'color:#000;font-size:20px;font-wieght:700' : ''" class="nav-item">Category</span>
              </a>
            </li>
            <li >
              <a @click="changerView('option')" href="#">
                <v-icon :color="ViewCurrent=='option' ? '#000' : ''" class="icon">mdi-view-grid-plus</v-icon>
                <span :style="ViewCurrent=='option' ? 'color:#000;font-size:20px;font-wieght:700' : ''" class="nav-item">Option</span>
              </a>
            </li>
            <li>
                <a  @click="changerView('client')"  href="#">
                  <v-icon :color="ViewCurrent=='client' ? '#000' : ''"  class="icon">mdi-account-group</v-icon>
                  <span :style="ViewCurrent=='client' ? 'color:#000;font-size:20px;font-wieght:700' : ''" class="nav-item">Client</span>
                </a>
              </li>
              <li>

                <a  @click="changerView('commande')" href="#">
                  <v-icon :color="ViewCurrent=='commande' ? '#000' : ''"  class="icon">mdi-truck-delivery</v-icon>
                  <span :style="ViewCurrent=='commande' ? 'color:#000 !important;font-size:20px;font-wieght:700' : ''" class="nav-item">Commande</span>
                </a>
              </li>
          
            <li class="logout"  :class="etatsidbar==true ? 'close' : '' ">
                  <v-btn  fab  @click="changer()">
                       <v-icon style="color:#E84C03" v-if="etatsidbar" class="px-1">mdi-arrow-right-bold</v-icon>
                       <v-icon   style="color:#E84C03" v-else class="px-1">mdi-arrow-left-bold</v-icon>
                 </v-btn>
            </li>
          </ul>
    </nav>

</template>

<script>
import { AuthStore } from '@/store/StoreAuth';
export default{
    name:"sidebar",
    setup(){
        const store=AuthStore();
        return {store}
    },
    data(){
        return{

        }
    },
    methods:{
      changerView(a){
        this.$emit("changerView",a)
      },
        changer(){
            this.etatsidbar=this.etatsidbar==true ? false : true;
            this.$emit("changreetat", this.etatsidbar);
        },
        logout(){
            this.store.logout();
        }
    },


    props:{
        etatsidbar:Boolean,
        admin_dashboard:Boolean,
        ViewCurrent:String
    }
    
}

</script>

<style scoped>


   nav{
        background: #E84C03;
        position: absolute;
        left: 0;
        top: 0;
        height: 100vh;
        z-index: 999999999;
        width: 90px;
        bottom: 0;
        overflow: hidden;
        transition: width 0.2s linear ;
        border-radius: 1px 50px 30px 1px;
        box-shadow: 0 20px 35px rgba(0,0,0,0.1);
        scroll-behavior: smooth;
    }

    .logo{
        text-align: center;
        display: flex;
        transition: all  0.5s ease;
        margin:20px 0 0 15px;
    }

    .logo img{
        width: 100px;
        height: 100px;
        margin-left: 25px;
        border-radius: 50%;
    }
    
    .logo span{
        font-weight: bold;
        padding: 15px;
        font-size: 18px;
        text-transform: uppercase;
    }

    a{
        position: relative;
        color: rbga(85,83,83);
        font-size: 14px;
        display: table;
        width: 300px;
        padding: 10px;
        text-decoration: none;
    }

    li{
        list-style-type: none;
    }
     .nav-item,.icon{
        color: #fff;
        font-size: 18px;
    }
    .icon{
        position: relative;
        width: 70px;
        height: 40px;
        top: 14px;
        font-size: 25px;
        text-align: center;
        margin-left: -20px;
    }

    .nav-item{
        position: relative;
        top: 19px;
        margin-left: 10px;
    }
   
    nav.close{
        width: 280px;
        transition:all 0.5s ease;
    }
    .logo.close img{
        width: 70px;
        height: 70px;
        margin-left:-32px;
        border-radius: 50%;
    }

    .logout{
        position: absolute;
        bottom: 0; 
        margin-left: 70px;
        margin-bottom: 20px;
    }
    .logout.close{
        position: absolute;
        bottom: 0; 
        margin-left: 0;
        margin-bottom: 20px;
    }

   
</style>