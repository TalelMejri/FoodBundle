
import { defineStore } from 'pinia';
import { computed, ref } from "vue";

export const sideBarStore = defineStore('sidebar',() =>{

     const collaps=ref(false);
     const togglesidebar=ref((collaps.value = !collaps.value));
     const sidebar_width_init=ref(180);
     const sidebar_collapse=ref(80);

     const sidebarwidth=computed(()=>
     `${collaps.value==false ? sidebar_collapse.value : sidebar_width_init.value}px`);

     function changer(){
        collaps.value=collaps.value==true ? false : true;
     }

     return {collaps,togglesidebar,sidebar_width_init,sidebar_collapse,sidebarwidth,changer}

})


    

