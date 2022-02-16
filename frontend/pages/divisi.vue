<template>
  <div>
    <UnderConstruction />
  </div>
</template>

<script>
export default {
  name: 'DivisiPage',
  data() {
    return {}
  },
  created() {
    this.$store.commit('page/setTitle', 'Divisi')
  },
}
</script>