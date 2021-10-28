<template>
    <app-layout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 mb-12">
            <div id="header">
                <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100">
                    FlareMetrics.io
                </h2>
                <p class="text-gray-600 dark:text-gray-50">
                    The network unlocking value with a total market cap of
                    <span
                        class="
                            text-indigo-700
                            dark:text-indigo-300
                            font-semibold
                        "
                        >{{ market_cap }}</span
                    >, by enabling existing blockchains without smart contracts
                    to utilise this advanced feature through the F-Asset
                    protocol and allowing for the next generation of De-Fi.
                </p>
            </div>
            <network-statistics class="py-3" />

            <div
                class="
                    container
                    mx-auto
                    grid
                    sm:grid-cols-1
                    md:grid-cols-2
                    lg:grid-cols-2
                    xl:grid-cols-2
                    pt-6
                    gap-8
                "
            >
                <!-- Remove class [ h-24 ] when adding a card block -->
                <!-- Remove class [ border-gray-300  dark:border-gray-700 border-dashed border-2 ] to remove dotted border -->
                <div
                    class="
                        pr-4
                        md:border-r md:border-gray-100
                        overflow-x-hidden
                    "
                >
                    <top-data-providers />
                </div>
                <!-- Remove class [ h-24 ] when adding a card block -->
                <!-- Remove class [ border-gray-300  dark:border-gray-700 border-dashed border-2 ] to remove dotted border -->
                <div class="">
                    <ftso-latest-prices />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import NetworkStatistics from "../Components/Home/NetworkStatistics.vue";
import TopDataProviders from "../Components/Home/TopDataProviders.vue";
import FassetLiquidityTable from "../Components/Home/FassetLiquidityTable.vue";
import FtsoLatestPrices from "../Components/Home/FtsoLatestPrices.vue";

export default {
    components: {
        AppLayout,
        NetworkStatistics,
        TopDataProviders,
        FassetLiquidityTable,
        FtsoLatestPrices,
    },
    data() {
        return {
            market_cap: "$TBD",
        };
    },
};
</script>
