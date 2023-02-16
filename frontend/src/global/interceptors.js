import Axios from "axios";
import { AuthStore } from "../store/StoreAuth.js";
export function interceptors() {
  Axios.interceptors.request.use(
    function (config) {
      const store = AuthStore();
      config.headers.Authorization = `Bearer ${store.token}`;
      return config;
    },
    function (error) {
      return Promise.reject(error);
    }
  );
}