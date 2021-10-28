<template>
    <div v-show="modal_visible" class="dark:bg-black bg-gray-300">
        <div
            class="
                py-12
                bg-gray-700 bg-opacity-50
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
            id="modal"
        >
            <div
                role="alert"
                class="
                    container
                    m-auto
                    md:mx-auto md:mt-32
                    w-11/12
                    md:w-2/3
                    max-w-lg
                "
            >
                <div
                    v-show="stage == 0"
                    class="
                        relative
                        rounded
                        shadow-lg
                        p-6
                        dark:bg-gray-800 dark:text-gray-100
                        bg-white
                    "
                >
                    <h1
                        class="
                            dark:text-gray-100
                            text-gray-800
                            font-bold
                            text-lg
                        "
                    >
                        Track Address
                    </h1>
                    <div class="mt-2">
                        Input your wallet address to begin tracking rewards.
                    </div>
                    <div class="flex flex-col mt-2">
                        <label
                            for="address"
                            class="
                                font-semibold
                                dark:text-gray-100
                                leading-tight
                            "
                            >Address</label
                        >
                        <input
                            v-model="address"
                            required
                            name="address"
                            id="address"
                            class="
                                h-10
                                px-2
                                w-full
                                rounded
                                mt-2
                                text-gray-600
                                dark:text-gray-400
                                bg-white
                                dark:bg-gray-800
                                dark:border-gray-700
                                dark:focus:border-indigo-600
                                focus:outline-none
                                focus:border
                                focus:border-indigo-700
                                border-gray-300 border
                                shadow
                            "
                            type="text"
                        />
                    </div>
                    <div class="flex flex-col mt-2">
                        <label
                            for="invite"
                            class="
                                font-semibold
                                dark:text-gray-100
                                leading-tight
                            "
                            >Invite Code</label
                        >
                        <input
                            v-model="invite_code"
                            required
                            name="invite"
                            id="invite"
                            class="
                                h-10
                                px-2
                                w-36
                                rounded
                                mt-2
                                text-gray-600
                                dark:text-gray-400
                                bg-white
                                dark:bg-gray-800
                                dark:border-gray-700
                                dark:focus:border-indigo-600
                                focus:outline-none
                                focus:border
                                focus:border-indigo-700
                                border-gray-300 border
                                shadow
                            "
                            type="text"
                        />
                    </div>
                    <p
                        class="
                            text-xs
                            font-medium
                            dark:text-gray-100
                            text-gray-600
                            mt-2
                        "
                    >
                        <span class="font-bold">Note:</span> We collect and
                        store information about your address.
                    </p>
                    <div v-if="errors.length > 0">
                        <p
                            v-for="(error, index) in errors"
                            :key="index"
                            class="
                                text-sm
                                font-medium
                                dark:text-gray-100
                                text-red-700
                                mt-2
                            "
                        >
                            {{ error }}
                        </p>
                    </div>
                    <div class="flex items-center justify-between pt-6">
                        <button
                            class="
                                py-3.5
                                px-10
                                dark:text-gray-100
                                text-gray-600
                                focus:outline-none
                                hover:opacity-90
                                text-sm
                                font-semibold
                                border border-gray-600
                                rounded
                            "
                            @click="modalHandler()"
                        >
                            Cancel
                        </button>
                        <button
                            @click="submit()"
                            class="
                                py-3.5
                                px-10
                                sm:mt-0
                                mt-4
                                focus:outline-none
                                hover:opacity-90
                                rounded
                                text-indigo-700
                                dark:text-indigo-400
                                border border-indigo-700
                                dark:border-indigo-400
                                text-sm
                                font-semibold
                                bg-primary
                            "
                        >
                            Link
                        </button>
                    </div>
                    <div
                        class="
                            cursor-pointer
                            absolute
                            top-0
                            right-0
                            mt-4
                            mr-5
                            hover:
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
    </div>
</template>

<script>
export default {
    name: "AddEmailModule",
    data() {
        return {
            stage: 0,
            modal_visible: false,
            address: "",
            errors: [],
            invite_code: "",
        };
    },
    mounted: function () {
        //   this.modalHandler(false);
    },
    methods: {
        submit() {
            if (ethers.utils.isAddress(this.address) == false) {
                this.errors = [
                    `Please enter a valid ${
                        this.$store.state.chainName.charAt(0).toUpperCase() +
                        this.$store.state.chainName.slice(1)
                    } address`,
                ];
                return;
            }
            axios
                .post(route("user.ftso.tracking.add"), {
                    address: this.address,
                    invite_code: this.invite_code,
                })
                .then((response) => {
                    if (response.data.error) {
                        this.errors = response.data.errors;
                        return;
                    }
                    this.$emit("added");
                    this.modalHandler(false);
                })
                .catch((error) => {
                    this.errors = ["Something went wrong..."];
                    console.log(error);
                });
        },
        modalHandler(val) {
            let modal = document.getElementById("modal");
            if (val) {
                this.modal_visible = true;
                this.fadeIn(modal);
            } else {
                this.fadeOut(modal);
            }
        },
        fadeOut(el) {
            el.style.opacity = 1;
            (function fade() {
                if ((el.style.opacity -= 0.1) < 0) {
                    el.style.display = "none";
                } else {
                    requestAnimationFrame(fade);
                }
            })();
        },
        fadeIn(el, display) {
            el.style.opacity = 0;
            el.style.display = display || "flex";
            (function fade() {
                let val = parseFloat(el.style.opacity);
                if (!((val += 0.2) > 1)) {
                    el.style.opacity = val;
                    requestAnimationFrame(fade);
                }
            })();
        },
    },
};
</script>
