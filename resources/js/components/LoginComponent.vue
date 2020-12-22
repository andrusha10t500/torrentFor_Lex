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

        <input type="checkbox" @click="registration" v-bind:value="reg">

    </form>
</template>

<script>
    import axios from 'axios';
    export default {
        data() {
            return {
                email1: null,
                email: null,
                errors: [],
                password: null,
                reg: null
            }
        },
        created() {

        },
        mounted() {
            console.log('Component mounted.')
        },
        updated() {
            console.log(this.email1);
            console.log(this.email);
            console.log(this.password);
            console.log(this.validEmail(email));
            if(this.email && this.password && this.validEmail(email) && this.email1) {

                console.log("GO!");
            } else {
                console.log("NO!");
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
                       "email" : this.email
                    })
                    .then(response => {
                        // console.log(response.data[0].email);
                        this.email1 = response.data[0].email;
                        return true;
                    })
                    .catch(error => {
                        console.log(error);
                        return false;
                    })
            },

            registration : function() {
                // if (reg == true) {
                //     reg = false;
                // } else {
                //     reg = true;
                // }
                alert(reg);
            }
        }
    }

</script>
