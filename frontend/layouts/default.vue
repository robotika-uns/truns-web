<template>
  <div>
    <Navbar />

    <Nuxt />

    <Footer />
  </div>
</template>

<script>
export default {
  name: 'DefaultLayout',
  head() {
    return {
      title: `${this.title} | ${this.$config.appName}`,
    }
  },
  computed: {
    title() {
      return this.$store.state.page.title
    },
  },
}
</script>
