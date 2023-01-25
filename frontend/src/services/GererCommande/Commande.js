import "@/plugins/axios";
import axios from "axios";

export default{

     AddCommande(Commande){
        return axios.post('commande/AddCommande',Commande);
     }
     
}