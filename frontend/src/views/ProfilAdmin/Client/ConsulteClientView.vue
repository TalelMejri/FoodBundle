<template>
    <div class="mt-5 py-5">

        <v-data-table
            :headers="headers"
            :items="users"
            :search="search"
            v-model="selected"
            :single-select="singleSelect"
            item-key="name"
            show-select
            class="elevation-1  mt-5 py-5"
            :loading="load==true ? false : true"
            loading-text="Loading... Please wait"
         >
<!-- v-slot:item.actions="{ item }" -->
          <template  >
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
                  dd
              </v-icon>
            </template>
            <template v-slot:default="dialog">
              <v-card>
                <v-toolbar
                  color="red"
                  style="color:#fff"
                >Confirmed Delete</v-toolbar>
                <v-card-text>
                  <div class="text-h4 pa-12">Do You Want Delete {{ item['name'] }} </div>
                </v-card-text>
                <v-card-actions class="justify-end">
                  <v-btn
                    text
                    @click="dialog.value = false"
                  >Close</v-btn>
                  <v-btn
                  text
                  color="red"
                  @click="deleteItem(item)"
                >Confirmed</v-btn>
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
                label="Search"
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
         Delete Completed With Success
        <template v-slot:action="{ attrs }">
         <v-btn
           color="pink"
              text
              v-bind="attrs"
              @click="snackbar = false"
         >
           Close
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
            service.deleteUser(item.id).then(()=>{
                this.dialog=false;
                this.snackbar=true;
                this.Alluser();
            })
        }

      },

}
</script>