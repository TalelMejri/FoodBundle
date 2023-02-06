 <template>
    <div>
      <div class="sidebar_position">    
        <SideBar :etatsidbar="etatsidbar" :border_radius="'no'" @changreetat="changreetat" ></SideBar>
      </div>
      <div  class="content"  :class=" etatsidbar==true ? 'close ' : '' ">
        <v-card class="header" elavation="3">
            <div class="row">
                    <h3 style="padding:15px"><span style="color:#E84C03;">Food</span>Bundle</h3>
                    <v-spacer></v-spacer>
                    <div v-if="store.isauth!=null">
                        <InfoClient :nbr_panier="nbr_panier" style="padding:15px;padding-right:40px" :menu="'menu'">
                        </InfoClient>
                    </div>
                    <div v-else>
                        <v-badge class="mx-5 mt-3" color="red"  :content="nbr_panier">
                                <router-link  to="../PanierView" style="text-decoration:none !important">
                                    <v-icon  style="font-size:25px">mdi-cart-outline</v-icon>
                                </router-link>
                        </v-badge>
                    </div>
            </div>
        </v-card>
         <div class="content_menu">
               <v-card elavation="7" style="padding:25px">
                
                <h4 class="text-center py-4">List Produits Commandés</h4>
                <v-text-field
                    v-model="search"
                    @keyup="fetchdata()"
                    append-icon="mdi-magnify"
                    label="Search"
                    single-line
                    hide-details
                ></v-text-field>
                <v-expansion-panels v-if="All_Commande==''" focusable>
                   pas  produit Commandé
                  </v-expansion-panels>
                  
                <v-expansion-panels v-else focusable>
                    <v-expansion-panel class="mt-5"
                    v-for="item in All_Commande"
                           :key="item.id"
                      >
                      <v-expansion-panel-header style="padding:15px" :color="item.statu==0 ? 'yellow' : item.statu==1 ? 'green' : 'red'" >
                        <v-simple-table>
                            <template v-slot:default>
                              <thead>
                                <tr>
                                  <th  class="text-left ">
                                    Code Commande
                                  </th>
                                  <th  class="text-left ">
                                    Prix Total
                                  </th>
                                  <th  class="text-left ">
                                    statu
                                  </th>
                                  <th v-if="item.statu==1 " class="text-left ">
                                      Supprimer
                                  </th>
                                  <th v-else class="text-left ">
                                    Annuler
                                  </th>
                                  <th v-if="item.statu==1">
                                      Télecharger Commande  Pdf
                                  </th>
                                </tr>
                              </thead>
                              <tbody>
                                    <td>
                                        {{ item.Code_Commande }}
                                    </td>
                                    <td>
                                        {{ item.Prix_Total }}
                                    </td>
                                   <td v-if="item.statu==1">
                                            Valider 
                                   </td>
                                   <td v-else-if="item.statu==0">
                                           En Cours 
                                  </td>
                                  <td v-else>
                                           Rejeter 
                                    </td>
                                    <td>
                                         <v-btn text @click="initcommande(item)">
                                             <v-icon>mdi-delete</v-icon>
                                         </v-btn>
                                    </td>
                                    <td v-if="item.statu==1">
                                        <v-btn text @click="GeneratePdf(item)">
                                          <v-icon>mdi-file-pdf-box</v-icon>
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
                                  <th  class="text-left ">
                                     Food
                                  </th>
                                  <th  class="text-left ">
                                     Prix
                                  </th>
                                  <th  class="text-left ">
                                      Quantité
                                  </th>
                                  <th  class="text-left ">
                                      Prix Total
                                  </th>
                                  <th  class="text-left ">
                                      Option
                                  </th>
                                </tr>
                              </thead>
                               <tbody>
                                <tr v-for="i in item.ligencommandes" :key="i.id">
                                  <p style="display: none;"> {{index = All_product.find((v)=>v.id=i.product_id)}} </p>
                                  <td><img width="80px" height="80px" :src="index.PhotoProduct" alt=""></td>
                                  <td>{{index.PrixProduct}}</td>
                                  <td>{{i.Quantity}}</td>
                                  <td>{{i.prix_ligne_commande}}</td>
                                  <div style="display: none;">
                                    {{ option_current=[] }}
                                    <div v-for="option in All_option" :key="option.id">
                                        {{ option.lign_commande_id==i.id ? option_current.push({nameOption:option.nameOption}) : '' }}
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
                    <v-btn  class="mx-2" :disabled="pagination.prevpage==null" @click="changerPage(pagination.curentpage-1)">
                        prev
                    </v-btn>
                    <v-btn v-for="num in (Math.ceil(pagination.per_page ? pagination.total/pagination.per_page : 1))"
                        :key="num"
                        color="primary"
                        :disabled="pagination.curentpage==num">
                          {{num}}
                    </v-btn>
                    <v-btn class="mx-2" :disabled="pagination.nextpage==null" @click="changerPage(pagination.curentpage+1)">
                          suivant
                    </v-btn>
                 </div>
          </v-card>
         
        </div>
        <v-dialog  v-if="commande_selected!=''"
        transition="dialog-bottom-transition"
        max-width="600"
        v-model="dialog"
      >
       <template >
         <v-card>
           <v-toolbar
             color="danger"
             dark
           >Suprrimer Commande</v-toolbar>
           <v-card-text>
             <div class="text-h4 pa-12">Code :{{commande_selected.Code_Commande}}</div>
           </v-card-text>
           <v-card-actions class="justify-end">
             <v-btn 
               text
               @click="deleteCommande(commande_selected.id)"
             >Suprrimer</v-btn>
             <v-btn
             text
             @click="dialog=false"
           >Fermer</v-btn>
           </v-card-actions>
         </v-card>
       </template>
     </v-dialog> 

        <div class="py-5 mt-5">
          <FooterVue class="py-5 mt-5"></FooterVue>
        </div>
        </div>
        
     <v-snackbar
     v-model="snackbar"
 >
 Suppression terminée avec succès
 
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
import jsPDF from 'jspdf'
import autoTable from 'jspdf-autotable'
import SideBar from "@/components/SideBar.vue";
import service_commande from "@/services/GererCommande/Commande.js";
import service_product from "@/services/GererProduct/GererProduct";
import service_option from "@/services/GererOption/option";
import FooterVue from "@/components/home_page/FooterVue.vue";
import InfoClient from "@/components/Client/InfoClient.vue";
import { AuthStore } from "@/store/StoreAuth";
// import html2PDF from 'jspdf-html2canvas';
// import html2canvas from "html2canvas"
import { ProductStore } from "@/store/StoreProducts";
export default{
    created(){
           this.fetchdata();
           service_product.getProducts().then((res)=>{
              this.All_product=res.data;
           });
           service_option.getAllOption().then((res)=>{
              this.All_option=res.data;
           });
           this.changerPage(1);
           this.nbr_panier=this.store_products.Products==null ? 0 :this.store_products.Products.length;
    },
    setup(){
        const store=AuthStore();
        const store_products=ProductStore();
        return{
            store,store_products
        }
    },
    data(){
        return{
            nbr_panier:0,
            commande_selected:[],
            snackbar:false,
            name_product:'',
            prix_unit:'',
            productChecked:[],
            pagination:{
                curentpage:1,
                nextpage:0,
                prevpage:0,
                total:0,
                per_page:0,
            },
            loader:false,
            search:'',
            All_option:[],
            All_Commande:[],
            dialog:false,
            All_product:[],
            etatsidbar:true
        }
    },
    methods:{
      async chercherProduct(id){
        await service_product.findProductByIid(id).then((res)=>{
           this.productChecked=res.data.data;
           this.name_product=this.productChecked['nameProduct'];
           this.prix_unit=this.productChecked['PrixProduct'];
        })
      },
      GeneratePdf(commande){
          const doc = new jsPDF();
          doc.addImage(require('../../assets/logo.png'),'png', 2, 2, 20, 20);
          doc.setFontSize(12);
          doc.setFont("times", "bold");
          doc.text('Date :',158,10);
          doc.text('Code Commande :',158,20);
          doc.setFont("times", "normal");
          doc.text(commande.created_at.substr(0,10),170,10);
          doc.text((commande.Code_Commande).toString(),192,20);
          doc.setFontSize(25);
          doc.setFont("times", "bold");
          doc.setTextColor(0, 0, 0);
          doc.text(45,40, 'BON DE COMMANDE');
          doc.setFontSize(12);
          doc.setFont("times", "bold");
          doc.text('Nom :',12,60);
          doc.text('Prénom :',12,67);
          doc.text('Email :',12,74);
          doc.text('Ville :',150,60);
          doc.text('Pays :',150,67);
          doc.text('Numéro Tlf :',150,74);
          doc.setFont("times", "normal");
          doc.text(commande.Nom,24,60);
          doc.text(commande.Prenom,30,67);
          doc.text(commande.adresse_email,26,74);
          doc.text(commande.Ville,163,60);
          doc.text(commande.Pays,163,67);
          doc.text(commande.Numero_tlf,175,74);
      
       commande.ligencommandes.forEach((v)=>{
        this.chercherProduct(v.product_id);
        var prix_total_ligne_commande=v.prix_ligne_commande;
        var quantity=v.Quantity;
            autoTable(doc, {
              theme:'striped',
              headerStyles:{halign:'center'},
              bodyStyles:{fontStyle:'bold',halign:'center'},
              margin: { top: 90 },
              head: [['Name Product','Prix Unit', 'Quantity', 'Prix Total']],
              body: [
                [this.name_product,this.prix_unit,quantity,prix_total_ligne_commande],
              ],
            })
      });
         let finalY = doc.lastAutoTable.finalY
         doc.autoTable({
             theme:'plain',
              startY: finalY+2,
              tableWidth:55,
              margin:{left:79},
              headerStyles:{halign:'center'},
              bodyStyles:{halign:'center',fontStyle:'bold'},
              head: [['Total']],
              body: [ [commande.Prix_Total]],
        });
        finalY = doc.lastAutoTable.finalY
        var writtenNumber = require('written-number');
        let total=(writtenNumber(commande.Prix_Total, {lang: 'fr'})).toUpperCase();
        doc.setFont("times", "bold");
        doc.autoTable({
              theme:'plain',
              startY: finalY+2,
              bodyStyles:{halign:'center',fontStyle:'bold'},
              body: [ [total+' DINARS']],
        });
        doc.text('Nous apprecions votre clinetele',110,doc.internal.pageSize.height - 30,'center');
        doc.text('si vous-avez des questions sur cette facture,n hesitez pas a nous contacter' ,110, doc.internal.pageSize.height - 20,'center');
          var pageCount = doc.internal.getNumberOfPages();
          for(let i = 0; i < pageCount; i++) { 
            doc.setPage(i); 
            let pageCurrent = doc.internal.getCurrentPageInfo().pageNumber; 
            doc.setFontSize(12);
            doc.text('Page: ' + pageCurrent + '/' + pageCount,110, doc.internal.pageSize.height - 10,'center');
          }
        doc.save(`Food${commande.Code_Commande}.pdf`);    
    },
      changreetat(a){
        this.etatsidbar=a;
      },
     changerPage(num){
        this.pagination.curentpage=num;
        this.fetchdata();
      },
      fetchdata(){
        service_commande.CommandeForUser(this.store.user['id'],this.search,this.pagination.curentpage).then((res)=>{
            this.All_Commande=res.data.data;
            this.pagination.curentpage=res.data.current_page;
            this.pagination.prevpage=res.data.prev_page_url?.split("=")[1];
            this.pagination.nextpage=res.data.next_page_url?.split("=")[1];
            this.pagination.per_page=res.data.per_page;
            this.pagination.total=res.data.total;
        })
      },
      initcommande(item){
        this.commande_selected=item;
        this.dialog=true;
      },
      deleteCommande(id){
        service_commande.deleteCommande(id).then((res)=>{
           console.log(res.data);
           this.commande_selected=[];
           this.dialog=false;
           this.snackbar=true;
           this.$router.go();
        })
      }
    },
    components:{
        FooterVue,InfoClient,SideBar
    }
}
</script> 
