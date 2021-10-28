<template>
    <div>
        <app-layout ff_bg="true">
            <template>
                <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                    Daily Yield Calculator
                </h1>
            </template>

            <div class="py-2 md:py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div
                        class="
                            bg-white
                            dark:bg-gray-800
                            overflow-hidden
                            rounded
                        "
                    >
                        <daily-yield-calculator-app />
                    </div>
                </div>
            </div>
        </app-layout>
    </div>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import DailyYieldCalculatorApp from "../Components/DailyYieldCalculatorApp.vue";

export default {
    components: {
        AppLayout,
        DailyYieldCalculatorApp,
        AppLayout,
    },
    mounted: function () {
        if (document.title != "FF Yield Calculator | FlareMetrics") {
            document.title = "FF Yield Calculator | FlareMetrics";
        }
    },
};
</script>
