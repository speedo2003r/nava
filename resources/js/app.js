require("./bootstrap");
window.Vue = require("vue");

var Lang = localStorage.getItem("lang") != null ? localStorage.getItem("lang") : "ar";
window.Lang = Lang;

// moment
var moment = require("moment");
Lang == "ar" ? moment.locale("ar") : moment.locale("en");
Vue.use(require("vue-moment"), {
    moment
});

window.Origin = window.location.origin;

// vue resource
var VueResource = require("vue-resource");
Vue.use(VueResource);
Vue.http.headers.common["X-CSRF-TOKEN"] = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");


// loader
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
window.Loading = Loading;

import VueChatScroll from "vue-chat-scroll";
Vue.use(VueChatScroll);

///////////////////// socket /////////////////////////
// var WS_URL = 'https://navaservices.net:4321';
var USER_ID = Number($("meta[name=user_id]").attr("content"));
window.USER_ID = USER_ID;
// components
const files = require.context("./", true, /\.vue$/i);
files.keys().map(key =>Vue.component(key.split("/").pop().split(".")[0],files(key).default));

const app = new Vue({
    el: "#app",

});

