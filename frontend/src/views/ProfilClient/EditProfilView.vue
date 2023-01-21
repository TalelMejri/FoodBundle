<template>
    <div>
        <v-container class="mt-5 py-5">
            <h2 class="text-center mb-5"> <span style="color:#E84C03;">Food</span>Bundle</h2>
            <EditAcountVue :direction="'home'"></EditAcountVue>
        </v-container>
        <FooterVueVue></FooterVueVue>
    </div>
</template>

<script>
import FooterVueVue from '@/components/home_page/FooterVue.vue';
import EditAcountVue from '@/components/ProfilAdmin/EditAcount.vue';
export default{
    created(){
       // this.id=this.$route.params.id;
    },
    data(){
        return{
            
        }
    },
    methods:{

    },
    components:{
        EditAcountVue,FooterVueVue
    }
}
</script>