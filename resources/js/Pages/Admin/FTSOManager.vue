<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                FTSO Manager
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex">
                    <div
                        @click="mode = 1"
                        class="pr-2 text-sm text-indigo-700 cursor-pointer"
                        :class="mode == 1 ? 'font-bold' : ''"
                    >
                        Provider Listings
                    </div>
                    <div
                        @click="mode = 2"
                        class="text-sm text-indigo-700 cursor-pointer"
                        :class="mode == 2 ? 'font-bold' : ''"
                    >
                        Provider Pools
                    </div>
                </div>
                <ftso-applications-table v-if="mode == 1" />
                <provider-pool-table v-if="mode == 2" />
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import FtsoApplicationsTable from "../../Components/Admin/FtsoApplicationsTable.vue";
import ProviderPoolTable from "../../Components/Admin/ProviderPoolTable.vue";

export default {
    data() {
        return {
            mode: 2, // 1:Applications 2:Provider Pools
        };
    },
    components: {
        AppLayout,
        FtsoApplicationsTable,
        ProviderPoolTable,
    },
};
</script>
