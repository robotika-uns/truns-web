<template>
  <div>
    <div class="hero min-h-screen bg-base-200">
      <div class="text-center hero-content z-50">
        <div class="max-w-xl">
          <h1 class="mb-5 text-5xl font-bold">Verifikasi Email</h1>
          <p class="mb-5 text-slate-300">
            Silahkan masukkan kode verifikasi yang tertera pada email kamu untuk
            memverifikasi email. Jika tidak ada email masuk pada Inbox cek juga
            pada folder Spam. Kode verifikasi akan kadaluarsa dalam 15 menit.
          </p>
          <div class="mt-5">
            <form id="verifyForm" @submit.prevent="verify">
              <div class="form-control w-72 m-auto">
                <div class="flex space-x-2">
                  <input
                    v-model="verification_code"
                    type="number"
                    placeholder="______"
                    required
                    class="w-full input input-lg input-bordered tracking-[16px] text-xl text-center pr-1"
                    :class="state.error ? 'input-error' : ''"
                    @input="state.error = ''"
                  />

                  <button
                    type="submit"
                    :disabled="state.isChecking"
                    class="btn btn-secondary btn-lg"
                  >
                    <svg
                      v-if="!state.isChecking"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 24 24"
                      width="24"
                      height="24"
                    >
                      <path fill="none" d="M0 0h24v24H0z" />
                      <path
                        d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
                        class="fill-white"
                      />
                    </svg>
                    <svg
                      v-if="state.isChecking"
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
                <label v-if="state.error" class="label">
                  <span
                    class="label-text-alt text-sm tracking-wider text-error"
                    >{{ state.error.pesan }}</span
                  >
                </label>
              </div>
            </form>
          </div>

          <div class="mt-5">
            <button
              :disabled="cooldown > 0 || state.isResending"
              class="btn btn-primary btn-sm"
              @click="resendEmail"
            >
              <span v-if="!state.isResending">
                Kirim Ulang Email Verifikasi
              </span>
              <span v-if="cooldown > 0 && !state.isResending" class="countdown">
                &nbsp; (<span :style="'--value: ' + cooldown"></span>)
              </span>
              <svg
                v-if="state.isResending"
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
          <div class="mt-5">
            <button class="link text-red-500 tracking-wide" @click="logout">
              <span class="flex flex-row">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  width="24"
                  height="24"
                >
                  <path fill="none" d="M0 0h24v24H0z" />
                  <path
                    d="M12 2c5.52 0 10 4.48 10 10s-4.48 10-10 10S2 17.52 2 12 6.48 2 12 2zm0 9V8l-4 4 4 4v-3h4v-2h-4z"
                    class="fill-red-500"
                  />
                </svg>
                &nbsp;
                <b>LOGOUT</b>
              </span>
            </button>
          </div>
        </div>
      </div>
    </div>
    <Wave />
  </div>
</template>

<script>
export default {
  name: 'VerifyPage',
  middleware: 'unverified-email',
  data: () => ({
    verification_code: '',
    cooldown: 60,
    state: {
      isResending: true,
      isChecking: false,
      error: '',
    },
  }),
  async fetch() {
    this.state.isResending = true
    await this.$axios
      .get(`${this.$config.apiURL}/auth/resend/cooldown`)
      .then((response) => {
        if (response.data) {
          this.cooldown = response.data.cooldown
          this.cooldownTimer()
          this.state.error = ''
          this.state.isResending = false
        } else {
          this.cooldown = 0
          this.state.isResending = false
        }
      })
      .catch((error) => {
        this.state.error = error.response.data
        this.state.isResending = false
      })
  },
  methods: {
    async verify() {
      this.state.isChecking = true
      this.state.error = ''
      await this.$axios
        .post(`${this.$config.apiURL}/auth/verify`, {
          verification_code: this.verification_code,
        })
        .then((response) => {
          window.location.reload(true)
        })
        .catch((error) => {
          this.state.error = error.response.data
          this.state.isChecking = false
        })
    },
    async resendEmail() {
      this.state.isResending = true
      setTimeout(() => {}, 2000)
      await this.$axios
        .patch(`${this.$config.apiURL}/auth/resend`)
        .then((response) => {
          this.cooldown = 60
          this.cooldownTimer()
          this.state.isResending = false
        })
    },
    cooldownTimer() {
      if (this.cooldown > 0) {
        setTimeout(() => {
          this.cooldown -= 1
          this.cooldownTimer()
        }, 1000)
      }
    },
    async logout() {
      await this.$axios
        .delete(`${this.$config.apiURL}/auth/logout`)
        .then((response) => {
          localStorage.removeItem('token')
          this.$store.commit('user/setUser', null)
          window.location.reload(true)
        })
        .catch((error) => {
          this.state.error = error
        })
    },
  },
}
</script>
