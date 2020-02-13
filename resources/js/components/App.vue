<template>
  <div class="flex flex-col flex-1 h-screen overflow-y-hidden" v-show="authUser">
    <Nav />
    <div class="flex flex-1 overflow-y-hidden">
      <Sidebar />
      <div class="w-2/3 overflow-x-hidden">
        <router-view :key="$route.fullPath"></router-view>
      </div>
    </div>
  </div>
</template>

<script>
import Nav from "./Nav";
import Sidebar from "./Sidebar";
import { mapGetters } from "vuex";

export default {
  name: "App",
  components: {
    Nav,
    Sidebar
  },
  mounted() {
    this.$store.dispatch("fetchAuthUser");
  },
  created() {
    this.$store.dispatch("setPageTitle", this.$route.meta.title);
  },
  computed: {
    ...mapGetters({
      authUser: "authUser",
      user: "user"
    })
  },
  watch: {
    $route(to, from) {
      this.$store.dispatch("setPageTitle", to.meta.title);
    }
  }
};
</script>
