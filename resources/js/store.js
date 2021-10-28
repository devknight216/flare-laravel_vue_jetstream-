import axios from "axios";

// Implement External Store
export function _store() {
    return {
        state() {
            return {
                theme: "light",
                ftso: {
                    ftsoWhitelistedPriceProviders: [],
                    wNatSupply: 1160450970,
                },

                chainId: 19,
                chainName: "songbird",
                rpc: {
                    19: "https://sgb.ftso.com.au/ext/bc/C/rpc",
                    14: "https://main-light.eth.linkpool.io/",
                },

                token_address: {
                    wflr: "",
                    wsgb: "0x02f0826ef6aD107Cfc861152B32B52fD11BaB9ED",
                    ftsoControl: "0x157D6316475765F13348DfA897C503Af0161B232",
                },

                contract_address: {
                    supply: "0x5059bA6272Fa598efAaCC9b6FCeFef7366980aD7",
                    rewardManager: "0xc5738334b972745067fFa666040fdeADc66Cb925",
                    ftsoManager: "0xbfA12e4E1411B62EdA8B035d71735667422A6A9e",
                },
                network_statistics: {
                    songbird: {},
                    flare: {},
                },

                abi: {
                    RewardManager: require("./Contracts/RewardManager.json"),
                },

                circulating_supply: 0,

                currentRewardEpoch: null,

                data_provider_list: [],
                data_provider_list_last_update: null,
            };
        },
        getters: {
            getTheme: (state) => {
                return state.theme;
            },
            ftsoWhitelistedPriceProviders: (state) => {
                return state.ftso.ftsoWhitelistedPriceProviders;
            },
            getCirculatingSupply: (state) => {
                return state.circulating_supply;
            },
            getWnatSupply: (state) => {
                return state.ftso.wNatSupply;
            },
            getWnatVotingThreshold: (state) => {
                return 0.1 * parseFloat(state.ftso.wNatSupply);
            },
            getFtsoListWithMetrics: (state) => {
                state.data_provider_list.forEach((provider) => {
                    provider.votepower = 0;
                    provider.fee = "N/A";
                    provider.pools.map((pool) => {
                        if (pool.network == state.chainName) {
                            provider.votepower = pool.votepower;
                            provider.fee = pool.fee / 100;
                            if (
                                state.data_provider_list_last_update == null &&
                                pool.updated_at !== null
                            ) {
                                console.log("Set Date", pool.updated_at);
                                state.data_provider_list_last_update = new Date(
                                    pool.updated_at
                                ).toUTCString();
                            }
                        }
                    });
                });
                state.data_provider_list.sort(
                    (a, b) => parseFloat(b.votepower) - parseFloat(a.votepower)
                );
                return state.data_provider_list;
            },
        },
        mutations: {
            setFtsoWhitelistedPriceProviders(state, payload) {
                state.ftso.ftsoWhitelistedPriceProviders = payload;
            },
            setCirculatingSupply(state, payload) {
                state.circulating_supply = payload;
            },
            setNetworkStatistics(state, payload) {
                state.network_statistics.songbird = payload.songbird_statistics;
                state.network_statistics.flare = payload.flare_statistics;
            },
            setWnatSupply(state, payload) {
                state.ftso.wNatSupply = payload;
            },
            setTheme(state, payload) {
                state.theme = payload;
            },
        },
        actions: {
            async getFtsoList(context, payload) {
                axios
                    .get(route("api.ftso.list"), { params: payload })
                    .then(async (response) => {
                        context.state.data_provider_list = response.data;
                    });
            },
            async getFtsoWhitelistedPriceProviders(context) {
                const voterWhitelisterAddress =
                    "0xa76906EfBA6dFAe155FfC4c0eb36cDF0A28ae24D";
                const voterWhitelisterABI = require("./Contracts/VoterWhitelister.json");
                const wNatContract = new ethers.Contract(
                    voterWhitelisterAddress,
                    voterWhitelisterABI,
                    provider
                );
                const symbols = [""];
                try {
                    var delegatesOf = await wNatContract.delegatesOf(
                        context.state.web3.account
                    );

                    var providers = delegatesOf[0];
                    var bips = delegatesOf[1];

                    var payload = [];

                    for (var i in providers) {
                        payload.push({
                            address: providers[i],
                            bips: bips[i].toNumber(),
                        });
                    }

                    context.commit("setWeb3Delegations", payload);
                } catch (error) {
                    console.log("delegatesOf Error", error);
                }

                var payload = [{ hello: "world" }];
                context.commit("setFtsoWhitelistedPriceProviders", payload);
            },

            async requestWnatSupply(context) {
                const wNatAbi = require("./Contracts/wNat.json");
                var wNatAddress = "";
                if (context.state.chainId == 19) {
                    wNatAddress = context.state.token_address.wsgb;
                }
                if (context.state.chainId == 14) {
                    wNatAddress = context.state.token_address.wflr;
                }
                const wNatContract = new ethers.Contract(
                    wNatAddress,
                    wNatAbi,
                    provider
                );
                var supply = 0;
                try {
                    var response = await wNatContract.totalSupply();
                    supply = ethers.utils.formatUnits(response, 18);
                } catch (error) {
                    console.log("wNatContract.Supply Error", error);
                    return (supply = 0);
                }
                context.commit("setWnatSupply", supply);

                return supply;
            },
            async requestVotePowerOf(context, address) {
                const wNatAbi = require("./Contracts/wNat.json");
                var wNatAddress = "";
                if (context.state.chainId == 19) {
                    wNatAddress = context.state.token_address.wsgb;
                }
                if (context.state.chainId == 14) {
                    wNatAddress = context.state.token_address.wflr;
                }
                const wNatContract = new ethers.Contract(
                    wNatAddress,
                    wNatAbi,
                    provider
                );
                var votepower = 0;
                try {
                    var response = await wNatContract.votePowerOf(address);
                    votepower = ethers.utils.formatUnits(response, 18);
                } catch (error) {
                    console.log("wNatContract Error", error);
                    return (votepower = 0);
                }
                return votepower;
            },
            async requestVotePowerBatch(context, addresses) {
                const wNatAbi = require("./Contracts/wNat.json");
                var wNatAddress = "";
                if (context.state.chainId == 19) {
                    wNatAddress = context.state.token_address.wsgb;
                }
                if (context.state.chainId == 14) {
                    wNatAddress = context.state.token_address.wflr;
                }
                const wNatContract = new ethers.Contract(
                    wNatAddress,
                    wNatAbi,
                    provider
                );
                var block = await provider.getBlockNumber();

                var votepower = 0;
                try {
                    var response = await wNatContract.batchVotePowerOfAt(
                        addresses,
                        block - 1
                    );
                    // votepower = ethers.utils.formatUnits(response, 18);
                } catch (error) {
                    console.log("wNatContract Error", error);
                    return (votepower = 0);
                }
                var map = [];
                for (var i in addresses) {
                    // map.push(ethers.utils.formatUnits(response[i], 18));
                    map.push({
                        address: addresses[i],
                        value: ethers.utils.formatUnits(response[i], 18),
                    });
                }
                return map;
            },
            async requestCirulatingSupply(context) {
                const contractAbi = require("./Contracts/Supply.json");
                var contractAddress = context.state.contract_address.supply;
                const contract = new ethers.Contract(
                    contractAddress,
                    contractAbi,
                    provider
                );
                var supply = 0;
                try {
                    var block = await provider.getBlockNumber();

                    var response = await contract.getCirculatingSupplyAt(block);
                    supply = ethers.utils.formatUnits(response, 18);
                } catch (error) {
                    console.log("SupplyContract Error", error);
                    return (supply = 0);
                }
                context.commit("setCirculatingSupply", supply);
                return supply;
            },
            async requestFoundationSupply(context) {
                const contractAbi = require("./Contracts/Supply.json");
                var contractAddress = context.state.contract_address.supply;
                const contract = new ethers.Contract(
                    contractAddress,
                    contractAbi,
                    provider
                );
                var supply = 0;
                try {
                    var response = await contract.totalFoundationSupplyWei();
                    supply = ethers.utils.formatUnits(response, 18);
                } catch (error) {
                    console.log("SupplyContract Error", error);
                    return (supply = 0);
                }
                return supply;
            },
            async requestInflationAuthorized(context) {
                const contractAbi = require("./Contracts/Supply.json");
                var contractAddress = context.state.contract_address.supply;

                const contract = new ethers.Contract(
                    contractAddress,
                    contractAbi,
                    provider
                );
                var supply = 0;
                try {
                    var response = await contract.totalInflationAuthorizedWei();
                    supply = ethers.utils.formatUnits(response, 18);
                } catch (error) {
                    console.log("SupplyContract Error", error);
                    return (supply = 0);
                }
                return supply;
            },
            async requestInflatableBalance(context) {
                const contractAbi = require("./Contracts/Supply.json");
                var contractAddress = context.state.contract_address.supply;

                const contract = new ethers.Contract(
                    contractAddress,
                    contractAbi,
                    provider
                );
                var supply = 0;
                try {
                    var response = await contract.getInflatableBalance();
                    supply = ethers.utils.formatUnits(response, 18);
                } catch (error) {
                    console.log("SupplyContract Error", error);
                    return (supply = 0);
                }
                return supply;
            },
            async requestEpochId(context) {
                const contractAbi = require("./Contracts/Ftso.json");
                var contractAddress = context.state.token_address.ftsoControl;

                const contract = new ethers.Contract(
                    contractAddress,
                    contractAbi,
                    provider
                );
                var epochId = 0;
                try {
                    var response = await contract.getPriceEpochData();
                    epochId = response[0].toNumber();
                } catch (error) {
                    console.log("SupplyContract Error", error);
                    return (supply = 0);
                }
                return epochId;
            },
            async requestRewardData(context) {
                const contractAbi = require("./Contracts/RewardManager.json");
                var contractAddress =
                    context.state.contract_address.rewardManager;

                const contract = new ethers.Contract(
                    contractAddress,
                    contractAbi,
                    provider
                );
                var payload;
                try {
                    var totalAwardedWei = await contract.totalAwardedWei();
                    var totalClaimedWei = await contract.totalClaimedWei();
                    var totalExpiredWei = await contract.totalExpiredWei();
                    payload = {
                        totalAwarded: ethers.utils.formatUnits(
                            totalAwardedWei,
                            18
                        ),
                        totalClaimed: ethers.utils.formatUnits(
                            totalClaimedWei,
                            18
                        ),
                        totalExpired: ethers.utils.formatUnits(
                            totalExpiredWei,
                            18
                        ),
                    };
                } catch (error) {
                    console.log("SupplyContract Error", error);
                    return (supply = 0);
                }
                return payload;
            },
            async requestRewardEpochsData(context) {
                if (context.state.currentRewardEpoch == null) {
                    return console.log("Missing current reward epoch.");
                }
                var payload = {
                    abi: require("./Contracts/FtsoManager.json"),
                    address: context.state.contract_address.ftsoManager,
                    method: "rewardEpochs",
                    args: context.state.currentRewardEpoch,
                };
                return context.dispatch("contractCall", payload);
            },
            async requestCurrentRewardEpoch(context) {
                var payload = {
                    abi: require("./Contracts/FtsoManager.json"),
                    address: context.state.contract_address.ftsoManager,
                    method: "getCurrentRewardEpoch",
                    args: null,
                };
                return context.dispatch("contractCall", payload);
            },
            async requestNetworkStatistics(context) {
                return axios
                    .get(route("api.network.statistics"))
                    .then((response) => {
                        context.commit("setNetworkStatistics", response.data);
                        return response.data;
                    })
                    .catch((err) => {
                        console.log("Error getting network statistics", err);
                    });
            },
            async contractCall(context, payload) {
                const contract = new ethers.Contract(
                    payload.address,
                    payload.abi,
                    provider
                );
                var result;
                try {
                    if (payload.args) {
                        var result = await contract[payload.method](
                            payload.args
                        );
                    } else {
                        result = contract[payload.method]();
                    }
                } catch (error) {
                    console.log(payload.method, "Error", error);
                }
                return result;
            },
            async requestFtsoPrice(context, address) {
                const contractAbi = require("./Contracts/Ftso.json");
                var contractAddress = address;
                const contract = new ethers.Contract(
                    contractAddress,
                    contractAbi,
                    provider
                );
                var price = 0;
                try {
                    var price = await contract.getCurrentPrice();
                } catch (error) {
                    console.log("SupplyContract Error", error);
                    return (price = 0);
                }
                return parseInt(price) / 100000;
            },
        },
    };
}
