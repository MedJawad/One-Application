import axios from "axios";
import store from "../store/index";

const listener = () => {
    let token = store.getState().auth.token;
    axios.defaults.baseURL = `/api`;
    axios.defaults.headers.common = {
        Accept: "application/json",
        Authorization: `Bearer ${token}`,
        "Content-Type": "application/x-www-form-urlencoded"
    };
};
store.subscribe(listener);

export default axios;
