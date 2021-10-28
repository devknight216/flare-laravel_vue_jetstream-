<template>
    <div id="layout-body">
        <jet-banner />

        <div class="min-h-screen bg-white dark:bg-ff-dark relative">
            <nav class="bg-gray-50 dark:bg-gray-700">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-2">
                    <div class="flex justify-between h-12 pt-2">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex-shrink-0 flex items-center">
                                <Link :href="route('view.home')">
                                    <img
                                        class="h-4"
                                        :src="
                                            !isDark
                                                ? '/images/flaremetrics-logo-sm.png'
                                                : '/images/flaremetrics-logo-sm-light.png'
                                        "
                                        alt=""
                                    />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div
                                class="
                                    hidden
                                    dark:text-white
                                    space-x-8
                                    sm:-my-px sm:ml-10
                                    md:flex
                                "
                            >
                                <!-- <jet-nav-link
                                    v-if="$page.props.user"
                                    :href="route('dashboard')"
                                    :active="route().current('dashboard')"
                                >
                                    Dashboard
                                </jet-nav-link> -->

                                <!-- <jet-nav-link
                                    :href="route('view.ftso')"
                                    :active="route().current('view.ftso')"
                                >
                                    FTSO List
                                </jet-nav-link>
                                <jet-nav-link
                                    :href="route('view.check-ftso-reward')"
                                    :active="
                                        route().current(
                                            'view.check-ftso-reward'
                                        )
                                    "
                                >
                                    Check Rewards
                                </jet-nav-link> -->
                                <jet-dropdown align="right" width="48">
                                    <template #trigger>
                                        <div
                                            class="
                                                mt-2
                                                items-center
                                                px-1
                                                pt-1
                                                pb-2
                                                border-b-2 border-transparent
                                                text-sm
                                                font-medium
                                                leading-5
                                                dark:text-white
                                                text-gray-500
                                                hover:text-gray-700
                                                hover:border-gray-300
                                                focus:outline-none
                                                focus:text-gray-700
                                                focus:border-gray-300
                                                transition
                                                duration-150
                                                ease-in-out
                                                cursor-pointer
                                            "
                                        >
                                            FTSO
                                        </div></template
                                    >

                                    <template #content>
                                        <!-- Account Management -->
                                        <!-- <div
                                            class="
                                                block
                                                px-4
                                                py-2
                                                text-xs text-gray-400
                                                dark:text-gray-200
                                            "
                                        >
                                            Manager
                                        </div>
                -->

                                        <jet-dropdown-link
                                            :href="route('view.ftso')"
                                        >
                                            Data Providers
                                        </jet-dropdown-link>
                                        <jet-dropdown-link
                                            :href="
                                                route('view.check-ftso-reward')
                                            "
                                        >
                                            Check Rewards
                                        </jet-dropdown-link>
                                    </template>
                                </jet-dropdown>

                                <a
                                    href="https://docs.flaremetrics.io/"
                                    target="_blank"
                                    class="
                                        flex
                                        items-center
                                        cursor-pointer
                                        relative
                                        select-none
                                    "
                                    :class="classes"
                                >
                                    Help</a
                                >
                                <div
                                    class="
                                        flex
                                        items-center
                                        cursor-pointer
                                        relative
                                        select-none
                                    "
                                    :class="classes"
                                >
                                    <div
                                        class="
                                            rounded-full
                                            h-2
                                            w-2
                                            bg-green-600 bg-opacity-50
                                        "
                                    ></div>
                                    <select
                                        id="network-selector"
                                        class="
                                            bg-none
                                            border-none
                                            bg-transparent
                                            rounded
                                            w-28
                                            focus:ring-0
                                            text-sm
                                            py-1
                                        "
                                    >
                                        <option value="Songbird">
                                            Songbird
                                        </option>
                                        <option disabled value="Flare">
                                            Flare
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="flex">
                            <!-- Login -->
                            <div
                                v-if="!$page.props.user"
                                class="
                                    hidden
                                    md:flex
                                    flex-wrap
                                    content-center
                                    mr-6
                                "
                            >
                                <div
                                    @click="login()"
                                    class="
                                        flex
                                        text-sm text-indigo-700
                                        dark:text-white
                                        cursor-pointer
                                        hover:text-indigo-600
                                    "
                                >
                                    Login
                                </div>
                            </div>
                            <div
                                class="
                                    cursor-pointer
                                    flex-shrink-0 flex
                                    items-center
                                "
                                @click="toggleDarkMode()"
                            >
                                <div
                                    class="
                                        h-6
                                        w-12
                                        flex
                                        relative
                                        rounded-xl
                                        border border-gray-400
                                    "
                                >
                                    <div
                                        class="
                                            absolute
                                            bg-white
                                            dark:bg-ff-dark
                                            border
                                            dark:border-gray-100
                                            border-ff-dark
                                            h-6
                                            w-6
                                            rounded-xl
                                        "
                                        :class="isDark ? '' : 'right-0'"
                                    ></div>

                                    <img
                                        class="left-0 h-6 w-6 p-1"
                                        src="/images/light-icon.svg"
                                        alt=""
                                    />
                                    <img
                                        class="right-0 h-6 w-6 p-1"
                                        src="/images/dark-icon.svg"
                                        alt=""
                                    />
                                </div>
                            </div>
                            <div
                                v-if="!$page.props.user"
                                class="
                                    hidden
                                    sm:flex sm:items-center sm:ml-6
                                    text-gray-600 text-sm
                                "
                            >
                                <!-- Login -->
                            </div>
                            <div
                                v-if="$page.props.user"
                                class="hidden sm:flex sm:items-center sm:ml-6"
                            >
                                <!-- Settings Dropdown -->
                                <div class="ml-3 relative">
                                    <jet-dropdown align="right" width="48">
                                        <template #trigger>
                                            <button
                                                v-if="
                                                    $page.props.jetstream
                                                        .managesProfilePhotos
                                                "
                                                class="
                                                    flex
                                                    text-sm
                                                    border-2 border-transparent
                                                    rounded-full
                                                    focus:outline-none
                                                    focus:border-gray-300
                                                    transition
                                                    duration-150
                                                    ease-in-out
                                                "
                                            >
                                                <img
                                                    class="
                                                        h-8
                                                        w-8
                                                        rounded-full
                                                        object-cover
                                                    "
                                                    :src="
                                                        $page.props.user
                                                            .profile_photo_url
                                                    "
                                                    :alt="$page.props.user.name"
                                                />
                                            </button>

                                            <span
                                                v-else
                                                class="inline-flex rounded-md"
                                            >
                                                <button
                                                    type="button"
                                                    class="
                                                        inline-flex
                                                        items-center
                                                        px-3
                                                        py-2
                                                        border
                                                        border-transparent
                                                        text-sm
                                                        leading-4
                                                        font-medium
                                                        rounded-md
                                                        text-gray-500
                                                        dark:text-white
                                                        bg-white
                                                        dark:bg-gray-600
                                                        hover:text-gray-700
                                                        focus:outline-none
                                                        transition
                                                        ease-in-out
                                                        duration-150
                                                    "
                                                >
                                                    {{ $page.props.user.name }}

                                                    <svg
                                                        class="
                                                            ml-2
                                                            -mr-0.5
                                                            h-4
                                                            w-4
                                                        "
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                    >
                                                        <path
                                                            fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                            clip-rule="evenodd"
                                                        />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>

                                        <template #content>
                                            <!-- Account Management -->
                                            <div
                                                class="
                                                    block
                                                    px-4
                                                    py-2
                                                    text-xs text-gray-400
                                                    dark:text-gray-200
                                                "
                                            >
                                                Manage Account
                                            </div>

                                            <jet-dropdown-link
                                                :href="route('profile.show')"
                                            >
                                                Profile
                                            </jet-dropdown-link>

                                            <jet-dropdown-link
                                                :href="
                                                    route('api-tokens.index')
                                                "
                                                v-if="
                                                    $page.props.jetstream
                                                        .hasApiFeatures
                                                "
                                            >
                                                API Tokens
                                            </jet-dropdown-link>

                                            <div
                                                class="border-t border-gray-100"
                                            ></div>

                                            <!-- Authentication -->
                                            <form @submit.prevent="logout">
                                                <jet-dropdown-link as="button">
                                                    Log Out
                                                </jet-dropdown-link>
                                            </form>
                                        </template>
                                    </jet-dropdown>
                                </div>
                            </div>
                        </div>

                        <!-- MOBILE MENU -->
                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center md:hidden">
                            <button
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                class="
                                    inline-flex
                                    items-center
                                    justify-center
                                    p-2
                                    rounded-md
                                    text-gray-400
                                    hover:text-gray-500 hover:bg-gray-100
                                    focus:outline-none
                                    focus:bg-gray-100
                                    focus:text-gray-500
                                    transition
                                    duration-150
                                    ease-in-out
                                "
                            >
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="md:hidden"
                >
                    <div
                        class="
                            pt-3
                            ml-4
                            pb-3
                            space-y-1
                            list-none
                            dark:text-gray-300
                            text-gray-400
                        "
                    >
                        <!-- <div
                            @click="$inertia.get(route('view.home'))"
                            class="ml-1 pt-2 font-semibold"
                        >
                            Home
                        </div> -->
                        <!-- <ul>
                            <li>
                                <jet-nav-link
                                    v-if="$page.props.user"
                                    :href="route('dashboard')"
                                    :active="route().current('dashboard')"
                                >
                                    Dashboard
                                </jet-nav-link>
                            </li>
                        </ul> -->

                        <ul class="text-md pr-3 ml-2">
                            <li class="py-1 text-md">
                                <div
                                    @click="$inertia.get(route('view.home'))"
                                    class="
                                        w-full
                                        hover:bg-indigo-50
                                        font-semibold
                                    "
                                >
                                    Home
                                </div>
                            </li>
                            <!-- FTSO Dropdown -->
                            <li class="py-1" @click="dropdownHandler($event)">
                                <div
                                    id="mobile-dropdown-1"
                                    class="w-full flex items-center"
                                >
                                    <div class="font-semibold">FTSO</div>
                                    <svg
                                        class="
                                            ml-2
                                            h-3
                                            w-3
                                            fill-current
                                            text-gray-400
                                            transform
                                            transition-transform
                                            duration-300
                                            ease-in-out
                                        "
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        x="0px"
                                        y="0px"
                                        viewBox="0 0 451.847 451.847"
                                        style="
                                            enable-background: new 0 0 451.847
                                                451.847;
                                        "
                                        xml:space="preserve"
                                    >
                                        <g>
                                            <path
                                                d="M225.923,354.706c-8.098,0-16.195-3.092-22.369-9.263L9.27,151.157c-12.359-12.359-12.359-32.397,0-44.751
		c12.354-12.354,32.388-12.354,44.748,0l171.905,171.915l171.906-171.909c12.359-12.354,32.391-12.354,44.744,0
		c12.365,12.354,12.365,32.392,0,44.751L248.292,345.449C242.115,351.621,234.018,354.706,225.923,354.706z"
                                            />
                                        </g>
                                    </svg>
                                </div>
                                <ul
                                    id="mobile-dropdown-content-1"
                                    class="ml-2 mt-1 dark:text-gray-100"
                                >
                                    <li
                                        class="mt-2"
                                        @click="
                                            $inertia.get(route('view.ftso'))
                                        "
                                    >
                                        Data Providers
                                    </li>
                                    <li
                                        class="mt-2"
                                        @click="
                                            $inertia.get(
                                                route('view.check-ftso-reward')
                                            )
                                        "
                                    >
                                        Check Rewards
                                    </li>
                                </ul>
                            </li>

                            <li v-if="!$page.props.user" class="py-1 text-md">
                                <div
                                    @click="login()"
                                    class="
                                        w-full
                                        hover:bg-indigo-50
                                        font-semibold
                                    "
                                >
                                    Login
                                </div>
                            </li>
                            <li class="py-1 hover:bg-indigo-50 font-semibold">
                                <a
                                    class="w-full hover:bg-indigo-50"
                                    href="https://docs.flaremetrics.io/"
                                >
                                    Help
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div
                        v-if="$page.props.user"
                        class="pt-4 pb-1 border-t border-gray-200"
                    >
                        <div class="flex items-center px-4">
                            <div
                                v-if="
                                    $page.props.jetstream.managesProfilePhotos
                                "
                                class="flex-shrink-0 mr-3"
                            >
                                <img
                                    class="h-10 w-10 rounded-full object-cover"
                                    :src="$page.props.user.profile_photo_url"
                                    :alt="$page.props.user.name"
                                />
                            </div>

                            <div>
                                <div
                                    class="
                                        font-medium
                                        text-sm text-gray-800
                                        dark:text-white
                                    "
                                >
                                    {{ $page.props.user.name }}
                                </div>
                                <div
                                    class="
                                        font-medium
                                        text-sm text-gray-500
                                        dark:text-white
                                    "
                                >
                                    {{ $page.props.user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1 dark:text-white">
                            <jet-responsive-nav-link
                                :href="route('profile.show')"
                                :active="route().current('profile.show')"
                            >
                                Profile
                            </jet-responsive-nav-link>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <jet-responsive-nav-link as="button">
                                    Log Out
                                </jet-responsive-nav-link>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <!-- <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header"></slot>
                </div>
            </header> -->

            <div
                class="
                    hidden
                    pt-4
                    pb-1
                    border-t border-gray-200w-full
                    flex
                    justify-center
                    py-2
                    text-sm text-center
                    bg-gray-50
                    dark:bg-gray-600 dark:text-white
                "
            >
                <img
                    class="h-4 w-4 mr-2 opacity-50"
                    src="/images/bell.svg"
                    alt="Alert"
                />
                <p class="">
                    <b>FF Competition Postponed</b> | Follow me on Twitter for
                    updates
                </p>
                <a href="https://twitter.com/flaremetrics" target="_blank">
                    <img
                        class="h-4 w-4 ml-2 hover:opacity-75"
                        src="/images/twitter-icon.svg"
                        alt="Twitter"
                    />
                </a>
            </div>

            <div
                v-if="!hide_bg"
                class="w-full block absolute z-0"
                id="bg"
            ></div>

            <!-- Page Content -->
            <div class="relative mt-3">
                <main>
                    <slot></slot>
                </main>
            </div>

            <!-- Footer -->
            <div class="inline-block h-6"></div>
            <div
                class="
                    mt-2
                    w-full
                    absolute
                    bottom-0
                    flex
                    bg-gray-50
                    text-gray-700
                    dark:bg-gray-800 dark:text-white
                "
            >
                <div class="mx-auto md:flex text-sm py-2">
                    <div class="mx-auto md:pr-4">FlareMetrics.io © 2021</div>
                    <span class="hidden md:block">|</span>
                    <div class="flex justify-center mt-2 md:mt-0 md:pl-4 flex">
                        <a
                            href="https://twitter.com/timrowley_au"
                            target="_blank"
                            class="mr-2"
                        >
                            <img
                                class="h-5 w-5 hover:opacity-75"
                                src="/images/twitter-icon.svg"
                                alt=""
                            />
                        </a>
                        <a
                            href="https://www.youtube.com/channel/UCeF146a-oUHELpzuFvGSyYQ"
                            target="_blank"
                            class="mx-2 hover:opacity-75"
                        >
                            <img
                                class="h-5 w-5"
                                src="/images/youtube-icon.svg"
                                alt=""
                            />
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <teleport to="body">
            <login-modal ref="login_modal" />
        </teleport>
    </div>
</template>

<script>
import JetApplicationMark from "@/Jetstream/ApplicationMark";
import JetBanner from "@/Jetstream/Banner";
import JetDropdown from "@/Jetstream/Dropdown";
import JetDropdownLink from "@/Jetstream/DropdownLink";
import JetNavLink from "@/Jetstream/NavLink";
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink";
import { Link } from "@inertiajs/inertia-vue3";
import LoginModal from "../Pages/Auth/LoginModal.vue";

export default {
    components: {
        JetApplicationMark,
        JetBanner,
        JetDropdown,
        JetDropdownLink,
        JetNavLink,
        JetResponsiveNavLink,
        Link,
        LoginModal,
    },

    props: {
        hide_bg: {
            required: false,
        },
        ff_bg: {
            required: false,
        },
    },
    data() {
        return {
            showingNavigationDropdown: false,
            isDark: false,
            countdown: "0d 0h 0m 0s",
        };
    },
    watch: {
        "$page.props.title"(newTitle) {
            this.setPageData();
        },
        "$page.props.description"(newDescription) {
            this.setPageData();
        },
    },

    mounted: function () {
        this.setPageData();
        if (localStorage.countdown) {
            this.countdown = localStorage.countdown;
        }
        if (localStorage.theme == "dark") {
            document.querySelector("html").classList.add("dark");
            this.isDark = true;
            this.$store.commit("setTheme", "dark");
        } else {
            document.querySelector("html").classList.add("light");
            this.$store.commit("setTheme", "light");

            this.isDark = false;
        }
        this.countdownTimer();
        // Whenever the user explicitly chooses to respect the OS preference
        // localStorage.removeItem("theme");
    },
    methods: {
        dropdownHandler(event) {
            let single = event.currentTarget.getElementsByTagName("ul")[0];
            let svg = event.currentTarget.getElementsByTagName("svg")[0];
            svg.classList.toggle("-rotate-90");
            single.classList.toggle("hidden");
        },
        login() {
            return this.$refs.login_modal.modalHandler(true);
        },
        isAdmin() {
            if (this.$page.props.user) {
                return this.$page.props.user.is_admin;
            }
            return false;
        },
        setPageData() {
            document.getElementById("layout-body").title = "";
            document.title = this.$page.props.title ?? "Flare Metrics"; //Page Title
            document
                .querySelector('meta[name="description"]')
                .setAttribute("content", this.$page.props.description); //Page Description
        },
        countdownTimer() {
            const { DateTime } = require("luxon");

            var countDownDate = DateTime.fromISO("2021-03-10T12:00:00", {
                zone: "America/Los_Angeles",
            }).toMillis();

            // Update the count down every 1 second
            var x = setInterval(() => {
                // Get today's date and time
                var now = new Date().getTime();

                // Find the distance between now and the count down date
                var distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor(
                    (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
                );
                var minutes = Math.floor(
                    (distance % (1000 * 60 * 60)) / (1000 * 60)
                );
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Display the result in the element with id="demo"
                this.countdown =
                    days +
                    "d " +
                    hours +
                    "h " +
                    minutes +
                    "m " +
                    seconds +
                    "s ";

                // If the count down is finished, write some text
                if (distance < 0) {
                    clearInterval(x);
                    this.countdown = "LIVE";
                }
                localStorage.countdown = this.countdown;
            }, 1000);
        },
        toggleMenu(id) {
            const el = document.getElementById(id);
            el.classList.toggle("hidden");
        },
        toggleDarkMode() {
            var element = document.querySelector("html");
            if (element.classList.contains("dark")) {
                element.classList.remove("dark");
                element.classList.add("light");
                localStorage.theme = "light";
                this.$store.commit("setTheme", "light");
                this.isDark = false;
            } else {
                element.classList.remove("light");
                element.classList.add("dark");
                localStorage.theme = "dark";
                this.$store.commit("setTheme", "dark");
                this.isDark = true;
            }
        },
        switchToTeam(team) {
            this.$inertia.put(
                route("current-team.update"),
                {
                    team_id: team.id,
                },
                {
                    preserveState: false,
                }
            );
        },

        logout() {
            this.$inertia.post(route("logout"));
        },
    },
    computed: {
        classes() {
            return this.active
                ? "inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium leading-5 dark:text-white text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out"
                : "inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 dark:text-white text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out";
        },
    },
};
</script>
<style scoped>
.hide-select {
    appearance: none; /* Hide dropdown in Firefox */
    -moz-appearance: none; /* Hide dropdown in Firefox */
    -webkit-appearance: none; /* Hide dropdown in Chrome */
}
</style>
