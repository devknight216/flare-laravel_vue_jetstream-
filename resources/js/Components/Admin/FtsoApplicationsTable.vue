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
                            Listing Applications
                        </p>
                    </div>
                    <div class="col-span-2 float-right flex gap-3">
                        <div class="flex gap-1 text-sm mt-1">
                            <label for="show_registrations_only">
                                Registrations:</label
                            ><br />

                            <input
                                @change="radioChanged()"
                                type="radio"
                                id="show_registrations_only"
                                value="register"
                                v-model="show_type"
                            />
                        </div>
                        <div class="flex gap-1 text-sm mt-1">
                            <label for="show_updates"> Updates:</label><br />
                            <input
                                @change="radioChanged()"
                                type="radio"
                                id="show_updates"
                                value="update"
                                v-model="show_type"
                            />
                        </div>
                        <div class="flex gap-1 text-sm mt-1">
                            <label for="show_all"> All:</label><br />
                            <input
                                @change="radioChanged()"
                                type="radio"
                                id="show_all"
                                value="all"
                                v-model="show_type"
                            />
                        </div>
                        <div class="flex gap-1 text-sm mt-1 mx-4">
                            <label for="pending_only"> Pending Only:</label
                            ><br />
                            <input
                                @change="radioChanged()"
                                type="checkbox"
                                id="pending_only"
                                value="true"
                                v-model="pending_only"
                            />
                        </div>
                        <!-- <div class="flex gap-1 text-sm mt-1">
                            <label for="show_qualified_only">
                                Qualified Only:</label
                            ><br />
                            <input
                                @change="toggleQualifiedOnly($event)"
                                id="show_qualified_only"
                                type="checkbox"
                                :checked="show_qualified_only"
                                :v-model="show_qualified_only"
                            />
                        </div> -->
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
                                ID
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
                                Application Date
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
                                Name
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
                                Type
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
                                Status
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
                                User ID
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
                                Admin Email
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
                                Website URL
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
                            v-for="event in applications"
                            :key="event.id"
                            class="
                                h-20
                                text-sm
                                leading-none
                                text-gray-800
                                border-b border-gray-100
                            "
                        >
                            <td tabindex="0" class="focus:outline-none pl-8">
                                <p class="mt-2">{{ event.id }}</p>
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
                                        {{ event.created_at }}
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
                                        :src="event.emblem"
                                        class="h-6 mr-2"
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
                                        {{ event.name }}
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
                                        bg-yellow-100
                                        rounded-full
                                        capitalize
                                    "
                                    :class="
                                        event.type == 'register'
                                            ? 'bg-indigo-200'
                                            : 'bg-pink-100'
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
                                            event.type == 'register'
                                                ? 'text-indigo-800'
                                                : 'text-pink-700'
                                        "
                                    >
                                        {{ event.type }}
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
                                        event.status == 'pending'
                                            ? 'bg-yellow-100'
                                            : event.status == 'rejected'
                                            ? 'bg-red-200'
                                            : 'bg-green-200'
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
                                            event.status == 'pending'
                                                ? 'text-yellow-700'
                                                : event.status == 'rejected'
                                                ? 'text-red-700'
                                                : 'text-green-800'
                                        "
                                    >
                                        <span class="capitalize">
                                            {{ event.status }}</span
                                        >
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
                                <p
                                    tabindex="0"
                                    class="
                                        focus:outline-none
                                        text-indigo-600
                                        font-bold
                                        mt-2
                                    "
                                >
                                    {{ event.user_id }}
                                </p>
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
                                <p
                                    tabindex="0"
                                    class="
                                        focus:outline-none
                                        text-gray-600
                                        font-normal
                                        mt-2
                                    "
                                >
                                    {{ event.admin_email }}
                                </p>
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
                                <p
                                    tabindex="0"
                                    class="
                                        focus:outline-none
                                        text-gray-600
                                        font-normal
                                        mt-2
                                    "
                                >
                                    {{ event.website_url }}
                                </p>
                            </td>

                            <td>
                                <Link
                                    :href="
                                        route(
                                            'admin.assess-applications',
                                            event.id
                                        )
                                    "
                                    class="
                                        text-sm
                                        leading-none
                                        text-indigo-700
                                        cursor-pointer
                                    "
                                >
                                    Assess
                                </Link>
                            </td>
                        </tr>
                        <div
                            v-if="applications.length == 0"
                            class="text-sm p-2"
                        >
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
            applications: [],
            pagination: {},
            show_type: "all",
            pending_only: [],
        };
    },
    mounted: function () {
        this.getApplications();
    },
    methods: {
        getApplications(page = 1) {
            axios
                .get(route("action.admin.get-applications"), {
                    params: {
                        show_type: this.show_type,
                        pending_only: this.pending_only[0],
                        page: page,
                    },
                })
                .then((response) => {
                    this.pagination = response.data;
                    this.applications = response.data.data;
                });
        },
        radioChanged() {
            this.getApplications();
        },
        nextPage() {
            if (this.pagination.current_page != this.pagination.last_page) {
                this.getEvents(this.pagination.current_page + 1);
            }
        },
        prevPage() {
            if (this.pagination.current_page != 1) {
                this.getEvents(this.pagination.current_page - 1);
            }
        },
    },
};
</script>
