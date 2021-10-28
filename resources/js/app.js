require("./bootstrap");

// Import modules...
import { createApp, h, version } from "vue";
import { createStore } from "vuex";
import { ethers } from "ethers";
import { isMobile } from "mobile-device-detect";
window.isMobile = isMobile;
window.ethers = ethers;
import {
    App as InertiaApp,
    plugin as InertiaPlugin,
} from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";

const el = document.getElementById("app");
var theme = localStorage.getItem("theme");

import { _store } from "./store";
const store = createStore(_store());

async function initWeb3() {
    // Ethers.js Implementation
    window.ethers = ethers;

    // Set Default RPC to Songbird node (19)
    window.provider = new ethers.providers.JsonRpcProvider(store.state.rpc[19]);
    window.signer = window.provider.getSigner();

    // console.log("Provider", window.provider);
    // console.log("Signer", window.signer);
}
initWeb3();
createApp({
    render: () =>
        h(InertiaApp, {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: (name) => require(`./Pages/${name}`).default,
        }),
})
    .mixin({ methods: { route } })
    .use(InertiaPlugin)
    .use(store)
    .mount(el);

InertiaProgress.init({
    color: "#dc5049",
    showSpinner: true,
});

gtag("event", "page_view", {
    page_title: document.title,
});

document.addEventListener("inertia:before", (event) => {
    setTimeout(() => {
        gtag("event", "page_view", {
            page_title: event.target.title,
            page_location: event.target.URL,
        });
    }, 100);
});

// InertiaProgress.on('navigate', (event) => {
//   gtag('event', 'page_view', {
//    'page_location': event.detail.page.url
//   });
// })
