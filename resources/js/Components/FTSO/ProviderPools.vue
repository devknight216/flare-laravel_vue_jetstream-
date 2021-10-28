<template>
    <div>
        <div class="flex">
            <h2 class="text-gray-800 font-semibold text-lg">Pools</h2>
            <div class="w-full text-right text-indigo-700">
                <button class="p-2" @click="createPoolModal()">
                    <svg
                        class="fill-current text-indigo-700 h-4 w-4"
                        viewBox="0 0 469.33333 469.33333"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="m437.332031 192h-160v-160c0-17.664062-14.335937-32-32-32h-21.332031c-17.664062 0-32 14.335938-32 32v160h-160c-17.664062 0-32 14.335938-32 32v21.332031c0 17.664063 14.335938 32 32 32h160v160c0 17.664063 14.335938 32 32 32h21.332031c17.664063 0 32-14.335937 32-32v-160h160c17.664063 0 32-14.335937 32-32v-21.332031c0-17.664062-14.335937-32-32-32zm0 0"
                        />
                    </svg>
                </button>
            </div>
        </div>
        <table
            class="
                w-full
                shadow
                text-left
                bg-white
                dark:bg-gray-800
                rounded-md
                block
                h-52
                overflow-y-scroll
            "
        >
            <thead>
                <tr
                    class="
                        border-b border-gray-300
                        dark:border-gray-200
                        sticky
                        top-0
                        bg-white
                    "
                >
                    <th
                        class="
                            py-3
                            pl-2
                            sm:pl-10
                            w-1/4
                            text-base
                            dark:text-gray-100
                            text-gray-800
                            sticky
                        "
                    >
                        Name
                    </th>
                    <th
                        class="
                            py-3
                            w-1/4
                            text-base
                            dark:text-gray-100
                            text-gray-800
                            pr-8
                        "
                    >
                        Description
                    </th>
                    <th
                        class="
                            py-3
                            w-1/4
                            text-base
                            dark:text-gray-100
                            text-gray-800
                            pl-6
                        "
                    >
                        Network
                    </th>
                    <th
                        class="
                            py-3
                            w-1/4
                            text-base
                            dark:text-gray-100
                            text-gray-800 text-right
                        "
                    >
                        Address
                    </th>
                    <th
                        class="
                            py-3
                            text-base
                            dark:text-gray-100
                            text-gray-800 text-right
                            pr-2
                            sm:pr-10
                        "
                    ></th>
                </tr>
            </thead>
            <tbody class="">
                <tr
                    v-for="(pool, i) in pools"
                    :key="i"
                    class="border-b border-gray-200 py-2"
                >
                    <td class="pl-10 pr-2 py-4">
                        <p
                            class="
                                dark:text-gray-100
                                text-gray-800 text-sm
                                truncate
                                w-24
                            "
                        >
                            {{ pool.name }}
                        </p>
                    </td>
                    <td class="pr-2 text-gray-800 text-xs sm:text-sm">
                        <p
                            class="
                                dark:text-gray-100
                                text-gray-800 text-xs
                                sm:text-sm
                                truncate
                                w-48
                            "
                        >
                            {{ pool.description }}
                        </p>
                    </td>
                    <td
                        class="
                            pr-2
                            pl-6
                            text-green-400 text-xs
                            sm:text-sm
                            capitalize
                        "
                    >
                        <span
                            class="px-2 rounded-full"
                            :class="
                                pool.network == 'flare'
                                    ? 'bg-green-200 text-green-800'
                                    : pool.network == 'songbird'
                                    ? 'bg-red-200 text-red-800'
                                    : 'bg-blue-200 text-blue-800'
                            "
                        >
                            {{ pool.network }}
                        </span>
                    </td>
                    <td
                        class="
                            dark:text-gray-100
                            text-gray-800 text-xs
                            sm:text-sm
                            text-right
                        "
                    >
                        <p class="truncate w-36">{{ pool.address }}</p>
                    </td>
                    <td class="text-right pr-1">
                        <div class="flex justify-end pr-2">
                            <div
                                :title="
                                    pool.approved
                                        ? 'Approved'
                                        : 'Pending Approval'
                                "
                                class="h-3 w-3 rounded-full"
                                :class="
                                    pool.approved
                                        ? 'border-green-700 bg-green-600'
                                        : 'border-yellow-600 bg-yellow-400'
                                "
                            ></div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <teleport to="#teleport-target">
        <add-pool @poolAdded="getPools()" :code="code" ref="add_pool" />
    </teleport>
</template>
<script>
import AddPool from "./Manager/AddPool.vue";
export default {
    components: {
        AddPool,
    },
    props: ["code"],
    data: () => {
        return {
            pools: [],
        };
    },
    mounted: function () {
        this.getPools();
    },
    methods: {
        createPoolModal() {
            this.$refs.add_pool.modalHandler(true);
        },
        getPools() {
            axios
                .get(route("get.provider.pools"), {
                    params: { code: this.$props.code },
                })
                .then((response) => {
                    if (response.data.error) {
                        console.error(response.data.message);
                    }
                    this.pools = response.data.pools;
                });
        },
    },
};
</script>
<style scoped></style>
