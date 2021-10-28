<template>
    <app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="container pt-6 mx-auto">
                    <div class="mb-4">
                        <div class="text-gray-800 font-bold text-xl pb-2">
                            Provider
                            <span class="text-indigo-700">{{
                                provider.name
                            }}</span>
                            <span class="text-xs text-gray-400">BETA</span>
                        </div>
                        <p>
                            View and manage your FTSO Signal Provider listing.
                            <Link
                                :href="route('view.provider.update', code)"
                                class="
                                    text-indigo-700 text-xs
                                    leading-loose
                                    pt-1
                                "
                                >Update Provider Listing</Link
                            >
                        </p>
                    </div>
                    <div class="flex flex-wrap pb-4 border-b border-gray-200">
                        <div class="lg:w-2/3 w-full pb-6 lg:pb-0 lg:pr-6">
                            <div class="">
                                <div class="text-gray-800 font-semibold pb-2">
                                    7 Day Statistics
                                </div>
                                <ftso-page-statistics
                                    :code="code"
                                    period="7daysAgo"
                                />
                            </div>
                            <div class="pt-4">
                                <div class="text-gray-800 font-semibold pb-2">
                                    30 Day Statistics
                                </div>
                                <ftso-page-statistics
                                    :code="code"
                                    period="30daysAgo"
                                />
                            </div>
                        </div>
                        <div class="lg:w-1/3 w-full">
                            <!-- Remove class [ h-24 ] when adding a card block -->
                            <!-- Remove class [ border-gray-300  dark:border-gray-700 border-dashed border-2 ] to remove dotted border -->
                            <div class="">
                                <applications-list :code="code" />
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap pt-4">
                        <div class="lg:w-2/3 w-full pb-6 lg:pb-0 lg:pr-6">
                            <provider-pools :code="code" />
                            <div class="flex items-center mt-1">
                                <xml version="1.0" encoding="iso-8859-1" />
                                <svg
                                    class="
                                        fill-current
                                        text-gray-300
                                        h-4
                                        w-4
                                        mr-2
                                    "
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    viewBox="0 0 45.999 45.999"
                                    style="
                                        enable-background: new 0 0 45.999 45.999;
                                    "
                                    xml:space="preserve"
                                >
                                    <g>
                                        <g>
                                            <path
                                                d="M39.264,6.736c-8.982-8.981-23.545-8.982-32.528,0c-8.982,8.982-8.981,23.545,0,32.528c8.982,8.98,23.545,8.981,32.528,0
			C48.245,30.281,48.244,15.719,39.264,6.736z M25.999,33c0,1.657-1.343,3-3,3s-3-1.343-3-3V21c0-1.657,1.343-3,3-3s3,1.343,3,3V33z
			 M22.946,15.872c-1.728,0-2.88-1.224-2.844-2.735c-0.036-1.584,1.116-2.771,2.879-2.771c1.764,0,2.88,1.188,2.917,2.771
			C25.897,14.648,24.746,15.872,22.946,15.872z"
                                            />
                                        </g>
                                    </g>
                                </svg>

                                <p class="text-sm text-gray-500 mt-1">
                                    Pools are the addresses that your delegators
                                    will delegate their tokens to.
                                </p>
                            </div>
                        </div>
                        <div class="lg:w-1/3 w-full">
                            <div class=""></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import UpdateFtsoForm from "../../Components/FTSO/UpdateFtsoForm.vue";
import ApplicationsList from "../../Components/FTSO/ApplicationsList.vue";
import FtsoPageStatistics from "../../Components/FTSO/FtsoPageStatistics.vue";
import { Link } from "@inertiajs/inertia-vue3";
import ProviderPools from "../../Components/FTSO/ProviderPools.vue";
export default {
    components: {
        AppLayout,
        UpdateFtsoForm,
        ApplicationsList,
        FtsoPageStatistics,
        Link,
        ProviderPools,
    },
    props: ["code"],
    data() {
        return {
            provider: {
                name: "",
                seven_day_stats: {},
                thirty_day_stats: {},
            },
        };
    },
    mounted: function () {
        this.provider.name = this.$props.code;
    },
};
</script>
