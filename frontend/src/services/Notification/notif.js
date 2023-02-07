import "@/plugins/axios";
import Axios from "axios";

export default{
    getNotification(id){
        return Axios.get('notif/getnotif/'+id);
    },
    getAllNotification(id){
        return Axios.get('notif/getAllNotification/'+id);
    },
    deleteAllNotif(id){
        return Axios.get('notif/deleteAllNotif/'+id);
    },
    deleteNotification(id){
        return Axios.delete('notif/deleteNotification/'+id);
    },
    changeretat(id){
        return Axios.put('notif/changeretat/'+id);
    }
}