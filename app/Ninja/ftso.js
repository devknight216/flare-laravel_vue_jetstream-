const { add, update } = require("lodash");

var totalVotingPower = 0; // Total Spark Staked

var mean = 0; // Oracle Output
var award_weight = 0; // Total Award Weight

var award_rate = 0.1;
var voting_rounds = 12;
var spark_circulation = 1440;
var award = (award_rate * spark_circulation) / voting_rounds;

// Round 1
var voters = [
    {
        address: "FTSO.eu",
        spark: 100, // Owns ten token
        vote: 2.0, // Votes price as $3.00
    },
    {
        address: "FTSO.uk",
        spark: 50, // Owns twenty token
        vote: 3.0, // Votes price as $4.00
    },
    {
        address: "FTSO.au",
        spark: 100, // Owns thirty token
        vote: 4.0, // Votes price as $5.00
    },
];

function prepareAddresses() {
    // Sort in order of vote
    voters.sort((a, b) => {
        return a.vote - b.vote;
    });
}

function setTotalVotingPower() {
    voters.forEach((address) => {
        totalVotingPower += address.spark;
    });
}

function truncate() {
    var lowerRemoveLimit = totalVotingPower * 0.25;
    var upperRemoveLimit = totalVotingPower * 0.25;

    voters.forEach((address) => {
        address.spark_pre_truncate = address.spark; // Sets voted spark before truncation
        if (lowerRemoveLimit == 0) return;

        if (address.spark < lowerRemoveLimit) {
            lowerRemoveLimit -= address.spark;
            address.spark = 0;
        } else {
            address.spark -= lowerRemoveLimit;
            lowerRemoveLimit = 0;
        }
    });

    voters.reverse();
    voters.forEach((address) => {
        if (upperRemoveLimit == 0) return;

        if (address.spark < upperRemoveLimit) {
            upperRemoveLimit -= address.spark;
            address.spark = 0;
        } else {
            address.spark -= upperRemoveLimit;
            upperRemoveLimit = 0;
        }
    });
}

function updateAddresses() {
    // Get new total voting power
    var truncatedVotingPower = 0; // Total Spark Staked
    voters.forEach((address) => {
        truncatedVotingPower += address.spark;
    });

    // Get Weighted Mean
    voters.forEach((address) => {
        address.award_weight = address.spark / address.spark_pre_truncate;
        award_weight += address.award_weight;
        if (address.spark > 0) {
            mean += (address.spark / truncatedVotingPower) * address.vote;
        }
    });
}

function awardSpark() {
    voters.forEach((address) => {
        address.award = award * (address.award_weight / award_weight);
    });
}

prepareAddresses();
setTotalVotingPower();
truncate();
updateAddresses();
awardSpark();

console.log({
    voters: voters,
    mean: mean,
    award: award,
    award_weight: award_weight,
});
