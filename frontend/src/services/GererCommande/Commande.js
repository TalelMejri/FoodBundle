import "@/plugins/axios";
import axios from "axios";

export default{

     AddCommande(Commande){
        return axios.post('commande/AddCommande',Commande);
     },
     CommandeForUser(id,code,page){
       return axios.get(`commande/CommandeForUser/?id=${id}&${code ? 'code='+code : ''}&page=${page}`);
     },
     deleteCommande(id){
      return axios.delete('commande/deleteCommande/'+id);
     },
     AllCommande(code,page){
       return axios.get(`commande/AllCommande?${code ? 'code='+code : ''}&page=${page}`);
     },
     AllCommandeAccpted(code,page){
      return axios.get(`commande/AllCommandeAccpted?${code ? 'code='+code : ''}&page=${page}`);
    },
    AllCommandeRejeter(code,page){
       return axios.get(`commande/AllCommandeRejeter?${code ? 'code='+code : ''}&page=${page}`);
    },
    rejeterCommande(id,iduser){
      return axios.delete(`commande/rejeterCommande?${iduser!=null ? 'iduser='+iduser : ''}&id=${id}`);
    },
    AccepterCommande(id,iduser){
      return axios.put(`commande/AccepterCommande?${iduser!=null ? 'iduser='+iduser : ''}&id=${id}`);
    },
    countCommande(){
      return axios.get('commande/countCommande');
    }
     
}