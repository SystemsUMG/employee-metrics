<template>
    <div class="min-height-300 position-absolute w-100 bg-transparent"/>
    <aside class="my-3 overflow-auto border-0 sidenav navbar navbar-vertical navbar-expand-xs border-radius-xl fixed-start ms-3"
           :class="`${this.$store.state.sidebarType}`"
           id="sidenav-main">
        <div class="sidenav-header py-2 my-3">
            <i class="top-0 p-3 cursor-pointer fas fa-times text-secondary opacity-5 position-absolute end-0 d-none d-xl-none"
               aria-hidden="true"
               id="iconSidenav">
            </i>
            <router-link class="m-0" to="/">
                <img class="d-block m-auto h-100" alt="main_logo" :src="logo"/>
            </router-link>
        </div>
        <hr class="mt-0 horizontal dark" />
        <sidenav-list :cardBg="custom_class" />
      </aside>
</template>
<script>
import SidenavList from "./SidenavList.vue";
import logo from "../../../assets/img/logos/logo.png";

export default {
  name: "index",
  components: {
    SidenavList
  },
  data() {
    return {
      logo,
    };
  },
  props: ["custom_class", "layout"]
};
</script>
