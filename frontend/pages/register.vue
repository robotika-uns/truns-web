<template>
  <div>
    <div class="min-h-screen bg-base-100">
      <div class="flex md:flex-row gap-4 min-h-screen">
        <div
          class="
            md:basis-7/12
            lg:basis-7/12
            xl:basis-8/12
            place-self-center
            z-50
            hidden
            md:block
          "
        >
          <div class="text-left px-10 xl:px-24">
            <!-- <img src="/assets/img/login.svg" class="max-w-sm" alt="" /> -->
            <p class="mb-5 text-5xl font-bold uppercase flex">
              Register Portal &nbsp;
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="40"
                height="40"
              >
                <path fill="none" d="M0 0h24v24H0z" />
                <path
                  d="M14 14.252V22H4a8 8 0 0 1 10-7.748zM12 13c-3.315 0-6-2.685-6-6s2.685-6 6-6 6 2.685 6 6-2.685 6-6 6zm6 4v-3h2v3h3v2h-3v3h-2v-3h-3v-2h3z"
                  class="fill-primary"
                />
              </svg>
            </p>
            <p class="mb-5 xl:pr-24 text-white/60 tracking-wide text-xl">
              Untuk bisa menggunakan fitur-fitur yang ada pada web Robotika UNS,
              silahkan buat akun terlebih dahulu. Jika sudah memiliki akun
              silahkan login
              <NuxtLink to="/login" class="text-slate-300"
                ><b>disini</b></NuxtLink
              >.
            </p>
            <NuxtLink to="/" class="btn btn-primary">
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
              &nbsp; Kembali ke Beranda
            </NuxtLink>
          </div>
        </div>
        <div
          class="
            flex
            md:basis-5/12
            lg:basis-5/12
            xl:basis-4/12
            bg-base-300
            min-h-screen
            place-self-center
            w-full
            p-14
            z-50
          "
        >
          <div class="w-full place-self-center z-50">
            <img src="/assets/img/logo.png" class="w-52 m-auto mb-14" alt="" />

            <form id="loginForm" @submit.prevent="register">
              <div class="form-control">
                <input
                  v-model="name"
                  type="text"
                  placeholder="Nama Lengkap"
                  class="input input-bordered"
                  required
                  :class="state.error.name ? 'input-error' : ''"
                  @input="state.error.name ? (state.error.name = '') : ''"
                />
                <InputErrorLabel :error="state.error.name" />
              </div>
              <br />
              <div class="form-control">
                <input
                  v-model="username"
                  type="text"
                  placeholder="Username"
                  class="input input-bordered"
                  required
                  :class="state.error.username ? 'input-error' : ''"
                  @input="
                    state.error.username ? (state.error.username = '') : ''
                  "
                />

                <InputErrorLabel :error="state.error.username" />
              </div>
              <br />
              <div class="form-control">
                <input
                  v-model="email"
                  type="email"
                  name="email"
                  placeholder="Email"
                  class="input input-bordered"
                  required
                  :class="state.error.email ? 'input-error' : ''"
                  @input="state.error.email ? (state.error.email = '') : ''"
                />
                <InputErrorLabel :error="state.error.email" />
              </div>
              <br />
              <div class="form-control">
                <input
                  v-model="password"
                  type="password"
                  name="password"
                  placeholder="Password"
                  class="input input-bordered"
                  required
                  :class="state.error.password ? 'input-error' : ''"
                  @input="
                    state.error.password ? (state.error.password = '') : ''
                  "
                />
                <InputErrorLabel :error="state.error.password" />
              </div>
              <div class="form-control mt-6">
                <button
                  type="submit"
                  class="
                    btn btn-primary
                    tracking-widest
                    hover:shadow-lg hover:shadow-white/50
                  "
                  :disabled="state.isRegistering"
                >
                  <span v-if="!state.isRegistering" class="flex flex-row">
                    BUAT AKUN &nbsp;
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 24 24"
                      width="24"
                      height="24"
                    >
                      <path fill="none" d="M0 0h24v24H0z" />
                      <path
                        d="M14 14.252v2.09A6 6 0 0 0 6 22l-2-.001a8 8 0 0 1 10-7.748zM12 13c-3.315 0-6-2.685-6-6s2.685-6 6-6 6 2.685 6 6-2.685 6-6 6zm0-2c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm6 6v-3h2v3h3v2h-3v3h-2v-3h-3v-2h3z"
                      />
                    </svg>
                  </span>

                  <svg
                    v-if="state.isRegistering"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    width="24"
                    height="24"
                    class="animate-spin"
                  >
                    <path fill="none" d="M0 0h24v24H0z" />
                    <path
                      d="M12 3a9 9 0 0 1 9 9h-2a7 7 0 0 0-7-7V3z"
                      class="fill-white"
                    />
                  </svg>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <Wave class="hidden md:block" />
    </div>
  </div>
</template>

<script>
export default {
  name: 'RegisterPage',
  middleware: 'guest',
  data: () => ({
    name: '',
    username: '',
    email: '',
    password: '',

    state: {
      isRegistering: false,
      error: '',
    },
  }),
  methods: {
    register() {
      this.state.error = ''
      this.state.isRegistering = true
      this.$axios
        .post(`${this.$config.apiURL}/auth/register`, {
          name: this.name,
          username: this.username,
          email: this.email,
          password: this.password,
        })
        .then((response) => {
          localStorage.setItem('token', response.data.token)
          this.$router.push('/dashboard')
        })
        .catch((error) => {
          this.state.isRegistering = false
          this.state.error = error.response.data
        })
    },
  },
}
</script>
