<template>
  <div>
    <div class="">
      <div class="text-sm">
        Connected to:
        <span class="text-green-700" v-if="chain_id == '0x3'">Ropesten</span>
        <span class="text-red-700" v-else-if="chain_id == '0x1'"
          >Ethereum Mainnet OR Costone Network (we can't tell)
        </span>
        <span class="text-red-700" v-else>Other Network</span>
      </div>
      <div
        v-for="(token, index) in tokens"
        :key="index"
        @click="addToken(token)"
        class="border border-indigo-700 p-2 rounded mx-2 flex w-24"
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
          name: "USDT",
          address: "0x5A2e49Fb8f306Bf39cF1c8bc82B5155f4F0f9EBD",
          symbol: "bUSDT",
          decimals: 6,
          added: false,
          selected: false,
        },
      ],
      chain_id: null,
    };
  },
  mounted: function () {
    ethereum.on("chainChanged", this.handleChainChanged);
    this.chain_id = ethereum.chainId;
  },
  methods: {
    handleChainChanged(_chainId) {
      this.chain_id = _chainId;
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
