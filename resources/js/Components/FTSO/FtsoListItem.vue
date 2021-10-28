<template>
    <div
        @click="select(index)"
        class="relative grid grid-cols-12 bg-gray-50 dark:bg-gray-200 rounded-sm hover:shadow mb-4 cursor-pointer"
        :class="selected ? 'shadow' : ''"
    >
        <div class="absolute right-0 m-3">
            <img
                class="h-5"
                :src="
                    ftso.verified
                        ? '/images/icons/verified.svg'
                        : '/images/icons/unverified.svg'
                "
                alt=""
            />
        </div>
        <div class="col-span-2">
            <div class="my-auto p-3 md:p-6 max-h-18">
                <img class="max-h-16" :src="ftso.emblem" alt="" />
            </div>
        </div>
        <div class="col-span-10">
            <div class="ml-2 md:ml-0 mt-4 text-lg font-semibold">
                {{ ftso.name }}
            </div>
            <!-- 156 Chars Max-->
            <div class="hidden md:block text-sm mr-4">
                {{ ftso.description }}
            </div>
            <div
                id="website-url"
                class="ml-2 md:ml-0 mb-2 md:mb-0 md:mt-2 text-xs text-indigo-700"
            >
                <a :href="ftso.websiteURL" target="_blank">{{
                    ftso.website
                }}</a>
                <span class="text-gray-300 dark:text-gray-500">
                    / {{ ftso.info.local }}</span
                >
            </div>
        </div>
        <div class="absolute right-0 bottom-0 mr-3 mb-2">
            <img
                class="h-3 opacity-25"
                :class="selected ? 'transform rotate-180 md:rotate-90' : ''"
                src="/images/icons/arrow.svg"
                alt=""
            />
        </div>
    </div>
</template>

<script>
export default {
    props: {
        ftso: {
            required: true,
        },
        index: {
            required: true,
        },
        selected: {
            required: true,
        },
    },
    data: () => {
        return {};
    },
    mounted: function () {},
    methods: {
        select(index) {
            this.$emit("select", index);
        },
    },
};

// This is your chance to talk about your Flare Time Series Oracle. We're
// allowing a maximum of 234 characters so choose your words wisely in this
// description.

// If your FTSO item is selected you will have the oppertunity to talk more about your FTSO to give the viewer a better idea of who you are, your goals and achievments. Also, perhaps why they should join you?
</script>
<style scoped></style>
