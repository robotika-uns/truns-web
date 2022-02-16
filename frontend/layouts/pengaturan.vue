<template>
  <div>
    <Navbar />
    <div
      class="h-56 rounded-b-[5rem] bg-base-300 mt-[-9rem] shadow-2xl shadow-black/70"
    >
      <div
        class="text-center pt-32 text-4xl font-extralight tracking-widest uppercase"
      >
        Pengaturan
      </div>
    </div>

    <div class="px-24 pt-14 grid grid-cols-12 gap-10 pb-24">
      <div class="col-span-4">
        <PengaturanSidebar />
      </div>
      <div class="col-span-8">
        <Nuxt />
      </div>
    </div>

    <Footer />
  </div>
</template>

<script>
export default {
  name: 'PengaturanLayout',
  head() {
    return {
      title: `${this.title} - Pengaturan | ${this.$config.appName}`,
    }
  },
  computed: {
    title() {
      return this.$store.state.page.title
    },
  },
}
</script>
