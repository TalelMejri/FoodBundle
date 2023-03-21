<template>
  <div class="mt-3 py-5">
    <v-container class="mx-auto mt-3 mb-5">
      <h4 class="text-center">Commande Demander</h4>
      <v-text-field
        v-model="search_demander"
        @keyup="fetchAllcommandeDemaander()"
        append-icon="mdi-magnify"
        label="Search Commande Demander"
        max-width="100"
        single-line
        hide-details
      ></v-text-field>
      <v-row max-width="700" class="mt-2 mb-2">
        <v-card
          class="mt-5"
          style="padding: 25px 15px; margin: 0 auto"
          v-if="loader_demander == false"
        >
          <v-progress-circular
            :width="3"
            color="red"
            class="mt-5"
            indeterminate
          ></v-progress-circular>
        </v-card>
        <v-card
          class="mt-5"
          style="padding: 25px 15px; margin: 0 auto"
          v-else-if="AllCommande == ''"
        >
          Pas de Commande Demander
        </v-card>
        <v-card
          v-else
          v-for="commande in AllCommande"
          :key="commande"
          class="mx-5 mb-2"
          style="padding: 15px"
          max-width="300"
        >
          <h4 class="text-center mb-4">
            {{ commande.Nom + " " + commande.Prenom }}
          </h4>
          <p class="text-center py-2">
            Commande N°{{ commande.Code_Commande }}
          </p>
          <div class="text-center py-2">
            <v-btn
              class="text-center"
              color="primary"
              @click="initIndice(commande)"
              >Plus d'info</v-btn
            >
          </div>
          <v-container>
            <v-row class="mt-2 justify-center">
              <v-btn
                @click="AccepterCommande(commande.id, commande.user_id)"
                class="mx-2 mb-1"
                style="color: blue"
                text
                outlined
                >Accepter</v-btn
              >
              <v-btn
                type="button"
                @click="initRegeter(commande)"
                text
                outlined
                style="color: red"
                >Rejeter</v-btn
              >
            </v-row>
          </v-container>
        </v-card>
      </v-row>

      <div class="justify-center mt-3">
        <v-btn
          class="mx-2"
          :disabled="pagination.prevpage == null"
          @click="changerPage(pagination.curentpage - 1)"
        >
          <v-icon>mdi-chevron-left</v-icon>
        </v-btn>
        <v-btn
          v-for="num in Math.ceil(
            pagination.per_page ? pagination.total / pagination.per_page : 1
          )"
          :key="num"
          color="primary"
          @click="changerPage(num)"
          :disabled="pagination.curentpage == num"
        >
          {{ num }}
        </v-btn>
        <v-btn
          class="mx-2"
          :disabled="pagination.nextpage == null"
          @click="changerPage(pagination.curentpage + 1)"
        >
          <v-icon> mdi-chevron-right</v-icon>
        </v-btn>
      </div>
    </v-container>

    <v-dialog
      v-if="commande_selected != ''"
      transition="dialog-bottom-transition"
      max-width="500"
      v-model="dialog"
    >
      <template>
        <v-card>
          <v-toolbar color="primary" dark>Info Commande</v-toolbar>
          <v-card-text>
            <div class="text-h5 text-center pa-12">
              N°{{ commande_selected.Code_Commande }}
            </div>
            <v-simple-table>
              <template v-slot:default>
                <thead>
                  <tr>
                    <th class="text-left">Image</th>
                    <th class="text-left">Prix Unite</th>
                    <th class="text-left">Quantité</th>
                    <th class="text-left">Prix Total</th>
                    <th class="text-left">Option</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="i in commande_selected.ligencommandes" :key="i.id">
                    <p style="display: none">
                      {{
                        (index = All_product.find((v) => v.id == i.product_id))
                      }}
                    </p>
                    <td>
                      <img
                        width="70px"
                        height="60px"
                        :src="index.PhotoProduct"
                        alt=""
                      />
                    </td>
                    <td>{{ index.PrixProduct }}</td>
                    <td>{{ i.Quantity }}</td>
                    <td>{{ i.prix_ligne_commande }}</td>
                    <div style="display: none">
                      {{ (option_current = []) }}
                      <div v-for="option in All_option" :key="option.id">
                        {{
                          option.lign_commande_id == i.id
                            ? option_current.push({
                                nameOption: option.nameOption,
                              })
                            : ""
                        }}
                      </div>
                    </div>
                    <td>
                      <v-select
                        :items="option_current"
                        item-text="nameOption"
                        label="Option"
                      >
                      </v-select>
                    </td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>
          </v-card-text>
          <v-card-text>
            <h2>Info Client</h2>
            <v-simple-table>
              <template v-slot:default>
                <thead>
                  <tr>
                    <th class="text-left">Name</th>
                    <th class="text-left">Adresse</th>
                    <th class="text-left">Pays</th>
                    <th class="text-left">tlf</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>{{ commande_selected.Nom }}</td>
                    <td>{{ commande_selected.Adresse }}</td>
                    <td>{{ commande_selected.Pays }}</td>
                    <td>{{ commande_selected.Numero_tlf }}</td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>
          </v-card-text>
          <v-card-actions class="justify-end">
            <v-btn text @click="commande_selected = []">Fermer</v-btn>
          </v-card-actions>
        </v-card>
      </template>
    </v-dialog>

    <div class="mt-5 py-5">
      <div class="d-flex" v-if="commande_current == 'accepter'">
        <h4 class="py-4">Commande Accepter</h4>
        <v-spacer></v-spacer>
        <span class="">
          <v-tooltip bottom>
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                @click="changerView('rejeter')"
                class="mb-5"
                v-bind="attrs"
                v-on="on"
                text
              >
                <v-icon color="red">mdi-cancel</v-icon>
              </v-btn>
            </template>
            <span>Rejeter</span>
          </v-tooltip>
        </span>
      </div>
      <div class="d-flex" v-else>
        <h4 class="py-4">Commande Rejeter</h4>
        <v-spacer></v-spacer>
        <span class="">
          <v-tooltip bottom>
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                @click="changerView('accepter')"
                class="mb-5"
                v-bind="attrs"
                v-on="on"
                text
              >
                <v-icon color="green">mdi-check-circle-outline</v-icon>
              </v-btn>
            </template>
            <span>Accepter</span>
          </v-tooltip>
        </span>
      </div>
      <div class="mt-5" v-if="commande_current == 'accepter'">
        <v-card elavation="7" style="padding: 25px">
          <v-text-field
            v-model="search"
            @keyup="fetchAllcommandeAccepter()"
            append-icon="mdi-magnify"
            label="Rechercher"
            single-line
            hide-details
          ></v-text-field>
          <v-expansion-panels v-if="loader == false" focusable>
            <v-progress-circular
              :width="3"
              color="red"
              class="mt-5"
              indeterminate
            ></v-progress-circular>
          </v-expansion-panels>
          <v-expansion-panels v-else-if="AllCommandeAccpted == ''" focusable>
            pas de donneés
          </v-expansion-panels>
          <v-expansion-panels v-else focusable>
            <v-expansion-panel
              class="mt-5"
              v-for="item in AllCommandeAccpted"
              :key="item.id"
            >
              <v-expansion-panel-header>
                <v-simple-table>
                  <template v-slot:default>
                    <thead>
                      <tr>
                        <th class="text-left">Code Commande</th>
                        <th class="text-left">Prix Total</th>
                        <th class="text-left">Operation</th>
                      </tr>
                    </thead>
                    <tbody>
                      <td>
                        {{ item.Code_Commande }}
                      </td>
                      <td>
                        {{ item.Prix_Total }}
                      </td>
                      <td>
                        <v-btn text @click="initcommande(item)">
                          <v-icon>mdi-delete</v-icon>
                        </v-btn>
                      </td>
                    </tbody>
                  </template>
                </v-simple-table>
              </v-expansion-panel-header>
              <v-expansion-panel-content>
                <v-simple-table>
                  <template v-slot:default>
                    <thead>
                      <tr>
                        <th class="text-left">Image</th>
                        <th class="text-left">Prix</th>
                        <th class="text-left">Quantité</th>
                        <th class="text-left">Prix Total</th>
                        <th class="text-left">Option</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="i in item.ligencommandes" :key="i.id">
                        <p style="display: none">
                          {{
                            (index = All_product.find(
                              (v) => v.id == i.product_id
                            ))
                          }}
                        </p>
                        <td>
                          <img
                            width="80px"
                            height="80px"
                            :src="index.PhotoProduct"
                            alt=""
                          />
                        </td>
                        <td>{{ index.PrixProduct }}</td>
                        <td>{{ i.Quantity }}</td>
                        <td>{{ i.prix_ligne_commande }}</td>
                        <div style="display: none">
                          {{ (option_current = []) }}
                          <div v-for="option in All_option" :key="option.id">
                            {{
                              option.lign_commande_id == i.id
                                ? option_current.push({
                                    nameOption: option.nameOption,
                                  })
                                : ""
                            }}
                          </div>
                        </div>
                        <td>
                          <v-select
                            :items="option_current"
                            item-text="nameOption"
                            label="Option"
                          >
                          </v-select>
                        </td>
                      </tr>
                    </tbody>
                  </template>
                </v-simple-table>
              </v-expansion-panel-content>
            </v-expansion-panel>
          </v-expansion-panels>
          <div class="justify-center mt-3">
            <v-btn
              class="mx-2"
              :disabled="paginatione.prevpage == null"
              @click="changerPagee(paginatione.curentpage - 1)"
            >
              <v-icon>mdi-chevron-left</v-icon>
            </v-btn>
            <v-btn
              v-for="num in Math.ceil(
                paginatione.per_page
                  ? paginatione.total / paginatione.per_page
                  : 1
              )"
              :key="num"
              color="primary"
              @click="changerPagee(num)"
              :disabled="paginatione.curentpage == num"
            >
              {{ num }}
            </v-btn>
            <v-btn
              class="mx-2"
              :disabled="paginatione.nextpage == null"
              @click="changerPagee(paginatione.curentpage + 1)"
            >
              <v-icon>mdi-chevron-right</v-icon>
            </v-btn>
          </div>
        </v-card>
      </div>

      <div class="mt-5" v-else>
        <v-card elavation="7" style="padding: 25px">
          <v-text-field
            v-model="search"
            @keyup="fetchAllCommandeRejeter()"
            append-icon="mdi-magnify"
            label="Rechercher"
            single-line
            hide-details
          ></v-text-field>
          <v-expansion-panels v-if="loader == false" focusable>
            <v-progress-circular
              :width="3"
              color="red"
              class="mt-5"
              indeterminate
            ></v-progress-circular>
          </v-expansion-panels>
          <v-expansion-panels v-else-if="AllCommande_rejeter == ''" focusable>
            pas de donneés
          </v-expansion-panels>
          <v-expansion-panels v-else focusable>
            <v-expansion-panel
              class="mt-5"
              v-for="item in AllCommande_rejeter"
              :key="item.id"
            >
              <v-expansion-panel-header>
                <v-simple-table>
                  <template v-slot:default>
                    <thead>
                      <tr>
                        <th class="text-left">Code Commande</th>
                        <th class="text-left">Prix Total</th>
                        <th class="text-left">Operation</th>
                      </tr>
                    </thead>
                    <tbody>
                      <td>
                        {{ item.Code_Commande }}
                      </td>
                      <td>
                        {{ item.Prix_Total }}
                      </td>
                      <td>
                        <v-btn text @click="initcommande(item)">
                          <v-icon>mdi-delete</v-icon>
                        </v-btn>
                      </td>
                    </tbody>
                  </template>
                </v-simple-table>
              </v-expansion-panel-header>
              <v-expansion-panel-content>
                <v-simple-table>
                  <template v-slot:default>
                    <thead>
                      <tr>
                        <th class="text-left">Image</th>
                        <th class="text-left">Prix</th>
                        <th class="text-left">Quantité</th>
                        <th class="text-left">Prix Total</th>
                        <th class="text-left">Option</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="i in item.ligencommandes" :key="i.id">
                        <p style="display: none">
                          {{
                            (index = All_product.find(
                              (v) => v.id == i.product_id
                            ))
                          }}
                        </p>

                        <td>
                          <img
                            width="80px"
                            height="80px"
                            :src="index.PhotoProduct"
                            alt=""
                          />
                        </td>
                        <td>{{ index.PrixProduct }} TND</td>
                        <td>{{ i.Quantity }}</td>
                        <td>{{ i.prix_ligne_commande }}</td>
                        <div style="display: none">
                          {{ (option_current = []) }}
                          <div v-for="option in All_option" :key="option.id">
                            {{
                              option.lign_commande_id == i.id
                                ? option_current.push({
                                    nameOption: option.nameOption,
                                  })
                                : ""
                            }}
                          </div>
                        </div>
                        <td>
                          <v-select
                            :items="option_current"
                            item-text="nameOption"
                            label="Option"
                          >
                          </v-select>
                        </td>
                      </tr>
                    </tbody>
                  </template>
                </v-simple-table>
              </v-expansion-panel-content>
            </v-expansion-panel>
          </v-expansion-panels>
          <div class="justify-center mt-3">
            <v-btn
              class="mx-2"
              :disabled="paginatione.prevpage == null"
              @click="changerPagee(paginatione.curentpage - 1)"
            >
              <v-icon>mdi-chevron-left</v-icon>
            </v-btn>
            <v-btn
              v-for="num in Math.ceil(
                paginatione.per_page
                  ? paginatione.total / paginatione.per_page
                  : 1
              )"
              :key="num"
              color="primary"
              @click="changerPagee(num)"
              :disabled="paginatione.curentpage == num"
            >
              {{ num }}
            </v-btn>
            <v-btn
              class="mx-2"
              :disabled="paginatione.nextpage == null"
              @click="changerPagee(paginatione.curentpage + 1)"
            >
              <v-icon>mdi-chevron-right</v-icon>
            </v-btn>
          </div>
        </v-card>
      </div>

      <v-dialog
        v-if="commande_selected_rejeter != ''"
        transition="dialog-bottom-transition"
        max-width="600"
        v-model="dialog_rejeter"
      >
        <template>
          <v-card>
            <v-toolbar color="danger" dark>Rejeter Commande</v-toolbar>
            <v-card-text>
              <div class="text-h4 pa-12">
                Code :{{ commande_selected_rejeter.Code_Commande }}
              </div>
            </v-card-text>
            <v-card-actions class="justify-end">
              <v-btn
                text
                @click="
                  RejeterCommande(
                    commande_selected_rejeter.id,
                    commande_selected_rejeter.user_id
                  )
                "
                >Rejeter</v-btn
              >
              <v-btn text @click="dialog_rejeter = false">Fermer</v-btn>
            </v-card-actions>
          </v-card>
        </template>
      </v-dialog>

      <v-dialog
        v-if="commande_selected_deleted != ''"
        transition="dialog-bottom-transition"
        max-width="600"
        v-model="dialog_deleted"
      >
        <template>
          <v-card>
            <v-toolbar color="danger" dark>Supprimer Commande</v-toolbar>
            <v-card-text>
              <div class="text-h4 pa-12">
                Code :{{ commande_selected_deleted.Code_Commande }}
              </div>
            </v-card-text>
            <v-card-actions class="justify-end">
              <v-btn text @click="deleteCommande(commande_selected_deleted.id)"
                >Supprimer</v-btn
              >
              <v-btn text @click="dialog_deleted = false">Fermer</v-btn>
            </v-card-actions>
          </v-card>
        </template>
      </v-dialog>
      <v-snackbar v-model="snackbar">
        Suppression terminée avec succès
        <template v-slot:action="{ attrs }">
          <v-btn color="pink" text v-bind="attrs" @click="snackbar = false">
            Fermer
          </v-btn>
        </template>
      </v-snackbar>
    </div>
  </div>
