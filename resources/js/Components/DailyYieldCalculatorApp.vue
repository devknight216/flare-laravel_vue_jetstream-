<template>
    <div>
        <div class="grid grid-cols-2 dark:text-gray-50">
            <div
                class="w-full col-span-2 font-bold bg-gray-100 dark:bg-gray-600"
            >
                <div class="ml-6 my-6">Daily Yield Calculator</div>
            </div>
            <div class="col-span-2 lg:col-span-1">
                <div class="grid grid-cols-2 text-sm p-6">
                    <!-- Col 1 -->
                    <div class="col-span-2 md:col-span-1">
                        <div class="font-bold">Pool Share</div>
                        <div class="my-2 mr-2">
                            <div>
                                <div
                                    class="font-semibold text-gray-600 dark:text-gray-300"
                                >
                                    Your Stake
                                    <span class="text-gray-300 font-bold"
                                        >(a)</span
                                    >
                                </div>
                                <input
                                    v-model="stake"
                                    class="text-sm h-8 dark:text-gray-600 rounded w-full"
                                    id="staked"
                                    type="number"
                                    inputmode="decimal"
                                />
                            </div>
                            <div class="my-2">
                                <div
                                    class="font-semibold text-gray-600 dark:text-gray-300"
                                >
                                    Pool Total Stake
                                    <span class="text-gray-300 font-bold"
                                        >(b)</span
                                    >
                                </div>
                                <input
                                    v-model="pool_stake"
                                    class="text-sm h-8 rounded w-full dark:text-gray-600"
                                    id="pool-total-staked"
                                    type="number"
                                    inputmode="decimal"
                                />
                            </div>
                        </div>
                        <div
                            class="font-bold text-base my-2 text-gray-500 dark:text-gray-400"
                        >
                            =
                            <span>{{ calculatePoolShare().toFixed(8) }} </span>
                        </div>
                        <div class="font-bold text-base my-2">
                            =
                            <span
                                >{{ calculatePoolShare(true).toFixed(4) }}% Pool
                                Share
                            </span>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div
                        class="lg:hidden col-span-2 border-t border-gray-100 my-4"
                    ></div>

                    <!-- Col 2 -->
                    <div class="col-span-2 md:col-span-1">
                        <div class="font-bold">YFIN Daily Yield</div>

                        <div class="my-2">
                            <div
                                class="font-semibold text-gray-600 dark:text-gray-300"
                            >
                                Pool Reward Rate
                                <span class="text-gray-300 font-bold">(c)</span>
                            </div>
                            <input
                                v-model="reward_rate"
                                class="text-sm h-8 rounded w-full dark:text-gray-600"
                                id="reward-rate"
                                type="number"
                                inputmode="decimal"
                            />
                        </div>
                        <div class="my-2">
                            <div
                                class="font-semibold text-gray-600 dark:text-gray-300"
                            >
                                Your Pool Share
                            </div>
                            <input
                                v-model="pool_share"
                                class="text-sm h-8 rounded w-full dark:text-gray-600"
                                id="pool-share"
                                type="number"
                                inputmode="decimal"
                            />
                        </div>

                        <div
                            class="font-bold text-base my-2 text-gray-500 dark:text-gray-400"
                        >
                            = <span>{{ calculateYield().toFixed(8) }}</span>
                        </div>
                        <div class="font-bold text-base my-2">
                            =
                            <span
                                >{{ calculateYield().toFixed(4) }} YFIN
                                Daily</span
                            >
                        </div>
                        <div
                            @click="clear()"
                            class="text-indigo-700 dark:text-ff-red mt-4 hover:underline"
                        >
                            Clear
                        </div>
                    </div>

                    <div
                        class="col-span-2 rounded bg-gray-100 dark:bg-gray-600 mt-6"
                    >
                        <p class="mt-4 pl-4 font-bold">Pool Share Forumla</p>
                        <p class="pb-3 pl-4">
                            Your Stake / Pool Total Stake = <i>Pool Share</i>
                        </p>
                        <p class="mt-4 pl-4 font-bold">YFIN Daily Formula</p>
                        <p class="pb-3 pl-4">
                            Pool Reward Rate * Your Pool Share =
                            <i>YFIN / day</i>
                        </p>
                    </div>
                </div>
            </div>
            <div class="hidden lg:block col-span-1">
                <div class="w-full pt-6 px-16 select-none">
                    <img class="drag" src="/images/pool-example.png" alt="" />
                </div>
            </div>
            <!-- Log -->
            <!-- <div class="col-span-1 p-6">
        <div class="font-bold mb-6">Calculator Log</div>
        <table>
          <tr>
            <th class="text-left w-36 pr-3">Pool</th>
            <th class="w-64 px-3">Your Stake</th>
            <th class="w-64 px-3">Pool Stake</th>
            <th class="w-64 px-3">Reward Rate</th>
            <th class="w-64 px-3">Pool Share</th>
          </tr>
          <tr class="text-center">
            <td class="text-left">January</td>
            <td>$100</td>
            <td>$100</td>
            <td>$100</td>
            <td>$100</td>
          </tr>
        </table>
      </div> -->
        </div>
    </div>
</template>

<script>
export default {
    data: () => {
        return {
            stake: 0,
            pool_stake: 0,
            reward_rate: 0,
            pool_share: 0,

            user_pool_share: 0,
            user_yfin_yield: 0,
        };
    },
    mounted: function () {
        if (localStorage.getItem("saved")) {
            this.load();
        }
    },
    methods: {
        calculatePoolShare(percentage) {
            if (this.stake == 0 || this.pool_stake == 0) {
                return 0.0;
            }
            var result = this.stake / this.pool_stake;
            this.pool_share = result;
            this.user_pool_share = result;
            this.save();
            if (percentage) {
                return result * 100;
            }
            return result;
        },
        calculateYield() {
            if (this.reward_rate == 0 || this.pool_share == 0) {
                return 0.0;
            }
            var result = this.reward_rate * this.user_pool_share;
            this.user_yfin_yield = result;
            this.save();
            return result;
        },
        save() {
            localStorage.setItem("saved", true);
            localStorage.setItem("stake", this.stake);
            localStorage.setItem("pool_stake", this.pool_stake);
            localStorage.setItem("reward_rate", this.reward_rate);
            localStorage.setItem("pool_share", this.pool_share);

            localStorage.setItem("user_pool_share", this.user_pool_share);
            localStorage.setItem("user_yfin_yield", this.user_yfin_yield);
        },
        load() {
            this.stake = localStorage.getItem("stake");
            this.pool_stake = localStorage.getItem("pool_stake");
            this.reward_rate = localStorage.getItem("reward_rate");
            this.pool_share = localStorage.getItem("pool_share");

            this.user_pool_share = localStorage.getItem("user_pool_share");
            this.user_yfin_yield = localStorage.getItem("user_yfin_yield");
        },
        clear() {
            localStorage.clear();
            this.stake = 0;
            this.pool_stake = 0;
            this.reward_rate = 0;
            this.pool_share = 0;

            this.user_pool_share = 0;
            this.user_yfin_yield = 0;
        },
    },
};
</script>
<style scoped>
.drag {
    user-drag: none;
    user-select: none;
    -moz-user-select: none;
    -webkit-user-drag: none;
    -webkit-user-select: none;
    -ms-user-select: none;
}
</style>
