<template>
    <!--<div class="row">-->
        <!--<input type="checkbox" @click="registration" value="reg">-->
    <!--</div>-->
    <form
        class="form"
        id="myForm"
        action="#"
        @submit="checkForm"
        method="post"
    >
        <div v-if="errors.length">
            <b>Ошибки:</b>
            <ul>
                <li v-for="error in errors">{{ error }}</li>
            </ul>
        </div>
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

        <p id="hui">{{ this.email1 }}</p>



        <div class="sphere"
             @click="alert()">
            <transition name="slide">
                <div
                    v-bind:class="reg"
                ></div>
            </transition>
        </div>
        <!--<input type="hidden" name="token" :value="csrf">-->
    </form>
</template>
<style>
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
        float: left;
        border-radius: 50px;
        border-radius: 10px;
        height : inherit;
        width: 50%;
        background: greenyellow;
        transition: float 1s;
    }
    .checkbox-right {
        float: right;
        border-radius: 50px;
        border-radius: 10px;
        height : inherit;
        width: 50%;
        background: greenyellow;
        transition: float 1s;
    }
    /*.slide-enter-active {*/
        /*float: right;*/
        /*transition: all 3s;*/
    /*}*/
    /*.slide-enter-to {*/
        /*float : right;*/
        /*transform: translateX(50px);*/
    /*}*/

</style>
<script>
    import axios from 'axios';
    export default {
        data() {
            return {
                email1: null,
                email: null,
                errors: [],
                password: null,
                reg: 'checkbox-left'
            }
        },
        created() {

        },
        mounted() {
            // console.log('Component mounted.')
        },
        updated() {

            // console.log(this.email);
            // console.log(this.password);
            // console.log(this.validEmail(email));
            if(this.email && this.password && this.validEmail(email) && this.email1) {

                // console.log("GO!");

            } else {
                // this.errors.push("Не прошли валидацию.")
                // console.log("NO!");
            }
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
                        console.log(response.data[0].email);
                        console.log(response.data);
                        if(response.data != "прошёл в torrent")
                            this.errors.push(response.data);

                        this.email1 = response.data[0].email;
                        return true;
                    })
                    .catch(error => {
                        console.log(error);
                        return false;
                    })
            },
            alert : function() {
                if (this.reg == "checkbox-left") {
                    this.reg = 'checkbox-right';
                } else {
                    this.reg = 'checkbox-left';
                }
                console.log(this.reg);
            }
        }
    }

</script>


