<template>
    <div
        v-show="this.$store.state.layout === 'landing'"
        class="landing-bg h-100 bg-gradient-primary position-fixed w-100">
    </div>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <router-view/>
    </main>
</template>
<script>
export default {
    name: "BaseLayout"
}
</script>
