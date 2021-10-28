<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                FTSO Manager
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="w-full flex">
                        <div
                            @click="mode = 1"
                            class="
                                cursor-pointer
                                font-bold
                                p-5
                                hover:bg-indigo-200 hover:text-white
                            "
                        >
                            Add
                        </div>
                        <div
                            @click="mode = 2"
                            class="
                                cursor-pointer
                                font-bold
                                p-5
                                hover:bg-indigo-200 hover:text-white
                            "
                        >
                            Edit
                        </div>
                    </div>
                    <div v-if="mode == 1" class="w-full">
                        <add-ftso />
                    </div>
                    <div v-if="mode == 2" class="w-full">
                        <modify-ftso />
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Welcome from "@/Jetstream/Welcome";
import AddFtso from "../../Components/FTSO/Manager/AddFtso.vue";
import ModifyFtso from "../../Components/FTSO/Manager/ModifyFtso.vue";

export default {
    data() {
        return {
            mode: 1, // 1:Add, 2:Edit
        };
    },
    components: {
        AppLayout,
        Welcome,
        AddFtso,
        ModifyFtso,
    },
};
</script>
