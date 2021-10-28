<template>
    <div class="w-full sm:max-w-2xl bg-white dark:bg-gray-800 pb-10 rounded-lg">
        <p
            class="
                text-xl
                font-semibold
                leading-tight
                text-gray-800
                dark:text-gray-100
            "
        >
            F-Assets
        </p>

        <div class="w-full mt-6 overflow-x-scroll sm:overflow-x-auto">
            <table class="w-full">
                <thead
                    class="
                        text-xs
                        sm:text-base
                        font-medium
                        leading-none
                        text-gray-500
                        dark:text-gray-400
                    "
                >
                    <tr class="border-b border-gray-200">
                        <td class="pb-4">Name</td>
                        <td class="pb-4 pl-4">Liquidity</td>
                        <td class="pl-14 pb-4">Agents</td>
                        <td class="pl-14 pb-4">Price</td>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(item, i) in items"
                        :key="i"
                        class="
                            text-xs
                            sm:text-base
                            leading-none
                            text-gray-800
                            dark:text-gray-100
                        "
                    >
                        <td class="pt-6">
                            <div class="flex items-center">
                                <div
                                    class="
                                        w-8
                                        h-8
                                        flex
                                        items-center
                                        justify-center
                                    "
                                >
                                    <img
                                        class="h-7 w-7"
                                        :src="item.logo"
                                        alt=""
                                    />
                                </div>
                                <p class="ml-3">{{ item.name }}</p>
                            </div>
                        </td>
                        <td class="pt-6 pl-4">{{ item.liquidity }}</td>
                        <td class="pt-6 pl-14">{{ item.agents }}</td>
                        <td class="pt-6 pl-14">{{ item.price }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
export default {
    components: {},
    data() {
        return {
            items: [
                {
                    logo: "https://cdn.ftso.com.au/assets/images/token-logos/xrp_64x64.png",
                    name: "F-XRP",
                    liquidity: "23.3m FLR",
                    agents: "69",
                    price: "$1.08",
                },
                {
                    logo: "https://cdn.ftso.com.au/assets/images/token-logos/doge_64x64.png",
                    name: "F-DOGE",
                    liquidity: "21.8m FLR",
                    agents: "72",
                    price: "$0.271",
                },
                {
                    logo: "https://cdn.ftso.com.au/assets/images/token-logos/ltc_64x64.png",
                    name: "F-LTC",
                    liquidity: "17.1m FLR",
                    agents: "67",
                    price: "$168.52",
                },
                {
                    logo: "https://cdn.ftso.com.au/assets/images/token-logos/ada_64x64.png",
                    name: "F-ADA",
                    liquidity: "17.0m FLR",
                    agents: "83",
                    price: "$2.56",
                },
                {
                    logo: "https://cdn.ftso.com.au/assets/images/token-logos/bch_64x64.png",
                    name: "F-BCH",
                    liquidity: "16.8m FLR",
                    agents: "73",
                    price: "$610.23",
                },
            ],
        };
    },
};
</script>
