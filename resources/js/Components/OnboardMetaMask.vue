<template>
    <div
        class="pl-1 text-indigo-700 hover:underline cursor-pointer font-bold"
        @click="onboarding.startOnboarding()"
    >
        Install MetaMask
    </div>
</template>

<script>
import MetaMaskOnboarding from "@metamask/onboarding";

export default {
    data: () => {
        return {
            onboarding: null,
        };
    },
    mounted: function () {
        this.onboarding = new MetaMaskOnboarding();
    },
    methods: {},
};
</script>
<style scoped></style>
