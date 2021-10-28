<template>
    <div>
        <app-layout>
            <template>
                <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                    Bridge Wins
                </h1>
            </template>

            <div class="py-2 md:py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div
                        class="bg-white dark:bg-gray-800 overflow-hidden rounded"
                    >
                        <bridge-wins-app />
                    </div>
                </div>
            </div>
        </app-layout>
    </div>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import BridgeWinsApp from "../Components/FlareTools/BridgeWinsApp.vue";

export default {
    components: {
        AppLayout,
        BridgeWinsApp,
    },
    data: () => {
        return {};
    },
    mounted: function () {},
    methods: {},
};
</script>
