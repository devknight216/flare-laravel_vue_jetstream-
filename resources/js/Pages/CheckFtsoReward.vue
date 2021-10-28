<template>
    <app-layout :hide_bg="true">
        <div
            class="
                max-w-7xl
                mx-auto
                px-4
                sm:px-6
                lg:px-8
                mt-8
                mb-12
                flex
                justify-center
            "
        >
            <!-- <check-rewards-by-address /> -->
            <check-rewards-by-address v-if="$page.props.user == null" />
            <user-ftso-rewards v-else />
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import CheckRewardsByAddress from "../Components/Services/CheckRewardsByAddress.vue";
import UserFtsoRewards from "../Components/Services/UserFtsoRewards.vue";

export default {
    components: {
        AppLayout,
        CheckRewardsByAddress,
        UserFtsoRewards,
    },

    data() {
        return {};
    },
    mounted: function () {
        console.log();
    },
    computed: {},
    methods: {},
};
</script>
<style scoped>
.list-height {
    max-height: 650px;
}
</style>
