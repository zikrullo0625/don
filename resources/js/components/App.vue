<script>
import axios from 'axios'

export default {
    data() {
        return {
            news: [], // Массив, так как это список новостей
        };
    },
    beforeMount() {
        this.getNews()
    },
    methods: {
        getNews() {
            axios.get("/api/news")
                .then(response => {
                    this.news = response.data; // Присваиваем данные из ответа
                })
                .catch(error => {
                    console.error("Ошибка при получении новостей:", error);
                });
        },
    },
};
</script>


<template>
    <h1 class="text-lg-center py-2">News</h1>
    <div class="container table-responsive py-1">
        <table class="table table-bordered table-hover">
            <thead>
            <tr class="bgblack">
                <th scope="col">ID</th>
                <th scope="col">Title</th>
                <th scope="col">Link</th>
                <th scope="col">Source</th>
            </tr>
            </thead>
            <tbody v-for="data in news">
            <tr>
                <th scope="row">{{data.id}}</th>
                <td>{{data.title}}</td>
                <td><a :href="data.link" target="_blank">{{ data.link }}</a></td>
                <td><a :href="data.source" target="_blank">{{ data.source }}</a></td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<style scoped>
.bgblack{
    background-color: #4b5563 !important;
}
</style>
