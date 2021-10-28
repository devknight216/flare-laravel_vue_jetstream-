<template>
    <body>
        <div class="md:flex items-center border-b pb-6 border-gray-200">
            <div @click="goToStep(1)" class="flex items-center md:mt-0 mt-4">
                <div
                    class="
                        w-8
                        h-8
                        bg-gray-100
                        rounded
                        flex
                        items-center
                        justify-center
                    "
                    :class="step === 1 ? 'bg-indigo-700 text-white' : ''"
                >
                    <p class="text-base font-medium leading-none">01</p>
                </div>
                <p class="text-base ml-3 font-medium leading-4 text-gray-800">
                    Profile
                </p>
            </div>
            <div
                @click="goToStep(2)"
                class="flex items-center md:mt-0 mt-4 md:ml-12"
            >
                <div
                    class="
                        w-8
                        h-8
                        bg-gray-100
                        rounded
                        flex
                        items-center
                        justify-center
                    "
                    :class="step === 2 ? 'bg-indigo-700 text-white' : ''"
                >
                    <p class="text-base font-medium leading-none">02</p>
                </div>
                <p class="text-base ml-3 font-medium leading-4 text-gray-800">
                    Meta Info
                </p>
            </div>
            <div
                @click="goToStep(3)"
                class="flex items-center md:mt-0 mt-4 md:ml-12"
            >
                <div
                    class="
                        w-8
                        h-8
                        bg-gray-100
                        rounded
                        flex
                        items-center
                        justify-center
                    "
                    :class="step === 3 ? 'bg-indigo-700 text-white' : ''"
                >
                    <p class="text-base font-medium leading-none">03</p>
                </div>
                <p class="text-base ml-3 font-medium leading-4 text-gray-800">
                    Socials
                </p>
            </div>
            <div
                @click="goToStep(4)"
                class="flex items-center md:mt-0 mt-4 md:ml-12"
            >
                <div
                    class="
                        w-8
                        h-8
                        bg-gray-100
                        rounded
                        flex
                        items-center
                        justify-center
                    "
                    :class="step === 4 ? 'bg-indigo-700 text-white' : ''"
                >
                    <p class="text-base font-medium leading-none">04</p>
                </div>
                <p class="text-base ml-3 font-medium leading-4 text-gray-800">
                    Verification
                </p>
            </div>
        </div>
        <div class="mt-4 text-gray-700 text-lg font-semibold capitalize">
            {{ application.type }}
            <span class="text-indigo-700 font-bold">{{
                application.name
            }}</span>
        </div>
        <template v-if="step == 1">
            <h1
                tabindex="0"
                role="heading"
                aria-label="profile information"
                class="focus:outline-none text-3xl font-bold text-gray-800 mt-6"
            >
                Profile info
            </h1>
            <p
                role="contentinfo"
                class="
                    focus:outline-nonetext-sm
                    font-light
                    leading-tight
                    text-gray-600
                    mt-4
                "
            >
                Please enter the details about your FTSO signal provider service
                as accurately as possible.
            </p>
            <!-- <h2
            role="heading"
            aria-label="enter Personal data"
            class="text-xl font-semibold leading-7 text-gray-800 mt-10"
        >
            Personal data
        </h2>
        <p class="text-sm font-light leading-none text-gray-600 mt-0.5">
            Your details and place of birth
        </p> -->
            <div class="mt-8 md:flex items-center">
                <div class="flex flex-col">
                    <label class="mb-3 text-sm leading-none text-gray-800"
                        >Provider Name</label
                    >
                    <input
                        v-model="form.name"
                        type="name"
                        tabindex="0"
                        aria-label="Enter first name"
                        class="
                            w-64
                            bg-gray-50
                            text-sm
                            font-medium
                            leading-none
                            text-gray-800
                            p-3
                            border
                            rounded
                            border-gray-200
                        "
                        placeholder="FTSO XYZ"
                    />
                </div>
                <div class="flex flex-col md:ml-12 md:mt-0 mt-8">
                    <label class="mb-3 text-sm leading-none text-gray-800"
                        >Admin Email</label
                    >
                    <input
                        v-model="form.admin_email"
                        type="email"
                        tabindex="0"
                        aria-label="Enter email Address"
                        class="
                            w-64
                            bg-gray-50
                            text-sm
                            font-medium
                            leading-none
                            text-gray-800
                            p-3
                            border
                            rounded
                            border-gray-200
                        "
                        placeholder="admin@ftsoxyz.com"
                    />
                </div>
            </div>
            <div class="mt-12 md:flex items-center">
                <div class="flex flex-col">
                    <label class="mb-3 text-sm leading-none text-gray-800"
                        >Established Date</label
                    >
                    <input
                        v-model="form.info.established"
                        type="date"
                        tabindex="0"
                        aria-label="Enter email Address"
                        class="
                            w-64
                            bg-gray-50
                            text-sm
                            font-medium
                            leading-none
                            text-gray-800
                            p-3
                            border
                            rounded
                            border-gray-200
                        "
                    />
                </div>
                <div class="flex flex-col md:ml-12 md:mt-0 mt-8">
                    <label class="mb-3 text-sm leading-none text-gray-800"
                        >Website URL</label
                    >
                    <input
                        v-model="form.website_url"
                        type="url"
                        tabindex="0"
                        aria-label="Enter website URL"
                        class="
                            w-64
                            bg-gray-50
                            text-sm
                            font-medium
                            leading-none
                            text-gray-800
                            p-3
                            border
                            rounded
                            border-gray-200
                        "
                        placeholder="https://ftsoxyz.com/"
                    />
                </div>
            </div>
            <div class="mt-12 md:flex items-center">
                <div class="flex flex-col w-132">
                    <label class="mb-3 text-sm leading-none text-gray-800"
                        >Short Description</label
                    >
                    <textarea
                        v-model="form.description"
                        type=""
                        tabindex="0"
                        aria-label="Enter short description"
                        class="
                            w-132
                            h-44
                            bg-gray-50
                            text-sm
                            font-medium
                            leading-none
                            text-gray-800
                            p-3
                            border
                            rounded
                            border-gray-200
                        "
                        placeholder="A small brief of your provider service."
                    />
                    <div class="text-sm mt-1">
                        <span class="text-gray-600">Character Count: </span>
                        <span
                            :class="
                                form.description.length > 156
                                    ? 'text-red-600'
                                    : form.description.length < 30
                                    ? 'text-yellow-600'
                                    : 'text-green-600'
                            "
                            >{{ form.description.length }}</span
                        >
                        <span class="text-gray-300 ml-1">(Max 156) </span>
                    </div>
                </div>
            </div>
            <div class="mt-12 md:flex items-center">
                <div class="flex flex-col w-132">
                    <label class="mb-3 text-sm leading-none text-gray-800"
                        >Extended Description</label
                    >
                    <textarea
                        v-model="form.extended_description"
                        type=""
                        tabindex="0"
                        aria-label="Enter extended description"
                        class="
                            w-132
                            h-44
                            bg-gray-50
                            text-sm
                            font-medium
                            leading-none
                            text-gray-800
                            p-3
                            border
                            rounded
                            border-gray-200
                        "
                        placeholder="A longer detail of your provider service."
                    />
                    <div class="text-sm mt-1">
                        <span class="text-gray-600">Character Count: </span>
                        <span
                            :class="
                                form.extended_description.length > 800
                                    ? 'text-red-600'
                                    : form.extended_description.length < 45
                                    ? 'text-yellow-600'
                                    : 'text-green-600'
                            "
                            >{{ form.extended_description.length }}</span
                        >
                        <span class="text-gray-300 ml-1">(Max 800) </span>
                    </div>
                </div>
            </div>
        </template>
        <!-- Meta Info -->
        <template v-if="step == 2">
            <h1
                tabindex="0"
                role="heading"
                aria-label="profile information"
                class="focus:outline-none text-3xl font-bold text-gray-800 mt-6"
            >
                Meta Information
            </h1>

            <!-- <h2
            role="heading"
            aria-label="enter Personal data"
            class="text-xl font-semibold leading-7 text-gray-800 mt-10"
        >
            Personal data
        </h2>
        <p class="text-sm font-light leading-none text-gray-600 mt-0.5">
            Your details and place of birth
        </p> -->
            <div class="mt-8 md:flex items-center">
                <!-- Hosted Continent -->
                <div class="flex flex-col">
                    <label class="mb-3 text-sm leading-none text-gray-800"
                        >Hosted Continent</label
                    >

                    <select
                        v-model="form.info.local"
                        class="
                            w-64
                            bg-gray-50
                            text-sm
                            font-medium
                            leading-none
                            text-gray-800
                            p-3
                            border
                            rounded
                            border-gray-200
                        "
                    >
                        <option
                            v-for="(c, i) in continents()"
                            :key="i"
                            :value="c"
                        >
                            {{ c }}
                        </option>
                    </select>
                </div>
                <!-- Hosted Country -->
                <div class="flex flex-col md:ml-12 md:mt-0 mt-8">
                    <label class="mb-3 text-sm leading-none text-gray-800"
                        >Hosted Country</label
                    >
                    <select
                        v-model="form.info.country"
                        class="
                            w-64
                            bg-gray-50
                            text-sm
                            font-medium
                            leading-none
                            text-gray-800
                            p-3
                            border
                            rounded
                            border-gray-200
                        "
                    >
                        <option
                            v-for="(c, i) in countries()"
                            :key="i"
                            :value="c"
                        >
                            {{ c }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="mt-12 md:flex items-center">
                <div class="flex flex-col">
                    <label class="mb-3 text-sm leading-none text-gray-800"
                        >Logo</label
                    >
                    <input
                        class="hidden"
                        id="logo_image"
                        @change="processFile($event)"
                        type="file"
                        name="img"
                        accept="image/*"
                    />
                    <div class="w-64">
                        <div
                            @click="selectFile('logo_image')"
                            class="
                                select-none
                                hover:bg-indigo-50
                                text-indigo-700
                                w-32
                                border
                                rounded
                                border-indigo-600
                                px-3
                                py-1
                            "
                        >
                            Select Logo
                        </div>
                    </div>
                </div>
                <div class="flex flex-col md:mt-0 mt-8 ml-12">
                    <label class="mb-3 text-sm leading-none text-gray-800"
                        >Emblem</label
                    >
                    <input
                        class="hidden"
                        id="emblem_image"
                        @change="processFile($event)"
                        type="file"
                        name="img"
                        accept="image/*"
                    />
                    <div class="w-64">
                        <div
                            @click="selectFile('emblem_image')"
                            class="
                                select-none
                                hover:bg-indigo-50
                                w-36
                                border
                                rounded
                                text-indigo-700
                                border-indigo-600
                                px-3
                                py-1
                            "
                        >
                            Select Emblem
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-8 md:flex items-center">
                <div class="grid grid-cols-2">
                    <div class="col-span-1">
                        <div
                            class="
                                w-64
                                h-64
                                bg-gray-50
                                border border-gray-200
                                flex
                                items-center
                                justify-center
                            "
                        >
                            <img class="px-2" :src="images.logo" alt="" />
                        </div>
                    </div>
                    <div class="col-span-1 ml-6">
                        <div
                            class="
                                w-64
                                h-64
                                bg-gray-50
                                border border-gray-200
                                flex
                                items-center
                                justify-center
                            "
                        >
                            <img class="px-2" :src="images.emblem" alt="" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-12 md:flex items-center">
                <div class="flex flex-col w-132">
                    <label class="mb-3 text-sm leading-none text-gray-800"
                        >Featured Video (YouTube)</label
                    >
                    <input
                        v-model="form.feature_video"
                        type="text"
                        tabindex="0"
                        aria-label="Enter featured Youtube Video"
                        class="
                            w-132
                            bg-gray-50
                            text-sm
                            font-medium
                            leading-none
                            text-gray-800
                            p-3
                            border
                            rounded
                            border-gray-200
                        "
                        placeholder="https://youtube.com/watch?v=xyz"
                    />
                </div>
            </div>
        </template>
        <template v-if="step == 3">
            <h1
                tabindex="0"
                role="heading"
                aria-label="profile information"
                class="focus:outline-none text-3xl font-bold text-gray-800 mt-6"
            >
                Social Links
            </h1>
            <div class="mt-8 md:flex items-center">
                <div class="flex flex-col">
                    <label class="mb-3 text-sm leading-none text-gray-800"
                        >Twitter</label
                    >
                    <input
                        v-model="form.socials.twitter"
                        type="text"
                        tabindex="0"
                        aria-label="Enter first name"
                        class="
                            w-64
                            bg-gray-50
                            text-sm
                            font-medium
                            leading-none
                            text-gray-800
                            p-3
                            border
                            rounded
                            border-gray-200
                        "
                        placeholder="twitter.com/ftsoxyz"
                    />
                </div>
                <div class="flex flex-col md:ml-12 md:mt-0 mt-8">
                    <label class="mb-3 text-sm leading-none text-gray-800"
                        >Telegram</label
                    >
                    <input
                        v-model="form.socials.telegram"
                        type="text"
                        tabindex="0"
                        aria-label="Enter email Address"
                        class="
                            w-64
                            bg-gray-50
                            text-sm
                            font-medium
                            leading-none
                            text-gray-800
                            p-3
                            border
                            rounded
                            border-gray-200
                        "
                        placeholder="https://t.me/ftsoxyz"
                    />
                </div>
            </div>
            <div class="mt-12 md:flex items-center">
                <div class="flex flex-col">
                    <label class="mb-3 text-sm leading-none text-gray-800"
                        >YouTube</label
                    >
                    <input
                        v-model="form.socials.youtube"
                        type="text"
                        tabindex="0"
                        aria-label="Enter email Address"
                        class="
                            w-64
                            bg-gray-50
                            text-sm
                            font-medium
                            leading-none
                            text-gray-800
                            p-3
                            border
                            rounded
                            border-gray-200
                        "
                        placeholder="http://youtube.com/channel/ftsoxyz"
                    />
                </div>
                <div class="flex flex-col md:ml-12 md:mt-0 mt-8">
                    <label class="mb-3 text-sm leading-none text-gray-800"
                        >Discord</label
                    >
                    <input
                        v-model="form.socials.discord"
                        type="text"
                        tabindex="0"
                        aria-label="Enter website URL"
                        class="
                            w-64
                            bg-gray-50
                            text-sm
                            font-medium
                            leading-none
                            text-gray-800
                            p-3
                            border
                            rounded
                            border-gray-200
                        "
                        placeholder="https://discord.gg/ftsoxyz"
                    />
                </div>
            </div>
            <div class="mt-12 md:flex items-center">
                <div class="flex flex-col w-132">
                    <label class="mb-3 text-sm leading-none text-gray-800"
                        >Additional Info/Comments</label
                    >
                    <textarea
                        v-model="form.additional_comments"
                        type=""
                        tabindex="0"
                        aria-label="Enter short description"
                        class="
                            w-132
                            h-44
                            bg-gray-50
                            text-sm
                            font-medium
                            leading-none
                            text-gray-800
                            p-3
                            border
                            rounded
                            border-gray-200
                        "
                        placeholder="Anything else you'd like to add which may help speed up the verification of your update."
                    />
                </div>
            </div>
        </template>
        <template v-if="step == 4">
            <h1
                tabindex="0"
                role="heading"
                aria-label="verification"
                class="focus:outline-none text-3xl font-bold text-gray-800 mt-6"
            >
                Review Decision
            </h1>

            <div class="mt-3 grid grid-cols-2">
                <div
                    id="admin"
                    :class="form.status !== 'pending' ? 'opacity-50' : ''"
                >
                    <div class="flex gap-4">
                        <div>
                            <label class="mr-2" for="approve-checkbox-checkbox"
                                >Approve</label
                            >
                            <input
                                :disabled="form.status !== 'pending'"
                                id="approve-checkbox"
                                type="radio"
                                v-model="form.outcome.status"
                                value="approve"
                            />
                        </div>
                        <div>
                            <label class="mr-2" for="reject-checkbox"
                                >Reject</label
                            >
                            <input
                                :disabled="form.status !== 'pending'"
                                id="reject-checkbox"
                                type="radio"
                                v-model="form.outcome.status"
                                value="reject"
                            />
                        </div>
                    </div>
                    <div class="mt-4 font-semibold">Outcome Notes</div>
                    <textarea
                        :disabled="form.status !== 'pending'"
                        v-model="form.outcome.notes"
                        class="w-96"
                    ></textarea>

                    <div
                        v-if="application.type == 'register'"
                        class="flex flex-col mt-8"
                    >
                        <label class="mb-3 text-sm leading-none text-gray-800"
                            >FTSO Code</label
                        >
                        <input
                            :disabled="form.status !== 'pending'"
                            v-model="form.code"
                            type="text"
                            tabindex="0"
                            aria-label="Enter website URL"
                            class="
                                w-64
                                bg-gray-50
                                text-sm
                                font-medium
                                leading-none
                                text-gray-800
                                p-3
                                border
                                rounded
                                border-gray-200
                            "
                            placeholder="FTSOXY"
                        />
                    </div>
                </div>
                <div>
                    <div>
                        <h1 class="font-semibold">Applicant Comments</h1>
                        <p class="pt-2 text-gray-600">
                            {{ form.additional_comments }}
                        </p>
                    </div>
                    <div class="mt-4">
                        <h1 class="font-semibold">Outcome Comments</h1>
                        <p class="pt-2 text-gray-600">
                            <span
                                class="
                                    font-semibold
                                    text-indigo-700
                                    mr-2
                                    capitalize
                                "
                                >{{ form.status }}</span
                            >
                            {{ form.outcome.notes ?? "No notes." }}
                        </p>
                    </div>
                </div>
            </div>
        </template>

        <div v-show="error.show" class="text-red-600">{{ error.message }}</div>

        <!-- Stepper Button -->
        <button
            :disabled="form.status !== 'pending'"
            @click="nextStep()"
            role="button"
            aria-label="Next step"
            class="
                flex
                items-center
                justify-center
                py-4
                px-7
                focus:outline-none
                bg-white
                border
                rounded
                border-gray-400
                mt-2
                md:mt-6
                hover:bg-gray-100
                focus:ring-2 focus:ring-offset-2 focus:ring-gray-700
            "
        >
            <loading-spinner
                v-if="form.processing"
                size="6"
                color="text-indigo-700"
            />
            <span
                v-if="!form.processing"
                class="text-sm font-medium text-center text-gray-800 capitalize"
                >{{ step == 4 ? "Submit" : "Next Step" }}</span
            >
            <svg
                v-if="!form.processing"
                class="mt-1 ml-3"
                width="12"
                height="8"
                viewBox="0 0 12 8"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path d="M8.01 3H0V5H8.01V8L12 4L8.01 0V3Z" fill="#242731" />
            </svg>
        </button>
    </body>
</template>
<script>
import country from "country-list-js";
import LoadingSpinner from "../Ui/LoadingSpinner.vue";
import Input from "../../Jetstream/Input.vue";
export default {
    components: { LoadingSpinner, Input },
    props: ["id", "application"],
    data() {
        return {
            step: 4,
            form: {
                processing: false,

                name: "",
                code: "",
                admin_email: "",
                website_url: "",

                description: "",
                extended_description: "",
                additional_comments: "",
                info: {
                    local: "",
                    country: "",
                    established: "",
                },
                socials: {
                    twitter: "",
                    discord: "",
                    telegram: "",
                    youtube: "",
                },
                emblem: null,
                logo: null,
                feature_video: "",

                ftsos_id: null,
                application_id: null,
                type: "",
                status: "",

                outcome: {
                    status: "approve",
                    notes: "",
                },
            },

            images: {
                logo: "",
                emblem: "",
            },

            error: {
                show: false,
                message: "",
            },
        };
    },
    mounted() {
        console.log("application", this.$props.application);
        let provider = this.$props.application;
        this.form.ftsos_id = provider.ftsos_id;
        this.form.application_id = provider.id;
        this.form.type = provider.type;
        this.form.status = provider.status;
        this.form.name = provider.name;
        this.form.code = provider.code ?? "";
        this.form.admin_email = provider.admin_email;
        this.form.website_url = provider.website_url;

        this.form.description = provider.description;
        this.form.extended_description = provider.extended_description;
        this.form.additional_comments = provider.additional_comments;

        this.form.info = provider.info;
        this.form.socials = provider.socials;
        this.form.feature_video = provider.feature_video;

        this.images.logo = provider.logo;
        this.images.emblem = provider.emblem;

        this.form.outcome.notes = provider.admin_notes;
    },
    methods: {
        submit() {
            this.form.processing = true;

            if (this.form.outcome.status == "reject") {
                return this.reject();
            }
            let formData = new FormData();

            formData.append("logo", this.form.logo ?? this.images.logo);
            formData.append("emblem", this.form.emblem ?? this.images.emblem);
            formData.append("data", JSON.stringify(this.form));
            var routeName;
            if (this.form.type == "update") {
                routeName = "admin.update-from-application";
            }
            if (this.form.type == "register") {
                routeName = "admin.create-from-application";
            }
            axios
                .post(route(routeName), formData, {
                    headers: { "Content-Type": "multipart/form-data" },
                })
                .then((response) => {
                    if (response.data.error) {
                        this.error.show = true;
                        this.error.message = response.data.errors[0];
                        this.form.processing = false;
                        return;
                    }
                    this.form.processing = false;
                    if (this.step == 4) {
                        return this.$inertia.get(route("admin.ftso-manager"));
                    }
                    this.step++;
                })
                .catch((error) => {
                    this.form.processing = false;
                });
        },
        reject() {
            axios
                .post(route("admin.reject-application"), {
                    outcome: this.form.outcome,
                    application_id: this.form.application_id,
                })
                .then((response) => {
                    if (response.data.error) {
                        this.error.show = true;
                        this.error.message = response.data.errors[0];
                        this.form.processing = false;
                        return;
                    }
                    this.form.processing = false;
                    return this.$inertia.get(route("admin.ftso-manager"));
                });
        },
        nextStep() {
            if (this.step == 4) {
                this.submit();
                return;
            }
            this.error.show = false;
            this.step++;
            window.scrollTo(0, 0);
        },
        goToStep(step) {
            this.step = step;
        },
        continents() {
            return country.continents();
        },
        countries() {
            return country.names().sort();
        },
        selectFile(id) {

            document.getElementById(id).click();
        },

        showError(message) {
            this.error.show = true;
            this.error.message = message;
        },

        processFile(event) {
            switch (event.target.id) {
                case "emblem_image":
                    this.form.emblem = event.target.files[0];
                    this.images.emblem = this.displayImage(this.form.emblem);
                    break;
                case "logo_image":
                    this.form.logo = event.target.files[0];
                    this.images.logo = this.displayImage(this.form.logo);

                    break;

                default:
                    break;
            }
        },

        displayImage(file) {
            if (!file) return;
            return URL.createObjectURL(file);
        },
    },
};
</script>

<style scoped>
.checkbox:checked + .check-icon {
    display: flex;
}
</style>
