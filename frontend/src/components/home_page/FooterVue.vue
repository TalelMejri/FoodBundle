<template>
    <div class="footer">
        <div class="ma-5 pa-5 " >
            <v-card  elevation="2">
                    <div class="row "  >
                         <div class="col-lg-4 text-center">
                                     <img width="100px"  height="100px"  src="../../assets/logo.png" alt="">
                                
                                <h4 class="py-2"> <span style="color:#E84C03;">Food</span>Bundle</h4>
                         </div>
                         <div class="col-lg-4 text-center">
                                <p style="color:#000">Menu</p>
                                <ul class="list-group">
                                    <li class="list-group-item">Domicile</li>
                                    <li class="list-group-item">À propos de</li>
                                    <li class="list-group-item">Blog</li>
                                  </ul>
                         </div>
                         <div class="col-lg-4 text-center">
                            <p style="color:#000">Téléchargez notre application</p>
                             <img width="100px" height="100px" src="../../assets/apple-app-store-travel-awards-globestamp-7.png" alt="">
                         </div>
                         <v-divider></v-divider>
                         <div class="col-lg-12 py-2 text-center">
                            © 2023. Tous les droits sont réservés.
                         </div>
                    </div>

            </v-card>
          </div>
    </div>
</template>

<script>
export default{
    name:"footer",
    data(){
        return{

        }
    },
    methods:{

    },
    computed:{

    }
}
</script>

<style>
li{
    list-style-type: none;
}



</style>