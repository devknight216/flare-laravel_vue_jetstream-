<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Playground
            </h2>
        </template>

        <!-- <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden rounded-md sm:rounded-lg">
                    <div
                        v-for="(tx, i) in transactions"
                        :key="i"
                        class="m-4 rounded bg-gray-200"
                    >
                        <p><b>block:</b> {{ tx.number }}</p>
                        <p><b>gasLimit:</b> {{ tx.gasLimit }}</p>
                        <p><b>gasused:</b> {{ tx.gasUsed }}</p>
                        <p><b>hash:</b> {{ tx.hash }}</p>
                        <p><b>parent hash:</b> {{ tx.parentHash }}</p>
                        <p><b>receipt hash:</b> {{ tx.receiptsRoot }}</p>
                        <p><b>sha3Uncles:</b> {{ tx.sha3Uncles }}</p>
                        <p><b>state root:</b> {{ tx.stateRoot }}</p>
                        <p><b>tx root:</b> {{ tx.transactionsRoot }}</p>
                        <p>
                            <b>timestamp:</b>
                            {{ new Date(tx.timestamp * 1000) }}
                        </p>
                    </div>
                </div>
            </div>
        </div> -->
        <div>
            <button @click="gen()">Create Account</button>
            <div class="flex">
                <span>Address: </span>
                <p>{{ address }}</p>
            </div>
            <div class="flex">
                <span>Key: </span>
                <p>{{ key }}</p>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
// import _Web3 from "../Pages/Contracts/web3";

export default {
    data() {
        return {
            transactions: [],
            blocks: [],
            address: "",
            key: "",
        };
    },
    mounted: function () {
        // console.log(Web3);
        // var web3 = new Web3(
        //     new Web3.providers.WebsocketProvider(
        //         "wss://coston.ftso.com.au/ext/bc/C/ws"
        //     )
        // );
        // console.log(web3);
        // web3.eth.getBlock(20639).then(console.log);
        // // console.log(web3ws);
        // var subscription = web3.eth
        //     .subscribe("newBlockHeaders", (error, result) => {})
        //     .on("connected", (subscriptionId) => {
        //         console.log(subscriptionId);
        //     })
        //     .on("data", (blockHeader) => {
        //         console.log(blockHeader);
        //         this.transactions.push(blockHeader);
        //         web3.eth
        //             .getTransactionFromBlock(blockHeader.hash, 0)
        //             .then((data) => {
        //                 console.log(data);
        //                 web3.eth
        //                     .getTransactionReceipt(data.hash)
        //                     .then((data) => {
        //                         console.log(data);
        //                     });
        //             });
        //     });
    },
    methods: {
        gen() {
            var web3 = new Web3(
                new Web3.providers.HttpProvider(
                    "https://main-light.eth.linkpool.io/"
                )
            );
            console.log(web3);
            var acc = web3.eth.accounts.create();
            consle.log(acc);
        },
    },
    components: {
        AppLayout,
    },
};
</script>
