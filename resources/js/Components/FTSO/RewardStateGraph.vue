<template>
    <div class="chart-container relative h-96 w-full">
        <canvas id="rewardStateChart"></canvas>
    </div>
</template>
<script>
import Chart from "chart.js/auto";
import dateFormat from "dateformat";

export default {
    props: {
        provider_id: {
            required: true,
        },
    },
    data: () => {
        return {
            chartData: [],
            chartLabels: [],
        };
    },
    mounted: function () {
        this.getChartData();
    },
    methods: {
        init() {
            var ctx = document
                .getElementById("rewardStateChart")
                .getContext("2d");
            var myChart = new Chart(ctx, {
                type: "line",
                data: {
                    // labels: this.chartLabels,
                    datasets: [
                        {
                            label: "Reward Ratio",
                            data: this.chartData,
                            parsing: {
                                yAxisKey: "ratio",
                            },
                            backgroundColor: ["#4F46E5"],
                            borderColor: ["#818CF8"],
                            borderWidth: 1,
                        },
                        // {
                        //     label: "Rewards",
                        //     data: this.chartData,
                        //     parsing: {
                        //         yAxisKey: "rewards",
                        //     },
                        //     display: false,
                        //     backgroundColor: ["#4F46E5"],
                        //     borderColor: ["#818CF8"],
                        //     borderWidth: 1,
                        // },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                        x: {
                            ticks: {
                                maxTicksLimit: 6,
                                stepSize: 6,
                                maxRotation: 0,
                                align: "start",
                                display: !isMobile,
                            },
                            grid: {
                                display: false,
                            },
                        },
                    },
                    plugins: {
                        tooltip: {
                            intersect: false,
                            callbacks: {
                                label: (context) => {
                                    var label = context.dataset.label;
                                    var value = context.formattedValue;
                                    var subValue = context.raw.rewards;
                                    var subValue2 = context.raw.epoch;
                                    return `${label}: ${value} (${this.parseNumber(
                                        subValue
                                    )} SGB) ⇹${subValue2}`;
                                },
                            },
                        },
                        legend: {
                            display: false,
                        },
                    },
                },
            });
        },

        getChartData() {
            axios
                .get(route("api.provider.reward-state"), {
                    params: { provider_id: this.$props.provider_id },
                })
                .then((response) => {
                    var data = response.data;
                    this.chartLabels = data.map((item) =>
                        dateFormat(
                            new Date(item.created_at.replace(/-/g, "/")),
                            "dd-mmm-yy h:MM TT"
                        )
                    );

                    this.chartData = data.map((item) => {
                        "";
                        var time = dateFormat(
                            new Date(item.created_at.replace(/-/g, "/")),
                            "ddd h:MM TT"
                        );
                        var point = {
                            x: time,
                            ratio: this.getRewardRate(item),
                            rewards: item.provider_reward_state,
                            epoch: item.reward_epoch,
                            label:
                                dateFormat(
                                    new Date(
                                        item.created_at.replace(/-/g, "/")
                                    ),
                                    "dd-mmm-yy h:MM TT"
                                ) + `Epoch #${item.reward_epoch}`,
                        };
                        return point;
                    });
                    this.chartData = this.chartData.reverse();

                    this.init();
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        getRewardRate(state) {
            var multiplier = 100 - state.provider_fee;
            multiplier = multiplier / state.provider_fee;
            return (
                ((multiplier * state.provider_reward_state) /
                    state.provider_votepower) *
                100
            ).toFixed(3);
        },
        parseNumber(n) {
            return parseFloat(n).toLocaleString(undefined, {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0,
            });
        },
    },
};
</script>
<style scoped>
canvas {
}

.chart-container {
    position: relative;
    margin: auto;
    height: 100%;
    width: 100%;
}
</style>
