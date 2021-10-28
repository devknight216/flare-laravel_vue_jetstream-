const config = require("./config.json");
const Web3 = require("web3");
const pairs = require("./pairs.json");
const web3 = new Web3(config.rpc_url);
const axios = require("axios");

axios
    .get(config.app_endpoint + "/api/pair/price", {
        params: {
            pair: "yfin-xusd",
            start_time: 0,
        },
    })
    .then((response) => {
        console.log(response);
    })
    .catch((error) => {
        console.log(error);
    });
