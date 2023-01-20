<template>
    <div  class="content">
        <img width="200px" height="200px" src="../assets/loader.gif" alt="">
    </div>
</template>

<script>
export default{
    name:"loader"
}
</script>

<style scoped>
    .content{
        background-color:  #fff;
        height: 100vh;
        position: fixed;
        top:0;
        left:0;
        width: 100vw;
        display: flex;
        min-height: 100vh;
        justify-content: center;
        align-items: center;
    }
    
</style>