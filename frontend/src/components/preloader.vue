<template>
    <div  class="popup-below">
        <div class="popup_form">
             <img width="200px" height="200px" src="../assets/loader.gif" alt="">
        </div>
    </div>
</template>

<script>

</script>

<style scoped>

.popup-below {
    position: fixed; /* Stay in place */
    z-index: 999999999;
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

.popup_form{
    position: fixed;
    top: 50%;
    left:50%;
    flex-direction: column;
    transform: translate(-50%,-50%)scale(0.9);
    background: #fff;
    width:70%;
    border-radius: 10px;
    height:60%;
    z-index: 999999999;
    display: flex;
    justify-content: center;
    align-items: center;
    padding:88px;
}
    .content{
        background-color:  #fff;
        height: 100vh;
        z-index: 9999999999;
        position: fixed;
        top:0;
        left:0;
        width: 100%;
        display: flex;
        min-height: 100vh;
        justify-content: center;
        align-items: center;
    }
    
</style>