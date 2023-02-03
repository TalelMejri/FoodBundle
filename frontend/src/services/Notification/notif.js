import "@/plugins/axios";
import Axios from "axios";

export default{
    getNotification(){
        return Axios.get('getnotif/');
    },
    getAllNotification(id){
        return Axios.get('notif/getAllNotification/'+id);
    },
    deleteNotification(id){
        return Axios.delete('notif/deleteNotification/'+id);
    },
    changeretat(id){
        return Axios.put('notif/changeretat/'+id);
    }
}