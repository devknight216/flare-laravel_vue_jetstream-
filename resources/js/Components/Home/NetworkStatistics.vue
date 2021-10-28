<template>
    <div class="flex justify-center md:px-0">
        <div class="relative w-full py-6">
            <div class="flex items-center">
                <p
                    class="
                        text-xl
                        font-semibold
                        leading-tight
                        text-gray-800
                        dark:text-gray-100
                    "
                >
                    Statistics
                </p>
            </div>
            <div
                class="
                    grid grid-cols-2
                    md:grid-cols-4
                    items-center
                    justify-between
                    pt-8
                    gap-2
                "
            >
                <div
                    v-for="(metric, i) in metrics()"
                    :key="i"
                    class="
                        relative
                        h-20
                        w-full
                        bg-indigo-50
                        dark:bg-gray-600 dark:border dark:border-gray-500
                        rounded-md
                    "
                >
                    <div>
                        <div
                            class="
                                p-1
                                text-gray-800
                                dark:text-gray-300
                                font-bold
                                md:text-sm
                                text-xs
                            "
                        >
                            {{ metric.name }}
                        </div>
                        <div
                            class="
                                absolute
                                bottom-0
                                right-0
                                md:text-3xl
                                text-2xl
                                pr-2
                                text-indigo-600
                                dark:text-gray-300
                            "
                        >
                            <div
                                v-if="metric.value == null"
                                class="
                                    animate-pulse
                                    bg-indigo-200
                                    dark:bg-gray-500
                                    rounded-lg
                                    w-16
                                    h-7
                                    mb-2
                                "
                            ></div>
                            <div class="text-right" v-else>
                                {{ metric.value }}
                            </div>
                            <div
                                v-if="metric.subtext != ''"
                                class="text-sm text-right"
                            >
                                {{ metric.subtext }}
                            </div>
                        </div>
                        <div
                            class="
                                absolute
                                bottom-0
                                left-0
                                md:text-xl
                                text-lg
                                pl-2
                                text-indigo-300
                            "
                        >
                            <span> {{ metric.label }} </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="absolute text-xs text-gray-400 right-0 bottom-0 -pt-3">
                Updated At: {{ parseDate(updated_at) }}
            </div>
        </div>
    </div>
</template>
<script>
import { mapGetters } from "vuex";
import dateFormat from "dateformat";

export default {
    components: {},
    data() {
        return {
            circulatingSupply: null,
            foundationSupply: null,
            inflationAuthorized: null,
            inflatableBalance: null,
            epochId: null,
            rewardData: {
                totalAwarded: null,
                totalClaimed: null,
                totalExpired: null,
            },

            latestRewardEpoch: null,
            latestRewardEpochStart: null,
            latestRewardEpochStartBlock: null,
            latestRewardEpochVotepowerBlock: null,

            updated_at: null,
        };
    },
    computed: {
        // mix the getters into computed with object spread operator
        // ...mapGetters(["getCirculatingSupply"]),
    },

    mounted: async function () {
        var data = await this.$store.dispatch("requestNetworkStatistics");
        var network = this.$store.state.chainName;

        this.circulatingSupply = this.parseNumber(
            data[`${network}_statistics`].circulating_supply
        );
        this.foundationSupply = this.parseNumber(
            data[`${network}_statistics`].foundation_supply
        );
        this.inflationAuthorized = this.parseNumber(
            data[`${network}_statistics`].inflation_authorised
        );
        this.inflatableBalance = this.parseNumber(
            data[`${network}_statistics`].inflatable_balance
        );
        this.epochId = data[`${network}_statistics`].latest_ftso_epoch;

        this.rewardData.totalAwarded = this.parseNumber(
            data[`${network}_statistics`].ftso_rewards_total
        );
        this.rewardData.totalClaimed = this.parseNumber(
            data[`${network}_statistics`].ftso_rewards_claimed
        );
        this.rewardData.totalExpired = this.parseNumber(
            data[`${network}_statistics`].ftso_rewards_expired
        );
        this.latestRewardEpoch =
            data[`${network}_statistics`].latest_reward_epoch;
        this.latestRewardEpochStart =
            data[`${network}_statistics`].latest_reward_epoch_start;
        this.latestRewardEpochStartBlock =
            data[`${network}_statistics`].latest_reward_epoch_start_block;
        this.latestRewardEpochVotepowerBlock =
            data[`${network}_statistics`].latest_reward_epoch_votepower_block;

        this.updated_at = data[`${network}_statistics`].updated_at;

        return;
    },
    methods: {
        metrics() {
            return [
                {
                    name: "Circulating Supply",
                    label: "SGB",
                    value: this.circulatingSupply,
                    subtext: "",
                },
                {
                    name: "Foundation Supply",
                    label: "SGB",
                    value: this.foundationSupply,
                    subtext: "",
                },
                {
                    name: "Inflation Authorized",
                    label: "SGB",
                    value: this.inflationAuthorized,
                    subtext: "",
                },
                {
                    name: "Inflatable Balance",
                    label: "SGB",
                    value: this.inflatableBalance,
                    subtext: "",
                },
                {
                    name: "# FTSO Rounds",
                    label: "Epoch",
                    value: this.epochId,
                    subtext: "",
                },
                {
                    name: "FTSO Rewards Total",
                    label: "SGB",
                    value: this.rewardData.totalAwarded,
                    subtext: "",
                },
                {
                    name: "FTSO Rewards Claimed",
                    label: "SGB",
                    value: this.rewardData.totalClaimed,
                    subtext: "",
                },
                {
                    name: "FTSO Rewards Expired",
                    label: "SGB",
                    value: this.rewardData.totalExpired,
                    subtext: "",
                },
                {
                    name: "Reward Round",
                    label: "Epoch",
                    value: this.latestRewardEpoch,
                    subtext: "",
                },
                {
                    name: "Reward Votepower Block",
                    label: "Block",
                    value: this.latestRewardEpochVotepowerBlock,
                },
                {
                    name: "Current Reward Start",
                    label: "Time",
                    value: this.parseEpochTime(
                        this.latestRewardEpochStart,
                        "dd mmm"
                    ),
                    subtext: this.parseEpochTime(
                        this.latestRewardEpochStart,
                        "h:MM TT"
                    ),
                },
                {
                    name: "Current Reward End",
                    label: "Time",
                    value: this.parseEpochTime(
                        this.latestRewardEpochStart + 604800,
                        "dd mmm"
                    ),
                    subtext: this.parseEpochTime(
                        this.latestRewardEpochStart + 604800,
                        "h:MM TT"
                    ),
                },
            ];
        },
        nextRewardEpoch() {
            const rewardEpochDuration = 604800;
        },
        parseEpochTime(epoch, format) {
            var d = new Date(0);
            d.setUTCSeconds(epoch);
            return dateFormat(new Date(d), format);
        },
        parseDate(date) {
            return dateFormat(new Date(date), "dd-mmm-yy h:MM TT");
        },
        parseNumber(num) {
            if (num >= 1000000000) {
                return (num / 1000000000).toFixed(1).replace(/\.0$/, "") + "B";
            }
            if (num >= 1000000) {
                return (num / 1000000).toFixed(1).replace(/\.0$/, "") + "M";
            }
            if (num >= 1000) {
                return (num / 1000).toFixed(1).replace(/\.0$/, "") + "K";
            }
            return 0;
        },
    },
};
</script>
