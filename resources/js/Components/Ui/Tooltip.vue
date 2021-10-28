<template>
    <!--Code Block for white tooltip starts-->
    <div class="relative" @click="scrollIntoView()">
        <div
            :id="id"
            role="tooltip"
            class="
                z-20
                transition
                duration-150
                ease-in-out
                bottom-0
                mb-5
                absolute
                shadow-lg
                pt-4
                pr-3
                pl-3
                pb-3
                bg-white
                text-gray-600
                rounded
                w-72
                opacity-0
                select-none
                pointer-events-none
            "
        >
            <svg
                class="absolute bottom-0 -mb-1"
                width="16px"
                height="8px"
                viewBox="0 0 16 8"
                version="1.1"
                xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink"
            >
                <g
                    id="Page-1"
                    stroke="none"
                    stroke-width="1"
                    fill="none"
                    fill-rule="evenodd"
                >
                    <g
                        id="Tooltips-"
                        transform="translate(-84.000000, -203.000000)"
                        fill="#FFFFFF"
                    >
                        <g
                            id="Group-3-Copy"
                            transform="translate(76.000000, 145.000000)"
                        >
                            <polygon
                                class="shadow"
                                id="Triangle"
                                transform="translate(16.000000, 62.000000) rotate(-180.000000) translate(-16.000000, -62.000000) "
                                points="16 58 24 66 8 66"
                            ></polygon>
                        </g>
                    </g>
                </g>
            </svg>
            <p class="text-xs text-gray-600 leading-4">
                {{ text }}
            </p>
        </div>
        <div
            @mouseover="showTooltip(1)"
            @mouseout="hideTooltip(1)"
            class="ml-2 cursor-pointer"
        >
            <svg
                aria-haspopup="true"
                xmlns="http://www.w3.org/2000/svg"
                class="icon icon-tabler icon-tabler-info-circle"
                width="16"
                height="16"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="#A0AEC0"
                fill="none"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <path stroke="none" d="M0 0h24v24H0z" />
                <circle cx="12" cy="12" r="9" />
                <line x1="12" y1="8" x2="12.01" y2="8" />
                <polyline points="11 12 12 12 12 16 13 16" />
            </svg>
        </div>
    </div>
</template>

<script>
export default {
    name: "ToolTip",
    props: ["text", "id"],
    methods: {
        scrollIntoView() {
            document.getElementById(this.$props.id).scrollIntoView({
                behavior: "smooth",
                block: "end",
                inline: "nearest",
            });
        },
        showTooltip(flag) {
            switch (flag) {
                case 1:
                    document
                        .getElementById(this.$props.id)
                        .classList.remove("opacity-0");

                    break;
            }
        },
        hideTooltip(flag) {
            switch (flag) {
                case 1:
                    document
                        .getElementById(this.$props.id)
                        .classList.add("opacity-0");
                    break;
            }
        },
    },
};
</script>
