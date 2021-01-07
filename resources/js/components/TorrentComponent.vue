<template>
    <table class="table table-bordered table-dark">
        <thead>
            <tr>
                <th>№</th>
                <th>дата</th>
                <th>торрент</th>
                <th>пользователь</th>
                <th>загружено</th>
                <th>когда загружено</th>
            </tr>
        </thead>
        <tbody v-for="torrent in torrents">
            <tr>
                <td>
                   {{ torrent['id'] }}
                </td>
                <td>
                    {{ torrent['created_at'] }}
                </td>
                <td>
                    <a v-bind:href="torrent['torrent']">{{ torrent['torrent'] }}</a>

                </td>
                <td>
                    {{ torrent['user'] }}
                </td>
                <td>
                    {{ torrent['download'] }}
                </td>
                <td>
                    {{ torrent['when_downloaded'] }}
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    import axios from 'axios';
    export default {
        data() {
            return {
                torrents : [],
                errors: []
            }

        },
        created() {
            axios
                .get('/routeTorrentController')
                .then(response => {
                    this.torrents = response.data.data;
                })
                .catch(error => {
                    this.errors.push(error);
                })
        }
    }
</script>

<style scoped>

</style>