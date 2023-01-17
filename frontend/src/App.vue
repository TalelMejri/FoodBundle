<template>
  <v-app id="app">
    <router-view v-slot="{ Component }">
      <transition name="fade"  mode="out-in">
        <component :is="Component" />
      </transition>
    </router-view>
  </v-app>
</template>

<script>

export default {
  name: 'App',
    methods:{
      
    },
  
};
</script>


<style scoped>
#app{
  background: #FFF9EB;
  overflow: hidden;
  width: 100vw;
}

.fade-enter,.fade-leave-to{
  opacity: 0; 
  transform: translateX(2em);
}
.fade-enter-active,.fade-leave-active{
  transition: all .3s ease;
}
</style>
