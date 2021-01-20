<template>

    <!--Форма авторизации-->
    <form
        class="form-group"
        id="myForm"
        @submit="checkForm"
        method="post"
    >
        <!--<button class="btn btn-success" type="reset" v-on:click="alert">Событие для родителя</button>-->
        <!--Блок ошибок-->
        <div v-if="errors.length">
            <b>Ошибки:</b>
            <ul>
                <li v-for="error in errors">{{ error }}</li>
            </ul>
        </div>
        <!--Блок ошибок конец-->
        <label for="email">Почта</label>
        <input
                class="form-control"
                id="email"
                v-model="email"
                type="text"
                name="email"
        />

        <label for="password">Пароль</label>
        <input
                class="form-control"
                type="password"
                name="password"
                id="password"
                v-model="password"
        />
        <input type="submit" value="ok">

        <!--<input type="hidden" name="token" :value="csrf">-->
    </form>
    <!--Форма авторизации конец-->


</template>
<style >
    .sphere {
        border: solid 1px;
        border-radius: 10px;
        height : 50px;
        width : 5em;
        cursor: pointer;
    }
    div.sphere > div[class^="checkbox-"] {
        border-radius: 50px;
        border-radius: 10px;
        height : inherit;
        width: 50%;
        background: greenyellow;
    }
    .checkbox-left {
        /*float: left;*/
        display: block;
        border-radius: 50px;
        border-radius: 10px;
        margin-left: 0px;
        height : inherit;
        width: 50%;
        margin-right: 100px;
        background: greenyellow;
        /*transition: margin-right 1000s ease-out;*/
    }

    .checkbox-right {
        float: right;
        border-radius: 50px;
        border-radius: 10px;
        height : inherit;
        width: 50%;
        background: greenyellow;
        /*transition: float 1000ms;*/
    }
    .fade-enter-active:active, .fade-leave-active {
        transition: left .5s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        left: 50px;
    }

</style>
<script>
    import axios from 'axios';
    export default {
        data() {
            return {
                showSignup: true,
                showsignin: false,
                email: null,
                errors: [],
                password: null,
                userName: null,
                csrf : null
            }
        },
        created() {

        },
        mounted() {

        },
        updated() {

        },
        methods : {

            checkForm: function(e) {

                this.errors = [];

                if(!this.email) {
                    this.errors.push('Не указали Почту');
                }else if (!this.validEmail(email)) {
                    this.errors.push('Адрес электронной почты имеет другой формат.');
                }

                if(!this.password) {
                    this.errors.push('Не указали Пароль');
                }

                this.fetchData();

                e.preventDefault();

            },

            validEmail: function (email) {
                // var regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                var regex =/\s/;

                return regex.test(email);
            },

            fetchData: function() {
                axios
                    .post("/api/signin", {
                        "email" : this.email,
                        "password" : this.password
                    })
                    .then(response => {
                        this.alert(true);

                    })
                    .catch(error => {
                        console.log(error);
                        this.errors.push(error);
                    })
            },
            alert : function(r) {

                this.$emit('showloginchild',r);
            },

        },
        destroyed() {

        }
    }

</script>


