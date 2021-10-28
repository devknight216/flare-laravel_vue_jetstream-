<template>
    <div>
        <div class="grid grid-cols-2 dark:text-gray-50 mb-2">
            <div
                class="w-full col-span-2 font-bold bg-gray-100 dark:bg-gray-600"
            >
                <div class="ml-6 my-6">Bridge Game Wins</div>
                <div class="grid grid-cols-2">
                    <div class="mx-6 col-span-2">
                        <div class="text-sm font-semibold">
                            Enter Wallet Address:
                        </div>
                        <div class="flex">
                            <input
                                v-model="wallet_address"
                                class="text-sm h-8 dark:text-gray-600 rounded w-full"
                                type="text"
                            />
                            <div
                                @click="checkWins()"
                                class="h-full bg-ff-red my-auto ml-2 py-1 px-3 text-white rounded cursor-pointer hover:opacity-75"
                            >
                                Check
                            </div>
                        </div>

                        <div v-if="first_load" class="my-2">
                            Enter your wallet address then click 'check'.
                        </div>
                        <div v-else class="my-2 flex">
                            <span>Wins:</span>
                            <div v-if="loading">
                                <img
                                    class="h-4 mt-1 ml-2 animate-spin"
                                    src="/images/icons/loading.svg"
                                    alt="Loading"
                                />
                            </div>
                            <div class="ml-2" v-else>{{ wins }}</div>
                        </div>
                        <div class="my-2" v-if="message.error">
                            <span class="text-sm text-red-600">{{
                                message.text
                            }}</span>
                        </div>
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
            loading: false,
            first_load: true,
            wallet_address: "",
            wins: 0,

            message: {
                error: false,
                text: "",
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
        checkWins() {
            if (this.wallet_address.length == 0) {
                return;
            }
            this.loading = true;
            this.first_load = false;

            axios
                .get(
                    route("api.flare.bridgeWins", {
                        wallet: this.wallet_address,
                    })
                )
                .then((response) => {
                    console.log(response.data);
                    this.wins = response.data.wins;
                    this.loading = false;
                })
                .catch((error) => {
                    this.loading = false;
                    this.first_load = true;
                    this.message.error = true;
                    this.message.text =
                        "Please check the address and try again.";
                });
        },
    },
};
</script>
<style scoped></style>
