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
        Dashboard
      </div>
    </div>
    <div class="px-24 pt-14 grid grid-cols-12 w-full gap-10">
      <div class="col-span-4">
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
      <div class="col-span-8">
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
            <svg
              v-if="state.isFetchingNotifications"
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
            </svg>

            <div
              v-if="!notifications && !state.isFetchingNotifications"
              class="text-center py-5"
            >
              Belum Ada Notifikasi
            </div>

            <div
              v-for="notification in notifications"
              :key="notification.id"
              class="alert bg-base-100"
            >
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
                  <!-- <h4>Lorem <b>ipsum</b> dolor sit!</h4> -->
                  <h4>{{ notification.data.pesan }}</h4>
                  <p class="text-sm text-base-content text-opacity-60">
                    2 menit yang lalu.
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
    notifications: null,

    state: {
      isFetchingNotifications: true,
      error: '',
    },
  }),
  async fetch() {
    this.state.isFetchingNotifications = true
    await this.$axios
      .get(`${this.$config.apiURL}/notifications`)
      .then((response) => {
        if (response.data.tag === 'notifikasi_kosong') {
          this.notifications = null
        } else if (response.data.tag === 'notifikasi_ada') {
          this.notifications = response.data.data
        }
        this.state.isFetchingNotifications = false
      })
  },
}
</script>
