<template>
    <div>
        <div class="m-4 flex">
            <label class="mr-2" for="providers">Choose provider:</label>

            <select
                @change="updateSelectedProvider()"
                v-model="selected_provider"
                name="providers"
            >
                <option v-for="(provider, i) in providers" :key="i" :value="i">
                    {{ provider.name }}
                </option>
            </select>
            <div class="mx-4">
                <img class="h-8" v-if="selected" :src="form.logo" alt="" />
            </div>
        </div>
        <div v-if="selected" id="form">
            <div class="mx-4 py-2 grid grid-cols-12 gap-3">
                <div class="col-span-6">
                    <div class="px-2">Name:</div>
                    <input class="mx-2 h-8" v-model="form.name" type="text" />
                </div>
                <div class="col-span-6">
                    <div class="px-2">Code:</div>
                    <input class="mx-2 h-8" v-model="form.code" type="text" />
                </div>
                <div class="col-span-6">
                    <div class="px-2">Admin Email:</div>
                    <input
                        class="mx-2 h-8"
                        v-model="form.admin_email"
                        type="text"
                    />
                </div>
                <div class="col-span-6">
                    <div class="px-2">Website:</div>
                    <input
                        class="mx-2 h-8"
                        v-model="form.website"
                        type="text"
                    />
                </div>
                <div class="col-span-6">
                    <div class="px-2">Website URL:</div>
                    <input
                        class="mx-2 h-8"
                        v-model="form.website_url"
                        type="text"
                    />
                </div>
                <div class="col-span-6">
                    <div class="px-2">Local:</div>
                    <input
                        class="mx-2 h-8"
                        v-model="form.info.local"
                        type="text"
                    />
                </div>
                <div class="col-span-6">
                    <div class="px-2">Country:</div>
                    <input
                        class="mx-2 h-8"
                        v-model="form.info.country"
                        type="text"
                    />
                </div>
                <div class="col-span-6">
                    <div class="px-2">Established:</div>
                    <input
                        class="mx-2 h-8"
                        v-model="form.info.established"
                        type="text"
                    />
                </div>
                <div class="col-span-12 mr-6">
                    <div class="px-2">Feature Video:</div>
                    <input
                        class="mx-2 h-8 w-full"
                        v-model="form.feature_video"
                        type="text"
                    />
                </div>
                <div class="col-span-6 mr-6">
                    <div class="px-2">Description:</div>
                    <textarea
                        class="mx-2 h-28 w-full"
                        v-model="form.description"
                        type="text"
                    />
                </div>
                <div class="col-span-6 mr-6">
                    <div class="px-2">Extended Description:</div>
                    <textarea
                        class="mx-2 h-28 w-full"
                        v-model="form.extended_description"
                        type="text"
                    />
                </div>

                <div class="col-span-12 mr-6">
                    <div class="px-2">Site Description:</div>
                    <textarea
                        class="mx-2 h-28 w-full"
                        v-model="form.site_description"
                        type="text"
                    />
                </div>

                <div class="col-span-6 mx-3">
                    <div class="px-2">Meta Image:</div>
                    <img
                        v-if="images.meta_image"
                        :src="images.meta_image"
                        alt="Emblem"
                        class="h-24 m-2"
                    />
                    <input
                        id="meta_image"
                        @change="processFile($event)"
                        type="file"
                        name="img"
                        accept="image/*"
                    />
                </div>

                <div class="col-span-6 mx-3">
                    <div class="px-2">Emblem Image:</div>
                    <img
                        v-if="images.emblem"
                        :src="images.emblem"
                        alt="Emblem"
                        class="h-12 m-2"
                    />
                    <input
                        id="emblem_image"
                        @change="processFile($event)"
                        type="file"
                        name="img"
                        accept="image/*"
                    />
                </div>
                <div class="col-span-6 mx-3">
                    <div class="px-2">Logo Image:</div>
                    <img
                        v-if="images.logo"
                        :src="images.logo"
                        alt="Emblem"
                        class="h-12 m-2"
                    />
                    <input
                        id="logo_image"
                        @change="processFile($event)"
                        type="file"
                        name="img"
                        accept="image/*"
                    />
                </div>
            </div>

            <div
                class="
                    mx-4
                    py-2
                    mb-4
                    border-t border-gray-200
                    grid grid-cols-12
                    gap-3
                "
            >
                <div class="col-span-12">Socials</div>
                <div class="col-span-6">
                    <div class="px-2">Twitter:</div>
                    <input
                        class="mx-2 h-8"
                        v-model="form.socials.twitter"
                        type="text"
                    />
                </div>
                <div class="col-span-6">
                    <div class="px-2">Telegram:</div>
                    <input
                        class="mx-2 h-8"
                        v-model="form.socials.telegram"
                        type="text"
                    />
                </div>
                <div class="col-span-6">
                    <div class="px-2">Discord:</div>
                    <input
                        class="mx-2 h-8"
                        v-model="form.socials.discord"
                        type="text"
                    />
                </div>
                <div class="col-span-6">
                    <div class="px-2">Youtube:</div>
                    <input
                        class="mx-2 h-8"
                        v-model="form.socials.youtube"
                        type="text"
                    />
                </div>
                <div class="col-span-6">
                    <div class="px-2">Verified:</div>
                    <input
                        class="mx-2 h-6 w-6"
                        v-model="form.verified"
                        type="checkbox"
                    />
                </div>
            </div>

            <button
                :disabled="form.processing"
                @click="submit()"
                class="
                    float-right
                    bg-indigo-700
                    m-3
                    p-2
                    text-white
                    rounded-md
                    disabled:opacity-50
                "
            >
                Submit
            </button>
            <div class="mx-4">
                <div class="text-green-700 font-semibold" v-if="complete">
                    Submitted.
                </div>
                <div v-for="(error, i) in errors" :key="i" class="text-red-600">
                    - {{ error }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    components: {},
    data() {
        return {
            providers: [],
            selected_provider: null,
            selected: false,
            form: {
                processing: false,

                name: "",
                code: "",
                admin_email: "",
                website: "",
                website_url: "",

                description: "",
                extended_description: "",
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
                verified: "",
                meta_image: null,
                emblem: null,
                logo: null,
                feature_video: "",
                site_description: "",
            },

            images: {
                emblem: null,
                logo: null,
                meta_image: null,
            },

            errors: [],
            complete: false,
        };
    },
    mounted: function () {
        this.getProviders();
    },
    methods: {
        updateSelectedProvider() {
            this.selected = true;
            this.form = this.providers[this.selected_provider];
            this.images.logo = this.providers[this.selected_provider].logo;
            this.images.emblem = this.providers[this.selected_provider].emblem;
            this.images.meta_image =
                this.providers[this.selected_provider].meta_image;

            this.form.emblem_updated = false;
            this.form.logo_updated = false;
            this.form.meta_image_updated = false;
        },
        getProviders() {
            axios
                .get(route("api.ftso.listAll"))
                .then((response) => {
                    this.providers = response.data;
                })
                .catch((error) => {
                    this.form.processing = false;
                });
        },
        submit() {
            this.errors = [];
            this.form.processing = true;
            let formData = new FormData();

            if (this.form.logo_updated) {
                formData.append("logo", this.form.logo);
            }

            if (this.form.emblem_updated) {
                formData.append("emblem", this.form.emblem);
            }

            if (this.form.meta_image_updated) {
                formData.append("meta_image", this.form.meta_image);
            }

            formData.append("data", JSON.stringify(this.form));

            axios
                .post(route("api.ftso.update"), formData, {
                    headers: { "Content-Type": "multipart/form-data" },
                })
                .then((response) => {
                    this.form.processing = false;
                    if (response.data.error) {
                        this.errors = response.data.errors;
                    } else {
                        this.complete = true;
                        this.images.emblem = null;
                        this.images.logo = null;
                        this.images.meta_image = null;
                    }
                })
                .catch((error) => {
                    this.form.processing = false;
                });
        },
        processFile(event) {
            switch (event.target.id) {
                case "meta_image":
                    this.form.meta_image = event.target.files[0];
                    this.images.meta_image = this.displayImage(
                        this.form.meta_image
                    );
                    this.form.meta_image_updated = true;
                    break;
                case "emblem_image":
                    this.form.emblem = event.target.files[0];
                    this.images.emblem = this.displayImage(this.form.emblem);
                    this.form.emblem_updated = true;
                    break;
                case "logo_image":
                    this.form.logo = event.target.files[0];
                    this.images.logo = this.displayImage(this.form.logo);
                    this.form.logo_updated = true;
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
<style scoped></style>
