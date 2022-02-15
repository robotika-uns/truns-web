<template>
  <div class="pb-16">
    <div class="bg-base-200 rounded-xl font-semibold">
      <div class="p-8">
        <div
          v-if="$fetchState.pending"
          class="text-center text-primary/80 tracking-widest font-light rounded-lg py-5"
        >
          <LoaderModel6 :size="32" />
        </div>
        <div
          v-if="logs.total === 0 && !$fetchState.pending"
          class="text-center tracking-widest opacity-60 font-medium"
        >
          Tidak ada log.
        </div>
        <div v-if="logs.total > 0 && !$fetchState.pending">
          <div v-for="(log, index) in logs.data" :key="log.id">
            <div
              v-if="!(index == 0)"
              class="h-5 ml-16 border-l-2 border-primary/10"
            ></div>
            <div
              class="alert bg-base-100 border-2 border-primary/10 hover:shadow-lg hover:shadow-black transition-all ease-in-out duration-300"
            >
              <div class="flex-1">
                <i
                  class="ri-checkbox-blank-circle-line flex-shrink w-6 h-6 mx-2 text-info"
                ></i>
                <label>
                  <TipTapRender :data="log.data.pesan" />

                  <p class="text-sm opacity-60 font-normal">
                    {{ tanggal(log.created_at) }}
                  </p>
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <Pagination
      :page="logs.current_page"
      :total="logs.last_page"
      class="mt-8"
    />
  </div>
</template>

<script>
export default {
  name: 'PengaturanLogPage',
  layout: 'pengaturan',
  middleware: ['authenticated', 'moderator'],

  data() {
    return {
      logs: [],
      filters: {
        page: 1,
      },
      selectedTab: 'data',
    }
  },

  async fetch() {
    await this.$axios
      .get(`${this.$config.apiURL}/log`, {
        params: { page: this.filters.page },
      })
      .then((response) => {
        this.logs = response.data
      })
  },
  created() {
    this.$store.commit('page/setTitle', 'Log')
  },
}
</script>