</template>

<script>
import service_product from "@/services/GererProduct/GererProduct";
import service_option from "@/services/GererOption/option";
import service_commande from "@/services/GererCommande/Commande";
export default {
  name: "commande",
  mounted() {
    window.Echo.channel("public").listen("notif", (e) => {
      if (this.commande_current == "accepter") {
        this.fetchAllcommandeAccepter();
      } else {
        this.fetchAllCommandeRejeter();
      }
      this.fetchAllcommandeDemaander();
    });
  },
  created() {
    this.changerPage(1);
    this.changerPagee(1);
    if (this.commande_current == "accepter") {
      this.fetchAllcommandeAccepter();
    } else {
      this.fetchAllCommandeRejeter();
    }
    this.fetchAllcommandeDemaander();

    service_product.getProducts().then((res) => {
      this.All_product = res.data;
    });
    service_option.getAllOption().then((res) => {
      this.All_option = res.data;
    });
  },
  data() {
    return {
      AllCommande: [],
      AllCommandeAccpted: [],
      commande_current: "accepter",
      commande_selected_deleted: [],
      search: "",
      commande_selected: [],
      pagination: {
        curentpage: 1,
        nextpage: 0,
        prevpage: 0,
        total: 0,
        per_page: 0,
      },
      paginatione: {
        curentpage: 1,
        nextpage: 0,
        prevpage: 0,
        total: 0,
        per_page: 0,
      },
      commande_selected_rejeter: [],
      AllCommande_rejeter: [],
      dialog_rejeter: false,
      All_option: [],
      dialog_deleted: false,
      All_product: [],
      search_demander: "",
      snackbar: false,
      loader: false,
      loader_demander: false,
    };
  },
  methods: {
    changerView(curent) {
      this.search = "";
      this.loader = false;
      this.commande_current = curent;
      if (this.commande_current == "accepter") {
        this.fetchAllcommandeAccepter();
      } else {
        this.fetchAllCommandeRejeter();
      }
    },
    initRegeter(item) {
      this.commande_selected_rejeter = item;
      this.dialog_rejeter = true;
    },
    RejeterCommande(id, iduser) {
      service_commande.rejeterCommande(id, iduser).then((res) => {
        this.commande_selected_rejeter = [];
        this.dialog_rejeter = false;
        this.fetchAllcommandeDemaander();
      });
    },
    AccepterCommande(id, iduser) {
      service_commande.AccepterCommande(id, iduser).then((res) => {
        console.log(res);
        this.fetchAllcommandeDemaander();
        this.fetchAllcommandeAccepter();
      });
    },
    initcommande(item) {
      this.commande_selected_deleted = item;
      this.dialog_deleted = true;
    },
    deleteCommande(id) {
      service_commande.deleteCommande(id).then((res) => {
        this.commande_selected_deleted = [];
        this.dialog_deleted = false;
        this.snackbar = true;
        if (this.commande_current == "accepter") {
          this.fetchAllcommandeAccepter();
        } else {
          this.fetchAllCommandeRejeter();
        }
      });
    },
    initIndice(item) {
      this.commande_selected = item;
      this.dialog = true;
    },
    fetchAllcommandeDemaander() {
      service_commande
        .AllCommande(this.search_demander, this.pagination.curentpage)
        .then((res) => {
          this.AllCommande = res.data.data;
          this.loader_demander = true;
          this.pagination.curentpage = res.data.current_page;
          this.pagination.prevpage = res.data.prev_page_url?.split("=")[1];
          this.pagination.nextpage = res.data.next_page_url?.split("=")[1];
          this.pagination.per_page = res.data.per_page;
          this.pagination.total = res.data.total;
        });
    },

    changerPage(num) {
      this.pagination.curentpage = num;
      this.fetchAllcommandeDemaander();
    },
    changerPagee(num) {
      this.paginatione.curentpage = num;
      this.fetchAllcommandeAccepter();
    },
    fetchAllcommandeAccepter() {
      service_commande
        .AllCommandeAccpted(this.search, this.paginatione.curentpage)
        .then((res) => {
          this.AllCommandeAccpted = res.data.data;
          this.loader = true;
          this.paginatione.curentpage = res.data.current_page;
          this.paginatione.prevpage = res.data.prev_page_url?.split("=")[1];
          this.paginatione.nextpage = res.data.next_page_url?.split("=")[1];
          this.paginatione.per_page = res.data.per_page;
          this.paginatione.total = res.data.total;
        });
    },
    fetchAllCommandeRejeter() {
      service_commande
        .AllCommandeRejeter(this.search, this.paginatione.curentpage)
        .then((res) => {
          this.AllCommande_rejeter = res.data.data;
          this.loader = true;
          this.paginatione.curentpage = res.data.current_page;
          this.paginatione.prevpage = res.data.prev_page_url?.split("=")[1];
          this.paginatione.nextpage = res.data.next_page_url?.split("=")[1];
          this.paginatione.per_page = res.data.per_page;
          this.paginatione.total = res.data.total;
        });
    },
  },
};
</script>