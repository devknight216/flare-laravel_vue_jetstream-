<template>
    <app-layout :hide_bg="true">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 mb-6">
            <div id="breadcrumb">
                <div class="mb-4 text-sm">
                    <inertia-link
                        class="
                            text-indigo-400
                            cursor-pointer
                            font-bold
                            hover:opacity-75
                        "
                        href="/ftso"
                    >
                        FTSO Providers
                    </inertia-link>
                    <span class="font-bold text-indigo-400">></span>
                    <span class="ml-1 dark:text-gray-100">{{ ftso.code }}</span>
                </div>
            </div>

            <div v-if="isOwner" class="flex -mt-4">
                <Link
                    :href="route('view.provider.manage', ftso.code)"
                    class="
                        mb-2
                        text-sm text-indigo-700
                        mt-1
                        pr-1
                        hover:text-indigo-500
                    "
                    >Manage</Link
                >
                <span class="text-gray-300 font-sm">|</span>
                <Link
                    :href="route('view.provider.update', ftso.code)"
                    class="
                        mb-2
                        text-sm text-indigo-700
                        mt-1
                        pl-1
                        hover:text-indigo-500
                    "
                    >Update</Link
                >
            </div>

            <div id="header" class="mt-8">
                <div class="relative h-20">
                    <div class="absolute left-0">
                        <h1
                            class="
                                font-lato
                                relative
                                text-gray-800
                                font-bold
                                text-xl
                            "
                        >
                            <a
                                class="flex items-end"
                                target="_blank"
                                :href="`${ftso.website_url}?ref=flaremetrics.io`"
                            >
                                <img
                                    class="h-8 z-10 left-5"
                                    :class="isDark() ? 'dark-logo' : ''"
                                    :src="ftso.emblem"
                                    :alt="ftso.name"
                                />

                                <div class="ml-2">{{ ftso.name }}</div>
                            </a>
                        </h1>
                        <h2
                            class="
                                text-sm text-gray-500
                                dark:text-gray-100
                                mt-2
                            "
                        >
                            {{ ftso.description }}
                        </h2>
                        <div class="flex" v-if="ftso.socials !== undefined">
                            <div
                                class="mt-1 mr-1"
                                v-for="(social, index) in socials"
                                :key="index"
                            >
                                <div v-if="ftso.socials[social.name]">
                                    <a
                                        :href="`${social.url}${
                                            ftso.socials[social.name]
                                        }`"
                                        target="_blank"
                                    >
                                        <img
                                            class="h-5 w-5 hover:opacity-75"
                                            :class="
                                                !ftso.verified
                                                    ? 'opacity-50'
                                                    : ''
                                            "
                                            :src="`/images/icons/socials/${social.name}.svg`"
                                            alt=""
                                        />
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="absolute right-0 hidden md:block">
                        <div class="mt-2">
                            <div
                                class="
                                    text-lg text-center
                                    mb-2
                                    dark:text-gray-100
                                "
                            >
                                0
                            </div>
                            <div
                                class="
                                    font-semibold
                                    text-sm text-gray-500
                                    dark:text-gray-300
                                "
                            >
                                ACTIVE FTSO'S
                            </div>
                            <div class="text-center text-xs text-indigo-400">
                                <a
                                    target="_blank"
                                    :href="`${ftso.website_url}?ref=flaremetrics.io`"
                                    >Visit Website</a
                                >
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
            <div id="content">
                <!-- <h2 class="font-lato font-semibold mb-1 dark:text-gray-200">
                    About {{ ftso.name }}
                </h2> -->
                <div class="grid grid-cols-12 mb-8 dark:text-white">
                    <div class="col-span-12 md:col-span-12 mr-4">
                        <!-- <div class="mb-4 text-justify">
                            {{ ftso.site_description }}
                        </div> -->
                        <!-- FTSO Quote -->
                        <div class="mb-2 relative md:mt-0 mt-12">
                            <div class="absolute left-0">
                                <img
                                    class="h-8 z-0 opacity-20"
                                    :class="isDark() ? 'dark-icon' : ''"
                                    src="/images/icons/left-quote.svg"
                                    alt=""
                                />
                            </div>
                            <div
                                class="
                                    mt-6
                                    p-4
                                    relative
                                    text-justify
                                    whitespace-pre-wrap
                                "
                            >
                                {{ ftso.extended_description }}
                            </div>
                        </div>

                        <!-- <you-tube
                            v-if="ftso.feature_video"
                            :videoId="ftso.feature_video"
                            maxWidth="460px"
                        /> -->
                        <!-- <div
                            class="video-container"
                            v-if="ftso.feature_video"
                            v-html="embedYoutube(ftso.feature_video)"
                        ></div> -->
                    </div>
                    <div class="col-span-4 grid grid-cols-8"></div>

                    <!-- Overview  -->

                    <!-- <div class="col-span-12 w-full h-10 bg-red-200"></div> -->
                </div>
                <div class="grid grid-cols-6">
                    <div class="col-span-6 mb-2 font-semibold text-gray-800">
                        Reward Ratio
                    </div>
                    <div
                        class="
                            col-span-6
                            md:col-span-4
                            h-36
                            md:h-72
                            w-full
                            pr-2
                        "
                    >
                        <reward-state-graph
                            v-if="ftso.uid"
                            :provider_id="ftso.uid"
                        />
                    </div>
                    <div
                        v-if="loaded"
                        class="col-span-6 md:col-span-2 md:mb-0 mb-8"
                    >
                        <div
                            class="
                                bg-gray-50
                                dark:bg-gray-600
                                h-72
                                rounded-md
                                md:mt-0
                                mt-8
                            "
                        >
                            <div
                                class="
                                    dark:text-gray-200
                                    border-b border-gray-200
                                    font-semibold font-lato
                                    pl-2
                                    py-1
                                    text-sm
                                "
                            >
                                Overview
                            </div>
                            <div class="grid grid-cols-4 text-sm mt-1">
                                <div
                                    class="
                                        col-span-2
                                        ml-2
                                        my-1
                                        text-gray-500
                                        dark:text-gray-300
                                    "
                                >
                                    Verified
                                </div>
                                <div class="col-span-2 my-1">
                                    <img
                                        class="h-4"
                                        :src="
                                            ftso.verified
                                                ? '/images/icons/verified.svg'
                                                : '/images/icons/unverified.svg'
                                        "
                                        alt="Verified Icon"
                                    />
                                </div>

                                <div
                                    class="
                                        col-span-2
                                        ml-2
                                        my-1
                                        text-gray-500
                                        dark:text-gray-300
                                    "
                                >
                                    Vote Power
                                </div>
                                <div class="col-span-2 my-1 dark:text-gray-400">
                                    <span
                                        v-if="ftso.votepower == 'N/A'"
                                        class="text-gray-600"
                                        >N/A</span
                                    >
                                    <span v-else
                                        >{{
                                            parseFloat(
                                                ftso.votepower
                                            ).toLocaleString(undefined, {
                                                minimumFractionDigits: 0,
                                                maximumFractionDigits: 0,
                                            })
                                        }}
                                        <span class="text-xs text-gray-600"
                                            >SGB</span
                                        ></span
                                    >
                                </div>

                                <div
                                    class="
                                        col-span-2
                                        ml-2
                                        my-1
                                        text-gray-500
                                        dark:text-gray-300
                                    "
                                >
                                    Fee
                                </div>
                                <div class="col-span-1 my-1 dark:text-gray-400">
                                    <span
                                        v-if="ftso.votepower == 'N/A'"
                                        class="text-gray-600"
                                        >N/A</span
                                    >
                                    <span v-else
                                        >{{ ftso.fee }}
                                        <span class="text-xs text-gray-600"
                                            >%</span
                                        ></span
                                    >
                                </div>
                                <!-- <div
                                    class="
                                        col-span-2
                                        ml-2
                                        my-1
                                        text-gray-500
                                        dark:text-gray-300
                                    "
                                >
                                    Local
                                </div>
                                <div class="col-span-1 my-1">
                                    {{ ftso.info.local }}
                                </div> -->

                                <div
                                    class="
                                        col-span-2
                                        ml-2
                                        my-1
                                        text-gray-500
                                        dark:text-gray-300
                                    "
                                >
                                    Country
                                </div>
                                <div class="col-span-1 my-1 dark:text-gray-400">
                                    {{ ftso.info.country }}
                                </div>
                                <div
                                    class="
                                        col-span-2
                                        ml-2
                                        my-1
                                        text-gray-500
                                        dark:text-gray-300
                                    "
                                >
                                    Established
                                </div>
                                <div class="col-span-1 my-1 dark:text-gray-400">
                                    {{ ftso.info.established }}
                                </div>
                                <div
                                    class="
                                        col-span-2
                                        ml-2
                                        my-1
                                        text-gray-500
                                        dark:text-gray-300
                                    "
                                >
                                    Flare Address
                                </div>
                                <div
                                    class="
                                        col-span-1
                                        my-1
                                        dark:text-gray-400
                                        flex
                                    "
                                >
                                    <div v-if="ftso.flare_address" class="flex">
                                        {{
                                            truncate(
                                                ftso.flare_address,
                                                "16",
                                                "..."
                                            )
                                        }}
                                        <div
                                            @click="
                                                copyToClipBoard(
                                                    ftso.flare_address
                                                )
                                            "
                                        >
                                            <svg
                                                class="
                                                    fill-current
                                                    text-gray-400
                                                    hover:text-gray-500
                                                    h-4
                                                    w-4
                                                    ml-2
                                                    cursor-pointer
                                                "
                                                viewBox="-40 0 512 512"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    d="m271 512h-191c-44.113281 0-80-35.886719-80-80v-271c0-44.113281 35.886719-80 80-80h191c44.113281 0 80 35.886719 80 80v271c0 44.113281-35.886719 80-80 80zm-191-391c-22.054688 0-40 17.945312-40 40v271c0 22.054688 17.945312 40 40 40h191c22.054688 0 40-17.945312 40-40v-271c0-22.054688-17.945312-40-40-40zm351 261v-302c0-44.113281-35.886719-80-80-80h-222c-11.046875 0-20 8.953125-20 20s8.953125 20 20 20h222c22.054688 0 40 17.945312 40 40v302c0 11.046875 8.953125 20 20 20s20-8.953125 20-20zm0 0"
                                                />
                                            </svg>
                                        </div>
                                    </div>
                                    <div v-else class="text-gray-600">N/A</div>
                                </div>
                                <div
                                    class="
                                        col-span-2
                                        ml-2
                                        my-1
                                        text-gray-500
                                        dark:text-gray-300
                                    "
                                >
                                    Songbird Address
                                </div>
                                <div class="col-span-1 my-1 dark:text-gray-400">
                                    <div
                                        v-if="ftso.songbird_address"
                                        class="flex"
                                    >
                                        {{
                                            truncate(
                                                ftso.songbird_address,
                                                "16",
                                                "..."
                                            )
                                        }}
                                        <div
                                            @click="
                                                copyToClipBoard(
                                                    ftso.songbird_address
                                                )
                                            "
                                        >
                                            <svg
                                                class="
                                                    fill-current
                                                    text-gray-400
                                                    hover:text-gray-500
                                                    h-4
                                                    w-4
                                                    ml-2
                                                    cursor-pointer
                                                "
                                                viewBox="-40 0 512 512"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    d="m271 512h-191c-44.113281 0-80-35.886719-80-80v-271c0-44.113281 35.886719-80 80-80h191c44.113281 0 80 35.886719 80 80v271c0 44.113281-35.886719 80-80 80zm-191-391c-22.054688 0-40 17.945312-40 40v271c0 22.054688 17.945312 40 40 40h191c22.054688 0 40-17.945312 40-40v-271c0-22.054688-17.945312-40-40-40zm351 261v-302c0-44.113281-35.886719-80-80-80h-222c-11.046875 0-20 8.953125-20 20s8.953125 20 20 20h222c22.054688 0 40 17.945312 40 40v302c0 11.046875 8.953125 20 20 20s20-8.953125 20-20zm0 0"
                                                />
                                            </svg>
                                        </div>
                                    </div>
                                    <div v-else class="text-gray-600">N/A</div>
                                </div>
                                <div
                                    class="
                                        col-span-2
                                        ml-2
                                        my-1
                                        text-gray-500
                                        dark:text-gray-300
                                    "
                                >
                                    Website
                                </div>
                                <div class="col-span-1 my-1 dark:text-gray-400">
                                    <a
                                        target="_blank"
                                        :href="`${ftso.website_url}?ref=flaremetrics.io`"
                                        class="
                                            text-indigo-700
                                            dark:text-indigo-300
                                        "
                                        >{{
                                            ftso.website_url
                                                .replace("https://", "")
                                                .replace("www", "")
                                        }}</a
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input
                    id="copy_text"
                    class="hidden border-none text-white"
                    type="text"
                />
                <!-- <div class="pb-8">
                    <div class="flex font-semibold font-lato mb-2">
                        <span class="dark:text-gray-200">Social Status</span>
                        <img
                            @click="tabs.social.visible = !tabs.social.visible"
                            class="
                                h-3
                                ml-1
                                mt-2
                                transition-transform
                                transform
                                cursor-pointer
                            "
                            :class="tabs.social.visible ? 'rotate-180' : ''"
                            src="/images/icons/arrow.svg"
                            alt=""
                        />
                    </div>
                    <transition name="fade">
                        <div id="social-tab" v-show="tabs.social.visible">
                            <div>
                                <div
                                    class="grid grid-cols-12 gap-2"
                                    v-if="loaded"
                                >
                                    <div class="col-span-6 md:col-span-2">
                                        <twitter-column
                                            v-if="ftso.socials.twitter"
                                            :username="ftso.socials.twitter"
                                        />
                                    </div>
                                    <div
                                        class="col-span-6 md:col-span-2"
                                        v-if="ftso.socials.youtube"
                                    >
                                        <youtube-column
                                            :channel_id="ftso.socials.youtube"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </transition>
                </div> -->
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import FtsoSignalsHolder from "../Components/FTSO/FtsoSignalsHolder.vue";
import TwitterColumn from "../Components/Social/TwitterColumn.vue";
import YoutubeColumn from "../Components/Social/YoutubeColumn.vue";
import YouTube from "../Components/Social/YouTube.vue";
import { Link } from "@inertiajs/inertia-vue3";
import RewardStateGraph from "../Components/FTSO/RewardStateGraph.vue";

export default {
    props: ["code", "isOwner"],
    components: {
        AppLayout,
        FtsoSignalsHolder,
        TwitterColumn,
        YoutubeColumn,
        YouTube,
        Link,
        RewardStateGraph,
    },

    data() {
        return {
            loaded: false,
            ftso: {
                code: "",
            },
            socials: [
                { name: "twitter", url: "https://twitter.com/" },
                { name: "youtube", url: "https://www.youtube.com/channel/" },
                { name: "discord", url: "https://discord.gg/" },
                { name: "telegram", url: "https://t.me/" },
            ],
            tabs: {
                social: {
                    visible: true,
                },
            },
        };
    },
    mounted: function () {
        this.getFTSO();
        if (this.$store.state.ftso.ftsoWhitelistedPriceProviders.length === 0) {
            this.$store.dispatch("getFtsoWhitelistedPriceProviders");
        }
    },
    methods: {
        getFTSO() {
            axios
                .get(
                    route("api.ftso.single", {
                        id: this.$props.code,
                    })
                )
                .then((response) => {
                    this.ftso = response.data;
                    // this.getVotePower();
                    this.parseMetrics();
                    this.getAddresses();
                    this.loaded = true;
                });
        },
        getAddresses() {
            this.ftso.pools.map((pool) => {
                if (pool.network == "songbird")
                    this.ftso.songbird_address = pool.address;
                if (pool.network == "flare")
                    this.ftso.flare_address = pool.address;
            });
        },
        parseMetrics() {
            this.ftso.pools.map((pool) => {
                if (pool.network == this.$store.state.chainName) {
                    this.ftso.votepower = pool.votepower;
                    this.ftso.fee = pool.fee / 100;
                }
            });
        },
        async getVotePower() {
            var address = "";
            this.ftso.pools.map((pool) => {
                if (pool.network == this.$store.state.chainName) {
                    address = pool.address;
                }
            });
            if (address == "") {
                return console.log(
                    "no pool found for this network",
                    this.$store.state.chainName
                );
            }

            var votepower = await this.$store.dispatch(
                "requestVotePowerOf",
                address
            );

            this.ftso.info.votepower = parseFloat(votepower).toLocaleString(
                undefined,
                { minimumFractionDigits: 2, maximumFractionDigits: 2 }
            );
        },
        embedYoutube(url) {
            var width = 560;
            var height = 315;
            var code = `<iframe  src="${url}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" ></iframe>`;
            return code;
        },
        isDark() {
            return localStorage.theme == "dark";
        },
        truncate(fullStr, strLen, separator) {
            try {
                if (fullStr.length <= strLen) return fullStr;

                separator = separator || "...";

                var sepLen = separator.length,
                    charsToShow = strLen - sepLen,
                    frontChars = Math.ceil(charsToShow / 2),
                    backChars = Math.floor(charsToShow / 2);

                return (
                    fullStr.substr(0, frontChars) +
                    separator +
                    fullStr.substr(fullStr.length - backChars)
                );
            } catch (error) {}
        },
        copyToClipBoard(value) {
            var copyText = document.getElementById("copy_text");
            copyText.classList.remove("hidden");
            copyText.value = value;

            /* Select the text field */
            copyText.select();
            copyText.setSelectionRange(0, 99999); /*For mobile devices*/
            /* Copy the text inside the text field */
            document.execCommand("copy");
            copyText.classList.add("hidden");
        },
    },
};
</script>
<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.dark-icon {
    filter: invert(1);
}
.dark-logo {
    filter: invert(1) grayscale(1) brightness(1.5);
}

.video-container {
    overflow: hidden;
    position: relative;
    width: 100%;
}

.video-container::after {
    padding-top: 56.25%;
    display: block;
    content: "";
}

.video-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
</style>
