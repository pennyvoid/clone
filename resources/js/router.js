import Vue from "vue";
import VueRouter from "vue-router";
import NewsFeed from "./views/NewsFeed";
import ShowUser from "./views/users/Show";
Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        name: "home",
        component: NewsFeed,
        meta: { title: "NewsFeed" }
    },
    {
        path: "/users/:userId",
        name: "user.show",
        component: ShowUser,
        meta: { title: "Profile" }
    }
];
export default new VueRouter({
    mode: "history",
    routes
});
