<template>
    <router-link to="">

    </router-link>
    <div class="container">
        <router-view></router-view>
    </div>

</template>

<script>
    import vueRouter from 'vue-router';
    const vuerouter = new vueRouter({
        routes : routes
    });
    export default {
        name: "App"
    }
</script>

<style scoped>

</style>
