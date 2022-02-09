<template>
  <div>
    <div class="bg-base-200 rounded-xl font-semibold">
      <div class="tabs tabs-boxed bg-base-300">
        <a
          class="tab transition-all ease-in-out duration-300"
          :class="{ 'tab-active': selectedTab === 'data' }"
          @click="selectedTab = 'data'"
          >Data</a
        >
        <a
          class="tab transition-all ease-in-out duration-300"
          :class="{ 'tab-active': selectedTab === 'konfigurasi' }"
          @click="selectedTab = 'konfigurasi'"
          >Konfigurasi</a
        >
      </div>
      <div class="p-8">
        <PengaturanRekrutmenData v-if="selectedTab === 'data'" />
        <PengaturanRekrutmenKonfigurasi v-if="selectedTab === 'konfigurasi'" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PengaturanRekrutmenPage',
  layout: 'pengaturan',
  middleware: ['authenticated', 'moderator'],

  data() {
    return {
      selectedTab: 'data',
    }
  },

  created() {
    this.$store.commit('page/setTitle', 'Rekrutmen')
  },
}
</script>
