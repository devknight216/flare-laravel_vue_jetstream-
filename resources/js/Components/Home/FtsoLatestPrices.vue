<template>
    <div class="sm:max-w-2xl pb-10 rounded-lg">
        <div class="flex justify-between items-center">
            <p
                class="
                    text-xl
                    font-semibold
                    leading-tight
                    text-gray-800
                    dark:text-gray-100
                "
            >
                FTSO Signals
            </p>
            <!-- <div
                class="
                    text-sm text-indigo-700
                    dark:text-indigo-300
                    text-right
                    pr-2
                "
            >
                View All
            </div> -->
        </div>
        <div class="dark:text-gray-300 pt-1">Latest Prices</div>
        <div class="mt-8">
            <div
                class="
                    grid grid-cols-2
                    md:grid-cols-3
                    gap-3
                    md:h-72 md:overflow-y-scroll
                "
            >
                <div
                    v-for="(signal, i) in signals"
                    :key="i"
                    class="w-full p-3"
                    :title="signal.name"
                >
                    <div
                        class="
                            relative
                            rounded-full
                            bg-indigo-50
                            dark:bg-gray-600
                            p-2
                            flex
                            items-center
                        "
                    >
                        <img
                            :src="signal.emblem"
                            :class="getTheme == 'dark' ? 'dark-logo' : ''"
                            class="w-6 h-6"
                            alt=""
                        />
                        <div
                            v-if="signal.price == null"
                            class="
                                animate-pulse
                                bg-indigo-200
                                dark:bg-gray-500
                                rounded-lg
                                w-full
                                h-4
                                mx-3
                            "
                        ></div>
                        <span
                            v-else
                            class="pl-3 dark:text-gray-300 text-indigo-800"
                            >${{
                                parseFloat(signal.price).toLocaleString(
                                    undefined,
                                    {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2,
                                    }
                                )
                            }}</span
                        >
                        <!-- <div class="absolute text-xs">{{ signal.name }}</div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { mapGetters } from "vuex";

export default {
    components: {},
    data() {
        return {
            signals: [
                {
                    emblem: "https://cdn.ftso.com.au/assets/images/token-logos/xrp_64x64.png",
                    address: "0xa1a9b8ab5bb798eee536a23669ad744dcf8537a3",
                    name: "XRP",
                    price: null,
                },
                {
                    emblem: "https://cdn.ftso.com.au/assets/images/token-logos/ltc_64x64.png",
                    address: "0x157d6316475765f13348dfa897c503af0161b232",
                    name: "LTC",
                    price: null,
                },
                {
                    emblem: "https://cdn.ftso.com.au/assets/images/token-logos/xlm_64x64.png",
                    address: "0xdc2cfeee7da8be3eef13b9e05bb4235063d0ecc1",
                    name: "XLM",
                    price: null,
                },
                {
                    emblem: "https://cdn.ftso.com.au/assets/images/token-logos/doge_64x64.png",
                    address: "0xbc696a456e351c8a5f170135868a3850eb29135a",
                    name: "DOGE",
                    price: null,
                },
                {
                    emblem: "https://cdn.ftso.com.au/assets/images/token-logos/ada_64x64.png",
                    address: "0xce7472a48754a2afe34951c6f35f7bfe01bb8fee",
                    name: "ADA",
                    price: null,
                },
                {
                    emblem: "https://cdn.ftso.com.au/assets/images/token-logos/algo_64x64.png",
                    address: "0x2ce1d8653bbca3f636a63e35136f4e015f0b4647",
                    name: "ALGO",
                    price: null,
                },
                {
                    emblem: "https://cdn.ftso.com.au/assets/images/token-logos/bch_64x64.png",
                    address: "0x9dcda46cb0589ec54384801905b2f79b65e93347",
                    name: "BCH",
                    price: null,
                },
                {
                    emblem: "https://cdn.ftso.com.au/assets/images/token-logos/dgb_64x64.png",
                    address: "0xd47b92e53941b7f71aca3cd6235c866c55b4f23a",
                    name: "DGB",
                    price: null,
                },
                {
                    emblem: "https://cdn.ftso.com.au/assets/images/token-logos/btc_64x64.png",
                    address: "0x20fecb7b1ff69c62bba5bb6acd5a9743d11e246f",
                    name: "BTC",
                    price: null,
                },
                {
                    emblem: "https://cdn.ftso.com.au/assets/images/token-logos/eth_64x64.png",
                    address: "0x3c028fe13a87229d5d56a5b234edc0199794684e",
                    name: "ETH",
                    price: null,
                },
                {
                    emblem: "https://cdn.ftso.com.au/assets/images/token-logos/fil_64x64.png",
                    address: "0x71c57de677222f5e9bb3a3134eb27aee8b50bd39",
                    name: "FIL",
                    price: null,
                },
            ],
            ftsos: [
                "0xa1a9b8ab5bb798eee536a23669ad744dcf8537a3",
                "0x157d6316475765f13348dfa897c503af0161b232",
                "0xdc2cfeee7da8be3eef13b9e05bb4235063d0ecc1",
                "0xbc696a456e351c8a5f170135868a3850eb29135a",
                "0xce7472a48754a2afe34951c6f35f7bfe01bb8fee",
                "0x2ce1d8653bbca3f636a63e35136f4e015f0b4647",
                "0x9dcda46cb0589ec54384801905b2f79b65e93347",
                "0xd47b92e53941b7f71aca3cd6235c866c55b4f23a",
                "0x20fecb7b1ff69c62bba5bb6acd5a9743d11e246f",
                "0x3c028fe13a87229d5d56a5b234edc0199794684e",
                "0x71c57de677222f5e9bb3a3134eb27aee8b50bd39",
            ],

            indices: {
                0: "XRP",
                1: "LTC",
                2: "XLM",
                3: "DOGE",
                4: "ADA",
                5: "ALGO",
                6: "BCH",
                7: "DGB",
                8: "BTC",
                9: "ETH",
                10: "FIL",
            },
        };
    },
    mounted: async function () {
        setTimeout(() => {
            this.collectPrices();
        }, 1000);
    },
    computed: {
        ...mapGetters(["getFtsoListWithMetrics", "getTheme"]),
    },
    methods: {
        async collectPrices() {
            this.signals.forEach(async (signal) => {
                signal.price = await this.$store.dispatch(
                    "requestFtsoPrice",
                    signal.address
                );
            });
        },
    },
};
</script>
<style scoped>
.dark-logo {
    filter: grayscale(100%) invert(1) brightness(2);
}
/* .dark-logo {
    filter: invert(1) grayscale(1) brightness(1.5);
} */
</style>
