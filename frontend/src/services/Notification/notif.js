import "@/plugins/axios";
import Axios from "axios";

export default{
    getNotification(id){
        return Axios.get('notif/getnotif/'+id);
    },
    deleteNotification(id){
        return Axios.delete('notif/deleteNotification/'+id);
    }
}