<template>
    <div class="min-h-screen relative bg-gradient-to-b from-white to-gray-50">
        <div id="header">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-14">
                <div class="py-4 grid grid-cols-12 gap-3">
                    <div id="logo" class="col-span-6">
                        <img
                            class="h-6 mt-2"
                            src="/images/flaremetrics-logo-sm.png"
                            alt=""
                        />
                    </div>
                    <div
                        id="actions"
                        class="col-span-6 flex justify-end my-auto"
                    >
                        <div
                            @click="login()"
                            class="
                                mx-5
                                font-lato
                                text-indigo-700
                                flex
                                cursor-pointer
                            "
                        >
                            Login
                        </div>
                        <div
                            @click="register()"
                            class="
                                mx-5
                                font-lato
                                text-indigo-700
                                flex
                                cursor-pointer
                            "
                        >
                            Register
                        </div>
                    </div>
                </div>

                <div id="content" class="">
                    <div class="mt-8 mb-12">
                        <h1 class="font-lato font-thin text-5xl">
                            <span>FlareMetrics.io</span>
                        </h1>
                        <h2 class="font-lato mt-2">
                            Accelerating the growth of the community.
                        </h2>
                    </div>

                    <h3 class="font-lato font-thin text-4xl text-gray-600 mb-6">
                        Our Solutions
                    </h3>
                    <div class="grid grid-cols-12 md:gap-12">
                        <feature-product
                            title="FTSO Data Provider List"
                            subtitle="Flare Networks"
                            image="/images/home/ftso.svg"
                            :href="route('view.ftso')"
                            class="col-span-12 md:col-span-6 my-6"
                        >
                            Find all Flare Time Series Oracles data providers in
                            one place with genuine information and official
                            links to help guide you safely to your decision when
                            choosing an FTSO provider.
                        </feature-product>

                        <!-- Wallet Calc -->
                        <!-- <feature-product
                            title="Wallet Calculator"
                            subtitle="Flare Finance"
                            image="/images/home/wallet-calculator.svg"
                            :href="route('view.wallet-calculator')"
                            class="col-span-12 md:col-span-6 my-6"
                        >
                            We run the numbers for you to get the value of your
                            wallet in minutes rather than manually adding up
                            each token. Quicker. Easier.
                        </feature-product> -->
                        <!-- Yield Calc -->
                        <!-- <feature-product
                            title="Yield Calculator"
                            subtitle="Flare Finance"
                            image="/images/home/yield-calculator.svg"
                            :href="route('view.yield-calculator')"
                            class="col-span-12 md:col-span-6 my-6"
                        >
                            Find out how much you could earn from staking in
                            each Flare Finance pool instantly to give you a
                            competitive edge when choosing which pool to invest
                            your tokens into.
                        </feature-product> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import FeatureProduct from "../Components/Home/FeatureProduct.vue";

export default {
    components: { FeatureProduct },

    data() {
        return {};
    },
    mounted: function () {},
    methods: {
        isDark() {
            return localStorage.getItem("theme") == "dark";
        },
        register() {
            return this.$inertia.get(route("register"));
        },
        login() {
            return this.$inertia.get(route("login"));
        },
    },
};
</script>
<style scoped></style>
