<template>
  <div class="min-h-screen bg text-right">
    <div class="text-8xl shadow font-bold text-white pt-12 pr-12">
      Coming Soon
    </div>
    <div class="text-4xl text-white pt-6 pr-12">
      More cool stuff coming soon!
    </div>
    <div @click="addTokens()">add tokens</div>
  </div>
</template>

<style scoped>
.bg {
  /* The image used */
  background-image: url("/images/bg-image.jpg");

  /* Full height */
  height: 100%;

  /* Center and scale the image nicely */

  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}
body,
html {
  height: 100%;
  margin: 0;
}
</style>

<script>
export default {
  props: {
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
  },

  mounted: function () {},

  methods: {},
};
</script>
