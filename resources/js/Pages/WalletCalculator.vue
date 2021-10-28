<template>
    <div>
        <app-layout ff_bg="true">
            <template>
                <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                    Wallet Value Calculator
                </h1>
            </template>

            <div class="py-2 md:py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div
                        class="bg-white dark:bg-gray-800 overflow-hidden rounded"
                    >
                        <wallet-calculator-app :statistics="statistics" />
                    </div>
                </div>
            </div>
        </app-layout>
    </div>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import WalletCalculatorApp from "../Components/WalletCalculatorApp.vue";

export default {
    components: {
        AppLayout,
        WalletCalculatorApp,
        AppLayout,
    },
    data: () => {
        return {
            statistics: {},
        };
    },
    mounted: function () {
        this.loadStatistics();
    },
    methods: {
        loadStatistics() {
            axios.get(route("api.statistics.all")).then((response) => {
                this.statistics = response.data;
            });
        },
    },
};
</script>
