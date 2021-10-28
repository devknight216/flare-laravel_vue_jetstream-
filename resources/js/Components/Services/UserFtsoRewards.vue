<template>
    <div class="w-full relative">
        <div id="header" class="mb-3 md:flex justify-between items-center">
            <div>
                <h1
                    class="
                        font-lato font-bold
                        text-gray-800
                        dark:text-gray-200
                        text-xl
                    "
                >
                    Rewards <span class="text-gray-400 font-bold">BETA</span>
                </h1>
                <p class="text-gray-600 text-sm dark:text-white">
                    Track the performance of your delegations.
                </p>
            </div>
            <div
                v-if="data.invite"
                class="rounded-md border border-indigo-300 px-3 py-2 text-sm"
            >
                <div>
                    <span class="text-indigo-600 dark:text-indigo-400 font-bold"
                        >Invite Code:
                    </span>
                    <span
                        v-if="inviteHidden"
                        class="text-indigo-600 dark:text-indigo-400"
                        >&lowast;&lowast;&lowast;&lowast;&lowast;&lowast;</span
                    >
                    <span v-else class="text-indigo-600 dark:text-indigo-400">{{
                        data.invite.code
                    }}</span>
                </div>
                <div
                    class="
                        text-xs text-gray-600
                        dark:text-gray-100
                        flex
                        justify-between
                    "
                >
                    <div>
                        Uses: {{ data.invite.redemptions }}/{{
                            data.invite.max_redemptions
                        }}
                    </div>
                    <div
                        @click="inviteHidden = !inviteHidden"
                        class="cursor-pointer select-none"
                    >
                        {{ inviteHidden ? "Show" : "Hide" }}
                    </div>
                </div>
            </div>
        </div>
        <div
            class="
                w-full
                rounded-md
                bg-yellow-500
                text-white
                px-3
                py-1
                my-2
                text-sm
            "
        >
            This tool is currently in beta and may not be 100% accurate. Please
            <span
                class="underline cursor-pointer"
                @click="$inertia.post(route('logout'))"
                >log out</span
            >
            to access public rewards checker if experiencing issues.
        </div>
        <div v-if="addresses.length == 0">
            <div v-if="loadedRpc == false">
                <loading-spinner size="6" color="text-gray-200" />
            </div>
            <div
                class="dark:text-gray-100"
                v-else-if="$page.props.user.email_verified_at == null"
            >
                Please verify your email address to continue.
            </div>
            <button
                v-else
                @click="openModal()"
                class="
                    cursor-pointer
                    border border-indigo-700
                    text-indigo-700
                    dark:text-indigo-400 dark:border-indigo-400
                    px-3
                    py-2
                    rounded-md
                "
            >
                Link Address
            </button>
        </div>

        <div
            v-else
            class="
                mt-12
                w-full
                grid grid-cols-12
                gap-3
                text-gray-800
                dark:text-gray-300
                relative
            "
        >
            <!-- Latest Epoch -->

            <div
                v-if="data.latest_epoch == null"
                class="
                    absolute
                    w-full
                    h-full
                    bg-gray-50
                    dark:bg-gray-600
                    rounded-md
                    z-10
                    flex
                    justify-center
                    items-center
                "
            >
                <div class="text-center">
                    <svg
                        class="h-20 w-20 fill-current text-gray-400 mx-auto"
                        version="1.1"
                        xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                        x="0px"
                        y="0px"
                        viewBox="0 0 512 512"
                        style="enable-background: new 0 0 512 512"
                        xml:space="preserve"
                    >
                        <g>
                            <g>
                                <g>
                                    <path
                                        d="M458.406,380.681c-8.863-6.593-21.391-4.752-27.984,4.109c-3.626,4.874-7.506,9.655-11.533,14.21
				c-7.315,8.275-6.538,20.915,1.737,28.231c3.806,3.364,8.531,5.016,13.239,5.016c5.532,0,11.04-2.283,14.992-6.754
				c4.769-5.394,9.364-11.056,13.658-16.829C469.108,399.803,467.269,387.273,458.406,380.681z"
                                    />
                                    <path
                                        d="M491.854,286.886c-10.786-2.349-21.447,4.496-23.796,15.288c-1.293,5.937-2.855,11.885-4.646,17.681
				c-3.261,10.554,2.651,21.752,13.204,25.013c1.967,0.607,3.955,0.896,5.911,0.896c8.54,0,16.448-5.514,19.102-14.102
				c2.126-6.878,3.98-13.937,5.514-20.98C509.492,299.89,502.647,289.236,491.854,286.886z"
                                    />
                                    <path
                                        d="M362.139,444.734c-5.31,2.964-10.808,5.734-16.34,8.233c-10.067,4.546-14.542,16.392-9.996,26.459
				c3.34,7.396,10.619,11.773,18.239,11.773c2.752,0,5.549-0.571,8.22-1.777c6.563-2.964,13.081-6.249,19.377-9.764
				c9.645-5.384,13.098-17.568,7.712-27.212C383.968,442.803,371.784,439.35,362.139,444.734z"
                                    />
                                    <path
                                        d="M236,96v151.716l-73.339,73.338c-7.81,7.811-7.81,20.474,0,28.284c3.906,3.906,9.023,5.858,14.143,5.858
				c5.118,0,10.237-1.953,14.143-5.858l79.196-79.196c3.75-3.75,5.857-8.838,5.857-14.142V96c0-11.046-8.954-20-20-20
				C244.954,76,236,84.954,236,96z"
                                    />
                                    <path
                                        d="M492,43c-11.046,0-20,8.954-20,20v55.536C425.448,45.528,344.151,0,256,0C187.62,0,123.333,26.629,74.98,74.98
				C26.629,123.333,0,187.62,0,256s26.629,132.667,74.98,181.02C123.333,485.371,187.62,512,256,512c0.169,0,0.332-0.021,0.5-0.025
				c0.168,0.004,0.331,0.025,0.5,0.025c7.208,0,14.487-0.304,21.637-0.902c11.007-0.922,19.183-10.592,18.262-21.599
				c-0.923-11.007-10.58-19.187-21.6-18.261C269.255,471.743,263.099,472,257,472c-0.169,0-0.332,0.021-0.5,0.025
				c-0.168-0.004-0.331-0.025-0.5-0.025c-119.103,0-216-96.897-216-216S136.897,40,256,40c76.758,0,147.357,40.913,185.936,106
				h-54.993c-11.046,0-20,8.954-20,20s8.954,20,20,20H448c12.18,0,23.575-3.423,33.277-9.353c0.624-0.356,1.224-0.739,1.796-1.152
				C500.479,164.044,512,144.347,512,122V63C512,51.954,503.046,43,492,43z"
                                    />
                                </g>
                            </g>
                        </g>
                    </svg>
                    <div class="text-sm text-gray-500 dark:text-gray-100 mt-2">
                        Please check back in 5 minutes while we start tracking
                        your rewards.
                    </div>
                    <div
                        class="
                            mt-2
                            flex
                            text-xs text-gray-400
                            dark:text-gray-200
                        "
                    >
                        <loading-spinner
                            size="4"
                            color="text-gray-400 dark:text-gray-100 mr-2"
                        />
                        <span class=""
                            >Gathering data for
                            {{ this.addresses[0].address }}...</span
                        >
                    </div>
                    <div class="text-gray-400 mt-2 text-xs">
                        You may close this window at anytime.
                    </div>
                </div>
            </div>
            <div
                class="
                    relative
                    col-span-12
                    md:col-span-2
                    bg-indigo-100
                    dark:bg-gray-500
                    rounded-md
                    grid grid-cols-1
                    h-40
                    place-content-center
                "
            >
                <div
                    class="
                        absolute
                        p-2
                        font-bold
                        dark:text-indigo-200
                        text-indigo-400
                    "
                >
                    Songbird
                </div>
                <div class="pt-6">
                    <div
                        class="
                            fill-current
                            text-indigo-700
                            dark:text-gray-200
                            w-full
                            flex
                            justify-center
                        "
                    >
                        <svg
                            class="h-7 w-7"
                            viewBox="-117 0 512 512.00107"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="m199.027344 211.726562v-53.578124h16.554687c14.234375 0 26.722657-8.054688 32.589844-21.027344 5.863281-12.96875 3.671875-27.664063-5.730469-38.355469l-76.15625-86.617187c-6.789062-7.71875-16.578125-12.148438-26.859375-12.148438s-20.070312 4.429688-26.859375 12.148438l-76.164062 86.617187c-9.398438 10.6875-11.59375 25.386719-5.726563 38.355469 5.863281 12.972656 18.351563 21.027344 32.585938 21.027344h16.550781v53.578124c18.578125-6.90625 38.660156-10.6875 59.613281-10.6875 20.949219 0 41.027344 3.78125 59.601563 10.6875zm0 0"
                            />
                            <path
                                d="m278.847656 372.574219c0-76.875-62.542968-139.421875-139.421875-139.421875-76.878906 0-139.425781 62.546875-139.425781 139.421875 0 76.878906 62.546875 139.425781 139.425781 139.425781 76.878907 0 139.421875-62.546875 139.421875-139.425781zm-123.367187 65.695312v13.246094c0 8.867187-7.1875 16.058594-16.054688 16.058594-8.867187 0-16.058593-7.191407-16.058593-16.058594v-9.996094h-11.621094c-8.867188 0-16.058594-7.191406-16.058594-16.058593 0-8.867188 7.191406-16.054688 16.058594-16.054688h27.679687c6.410157 0 11.621094-6.382812 11.621094-14.226562s-5.210937-14.222657-11.621094-14.222657c-24.117187 0-43.738281-20.789062-43.738281-46.339843 0-19.542969 11.488281-36.289063 27.679688-43.085938v-13.246094c0-8.871094 7.191406-16.058594 16.058593-16.058594 8.867188 0 16.054688 7.1875 16.054688 16.058594v9.996094h11.625c8.867187 0 16.054687 7.1875 16.054687 16.058594 0 8.867187-7.1875 16.054687-16.054687 16.054687h-27.679688c-6.410156 0-11.625 6.382813-11.625 14.222657 0 7.84375 5.214844 14.226562 11.625 14.226562 24.117188 0 43.734375 20.785156 43.734375 46.335938 0 19.546874-11.484375 36.292968-27.679687 43.089843zm0 0"
                            />
                        </svg>
                    </div>
                    <div
                        class="
                            text-3xl
                            font-semibol
                            text-center
                            pt-2
                            flex
                            justify-center
                        "
                    >
                        <span v-if="data.latest_epoch">{{
                            parseBigNumber(data.total_earnings)
                        }}</span>
                        <div
                            v-else-if="loaded == false"
                            class="
                                w-16
                                h-8
                                my-1
                                rounded-md
                                bg-indigo-200
                                dark:bg-gray-300
                                animate-pulse
                            "
                        ></div>
                        <div class="opacity-20" v-else>N/A</div>
                    </div>

                    <div class="text-md w-full text-center">Total Earnings</div>
                </div>
            </div>
            <div
                class="
                    col-span-12
                    md:col-span-5
                    bg-indigo-100
                    dark:bg-gray-500
                    rounded-md
                    h-40
                "
            >
                <div
                    class="relative grid grid-cols-3 h-40 place-content-center"
                >
                    <div
                        class="
                            absolute
                            p-2
                            font-bold
                            dark:text-indigo-200
                            text-indigo-400
                        "
                    >
                        Current Epoch
                    </div>
                    <div id="current_epoch_earnings" class="pt-6">
                        <div
                            class="
                                fill-current
                                text-indigo-700
                                dark:text-gray-200
                                w-full
                                flex
                                justify-center
                            "
                        >
                            <svg
                                class="h-6 w-6"
                                viewBox="-74 1 511 511.99897"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="m182.015625 0c-100.089844 0-181.515625 81.429688-181.515625 181.515625 0 55.261719 28.789062 126.992187 85.570312 213.203125 41.621094 63.1875 82.589844 110.046875 84.3125 112.011719 2.9375 3.347656 7.179688 5.269531 11.632813 5.269531s8.695313-1.921875 11.632813-5.269531c1.722656-1.964844 42.695312-48.824219 84.3125-112.011719 56.78125-86.210938 85.570312-157.941406 85.570312-213.203125.003906-100.085937-81.425781-181.515625-181.515625-181.515625zm-.320313 180.570312c25.964844 0 47.082032 22.453126 47.082032 50.054688 0 21.832031-13.222656 40.433594-31.601563 47.257812v17.0625c0 8.546876-6.929687 15.476563-15.480469 15.476563-8.546874 0-15.476562-6.929687-15.476562-15.476563v-14.269531h-16.125c-8.546875 0-15.476562-6.933593-15.476562-15.480469 0-8.546874 6.929687-15.476562 15.476562-15.476562h31.601562c8.894532 0 16.125-8.566406 16.125-19.09375 0-10.53125-7.234374-19.097656-16.125-19.097656-25.957031 0-47.078124-22.453125-47.078124-50.050782 0-21.832031 13.222656-40.433593 31.601562-47.257812v-17.0625c0-8.546875 6.929688-15.476562 15.476562-15.476562 8.550782 0 15.480469 6.929687 15.480469 15.476562v14.269531h16.125c8.546875 0 15.476563 6.929688 15.476563 15.480469 0 8.546875-6.929688 15.476562-15.476563 15.476562h-31.605469c-8.890624 0-16.121093 8.566407-16.121093 19.09375 0 10.53125 7.230469 19.09375 16.121093 19.09375zm0 0"
                                />
                            </svg>
                        </div>
                        <div
                            class="
                                text-3xl
                                font-semibol
                                text-center
                                pt-2
                                flex
                                justify-center
                            "
                        >
                            <span v-if="data.latest_epoch">{{
                                parseBigNumber(data.latest_epoch.epoch_rewards)
                            }}</span>
                            <div
                                v-else-if="loaded == false"
                                class="
                                    w-16
                                    h-8
                                    my-1
                                    rounded-md
                                    bg-indigo-200
                                    dark:bg-gray-300
                                    animate-pulse
                                "
                            ></div>
                            <div class="opacity-20" v-else>N/A</div>
                        </div>

                        <div class="text-md w-full text-center">Earnings</div>
                    </div>
                    <div id="current_epoch_daily" class="pt-6">
                        <div
                            class="
                                fill-current
                                text-indigo-700
                                dark:text-gray-200
                                w-full
                                flex
                                justify-center
                            "
                        >
                            <svg
                                class="h-6 w-6"
                                viewBox="0 -106 512.00019 512"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="m497.328125 7.679688c-10.390625-7.945313-24.28125-9.871094-36.421875-5.089844l-122.480469 39.398437c-.402343.128907-.796875.273438-1.183593.4375-12.292969 5.109375-21 16.492188-22.722657 29.699219-1.71875 13.203125 3.785157 26.433594 14.363281 34.527344l9.601563 7.34375-34.421875 35.886718-98.4375-108.285156c-11.679688-13.792968-28.738281-21.476562-46.894531-21.054687-18.226563.433593-35.003907 9.011719-46.085938 23.601562l-100.503906 133.914063c-9.625 12.675781-13.738281 28.34375-11.582031 44.113281 2.160156 15.773437 10.328125 29.757813 23.007812 39.382813 10.75 8.167968 23.40625 12.109374 35.964844 12.109374 18.011719 0 35.824219-8.113281 47.53125-23.53125.027344-.03125.050781-.066406.078125-.101562l55.886719-74.902344 94.472656 103.71875c11.167969 13.183594 27.464844 20.855469 44.824219 21.0625h.640625c17.066406 0 33.320312-7.324218 44.625-20.101562l86.0625-93.007813 14.664062 11.21875c6.039063 4.617188 13.246094 7.261719 20.839844 7.640625 5.515625.28125 11.136719-.695312 16.242188-2.820312 12.292968-5.113282 21-16.492188 22.71875-29.699219.066406-.511719.105468-1.027344.121093-1.546875l3.554688-130.257812c1.371093-12.910157-4.117188-25.738282-14.464844-33.65625zm0 0"
                                />
                            </svg>
                        </div>
                        <div
                            class="
                                text-3xl
                                font-semibol
                                text-center
                                pt-2
                                flex
                                justify-center
                            "
                        >
                            <span v-if="data.latest_epoch">
                                {{
                                    parseBigNumber(
                                        data.latest_epoch.epoch_rewards /
                                            days_since_epoch_start
                                    )
                                }}
                            </span>
                            <div
                                v-else-if="loaded == false"
                                class="
                                    w-16
                                    h-8
                                    my-1
                                    rounded-md
                                    bg-indigo-200
                                    dark:bg-gray-300
                                    animate-pulse
                                "
                            ></div>
                            <div class="opacity-20" v-else>N/A</div>
                        </div>

                        <div class="text-md w-full text-center">Daily Avg.</div>
                    </div>
                    <div id="current_epoch_rate" class="pt-6">
                        <div
                            class="
                                fill-current
                                text-indigo-700
                                dark:text-gray-200
                                w-full
                                flex
                                justify-center
                            "
                        >
                            <svg
                                class="h-6 w-6"
                                viewBox="0 -106 512.00019 512"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="m497.328125 7.679688c-10.390625-7.945313-24.28125-9.871094-36.421875-5.089844l-122.480469 39.398437c-.402343.128907-.796875.273438-1.183593.4375-12.292969 5.109375-21 16.492188-22.722657 29.699219-1.71875 13.203125 3.785157 26.433594 14.363281 34.527344l9.601563 7.34375-34.421875 35.886718-98.4375-108.285156c-11.679688-13.792968-28.738281-21.476562-46.894531-21.054687-18.226563.433593-35.003907 9.011719-46.085938 23.601562l-100.503906 133.914063c-9.625 12.675781-13.738281 28.34375-11.582031 44.113281 2.160156 15.773437 10.328125 29.757813 23.007812 39.382813 10.75 8.167968 23.40625 12.109374 35.964844 12.109374 18.011719 0 35.824219-8.113281 47.53125-23.53125.027344-.03125.050781-.066406.078125-.101562l55.886719-74.902344 94.472656 103.71875c11.167969 13.183594 27.464844 20.855469 44.824219 21.0625h.640625c17.066406 0 33.320312-7.324218 44.625-20.101562l86.0625-93.007813 14.664062 11.21875c6.039063 4.617188 13.246094 7.261719 20.839844 7.640625 5.515625.28125 11.136719-.695312 16.242188-2.820312 12.292968-5.113282 21-16.492188 22.71875-29.699219.066406-.511719.105468-1.027344.121093-1.546875l3.554688-130.257812c1.371093-12.910157-4.117188-25.738282-14.464844-33.65625zm0 0"
                                />
                            </svg>
                        </div>
                        <div
                            class="
                                text-3xl
                                font-semibol
                                text-center
                                pt-2
                                flex
                                justify-center
                            "
                        >
                            <span v-if="data.latest_epoch">
                                {{ data.latest_epoch.rate_average.toFixed(3) }}
                            </span>
                            <div
                                v-else-if="loaded == false"
                                class="
                                    w-16
                                    h-8
                                    my-1
                                    rounded-md
                                    bg-indigo-200
                                    dark:bg-gray-300
                                    animate-pulse
                                "
                            ></div>
                            <div class="opacity-20" v-else>N/A</div>
                        </div>

                        <div class="text-md w-full text-center">Rate Avg.</div>
                    </div>
                </div>
            </div>

            <!-- Last Epoch -->
            <div
                class="
                    col-span-12
                    md:col-span-5
                    bg-indigo-100
                    dark:bg-gray-500
                    rounded-md
                    h-40
                "
            >
                <div
                    class="relative grid grid-cols-3 h-40 place-content-center"
                >
                    <div
                        class="
                            absolute
                            p-2
                            font-bold
                            dark:text-indigo-200
                            text-indigo-400
                        "
                    >
                        Last Epoch
                    </div>
                    <div id="current_epoch_earnings" class="pt-6">
                        <div
                            class="
                                fill-current
                                text-indigo-700
                                dark:text-gray-200
                                w-full
                                flex
                                justify-center
                            "
                        >
                            <svg
                                class="h-6 w-6"
                                viewBox="-74 1 511 511.99897"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="m182.015625 0c-100.089844 0-181.515625 81.429688-181.515625 181.515625 0 55.261719 28.789062 126.992187 85.570312 213.203125 41.621094 63.1875 82.589844 110.046875 84.3125 112.011719 2.9375 3.347656 7.179688 5.269531 11.632813 5.269531s8.695313-1.921875 11.632813-5.269531c1.722656-1.964844 42.695312-48.824219 84.3125-112.011719 56.78125-86.210938 85.570312-157.941406 85.570312-213.203125.003906-100.085937-81.425781-181.515625-181.515625-181.515625zm-.320313 180.570312c25.964844 0 47.082032 22.453126 47.082032 50.054688 0 21.832031-13.222656 40.433594-31.601563 47.257812v17.0625c0 8.546876-6.929687 15.476563-15.480469 15.476563-8.546874 0-15.476562-6.929687-15.476562-15.476563v-14.269531h-16.125c-8.546875 0-15.476562-6.933593-15.476562-15.480469 0-8.546874 6.929687-15.476562 15.476562-15.476562h31.601562c8.894532 0 16.125-8.566406 16.125-19.09375 0-10.53125-7.234374-19.097656-16.125-19.097656-25.957031 0-47.078124-22.453125-47.078124-50.050782 0-21.832031 13.222656-40.433593 31.601562-47.257812v-17.0625c0-8.546875 6.929688-15.476562 15.476562-15.476562 8.550782 0 15.480469 6.929687 15.480469 15.476562v14.269531h16.125c8.546875 0 15.476563 6.929688 15.476563 15.480469 0 8.546875-6.929688 15.476562-15.476563 15.476562h-31.605469c-8.890624 0-16.121093 8.566407-16.121093 19.09375 0 10.53125 7.230469 19.09375 16.121093 19.09375zm0 0"
                                />
                            </svg>
                        </div>
                        <div
                            class="
                                text-3xl
                                font-semibol
                                text-center
                                pt-2
                                flex
                                justify-center
                            "
                        >
                            <span v-if="data.previous_epoch !== null">{{
                                parseBigNumber(
                                    data.previous_epoch.epoch_rewards
                                )
                            }}</span>
                            <div
                                v-else-if="loaded == false"
                                class="
                                    w-16
                                    h-8
                                    my-1
                                    rounded-md
                                    bg-indigo-200
                                    dark:bg-gray-300
                                    animate-pulse
                                "
                            ></div>
                            <div class="opacity-20" v-else>N/A</div>
                        </div>

                        <div class="text-md w-full text-center">Earnings</div>
                    </div>
                    <div id="current_epoch_daily" class="pt-6">
                        <div
                            class="
                                fill-current
                                text-indigo-700
                                dark:text-gray-200
                                w-full
                                flex
                                justify-center
                            "
                        >
                            <svg
                                class="h-6 w-6"
                                viewBox="0 -106 512.00019 512"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="m497.328125 7.679688c-10.390625-7.945313-24.28125-9.871094-36.421875-5.089844l-122.480469 39.398437c-.402343.128907-.796875.273438-1.183593.4375-12.292969 5.109375-21 16.492188-22.722657 29.699219-1.71875 13.203125 3.785157 26.433594 14.363281 34.527344l9.601563 7.34375-34.421875 35.886718-98.4375-108.285156c-11.679688-13.792968-28.738281-21.476562-46.894531-21.054687-18.226563.433593-35.003907 9.011719-46.085938 23.601562l-100.503906 133.914063c-9.625 12.675781-13.738281 28.34375-11.582031 44.113281 2.160156 15.773437 10.328125 29.757813 23.007812 39.382813 10.75 8.167968 23.40625 12.109374 35.964844 12.109374 18.011719 0 35.824219-8.113281 47.53125-23.53125.027344-.03125.050781-.066406.078125-.101562l55.886719-74.902344 94.472656 103.71875c11.167969 13.183594 27.464844 20.855469 44.824219 21.0625h.640625c17.066406 0 33.320312-7.324218 44.625-20.101562l86.0625-93.007813 14.664062 11.21875c6.039063 4.617188 13.246094 7.261719 20.839844 7.640625 5.515625.28125 11.136719-.695312 16.242188-2.820312 12.292968-5.113282 21-16.492188 22.71875-29.699219.066406-.511719.105468-1.027344.121093-1.546875l3.554688-130.257812c1.371093-12.910157-4.117188-25.738282-14.464844-33.65625zm0 0"
                                />
                            </svg>
                        </div>
                        <div
                            class="
                                text-3xl
                                font-semibol
                                text-center
                                pt-2
                                flex
                                justify-center
                            "
                        >
                            <span v-if="data.previous_epoch !== null">{{
                                parseBigNumber(
                                    data.previous_epoch.epoch_rewards / 7
                                )
                            }}</span>
                            <div
                                v-else-if="loaded == false"
                                class="
                                    w-16
                                    h-8
                                    my-1
                                    rounded-md
                                    bg-indigo-200
                                    dark:bg-gray-300
                                    animate-pulse
                                "
                            ></div>
                            <div class="opacity-20" v-else>N/A</div>
                        </div>

                        <div class="text-md w-full text-center">Daily Avg.</div>
                    </div>
                    <div id="current_epoch_rate" class="pt-6">
                        <div
                            class="
                                fill-current
                                text-indigo-700
                                dark:text-gray-200
                                w-full
                                flex
                                justify-center
                            "
                        >
                            <svg
                                class="h-6 w-6"
                                viewBox="0 -106 512.00019 512"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="m497.328125 7.679688c-10.390625-7.945313-24.28125-9.871094-36.421875-5.089844l-122.480469 39.398437c-.402343.128907-.796875.273438-1.183593.4375-12.292969 5.109375-21 16.492188-22.722657 29.699219-1.71875 13.203125 3.785157 26.433594 14.363281 34.527344l9.601563 7.34375-34.421875 35.886718-98.4375-108.285156c-11.679688-13.792968-28.738281-21.476562-46.894531-21.054687-18.226563.433593-35.003907 9.011719-46.085938 23.601562l-100.503906 133.914063c-9.625 12.675781-13.738281 28.34375-11.582031 44.113281 2.160156 15.773437 10.328125 29.757813 23.007812 39.382813 10.75 8.167968 23.40625 12.109374 35.964844 12.109374 18.011719 0 35.824219-8.113281 47.53125-23.53125.027344-.03125.050781-.066406.078125-.101562l55.886719-74.902344 94.472656 103.71875c11.167969 13.183594 27.464844 20.855469 44.824219 21.0625h.640625c17.066406 0 33.320312-7.324218 44.625-20.101562l86.0625-93.007813 14.664062 11.21875c6.039063 4.617188 13.246094 7.261719 20.839844 7.640625 5.515625.28125 11.136719-.695312 16.242188-2.820312 12.292968-5.113282 21-16.492188 22.71875-29.699219.066406-.511719.105468-1.027344.121093-1.546875l3.554688-130.257812c1.371093-12.910157-4.117188-25.738282-14.464844-33.65625zm0 0"
                                />
                            </svg>
                        </div>
                        <div
                            class="
                                text-3xl
                                font-semibol
                                text-center
                                pt-2
                                flex
                                justify-center
                            "
                        >
                            <span v-if="data.previous_epoch !== null">
                                {{
                                    data.previous_epoch.rate_average.toFixed(3)
                                }}
                            </span>
                            <div
                                v-else-if="loaded == false"
                                class="
                                    w-16
                                    h-8
                                    my-1
                                    rounded-md
                                    bg-indigo-200
                                    dark:bg-gray-300
                                    animate-pulse
                                "
                            ></div>
                            <div class="opacity-20" v-else>N/A</div>
                        </div>

                        <div class="text-md w-full text-center">Rate Avg.</div>
                    </div>
                </div>
            </div>

            <div
                class="
                    col-span-12
                    md:col-span-6
                    bg-indigo-100
                    dark:bg-gray-500
                    rounded-md
                    h-52
                    w-full
                "
            >
                <template v-if="chart_data !== null">
                    <user-reward-state-graph :chart_data="chart_data" />
                </template>
            </div>
            <div
                class="
                    col-span-12
                    md:col-span-6
                    bg-indigo-100
                    dark:bg-gray-500
                    rounded-md
                    h-52
                "
            >
                <div class="p-2 font-bold dark:text-indigo-200 text-indigo-400">
                    Epoch Delegations
                </div>
                <div class="px-2 md:px-4">
                    <table class="text-left w-full">
                        <tr class="text-indigo-300">
                            <th>Name</th>
                            <th class="text-right">%</th>
                            <th class="text-right">Rate</th>
                            <th class="text-right">Earnings</th>
                        </tr>
                        <template v-if="data.latest_epoch">
                            <tr
                                v-for="(p, i) in data.latest_epoch
                                    .delegated_providers"
                                :key="i"
                            >
                                <td class="flex items-center">
                                    <div
                                        class="
                                            h-10
                                            w-10
                                            bg-gray-50
                                            border border-indigo-100
                                            rounded-md
                                            mr-2
                                            mb-1
                                        "
                                    >
                                        <img
                                            class="p-2"
                                            :src="p.emblem"
                                            alt=""
                                        />
                                    </div>
                                    <div class="w-24 md:w-36 truncate">
                                        {{ p.name }}
                                    </div>
                                </td>
                                <td class="text-right">
                                    {{
                                        data.latest_epoch[
                                            `provider_percentage_${i + 1}`
                                        ] / 100
                                    }}%
                                </td>
                                <td class="text-right">
                                    {{ getRewardRate(p) }}
                                </td>
                                <td class="text-right">
                                    <!-- {{ data.latest_epoch.epoch_rewards }}
                                    {{ p.delegated_percentage }}
                                    {{
                                        (
                                            (data.latest_epoch.epoch_rewards *
                                                getRewardRate(p)) /
                                            10
                                        ).toFixed(3)
                                    }} -->
                                    {{
                                        getWeightedEarnings(
                                            p,
                                            data.latest_epoch
                                        ).toFixed(3)
                                    }}
                                </td>
                            </tr>
                        </template>
                    </table>
                </div>
                <div
                    class="
                        border border-indigo-200
                        dark:border-gray-400
                        mx-4
                        my-2
                    "
                ></div>
                <div class="text-right mx-4 text-sm">
                    Votepower:
                    <span v-if="data.latest_epoch !== null">{{
                        data.latest_epoch.votepower
                    }}</span
                    ><span v-else>----</span>
                </div>
            </div>
        </div>
        <teleport to="body">
            <track-address-modal @added="init()" ref="track_address_modal" />
        </teleport>
    </div>
