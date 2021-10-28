<template>
    <div class="sm:max-w-2xl pb-10 rounded-lg">
        <div class="flex justify-between items-center">
            <p
                class="
                    text-xl
                    font-semibold
                    leading-tight
                    text-gray-800
                    dark:text-gray-100
                "
            >
                FTSO Providers
            </p>
            <div
                @click="$inertia.get(route('view.ftso'))"
                class="
                    cursor-pointer
                    text-sm text-indigo-700
                    dark:text-indigo-300
                    text-right
                    pr-2
                "
            >
                View All
            </div>
        </div>

        <div class="w-full mt-6 overflow-x-scroll xl:overflow-x-hidden">
            <table class="w-full">
                <thead
                    class="
                        w-full
                        text-xs
                        sm:text-base
                        font-medium
                        leading-none
                        text-gray-500
                        dark:text-gray-400
                    "
                >
                    <tr class="border-b border-gray-200">
                        <td class="pb-4">Name</td>
                        <td class="pb-4 pl-4">Vote Power</td>
                        <td class="pl-14 pb-4 text-right pr-2">Fee</td>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(item, i) in limited_list"
                        :key="i"
                        class="
                            text-xs
                            sm:text-base
                            leading-none
                            text-gray-800
                            dark:text-gray-100
                        "
                    >
                        <td class="pt-6 w-2/4">
                            <div class="flex items-center">
                                <div
                                    class="
                                        w-8
                                        h-8
                                        flex
                                        items-center
                                        justify-center
                                    "
                                >
                                    <img
                                        :class="
                                            getTheme == 'dark'
                                                ? 'dark-logo'
                                                : ''
                                        "
                                        :src="item.emblem"
                                        alt=""
                                    />
                                </div>
                                <p class="ml-3">{{ item.name }}</p>
                            </div>
                        </td>
                        <td class="pt-6 w-1/4 pl-4">
                            {{
                                parseFloat(item.votepower).toLocaleString(
                                    undefined,
                                    {
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: 0,
                                    }
                                )
                            }}
                        </td>
                        <td class="pt-6 w-1/4 pl-14 text-right pr-2">
                            {{ item.fee }}%
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
import { mapGetters } from "vuex";

export default {
    components: {},
    data() {
        return {
            ftso_list: [],
            params: {
                q: "",
                hide_unverified: false,
            },
        };
    },
    mounted: async function () {
        await this.$store.dispatch("getFtsoList", this.params);
    },
    computed: {
        ...mapGetters(["getFtsoListWithMetrics", "getTheme"]),
        limited_list: function () {
            var array = this.getFtsoListWithMetrics;
            var n = Math.abs(5 - array.length);
            array.splice(array.length - n, array.length);
            return array;
        },
    },
    methods: {
        getList() {
            axios
                .get(route("api.ftso.list"), { params: this.params })
                .then(async (response) => {
                    this.ftso_list = response.data;
                    this.parseMetrics();
                    this.$store.dispatch("requestWnatSupply");
                });
        },
    },
};
</script>
<style scoped>
.dark-logo {
    filter: grayscale(100%) invert(1) brightness(2);
}
/* .dark-logo {
    filter: invert(1) grayscale(1) brightness(1.5);
} */
</style>
