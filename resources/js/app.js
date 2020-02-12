/*jslint node: true */
"use strict";

require('./bootstrap');
require("popper.js");


import App from "./components/App.svelte";

const app = new App({
    target: document.body
});

window.app = app;

window.API_ROUTES = {
    "login": "/api/auth/login",
    "tokeninfo": "/api/auth/info?token=",
    "changepassword": "/api/auth/changepassword",
    "logout": "/api/auth/logout",

    "post": "/api/post/view/",
    "createpost": "/api/post/create",
};

setInterval(() => {

    if(window.location.href.includes("login")) {
        return;
    }

    if(localStorage.getItem("token") === null || localStorage.getItem("token").length !== 128) {
        window.location.href = "/login";
    }

   fetch("/api/auth/info?token=" + localStorage.getItem("token"))
       .then((data) => {
           if(data.status === 401) {
               window.location.href = "/login";
           }
       });
}, 1500);

export default app;

