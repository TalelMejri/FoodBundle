<template> 
      <div class="all"> 
        <div >
          <SideBar :etatsidbar="etatsidbar" @changreetat="changreetat"></SideBar>
        </div>
        <div class="content" :class=" etatsidbar==true ? 'close ' : ''">
          <div class="ma-5 pa-5">
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
                >
                  <v-btn   class="mx-2"   color="primary">
                    Login
                  </v-btn>
                  <v-btn  class="pa-2"  color="primary">
                    Sign Up
                  </v-btn>
                </v-row>
                </v-col>
              </v-row>
               <v-content class="home my-5 py-5 d-flex justify-content-center"  >
                <v-container class="mt-5 py-5" >
                  <v-row 
                    class="mb-6 mt-5"
                    no-gutters
                  >
                    <v-col class="mt-5 py-5" md="5">
                         <p class="py-5 mt-5 paragh" >
                          Taste Our <br>
                            Delicious Foods
                         </p>
                         <p  >
                          lore"Lorem ipsum dolor sit amet, consectetur adipiscing 
                          elit, sed do eiusmod tempor incididunt ut labore et dolor
                           magna aliqua. 
                         </p>
                    </v-col>
                    <v-col
                      md="4"
                      offset-md="2"
                    >
                        <img class="image" src="../assets/home-img.png" alt="">
                    </v-col>
                  </v-row>
                  <v-btn class="btn">See Menu</v-btn>
                </v-container>
               </v-content>
            </v-container>
          </div>
        </div>
     </div>
</template>
<script>
  import SideBar from "../components/SideBar.vue"
  export default {
    name: 'Home', 
    data(){
        return{
          etatsidbar:false
        }
    },
    components:{
        SideBar
    },
    methods:{
      changreetat(a){
        this.etatsidbar=a;
      }
    }

  }
</script>

<style scoped>
.btn{
  color: #fff;
  background: #E84C03 !important; 
}
.btn:hover{
  color: #E84C03;
  background: #fff !important; 
}
.content.close{
  width: calc(100%-90px);
  margin-left: 90px;
}

.content {
  width: calc(100%-280px);
  margin-left: 280px;
}

.image{
  width: 500px;
  height: 400px;
  transition: all 0.2 ease-in-out;
  animation: animate 8s infinite;
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

</style>
