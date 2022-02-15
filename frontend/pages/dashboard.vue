<template>
  <div>
    <Navbar />

    <div
      class="h-56 rounded-b-[5rem] bg-base-300 mt-[-9rem] shadow-2xl shadow-black/70"
    >
      <div
        class="text-center pt-32 text-4xl font-extralight tracking-widest uppercase"
      >
        Dashboard
      </div>
    </div>
    <div class="px-24 pt-14 grid grid-cols-12 w-full gap-10">
      <div class="col-span-4">
        <div
          class="alert alert-primary border-2 border-primary/20 hover:shadow-lg hover:shadow-primary/20 transition-all ease-in-out duration-300"
        >
          <div class="flex-1 p-2">
            <i class="ri-spy-line ri-lg flex-shrink-0 mt-2 mr-3"></i>
            <label>
              <h4 class="text-lg uppercase"><b>Untuk Outsider</b></h4>
              <p class="leading-snug text-base-content">
                Selamat datang! Outsider adalah non-anggota UKM Robotika UNS,
                namun tetap bisa ikut berkontribusi pada fordis.
              </p>
              <!-- <p class="text-sm text-base-content text-opacity-60 mt-2">
                Diperbaharui
              </p> -->
            </label>
          </div>
        </div>

        <div class="h-10 ml-16 border-l-2 border-info/10"></div>

        <div
          class="alert alert-info border-2 border-info/20 hover:shadow-lg hover:shadow-info/20 transition-all ease-in-out duration-300"
        >
          <div class="flex-1 p-2">
            <i class="ri-user-add-line ri-lg flex-shrink-0 mt-2 mr-3"></i>
            <label>
              <h4 class="text-lg uppercase"><b>Untuk Calon Anggota</b></h4>
              <p class="leading-snug text-base-content">
                Untuk calon anggota UKM Robotika UNS yang ingin mendaftar
                menjadi anggota UKM Robotika UNS, silahkan klik
                <NuxtLink to="/rekrutmen" class="link"><b>disini</b></NuxtLink
                >.
              </p>
              <!-- <p class="text-sm text-base-content text-opacity-60 mt-2">
                Diperbaharui
              </p> -->
            </label>
          </div>
        </div>

        <div class="h-10 ml-16 border-l-2 border-warning/10"></div>

        <div
          class="alert alert-warning border-2 border-warning/20 hover:shadow-lg hover:shadow-warning/20 transition-all ease-in-out duration-300"
        >
          <div class="flex-1 p-2">
            <i class="ri-team-line ri-lg flex-shrink-0 mt-2 mr-3"></i>
            <label>
              <h4 class="text-lg uppercase"><b>Untuk Anggota & Alumni</b></h4>
              <p class="leading-snug text-base-content">
                Untuk anggota aktif atau alumni, silahkan hubungi moderator atau
                administrator website UKM Robotika UNS.
              </p>
              <!-- <p class="text-sm text-base-content text-opacity-60 mt-2">
                Diperbaharui
              </p> -->
            </label>
          </div>
        </div>

        <!-- <div class="card card-bordered bg-base-200">
          <h2
            class="card-title uppercase font-light bg-base-300 tracking-widest text-2xl py-3 px-8"
          >
            Informasi
          </h2>
          <div class="card-body">

          </div>
        </div> -->
      </div>
      <div class="col-span-8">
        <div class="card card-bordered bg-base-200">
          <h2
            class="card-title uppercase font-light bg-base-300 tracking-widest text-2xl py-3 px-8 border-b-2 border-b-primary/10"
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
              v-for="(notification, index) in notifications"
              :key="notification.id"
            >
              <div
                v-if="!(index == 0)"
                class="h-5 ml-16 border-l-2 border-primary/10"
              ></div>
              <div
                class="alert bg-base-100 border-2 border-primary/10 hover:shadow-lg hover:shadow-black transition-all ease-in-out duration-300"
              >
                <div class="flex-1">
                  <i
                    v-if="
                      notification.type ===
                      'App\\Notifications\\RecruitNotification'
                    "
                    class="ri-newspaper-fill flex-shrink w-6 h-6 mx-2"
                    :class="{
                      'text-info': notification.data.slug.status === 'diproses',
                      'text-error': notification.data.slug.status === 'ditolak',
                      'text-success':
                        notification.data.slug.status === 'diterima',
                    }"
                  ></i>
                  <label>
                    <TipTapRender :data="notification.data.pesan" />
                    <p class="text-sm opacity-60 font-normal">
                      {{ tanggal(notification.created_at) }}
                    </p>
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <Footer />
  </div>
</template>

<script>
import { parseJSON, formatRelative } from 'date-fns'
import { id } from 'date-fns/locale'

export default {
  name: 'DashboardPage',
  middleware: 'authenticated',
  data() {
    return {
      notifications: null,

      state: {
        isFetchingNotifications: true,
        error: '',
      },
    }
  },
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
  head() {
    return {
      title: `Dashboard | ${this.$config.appName}`,
    }
  },
  methods: {
    tanggal(date) {
      return formatRelative(new Date(parseJSON(date)), new Date(), {
        addSuffix: true,
        locale: id,
      })
    },
  },
}
</script>
