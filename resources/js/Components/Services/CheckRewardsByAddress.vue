<template>
    <div
        class="mt-12 rounded-md bg-gray-50 dark:bg-gray-500 p-3 w-full md:w-2/5"
    >
        <div class="dark:text-gray-200">Check Rewards</div>
        <div class="flex">
            <input
                placeholder="0x..."
                v-model="address"
                class="
                    dark:bg-gray-400
                    border border-gray-200
                    rounded-md
                    w-full
                "
                type="text"
            />
            <div
                @click="checkReward()"
                class="
                    bg-indigo-600
                    dark:bg-indigo-400
                    text-white
                    rounded-md
                    p-3
                    ml-3
                    cursor-pointer
                    select-none
                    text-sm
                    md:text-md
                "
            >
                Check
            </div>
        </div>
        <div v-if="error != ''" class="text-red-600 pt-2">
            {{ error }}
        </div>

        <template v-if="reward != null">
            <div class="text-sm text-gray-400 pt-2 font-semibold">
                Current Rewards
                <span class="text-gray-400 text-sm">(#E{{ epoch }})</span>
            </div>
            <div class="md:flex pt-2 dark:text-gray-200">
                <div v-if="reward[0].length == 0">No Rewards.</div>
                <div
                    class="flex md:justify-center mt-2"
                    v-for="(item, i) in reward[0]"
                    :key="i"
                >
                    <img
                        class="w-6 h-6 mr-2"
                        :src="`https://flaremetrics.io/provider/image/emblem/${item}`"
                        alt=""
                    />
                    <p class="font-bold">Reward:</p>
                    <p class="mx-2">{{ parseNumber(reward[1][i]) }} SGB</p>
                    <span v-if="reward > 0">🎉</span>
                </div>
            </div>
        </template>
        <!-- Previous Epoch Reward -->
        <template v-if="rewardPrevious != null">
            <div class="border-b border-gray-200 py-2"></div>

            <div class="text-sm text-gray-400 pt-2 font-semibold">
                Previous Epoch Rewards
            </div>
            <div class="md:flex pt-2 dark:text-gray-200">
                <div v-if="rewardPrevious[0].length == 0">No Rewards.</div>
                <div
                    class="flex md:justify-center mt-2"
                    v-for="(item, i) in rewardPrevious[0]"
                    :key="i"
                >
                    <img
                        class="w-6 h-6 mr-2"
                        :src="`https://flaremetrics.io/provider/image/emblem/${item}`"
                        alt=""
                    />
                    <p class="font-bold">Reward:</p>
                    <p class="mx-2">
                        {{ parseNumber(rewardPrevious[1][i]) }} SGB
                    </p>
                    <span v-if="rewardPrevious > 0">🎉</span>
                </div>
            </div>
        </template>
    </div>
</template>
<script>
import { mapGetters } from "vuex";

export default {
    components: {},

    data() {
        return {
            address: "",
            reward: null,
            rewardPrevious: null,
            epoch: 0,
            error: "",
        };
    },
    mounted: async function () {
        // this.$store.dispatch("getFtsoWhitelistedPriceProviders");
        this.address = localStorage.checkRewardAddress;
        var ep = await this.$store.dispatch("requestCurrentRewardEpoch");
        console.log((this.epoch = parseInt(ep)));
    },
    computed: {
        ...mapGetters(["ftsoWhitelistedPriceProviders"]),
    },
    methods: {
        parseNumber(input) {
            input = ethers.utils.formatUnits(input);
            return parseFloat(input).toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            });
        },
        async checkReward() {
            this.error = "";
            this.address = this.address.replace(" ", "");
            if (!ethers.utils.isAddress(this.address)) {
                this.error = "Please enter a valid Songbird address.";
                return;
            }
            localStorage.setItem("checkRewardAddress", this.address);

            var rewardManagerAbi = this.$store.state.abi.RewardManager;

            const contractAddress =
                "0xc5738334b972745067fFa666040fdeADc66Cb925";
            const contract = new ethers.Contract(
                contractAddress,
                rewardManagerAbi,
                provider
            );
            var reward;
            try {
                reward = await contract.getStateOfRewards(
                    this.address,
                    this.epoch
                );
            } catch (error) {
                if (error.reason == "Epoch data not available") {
                    console.log(
                        "Epoch data not available for",
                        proivderAddress
                    );
                    reward = 0;
                }
                console.log("Contract Error");
            }
            this.reward = reward;

            // Get Previous Reward
            var rewardPrevious;
            try {
                rewardPrevious = await contract.getStateOfRewards(
                    this.address,
                    this.epoch - 1
                );
            } catch (error) {
                if (error.reason == "Epoch data not available") {
                    console.log(
                        "Epoch data not available for",
                        proivderAddress
                    );
                    rewardPrevious = 0;
                }
                console.log("Contract Error");
            }
            this.rewardPrevious = rewardPrevious;

            return reward;
        },
    },
};
</script>
