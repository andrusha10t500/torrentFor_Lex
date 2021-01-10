<template>
    <!--<div class="row">-->
        <!--<input type="checkbox" @click="registration" value="reg">-->
    <!--</div>-->
    <!--Форма авторизации-->
    <form
        class="form-group"
        id="myForm"
        action="#"
        @submit="checkForm"
        method="post"
        v-if="show_signin"
    >

        <!--Блок ошибок-->
        <div v-if="errors.length">
            <b>Ошибки:</b>
            <ul>
                <li v-for="error in errors">{{ error }}</li>
            </ul>
        </div>
        <!--Блок ошибок-->
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

        <p id="hui">{{ this.show_signin }}</p>

        <div class="sphere">
                <div
                    v-bind:class="reg"
                ></div>
        </div>

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
                show_signin: true,
                email: null,
                errors: [],
                password: null,
                reg: 'checkbox-left',
                csrf : null
            }
        },
        created() {
            // this.fSignIn();
        },
        mounted() {
            // console.log('Component mounted.')
        },
        updated() {

            // console.log(this.email);
            // console.log(this.password);
            // console.log(this.validEmail(email));
            // if(this.email && this.password && this.validEmail(email) && this.show_signin) {

                // console.log("GO!");

            // } else {
                // this.errors.push("Не прошли валидацию.")
                // console.log("NO!");
            // }
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

                console.log(this.fetchData());

                e.preventDefault();

            },

            validEmail: function (email) {
                // var regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                var regex = /\s/;

                return regex.test(email);
            },

            fetchData: function() {
                axios
                    .post("/api/signin", {
                       "email" : this.email,
                       "password" : this.password
                    })
                    .then(response => {
                        // console.log(response.data[0].email);
                        console.log(response.data);
                        if(response.data != "прошёл в torrent")
                            this.errors.push(response.data.data);

                        this.show_signin = false;
                    })
                    .catch(error => {
                        console.log(error);
                        this.errors.push(error);
                    })
            },
            alert : function() {
                // if (this.reg == "checkbox-left") {
                //     this.reg = 'checkbox-right';
                // } else {
                //     this.reg = 'checkbox-left';
                // }
                console.log(this.reg);
            },

        },
        destroyed() {

        }
    }

</script>


