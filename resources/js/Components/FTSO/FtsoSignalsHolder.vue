<template>
    <div class="flex">
        <div class="my-auto mr-2">
            <img
                class="h-6 opacity-10 hover:opacity-20 cursor-pointer"
                src="/images/icons/round-arrow.svg"
                alt=""
            />
        </div>
        <div class="w-full grid grid-cols-12 gap-2">
            <div class="col-span-3">
                <ftso-signal-item />
            </div>
            <div class="col-span-3">
                <ftso-signal-item />
            </div>
            <div class="col-span-3">
                <ftso-signal-item />
            </div>
            <div class="col-span-3">
                <ftso-signal-item />
            </div>
        </div>
        <div class="my-auto ml-2">
            <img
                class="
                    h-6
                    opacity-10
                    hover:opacity-20
                    cursor-pointer
                    transform
                    rotate-180
                "
                src="/images/icons/round-arrow.svg"
                alt=""
            />
        </div>
    </div>
</template>

<script>
import FtsoSignalItem from "./FtsoSignalItem.vue";
export default {
    components: { FtsoSignalItem },
    props: {},
    data: () => {
        return {};
    },
    mounted: function () {},

    methods: {},
};
</script>
