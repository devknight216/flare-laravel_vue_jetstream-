<template>
    <app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden">
                    <update-ftso-form :code="code" :provider="provider" />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import UpdateFtsoForm from "../../Components/FTSO/UpdateFtsoForm.vue";

export default {
    props: ["code", "provider"],
    components: {
        AppLayout,
        UpdateFtsoForm,
    },
};
</script>
