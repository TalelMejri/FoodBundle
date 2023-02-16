import "@/plugins/axios";
import Axios from "axios";

export default{
    getNotification(){
        return Axios.get('notif/getnotif');
    },
    getAllNotification(){
        return Axios.get('notif/getAllNotification');
    },
    deleteAllNotif(){
        return Axios.delete('notif/deleteAllNotif');
    },
    deleteNotification(id){
        return Axios.delete('notif/deleteNotification/'+id);
    },
    changeretat(id){
        return Axios.put('notif/changeretat/'+id);
    }
}