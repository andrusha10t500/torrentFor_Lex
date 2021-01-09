<template>
    <!--Форма ввода-->
    <form
            class="form-group"
            action="#"
            @submit="send_torrent"
            method="post"
            v-if="show_form_insert"
    >
        <input type="hidden" name="token" :value="csrf">
        <input
                class="form-control"
                type="text"
                v-model="input_torrent_text"
                placeholder="вставьте ссылку"
                name="link_torrent"
                id="link_torrent"
        >
        <!--<input-->
        <!--class="form-control"-->
        <!--type="file"-->
        <!--placeholder="выберите файл"-->
        <!--name="file_torrent"-->
        <!--ref="file_torrent"-->
        <!--v-on:change="FileUpload()"-->
        <!--&gt;-->
        <input type="submit" value="добавить">
    </form>

    <!--Форма ввода конец-->
</template>

<script>
    export default {
        data() {
            return {
                input_torrent_text : null,
                input_torrent_file : null,
                show_form_insert: true,
                errors : []
            }
        },
        created() {

        },
        methods : {
            send_torrent: function () {
                // var input_return;

                // if(this.input_torrent_file == null) {
                //     input_return = this.input_torrent_text;
                // } else {
                //     let form = new FormData();
                //     form.append('file',this.input_torrent_file);
                //     input_return=form;
                // }

                axios
                    .post("/sendtorrent", {
                        "torrent" : this.input_torrent_text
                    })
                    .then(response => {
                        console.log(response.data);
                    })
                    .catch(error => {
                        this.errors.push(error);
                    })
            },
            FileUpload : function() {
                this.input_torrent_file=this.$refs.file_torrent.files[0];
            }
        }
    }
</script>

<style scoped>

</style>