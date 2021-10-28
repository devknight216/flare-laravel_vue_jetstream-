<template>
    <div>
        <div></div>
        <div class="grid grid-cols-12 w-full mb-2 rounded">
            <div class="flex col-span-6 md:col-span-8">
                <div
                    class="
                        text-xs text-gray-600
                        dark:text-gray-200
                        my-2
                        ml-2
                        flex
                    "
                >
                    <div
                        @click="toggleDisplayMode()"
                        class="
                            relative
                            w-24
                            h-5
                            rounded-full
                            bg-gradient-to-r
                            from-gray-100
                            to-gray-200
                            flex
                            items-center
                            cursor-pointer
                            select-none
                        "
                    >
                        <div
                            v-if="display_mode == 'overall'"
                            class="absolute text-xs text-gray-600 ml-2"
                        >
                            Overall
                        </div>
                        <div
                            v-if="display_mode == 'epoch'"
                            class="absolute text-xs text-gray-600 mr-2 right-0"
                        >
                            Epoch #{{
                                $store.state.network_statistics[
                                    $store.state.chainName
                                ].latest_reward_epoch
                            }}
                        </div>
                        <div
                            class="
                                absolute
                                rounded-full
                                w-4
                                h-4
                                border border-gray-50
                                mx-1
                            "
                            :class="
                                display_mode == 'overall'
                                    ? 'right-0 bg-gradient-to-r	from-indigo-400 to-indigo-500'
                                    : 'bg-gradient-to-r	from-green-400  to-green-600'
                            "
                        ></div>
                    </div>

                    <div class="mx-3 tooltip">
                        <span class="tooltiptext"
                            >{{
                                hide_inactive ? "Show" : "Hide"
                            }}
                            Inactive</span
                        >
                        <svg
                            @click="toggleHideInactive()"
                            class="h-4 fill-current text-gray-800"
                            :class="
                                hide_inactive ? 'opacity-100' : 'opacity-25'
                            "
                            enable-background="new 0 0 512 512"
                            viewBox="0 0 512 512"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <g>
                                <path
                                    d="m436.193 169.626c-5.507-4.735-11.04-9.258-16.589-13.59l-64.701 64.701c3.942 11.027 6.097 22.898 6.097 35.263 0 57.897-47.103 105-105 105-12.365 0-24.236-2.155-35.263-6.098l-48.558 48.558c28.356 11.632 56.481 17.54 83.821 17.54 32.657 0 66.432-8.396 100.384-24.955 26.662-13.005 53.514-31.063 79.809-53.671 44.455-38.226 71.841-76.024 72.984-77.615 3.765-5.232 3.765-12.285 0-17.518-1.144-1.591-28.529-39.389-72.984-77.615z"
                                />
                                <path
                                    d="m256 331c41.355 0 75-33.645 75-75 0-3.598-.27-7.134-.763-10.598l-84.835 84.835c3.465.493 7 .763 10.598.763z"
                                />
                                <path
                                    d="m507.607 4.394c-5.857-5.857-15.355-5.857-21.213 0l-117.848 117.848c-4.056-2.208-8.111-4.311-12.162-6.286-33.952-16.56-67.727-24.956-100.384-24.956s-66.432 8.396-100.384 24.955c-26.662 13.005-53.514 31.063-79.809 53.671-44.454 38.226-71.84 76.024-72.984 77.615-3.765 5.232-3.765 12.285 0 17.518 1.144 1.591 28.529 39.39 72.984 77.615 13.623 11.713 27.396 22.192 41.214 31.391l-112.627 112.629c-5.858 5.857-5.858 15.355 0 21.213 2.929 2.928 6.767 4.393 10.606 4.393s7.678-1.465 10.606-4.394l482-482c5.859-5.857 5.859-15.355.001-21.212zm-356.607 251.606c0-57.897 47.103-105 105-105 23.551 0 45.315 7.794 62.85 20.938l-21.52 21.52c-11.859-7.864-26.065-12.458-41.33-12.458-41.355 0-75 33.645-75 75 0 15.264 4.594 29.47 12.458 41.33l-21.52 21.52c-13.144-17.535-20.938-39.299-20.938-62.85z"
                                />
                            </g>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="col-span-6 md:col-span-4 mr-2">
                <input
                    @keyup="keyUp()"
                    placeholder="Search"
                    v-model="params.q"
                    class="h-6 my-1 rounded-sm border-gray-200 w-full text-sm"
                    type="text"
                />
            </div>
        </div>
        <div
            class="w-full overflow-x-scroll xl:overflow-x-hidden"
            v-if="list_mode == 'table'"
            id="table-list"
        >
            <table
                class="
                    min-w-full
                    table-fixed
                    w-full
                    text-left
                    min-width
                    dark:text-white
                "
            >
                <thead>
                    <tr
                        class="
                            border-b-2 border-gray-200
                            text-sm text-gray-500
                            dark:text-gray-300
                        "
                    >
                        <th class="w-52 md:w-2/9">Name</th>
                        <th class="w-32 md:w-1/9">Code</th>
                        <th
                            class="w-32 md:w-1/8 cursor-pointer select-none"
                            @click="sortList('votepower')"
                        >
                            Vote Power
                        </th>
                        <th
                            class="w-32 md:w-1/9 cursor-pointer select-none"
                            @click="sortList('votepower_percentage')"
                        >
                            Vote Power %
                        </th>
                        <th
                            class="w-32 md:w-1/9 cursor-pointer select-none"
                            @click="sortList('reward_rate')"
                        >
                            Reward Rate
                        </th>
                        <th class="w-32 md:w-1/9">Fee</th>

                        <th
                            class="w-32 md:w-1/9 cursor-pointer select-none"
                            @click="sortList('region')"
                        >
                            Region
                        </th>
                        <th class="w-32 md:w-1/9">Website</th>
                        <!-- <th class="w-16">Verified</th> -->
                    </tr>
                </thead>

                <tbody class="font-lato">
                    <template v-if="ftso_list.length == 0">
                        <tr
                            class="border-b border-gray-300"
                            v-for="n in 12"
                            :key="n"
                        >
                            <td class="flex items-center my-6">
                                <div
                                    class="
                                        h-8
                                        w-8
                                        bg-indigo-200
                                        dark:bg-gray-500
                                        animate-pulse
                                        rounded-full
                                    "
                                ></div>
                                <div
                                    class="
                                        h-6
                                        w-32
                                        md:w-36
                                        ml-4
                                        md:ml-6
                                        bg-indigo-200
                                        dark:bg-gray-500
                                        animate-pulse
                                        rounded-full
                                    "
                                ></div>
                            </td>
                            <td>
                                <div
                                    class="
                                        h-6
                                        w-16
                                        md:w-20
                                        bg-indigo-200
                                        dark:bg-gray-500
                                        animate-pulse
                                        rounded-full
                                    "
                                ></div>
                            </td>

                            <td>
                                <div
                                    class="
                                        h-6
                                        w-20
                                        md:w-26
                                        bg-indigo-200
                                        dark:bg-gray-500
                                        animate-pulse
                                        rounded-full
                                    "
                                ></div>
                            </td>
                            <td>
                                <div
                                    class="
                                        h-6
                                        w-16
                                        md:w-16
                                        bg-indigo-200
                                        dark:bg-gray-500
                                        animate-pulse
                                        rounded-full
                                    "
                                ></div>
                            </td>
                            <td>
                                <div
                                    class="
                                        h-6
                                        w-16
                                        md:w-16
                                        bg-indigo-200
                                        dark:bg-gray-500
                                        animate-pulse
                                        rounded-full
                                    "
                                ></div>
                            </td>
                            <td>
                                <div
                                    class="
                                        h-6
                                        w-16
                                        md:w-16
                                        bg-indigo-200
                                        dark:bg-gray-500
                                        animate-pulse
                                        rounded-full
                                    "
                                ></div>
                            </td>
                            <td>
                                <div
                                    class="
                                        h-6
                                        w-20
                                        md:w-28
                                        bg-indigo-200
                                        dark:bg-gray-500
                                        animate-pulse
                                        rounded-full
                                    "
                                ></div>
                            </td>
                            <td>
                                <div
                                    class="
                                        h-6
                                        w-20
                                        md:w-28
                                        bg-indigo-200
                                        dark:bg-gray-500
                                        animate-pulse
                                        rounded-full
                                    "
                                ></div>
                            </td>

                            <!-- <td class="flex justify-center items-center">
                                <div
                                    class="
                                        h-6
                                        w-6
                                        bg-indigo-200
                                        dark:bg-gray-500
                                        animate-pulse
                                        rounded-full
                                    "
                                ></div>
                            </td> -->
                        </tr>
                    </template>
                    <template
                        v-else
                        class="border-b border-gray-300"
                        :class="item.verified ? '' : 'opacity-60'"
                        v-for="(item, index) in ftso_list"
                        :key="index"
                    >
                        <tr v-if="!item.hidden">
                            <td class="flex my-6">
                                <div class="">
                                    <img
                                        class="w-7"
                                        :class="isDark ? 'dark-logo' : ''"
                                        :src="item.emblem"
                                        :alt="`${item.name}-emblem`"
                                    />
                                </div>
                                <div
                                    class="
                                        ml-6
                                        w-36
                                        overflow-ellipsis overflow-hidden
                                        whitespace-nowrap
                                    "
                                >
                                    <inertia-link
                                        v-if="item.verified"
                                        target="_blank"
                                        :href="`/ftso/providers/${item.code}`"
                                        class="
                                            hover:text-indigo-700
                                            cursor-pointer
                                        "
                                        >{{ item.name }}</inertia-link
                                    >
                                    <span v-else class="">{{ item.name }}</span>
                                </div>
                            </td>
                            <td>
                                <span
                                    v-if="item.code == ''"
                                    class="text-gray-400 text-xs"
                                    >UNVERIFIED</span
                                >
                                <div
                                    v-else
                                    class="
                                        bg-indigo-400
                                        rounded-full
                                        text-white text-sm
                                        inline-block
                                    "
                                >
                                    <span class="mx-2">{{ item.code }}</span>
                                </div>
                            </td>

                            <td>
                                <div
                                    v-if="item.votepower == null"
                                    class="
                                        rounded-full
                                        w-16
                                        h-4
                                        bg-gray-200
                                        animate-pulse
                                    "
                                ></div>
                                <span v-else>
                                    <div class="flex items-center">
                                        <div>
                                            {{
                                                parseFloat(
                                                    item.votepower
                                                ).toLocaleString(undefined, {
                                                    minimumFractionDigits: 0,
                                                    maximumFractionDigits: 0,
                                                })
                                            }}
                                        </div>
                                        <tooltip
                                            :id="`${item.uid}_vp_tooltip`"
                                            v-if="
                                                item.votepower >
                                                getWnatVotingThreshold
                                            "
                                            :text="`Voting threshold exceeded by ${parseFloat(
                                                item.votepower -
                                                    getWnatVotingThreshold
                                            ).toLocaleString(undefined, {
                                                minimumFractionDigits: 0,
                                                maximumFractionDigits: 0,
                                            })} WSGB.`"
                                        />
                                    </div>
                                </span>
                            </td>
                            <td>
                                <div
                                    v-if="!item.votepower_percentage"
                                    class="
                                        rounded-full
                                        w-16
                                        h-4
                                        bg-gray-200
                                        animate-pulse
                                    "
                                ></div>
                                <div v-else>
                                    <span v-if="item.votepower_percentage >= 0"
                                        >{{ item.votepower_percentage }}%</span
                                    >
                                    <span class="text-gray-400" v-else
                                        >N/A</span
                                    >
                                </div>
                            </td>

                            <td>
                                <div
                                    v-if="!item.fee"
                                    class="
                                        rounded-full
                                        w-16
                                        h-4
                                        bg-gray-200
                                        animate-pulse
                                    "
                                ></div>
                                <div v-else>
                                    <div
                                        class="flex items-center"
                                        v-if="item.reward_state !== null"
                                    >
                                        {{ item.reward_rate }}
                                        <tooltip
                                            :id="`${item.uid}_reward_rate_tooltip`"
                                            v-if="
                                                item.reward_rate > 0 &&
                                                display_mode == 'epoch'
                                            "
                                            :text="`Reward per 100 SGB for reward epoch #${item.reward_state.reward_epoch}.`"
                                        />
                                        <tooltip
                                            :id="`${item.uid}_reward_rate_tooltip`"
                                            v-if="
                                                item.reward_rate > 0 &&
                                                display_mode == 'overall'
                                            "
                                            :text="`Average reward per 100 SGB for last 3 reward epochs.`"
                                        />
                                        <!-- {{ item.votepower }} -->
                                        <tooltip
                                            :id="`${item.uid}_reward_rate_tooltip`"
                                            v-else-if="
                                                parseFloat(item.votepower) <
                                                1000
                                            "
                                            :text="`Reward rates not displayed when votepower less than 1k.`"
                                        />
                                    </div>
                                    <span class="text-gray-400" v-else
                                        >N/A</span
                                    >
                                </div>
                            </td>
                            <td>
                                <div
                                    v-if="!item.fee"
                                    class="
                                        rounded-full
                                        w-16
                                        h-4
                                        bg-gray-200
                                        animate-pulse
                                    "
                                ></div>
                                <div v-else>
                                    <span v-if="item.fee !== 'N/A'"
                                        >{{ item.fee }}%</span
                                    >
                                    <span class="text-gray-400" v-else
                                        >N/A</span
                                    >
                                </div>
                            </td>
                            <td>{{ item.info.local }}</td>
                            <td>
                                <a
                                    target="_blank"
                                    :href="item.website_url"
                                    class="
                                        text-sm text-indigo-700
                                        dark:text-indigo-300
                                        cursor-pointer
                                        overflow-ellipsis
                                    "
                                    >{{
                                        item.website_url
                                            .replace("https://", "")
                                            .replace("www.", "")
                                    }}</a
                                >
                            </td>

                            <!-- <td class="flex justify-center">
                                <img
                                    class="h-5"
                                    :src="
                                        item.verified
                                            ? '/images/icons/verified.svg'
                                            : '/images/icons/unverified.svg'
                                    "
                                    alt=""
                                />
                            </td> -->
                        </tr>
                    </template>
                </tbody>
                <tfoot></tfoot>
            </table>
        </div>
    </div>
    <div class="md:flex md:justify-between">
        <div>
            <span class="mt-2 text-xs text-gray-400"
                >Last Updated: {{ last_update }}</span
            >
        </div>
        <!-- <div>
            <a
                class="
                    mt-2
                    text-indigo-700
                    hover:text-indigo-500
                    dark:text-indigo-200
                    text-xs
                    md:text-right
                "
                target="_blank"
                href="https://docs.flaremetrics.io/ftso/ftso-verification"
                >List Your Signal Provider</a
            >
        </div> -->
    </div>
