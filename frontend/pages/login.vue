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
              Login Portal &nbsp;
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="40"
                height="40"
              >
                <path fill="none" d="M0 0h24v24H0z" />
                <path
                  d="M18 8h2a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1h2V7a6 6 0 1 1 12 0v1zm-7 7.732V18h2v-2.268a2 2 0 1 0-2 0zM16 8V7a4 4 0 1 0-8 0v1h8z"
                  class="fill-primary"
                />
              </svg>
            </p>
            <p class="mb-5 xl:pr-24 text-white/60 tracking-wide text-xl">
              Untuk bisa menggunakan fitur-fitur yang ada pada web Robotika UNS,
              silahkan login terlebih dahulu. Jika belum memiliki akun silahkan
              mendaftar akun
              <NuxtLink to="/register" class="text-slate-300"
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
            px-14
            z-50
          "
        >
          <div class="w-full place-self-center z-50">
            <img src="/assets/img/logo.png" class="w-52 m-auto mb-14" alt="" />

            <div v-if="state.error" class="alert alert-error mb-10">
              <div class="flex-1">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  class="w-6 h-6 mx-2 stroke-current"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"
                  ></path>
                </svg>
                <label>{{ state.error }} </label>
              </div>
            </div>

            <form id="loginForm" @submit.prevent="authenticate">
              <div class="form-control">
                <input
                  v-model="email"
                  type="text"
                  placeholder="Email / Username"
                  class="input input-bordered"
                  required
                />
              </div>
              <br />
              <div class="form-control">
                <input
                  v-model="password"
                  type="password"
                  placeholder="Password"
                  class="input input-bordered"
                  required
                />
              </div>
              <div class="form-control mt-6">
                <button
                  type="submit"
                  class="
                    btn btn-primary
                    tracking-widest
                    hover:shadow-lg hover:shadow-white/50
                  "
                  :disabled="state.isAuthenticationg"
                >
                  <span v-if="!state.isAuthenticationg" class="flex flex-row">
                    LOGIN &nbsp;
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 24 24"
                      width="24"
                      height="24"
                    >
                      <path fill="none" d="M0 0h24v24H0z" />
                      <path
                        d="M10 11V8l5 4-5 4v-3H1v-2h9zm-7.542 4h2.124A8.003 8.003 0 0 0 20 12 8 8 0 0 0 4.582 9H2.458C3.732 4.943 7.522 2 12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10c-4.478 0-8.268-2.943-9.542-7z"
                      />
                    </svg>
                  </span>

                  <svg
                    v-if="state.isAuthenticationg"
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
  name: 'LoginPage',
  middleware: 'guest',
  data: () => ({
    email: '',
    password: '',

    state: {
      isAuthenticationg: false,
      error: '',
    },
  }),
  methods: {
    authenticate() {
      this.state.error = ''
      this.state.isAuthenticationg = true
      this.$axios
        .post(`${this.$config.apiURL}/auth/login`, {
          email: this.email,
          password: this.password,
        })
        .then((response) => {
          localStorage.setItem('token', response.data.token)
          this.$router.push('/dashboard')
        })
        .catch((error) => {
          this.state.isAuthenticationg = false
          this.state.error = error.response.data.pesan
        })
    },
  },
}
</script>
