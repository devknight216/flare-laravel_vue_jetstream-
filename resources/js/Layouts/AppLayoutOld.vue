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

                                <jet-nav-link
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
                                </jet-nav-link>

                                <!-- <jet-dropdown align="left" width="46">
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
                                        <jet-dropdown-link
                                            :href="route('view.ftso')"
                                        >
                                            <div class="flex">
                                                <svg
                                                    class="
                                                        fill-current
                                                        text-indigo-700
                                                        w-4
                                                        h-5
                                                    "
                                                    version="1.1"
                                                    id="Capa_1"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                    viewBox="0 0 512 512"
                                                    xml:space="preserve"
                                                >
                                                    <g>
                                                        <g>
                                                            <path
                                                                d="M448,0H64C28.715,0,0,28.715,0,64v384c0,35.285,28.715,64,64,64h384c35.285,0,64-28.715,64-64V64
			C512,28.715,483.285,0,448,0z M469.333,448c0,11.776-9.579,21.333-21.333,21.333H64c-11.755,0-21.333-9.557-21.333-21.333V64
			c0-11.755,9.579-21.333,21.333-21.333h384c11.755,0,21.333,9.579,21.333,21.333V448z"
                                                            />
                                                        </g>
                                                    </g>
                                                    <g>
                                                        <g>
                                                            <path
                                                                d="M147.627,119.893c-1.067-2.773-2.56-4.907-4.48-7.04c-1.067-0.853-2.133-1.707-3.2-2.56c-1.28-0.853-2.56-1.493-3.84-1.92
			c-1.28-0.64-2.56-1.067-3.84-1.28c-4.267-0.853-8.533-0.427-12.373,1.28c-2.56,1.067-4.907,2.56-7.04,4.48
			c-1.92,2.133-3.413,4.267-4.48,7.04c-1.067,2.56-1.707,5.333-1.707,8.107s0.64,5.547,1.707,8.107
			c1.067,2.773,2.56,4.907,4.48,7.04c4.053,3.84,9.6,6.187,15.147,6.187c1.28,0,2.773-0.213,4.267-0.427
			c1.28-0.213,2.56-0.64,3.84-1.28c1.28-0.427,2.56-1.067,3.84-1.92c1.067-0.853,2.133-1.707,3.2-2.56
			c3.84-4.053,6.187-9.6,6.187-15.147C149.333,125.227,148.693,122.453,147.627,119.893z"
                                                            />
                                                        </g>
                                                    </g>
                                                    <g>
                                                        <g>
                                                            <path
                                                                d="M384,106.667H213.333C201.557,106.667,192,116.224,192,128s9.557,21.333,21.333,21.333H384
			c11.776,0,21.333-9.557,21.333-21.333S395.776,106.667,384,106.667z"
                                                            />
                                                        </g>
                                                    </g>
                                                    <g>
                                                        <g>
                                                            <path
                                                                d="M148.907,251.733c-0.213-1.28-0.64-2.56-1.28-3.84c-0.427-1.28-1.067-2.56-1.92-3.84c-0.853-1.067-1.707-2.133-2.56-3.2
			c-2.133-1.92-4.48-3.413-7.04-4.48c-5.12-2.133-11.093-2.133-16.213,0c-2.56,1.067-4.907,2.56-7.04,4.48
			c-0.853,1.067-1.707,2.133-2.56,3.2c-0.853,1.28-1.493,2.56-1.92,3.84c-0.64,1.28-1.067,2.56-1.28,3.84
			c-0.213,1.493-0.427,2.987-0.427,4.267c0,5.547,2.347,11.093,6.187,15.147c4.053,3.84,9.6,6.187,15.147,6.187
			s11.093-2.347,15.147-6.187c3.84-4.053,6.187-9.6,6.187-15.147C149.333,254.72,149.12,253.227,148.907,251.733z"
                                                            />
                                                        </g>
                                                    </g>
                                                    <g>
                                                        <g>
                                                            <path
                                                                d="M384,234.667H213.333C201.557,234.667,192,244.224,192,256s9.557,21.333,21.333,21.333H384
			c11.776,0,21.333-9.557,21.333-21.333S395.776,234.667,384,234.667z"
                                                            />
                                                        </g>
                                                    </g>
                                                    <g>
                                                        <g>
                                                            <path
                                                                d="M147.627,375.893c-1.067-2.773-2.56-4.907-4.48-7.04c-5.973-5.781-15.36-7.68-23.253-4.48
			c-2.56,1.067-4.907,2.56-7.04,4.48c-1.92,2.133-3.413,4.48-4.48,7.04s-1.707,5.333-1.707,8.107c0,5.76,2.133,11.093,6.187,15.147
			c4.053,4.032,9.387,6.187,15.147,6.187s11.093-2.155,15.147-6.187c4.053-4.053,6.187-9.387,6.187-15.147
			C149.333,381.227,148.907,378.453,147.627,375.893z"
                                                            />
                                                        </g>
                                                    </g>
                                                    <g>
                                                        <g>
                                                            <path
                                                                d="M384,362.667H213.333C201.557,362.667,192,372.203,192,384c0,11.797,9.557,21.333,21.333,21.333H384
			c11.776,0,21.333-9.536,21.333-21.333C405.333,372.203,395.776,362.667,384,362.667z"
                                                            />
                                                        </g>
                                                    </g>
                                                </svg>
                                                <div class="ml-2">List</div>
                                            </div>
                                        </jet-dropdown-link>

                                        <jet-dropdown-link
                                            :href="route('admin.ftso-manager')"
                                        >
                                            <div class="flex">
                                                <svg
                                                    class="
                                                        fill-current
                                                        text-indigo-700
                                                        -ml-1
                                                        w-5
                                                        h-5
                                                    "
                                                    viewBox="-91 0 512 512.00103"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                >
                                                    <path
                                                        d="m221.867188 192.953125v-41.152344h15.886718c13.664063 0 25.648438-7.734375 31.28125-20.183593 5.628906-12.449219 3.523438-26.554688-5.5-36.816407l-73.097656-83.140625c-6.519531-7.410156-15.914062-11.660156-25.785156-11.660156-9.867188 0-19.265625 4.25-25.78125 11.660156l-73.105469 83.140625c-9.019531 10.261719-11.128906 24.367188-5.496094 36.816407 5.628907 12.449218 17.613281 20.183593 31.277344 20.183593h15.886719v41.15625c-62.664063 23.296875-107.433594 83.710938-107.433594 154.390625 0 90.789063 73.863281 164.652344 164.652344 164.652344 90.789062 0 164.652344-73.863281 164.652344-164.652344 0-70.683594-44.769532-131.097656-107.4375-154.394531zm-191.042969 154.394531c0-73.792968 60.035156-133.828125 133.828125-133.828125 73.792968 0 133.832031 60.035157 133.832031 133.828125 0 73.792969-60.035156 133.828125-133.832031 133.828125-73.792969 0-133.828125-60.035156-133.828125-133.828125zm92.023437-226.371094h-31.300781c-1.5 0-2.574219-.695312-3.191406-2.0625-.621094-1.367187-.429688-2.632812.558593-3.757812l73.109376-83.140625c.863281-.984375 1.90625-1.191406 2.632812-1.191406.722656 0 1.765625.207031 2.632812 1.191406l73.101563 83.140625c.992187 1.125 1.179687 2.390625.558594 3.757812-.617188 1.367188-1.691407 2.0625-3.191407 2.0625h-31.300781c-8.511719 0-15.414062 6.898438-15.414062 15.410157v48.429687c-8.59375-1.390625-17.40625-2.121094-26.386719-2.121094-8.984375 0-17.796875.734376-26.394531 2.125v-48.433593c0-8.511719-6.902344-15.410157-15.414063-15.410157zm0 0"
                                                    />
                                                    <path
                                                        d="m164.652344 324.566406c-6.148438 0-11.15625-6.125-11.15625-13.652344 0-7.527343 5.007812-13.652343 11.15625-13.652343h26.570312c8.511719 0 15.414063-6.902344 15.414063-15.414063 0-8.511718-6.902344-15.410156-15.414063-15.410156h-11.15625v-9.597656c0-8.511719-6.902344-15.414063-15.414062-15.414063-8.511719 0-15.410156 6.902344-15.410156 15.414063v12.714844c-15.542969 6.527343-26.570313 22.597656-26.570313 41.359374 0 24.523438 18.832031 44.476563 41.980469 44.476563 6.152344 0 11.15625 6.125 11.15625 13.65625 0 7.527344-5.003906 13.652344-11.15625 13.652344h-26.566406c-8.511719 0-15.414063 6.898437-15.414063 15.410156s6.902344 15.414063 15.414063 15.414063h11.15625v9.597656c0 8.511718 6.898437 15.410156 15.410156 15.410156 8.511718 0 15.414062-6.898438 15.414062-15.410156v-12.71875c15.542969-6.523438 26.570313-22.597656 26.570313-41.355469 0-24.527344-18.835938-44.480469-41.984375-44.480469zm0 0"
                                                    />
                                                </svg>

                                                <div class="ml-2">Delegate</div>
                                            </div>
                                        </jet-dropdown-link>

                                        <div
                                            class="border-t border-gray-100"
                                        ></div>
                                    </template>
                                </jet-dropdown> -->

                                <jet-dropdown
                                    v-if="isAdmin()"
                                    align="right"
                                    width="48"
                                >
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
                                            "
                                        >
                                            Manage
                                        </div></template
                                    >

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
                                            Manager
                                        </div>
                                        <!-- 
                                        <jet-dropdown-link
                                            :href="
                                                route(
                                                    'view.provider.manage',
                                                    'FTSOAU'
                                                )
                                            "
                                        >
                                            Manage Provider
                                        </jet-dropdown-link> -->

                                        <jet-dropdown-link
                                            :href="route('admin.ftso-manager')"
                                        >
                                            Manage Providers
                                        </jet-dropdown-link>

                                        <div
                                            class="border-t border-gray-100"
                                        ></div>
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
                                v-else
                                class="hidden sm:flex sm:items-center sm:ml-6"
                            >
                                <div class="ml-3 relative">
                                    <!-- Teams Dropdown -->
                                    <jet-dropdown
                                        align="right"
                                        width="60"
                                        v-if="
                                            $page.props.jetstream
                                                .hasTeamFeatures
                                        "
                                    >
                                        <template #trigger>
                                            <span
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
                                                        bg-white
                                                        hover:bg-gray-50
                                                        hover:text-gray-700
                                                        focus:outline-none
                                                        focus:bg-gray-50
                                                        active:bg-gray-50
                                                        transition
                                                        ease-in-out
                                                        duration-150
                                                    "
                                                >
                                                    {{
                                                        $page.props.user
                                                            .current_team.name
                                                    }}

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
                                                            d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                            clip-rule="evenodd"
                                                        />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>

                                        <template #content>
                                            <div class="w-60">
                                                <!-- Team Management -->
                                                <template
                                                    v-if="
                                                        $page.props.jetstream
                                                            .hasTeamFeatures
                                                    "
                                                >
                                                    <div
                                                        class="
                                                            block
                                                            px-4
                                                            py-2
                                                            text-xs
                                                            text-gray-400
                                                        "
                                                    >
                                                        Manage Team
                                                    </div>

                                                    <!-- Team Settings -->
                                                    <jet-dropdown-link
                                                        :href="
                                                            route(
                                                                'teams.show',
                                                                $page.props.user
                                                                    .current_team
                                                            )
                                                        "
                                                    >
                                                        Team Settings
                                                    </jet-dropdown-link>

                                                    <jet-dropdown-link
                                                        :href="
                                                            route(
                                                                'teams.create'
                                                            )
                                                        "
                                                        v-if="
                                                            $page.props
                                                                .jetstream
                                                                .canCreateTeams
                                                        "
                                                    >
                                                        Create New Team
                                                    </jet-dropdown-link>

                                                    <div
                                                        class="
                                                            border-t
                                                            border-gray-100
                                                        "
                                                    ></div>

                                                    <!-- Team Switcher -->
                                                    <div
                                                        class="
                                                            block
                                                            px-4
                                                            py-2
                                                            text-xs
                                                            text-gray-400
                                                        "
                                                    >
                                                        Switch Teams
                                                    </div>

                                                    <template
                                                        v-for="team in $page
                                                            .props.user
                                                            .all_teams"
                                                        :key="team.id"
                                                    >
                                                        <form
                                                            @submit.prevent="
                                                                switchToTeam(
                                                                    team
                                                                )
                                                            "
                                                        >
                                                            <jet-dropdown-link
                                                                as="button"
                                                            >
                                                                <div
                                                                    class="
                                                                        flex
                                                                        items-center
                                                                    "
                                                                >
                                                                    <svg
                                                                        v-if="
                                                                            team.id ==
                                                                            $page
                                                                                .props
                                                                                .user
                                                                                .current_team_id
                                                                        "
                                                                        class="
                                                                            mr-2
                                                                            h-5
                                                                            w-5
                                                                            text-green-400
                                                                        "
                                                                        fill="none"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        stroke="currentColor"
                                                                        viewBox="0 0 24 24"
                                                                    >
                                                                        <path
                                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                                                        ></path>
                                                                    </svg>
                                                                    <div>
                                                                        {{
                                                                            team.name
                                                                        }}
                                                                    </div>
                                                                </div>
                                                            </jet-dropdown-link>
                                                        </form>
                                                    </template>
                                                </template>
                                            </div>
                                        </template>
                                    </jet-dropdown>
                                </div>

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
                                                    route(
                                                        'view.provider.register'
                                                    )
                                                "
                                            >
                                                Register Provider
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
                    <div class="pt-3 ml-4 pb-3 space-y-1 list-none">
                        <div
                            class="
                                ml-1
                                pt-2
                                text-sm
                                font-semibold
                                dark:text-gray-300
                            "
                        >
                            Home
                        </div>
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

                        <ul>
                            <li>
                                <jet-nav-link
                                    :href="route('view.ftso')"
                                    :active="route().current('view.ftso')"
                                >
                                    FTSO List
                                </jet-nav-link>
                            </li>
                            <li>
                                <jet-nav-link
                                    :href="route('view.check-ftso-reward')"
                                    :active="
                                        route().current(
                                            'view.check-ftso-reward'
                                        )
                                    "
                                >
                                    Check Rewards
                                </jet-nav-link>
                            </li>
                        </ul>

                        <ul>
                            <li>
                                <a
                                    href="https://docs.flaremetrics.io/"
                                    :class="classes"
                                >
                                    Help
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Login -->

                    <div
                        v-if="!$page.props.user"
                        class="
                            hidden
                            md:flex
                            sm:items-center sm:ml-6
                            text-gray-600 text-sm
                        "
                    >
                        <!-- Login Button -->
                    </div>
                    <!-- Responsive Settings Options -->
                    <div v-else class="pt-4 pb-1 border-t border-gray-200">
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

                            <jet-responsive-nav-link
                                :href="route('api-tokens.index')"
                                :active="route().current('api-tokens.index')"
                                v-if="$page.props.jetstream.hasApiFeatures"
                            >
                                API Tokens
                            </jet-responsive-nav-link>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <jet-responsive-nav-link as="button">
                                    Log Out
                                </jet-responsive-nav-link>
                            </form>

                            <!-- Team Management -->
                            <template
                                v-if="$page.props.jetstream.hasTeamFeatures"
                            >
                                <div class="border-t border-gray-200"></div>

                                <div
                                    class="
                                        block
                                        px-4
                                        py-2
                                        text-xs text-gray-400
                                    "
                                >
                                    Manage Team
                                </div>

                                <!-- Team Settings -->
                                <jet-responsive-nav-link
                                    :href="
                                        route(
                                            'teams.show',
                                            $page.props.user.current_team
                                        )
                                    "
                                    :active="route().current('teams.show')"
                                >
                                    Team Settings
                                </jet-responsive-nav-link>

                                <jet-responsive-nav-link
                                    :href="route('teams.create')"
                                    :active="route().current('teams.create')"
                                >
                                    Create New Team
                                </jet-responsive-nav-link>

                                <div class="border-t border-gray-200"></div>

                                <!-- Team Switcher -->
                                <div
                                    class="
                                        block
                                        px-4
                                        py-2
                                        text-xs text-gray-400
                                    "
                                >
                                    Switch Teams
                                </div>

                                <template
                                    v-for="team in $page.props.user.all_teams"
                                    :key="team.id"
                                >
                                    <form @submit.prevent="switchToTeam(team)">
                                        <jet-responsive-nav-link as="button">
                                            <div class="flex items-center">
                                                <svg
                                                    v-if="
                                                        team.id ==
                                                        $page.props.user
                                                            .current_team_id
                                                    "
                                                    class="
                                                        mr-2
                                                        h-5
                                                        w-5
                                                        text-green-400
                                                    "
                                                    fill="none"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                                    ></path>
                                                </svg>
                                                <div>{{ team.name }}</div>
                                            </div>
                                        </jet-responsive-nav-link>
                                    </form>
                                </template>
                            </template>
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
            <login-modal ref="login-modal" />
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
        login() {
            return this.$inertia.get(route("login"));
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
