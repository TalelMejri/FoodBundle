<template>
    <div v-if="preloader"  class="preloader">
        <img width="200px" height="200px" src="../assets/loader.gif" alt="">
    </div>
</template>
<script>
export default{
    name:"loader",
    mounted(){
        setTimeout(()=>this.preloader=false,1);
    },
    data(){
        return{
            preloader:true
        }
    }
}
</script>

<style scoped>
    .preloader{
        background-color:  #fff;
        height: 100vh;
        position: fixed;
        z-index:99999999;
        top:0;
        left:0;
        width: 100vw;
        display: flex;
        min-height: 100vh;
        justify-content: center;
        align-items: center;
    }
    
</style>