require('./bootstrap');
require('./vendor/livewire-charts/app');

import Alpine from 'alpinejs';
import autosize from "autosize/dist/autosize";
import ClipboardJS from "clipboard";

window.Alpine = Alpine;

Alpine.start();

autosize(document.querySelectorAll('textarea'));

new ClipboardJS('.copy-paste');

if ("serviceWorker" in navigator) {
    window.addEventListener("load", function() {
        navigator.serviceWorker
            .register("/_service-worker.js")
            .then(res => console.log("service worker registered"))
            .catch(err => console.log("service worker not registered", err))
    })
}
