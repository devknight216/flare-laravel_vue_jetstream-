<template>
    <!-- TODO:  Ntoify user no stats when returned data is null-->
    <div
        class="
            w-full
            grid
            sm:grid-cols-1
            md:grid-cols-2
            lg:grid-cols-3
            xl:grid-cols-3
            gap-8
        "
    >
        <div
            v-for="(stat, i) in items"
            :key="i"
            class="
                bg-white
                dark:bg-gray-800
                rounded
                pt-2
                pl-2
                pr-12
                pb-2
                flex
                items-start
                shadow
            "
        >
            <div class="text-gray-700 dark:text-gray-400">
                <svg
                    v-if="stat.icon == 'views'"
                    xmlns="http://www.w3.org/2000/svg"
                    class="icon icon-tabler icon-tabler-dashboard"
                    width="32"
                    height="32"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path stroke="none" d="M0 0h24v24H0z" />
                    <circle cx="12" cy="13" r="2" />
                    <line x1="13.45" y1="11.55" x2="15.5" y2="9.5" />
                    <path d="M6.4 20a9 9 0 1 1 11.2 0Z" />
                </svg>
                <svg
                    v-if="stat.icon == 'engagement'"
                    id="Layer_1"
                    enable-background="new 0 0 512.258 512.258"
                    width="30"
                    height="30"
                    viewBox="0 0 512.258 512.258"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="m187.158 512.258c-11.046 0-20-8.954-20-20v-8c0-11.028-8.972-20-20-20h-16.985c-38.866.695-73.928-31.499-76.545-70.283-.001.001-4.005-46.852-4.005-46.852-37.285-1.867-61.476-44.666-43.404-77.542 9.747-18.653 24.282-40.56 44.352-66.834 1.279-136.783 118.308-215.558 249.675-201.034 26.219 3.707 22.279 41.601-4.176 39.779-114.634-12.501-208.088 56.424-205.586 168.174-.002 4.433-1.476 8.742-4.193 12.248-20.449 26.393-35.462 48.664-44.623 66.193-3.044 5.825-.712 10.847.433 12.736 1.168 1.929 4.613 6.414 11.357 6.414 18.758 0 34.107 14.094 35.705 32.784 0 0 4.319 50.527 4.319 50.527 1.641 19.206 17.415 33.689 36.69 33.689h16.985c33.084 0 60 26.916 60 60v8c.001 11.047-8.953 20.001-19.999 20.001zm249-20v-124c0-27.662 9.331-46.302 20.604-66.101 5.466-9.599 2.115-21.811-7.484-27.276-9.596-5.464-21.811-2.114-27.275 7.484-13.077 22.968-25.845 48.519-25.845 85.893v124c.955 26.444 39.003 26.547 40 0zm-51-335.997c0 13.807-11.193 25-25 25-33.126-1.226-33.117-48.779 0-50 13.807 0 25 11.193 25 25zm127 0c0 18.787-9.207 36.387-24.629 47.08-91.409 64.33-165.408 64.278-256.742-.002-32.553-21.751-32.584-72.4.001-94.158 91.408-64.33 165.407-64.279 256.741.002 15.422 10.691 24.629 28.291 24.629 47.078zm-40 0c0-5.76-2.705-10.938-7.422-14.209-78.626-54.919-132.605-54.862-211.156.001-9.813 6.436-9.837 21.977 0 28.416 78.626 54.918 132.605 54.862 211.156-.002 4.717-3.268 7.422-8.447 7.422-14.206z"
                    />
                </svg>
                <svg
                    v-if="stat.icon == 'clicks'"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    version="1.1"
                    id="Capa_1"
                    x="0px"
                    y="0px"
                    viewBox="0 0 512 512"
                    style="enable-background: new 0 0 512 512"
                    xml:space="preserve"
                    width="30"
                    height="30"
                >
                    <g>
                        <path
                            d="M397.491,219.415c-5.54,0-10.838,1.042-15.723,2.923c-5.403-18.122-22.212-31.377-42.067-31.377   c-5.711,0-11.165,1.108-16.174,3.101c-5.838-17.393-22.281-29.965-41.616-29.965c-4.856,0-9.525,0.804-13.895,2.267v-46.47   c0-24.203-19.691-43.895-43.895-43.895s-43.895,19.691-43.895,43.895v189.863l-17.144-25.448l-0.398-0.495   c-16.801-20.884-46.358-25.525-68.751-10.794c-11.709,7.703-19.642,19.52-22.337,33.273c-2.676,13.656,0.15,27.494,7.958,38.998   l76.406,120.437l0.301,0.457C175.965,494.873,208.505,512,243.308,512h85.751c61.938,0,112.327-50.39,112.327-112.327V263.311   C441.386,239.106,421.695,219.415,397.491,219.415z M411.386,399.673c0,45.396-36.932,82.327-82.327,82.327h-85.751   c-24.829,0-48.048-12.175-62.168-32.583L104.753,329.01l-0.301-0.457c-3.334-4.854-4.546-10.71-3.414-16.489   c1.133-5.778,4.466-10.744,9.386-13.98c9.254-6.089,21.419-4.301,28.535,4.107l71.27,105.796V119.895   c0-7.661,6.233-13.895,13.895-13.895s13.895,6.233,13.895,13.895V269.79h30v-61.798c0-7.661,6.233-13.895,13.895-13.895   s13.895,6.233,13.895,13.895v61.798h30v-34.935c0-7.661,6.233-13.895,13.895-13.895s13.895,6.233,13.895,13.895v34.935h30v-5.296   v-1.184c0-7.662,6.233-13.896,13.895-13.896s13.895,6.233,13.895,13.896V399.673z"
                        />
                        <rect x="208.284" width="30" height="41.5" />
                        <rect
                            x="261.832"
                            y="28.147"
                            transform="matrix(0.6736 -0.7391 0.7391 0.6736 60.3529 222.949)"
                            width="41.5"
                            height="30"
                        />
                        <rect
                            x="290.574"
                            y="84.644"
                            transform="matrix(0.9957 -0.0926 0.0926 0.9957 -7.8875 29.2482)"
                            width="41.5"
                            height="30"
                        />
                        <rect
                            x="148.06"
                            y="22.397"
                            transform="matrix(0.7391 -0.6736 0.6736 0.7391 13.4755 121.0881)"
                            width="30"
                            height="41.5"
                        />
                        <rect
                            x="119.318"
                            y="78.894"
                            transform="matrix(0.0926 -0.9957 0.9957 0.0926 22.6684 224.1608)"
                            width="30"
                            height="41.5"
                        />
                    </g>
                </svg>
            </div>
            <div class="pl-3 mt-1">
                <h3
                    class="
                        mb-3
                        leading-4
                        text-gray-600
                        dark:text-gray-400
                        text-base
                    "
                >
                    {{ stat.name }}
                </h3>
                <div class="flex items-center">
                    <h2
                        class="
                            text-gray-800
                            dark:text-gray-100
                            text-2xl
                            leading-normal
                            font-bold
                        "
                    >
                        <span v-if="stat.value"
                            >{{ stat.value }}{{ stat.append }}</span
                        >
                        <div
                            v-else
                            class="
                                w-12
                                h-6
                                bg-gray-200
                                animate-pulse
                                rounded
                                my-1
                            "
                        ></div>
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Card code block end -->
</template>
<script>
export default {
    name: "FtsoPageStatitics",
    props: ["code", "period"],
    data() {
        return {
            items: [
                { name: "Page View", value: null, icon: "views", append: "" },
                { name: "Clicks", value: null, icon: "clicks", append: "" },
                {
                    name: "User Engagement",
                    value: null,
                    icon: "engagement",
                    append: "sec",
                },
            ],
        };
    },
    deactivated: function () {
    },

    mounted: function () {
        setTimeout(() => {
            axios
                .get(route("analytics.ftso"), {
                    params: {
                        period: this.$props.period,
                        ftso_code: this.$props.code,
                    },
                })
                .then((response) => {
                    var d = response.data[0];
                    this.items = [
                        {
                            name: "Page View",
                            value: d.page_view.eventCount,
                            icon: "views",
                            append: "",
                        },
                        {
                            name: "Clicks",
                            value: d.click.eventCount,
                            icon: "clicks",
                            append: "",
                        },
                        {
                            name: "User Engagement",
                            value: d.user_engagement.eventCount,
                            icon: "engagement",
                            append: "sec",
                        },
                    ];
                });
        }, 2000);
    },
};
</script>
