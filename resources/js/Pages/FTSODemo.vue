<template>
    <div>
        <app-layout>
            <div class="py-2 md:py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div
                        class="bg-white dark:bg-gray-800 overflow-hidden rounded"
                    >
                        <div>
                            <div
                                class="w-full col-span-2 font-bold bg-gray-100 dark:bg-gray-600"
                            >
                                <div class="ml-6 py-3">
                                    FTSO Demo
                                    <span class="text-red-600 text-sm"
                                        >(Experimental)</span
                                    >
                                </div>
                            </div>

                            <div class="grid grid-cols-7 text-sm p-6">
                                <!-- Col 1 -->
                                <div class="col-span-7 md:col-span-1">
                                    <span class="font-bold">Variables</span>
                                    <div class="my-2">
                                        <label for="award_rate"
                                            >Award Rate Percentage</label
                                        >
                                        <input
                                            v-model="award_rate"
                                            id="award_rate"
                                            class="h-8 w-full input-icon"
                                            min="1"
                                            max="100"
                                            type="number"
                                        />
                                    </div>
                                    <div class="my-2">
                                        <label for="spark_circulation"
                                            >Annual Spark Circulation</label
                                        >
                                        <input
                                            v-model="spark_circulation"
                                            id="spark_circulation"
                                            class="h-8 w-full"
                                            type="number"
                                        />
                                    </div>
                                    <div class="my-2">
                                        <label for="voting_rounds"
                                            >Annual Voting Rounds</label
                                        >
                                        <input
                                            v-model="voting_rounds"
                                            id="voting_rounds"
                                            class="h-8 w-full"
                                            type="number"
                                        />
                                    </div>
                                    <div class="text-xs">
                                        <span>Award Per Round: </span>
                                        <span class="font-bold"
                                            >{{ calculateAward() }} FLR</span
                                        >
                                    </div>
                                </div>

                                <!-- Col 2 -->
                                <div
                                    class="col-span-7 md:col-span-4 border-l border-gray-200 ml-4 pl-4"
                                >
                                    <span class="font-bold">Voters</span>
                                    <div
                                        v-for="(voter, index) in voters"
                                        :key="index"
                                        class="flex my-2"
                                    >
                                        <div>
                                            <label for="">Name </label>
                                            <input
                                                :disabled="rounded_started"
                                                class="h-6 w-28 border-gray-200"
                                                type="text"
                                                v-model="voter.address"
                                            />
                                        </div>
                                        <div class="ml-2">
                                            <label for="">Voted FLR </label>
                                            <input
                                                :disabled="rounded_started"
                                                class="h-6 w-28 border-gray-200"
                                                type="number"
                                                v-model="voter.spark"
                                            />
                                        </div>
                                        <div class="ml-2">
                                            <label for="">Vote </label>
                                            <input
                                                :disabled="rounded_started"
                                                @change="parseVote(index)"
                                                class="h-6 w-28 border-gray-200"
                                                type="number"
                                                step="0.01"
                                                v-model="voter.vote"
                                            />
                                        </div>
                                        <div
                                            @click="
                                                !rounded_started
                                                    ? removeVoter(index)
                                                    : ''
                                            "
                                            class="ml-2 text-sm text-red-600 cursor-pointer select-none"
                                            :class="
                                                !rounded_started
                                                    ? ''
                                                    : 'opacity-50'
                                            "
                                        >
                                            Remove
                                        </div>
                                    </div>
                                    <div
                                        v-if="!rounded_started"
                                        class="flex ml-4"
                                    >
                                        <div
                                            class="w-48 border-t border-gray-200 mt-2"
                                        ></div>
                                        <div
                                            @click="addVoter()"
                                            class="mx-2 text-gray-400 cursor-pointer select-none"
                                        >
                                            Add
                                        </div>
                                        <div
                                            class="w-48 border-t border-gray-200 mt-2"
                                        ></div>
                                    </div>
                                </div>
                                <!-- Col 2 -->
                                <div class="relative col-span-7 md:col-span-2">
                                    <div class="pb-4">
                                        <span class="font-bold">Result</span>
                                        <div
                                            v-for="(voter, index) in voters"
                                            :key="index"
                                            class="flex my-3"
                                        >
                                            <div>
                                                Award:
                                                {{ voter.award ?? "N/A" }} FLR
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        v-if="rounded_started"
                                        class="pt-3 absolute left-0 bottom-0 pr-3 select-none cursor-pointer text-indigo-700"
                                    >
                                        Oracle Output: {{ mean }}
                                    </div>
                                    <div
                                        v-if="!rounded_started"
                                        @click="startRound()"
                                        class="absolute right-0 bottom-0 pr-3 select-none cursor-pointer text-indigo-700"
                                    >
                                        Start Round
                                    </div>
                                    <div
                                        v-if="rounded_started"
                                        @click="resetRound()"
                                        class="absolute right-0 bottom-0 pr-3 select-none cursor-pointer text-red-500"
                                    >
                                        Reset Round
                                    </div>
                                </div>
                                <!-- Divider -->
                                <!-- <div
                                            class="lg:hidden col-span-2 border-t border-gray-100 my-4"
                                        ></div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </app-layout>
    </div>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";

