console.log("Loading Mod Tools Discord Bot");

const Discord = require("discord.js");
const client = new Discord.Client();
const { prefix, token, tokens } = require("./config.json");
const mod_commands = require("./mod_commands.json");

const axios = require("axios");

client.once("ready", () => {
    console.log("I'm ready to work!");
});

client.login(token);

function getPrice(token) {
    return axios
        .get(api_endpoint + "/pair/price/" + token + "/latest")
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

    if (command == "ping") {
        message.channel.send(`pong`);
    }

    if (command == "commands") {
        var chat_moderation = [];
        var tip_help = [];
        var modifiers = [];

        for (const [key, value] of Object.entries(mod_commands)) {
            console.log(`${key}: ${value}`);
            switch (key) {
                case "chat_moderation":
                    value.items.forEach((valueItem) => {
                        chat_moderation.push({
                            name: valueItem.command,
                            value: valueItem.description,
                        });
                    });
                    break;

                case "tip_help":
                    value.items.forEach((valueItem) => {
                        tip_help.push({
                            name: valueItem.command,
                            value: valueItem.description,
                        });
                    });
                    break;

                case "modifiers":
                    value.items.forEach((valueItem) => {
                        modifiers.push({
                            name: valueItem.command,
                            value: valueItem.description,
                        });
                    });
                    break;

                default:
                    break;
            }
        }

        const exampleEmbed = new Discord.MessageEmbed()
            .setColor("#0099ff")
            .setTitle("Moderation Commands")
            .addField("Chat Moderation", "-------------------")
            .addFields(chat_moderation)
            .addField("\u200B", "\u200B")
            .addField("Tip Help", "-------------------")
            .addFields(tip_help)
            .addField("\u200B", "\u200B")
            .addField("Modifiers", "-------------------")
            .addFields(modifiers)
            .addField("\u200B", "\u200B")

            .setTimestamp()
            .setFooter("Enjoy - From Tim");

        message.channel.send(exampleEmbed);
    }
});
