<template>
  <div>
    <LoaderModel6 v-if="$fetchState.pending" size="32" />

    <div v-else class="overflow-x-auto">
      <div
        v-if="recruits.length === 0"
        class="text-center text-primary/80 tracking-widest font-light bg-base-100 rounded-lg py-5"
      >
        Tidak ada data.
      </div>
      <table v-if="recruits.length > 0" class="table w-full">
        <thead>
          <tr>
            <th class="bg-base-300">Nama</th>
            <th class="bg-base-300">Prioritas</th>
            <th class="bg-base-300">Alternatif</th>
            <th class="bg-base-300"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="recruit in recruits" :key="recruit.id">
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
                    {{ recruit.prodi }}
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
                  <span class="capitalize"> {{ recruit.tim_alternatif }}</span>
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
                class="flex items-center"
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
                class="items-center text-center w-full"
              >
                -
              </div>
            </td>

            <th>
              <div class="btn-group">
                <button
                  class="btn btn-sm btn-primary p-0"
                  @click="
                    selectedRecruits = recruit
                    detil.modal = true
                  "
                >
                  <div data-tip="Detil" class="tooltip tooltip-primary">
                    <i class="ri-eye-line m-3"></i>
                  </div>
                </button>
                <button
                  class="btn btn-sm btn-error p-0"
                  :disabled="recruit.status === 'ditolak'"
                  @click="
                    selectedRecruits = recruit
                    confirm.modal = true
                    confirm.state = 'tolak'
                  "
                >
                  <div data-tip="Tolak" class="tooltip tooltip-error">
                    <i class="ri-close-line text-white m-3"></i>
                  </div>
                </button>
                <button
                  class="btn btn-sm btn-success p-0"
                  :disabled="recruit.status === 'diterima'"
                  @click="
                    selectedRecruits = recruit
                    confirm.modal = true
                    confirm.state = 'terima'
                    confirm.tim = recruit.tim_prioritas
                    confirm.divisi = recruit.divisi_prioritas
                  "
                >
                  <div data-tip="Terima" class="tooltip tooltip-success">
                    <i class="ri-check-line text-white m-3"></i>
                  </div>
                </button>
              </div>
            </th>
          </tr>
        </tbody>
      </table>
      <PengaturanRekrutmenDataConfirmModal
        :confirm="confirm"
        :selected-recruits="selectedRecruits"
      />

      <PengaturanRekrutmenDataDetilModal
        :detil="detil"
        :selected-recruits="selectedRecruits"
      />
    </div>
  </div>
</template>

<script>
export default {
  name: 'PengaturanRekrutmenDataComponent',

  data() {
    return {
      recruits: '',
      selectedRecruits: {
        user: {
          name: '',
        },
      },

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

      state: {
        isFetching: '',
        error: '',
      },
    }
  },

  async fetch() {
    this.state.isFetching = true
    await this.$axios
      .get(`${this.$config.apiURL}/recruit`)
      .then((response) => {
        this.recruits = response.data.data
      })
      .catch(() => {
        this.recruits = null
      })
    this.state.isFetching = false
  },

  methods: {
    async tolakUser(recruit) {
      this.confirm.loading = true
      await this.$axios
        .patch(`${this.$config.apiURL}/recruit/tolak`, {
          id: recruit.id,
        })
        .then((response) => {
          this.recruits.find((x) => x.id === recruit.id).status = 'ditolak'
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
          this.recruits.find((x) => x.id === recruit.id).status = 'diterima'
          this.recruits.find((x) => x.id === recruit.id).tim_diterima =
            this.confirm.tim
          this.recruits.find((x) => x.id === recruit.id).divisi_diterima =
            this.confirm.divisi
          this.confirm.modal = false
        })
        .catch((error) => {
          this.confirm.error = error.response.data
        })
      this.confirm.loading = false
    },
  },
}
</script>