export default {
    components: {
        AppLayout,
    },
    data() {
        return {
            voters: [
                {
                    address: "Alice",
                    spark: 1, // Owns ten token
                    vote: "3.00", // Votes price as $3.00
                },
                {
                    address: "Bob",
                    spark: 2, // Owns twenty token
                    vote: "4.00", // Votes price as $4.00
                },
                {
                    address: "Charlie",
                    spark: 3, // Owns thirty token
                    vote: "5.00", // Votes price as $5.00
                },
                {
                    address: "Eve",
                    spark: 2, // Owns thirty token
                    vote: "6.00", // Votes price as $5.00
                },
            ],

            award_rate: 10, // Percentage of circulated Spark to be given as a reward
            voting_rounds: 12,
            spark_circulation: 1440,
            award: 0, // Award per round

            totalVotingPower: 0, // Total Spark Staked

            mean: 0, // Oracle Output
            award_weight: 0, // Total Award Weight

            truncatedVotingPower: 0, // Total Spark Staked
            rounded_started: false,
        };
    },
    mounted: function () {},
    methods: {
        calculateAward() {
            this.award =
                ((this.award_rate / 100) * this.spark_circulation) /
                this.voting_rounds;
            return this.award.toFixed(2);
        },
        parseVote(index) {
            this.voters[index].vote = parseFloat(
                this.voters[index].vote
            ).toFixed(2);
        },
        addVoter() {
            var voters_length = this.voters.length;
            var average = 0;
            this.voters.forEach((voter) => {
                average += parseFloat(voter.vote);
            });
            this.voters.push({
                address: `Voter ${voters_length + 1}`,
                spark: 100,
                vote: parseFloat(average / voters_length).toFixed(2),
            });
        },
        removeVoter(index) {
            if (this.voters.length == 1) return;
            this.voters.splice(index, 1);
        },
        resetRound() {
            this.voters.forEach((voter) => {
                voter.spark = voter.spark_pre_truncate;
                delete voter.award_weight;
                delete voter.award;
            });
            this.totalVotingPower = 0;
            this.mean = 0;
            this.award_weight = 0;
            this.truncatedVotingPower = 0;
            this.rounded_started = false;
        },
        startRound() {
            this.rounded_started = true;
            this.prepareAddresses();
            this.setTotalVotingPower();
            this.truncate();
            this.updateAddresses();
            this.awardSpark();
        },
        prepareAddresses() {
            // Sort in order of vote
            this.voters.sort((a, b) => {
                return a.vote - b.vote;
            });
        },

        setTotalVotingPower() {
            this.voters.forEach((address) => {
                address.spark = parseFloat(address.spark);
                address.vote = parseFloat(address.vote);
                this.totalVotingPower += parseFloat(address.spark);
            });
        },

        truncate() {
            var lowerRemoveLimit = this.totalVotingPower * 0.25;
            var upperRemoveLimit = this.totalVotingPower * 0.25;
            console.log(`Removing ${lowerRemoveLimit} from bottom`);
            console.log(`Removing ${upperRemoveLimit} from top`);

            this.voters.forEach((address) => {
                address.spark_pre_truncate = address.spark; // Sets voted spark before truncation
                if (lowerRemoveLimit == 0) return;

                if (address.spark < lowerRemoveLimit) {
                    lowerRemoveLimit -= address.spark;
                    address.spark = 0;
                } else {
                    address.spark -= lowerRemoveLimit;
                    lowerRemoveLimit = 0;
                }
            });

            this.voters.reverse();
            this.voters.forEach((address) => {
                if (upperRemoveLimit == 0) return;

                if (address.spark < upperRemoveLimit) {
                    upperRemoveLimit -= address.spark;
                    address.spark = 0;
                } else {
                    address.spark -= upperRemoveLimit;
                    upperRemoveLimit = 0;
                }
            });
            console.log(this.voters);
        },

        updateAddresses() {
            // Get new total voting power
            this.truncatedVotingPower = 0; // Total Spark Staked
            this.voters.forEach((address) => {
                this.truncatedVotingPower += address.spark;
            });

            // Get Weighted Mean
            this.voters.forEach((address) => {
                address.award_weight =
                    address.spark / address.spark_pre_truncate;
                this.award_weight += address.award_weight;
                if (address.spark > 0) {
                    this.mean +=
                        (address.spark / this.truncatedVotingPower) *
                        address.vote;
                }
            });
        },

        awardSpark() {
            this.voters.forEach((address) => {
                address.award = parseFloat(
                    this.award * (address.award_weight / this.award_weight)
                ).toFixed(2);
            });
        },
    },
};
</script>
<style scoped>
.input-icon {
    background-image: url("/images/icons/percentage.png");
    background-position: right;
    background-repeat: no-repeat;
    background-position: 95% 50%;
}

input:disabled {
    background: #f1f1f1;
}
</style>
