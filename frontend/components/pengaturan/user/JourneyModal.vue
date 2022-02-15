<template>
  <div>
    <input
      id="journeyModal"
      :checked="journeyModal.show"
      type="checkbox"
      class="modal-toggle"
    />
    <div class="modal">
      <div class="modal-box">
        <div
          id="top"
          class="modal-header grid grid-cols-12 bg-base-300 rounded-xl p-5 mb-5"
        >
          <div class="col-span-11 font-bold text-xl">
            <span class="font-medium text-white/50">JOURNEY OF - </span>
            {{ selectedUsers.name ? singkatNama(selectedUsers.name) : '' }}
          </div>
          <div class="col-span-1 text-right">
            <button
              class="btn btn-sm btn-error btn-outline h-full"
              @click="close()"
            >
              <i class="ri-close-line"></i>
            </button>
          </div>
        </div>

        <div
          v-for="(journey, index) in selectedUsers.journeys"
          :key="journey.id"
        >
          <div
            v-if="!(index == 0)"
            class="h-10 ml-16 border-l-2 border-primary/10"
          ></div>
          <div
            class="card bg-base-100 shadow-lg shadow-black/20 transition ease-in-out duration-300 hover:shadow-lg hover:shadow-black border-2 border-primary/10 relative select-none z-10"
          >
            <div :id="journey.id" class="flex bg-base-300/50 p-5">
              <img
                v-if="!(journey.tim == 'pengurus')"
                :src="`/assets/img/tim/${journey.tim}.png`"
                class="w-28 pr-3"
              />
              <svg
                v-else
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                class="w-28 pr-3"
              >
                <path fill="none" d="M0 0h24v24H0z" />
                <path
                  d="M3.783 2.826L12 1l8.217 1.826a1 1 0 0 1 .783.976v9.987a6 6 0 0 1-2.672 4.992L12 23l-6.328-4.219A6 6 0 0 1 3 13.79V3.802a1 1 0 0 1 .783-.976zM12 13.5l2.939 1.545-.561-3.272 2.377-2.318-3.286-.478L12 6l-1.47 2.977-3.285.478 2.377 2.318-.56 3.272L12 13.5z"
                  class="fill-white"
                />
              </svg>
              <div class="card-title my-auto">
                <div class="font-light text-lg tracking-widest uppercase">
                  <div
                    v-if="journey.struktur"
                    class="badge badge-primary align-middle font-bold"
                  >
                    {{ journey.struktur.replace('_', ' ') }}
                  </div>
                  {{ journey.divisi }}
                </div>
                <span class="uppercase tracking-widest text-3xl">
                  {{ journey.tim }}
                </span>
                <div class="font-light text-lg tracking-widest">
                  {{ bulan(journey.tanggal_gabung) }},
                  <b>{{ tahun(journey.tanggal_gabung) }}</b>
                  <button
                    class="btn btn-error btn-outline btn-xs place-content-center"
                    :class="{
                      loading:
                        state.isDeleting && state.deletingId == journey.id,
                    }"
                    @click="hapusJourney(journey.id)"
                  >
                    Hapus
                    <i class="ri-delete-bin-line pl-2 ri-xs leading-none"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <hr class="my-10 border-white/30" />

        <div>
          <form
            id="newJourneyForm"
            class="w-full"
            @submit.prevent="tambahJourney"
          >
            <div class="grid grid-cols-2 gap-3">
              <div
                class="form-control col-span-2 border-2 border-primary/20 rounded-xl p-3"
              >
                <label class="cursor-pointer label">
                  <span class="label-text tracking-widest">PENGURUS</span>
                  <input
                    v-model="new_journey.pengurus"
                    type="checkbox"
                    class="checkbox"
                    @change="pengurus()"
                  />
                </label>
              </div>
              <div class="w-full">
                <label class="label">
                  <span class="label-text uppercase tracking-widest"
                    >Struktur</span
                  >
                </label>
                <select
                  v-model="new_journey.struktur"
                  class="select select-bordered w-full"
                  :class="state.error.struktur ? 'input-error' : ''"
                  :required="new_journey.pengurus"
                  @onchange="struktur()"
                  @input="
                    state.error.struktur ? (state.error.struktur = '') : ''
                  "
                >
                  <option v-if="!new_journey.pengurus" value="">
                    Staff/Anggota
                  </option>
                  <option v-if="!new_journey.pengurus" value="ketua">
                    Ketua Tim
                  </option>
                  <option v-if="new_journey.pengurus" value="ketua ukm">
                    Ketua UKM
                  </option>
                  <option v-if="new_journey.pengurus" value="wakil ketua ukm">
                    Wakil Ketua UKM
                  </option>
                  <option v-if="new_journey.pengurus" value="koordinator">
                    Koordinator
                  </option>
                  <option v-if="new_journey.pengurus" value="kepala divisi">
                    Kepala Divisi
                  </option>
                </select>
                <InputErrorLabel :error="state.error.struktur" />
              </div>
              <div class="w-full">
                <label class="label">
                  <span class="label-text uppercase tracking-widest"
                    >Divisi</span
                  >
                </label>
                <select
                  v-model="new_journey.divisi"
                  class="select select-bordered w-full"
                  required
                  :disabled="ketuadanwakil"
                  :class="state.error.divisi ? 'input-error' : ''"
                  @input="state.error.divisi ? (state.error.divisi = '') : ''"
                >
                  <option v-if="!ketuadanwakil" value="programmer">
                    [Teknis] Programmer
                  </option>
                  <option v-if="!ketuadanwakil" value="elektro">
                    [Teknis] Elektro
                  </option>
                  <option v-if="!ketuadanwakil" value="mekanik">
                    [Teknis] Mekanik
                  </option>
                  <option v-if="!ketuadanwakil" value="sekretaris">
                    [Non-Teknis] Sekretaris
                  </option>
                  <option v-if="!ketuadanwakil" value="bendahara">
                    [Non-Teknis] Bendahara
                  </option>
                  <option v-if="!ketuadanwakil" value="internal">
                    [Non-Teknis] Internal
                  </option>
                  <option v-if="!ketuadanwakil" value="media">
                    [Non-Teknis] Media
                  </option>
                  <option
                    v-if="new_journey.pengurus && !ketuadanwakil"
                    value="teknis"
                  >
                    Teknis
                  </option>
                  <option
                    v-if="new_journey.pengurus && !ketuadanwakil"
                    value="non-teknis"
                  >
                    Non-Teknis
                  </option>
                </select>
                <InputErrorLabel :error="state.error.divisi" />
              </div>
              <div class="w-full">
                <label class="label">
                  <span class="label-text uppercase tracking-widest">Tim</span>
                </label>
                <select
                  v-model="new_journey.tim"
                  class="select select-bordered w-full"
                  :disabled="new_journey.pengurus"
                  required
                  :class="state.error.tim ? 'input-error' : ''"
                  @input="state.error.tim ? (state.error.tim = '') : ''"
                >
                  <option value="sambergeni">[KRPAI] Sambergeni</option>
                  <option value="maladi">[KRSBI] Maladi</option>
                  <option value="werkudara">[KRAI] Werkudara</option>
                  <option value="sriwedari">[KRSTI] Sriwedari</option>
                  <option value="dewisri">[KRTMI] Dewisri</option>
                  <option value="jaladara">[ROV] Jaladara</option>
                </select>
                <InputErrorLabel :error="state.error.tim" />
              </div>
              <div class="form-control w-full">
                <label class="label">
                  <span class="label-text uppercase tracking-widest"
                    >Tanggal Gabung</span
                  >
                </label>
                <input
                  v-model="new_journey.tanggal_gabung"
                  type="date"
                  class="input input-bordered text-white"
                  required
                  :class="state.error.tanggal_gabung ? 'input-error' : ''"
                  @input="
                    state.error.tanggal_gabung
                      ? (state.error.tanggal_gabung = '')
                      : ''
                  "
                />
                <InputErrorLabel :error="state.error.tanggal_gabung" />
              </div>
            </div>
            <button
              class="btn btn-primary w-full tracking-widest mt-7"
              :class="{ loading: state.isCreating }"
              type="submit"
            >
              Tambah Journey <i class="ri-add-circle-line ml-1"></i>
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { format, getYear } from 'date-fns'
import { id } from 'date-fns/locale'