</template>

<script>
import FtsoListItem from "./FtsoListItem";
import FtsoWindow from "./FtsoWindow";
import moment from "moment";
import { provide } from "@vue/runtime-core";
import { mapGetters } from "vuex";
import Tooltip from "../Ui/Tooltip.vue";

export default {
    components: {
        FtsoListItem,
        FtsoWindow,
        Tooltip,
    },
    props: ["isDark"],
    data() {
        return {
            last_update: null,
            list_mode: "table",
            selected_ftso: null,
            ftso_list: [],
            hide_inactive: false,

            display_mode: "overall",
            keyup_delay: 0,
            params: {
                q: "",
                hide_unverified: false,
            },
            socials: [
                { name: "twitter", url: "https://twitter.com/" },
                { name: "youtube", url: "https://www.youtube.com/channel/" },
                { name: "discord", url: "https://discord.gg/" },
                { name: "telegram", url: "https://t.me/" },
            ],
            sort: {
                by: "votepower",
                direction: "desc",
            },
            network_statistics: [],
        };
    },
    mounted: async function () {
        if (
            Object.keys(this.$store.state.network_statistics.songbird).length ==
            0
        ) {
            await this.$store.dispatch("requestNetworkStatistics");
            this.network_statistics = this.$store.state.network_statistics;
        } else {
            this.network_statistics = this.$store.state.network_statistics;
        }
        // return console.log("stats", this.network_statistics);
        this.getList();
    },
    computed: {
        ...mapGetters(["getWnatVotingThreshold", "getWnatSupply"]),
    },
    methods: {
        toggleDisplayMode() {
            this.display_mode =
                this.display_mode == "epoch" ? "overall" : "epoch";
            this.parseMetrics(this.display_mode);
        },
        sortList(by) {
            if (by == this.sort.by) {
                this.sort.direction =
                    this.sort.direction == "desc" ? "asc" : "desc";

                this.ftso_list.sort((a, b) => {
                    if (this.sort.direction == "desc") {
                        if (this.sort.by == "region") {
                            return a[by].localeCompare(b[by]);
                        }
                        return (
                            parseFloat(b[this.sort.by]) -
                            parseFloat(a[this.sort.by])
                        );
                    } else {
                        if (this.sort.by == "region") {
                            return b[by].localeCompare(a[by]);
                        }
                        return (
                            parseFloat(a[this.sort.by]) -
                            parseFloat(b[this.sort.by])
                        );
                    }
                });
                return;
            }
            this.sort.by = by;
            this.ftso_list.sort((a, b) => {
                if (this.sort.by == "region") {
                    return a[by].localeCompare(b[by]);
                }
                return (
                    parseFloat(b[this.sort.by]) - parseFloat(a[this.sort.by])
                );
            });
        },
        toggleHideInactive() {
            if (this.display_mode == "epoch") return;
            this.hide_inactive = !this.hide_inactive;

            this.ftso_list.map((p) => {
                if (this.hide_inactive) {
                    if (p.votepower == 0 || p.reward_rate == 0) {
                        p.hidden = true;
                    }
                } else {
                    if (p.votepower == 0 || p.reward_rate == 0) {
                        p.hidden = false;
                    }
                }
            });
        },

        getList() {
            axios
                .get(route("api.ftso.list"), { params: this.params })
                .then(async (response) => {
                    this.ftso_list = response.data;
                    this.ftso_list.map((p) => (p.hidden = false));
                    this.parseMetrics();
                    this.$store.dispatch("requestWnatSupply");
                });
        },
        parseMetrics(mode = "overall") {
            var chainName = this.$store.state.chainName;
            this.ftso_list.forEach((provider) => {
                provider.region = provider.info.local;
                provider.votepower = 0;
                provider.fee = "N/A";
                if (mode == "epoch" && provider.pools.length == 0) {
                    provider.hidden = true;
                } else if (mode == "overall") {
                    if (this.hide_inactive == false) {
                        provider.hidden = false;
                    }
                }

                provider.pools.map((pool) => {
                    if (pool.network != this.$store.state.chainName) return;

                    if (mode == "overall") {
                        // Overall Display Mode
                        provider.votepower = pool.votepower;

                        var percentage =
                            (pool.votepower /
                                parseFloat(
                                    this.network_statistics[chainName]
                                        .latest_wnat_votepower
                                )) *
                            100;
                        provider.votepower_percentage = percentage.toFixed(2);
                    } else {
                        // Epoch Display Mode
                        if (provider.reward_state != null) {
                            provider.votepower =
                                provider.reward_state.provider_votepower;

                            var percentage =
                                (provider.votepower /
                                    parseFloat(
                                        this.network_statistics[chainName]
                                            .latest_reward_epoch_votepower
                                    )) *
                                100;
                            provider.votepower_percentage =
                                percentage.toFixed(2);
                        } else {
                            provider.hidden = true;
                        }
                    }

                    provider.fee = pool.fee / 100;
                    if (this.last_update == null && pool.updated_at !== null) {
                        this.last_update = new Date(
                            pool.updated_at
                        ).toUTCString();
                    }
                });
                if (provider.reward_state != null) {
                    provider.reward_rate = this.getRewardRate(provider);
                } else {
                    provider.reward_rate = 0;
                }
            });

            this.ftso_list.sort((a, b) => {
                return (
                    parseFloat(b.votepower) - parseFloat(a.votepower) ||
                    parseFloat(b.reward_rate) - parseFloat(a.reward_rate)
                );
            });
        },
        getRewardRate(provider) {
            // Update logic to share average reward rate when available
            var state = provider.reward_state;
            if (this.display_mode == "overall") {
                if (provider.average_reward_rate == null) return "0.00";
                if (state.provider_votepower < 1000) {
                    console.log("vp low", provider);
                    return "0.00";
                }

                return provider.average_reward_rate.toFixed(3);
            }
            var multiplier = 100 - state.provider_fee;
            if (state.provider_votepower < 1000) {
                console.log("vp low", provider);
                return "0.00";
            }

            multiplier = multiplier / state.provider_fee;
            return (
                ((multiplier * state.provider_reward_state) /
                    state.provider_votepower) *
                100
            ).toFixed(3);
        },

        keyUp() {
            if (this.keyup_delay !== 0) {
                return;
            }
            setTimeout(() => {
                this.keyup_delay = 0;
                this.search();
            }, 850);

            this.keyup_delay = 850;
        },

        search() {
            if (this.params.q.length >= 1) {
                this.getList(); // Get list with query
            } else {
                this.params.q = "";
                this.getList();
            }
        },
        toggleHideUnverified() {
            this.params.hide_unverified = this.params.hide_unverified =
                !this.params.hide_unverified;
            this.search();
        },
        toggleListMode(mode) {
            this.list_mode = mode;
        },
        select(index) {
            if (this.selected_ftso == index) {
                return (this.selected_ftso = null);
            }
            return (this.selected_ftso = index);
        },
        parseDate(date) {
            return moment(date).format("MMM YY");
        },
    },
};

// This is your chance to talk about your Flare Time Series Oracle. We're
// allowing a maximum of 234 characters so choose your words wisely in this
// description.

// If your FTSO item is selected you will have the oppertunity to talk more about your FTSO to give the viewer a better idea of who you are, your goals and achievments. Also, perhaps why they should join you?
</script>
<style scoped>
.dark-logo {
    filter: grayscale(100%) invert(1) brightness(2);
}
.tooltip {
    position: relative;
    display: inline-block;
}

.tooltip .tooltiptext {
    visibility: hidden;
    width: 120px;
    background-color: #eeeeee;
    color: rgb(75, 75, 75);
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;
    padding-left: 5px;
    padding-right: 5px;

    bottom: 120%;
    left: 50%;
    margin-left: -60px; /* Use half of the width (120/2 = 60), to center the tooltip */

    /* Position the tooltip */
    position: absolute;
    z-index: 1;
}

.tooltip:hover .tooltiptext {
    visibility: visible;
}
.dark-logo {
    filter: invert(1) grayscale(1) brightness(1.5);
}
@media screen and (max-width: 600px) {
    .min-width {
        min-width: 400px;
    }
}
</style>
