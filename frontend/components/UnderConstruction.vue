<template>
  <div>
    <div class="hero min-h-screen mt-[-9rem]">
      <div
        class="flex-col justify-center hero-content lg:flex-row-reverse min-w-full px-5 md:px-14 z-10 pt-24"
      >
        <img
          src="/assets/img/illustration/underconstruction.svg"
          class="p-5 md:max-w-lg"
        />
        <div class="w-full md:pl-10 text-center md:text-left">
          <h1 class="mb-5 text-5xl font-bold tracking-wide text-slate-100">
            <span class="font-light">UNDER</span> CONSTRUCTION
          </h1>
          <p class="mb-5 lg:pr-32 text-white/60 tracking-wide text-2xl">
            <b>Whoops!</b> Sepertinya halaman ini sedang dalam proses pembuatan
            atau perbaikan. Coba lagi nanti ya!
          </p>
          <NuxtLink
            to="/"
            class="btn btn-primary tracking-wider hover:shadow-lg hover:-translate-y-2 hover:shadow-white/50"
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
      <Wave />
    </div>
  </div>
</template>

<script>
export default {
  name: 'UnderConstructionComponent',
}
</script>