export default {
  name: 'PengaturanUserJourneyModalComponent',
  props: {
    selectedUsers: {
      type: Object,
      default: () => ({}),
    },
    journeyModal: {
      type: Object,
      default: () => ({
        state: '',
        show: false,
        loading: false,
      }),
    },
  },

  data() {
    return {
      new_journey: {
        tim: '',
        struktur: '',
        divisi: '',
        tanggal_gabung: '',
        pengurus: false,
      },

      state: {
        isCreating: false,
        isDeleting: false,
        deletingId: '',
        error: {},
      },
    }
  },

  computed: {
    ketuadanwakil() {
      return (
        this.new_journey.struktur === 'ketua ukm' ||
        this.new_journey.struktur === 'wakil ketua ukm'
      )
    },
  },

  methods: {
    bulan(tanggal) {
      return format(new Date(tanggal), 'MMMM', { locale: id })
    },
    tahun(tanggal) {
      return getYear(new Date(tanggal))
    },
    close() {
      this.new_journey = {
        tim: '',
        struktur: '',
        divisi: '',
        tanggal_gabung: '',
      }
      this.$parent.journeyModal.show = false
    },
    pengurus() {
      this.clear()
      if (this.new_journey.pengurus) {
        this.new_journey.tim = 'pengurus'
      } else {
        this.new_journey.tim = ''
      }
    },
    struktur() {
      if (
        this.new_journey.struktur === 'ketua ukm' ||
        this.new_journey.struktur === 'wakil ketua ukm'
      ) {
        this.new_journey.divisi = ''
      } else {
        this.new_journey.divisi = ''
      }
    },
    clear() {
      this.new_journey.tim = ''
      this.new_journey.struktur = ''
      this.new_journey.divisi = ''
      this.new_journey.tanggal_gabung = ''
    },
    async tambahJourney() {
      this.state.isCreating = true
      await this.$axios
        .post(`${this.$config.apiURL}/journey`, {
          user_id: this.selectedUsers.id,
          tim: this.new_journey.tim,
          divisi: this.new_journey.divisi,
          struktur: this.new_journey.struktur,
          tanggal_gabung: this.new_journey.tanggal_gabung,
        })
        .then((response) => {
          this.$parent.users.data.find(
            (x) => x.id === this.selectedUsers.id
          ).journeys = response.data
          window.location.href = '#top'
        })
        .catch((error) => {
          this.state.error = error.response.data
        })
      this.state.isCreating = false
    },
    async hapusJourney(journeyid) {
      this.state.deletingId = journeyid
      this.state.isDeleting = true
      await this.$axios
        .delete(`${this.$config.apiURL}/journey`, {
          data: {
            id: journeyid,
          },
        })
        .then((response) => {
          this.$parent.users.data.find(
            (x) => x.id === this.selectedUsers.id
          ).journeys = response.data
          window.location.href = '#top'
        })
        .catch((error) => {
          this.state.error = error.response.data
        })
      this.state.isDeleting = false
    },
  },
}
</script>
