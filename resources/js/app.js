import Vue from "vue";
import store from "./store";
import router from "./router";
import App from "./components/App";

import "./bootstrap";
window.Vue = require("vue");

const app = new Vue({
    el: "#app",
    components: {
        App
    },
    router,
    store
});