</template>
<script>
import { mapGetters } from "vuex";
import UserRewardStateGraph from "../FTSO/UserRewardStateGraph.vue";
import TrackAddressModal from "../Modals/TrackAddressModal.vue";
import LoadingSpinner from "../Ui/LoadingSpinner.vue";

export default {
    components: {
        UserRewardStateGraph,
        TrackAddressModal,
        LoadingSpinner,
    },

    data() {
        return {
            reward_epoch_id: null,
            data: {
                latest_epoch: null,
                previous_epoch: null,
            },
            chart_data: null,
            network_stats: {},
            days_since_epoch_start: 0,
            addresses: [],
            loaded: false,
            loadedRpc: false,
            inviteHidden: true,
        };
    },
    mounted: async function () {
        this.init();
    },
    computed: {
        ...mapGetters(["ftsoWhitelistedPriceProviders"]),
    },
    methods: {
        async init() {
            this.network_stats = await this.$store.dispatch(
                "requestNetworkStatistics"
            );
            if (this.$store.state.currentRewardEpoch == null) {
                this.reward_epoch_id = await this.$store.dispatch(
                    "requestCurrentRewardEpoch"
                );
            } else {
                this.reward_epoch_id = this.$store.state.currentRewardEpoch;
            }
            this.loadedRpc = true;

            await this.getTrackingAddresses();

            var secondsSinceEpochStart =
                Math.round(Date.now() / 1000) -
                parseInt(
                    this.network_stats.songbird_statistics
                        .latest_reward_epoch_start
                );
            this.days_since_epoch_start = Math.ceil(
                secondsSinceEpochStart / 60 / 60 / 24
            );
        },

        openModal() {
            this.$refs.track_address_modal.modalHandler(true);
        },
        async getTrackingAddresses() {
            return axios
                .get(route("user.ftso.tracking.addresses"))
                .then((resp) => {
                    this.addresses = resp.data;
                    if (resp.data.length == 0) {
                        this.openModal();
                        return;
                    }
                    this.getData(this.addresses[0].address);
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        async getData(address) {
            axios
                .get(route("user.ftso.tracking"), {
                    params: {
                        address: address,
                        current_epoch: parseInt(this.reward_epoch_id),
                    },
                })
                .then((resp) => {
                    this.data = resp.data;
                    this.chart_data = this.data.chart_data;
                    this.processData();
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        getWeightedEarnings(p, latest_epoch) {
            var rr = parseFloat(this.getRewardRate(p));
            var provider_percent = parseFloat(p.delegated_percentage);
            var votepower = parseFloat(latest_epoch.votepower);
            var earned = rr * (votepower * provider_percent);
            return earned / 100;
        },
        processData() {
            console.log(this.data.latest_epoch.delegated_providers);
            if (this.data.latest_epoch.delegated_providers.length > 1) {
                let sum = this.data.latest_epoch.delegated_providers.reduce(
                    (a, b) =>
                        parseFloat(this.getRewardRate(a)) +
                        parseFloat(this.getRewardRate(b))
                );
                this.data.latest_epoch.rate_average =
                    sum / this.data.latest_epoch.delegated_providers.length;
            } else {
                this.data.latest_epoch.rate_average = parseFloat(
                    this.getRewardRate(
                        this.data.latest_epoch.delegated_providers[0]
                    )
                );
            }

            this.data.latest_epoch.delegated_providers.map((p) => {
                if (p.uid == this.data.latest_epoch.provider_id_1) {
                    p.delegated_percentage =
                        this.data.latest_epoch.provider_percentage_1 / 10000;
                }
                if (p.uid == this.data.latest_epoch.provider_id_2) {
                    p.delegated_percentage =
                        this.data.latest_epoch.provider_percentage_2 / 10000;
                }
            });

            if (this.data.previous_epoch !== null) {
                let previous_sum =
                    this.data.previous_provider_reward_states.reduce(
                        (a, b) =>
                            parseFloat(
                                this.getRewardRate({ reward_state: a })
                            ) +
                            parseFloat(this.getRewardRate({ reward_state: b }))
                    );
                this.data.previous_epoch.rate_average =
                    previous_sum /
                    this.data.previous_provider_reward_states.length;
            }
            this.loaded = true;
        },

        parseBigNumber(num) {
            if (num >= 1000000000) {
                return (num / 1000000000).toFixed(1).replace(/\.0$/, "") + "B";
            }
            if (num >= 1000000) {
                return (num / 1000000).toFixed(1).replace(/\.0$/, "") + "M";
            }
            if (num >= 1000) {
                return (num / 1000).toFixed(1).replace(/\.0$/, "") + "K";
            }
            return parseFloat(num).toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            });
        },
        getRewardRate(provider) {
            // Update logic to share average reward rate when available
            if (1 == 1) {
                var state = provider.reward_state;
                var multiplier = 100 - state.provider_fee;
                multiplier = multiplier / state.provider_fee;
                return (
                    ((multiplier * state.provider_reward_state) /
                        state.provider_votepower) *
                    100
                ).toFixed(3);
            }
        },
    },
};
</script>
<style scoped></style>
