<template>
    <div class="bg-gray-50 dark:bg-gray-600 rounded-md w-full dark:text-white">
        <div class="flex py-3">
            <img
                class="ml-4 h-8"
                src="/images/icons/socials/youtube.svg"
                alt="Youtube"
            />
            <div class="my-auto ml-2 font-lato text-lg">Youtube</div>
        </div>
        <div id="stats" class="ml-3">
            <div class="flex py-2">
                <!-- <img
                class="ml-6 h-6 opacity-50"
                src="/images/icons/followers.svg"
                alt="Follower"
            /> -->
                <div class="my-auto ml-2 font-lato">
                    {{ youtube.statistics.subscriberCount }}
                    <span class="text-xs text-gray-400 dark:text-gray-200"
                        >Subscribers</span
                    >
                </div>
            </div>
            <div class="flex py-2">
                <!-- <img
                class="ml-6 h-6 opacity-50"
                src="/images/icons/hashtag.svg"
                alt="Tweets"
            /> -->
                <div class="my-auto ml-2 font-lato">
                    {{ youtube.statistics.videoCount }}
                    <span class="text-xs text-gray-400 dark:text-gray-200"
                        >Video Count</span
                    >
                </div>
            </div>

            <div class="flex py-2">
                <!-- <img
                class="ml-6 h-6 opacity-50"
                src="/images/icons/created.svg"
                alt="Tweets"
            /> -->
                <div class="my-auto ml-2 font-lato">
                    {{ convertDate(youtube.snippet.publishedAt) }}
                    <span class="text-xs text-gray-400 dark:text-gray-200"
                        >Registered</span
                    >
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        channel_id: {
            required: true,
        },
    },
    data() {
        return {
            loaded: false,
            youtube: {
                snippet: {
                    public_metrics: {},
                },
                statistics: {},
            },
        };
    },
    mounted: function () {
        this.getYoutube();
    },
    methods: {
        getYoutube() {
            axios
                .get(
                    route("api.youtube.statistics", {
                        channel_id: this.$props.channel_id,
                    })
                )
                .then((response) => {
                    this.youtube = response.data;
                    this.loaded = true;
                });
        },
        convertDate(date) {
            if (date) {
                var d = new Date(date);
                return d.toLocaleDateString();
            }
            return "";
        },
    },
};
</script>
