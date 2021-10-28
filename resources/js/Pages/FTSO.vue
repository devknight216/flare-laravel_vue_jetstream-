<template>
    <app-layout :hide_bg="true">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 mb-12">
            <div id="header" class="mt-4 mb-3">
                <h1
                    class="
                        font-lato font-bold
                        text-gray-800
                        dark:text-gray-200
                        text-xl
                    "
                >
                    Flare FTSO List
                </h1>
                <p class="text-gray-600 text-sm dark:text-white">
                    There are currently
                    <span
                        class="
                            text-indigo-700
                            dark:text-indigo-200
                            font-semibold
                        "
                        >{{ provider_count }} public signal providers</span
                    >
                    submitting data to Flare Networks.
                </p>
            </div>
            <ftso-list :isDark="isDark()" />
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import FtsoList from "../Components/FTSO/FtsoList.vue";
import { mapGetters } from "vuex";

export default {
    props: ["provider_count", "provider_verified_count"],
    components: {
        AppLayout,
        FtsoList,
    },

    data() {
        return {};
    },
    mounted: async function () {
        // this.$store.dispatch("getFtsoWhitelistedPriceProviders");
    },
    computed: {
        ...mapGetters(["ftsoWhitelistedPriceProviders"]),
    },
    methods: {
        isDark() {
            return localStorage.getItem("theme") == "dark";
        },
    },
};
</script>
<style scoped>
.list-height {
    max-height: 650px;
}
</style>
