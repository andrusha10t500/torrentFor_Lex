<template>
    <!--Форма ввода-->
    <form
            class="form-group"
            @submit="sendTorrent"
            method="post"
    >

        <input type="hidden" name="token" :value="csrf">
        <input
                class="form-control"
                type="text"
                v-model="input_torrent_text"
                placeholder="вставьте ссылку"
                name="input_torrent_text"
                id="input_torrent_text"
        >

        <input type="hidden" name="token" :value="csrf">
        <input type="submit" value="добавить">
    </form>

    <!--Форма ввода конец-->
</template>

<script>
    import axios from 'axios';
    export default {
        data() {
            return {
                input_torrent_text : null,
                input_torrent_file : null,
                show_form_insert: true,
                errors : [],
                csrf: null
            }
        },
        created() {

        },
        methods : {
            sendTorrent: function (e) {

                axios
                    .post("/sendtorrent", {
                        "torrent" : this.input_torrent_text
                    })
                    .then(response => {
                        console.log(response.data.data);
                        location.reload();
                        // store.commit('reloadF');
                    })
                    .catch(error => {

                        this.errors.push(error);
                    })

                e.preventDefault();
            },
            FileUpload : function() {
                this.input_torrent_file=this.$refs.file_torrent.files[0];
            },
            deleteTorrent : function() {

            }

        }
    }
</script>

<style scoped>

</style>
