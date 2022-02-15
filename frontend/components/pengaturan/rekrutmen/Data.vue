<template>
  <div>
    <div class="mb-5">
      <div class="grid grid-cols-12 gap-3">
        <div class="col-span-2">
          <div class="form-control">
            <select
              v-model="filters.batch"
              class="select select-bordered w-full max-w-xs"
              @change="$fetch()"
            >
              <option value="">Semua batch {{ index }}</option>
              <option
                v-for="index in setting['recruit.batch']"
                :key="index"
                :value="index"
              >
                Batch {{ index }}
              </option>
            </select>
          </div>
        </div>
        <div class="col-span-3">
          <div class="form-control">
            <select
              v-model="filters.status"
              class="select select-bordered w-full max-w-xs"
              @change="$fetch()"
            >
              <option value="">Status: Semua</option>
              <option value="diproses">Status: Diproses</option>
              <option value="diterima">Status: Diterima</option>
              <option value="ditolak">Status: Ditolak</option>
            </select>
          </div>
        </div>
        <div class="col-span-4">
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
        <div class="col-span-3 pl-5 border-l-2 border-white/30">
          <button
            class="btn btn-outline tracking-wider transition-all duration-300 ease-in-out hover:tracking-widest text-white w-full"
            :disabled="filters.batch !== setting['recruit.batch']"
            :class="
              filters.batch !== setting['recruit.batch']
                ? 'btn-success opacity-60'
                : 'btn-info'
            "
            @click="finalisasi.modal = true"
          >
            <span v-if="filters.batch === setting['recruit.batch']">
              Finalisasi
            </span>
            <i
              v-if="filters.batch !== setting['recruit.batch']"
              class="ri-check-line ml-2"
            ></i>
          </button>
        </div>
      </div>
    </div>

    <div>
      <div class="overflow-x-auto">
        <table class="table w-full">
          <thead>
            <tr>
              <th class="bg-base-300 w-4/12">Nama</th>
              <th class="bg-base-300 w-3/12 text-center">Prioritas</th>
              <th class="bg-base-300 w-3/12 text-center">Alternatif</th>
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

          <tbody v-if="recruits.total > 0 && !$fetchState.pending">
            <tr v-for="recruit in recruits.data" :key="recruit.id">
              <td>
                <div class="flex items-center space-x-3">
                  <div class="avatar">
                    <div class="w-12 h-12 mask mask-squircle">
                      <img :src="recruit.pas_photo" />
                    </div>
                  </div>
                  <div>
                    <div class="font-bold">
                      {{ singkatNama(recruit.user.name) }}
                      <div
                        v-if="recruit.status !== 'diproses'"
                        class="badge uppercase ml-2 align-middle"
                        :class="{
                          'badge-error': recruit.status === 'ditolak',
                          'badge-success': recruit.status === 'diterima',
                        }"
                      >
                        <i
                          v-if="recruit.status === 'ditolak'"
                          class="ri-close-line mr-1"
                        ></i>
                        <i
                          v-if="recruit.status === 'diterima'"
                          class="ri-check-line mr-1"
                        ></i>
                        {{ recruit.status }}
                      </div>
                    </div>

                    <div class="text-sm opacity-50">
                      @{{ recruit.user.username }}
                    </div>
                  </div>
                </div>
              </td>
              <td v-if="recruit.status === 'diproses'">
                <div class="flex items-center">
                  <img
                    :src="`/assets/img/tim/${recruit.tim_prioritas}.png`"
                    class="w-16 pr-2"
                  />
                  <div>
                    <span class="capitalize"> {{ recruit.tim_prioritas }}</span>
                    <br />
                    <span class="badge badge-primary capitalize">{{
                      recruit.divisi_prioritas
                    }}</span>
                  </div>
                </div>
              </td>
              <td v-if="recruit.status === 'diproses'">
                <div class="flex items-center">
                  <img
                    :src="`/assets/img/tim/${recruit.tim_alternatif}.png`"
                    class="w-16 pr-2"
                  />
                  <div>
                    <span class="capitalize">
                      {{ recruit.tim_alternatif }}</span
                    >
                    <br />
                    <span class="badge badge-primary capitalize">{{
                      recruit.divisi_alternatif
                    }}</span>
                  </div>
                </div>
              </td>

              <td v-if="recruit.status !== 'diproses'" colspan="2">
                <div
                  v-if="recruit.status === 'diterima'"
                  class="flex items-center w-full justify-center"
                >
                  <img
                    :src="`/assets/img/tim/${recruit.tim_diterima}.png`"
                    class="w-16 pr-2"
                  />
                  <div>
                    <span class="capitalize"> {{ recruit.tim_diterima }}</span>
                    <br />
                    <span class="badge badge-primary capitalize">{{
                      recruit.divisi_diterima
                    }}</span>
                  </div>
                </div>
                <div
                  v-if="recruit.status === 'ditolak'"
                  class="items-center text-center w-full justify-center"
                >
                  -
                </div>
              </td>

              <th>
                <div class="btn-group justify-center">
                  <button
                    class="btn btn-sm btn-primary p-0"
                    @click="
                      selectedRecruits = recruit
                      detil.modal = true
                    "
                  >
                    <div data-tip="Detil" class="tooltip tooltip-primary">
                      <i class="ri-eye-line m-2"></i>
                    </div>
                  </button>
                  <button
                    class="btn btn-sm btn-error p-0"
                    :disabled="
                      recruit.status === 'ditolak' ||
                      filters.batch !== setting['recruit.batch']
                    "
                    @click="
                      selectedRecruits = recruit
                      confirm.modal = true
                      confirm.state = 'tolak'
                    "
                  >
                    <div data-tip="Tolak" class="tooltip tooltip-error">
                      <i class="ri-close-line text-white m-2"></i>
                    </div>
                  </button>
                  <button
                    class="btn btn-sm btn-success p-0"
                    :disabled="
                      recruit.status === 'diterima' ||
                      filters.batch !== setting['recruit.batch']
                    "
                    @click="
                      selectedRecruits = recruit
                      confirm.modal = true
                      confirm.state = 'terima'
                      confirm.tim = recruit.tim_prioritas
                      confirm.divisi = recruit.divisi_prioritas
                    "
                  >
                    <div data-tip="Terima" class="tooltip tooltip-success">
                      <i class="ri-check-line text-white m-2"></i>
                    </div>
                  </button>
                </div>
              </th>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <th colspan="4" class="bg-base-300">
                <Pagination
                  :page="recruits.current_page"
                  :total="recruits.last_page"
                />
              </th>
            </tr>
          </tfoot>
        </table>

        <div
          v-if="$fetchState.pending"
          class="text-center text-primary/80 tracking-widest font-light bg-base-100 rounded-lg py-5"
        >
          <LoaderModel6 :size="32" />
        </div>
        <div
          v-if="recruits.total === 0 && !$fetchState.pending"
          class="w-full text-center text-primary/80 tracking-widest font-light bg-base-100 rounded-lg py-5"
        >
          Tidak ada data.
        </div>

        <PengaturanRekrutmenDataConfirmModal
          :confirm="confirm"
          :selected-recruits="selectedRecruits"
        />

        <PengaturanRekrutmenDataFinalisasiModal
          :finalisasi="finalisasi"
          :batch="setting['recruit.batch']"
        />

        <PengaturanRekrutmenDataDetilModal
          :detil="detil"
          :selected-recruits="selectedRecruits"
        />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PengaturanRekrutmenDataComponent',

  data() {
    return {
      recruits: [],
      selectedRecruits: {
        user: {
          name: '',
        },
      },

      filters: {
        page: 1,
        search: '',
        status: '',
        batch: 0,
      },

      setting: [],

      detil: {
        modal: false,
      },

      confirm: {
        state: '',
        modal: false,
        loading: false,
        tim: '',
        divisi: '',
      },

      finalisasi: {
        loading: false,
        modal: false,
        error: '',
      },

      state: {
        isFetching: '',
        error: '',
      },
    }
  },

  async fetch() {
    await this.$axios
      .get(`${this.$config.apiURL}/setting/get?name=recruit.batch`)
      .then((response) => {
        this.setting['recruit.batch'] = parseInt(response.data['recruit.batch'])
      })

    if (this.filters.batch === 0) {
      this.filters.batch = this.setting['recruit.batch']
    }

    await this.$axios
      .get(`${this.$config.apiURL}/recruit`, {
        params: {
          page: this.filters.page,
          search: this.filters.search,
          batch: this.filters.batch,
          status: this.filters.status,
        },
      })
      .then((response) => {
        this.recruits = response.data
      })
      .catch(() => {
        this.recruits = null
      })
  },

  methods: {
    async tolakUser(recruit) {
      this.confirm.loading = true
      await this.$axios
        .patch(`${this.$config.apiURL}/recruit/tolak`, {
          id: recruit.id,
        })
        .then((response) => {
          this.recruits.data.find((x) => x.id === recruit.id).status = 'ditolak'
          this.confirm.modal = false
        })
        .catch((error) => {
          this.confirm.error = error.response.data
        })
      this.confirm.loading = false
    },

    async terimaUser(recruit) {
      this.confirm.loading = true
      await this.$axios
        .patch(`${this.$config.apiURL}/recruit/terima`, {
          id: recruit.id,
          tim: this.confirm.tim,
          divisi: this.confirm.divisi,
        })
        .then((response) => {
          this.recruits.data.find((x) => x.id === recruit.id).status =
            'diterima'
          this.recruits.data.find((x) => x.id === recruit.id).tim_diterima =
            this.confirm.tim
          this.recruits.data.find((x) => x.id === recruit.id).divisi_diterima =
            this.confirm.divisi
          this.confirm.modal = false
        })
        .catch((error) => {
          this.confirm.error = error.response.data
        })
      this.confirm.loading = false
    },

    async finalisasiRekrutmen() {
      this.finalisasi.loading = true
      await this.$axios
        .post(`${this.$config.apiURL}/recruit/finalize`)
        .then((response) => {
          this.filters.batch = this.setting['recruit.batch'] + 1
          this.$fetch()
          this.finalisasi.modal = false
        })
        .catch((error) => {
          this.finalisasi.error = error.response.data
        })
      this.finalisasi.loading = false
    },
  },
}
</script>