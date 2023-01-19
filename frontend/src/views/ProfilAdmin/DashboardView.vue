<template>
    <div>   
        <div class="sidebar_position">
            <SideBar @changerView="changerView" :ViewCurrent="ViewCurrent" :admin_dashboard="admin_dashboard" :etatsidbar="etatsidbar" @changreetat="changreetat"></SideBar>
        </div>
        <div class="content"  :class=" etatsidbar==true ? 'close ' : '' "> 
            <div class="ma-5 pa-5" id="home">
              <v-container >
                <v-row >
                    <v-col
                      class="float-end"
                    >
                     <h2> <span style="color:#E84C03;">{{store.user['name']}}</span>{{store.user['lastname']}}</h2>
                    </v-col>
                  </v-row>
                  <div v-if="ViewCurrent=='state'">
                    <SatistiqueView></SatistiqueView>
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
                  <div  v-else-if="ViewCurrent=='commande'">
                    <CommandeView></CommandeView>
                  </div>
            </v-container>
            </div>
       </div>
    </div>
</template>
<script>

 /** 
  *  test better comment
  *  !sqdsqsqdq
  *  ? dsdsdsd
  *  TODO:dsdsdsd
 */

    import SatistiqueView from "./SatistiqueView.vue"
    import SideBar from "../../components/SideBar.vue"
    import CategoryView from "@/components/ProfilAdmin/ConsulteCategory.vue"
    import clientView from "@/views/ProfilAdmin/Client/ConsulteClientView.vue"
    import CommandeView from "../ProfilAdmin/Commande/CommandeView.vue";
    import ConsulteProduitView from "../ProfilAdmin/Product/ConsulteProduitView.vue";
    import { AuthStore } from '@/store/StoreAuth';

    export default{
        name:'dashboard',
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
                ViewCurrent:'state'
            }
        },
        methods:{
            changreetat(a){
                this.etatsidbar=a;
            },
            changerView(a){
                this.ViewCurrent=a;
            }
        },
        components:{
            SideBar,SatistiqueView,clientView,CommandeView,ConsulteProduitView,CategoryView
        }
    }
</script>

<style scoped>
    
</style>