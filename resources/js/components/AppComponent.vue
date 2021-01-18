<template>
    <div>
        <input type="button" :value="showlogin"  >


        <div v-if="!showlogin">
            <router-link :to="{ name : 'upload' }">upload</router-link>
        </div>

        <div class="container">
            <router-view></router-view>
        </div>
        <Login v-on:showloginchild="showconsole"></Login>
    </div>
</template>

<script>
    import Login from './LoginComponent'
    export default {
        data() {
            return {
                showlogin: true,
            }
        },

        components :{ Login },
        created() {

        },
        methods : {
            showconsole : function (ev) {
                this.showlogin = ev;
            }
        }

    }
</script>

<style scoped>

</style>
