<template>
  <div>
    <div class="bg-base-200 rounded-xl font-semibold">
      <div class="p-8">
        <div class="grid grid-cols-12 gap-3">
          <div class="col-span-3">
            <div class="form-control">
              <select
                v-model="filters.role"
                class="select select-bordered w-full max-w-xs"
                @change="$fetch()"
              >
                <option value="">Semua role</option>
                <option value="administrator">Administrator</option>
                <option value="moderator">Moderator</option>
                <option value="member">Member</option>
              </select>
            </div>
          </div>
          <div class="col-span-3">
            <div class="form-control">
              <select
                v-model="filters.tipe"
                class="select select-bordered w-full max-w-xs"
                @change="$fetch()"
              >
                <option value="">Semua tipe</option>
                <option value="anggota">Anggota</option>
                <option value="alumni">Alumni</option>
                <option value="outsider">Outsider</option>
              </select>
            </div>
          </div>
          <div class="col-span-6">
            <div class="form-control">
              <div class="relative">
                <input
                  v-model="filters.search"
                  type="text"
                  placeholder="Cari user..."
                  class="w-full pr-16 input border-primary/30"
                  @keyup.enter="$fetch()"
                />
                <button
                  v-if="filters.search"
                  class="absolute right-14 p-0 px-2 h-full transition-all duration-300 ease-in-out hover:text-error"
                  @click="
                    filters.search = ''
                    $fetch()
                  "
                >
                  <i class="ri-close-line"></i>
                </button>
                <button
                  class="absolute top-0 right-0 rounded-l-none btn btn-primary"
                  @click="$fetch()"
                >
                  <i class="ri-search-2-line"></i>
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="mt-5">
          <div class="overflow-x-auto">
            <table class="table w-full">
              <thead>
                <tr>
                  <th class="bg-base-300 w-4/12">Nama</th>
                  <th class="bg-base-300 w-2/12 text-center">Role</th>
                  <th class="bg-base-300 w-2/12 text-center">Tipe</th>
                  <th class="bg-base-300 w-2/12 text-center">Journey</th>
                  <th class="bg-base-300 w-2/12 text-right">
                    <div
                      class="btn btn-primary btn-xs"
                      :class="{ loading: $fetchState.pending }"
                      @click="$fetch()"
                    >
                      <span class="text-sm">Refresh</span>
                    </div>
                  </th>
                </tr>
              </thead>

              <tbody v-if="users.total > 0 && !$fetchState.pending">
                <tr v-for="user in users.data" :key="user.id">
                  <td>
                    <div class="flex items-center space-x-3">
                      <div class="avatar">
                        <div class="w-12 h-12 mask mask-squircle">
                          <img :src="user.photo" />
                        </div>
                      </div>
                      <div>
                        <div class="font-bold">
                          {{ singkatNama(user.name) }}
                        </div>

                        <div class="text-sm opacity-50">
                          @{{ user.username }}
                        </div>
                      </div>
                    </div>
                  </td>
                  <td class="text-center">
                    <button
                      class="font-bold"
                      :class="{
                        tooltip:
                          user.id !== $store.state.user.currentUser.id &&
                          $store.state.user.currentUser.role ===
                            'administrator',
                      }"
                      data-tip="KLIK UNTUK MENGUBAH"
                      :disabled="
                        $store.state.user.currentUser.role !==
                          'administrator' ||
                        user.id === $store.state.user.currentUser.id
                      "
                      @click="
                        roleModal.show = true
                        selectedUsers = { ...user }
                        selectedUsers.oldRole = selectedUsers.role
                      "
                    >
                      <div
                        class="badge align-middle select-none uppercase"
                        :class="{
                          'badge-error': user.role === 'administrator',
                          'badge-warning': user.role === 'moderator',
                          'badge-outline': user.role === 'member',
                        }"
                      >
                        <b>{{ user.role }}</b>
                      </div>
                    </button>
                  </td>
                  <td class="text-center">
                    <button
                      class="font-bold tooltip"
                      data-tip="KLIK UNTUK MENGUBAH"
                      @click="
                        tipeModal.show = true
                        selectedUsers = { ...user }
                        selectedUsers.oldTipe = selectedUsers.tipe
                      "
                    >
                      <div class="badge badge-primary select-none uppercase">
                        <b>{{ user.tipe }} </b>
                      </div>
                    </button>
                  </td>
                  <td class="text-center">
                    <div class="flex flex-row justify-center">
                      <div v-for="journey in user.journeys" :key="journey.id">
                        <div
                          :data-tip="journey.struktur + ' ' + journey.divisi"
                          class="tooltip tooltip-top tooltip-primary align-middle uppercase"
                        >
                          <img
                            v-if="!(journey.tim == 'pengurus')"
                            :src="`/assets/img/tim/${journey.tim}.png`"
                            class="w-7 px-1"
                          />
                          <svg
                            v-else
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            class="w-7 px-1"
                          >
                            <path fill="none" d="M0 0h24v24H0z" />
                            <path
                              d="M3.783 2.826L12 1l8.217 1.826a1 1 0 0 1 .783.976v9.987a6 6 0 0 1-2.672 4.992L12 23l-6.328-4.219A6 6 0 0 1 3 13.79V3.802a1 1 0 0 1 .783-.976zM12 13.5l2.939 1.545-.561-3.272 2.377-2.318-3.286-.478L12 6l-1.47 2.977-3.285.478 2.377 2.318-.56 3.272L12 13.5z"
                              class="fill-primary"
                            />
                          </svg>
                        </div>
                      </div>

                      <button
                        v-if="user.tipe !== 'outsider'"
                        data-tip="SESUAIKAN JOURNEY"
                        class="btn btn-xs m-0 p-0 btn-primary tooltip font-bold"
                        :class="{
                          tooltip: user.id !== $store.state.user.currentUser.id,
                        }"
                        @click="
                          journeyModal.show = true
                          selectedUsers = user
                        "
                      >
                        <i class="ri-pencil-line leading-none p-1"></i>
                      </button>
                    </div>
                  </td>
                  <td class="text-right">
                    <button class="btn btn-sm btn-error btn-outline">
                      Banned
                    </button>
                  </td>
                </tr>
              </tbody>
              <tbody>
                <tr v-if="$fetchState.pending">
                  <td colspan="5">
                    <div
                      class="text-center text-primary/80 tracking-widest font-light bg-base-100 rounded-lg py-5"
                    >
                      <LoaderModel6 :size="32" />
                    </div>
                  </td>
                </tr>
                <tr v-if="users.total === 0 && !$fetchState.pending">
                  <td colspan="5">
                    <div
                      class="w-full text-center text-primary/80 tracking-widest font-light bg-base-100 rounded-lg py-5"
                    >
                      Tidak ada data.
                    </div>
                  </td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="5" class="bg-base-300">
                    <Pagination
                      v-if="!$fetchState.pending"
                      :page="users.current_page"
                      :total="users.last_page"
                    />
                  </th>
                </tr>
              </tfoot>
            </table>

            <PengaturanUserRoleModal
              :role-modal="roleModal"
              :selected-users="selectedUsers"
              :old-role="selectedUsers.oldRole"
            />

            <PengaturanUserTipeModal
              :tipe-modal="tipeModal"
              :selected-users="selectedUsers"
              :old-tipe="selectedUsers.oldTipe"
            />

            <PengaturanUserJourneyModal
              :journey-modal="journeyModal"
              :selected-users="selectedUsers"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PengaturanUserPage',
  layout: 'pengaturan',
  middleware: ['authenticated', 'moderator'],

  data() {
    return {
      users: [],
      selectedUsers: [],

      filters: {
        page: 1,
        role: '',
        tipe: '',
        search: '',
      },

      roleModal: {
        show: false,
        loading: false,
      },

      tipeModal: {
        show: false,
        loading: false,
      },

      journeyModal: {
        show: false,
        loading: false,
      },

      state: {
        isFetching: '',
        error: '',
      },
    }
  },

  async fetch() {
    await this.$axios
      .get(`${this.$config.apiURL}/user/all`, {
        params: {
          page: this.filters.page,
          q: this.filters.search,
          role: this.filters.role,
          tipe: this.filters.tipe,
        },
      })
      .then((response) => {
        this.users = response.data
      })
      .catch(() => {
        this.users = null
      })
  },

  methods: {
    async changeRole(user) {
      this.roleModal.loading = true
      await this.$axios
        .patch(`${this.$config.apiURL}/user/role`, {
          user_id: user.id,
          role: user.role,
        })
        .then((response) => {
          this.users.data.find((x) => x.id === user.id).role = user.role
          this.roleModal.show = false
        })
        .catch((error) => {
          this.roleModal.error = error.response.data
        })
      this.roleModal.loading = false
    },

    async changeTipe(user) {
      this.tipeModal.loading = true
      await this.$axios
        .patch(`${this.$config.apiURL}/user/tipe`, {
          user_id: user.id,
          tipe: user.tipe,
        })
        .then((response) => {
          this.users.data.find((x) => x.id === user.id).tipe = user.tipe
          this.tipeModal.show = false
        })
        .catch((error) => {
          this.tipeModal.error = error.response.data
        })
      this.tipeModal.loading = false
    },
  },
}
</script>