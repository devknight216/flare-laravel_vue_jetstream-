const config = require("./config.json");
const Web3 = require("web3");
const pairs = require("./pairs.json");
const web3 = new Web3(config.rpc_url);
const axios = require("axios");
return storePrices();
// The minimum ABI to get ERC20 Token balance
function getPairBalances(token, address, decimal) {
    let minABI = [
        // balanceOf
        {
            constant: true,
            inputs: [{ name: "_owner", type: "address" }],
            name: "balanceOf",
            outputs: [{ name: "balance", type: "uint256" }],
            type: "function",
        },
        // decimals
        {
            constant: true,
            inputs: [],
            name: "decimals",
            outputs: [{ name: "", type: `uint8` }],
            type: "function",
        },
    ];
    var token_balance = 0;
    var contract = new web3.eth.Contract(minABI);
    contract.options.address = token;
    return contract.methods
        .balanceOf(address)
        .call()
        .then((result) => {
            token_balance = result;
            return result;
        });
}

async function storePrices() {
    let result = [];
    await Promise.all(
        pairs.data.map(async (pair) => {
            try {
                if (pair.decimalB == 6 && pair.decimalA == 6) {
                    var multiplier = 1;
                } else if (pair.decimalB == 6) {
                    var multiplier = 1;
                } else if (pair.decimalB == 18 && pair.decimalA == 18) {
                    var multiplier = 1;
                } else {
                    var multiplier = 1000000000000; // 6-18
                }

                var tokens = pair.name.split("/");
                var tokenA = getPairBalances(
                    pair.tokenA,
                    pair.address,
                    pair.decimalA
                );
                var tokenB = getPairBalances(
                    pair.tokenB,
                    pair.address,
                    pair.decimalB
                );
                var price = (await tokenB) / (await tokenA) / multiplier;
                result.push({
                    pair: `${tokens[0]}-${tokens[1]}`.toLowerCase(),
                    pair_d: `${pair.decimalA}-${pair.decimalB}`,
                    [tokens[0].toLocaleLowerCase()]: await tokenA,
                    [tokens[1].toLocaleLowerCase()]: await tokenB,
                    price: price.toFixed(12),
                });
                //
            } catch (error) {
                console.log("error" + error);
            }
        })
    );

    axios
        .put(config.app_endpoint + "/api/pair/price", {
            data: result,
        })
        .then((response) => {
            if (!response.data.error) {
                console.log(response.data);
                console.log("Operation Ran!");
                return 1;
            } else {
                console.log("- Operation Error -");
            }
        })
        .catch((error) => {
            console.log(error);
            return 2;
        });
    console.log("eof");
}
