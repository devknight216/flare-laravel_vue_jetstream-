<template>
    <div>
        <app-layout>
            <div class="py-2 md:py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div
                        class="
                            bg-white
                            dark:bg-gray-800
                            overflow-hidden
                            rounded
                        "
                    >
                        <div>
                            <div
                                class="
                                    w-full
                                    col-span-2
                                    font-bold
                                    bg-gray-100
                                    dark:bg-gray-600
                                "
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
                                    <div class="mt-3 text-xs">
                                        <div class="font-bold">Presets</div>
                                        <div
                                            class="
                                                cursor-pointer
                                                hover:text-indigo-700
                                            "
                                            @click="setExample(1)"
                                        >
                                            Example 1
                                        </div>
                                    </div>
                                </div>
                                <!-- Col 2 -->
                                <div
                                    class="
                                        col-span-7
                                        md:col-span-4
                                        border-l border-gray-200
                                        ml-4
                                        pl-4
                                    "
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
                                            <label for="">Vote </label>
                                            <input
                                                :disabled="rounded_started"
                                                class="h-6 w-28 border-gray-200"
                                                type="number"
                                                step="0.01"
                                                v-model="voter.vote"
                                            />
                                        </div>
                                        <div class="ml-2">
                                            <label for="">Vote Weight </label>
                                            <input
                                                :disabled="rounded_started"
                                                class="h-6 w-28 border-gray-200"
                                                type="number"
                                                v-model="voter.spark"
                                            />
                                        </div>

                                        <div
                                            @click="
                                                !rounded_started
                                                    ? removeVoter(index)
                                                    : ''
                                            "
                                            class="
                                                ml-2
                                                text-sm text-red-600
                                                cursor-pointer
                                                select-none
                                            "
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
                                            class="
                                                w-48
                                                border-t border-gray-200
                                                mt-2
                                            "
                                        ></div>
                                        <div
                                            @click="addVoter()"
                                            class="
                                                mx-2
                                                text-gray-400
                                                cursor-pointer
                                                select-none
                                            "
                                        >
                                            Add
                                        </div>
                                        <div
                                            class="
                                                w-48
                                                border-t border-gray-200
                                                mt-2
                                            "
                                        ></div>
                                    </div>
                                </div>
                                <!-- Col 3 -->
                                <div class="relative col-span-7 md:col-span-1">
                                    <div class="pb-4">
                                        <span class="font-bold">Awards</span>
                                        <div
                                            v-for="(voter, index) in voters"
                                            :key="index"
                                            class="flex my-3"
                                        >
                                            <div>
                                                Awarded:
                                                <span
                                                    :class="
                                                        voter.award == true
                                                            ? 'text-green-700'
                                                            : 'text-red-700'
                                                    "
                                                >
                                                    {{
                                                        voter.award == true
                                                            ? "Yes"
                                                            : "No"
                                                    }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Col 4 -->
                                <div class="relative col-span-7 md:col-span-1">
                                    <div class="pb-4">
                                        <span class="font-bold">Result</span>
                                        <div class="mt-2">
                                            <span class="font-semibold"
                                                >(M) Price:
                                            </span>
                                            {{ result.medianPrice }}
                                        </div>
                                        <div class="mt-2">
                                            <span class="font-semibold"
                                                >(M) Address:
                                            </span>
                                            {{ result.medianAddress }}
                                        </div>
                                        <div class="mt-2">
                                            <span class="font-semibold"
                                                >Σ Weight:
                                            </span>
                                            {{ result.totalWeight }}
                                        </div>
                                        <div class="mt-2">
                                            <span class="font-semibold"
                                                >(M) Weight:
                                            </span>
                                            {{ result.medianWeight }}
                                        </div>
                                        <div class="mt-2">
                                            <span class="font-semibold"
                                                >Target (M):
                                            </span>
                                            {{ result.targetMedian }}
                                        </div>
                                        <div class="mt-2">
                                            <span class="font-semibold"
                                                >Low Reward $:
                                            </span>
                                            {{ result.lowRewardPrice }}
                                        </div>
                                        <div class="mt-2">
                                            <span class="font-semibold"
                                                >High Reward $:
                                            </span>
                                            {{ result.highRewardPrice }}
                                        </div>
                                    </div>

                                    <div
                                        v-if="rounded_started"
                                        class="
                                            pt-3
                                            absolute
                                            left-0
                                            bottom-0
                                            pr-3
                                            select-none
                                            cursor-pointer
                                            text-indigo-700
                                        "
                                    >
                                        Oracle Output: {{ mean }}
                                    </div>
                                    <div
                                        v-if="!rounded_started"
                                        @click="startRound()"
                                        class="
                                            absolute
                                            right-0
                                            bottom-0
                                            pr-3
                                            select-none
                                            cursor-pointer
                                            text-indigo-700
                                        "
                                    >
                                        Start Round
                                    </div>
                                    <div
                                        v-if="rounded_started"
                                        @click="resetRound()"
                                        class="
                                            absolute
                                            right-0
                                            bottom-0
                                            pr-3
                                            select-none
                                            cursor-pointer
                                            text-red-500
                                        "
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
                    vote: "1.00", // Votes price as $3.00
                    spark: 2, // Owns ten token
                },
                {
                    address: "Bob",
                    vote: "1.00", // Votes price as $4.00
                    spark: 2, // Owns twenty token
                },
                {
                    address: "Charlie",
                    vote: "2.00", // Votes price as $5.00
                    spark: 1, // Owns thirty token
                },
                {
                    address: "Eve",
                    vote: "3.00", // Votes price as $5.00
                    spark: 2, // Owns thirty token
                },
                {
                    address: "Jan",
                    vote: "3.00", // Votes price as $5.00
                    spark: 2, // Owns thirty token
                },
                {
                    address: "Sam",
                    vote: "3.00", // Votes price as $5.00
                    spark: 1, // Owns thirty token
                },
                {
                    address: "Josh",
                    vote: "4.00", // Votes price as $5.00
                    spark: 1, // Owns thirty token
                },
                {
                    address: "Nick",
                    vote: "5.00", // Votes price as $5.00
                    spark: 5, // Owns thirty token
                },
            ],

            example_1: [
                {
                    address: "Alice",
                    vote: "1.00", // Votes price as $3.00
                    spark: 2, // Owns ten token
                },
                {
                    address: "Bob",
                    vote: "2.00", // Votes price as $4.00
                    spark: 2, // Owns twenty token
                },
                {
                    address: "Charlie",
                    vote: "2.00", // Votes price as $5.00
                    spark: 1, // Owns thirty token
                },
                {
                    address: "Eve",
                    vote: "3.00", // Votes price as $5.00
                    spark: 2, // Owns thirty token
                },
                {
                    address: "Jan",
                    vote: "3.00", // Votes price as $5.00
                    spark: 2, // Owns thirty token
                },
                {
                    address: "Josh",
                    vote: "4.00", // Votes price as $5.00
                    spark: 1, // Owns thirty token
                },
                {
                    address: "Nick",
                    vote: "5.00", // Votes price as $5.00
                    spark: 5, // Owns thirty token
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

            median_price_address: null,

            result: {
                medianPrice: 0,
                medianAddress: "",
                totalWeight: 0,
                totalWeightRewarded: 0,
                medianWeight: 0,
                targetMedian: 0,
                lowRewardPrice: 0,
                highRewardPrice: 0,
            },
        };
    },
    mounted: function () {},
    methods: {
        startRound() {
            this.voters.forEach((voter) => {
                voter.award = false;
            });

            var orderedVotes = this.orderVotes(this.voters);
            var totalVotePower = this.getTotalVotePower(orderedVotes);
            var totalVoteRewards = totalVotePower / 2;

            var medianWeight = this.getMedianWeight(totalVotePower);
            var targetMedian = totalVotePower - Math.floor(totalVotePower / 4);

            var lowRewardPrice = this.getLowRewardPrice(
                orderedVotes,
                targetMedian
            );
            var highRewardPrice = this.getHighRewardPrice(
                orderedVotes,
                targetMedian
            );

            var medianPrice = this.getMedianPrice(orderedVotes, medianWeight);

            console.log(orderedVotes);

            this.result = {
                medianPrice: medianPrice,
                totalWeight: totalVotePower,
                medianAddress: this.result.medianAddress,
                totalWeightRewarded: totalVoteRewards,
                medianWeight: medianWeight,
                targetMedian: targetMedian,
                lowRewardPrice: lowRewardPrice,
                highRewardPrice: highRewardPrice,
            };

            this.voters.forEach((voter, index) => {
                if (
                    parseFloat(voter.vote) >= lowRewardPrice &&
                    parseFloat(voter.vote) <= highRewardPrice
                ) {
                    voter.award = true;
                }
            });
        },
        orderVotes(voters) {
            var sequence = [];
            voters.forEach((voter) => {
                sequence.push([
                    parseFloat(voter.vote).toFixed(2),
                    voter.spark,
                    voter.address,
                ]); // (Vote, Vote Power)
            });
            // Arange in acending order of price
            var sequence = sequence.sort(function (a, b) {
                return a[0] - b[0];
            });
            return sequence;
        },
        getTotalVotePower(votes) {
            var sum = 0;
            votes.forEach((vote) => (sum += parseFloat(vote[1])));
            return sum;
        },
        getMedianWeight(totalVotePower) {
            return Math.floor(totalVotePower / 2) + (totalVotePower % 2);
        },
        getMedianPrice(orderedVotes, medianWeight) {
            var collected = 0;
            var colledtedVotes = [];
            orderedVotes.forEach((vote) => {
                if (medianWeight > collected) {
                    collected += parseFloat(vote[1]);
                    colledtedVotes.push(vote);
                }
                return;
            });
            this.result.medianAddress = colledtedVotes.pop()[2];
            console.log(this.result);
            return colledtedVotes.pop()[0];
        },

        getLowRewardPrice(orderedVotes, targetMedian) {
            var reversedVotes = orderedVotes.slice().reverse(); // Copy ordered array and reverse (prevent mutation)
            var collected = 0;
            var colledtedVotes = [];
            reversedVotes.forEach((vote) => {
                if (targetMedian > collected) {
                    collected += parseFloat(vote[1]);
                    colledtedVotes.push(vote);
                }
                return;
            });

            return colledtedVotes.pop()[0];
        },
        getHighRewardPrice(orderedVotes, targetMedian) {
            var collected = 0;
            var colledtedVotes = [];
            orderedVotes.forEach((vote) => {
                if (targetMedian > collected) {
                    collected += parseFloat(vote[1]);
                    colledtedVotes.push(vote);
                }
                return;
            });
            return colledtedVotes.pop()[0];
        },
        calculateAward() {
            this.award =
                ((this.award_rate / 100) * this.spark_circulation) /
                this.voting_rounds;
            return this.award.toFixed(2);
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
        setExample(n) {
            switch (n) {
                case 1:
                    this.voters = this.example_1;
                    break;

                default:
                    break;
            }
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
