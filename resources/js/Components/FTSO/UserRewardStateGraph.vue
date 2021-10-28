<template>
    <div class="chart-container relative h-96 w-full">
        <canvas id="rewardStateChart"></canvas>
    </div>
</template>
<script>
import Chart from "chart.js/auto";
import dateFormat from "dateformat";
import { mapGetters } from "vuex";
import { shallowRef } from "vue";

export default {
    props: ["chart_data"],
    data: () => {
        return {
            chartData: [],
            chartLabels: [],
            chart: null,
        };
    },
    mounted: function () {
        this.getChartData();
    },
    computed: {
        ...mapGetters(["getTheme"]),
    },
    watch: {
        getTheme: function () {
            console.log("theme changed");
            this.chart.options.scales.y.ticks.color =
                this.$store.state.theme == "light" ? "#4F46E5" : "#e5e7eb";
            this.chart.options.scales.x.ticks.color =
                this.$store.state.theme == "light" ? "#4F46E5" : "#e5e7eb";
            this.chart.data.datasets[0].backgroundColor = [
                this.$store.state.theme == "light" ? "#4F46E5" : "#e5e7eb",
            ];
            this.chart.data.datasets[0].borderColor = [
                this.$store.state.theme == "light" ? "#818CF8" : "#c7d2fe",
            ];
            this.chart.update();
        },
    },
    methods: {
        init() {
            var ctx = document
                .getElementById("rewardStateChart")
                .getContext("2d");
            // Chart.defaults.color =
            //     this.$store.state.theme == "light" ? "#4F46E5" : "#e5e7eb";
            this.chart = shallowRef(
                new Chart(ctx, {
                    type: "bar",
                    data: {
                        // labels: this.chartLabels,
                        datasets: [
                            {
                                label: "Daily Reward",
                                data: this.chartData,

                                parsing: {
                                    yAxisKey: "dailyRewards",
                                    xAxisKey: "x",
                                },
                                backgroundColor: [
                                    this.$store.state.theme == "light"
                                        ? "#4F46E5"
                                        : "#e5e7eb",
                                ],
                                borderColor: [
                                    this.$store.state.theme == "light"
                                        ? "#818CF8"
                                        : "#c7d2fe",
                                ],
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
                                ticks: {
                                    color:
                                        this.$store.state.theme == "light"
                                            ? "#4F46E5"
                                            : "#e5e7eb",
                                },
                            },
                            x: {
                                ticks: {
                                    maxTicksLimit: 7,
                                    stepSize: 7,
                                    maxRotation: 0,
                                    align: "start",
                                    display: !isMobile,
                                    color:
                                        this.$store.state.theme == "light"
                                            ? "#4F46E5"
                                            : "#e5e7eb",
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
                                        return `${label}: ${this.parseNumber(
                                            value
                                        )} SGB) ⇹${subValue2}`;
                                    },
                                },
                            },
                            legend: {
                                display: false,
                            },
                        },
                    },
                })
            );
        },
        //  label:
        //                         dateFormat(
        //                             new Date(item.updated_at),
        //                             "dd-mmm-yy h:MM TT"
        //                         ) + `Epoch #${item.epoch_id}`,
        getChartData() {
            this.chartData = this.$props.chart_data.map((item) => {
                // var date = new Date(item.updated_at.replace(/-/g, "/"));
                var date = item.updated_at;
                var time = dateFormat(date, "d/m", true);
                this.chartLabels.push(time);
                console.log(dateFormat(date, "d/m", true));
                var point = {
                    x: time,
                    dailyRewards: item.day_rewards,
                    epochRewards: item.epoch_rewards,
                    epoch: item.epoch_id,
                    label: date,
                };
                return point;
            });
            this.chartData = this.chartData.reverse();

            this.init();
        },
        // getRewardRate(state) {
        //     var multiplier = 100 - state.provider_fee;
        //     multiplier = multiplier / state.provider_fee;
        //     return (
        //         ((multiplier * state.provider_reward_state) /
        //             state.provider_votepower) *
        //         100
        //     ).toFixed(3);
        // },
        parseNumber(n) {
            return parseFloat(n).toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
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
