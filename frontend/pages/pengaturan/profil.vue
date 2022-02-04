<template>
  <div>
    <Navbar />

    <div
      class="
        h-56
        rounded-b-[5rem]
        bg-base-300
        mt-[-9rem]
        shadow-2xl shadow-black/70
      "
    >
      <div
        class="
          text-center
          pt-32
          text-4xl
          font-extralight
          tracking-widest
          uppercase
        "
      >
        Pengaturan
      </div>
    </div>
    <div class="px-24 pt-14 grid grid-cols-12 gap-10">
      <div class="col-span-4">
        <SidebarPengaturan />
      </div>
      <div class="col-span-8">
        <div class="px-14">
          <!-- <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            width="64"
            height="64"
            class="animate-spin m-auto"
          >
            <path fill="none" d="M0 0h24v24H0z" />
            <path
              d="M12 3a9 9 0 0 1 9 9h-2a7 7 0 0 0-7-7V3z"
              class="fill-white/50"
            />
          </svg> -->
        </div>
        <div class="bg-base-200 rounded-xl p-8">
          <form id="recruitForm" @submit.prevent="update">
            <div class="form-control mb-5">
              <label class="label">
                <span class="label-text uppercase tracking-widest"
                  >Nama Lengkap</span
                >
              </label>
              <input
                v-model="user.name"
                type="text"
                class="input input-bordered"
                required
                :class="state.error.name ? 'input-error' : ''"
                @input="state.error.name ? (state.error.name = '') : ''"
              />
              <InputErrorLabel :error="state.error.name" />
            </div>

            <div class="form-control mb-5">
              <label class="label">
                <span class="label-text uppercase tracking-widest"
                  >Bio Singkat</span
                >
              </label>
              <input
                v-model="user.bio"
                type="text"
                class="input input-bordered"
                :class="state.error.bio ? 'input-error' : ''"
                @input="state.error.bio ? (state.error.bio = '') : ''"
              />
              <InputErrorLabel :error="state.error.bio" />
            </div>

            <div class="form-control mt-10">
              <button
                type="submit"
                class="
                  btn btn-sm btn-primary
                  w-32
                  tracking-widest
                  hover:shadow-lg hover:shadow-white/50
                "
                :disabled="state.isUpdating || state.isSaved"
              >
                <span
                  v-if="!state.isUpdating && !state.isSaved"
                  class="flex flex-row"
                >
                  Update
                </span>

                <svg
                  v-if="state.isUpdating"
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
                <i v-if="state.isSaved" class="ri-check-line text-success"></i>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <Footer />
  </div>
</template>

<script>
export default {
  name: 'PengaturanProfilPage',
  middleware: 'authenticated',

  data: () => ({
    state: {
      isUpdating: false,
      isSaved: false,
      error: '',
    },
  }),
  computed: {
    user() {
      return { ...this.$store.state.user.currentUser }
    },
  },
  methods: {
    async update() {
      this.state.isUpdating = true
      this.state.error = ''
      await this.$axios
        .patch(`${this.$config.apiURL}/user`, this.user)
        .then((response) => {
          // this.status_recruit = 'recruit_sudah_submit'
          this.state.isUpdating = false
          this.state.isSaved = true
          setTimeout(() => {
            this.state.isSaved = false
          }, 1000)
        })
        .catch((error) => {
          this.state.error = error.response.data
          this.state.isUpdating = false
        })
    },
  },
}
</script>