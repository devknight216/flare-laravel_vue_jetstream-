<template>
    <div class="w-full h-full overflow-x-hidden">
        <div class="text-gray-800 font-semibold text-lg">Applications</div>
        <div class="container mx-auto">
            <table class="w-full text-left bg-white dark:bg-gray-800">
                <thead>
                    <tr class="border-b border-gray-300 dark:border-gray-700">
                        <th
                            class="
                                py-5
                                w-1/3
                                text-base text-gray-800
                                dark:text-gray-100
                            "
                        >
                            Type
                        </th>
                        <th
                            class="
                                py-5
                                w-1/3
                                text-base text-gray-800
                                dark:text-gray-100
                            "
                        >
                            Date
                        </th>
                        <th
                            class="
                                py-5
                                w-1/3
                                text-base text-gray-800
                                dark:text-gray-100
                                text-right
                            "
                        >
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(application, i) in applications" :key="i">
                        <td
                            class="
                                py-2
                                text-gray-800
                                dark:text-gray-100
                                text-xs
                                sm:text-sm
                                capitalize
                            "
                        >
                            {{ application.type }}
                        </td>
                        <td
                            class="
                                py-2
                                text-gray-800
                                dark:text-gray-100
                                text-xs
                                sm:text-sm
                            "
                        >
                            {{ application.created_at }}
                        </td>

                        <td
                            class="
                                py-2
                                text-xs
                                sm:text-sm
                                text-right
                                capitalize
                            "
                            :class="
                                application.status == 'pending'
                                    ? 'text-yellow-600'
                                    : application.status == 'rejected'
                                    ? 'text-red-700'
                                    : application.status == 'approved'
                                    ? 'text-green-700'
                                    : ''
                            "
                        >
                            {{ application.status }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div v-if="applications.length == 4" class="text-xs text-gray-400">
                Displaying last 4 applications...
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "ApplicationsList",
    props: ["code"],
    data() {
        return {
            applications: [],
        };
    },
    mounted: function () {
        axios
            .get(route("get.provider.applications"), {
                params: {
                    code: this.$props.code,
                },
            })
            .then((response) => {
                this.applications = response.data;
            });
    },
};
</script>
