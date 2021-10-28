<template>
    <div
        ref="pool_modal"
        v-show="showModal"
        class="
            opacity-0
            py-12
            bg-gray-700 bg-opacity-20
            transition
            duration-150
            ease-in-out
            z-10
            absolute
            top-0
            right-0
            bottom-0
            left-0
        "
        id="add-pool-modal"
    >
        <div
            role="alert"
            class="
                container
                mx-auto
                w-11/12
                md:w-2/3
                max-w-lg
                flex
                justify-center
                mt-0
                md:mt-24
            "
        >
            <div
                class="
                    relative
                    w-96
                    rounded
                    shadow-lg
                    p-6
                    dark:bg-gray-800
                    bg-white
                "
            >
                <p
                    class="
                        text-lg
                        font-bold
                        leading-none
                        text-gray-800
                        dark:text-gray-100
                    "
                >
                    Add Pool
                </p>
                <form class="mt-5">
                    <div class="flex flex-col">
                        <label
                            class="
                                text-xs
                                font-semibold
                                leading-3
                                text-gray-800
                                dark:text-gray-100
                            "
                        >
                            Pool Name
                        </label>
                        <input
                            v-model="pool.name"
                            placeholder="Enter pool name"
                            class="
                                text-xs
                                font-medium
                                leading-3
                                text-gray-500
                                dark:text-gray-400
                                resize-none
                                bg-gray-50
                                dark:bg-gray-700
                                border
                                rounded-lg
                                border-gray-200
                                dark:border-gray-700
                                focus:outline-none
                                px-4
                                py-3
                                mt-2
                            "
                        />
                    </div>
                    <div class="mt-4 flex flex-col">
                        <label
                            class="
                                text-xs
                                font-semibold
                                leading-3
                                text-gray-800
                                dark:text-gray-100
                            "
                        >
                            Pool Description
                        </label>
                        <textarea
                            v-model="pool.description"
                            placeholder="Enter a short description about this pool."
                            class="
                                text-xs
                                font-medium
                                leading-3
                                text-gray-500
                                dark:text-gray-400
                                resize-none
                                h-20
                                bg-gray-50
                                dark:bg-gray-700
                                border
                                rounded-lg
                                border-gray-200
                                dark:border-gray-700
                                focus:outline-none
                                px-4
                                py-3
                                mt-2
                            "
                        ></textarea>
                    </div>

                    <div class="mt-4">
                        <label
                            class="
                                text-xs
                                font-semibold
                                leading-3
                                text-gray-800
                                dark:text-gray-100
                            "
                        >
                            Network
                        </label>
                        <div
                            class="
                                py-1
                                rounded-lg
                                px-4
                                bg-gray-50
                                dark:bg-gray-700
                                border border-gray-200
                                dark:border-gray-700
                                mt-2
                            "
                        >
                            <select
                                v-model="pool.network"
                                class="
                                    text-xs
                                    focus:outline-none
                                    font-medium
                                    leading-3
                                    text-gray-600
                                    dark:text-gray-100
                                    bg-transparent
                                    border-none
                                    w-full
                                "
                            >
                                <option value="default" disabled selected>
                                    Select Network
                                </option>
                                <option value="flare">Flare</option>
                                <option value="songbird">Songbird</option>
                                <option value="coston">Coston</option>
                            </select>
                        </div>
                        <div class="flex flex-col mt-5">
                            <label
                                class="
                                    text-xs
                                    font-semibold
                                    leading-3
                                    text-gray-800
                                    dark:text-gray-100
                                "
                            >
                                Address
                            </label>
                            <input
                                v-model="pool.address"
                                placeholder="Enter pool address"
                                class="
                                    text-xs
                                    font-medium
                                    leading-3
                                    text-gray-500
                                    dark:text-gray-400
                                    resize-none
                                    bg-gray-50
                                    dark:bg-gray-700
                                    border
                                    rounded-lg
                                    border-gray-200
                                    dark:border-gray-700
                                    focus:outline-none
                                    px-4
                                    py-3
                                    mt-2
                                "
                            />
                        </div>
                    </div>
                    <button
                        @click="submit($event)"
                        id="submit"
                        class="
                            mt-5
                            focus:outline-none
                            px-5
                            py-3
                            bg-indigo-700
                            dark:bg-indigo-600
                            hover:bg-opacity-80
                            rounded
                            text-xs
                            font-semibold
                            leading-3
                            text-gray-100
                        "
                    >
                        Submit
                    </button>
                    <div v-if="errors.error" class="mt-3 text-xs text-red-600">
                        {{ errors.message }}
                    </div>
                </form>

                <div
                    class="
                        cursor-pointer
                        absolute
                        top-0
                        right-0
                        m-3
                        dark:text-gray-100
                        text-gray-600
                        transition
                        duration-150
                        ease-in-out
                    "
                    @click="modalHandler()"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        aria-label="Close"
                        class="icon icon-tabler icon-tabler-x"
                        width="20"
                        height="20"
                        viewBox="0 0 24 24"
                        stroke-width="2.5"
                        stroke="currentColor"
                        fill="none"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path stroke="none" d="M0 0h24v24H0z" />
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["code"],
    data() {
        return {
            mobileMenu: true,
            showModal: false,
            pool: {
                name: "",
                description: "",
                network: "default",
                address: "",
                provider: "",
            },
            errors: {
                error: false,
                message: "",
            },
            disabled: false,
        };
    },
    methods: {
        submit(event) {
            if (this.disabled) return;
            this.disabled = true;
            event.preventDefault();
            this.pool.provider = this.$props.code;
            this.errors.error = false;
            axios
                .post(route("action.provider.create-pool"), this.pool)
                .then((response) => {
                    if (response.data.error) {
                        this.errors.error = true;
                        this.errors.message = response.data.errors;
                        return;
                    }
                    this.modalHandler(false);
                    this.$emit("poolAdded");
                })
                .finally(() => {
                    this.disabled = false;
                });
        },
        modalHandler(val) {
            this.showModal = val;

            let modal = this.$refs.pool_modal;
            if (val) {
                fadeIn(modal);
            } else {
                fadeOut(modal);
            }
            function fadeOut(el) {
                el.style.opacity = 1;
                (function fade() {
                    if ((el.style.opacity -= 0.1) < 0) {
                        el.style.display = "none";
                    } else {
                        requestAnimationFrame(fade);
                    }
                })();
            }
            function fadeIn(el, display) {
                el.style.opacity = 0;
                el.style.display = display || "block";
                (function fade() {
                    let val = parseFloat(el.style.opacity);
                    if (!((val += 0.2) > 1)) {
                        el.style.opacity = val;
                        requestAnimationFrame(fade);
                    }
                })();
            }
        },
    },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped></style>
