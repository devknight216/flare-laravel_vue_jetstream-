<template>
    <app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden">
                    <assess-application-form
                        :id="id"
                        :application="application"
                    />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import AssessApplicationForm from "../../Components/FTSO/AssessApplicationForm.vue";

export default {
    props: ["id", "application"],
    components: {
        AppLayout,
        AssessApplicationForm,
    },
};
</script>
