<template>
    <div class="bg-gray-50 dark:bg-gray-600 rounded-md w-full dark:text-white">
        <div class="flex py-3">
            <img
                class="ml-4 h-8"
                src="/images/icons/socials/twitter.svg"
                alt="Twitter"
            />
            <div class="my-auto ml-2 font-lato text-lg">Twitter</div>
        </div>
        <div id="stats" class="ml-3">
            <div class="flex py-2">
                <!-- <img
                class="ml-6 h-6 opacity-50"
                src="/images/icons/followers.svg"
                alt="Follower"
            /> -->
                <div class="my-auto ml-2 font-lato">
                    {{ twitter.data.public_metrics.followers_count }}
                    <span class="text-xs text-gray-400 dark:text-gray-200"
                        >Followers</span
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
                    {{ twitter.data.public_metrics.tweet_count }}
                    <span class="text-xs text-gray-400 dark:text-gray-200"
                        >Tweets</span
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
                    {{ convertDate(twitter.data.created_at) }}
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
        username: {
            required: true,
        },
    },
    data() {
        return {
            loaded: false,
            twitter: {
                data: {
                    public_metrics: {},
                },
            },
        };
    },
    mounted: function () {
        this.getTwitter();
    },
    methods: {
        getTwitter() {
            if (this.$props.username == "" || this.$props.username == null) {
                return;
            }
            axios
                .get(
                    route("api.twitter.statistics", {
                        username: this.$props.username,
                    })
                )
                .then((response) => {
                    this.twitter = response.data;
                    this.loaded = true;
                })
                .catch((err) => {
                    console.log("Error getting twitter metrics.");
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
