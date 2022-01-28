<template>
  <div>
    <div v-if="error.statusCode === 404">
      <div class="hero min-h-screen bg-base-200">
        <div class="text-center hero-content z-50">
          <div class="max-w-md">
            <h1 class="mb-5 text-5xl font-bold">Whoops!</h1>
            <p class="mb-5 text-slate-400">
              Halaman yang kamu cari ngga ada nih.
            </p>
            <NuxtLink
              to="/"
              class="
                btn btn-primary
                tracking-wider
                hover:shadow-lg hover:-translate-y-2 hover:shadow-white/50
              "
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
              >
                <path fill="none" d="M0 0h24v24H0z" />
                <path
                  d="M12 2c5.52 0 10 4.48 10 10s-4.48 10-10 10S2 17.52 2 12 6.48 2 12 2zm0 9V8l-4 4 4 4v-3h4v-2h-4z"
                />
              </svg>
              &nbsp; Kembali ke Lab
            </NuxtLink>
          </div>
        </div>
      </div>
    </div>

    <div v-else>
      <div class="hero min-h-screen bg-base-200">
        <div class="text-center hero-content z-50">
          <div class="max-w-md">
            <h1 class="mb-5 text-5xl font-bold">Whoops!</h1>
            <p class="mb-5 text-slate-400">
              {{ error.message }}
            </p>
            <NuxtLink
              to="/"
              class="
                btn btn-primary
                tracking-wider
                hover:shadow-lg hover:-translate-y-2 hover:shadow-white/50
              "
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
              >
                <path fill="none" d="M0 0h24v24H0z" />
                <path
                  d="M12 2c5.52 0 10 4.48 10 10s-4.48 10-10 10S2 17.52 2 12 6.48 2 12 2zm0 9V8l-4 4 4 4v-3h4v-2h-4z"
                />
              </svg>
              &nbsp; Kembali ke Lab
            </NuxtLink>
          </div>
        </div>
      </div>
    </div>

    <Wave />
  </div>
</template>

<script>
export default {
  name: 'ErrorPage',
  layout: 'default', // you can set a custom layout for the error page
  props: { error: { type: Object, default: null } },
  head() {
    return {
      title: 'Keratown | Error ' + String(this.error.statusCode),
    }
  },
}
</script>