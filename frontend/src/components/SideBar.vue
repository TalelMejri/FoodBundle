<template>
      <nav class="fixed" :class="etatsidbar==false ? 'close' : '' ">
        <ul>
          <li>
               <a href="#"  :class="etatsidbar==true ? 'close' : '' " class="logo">
                 <img src="../assets/logo.png" alt="">
               </a>
          </li>
          <li>
            <a href="">
              <v-icon  class="icon">mdi-home</v-icon>
               <span  class="nav-item"> Home</span>
            </a>
          </li>
          <li>
            <a href="">
              <v-icon class="icon">mdi-menu</v-icon>
              <span class="nav-item">Menu</span>
            </a>
          </li>
          <li>
            <a href="">
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
    </nav>


</template>

<script>

export default{
    name:"sidebar",

    data(){
        return{

        }
    },

    methods:{
        changer(){
            this.etatsidbar=this.etatsidbar==true ? false : true;
            this.$emit("changreetat", this.etatsidbar);
        }
    },

    created(){
       
    },

    props:{
        etatsidbar:Boolean
    }
    
}

</script>

<style scoped>


    /*.sidebar{
        color:#fff;
        background-color: #2f855a;
        float: left;
        position: fixed;
        z-index: 1;
        top: 0;
        transition: 0.3 ease;
        left: 0;
        bottom: 0;
        padding: 0.5em;
        display: flex;
        flex-direction: column;
    }*/

   nav{

        background: #E84C03;
        position: absolute;
        left: 0;
        top: 0;
        height: 100vh;
        z-index: 9999999;
        width: 90px;
        bottom: 0;
        overflow: hidden;
        transition: width 0.2s linear ;
        border-radius: 1px 50px 30px 1px;
        box-shadow: 0 20px 35px rgba(0,0,0,0.1);
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