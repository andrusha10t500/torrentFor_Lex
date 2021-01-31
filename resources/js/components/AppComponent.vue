<template>
    <div>
        <div  v-if="!uploadComp" class="row">
            <router-link
                    class="btn btn-success border-dark"
                    :to="{ name : 'login' }"

            >Зарегистрироваться</router-link>

            <router-link
                    class="btn btn-success border-dark"
                    :to="{ name : 'signin' }"

            >Войти</router-link>
        </div>

        <div v-else-if="uploadComp">
            <router-link
                    :to="{ name: 'upload' }"
            >Загрузить торрент</router-link>
        </div>

        <div class="container">
            <router-view
                    v-on:showloginchild="showconsole"
            ></router-view>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                uploadComp : false
            }
        },

        created() {

        },
        methods : {
            showconsole : function (ev) {
                alert("AppComponent: " + ev);
                this.uploadComp = ev;
            }
        }

    }
</script>

<style scoped>

</style>
