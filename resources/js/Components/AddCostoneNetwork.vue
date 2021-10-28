<template>
  <div>
    <div class="">
      Add the Costone network & connect to it.

      <div class="bg-gray-100 max-w-md rounded my-2">
        <div class="p-2 text-sm">
          <p>
            <b class="select-none">RPC URL:</b>
            <span class="pl-2 text-indigo-700"
              >https://costone.flare.network/ext/bc/C/rpc</span
            >
          </p>
          <p>
            <b class="select-none">Chain ID:</b>
            <span class="pl-2 text-indigo-700">1</span>
          </p>
          <p>
            <b class="select-none">Symbol:</b>
            <span class="pl-2 text-indigo-700">FLR</span>
          </p>
          <p>
            <b class="select-none">Block Explorer Url:</b>
            <span class="pl-2 text-indigo-700">https://flarescan.org/</span>
          </p>
        </div>
      </div>
      <div>
        <div class="text-sm">
          Connected to:
          <span class="text-red-700" v-if="chain_id == '0x3'">Ropesten</span>
          <span class="text-yellow-600" v-else-if="chain_id == '0x1'"
            >Ethereum Mainnet OR Costone Network (we can't tell)
          </span>
          <span class="text-red-700" v-else>Other Network</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: () => {
    return {
      chain_id: null,
    };
  },
  mounted: function () {
    ethereum.on("chainChanged", this.handleChainChanged);
    this.chain_id = ethereum.chainId;
    ethereum
      .request({ method: "eth_accounts" })
      .then(this.handleAccountsChanged)
      .catch((err) => {
        // Some unexpected error.
        // For backwards compatibility reasons, if no accounts are available,
        // eth_accounts will return an empty array.
        console.error(err);
      });
  },
  methods: {
    handleChainChanged(_chainId) {
      this.chain_id = ethereum.chainId;
      console.log(ethereum);
      console.log(`CHANGED CHAIN: ${_chainId}`);
    },
    handleAccountsChanged(accounts) {
      if (accounts.length === 0) {
        // MetaMask is locked or the user has not connected any accounts
        console.log("Please connect to MetaMask.");
      } else {
        console.log(accounts);
        // Do any other work!
      }
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
