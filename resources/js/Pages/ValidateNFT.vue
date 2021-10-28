<template>
    <app-layout :hide_bg="true">
        <h1>Samurai</h1>
        <div v-for="(item, index) in samurai" :key="index">
            <h2>{{ item.name }}</h2>
            <div>
                <b>Creator Address: </b> {{ item.data.creator.address ?? "" }}
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
export default {
    components: {
        AppLayout,
    },

    data() {
        return {
            samurai: [
                {
                    name: "UR Samurai",
                    token_id: "122182",
                    contract: "0xd07dc4262bcdbf85190c01c996b4c06a461d2430",
                    data: {
                        creator: {
                            address: "",
                        },
                    },
                },

                {
                    name: "SR Samurai",
                    token_id: "122184",
                    contract: "0xd07dc4262bcdbf85190c01c996b4c06a461d2430",
                    data: {
                        creator: {
                            address: "",
                        },
                    },
                },

                {
                    name: "R Samurai",
                    token_id: "122185",
                    contract: "0xd07dc4262bcdbf85190c01c996b4c06a461d2430",
                    data: {
                        creator: {
                            address: "",
                        },
                    },
                },
            ],
        };
    },
    mounted: function () {
        this.test();
    },
    methods: {
        async test() {
            this.samurai.forEach(async (item, index) => {
                await this.wait(parseInt(`${index}000`));
                axios
                    .get(
                        `https://api.opensea.io/api/v1/asset/${item.contract}/${item.token_id}/`
                    )
                    .then((response) => {
                        item.data = response.data;
                        console.log(response.data);
                    });
            });
        },
        async wait(ms) {
            return new Promise((resolve) => {
                setTimeout(resolve, ms);
            });
        },
    },
};
</script>
<style scoped>
.list-height {
    max-height: 650px;
}
</style>
