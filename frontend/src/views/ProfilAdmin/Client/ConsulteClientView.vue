<template>
    <div class="mt-5 py-5">

        <v-data-table
            :headers="headers"
            :items="users"
            :search="search"
            v-model="selected"
            :single-select="singleSelect"
            item-key="name"
            class="elevation-1  mt-5 py-5"
            :loading="load==true ? false : true"
            loading-text="Loading... Please wait"
         >

          <template v-slot:item.actions="{ item }"  >
            <v-dialog
                transition="dialog-bottom-transition"
                max-width="600"
             >
            <template v-slot:activator="{ on, attrs }">
                <v-icon
                small
                color="red"
                v-bind="attrs"
                v-on="on"
                @click="dialog = true"
              >
                  mdi-delete
              </v-icon>
            </template>
            <template v-slot:default="dialog">
              <v-card>
                <v-toolbar
                  color="red"
                  style="color:#fff"
                >Supprimer Client</v-toolbar>
                <v-card-text>
                  <div class="text-h4 pa-12">Voulez-vous supprimer {{ item['name'] }} </div>
                </v-card-text>
                <v-card-actions class="justify-end">
                  <v-btn
                    text
                    @click="dialog.value = false"
                  >Fermer</v-btn>
                  <v-btn
                  text
                  color="red"
                  :loading="loader_delete"
                  @click="deleteItem(item)"
                >Supprimer</v-btn>
                </v-card-actions>
              </v-card>
            </template>
          </v-dialog>
  
          </template>

    <template v-slot:top >
      <v-toolbar flat
      >
        <v-toolbar-title > List Client </v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
            <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Recherche"
                single-line
                hide-details
          ></v-text-field>
        <v-spacer></v-spacer>
        <template v-slot:top>
            <v-switch
              v-model="singleSelect"
              label="Single select"
              class="pa-3"
            ></v-switch>
          </template>
      </v-toolbar>
    </template>
  </v-data-table>
        <v-snackbar
          v-model="snackbar"
        >
        Supprimer avec succès
        <template v-slot:action="{ attrs }">
         <v-btn
           color="pink"
              text
              v-bind="attrs"
              @click="snackbar = false"
         >
           Fermer
          </v-btn>
         </template>
        </v-snackbar>
    </div>
</template>

<script>

import service from "@/services/GererUser/GererUser"
export default{
    name:'client',

    mounted(){
        this.Alluser();
    },

    data(){
    return{
      singleSelect: false,
      selected: [],
      search: '',
      accepter:false,
      users:[],
      snackbar:false,
      dialog:false,
      dialogDelete: false,
      load:false,
      loader_delete:false,
      headers: [
        { text: 'id',value:'id'},
        { text: 'name',value:'name' },
        { text: 'email',value:'email' },
        { text: 'N°tlf',value:'numero_tlf' },
        { text: 'Operation', value: 'actions' },
      ],

        }
    },
   
    computed:{

    },
    methods:{

        Alluser(){
            service.getallUser().then((response)=>{
                 this.users=response.data.data;
                 this.load=true;
            })
        },
       
        deleteItem(item){
          this.loader_delete=true;
            service.deleteUser(item.id).then(()=>{
                this.loader_delete=false;
                this.dialog=false;
                this.snackbar=true;
                this.Alluser();
            })
        }

      },

}
</script>