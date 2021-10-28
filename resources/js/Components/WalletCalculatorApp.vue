<template>
    <div>
        <div class="grid grid-cols-2 dark:text-gray-50 mb-2">
            <div
                class="w-full col-span-2 font-bold bg-gray-100 dark:bg-gray-600"
            >
                <div class="ml-6 my-6">Wallet Value Calculator</div>
            </div>
            <div class="col-span-2 lg:col-span-1">
                <div class="ml-6 mt-4 font-bold">Tokens</div>
                <div class="grid grid-cols-2 text-sm px-6">
                    <!-- Col 1 -->
                    <div class="col-span-2 md:col-span-1">
                        <div class="my-2 mr-2">
                            <div>
                                <div
                                    class="font-semibold text-gray-600 dark:text-gray-300"
                                >
                                    YFIN
                                </div>
                                <input
                                    v-model="tokens.yfin"
                                    class="text-sm h-8 dark:text-gray-600 rounded w-full"
                                    type="number"
                                    inputmode="decimal"
                                />
                            </div>
                            <div class="my-2">
                                <div
                                    class="font-semibold text-gray-600 dark:text-gray-300"
                                >
                                    YFLR
                                </div>
                                <input
                                    v-model="tokens.yflr"
                                    class="text-sm h-8 rounded w-full dark:text-gray-600"
                                    type="number"
                                    inputmode="decimal"
                                />
                            </div>
                            <div class="my-2">
                                <div
                                    class="font-semibold text-gray-600 dark:text-gray-300"
                                >
                                    FXRP
                                </div>
                                <input
                                    v-model="tokens.fxrp"
                                    class="text-sm h-8 rounded w-full dark:text-gray-600"
                                    type="number"
                                    inputmode="decimal"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Col 2 -->
                    <div class="col-span-2 md:col-span-1">
                        <div class="font-bold"></div>
                        <div class="my-2 mr-2">
                            <div>
                                <div
                                    class="font-semibold text-gray-600 dark:text-gray-300"
                                >
                                    FLTC
                                </div>
                                <input
                                    v-model="tokens.fltc"
                                    class="text-sm h-8 dark:text-gray-600 rounded w-full"
                                    type="number"
                                    inputmode="decimal"
                                />
                            </div>
                            <div class="my-2">
                                <div
                                    class="font-semibold text-gray-600 dark:text-gray-300"
                                >
                                    YDOGE
                                </div>
                                <input
                                    v-model="tokens.fdoge"
                                    class="text-sm h-8 rounded w-full dark:text-gray-600"
                                    type="number"
                                    inputmode="decimal"
                                />
                            </div>
                            <div class="my-2">
                                <div
                                    class="font-semibold text-gray-600 dark:text-gray-300"
                                >
                                    XUSD
                                </div>
                                <input
                                    v-model="tokens.xusd"
                                    class="text-sm h-8 rounded w-full dark:text-gray-600"
                                    type="number"
                                    inputmode="decimal"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1 mx-3">
                <div class="ml-4 mt-4 font-bold">Breakdown</div>

                <div class="w-full px-5 mt-6 select-none">
                    <!-- Log -->
                    <div class="col-span-1">
                        <table class="text-xs md:text-base">
                            <tr>
                                <th class="text-left w-36 pr-3">YFIN</th>
                                <th class="w-64 px-3">YFLR</th>
                                <th class="w-64 px-3">FXRP</th>
                                <th class="w-64 px-3">FLTC</th>
                                <th class="w-64 px-3">FDOGE</th>
                                <th class="w-64 px-3">XUSD</th>
                            </tr>
                            <tr class="text-center">
                                <td class="text-left">
                                    ${{
                                        calculateTokenTotal("yfin", tokens.yfin)
                                    }}
                                </td>
                                <td>
                                    ${{
                                        calculateTokenTotal("yflr", tokens.yflr)
                                    }}
                                </td>
                                <td>
                                    ${{
                                        calculateTokenTotal("fxrp", tokens.fxrp)
                                    }}
                                </td>
                                <td>
                                    ${{
                                        calculateTokenTotal("fltc", tokens.fltc)
                                    }}
                                </td>
                                <td>
                                    ${{
                                        calculateTokenTotal(
                                            "fdoge",
                                            tokens.fdoge
                                        )
                                    }}
                                </td>
                                <td>
                                    ${{
                                        calculateTokenTotal("xusd", tokens.xusd)
                                    }}
                                </td>
                            </tr>
                        </table>
                        <div
                            class="my-4 border border-t border-gray-100 dark:border-gray-50"
                        ></div>
                        Total Wallet Value: ${{
                            calculateWalletTotal().toFixed(2)
                        }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        statistics: {
            required: true,
        },
    },
    data: () => {
        return {
            tokens: {
                yfin: 0,
                yflr: 0,
                fxrp: 0,
                fltc: 0,
                fdoge: 0,
                xusd: 0,
            },
            price: {
                yfin: 0,
                yflr: 0,
                fxrp: 0,
                fltc: 0,
                fdoge: 0,
                xusd: 1,
            },
        };
    },
    watch: {
        statistics() {
            this.sortData();
        },
    },
    mounted: function () {},
    methods: {
        calculateTokenTotal(token, quantity) {
            return (this.price[token] * quantity).toFixed(2);
        },
        calculateWalletTotal() {
            var total = 0;
            for (const [key, value] of Object.entries(this.tokens)) {
                total += parseFloat(this.calculateTokenTotal(key, value));
            }
            return total;
        },
        sortData() {
            for (const [key, value] of Object.entries(this.$props.statistics)) {
                var token = key.split("-");
                if (token[1] == "xusd") {
                    var price = parseFloat(value.latest_price.price);
                    this.price[token[0]] = price;
                }
            }
        },
        save() {},
        load() {},
    },
};
</script>
<style scoped></style>
