<template>
    <app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden">
                    <register-ftso-form />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import RegisterFtsoForm from "../../Components/FTSO/RegisterFtsoForm.vue";

export default {
    components: {
        AppLayout,
        RegisterFtsoForm,
    },
};
</script>
