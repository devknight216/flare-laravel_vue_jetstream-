<template>
    <div class="md:h-36 rounded md:flex">
        <img class="hidden md:block h-24 my-auto" :src="image" alt="" />
        <div class="md:ml-12 my-auto">
            <div class="flex mb-4">
                <img class="block md:hidden h-10 my-auto" :src="image" alt="" />
                <div class="ml-2 md:ml-0">
                    <div class="text-xl">{{ title }}</div>
                    <div class="text-sm text-gray-600">{{ subtitle }}</div>
                </div>
            </div>
            <div class="">
                <slot></slot>
            </div>
            <div class="text-xs text-indigo-700 hover:text-indigo-500">
                <inertia-link :href="href">View Now</inertia-link>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        image: {
            required: true,
        },
        title: {
            required: true,
        },
        subtitle: {
            required: true,
        },
        href: {
            required: true,
        },
    },
    data: () => {
        return {};
    },
    mounted: function () {},
    methods: {},
};
</script>
<style scoped></style>
