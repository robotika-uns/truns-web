<template>
  <div>
    <div class="hero min-h-screen">
      <div
        class="flex-col justify-center hero-content lg:flex-row-reverse min-w-full px-5 md:px-14 z-10"
      >
        <img
          :src="`/assets/img/illustration/${error.statusCode}.svg`"
          class="p-5 md:max-w-lg"
        />
        <div class="w-full md:pl-10 text-center md:text-left">
          <h1
            class="mb-5 text-5xl font-bold tracking-wide text-slate-100 uppercase"
          >
            <span class="font-light">WHOOPS!</span>
            <span v-if="error.statusCode === 404" class="font-bold"
              >NOT FOUND.</span
            >
            <span v-if="error.statusCode === 403" class="font-bold"
              >FORBIDDEN.</span
            >
          </h1>
          <p class="mb-5 lg:pr-32 text-white/60 tracking-wide text-2xl">
            {{
              error.statusCode === 404
                ? 'Halaman yang Kamu cari tidak ditemukan.'
                : ''
            }}
            {{
              error.statusCode === 403
                ? 'Kamu tidak memiliki akses ke halaman ini.'
                : ''
            }}
            {{ error.statusCode === 500 ? error.message : '' }}
          </p>
          <NuxtLink
            to="/"
            class="btn btn-primary tracking-wider hover:shadow-lg hover:-translate-y-2 hover:shadow-white/50"
          >
            <i class="ri-arrow-left-line mr-2"></i>
            Kembali ke Beranda
          </NuxtLink>
        </div>
      </div>
      <Wave />
    </div>
  </div>
</template>

<script>
export default {
  name: 'ErrorPage',
  layout: 'default', // you can set a custom layout for the error page
  props: { error: { type: Object, default: null } },
  head() {
    return {
      title: `Error | ${this.$config.appName}`,
    }
  },
}
</script>
