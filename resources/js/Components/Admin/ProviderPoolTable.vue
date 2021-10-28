<template>
    <div>
        <div class="border rounded-lg border-gray-100">
            <div class="py-4 md:py-6 pl-8">
                <div class="grid grid-cols-5 gap-3">
                    <div class="col-span-3">
                        <p
                            tabindex="0"
                            class="
                                focus:outline-none
                                text-base
                                md:text-lg
                                lg:text-xl
                                font-bold
                                leading-tight
                                text-gray-800
                            "
                        >
                            Provider Pools
                        </p>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr
                            class="
                                bg-gray-50
                                h-16
                                w-full
                                text-sm
                                leading-none
                                text-gray-800
                            "
                        >
                            <th
                                tabindex="0"
                                class="
                                    focus:outline-none
                                    font-normal
                                    text-left
                                    pl-8
                                "
                            >
                                Provider
                            </th>
                            <th
                                tabindex="0"
                                class="
                                    focus:outline-none
                                    font-normal
                                    text-left
                                    px-10
                                    lg:px-6
                                    xl:px-0
                                "
                            >
                                Pool name
                            </th>
                            <th
                                tabindex="0"
                                class="
                                    focus:outline-none
                                    font-normal
                                    text-left
                                    px-10
                                    lg:px-6
                                    xl:px-0
                                "
                            >
                                Pool Description
                            </th>
                            <th
                                tabindex="0"
                                class="
                                    focus:outline-none
                                    font-normal
                                    text-left
                                    px-10
                                    lg:px-6
                                    xl:px-0
                                "
                            >
                                Address
                            </th>
                            <th
                                tabindex="0"
                                class="
                                    focus:outline-none
                                    font-normal
                                    text-left
                                    px-10
                                    lg:px-6
                                    xl:px-0
                                "
                            >
                                Network
                            </th>

                            <th
                                tabindex="0"
                                class="focus:outline-none font-normal text-left"
                            >
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="w-full">
                        <tr
                            v-for="pool in pools"
                            :key="pool.id"
                            class="
                                h-20
                                text-sm
                                leading-none
                                text-gray-800
                                border-b border-gray-100
                            "
                        >
                            <td tabindex="0" class="focus:outline-none pl-8">
                                <p class="mt-2">{{ pool.provider_name }}</p>
                            </td>
                            <td
                                tabindex="0"
                                class="
                                    focus:outline-none
                                    font-medium
                                    px-10
                                    lg:px-6
                                    xl:px-0
                                "
                            >
                                <div class="flex">
                                    <p
                                        tabindex="0"
                                        class="
                                            focus:outline-none
                                            text-gray-600
                                            font-normal
                                            mt-2
                                        "
                                    >
                                        {{ pool.name }}
                                    </p>
                                </div>
                            </td>
                            <td
                                tabindex="0"
                                class="
                                    focus:outline-none
                                    font-medium
                                    px-10
                                    lg:px-6
                                    xl:px-0
                                "
                            >
                                <div class="flex">
                                    <img
                                        :src="pool.emblem"
                                        class="h-6"
                                        alt=""
                                    />
                                    <p
                                        tabindex="0"
                                        class="
                                            focus:outline-none
                                            text-gray-600
                                            font-normal
                                            mt-2
                                        "
                                    >
                                        {{ pool.description }}
                                    </p>
                                </div>
                            </td>

                            <td class="px-10 lg:px-6 xl:px-0">
                                <div
                                    class="
                                        flex
                                        items-center
                                        justify-center
                                        w-56
                                        h-6
                                        rounded-full
                                        capitalize
                                        bg-indigo-200
                                    "
                                >
                                    <p
                                        tabindex="0"
                                        class="
                                            focus:outline-none
                                            text-xs
                                            leading-3
                                            text-indigo-800
                                            truncate
                                            px-1
                                        "
                                    >
                                        {{ pool.address }}
                                    </p>
                                </div>
                            </td>

                            <td class="px-10 lg:px-6 xl:px-0">
                                <div
                                    class="
                                        flex
                                        items-center
                                        justify-center
                                        w-20
                                        h-6
                                        rounded-full
                                    "
                                    :class="
                                        pool.network == 'flare'
                                            ? 'bg-green-200 text-green-800'
                                            : pool.network == 'songbird'
                                            ? 'bg-red-200 text-red-800'
                                            : 'bg-blue-200 text-blue-800'
                                    "
                                >
                                    <p
                                        tabindex="0"
                                        class="
                                            focus:outline-none
                                            text-xs
                                            leading-3
                                        "
                                        :class="
                                            pool.status == 'pending'
                                                ? 'text-yellow-700'
                                                : pool.status == 'rejected'
                                                ? 'text-red-700'
                                                : 'text-green-800'
                                        "
                                    >
                                        <span class="capitalize">
                                            {{ pool.network }}</span
                                        >
                                    </p>
                                </div>
                            </td>

                            <td>
                                <div
                                    @click="approve(pool.id)"
                                    class="
                                        pb-2
                                        font-bold
                                        text-green-600
                                        cursor-pointer
                                    "
                                >
                                    Approve
                                </div>
                                <div class="text-red-600 cursor-pointer">
                                    Delete
                                </div>
                            </td>
                        </tr>
                        <div v-if="pools.length == 0" class="text-sm p-2">
                            No Events To Display
                        </div>
                    </tbody>
                </table>
                <div
                    class="w-full flex justify-center border-t border-gray-100"
                >
                    <div class="py-1">
                        <div class="flex pb-1 text-sm gap-2 select-none">
                            <span
                                :class="
                                    this.pagination.current_page == 1
                                        ? 'opacity-25'
                                        : 'cursor-pointer'
                                "
                                @click="prevPage()"
                                >Prev</span
                            >
                            |
                            <span
                                :class="
                                    this.pagination.current_page ==
                                    this.pagination.last_page
                                        ? 'opacity-25'
                                        : 'cursor-pointer'
                                "
                                @click="nextPage()"
                                >Next</span
                            >
                        </div>
                        <div class="flex text-sm">
                            Page {{ pagination.current_page }} of
                            {{ pagination.last_page }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <pay-referral-modal @saved="savedEvent" ref="modal" />
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
    components: { Link },
    data() {
        return {
            pools: [],
            pagination: {},
        };
    },
    mounted: function () {
        this.getPools();
    },
    methods: {
        getPools(page = 1) {
            axios
                .get(route("admin.get.provider.pools"), {
                    params: { code: this.$props.code, page: page },
                })
                .then((response) => {
                    this.pagination = response.data;
                    this.pools = response.data.data;
                });
        },
        approve(id) {
            axios
                .post(route("admin.approve.provider.pool"), { pool_id: id })
                .then((response) => {
                    this.getPools();
                });
        },

        nextPage() {
            if (this.pagination.current_page != this.pagination.last_page) {
                this.getPools(this.pagination.current_page + 1);
            }
        },
        prevPage() {
            if (this.pagination.current_page != 1) {
                this.getPools(this.pagination.current_page - 1);
            }
        },
    },
};
</script>
