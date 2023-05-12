<template>
    <div>
        <BaseLayout>
            <router-view/>
        </BaseLayout>
    </div>
</template>
<script>
import BaseLayout from './views/BaseLayout.vue';
import { activateDarkMode } from "./assets/js/dark-mode";

export default {
    name: "App",
    components: {
        BaseLayout
    },
    beforeMount() {
        this.$store.state.isTransparent = "bg-transparent";
        this.$store.state.darkMode = true;
        activateDarkMode();
    }
};
</script>
