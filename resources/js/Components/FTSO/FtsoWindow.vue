<template>
    <!-- <div class="border-gray-100 border-l"></div> -->
    <div
        v-if="ftso"
        class="
            relative
            bg-gray-50
            dark:bg-gray-200
            rounded
            md:ml-2
            w-full
            mb-6
            md:mb-0
            max-h-96
        "
    >
        <div
            class="
                font-semibold
                bg-gray-50
                dark:bg-gray-300
                border-b border-gray-200
                rounded-t
                w-full
            "
        >
            <div class="p-2 text-sm font-semibold uppercase">
                <img class="h-6" :src="ftso.logo" alt="" />
            </div>
        </div>
        <div class="text-sm font-semibold m-3 uppercase">
            {{ ftso.name }}
        </div>
        <div class="text-sm m-3">
            {{ ftso.extended_description }}
        </div>
        <div class="flex w-full m-3">
            <img class="h-4 opacity-50" src="/images/icons/star.svg" alt="" />
            <div class="text-sm font-semibold mx-2 text-gray-400">Founded</div>
            <div class="text-sm text-gray-800">
                {{ ftso.info.established }}
            </div>
        </div>
        <div class="flex w-full m-3">
            <img class="h-4 opacity-50" src="/images/icons/world.svg" alt="" />
            <div class="text-sm font-semibold mx-2 text-gray-400">Local</div>
            <div class="text-sm text-gray-800">
                {{ ftso.info.local }}
            </div>
        </div>
        <div class="flex w-full m-3">
            <img class="h-4 opacity-50" src="/images/icons/web.svg" alt="" />
            <div class="text-sm font-semibold mx-2 text-gray-400">Website</div>
            <div
                class="
                    cursor-pointer
                    text-sm text-gray-800
                    hover:text-indigo-700
                "
            >
                <a
                    :href="ftso.website_url + '?ref=flaremetrics.io'"
                    target="_blank"
                    >{{ ftso.website }}</a
                >
            </div>
        </div>
        <div class="flex w-full m-3">
            <inertia-link
                class="text-xs text-indigo-700"
                :href="`/ftso/providers/${ftso.code}`"
                >View Provider Profile</inertia-link
            >
        </div>
        <div class="inline-block mb-7"></div>
        <div id="socials" class="absolute bottom-0 flex w-full m-2">
            <div class="mx-1" v-for="(social, index) in socials" :key="index">
                <div v-if="ftso.socials[social.name]">
                    <a
                        :href="`${social.url}${ftso.socials[social.name]}`"
                        target="_blank"
                    >
                        <img
                            class="h-5 w-5"
                            :src="`/images/icons/socials/${social.name}.svg`"
                            alt=""
                        />
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div
        v-else
        class="
            relative
            bg-gray-50
            dark:bg-gray-200
            rounded
            md:ml-2
            w-full
            mb-6
            md:mb-0
            max-h-24
        "
    >
        <div
            class="
                font-semibold
                bg-gray-50
                dark:bg-gray-300
                border-b border-gray-200
                rounded-t
                w-full
            "
        >
            <div class="p-2 text-sm uppercase text-gray-300 dark:text-gray-600">
                FTSO Info
            </div>
        </div>
        <div class="text-sm m-3">
            Select an FTSO from the list to view more details.
        </div>
    </div>
</template>
<script>
export default {
    props: {
        ftso: {
            required: true,
        },
    },
    data: () => {
        return {
            socials: [
                { name: "twitter", url: "https://twitter.com/" },
                { name: "youtube", url: "https://www.youtube.com/channel/" },
                { name: "discord", url: "https://discord.gg/" },
                { name: "telegram", url: "https://t.me/" },
            ],
        };
    },
    mounted: function () {},
    methods: {
        select(index) {
            this.$emit("select", index);
        },
    },
};
</script>
<style scoped></style>
