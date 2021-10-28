<template>
  <app-layout>
    <div>
      <template>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Open Beta Setup
        </h2>
      </template>

      <div class="py-2 md:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <!-- Step 1 -->
            <div class="px-6 py-4">
              <div class="font-bold text-gray-800">Step 1</div>
              <div class="font-bold text-gray-600 text-sm">
                Install MetaMask
              </div>
              <div class="py-4">
                <div v-if="!hasMetaMask" class="flex">
                  <div>
                    We cannot detect your MetaMask, ensure it can access this
                    page or
                  </div>
                  <onboard-meta-mask />.
                </div>
                <div v-if="hasMetaMask" class="">
                  <div class="text-green-600 font-semibold">
                    Awesome! MetaMask is installed! ✅
                  </div>
                  <div class="text-sm text-gray-500">
                    Tip: To interact with the Flare network you must use this
                    browser with MetaMask installed.
                  </div>
                </div>
              </div>
            </div>
            <!-- Step 2 -->
            <div class="px-6 pb-4">
              <div class="font-bold text-gray-800">Step 3</div>
              <div class="font-bold text-gray-600 text-sm">
                Connect to Ropsten Network & Add USDT Token
              </div>
              <div class="py-4">
                <add-ropesten-tokens />
              </div>
            </div>
            <!-- Step 3 -->
            <div class="px-6 pb-4">
              <div class="font-bold text-gray-800">Step 3</div>
              <div class="font-bold text-gray-600 text-sm">
                Add Costone Network
              </div>
              <div class="py-4">
                <add-costone-network />
              </div>
            </div>

            <!-- Step 4 -->
            <div class="px-6 pb-4">
              <div class="font-bold text-gray-800">Step 4</div>
              <div class="font-bold text-gray-600 text-sm">
                Add Beta Tokens To Costone Network
              </div>
              <div class="py-4">
                <add-flare-beta-tokens />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>


<script>
import AppLayout from "@/Layouts/AppLayout";
import AddFlareBetaTokens from "../Components/AddFlareBetaTokens.vue";
import OnboardMetaMask from "../Components/OnboardMetaMask.vue";
import AddCostoneNetwork from "../Components/AddCostoneNetwork.vue";
import AddRopestenTokens from "../Components/AddRopestenTokens.vue";

export default {
  components: {
    AppLayout,
    AddFlareBetaTokens,
    OnboardMetaMask,
    AddCostoneNetwork,
    AddRopestenTokens,
  },
  data: () => {
    return {
      hasMetaMask: false,
    };
  },
  methods: {
    checkForMetaMask() {
      if (typeof window.ethereum !== "undefined") {
        this.hasMetaMask = true;
        console.log(this.hasMetaMask);
      }
    },
    refreshMetaMask() {
      location.reload(true);
    },
  },

  mounted: function () {
    this.checkForMetaMask();
  },
};
</script>
