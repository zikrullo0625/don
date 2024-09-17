import "./bootstrap";
import { createApp } from "vue";
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'bootstrap/dist/css/bootstrap.css'
import App from "./components/App.vue";

const app = createApp({})

app.component('app', App)

createApp(App).mount("#app");
