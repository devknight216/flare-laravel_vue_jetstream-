console.log("Loading Discord Bot");

const Discord = require("discord.js");
const client = new Discord.Client();
const { prefix, token, tokens, api_endpoint } = require("./config.json");
const axios = require("axios");

client.once("ready", () => {
    console.log("I'm ready to work!");
});

client.login(token);

function getPrice(token) {
    return axios
        .get(api_endpoint + "/pair/price/" + token + "/latest")
        .then(function (response) {
            return response.data.token;
        })
        .catch(function (error) {
            return error;
        });
}

function getChart(token) {
    return axios
        .get(api_endpoint + "/chart/snapshot/" + token)
        .then(function (response) {
            return response.data;
        })
        .catch(function (error) {
            return error;
        });
}

client.on("message", async (message) => {
    if (!message.content.startsWith(prefix) || message.author.bot) return;
    const args = message.content.slice(prefix.length).trim().split(" ");
    const command = args.shift();

    if (command == "price") {
        var ticker = args[0].toLowerCase();
        if (!tokens.includes(ticker)) {
            var string = "";
            tokens.forEach((token) => {
                string = string + `\`${token.toUpperCase()}\` | `;
            });
            message.channel.send(
                ` \`No token with that name, use:\` ${string}`
            );
            return;
        }
        var token = await getPrice(ticker);
        var price = token;
        var high = parseFloat(price.price);
        message.channel.send(
            `**${ticker.toUpperCase()} Price:** ${
                high > 1 ? high.toFixed(2) : high.toFixed(8)
            }`
        );
    }

    if (command == "chart") {
        console.log(tokens);
        if (!message.content.startsWith(prefix) || message.author.bot) return;
        var ticker = args[0].toLowerCase();
        console.log(`${ticker}`);
        if (!tokens.includes(ticker)) {
            var string = "";
            tokens.forEach((token) => {
                string = string + `\`${token.toUpperCase()}\` | `;
            });
            message.channel.send(
                ` \`No token with that name, use:\` ${string}`
            );
            return;
        }

        const chart = await getChart(ticker);
        var price = parseFloat(chart.statistics.price);
        var high = parseFloat(chart.statistics.high);
        var low = parseFloat(chart.statistics.low);
        const chartEmbed = new Discord.MessageEmbed()
            .setColor("#0099ff")
            .setTitle(`${ticker.toUpperCase()} Price`)
            .setURL(`https://flaremetrics.io/charts/${ticker}-xusd`)
            .setAuthor("flaremetrics.io", "", "https://flaremetrics.io/charts")
            .setThumbnail(
                "https://flare-beta.s3-ap-southeast-2.amazonaws.com/logos/avax-light.png"
            )
            .addFields(
                {
                    name: "Price",
                    value: price > 1 ? price.toFixed(2) : price.toFixed(8),
                    inline: true,
                },
                {
                    name: "24h High",
                    value: high > 1 ? high.toFixed(2) : high.toFixed(8),
                    inline: true,
                },
                {
                    name: "24h Low",
                    value: low > 1 ? low.toFixed(2) : low.toFixed(8),
                    inline: true,
                }
                // { name: '24h Tx', value: chart.statistics.transactions, inline: true },
            )
            .setImage(chart.url)
            .setTimestamp()
            .setFooter("Visit fflaremetrics.io/charts for more");
        message.channel.send(chartEmbed);
    }
});
