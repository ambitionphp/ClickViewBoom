require('./bootstrap');

import Alpine from 'alpinejs';
import autosize from "autosize/dist/autosize";
import ClipboardJS from "clipboard";

window.Alpine = Alpine;

Alpine.start();

autosize(document.querySelectorAll('textarea'));

new ClipboardJS('.copy-paste');

