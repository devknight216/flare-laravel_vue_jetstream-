<template>
    <div
        ref="login_modal"
        class="
            md:py-12
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
            flex
            items-center
            md:items-start
            hidden
            opacity-0
        "
    >
        <div
            role="alert"
            class="
                fixed
                md:static md:flex
                h-screen
                md:h-auto
                overflow-y-hidden
                container
                md:mx-auto md:mt-36
                justify-center
                w-full
                md:w-1/2
                xl:w-1/4
                md:px-4
            "
        >
            <div
                class="
                    relative
                    bg-white
                    dark:bg-gray-800
                    w-full
                    shadow
                    md:rounded-md
                    h-full
                "
            >
                <div class="sm:flex items-center items-stretch">
                    <div class="w-full">
                        <div class="px-6 w-full pt-8">
                            <img
                                class="md:hidden h-6 mb-8"
                                :src="
                                    !isDark
                                        ? '/images/flaremetrics-logo-sm.png'
                                        : '/images/flaremetrics-logo-sm-light.png'
                                "
                                alt=""
                            />
                            <p
                                class="
                                    text-2xl
                                    font-bold
                                    leading-5
                                    text-gray-800
                                    dark:text-gray-100
                                "
                            >
                                Sign in
                            </p>
                            <p
                                class="
                                    text-sm
                                    leading-4
                                    text-gray-600
                                    mt-4
                                    mb-5
                                    dark:text-gray-300
                                "
                            >
                                Personalised features coming soon :)
                            </p>

                            <jet-validation-errors class="mb-4" />

                            <div
                                v-if="status"
                                class="mb-4 font-medium text-sm text-green-600"
                            >
                                {{ status }}
                            </div>

                            <form @submit.prevent="submit">
                                <div>
                                    <jet-label for="email" value="Email" />
                                    <jet-input
                                        id="email"
                                        type="email"
                                        class="mt-1 block w-full"
                                        v-model="form.email"
                                        required
                                        autofocus
                                    />
                                </div>

                                <div class="mt-4">
                                    <jet-label
                                        for="password"
                                        value="Password"
                                    />
                                    <jet-input
                                        id="password"
                                        type="password"
                                        class="mt-1 block w-full"
                                        v-model="form.password"
                                        required
                                        autocomplete="current-password"
                                    />
                                </div>

                                <div class="flex justify-between">
                                    <div class="block mt-4">
                                        <label class="flex items-center">
                                            <jet-checkbox
                                                name="remember"
                                                v-model:checked="form.remember"
                                            />
                                            <span
                                                class="
                                                    ml-2
                                                    text-sm text-gray-600
                                                "
                                                >Remember me</span
                                            >
                                        </label>
                                    </div>

                                    <div
                                        class="
                                            flex
                                            items-center
                                            justify-end
                                            items-center
                                            mt-4
                                        "
                                    >
                                        <button
                                            class="
                                                focus:outline-none
                                                px-5
                                                py-2
                                                bg-indigo-700
                                                dark:bg-indigo-600
                                                rounded
                                                text-sm
                                                font-medium
                                                text-gray-100
                                                hover:bg-opacity-80
                                            "
                                            :class="{
                                                'opacity-25': form.processing,
                                            }"
                                            :disabled="form.processing"
                                        >
                                            Login
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <div class="flex items-center justify-between my-4">
                                <p
                                    @click="forgotPassword()"
                                    class="
                                        text-xs
                                        font-medium
                                        leading-3
                                        text-gray-600
                                        dark:text-gray-300
                                        cursor-pointer
                                    "
                                >
                                    Forgot Password?
                                </p>
                                <p
                                    @click="$inertia.get(route('register'))"
                                    class="
                                        text-xs
                                        leading-3
                                        text-gray-600
                                        dark:text-gray-300
                                        cursor-pointer
                                    "
                                >
                                    Don’t have an account?
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="
                        cursor-pointer
                        absolute
                        top-0
                        right-0
                        m-3
                        text-gray-800
                        dark:text-gray-100
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
import JetAuthenticationCard from "@/Jetstream/AuthenticationCard";
import JetAuthenticationCardLogo from "@/Jetstream/AuthenticationCardLogo";
import JetButton from "@/Jetstream/Button";
import JetInput from "@/Jetstream/Input";
import JetCheckbox from "@/Jetstream/Checkbox";
import JetLabel from "@/Jetstream/Label";
import JetValidationErrors from "@/Jetstream/ValidationErrors";

export default {
    components: {
        JetAuthenticationCard,
        JetAuthenticationCardLogo,
        JetButton,
        JetInput,
        JetCheckbox,
        JetLabel,
        JetValidationErrors,
    },

    data() {
        return {
            form: this.$inertia.form({
                email: "",
                password: "",
                remember: false,
            }),
        };
    },

    props: {
        canResetPassword: Boolean,
        status: String,
    },

    methods: {
        forgotPassword() {
            this.modalHandler(false);
            return this.$inertia.get(route("password.request"));
        },
        submit() {
            this.form
                .transform((data) => ({
                    ...data,
                    remember: this.form.remember ? "on" : "",
                }))
                .post(this.route("login"), {
                    onFinish: () => {
                        this.form.reset("password");
                        console.log("on fin");
                        console.log(this.$page.props.user);
                        if (this.$page.props.user) {
                            console.log("close modal");
                            this.modalHandler(false);
                        }
                    },
                });
        },
        modalHandler(val) {
            let modal = this.$refs.login_modal;
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

<style scoped></style>
