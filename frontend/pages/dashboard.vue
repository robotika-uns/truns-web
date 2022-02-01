<template>
  <div>
    <Navbar />

    <div class="grid grid-cols-12 w-full">
      <div class="col-span-4 p-10">
        <div class="card card-bordered bg-base-200">
          <h2
            class="
              card-title
              uppercase
              font-light
              bg-base-300
              tracking-widest
              text-3xl
              py-5
              px-8
            "
          >
            Pengumuman
          </h2>
          <div class="card-body">
            <div class="alert alert-info">
              <div class="flex-1">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="#2196f3"
                  class="flex-shrink-0 w-6 h-6 mx-2"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                  ></path>
                </svg>
                <label>
                  <h4><b>Lorem ipsum dolor sit!</b></h4>
                  <p class="text-sm text-base-content text-opacity-60">
                    Lorem ipsum dolor sit amet, consectetur adip! Lorem ipsum
                    dolor sit amet, consectetur adip!Lorem ipsum dolor sit amet,
                    consectetur adip!Lorem ipsum dolor sit amet, consectetur
                    adip!Lorem ipsum dolor sit amet, consectetur adip!Lorem
                    ipsum dolor sit amet, consectetur adip!
                  </p>
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-span-8 p-10">
        <div class="card card-bordered bg-base-200">
          <h2
            class="
              card-title
              uppercase
              font-light
              bg-base-300
              tracking-widest
              text-3xl
              py-5
              px-8
              border-b-2 border-b-primary/10
            "
          >
            Notifikasi
          </h2>
          <div class="card-body">
            <div class="alert bg-base-100">
              <div class="flex-1">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="#2196f3"
                  class="flex-shrink-0 w-6 h-6 mx-2"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                  ></path>
                </svg>
                <label>
                  <h4><b>Lorem ipsum dolor sit!</b></h4>
                  <p class="text-sm text-base-content text-opacity-60">
                    Lorem ipsum dolor sit amet, consectetur adip! Lorem ipsum
                    dolor sit amet, consectetur adip!Lorem ipsum dolor sit amet,
                    consectetur adip!Lorem ipsum dolor sit amet, consectetur
                    adip!Lorem ipsum dolor sit amet, consectetur adip!Lorem
                    ipsum dolor sit amet, consectetur adip!
                  </p>
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'DashboardPage',
  middleware: 'authenticated',
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
          this.state.isAuthenticationg = false
          alert(response.data.token)
        })
        .catch((error) => {
          this.state.isAuthenticationg = false
          this.state.error = error.response.data.pesan
        })
    },
  },
}
</script>
