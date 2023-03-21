<template>
  <v-app id="app">
    <router-view v-slot="{ Component }">
      <transition name="fade" mode="out-in">
        <component :is="Component" />
      </transition>
    </router-view>
  </v-app>
</template>

<script>
import AOS from "aos";
import "animate.css";
export default {
  name: "App",
  methods: {},
  mounted() {
    window.Echo.channel("public").listen("notif", (e) => {
      console.log(e);
    });
    AOS.init();
  },
};
</script>


<style scoped>
#app {
  background: #fff9eb;
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
  transform: translateX(2em);
}
.fade-enter-active,
.fade-leave-active {
  transition: all 0.3s ease;
}
</style>
