<template>
  <div>
    <div class="flex">
      <div
        v-for="(token, index) in tokens"
        :key="index"
        @click="addToken(token)"
        class="border border-indigo-700 p-2 rounded mx-2 flex"
      >
        Add {{ token.name }}
        <div v-if="token.selected && !token.added">
          <img
            class="animate-spin icon opacity-75 ml-2"
            src="/images/loading.svg"
            alt=""
          />
        </div>
        <div v-if="token.added" class="mx-2">✅</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: () => {
    return {
      tokens: [
        {
          name: "YFLR",
          address: "0x880903167d7665C28c3eC0E9b85741d1DFA4feEb",
          symbol: "bYFLR",
          decimals: 18,
          added: false,
          selected: false,
        },
        {
          name: "YFIN",
          address: "0x4eE1d121cCF3BF6f5b2218F82EC227264098a53b",
          symbol: "bYFIN",
          decimals: 18,
          added: false,
          selected: false,
        },
        {
          name: "xUSD",
          address: "0x3A71f101AD5f3bd0FB72a37474c31ED68BaBF6bf",
          symbol: "bxUSD",
          decimals: 6,
          added: false,
        },
        {
          name: "FXRP",
          address: "0x4140a324d7e60e633bb7cBD7bdcE330FF5702B5E",
          symbol: "bFXRP",
          decimals: 18,
          added: false,
          selected: false,
        },
        {
          name: "FLTC",
          address: "0x539F3bb9b7953450016B4933db6Fd847B0e7803F",
          symbol: "bFLTC",
          decimals: 6,
          added: false,
          selected: false,
        },
        {
          name: "FDOGE",
          address: "0xD08A154255339a1Ad359ed204374cF967b4D72DF",
          symbol: "bFDOGE",
          decimals: 6,
          added: false,
          selected: false,
        },
      ],
    };
  },
  mounted: function () {
    ethereum.on("chainChanged", this.handleChainChanged);
    console.log(ethereum.chainId);
  },
  methods: {
    handleChainChanged(_chainId) {
      console.log(`CHANGED CHAIN: ${_chainId}`);
    },
    async addToken(token) {
      token.selected = true;
      try {
        // wasAdded is a boolean. Like any RPC method, an error may be thrown.

        const wasAdded = await ethereum.request({
          method: "wallet_watchAsset",
          params: {
            type: "ERC20", // Initially only supports ERC20, but eventually more!
            options: {
              address: token.address, // The address that the token is at.
              symbol: token.symbol, // A ticker symbol or shorthand, up to 5 chars.
              decimals: token.decimals, // The number of decimals in the token
              // A string url of the token logo
            },
          },
        });

        if (wasAdded) {
          console.log("Thanks for your interest!");
          token.added = true;
        } else {
          token.selected = false;
          console.log("Your loss!");
        }
      } catch (error) {
        console.log(error);
      }
      console.log(this.tokens);
    },
  },
};
</script>
<style scoped>
.icon {
  height: 18px;
  width: 18px;
}
</style>
