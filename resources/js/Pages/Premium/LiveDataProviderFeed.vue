<template>
    <div>
        <app-layout>
            <template>
                <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                    Bridge Wins
                </h1>
            </template>

            <div class="py-2 md:py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="chart-container relative h-96 w-full">
                        <canvas id="ftsochart"></canvas>
                    </div>
                </div>
            </div>
        </app-layout>
    </div>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Chart from "chart.js/auto";

export default {
    components: {
        AppLayout,
    },
    data: () => {
        return {
            submitters: [
                {
                    chainId: 19,
                    name: "Bifrost Oracle",
                    description:
                        "Bifrost Oracle is a reliable Songbird oracle service run by Towo Labs, a Songbird Network development partner and the company behind Bifrost Wallet.",
                    url: "https://bifrostoracle.com",
                    address: "0x69141e890f3a79cd2cff552c0b71508be23712dc",
                    logoURI:
                        "https://raw.githubusercontent.com/TowoLabs/ftso-signal-providers/master/assets/0x69141e890f3a79cd2cff552c0b71508be23712dc.png",
                },
                {
                    chainId: 14,
                    name: "Bifrost Oracle",
                    description:
                        "Bifrost Oracle is a reliable Flare oracle service run by Towo Labs, a Flare Network development partner and the company behind Bifrost Wallet.",
                    url: "https://bifrostoracle.com",
                    address: "0x9a46864a3b0a7805b266c445289c3fad1e48f18e",
                    logoURI:
                        "https://raw.githubusercontent.com/TowoLabs/ftso-signal-providers/master/assets/0x9a46864a3b0a7805b266c445289c3fad1e48f18e.png",
                },
                {
                    chainId: 19,
                    name: "ScandiNodes FTSO",
                    description:
                        "We are proud to be part of Flare Networks. We have a responsibility and take our role as a signal provider very serious. We do not only provide data estimates. We provide good estimates, for maximum returns.",
                    url: "https://ftso.scandinodes.com",
                    address: "0x4ed9e5b82ce66311ac2230d2fccc5202d7b8c083",
                    logoURI:
                        "https://raw.githubusercontent.com/TowoLabs/ftso-signal-providers/master/assets/0x4ed9e5b82ce66311ac2230d2fccc5202d7b8c083.png",
                },
                {
                    chainId: 14,
                    name: "ScandiNodes FTSO",
                    description:
                        "We are proud to be part of Flare Networks. We have a responsibility and take our role as a signal provider very serious. We do not only provide data estimates. We provide good estimates, for maximum returns.",
                    url: "https://ftso.scandinodes.com",
                    address: "0x4ed9e5b82ce66311ac2230d2fccc5202d7b8c083",
                    logoURI:
                        "https://raw.githubusercontent.com/TowoLabs/ftso-signal-providers/master/assets/0x4ed9e5b82ce66311ac2230d2fccc5202d7b8c083.png",
                },
                {
                    chainId: 19,
                    name: "Aureus Ox",
                    description:
                        "Aureus Ox is building a scalable and reliable FTSO signal provider. Our initial goals include accurate price submission and delegation tools.",
                    url: "https://aureusox.com",
                    address: "0x6d323e71e141ce2d7b752313c8a654a9c9d1b377",
                    logoURI:
                        "https://raw.githubusercontent.com/TowoLabs/ftso-signal-providers/master/assets/0x6d323e71e141ce2d7b752313c8a654a9c9d1b377.png",
                },
                {
                    chainId: 14,
                    name: "Aureus Ox",
                    description:
                        "Aureus Ox is building a scalable and reliable FTSO signal provider. Our initial goals include accurate price submission and delegation tools.",
                    url: "https://aureusox.com",
                    address: "0x9269fb79b098ab314de8a1e2afb8705678520443",
                    logoURI:
                        "https://raw.githubusercontent.com/TowoLabs/ftso-signal-providers/master/assets/0x9269fb79b098ab314de8a1e2afb8705678520443.png",
                },
                {
                    chainId: 19,
                    name: "AlphaOracle",
                    description:
                        "AlphaOracle is a US based Signal Provider to the Flare Network. Our goal is to provide reliable data to support applications and expand the ecosystem.",
                    url: "https://www.alphaoracle.io",
                    address: "0xbf61db1cdb43d196309824473fa82e5b17581159",
                    logoURI:
                        "https://raw.githubusercontent.com/TowoLabs/ftso-signal-providers/master/assets/0xbf61db1cdb43d196309824473fa82e5b17581159.png",
                },
                {
                    chainId: 14,
                    name: "AlphaOracle",
                    description:
                        "AlphaOracle is a US based Signal Provider to the Flare Network. Our goal is to provide reliable data to support applications and expand the ecosystem.",
                    url: "https://www.alphaoracle.io",
                    address: "0x47b6effe71abd4e8cdcc56f2341beb404f804b87",
                    logoURI:
                        "https://raw.githubusercontent.com/TowoLabs/ftso-signal-providers/master/assets/0x47b6effe71abd4e8cdcc56f2341beb404f804b87.png",
                },
                {
                    chainId: 19,
                    name: "FTSO EU",
                    description:
                        "Ftso.eu is one of the oldest signal providers building on Flare, with a strong community and presence. Our signals are weighted, dynamic, resilient, processed with an innovative approach on a distributed P2P network to guarantee their accuracy.",
                    url: "https://www.ftso.eu",
                    address: "0x010a16c53f33e4d93892f00897965578b55a8cfc",
                    logoURI:
                        "https://raw.githubusercontent.com/TowoLabs/ftso-signal-providers/master/assets/0x010a16c53f33e4d93892f00897965578b55a8cfc.png",
                },
                {
                    chainId: 14,
                    name: "FTSO EU",
                    description:
                        "Ftso.eu is one of the oldest signal providers building on Flare, with a strong community and presence. Our signals are weighted, dynamic, resilient and processed with an innovative approach on a distributed P2P network to guarantee their accuracy.",
                    url: "https://www.ftso.eu",
                    address: "0xb0421af2cffb21d8a0be4087448146e4f9cbd306",
                    logoURI:
                        "https://raw.githubusercontent.com/TowoLabs/ftso-signal-providers/master/assets/0xb0421af2cffb21d8a0be4087448146e4f9cbd306.png",
                },
                {
                    chainId: 19,
                    name: "FTSO UK",
                    description:
                        "Signal provider on the Flare Network. UK-based team with global coverage. Providing robust and weighted signals. Dedicated to unlocking value.",
                    url: "https://www.ftso.uk",
                    address: "0xb9b7355f5b71cee345311921d247b1d2ba5cfe90",
                    logoURI:
                        "https://raw.githubusercontent.com/TowoLabs/ftso-signal-providers/master/assets/0xb9b7355f5b71cee345311921d247b1d2ba5cfe90.png",
                },
                {
                    chainId: 14,
                    name: "FTSO UK",
                    description:
                        "Signal provider on the Flare Network. UK-based team with global coverage. Providing robust and weighted signals. Dedicated to unlocking value.",
                    url: "https://www.ftso.uk",
                    address: "0x5f911c2c681f678e5a3a8d54f950d6b192cc16e3",
                    logoURI:
                        "https://raw.githubusercontent.com/TowoLabs/ftso-signal-providers/master/assets/0x5f911c2c681f678e5a3a8d54f950d6b192cc16e3.png",
                },
                {
                    chainId: 19,
                    name: "FTSO AU",
                    description:
                        "FTSO AU provide accurate and reliable price feeds to the Flare Network and a transparent, incentivised, risk-free delegation service. We do so by leveraging the distributed nature of the network and its participants.",
                    url: "https://www.ftso.com.au",
                    address: "0x499017adb21d6f70480e4e6224cf4144071c1461",
                    logoURI:
                        "https://raw.githubusercontent.com/TowoLabs/ftso-signal-providers/master/assets/0x499017adb21d6f70480e4e6224cf4144071c1461.png",
                },
                {
                    chainId: 14,
                    name: "FTSO AU",
                    description:
                        "FTSO AU provide accurate and reliable price feeds to the Flare Network and a transparent, incentivised, risk-free delegation service. We do so by leveraging the distributed nature of the network and its participants.",
                    url: "https://www.ftso.com.au",
                    address: "0x4990320858ae3528b645c60059281a66c3488888",
                    logoURI:
                        "https://raw.githubusercontent.com/TowoLabs/ftso-signal-providers/master/assets/0x4990320858ae3528b645c60059281a66c3488888.png",
                },
                {
                    chainId: 19,
                    name: "Use Your Spark",
                    description:
                        "Global Signal Provider for the Flare Time Series Oracle (FTSO), offering vote delegation services to Songbird (SGB) token holders. Start earning risk-free rewards today!",
                    url: "https://www.useyourspark.com",
                    address: "0x53caedda4339ed74272ecfef85b657def18fa2e4",
                    logoURI:
                        "https://raw.githubusercontent.com/TowoLabs/ftso-signal-providers/master/assets/0x53caedda4339ed74272ecfef85b657def18fa2e4.png",
                },
                {
                    chainId: 14,
                    name: "Use Your Spark",
                    description:
                        "Global Signal Provider for the Flare Time Series Oracle (FTSO), offering vote delegation services to Spark (FLR) token holders. Start earning risk-free rewards today!",
                    url: "https://www.useyourspark.com",
                    address: "0xa288054b230dcbb8689ac229d6dbd7df39203181",
                    logoURI:
                        "https://raw.githubusercontent.com/TowoLabs/ftso-signal-providers/master/assets/0xa288054b230dcbb8689ac229d6dbd7df39203181.png",
                },
                {
                    chainId: 19,
                    name: "Sun-Dara",
                    description:
                        "Sun-Dara is an Asian STSO provider based primarily in Bangladesh with connections to the United Kingdom. We try and keep things simple and easy to understand. Check out our website for more information and service status updates.",
                    url: "https://sun-dara.co.uk",
                    address: "0x7394923453fc2f606cfb4d0ea1a5438bb8260d08",
                    logoURI:
                        "https://raw.githubusercontent.com/TowoLabs/ftso-signal-providers/master/assets/0x7394923453fc2f606cfb4d0ea1a5438bb8260d08.png",
                },
                {
                    chainId: 14,
                    name: "Sun-Dara",
                    description:
                        "Sun-Dara is an Asian FTSO provider based primarily in Bangladesh with connections to the United Kingdom. We try and keep things simple and easy to understand. Check out our website for more information and service status updates.",
                    url: "https://sun-dara.co.uk",
                    address: "0x1e8f916ce03f4ce86186531a8994d366581ed4be",
                    logoURI:
                        "https://raw.githubusercontent.com/TowoLabs/ftso-signal-providers/master/assets/0x1e8f916ce03f4ce86186531a8994d366581ed4be.png",
                },
                {
                    chainId: 19,
                    name: "Interoracle",
                    description:
                        "An interchain oracle built by whirledlabs. Price ranked by liquidity.",
                    url: "https://interoracle.io",
                    address: "0x62d6116d6a139f2d402e8d8e30baaf5790542801",
                    logoURI:
                        "https://raw.githubusercontent.com/TowoLabs/ftso-signal-providers/master/assets/0x62d6116d6a139f2d402e8d8e30baaf5790542801.png",
                },
                {
                    chainId: 14,
                    name: "Interoracle",
                    description:
                        "An interchain oracle built by whirledlabs. Price ranked by liquidity.",
                    url: "https://interoracle.io",
                    address: "0x62d6116d6a139f2d402e8d8e30baaf5790542801",
                    logoURI:
                        "https://raw.githubusercontent.com/TowoLabs/ftso-signal-providers/master/assets/0x62d6116d6a139f2d402e8d8e30baaf5790542801.png",
                },
                {
                    chainId: 19,
                    name: "Lena Instruments",
                    description:
                        "Institutional grade vote delegation service and FTSO signal provider to the Songbird ecosystem",
                    url: "https://www.lena.tech",
                    address: "0xc9ac8f034d295962a6a975b717b691437605bbb6",
                    logoURI:
                        "https://raw.githubusercontent.com/TowoLabs/ftso-signal-providers/master/assets/0xc9ac8f034d295962a6a975b717b691437605bbb6.png",
                },
                {
                    chainId: 14,
                    name: "Lena Instruments",
                    description:
                        "Institutional grade vote delegation service and FTSO signal provider to the Flare ecosystem",
                    url: "https://www.lena.tech",
                    address: "0xc9ac8f034d295962a6a975b717b691437605bbb6",
                    logoURI:
                        "https://raw.githubusercontent.com/TowoLabs/ftso-signal-providers/master/assets/0xc9ac8f034d295962a6a975b717b691437605bbb6.png",
                },
                {
                    chainId: 19,
                    name: "A-FTSO",
                    description:
                        "The first indie FTSO provider, run as a professional one. No frills, low fees.",
                    url: "https://ftso.alexdupre.com",
                    address: "0x2d7bf53ed6117ad1dcd6416d460481522a16afdf",
                    logoURI:
                        "https://raw.githubusercontent.com/TowoLabs/ftso-signal-providers/master/assets/0x2d7bf53ed6117ad1dcd6416d460481522a16afdf.png",
                },
                {
                    chainId: 14,
                    name: "A-FTSO",
                    description:
                        "The first indie FTSO provider, run as a professional one. No frills, low fees.",
                    url: "https://ftso.alexdupre.com",
                    address: "0x2d7bf53ed6117ad1dcd6416d460481522a16afdf",
                    logoURI:
                        "https://raw.githubusercontent.com/TowoLabs/ftso-signal-providers/master/assets/0x2d7bf53ed6117ad1dcd6416d460481522a16afdf.png",
                },
                {
                    chainId: 19,
                    name: "Best FTSO",
                    description:
                        "Our goal is to offer users the most value for their delegation. Come check out our NFT club and earn more than just SGB rewards!",
                    url: "https://bestftso.xyz/",
                    address: "0x939789ed3d07a80da886a3e3017d665cbb5591dc",
                    logoURI:
                        "https://raw.githubusercontent.com/TowoLabs/ftso-signal-providers/master/assets/0x939789ed3d07a80da886a3e3017d665cbb5591dc.png",
                },
                {
                    chainId: 14,
                    name: "Best FTSO",
                    description:
                        "Our goal is to offer users the most value for their delegation. Come check out our NFT club and earn more than just FLR rewards!",
                    url: "https://bestftso.xyz/",
                    address: "0x939789ed3d07a80da886a3e3017d665cbb5591dc",
                    logoURI:
                        "https://raw.githubusercontent.com/TowoLabs/ftso-signal-providers/master/assets/0x939789ed3d07a80da886a3e3017d665cbb5591dc.png",
                },
                {
                    chainId: 19,
                    name: "Defi Oracles",
                    description:
                        "DeFi Oracles is a Multi-Chain Decentralized Finance Oracle Service Provider.",
                    url: "https://defioracles.org",
                    address: "0xca60cd408a5e447897258cdb1f699478c71cc55e",
                    logoURI:
                        "https://raw.githubusercontent.com/TowoLabs/ftso-signal-providers/master/assets/0xca60cd408a5e447897258cdb1f699478c71cc55e.png",
                },
                {
                    chainId: 14,
                    name: "Defi Oracles",
                    description:
                        "DeFi Oracles is a Multi-Chain Decentralized Finance Oracle Service Provider.",
                    url: "https://defioracles.org",
                    address: "0xca60cd408a5e447897258cdb1f699478c71cc55e",
                    logoURI:
                        "https://raw.githubusercontent.com/TowoLabs/ftso-signal-providers/master/assets/0xca60cd408a5e447897258cdb1f699478c71cc55e.png",
                },
                {
                    chainId: 19,
                    name: "KysenPool",
                    description:
                        "Global Proof-of-Stake Validator experienced operating nodes for Cardano, Cosmos, Terra , Harmony, Kava and Desmos. Now FTSO for Flare/Songbird.",
                    url: "https://www.kysenpool.io/",
                    address: "0xb53d69b2519ac9f6d65cff8e7824bf09f7064d61",
                    logoURI:
                        "https://raw.githubusercontent.com/TowoLabs/ftso-signal-providers/master/assets/0xb53d69b2519ac9f6d65cff8e7824bf09f7064d61.png",
                },
                {
                    chainId: 14,
                    name: "KysenPool",
                    description:
                        "Global Proof-of-Stake Validator experienced operating nodes for Cardano, Cosmos, Terra , Harmony, Kava and Desmos. Now FTSO for Flare/Songbird.",
                    url: "https://www.kysenpool.io/",
                    address: "0xb53d69b2519ac9f6d65cff8e7824bf09f7064d61",
                    logoURI:
                        "https://raw.githubusercontent.com/TowoLabs/ftso-signal-providers/master/assets/0xb53d69b2519ac9f6d65cff8e7824bf09f7064d61.png",
                },
                {
                    chainId: 19,
                    name: "Optakt",
                    description:
                        "Optakt is a tactical engineering team working on projects which reshape the landscape of blockchain technology.",
                    url: "https://www.optakt.io",
                    address: "0xddef7e54a9f72d9fc0a281b42f15a22b30681da5",
                    logoURI:
                        "https://raw.githubusercontent.com/TowoLabs/ftso-signal-providers/master/assets/0xddef7e54a9f72d9fc0a281b42f15a22b30681da5.png",
                },
                {
                    chainId: 19,
                    name: "AFOracle",
                    description:
                        "AFOracle is an FTSO provider from AFLabs, a team that helped build the Flare's smart contract infrastructure.",
                    url: "https://aforacle.com/",
                    address: "0x9565d813a3a0cea62b3bdb9a4e236dcb5910c4f0",
                    logoURI:
                        "https://raw.githubusercontent.com/TowoLabs/ftso-signal-providers/master/assets/0x9565d813a3a0cea62b3bdb9a4e236dcb5910c4f0.png",
                },
            ],
            providers: null,
            chart: null,
            chartData: [
                {
                    x: "68888",
                    y: "1633009573",
                    epoch: "68888",
                    label: "Name",
                },
            ],
            chartLabels: ["1633009573"],
        };
    },
    mounted: function () {
        this.providers = new Map();
        this.submitters.map((submitter) => {
            if (submitter.chainId != 19) return;
            this.providers.set(submitter.address, submitter.name);
        });
        this.initChart();
        console.log(this.chart);
        setTimeout(() => {
            console.log("add data");
            this.addData({
                x: this.randomNumber(68000, 69000),
                y: `163300${this.randomNumber(1111, 9999)}`,
                epoch: `6888${this.randomNumber(1, 9)}`,
                label: "Name",
            });
        }, 3000);
        //   this.intiliseFeed();
    },

    methods: {
        randomNumber(min, max) {
            return Math.random() * (max - min) + min;
        },
        addData(label, data) {
            this.chartLabels.push(label);
            this.chartData.push(data);
            this.chart.update();
        },

        initChart() {
            var ctx = document.getElementById("ftsochart").getContext("2d");
            this.chart = new Chart(ctx, {
                type: "line",
                data: {
                    // labels: this.chartLabels,
                    datasets: [
                        {
                            label: "Submission",
                            data: this.chartData,
                            parsing: {
                                yAxisKey: "y",
                            },
                            backgroundColor: ["#4F46E5"],
                            borderColor: ["#818CF8"],
                            borderWidth: 1,
                        },
                        // {
                        //     label: "Rewards",
                        //     data: this.chartData,
                        //     parsing: {
                        //         yAxisKey: "rewards",
                        //     },
                        //     display: false,
                        //     backgroundColor: ["#4F46E5"],
                        //     borderColor: ["#818CF8"],
                        //     borderWidth: 1,
                        // },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                        x: {
                            ticks: {
                                maxTicksLimit: 6,
                                stepSize: 6,
                                maxRotation: 0,
                                align: "start",
                                display: !isMobile,
                            },
                            grid: {
                                display: false,
                            },
                        },
                    },
                    plugins: {
                        tooltip: {
                            intersect: false,
                            callbacks: {
                                label: (context) => {
                                    var label = context.dataset.label;
                                    var subValue2 = context.raw.y;
                                    return `${label} at ${subValue2}`;
                                },
                            },
                        },
                        legend: {
                            display: false,
                        },
                    },
                },
            });
        },
        async intiliseFeed() {
            console.log("setting up feed");
            const contractAbi = require("../../Contracts/PriceSubmitter.json");
            const contractAddress =
                "0x1000000000000000000000000000000000000003";
            const contract = new ethers.Contract(
                contractAddress,
                contractAbi,
                provider
            );
            contract.on(
                "PriceHashesSubmitted",
                (address, epochId, ftsos, hashes, timestamp) => {
                    //   console.log(address, epochId, ftsos, hashes, timestamp);
                    //   console.log(address, "addres");
                    var submitter = this.providers.has(address)
                        ? this.providers.get(address)
                        : `Unknown-${address[1]}${address[2]}${address[3]}`;
                    //   console.log(
                    //       `[Epoch #${epochId}] Submitter [${submitter}], at ${timestamp}`
                    //   );
                    epochId = parseInt(epochId);

                    var point = {
                        x: epochId,
                        y: parseInt(timestamp),
                        epoch: epochId,
                        label: submitter,
                    };
                    console.log("adding...", point);
                    this.addData(timestamp, point);
                    //   this.submissions[epochId].push({
                    //       submitter,
                    //       timestamp: parseInt(timestamp),
                    //       ftsos: hashes.length,
                    //   });
                }
            );
        },
    },
};
</script>
