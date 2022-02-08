<template>
  <div>
    <Navbar />

    <div
      class="h-56 rounded-b-[5rem] bg-base-300 mt-[-9rem] shadow-2xl shadow-black/70"
    >
      <div
        class="text-center pt-32 text-4xl font-extralight tracking-widest uppercase"
      >
        Pengaturan
      </div>
    </div>
    <div class="px-24 pt-14 grid grid-cols-12 gap-10">
      <div class="col-span-4">
        <SidebarPengaturan />
      </div>
      <div class="col-span-8 bg-base-200 rounded-xl font-semibold">
        <div class="tabs tabs-boxed bg-base-300">
          <a
            class="tab transition-all ease-in-out duration-300"
            :class="{ 'tab-active': selectedTab === 'data' }"
            @click="selectedTab = 'data'"
            >Data</a
          >
          <a
            class="tab transition-all ease-in-out duration-300"
            :class="{ 'tab-active': selectedTab === 'pengaturan' }"
            @click="selectedTab = 'pengaturan'"
            >Pengaturan</a
          >
        </div>
        <div class="p-8">
          <div v-if="selectedTab === 'data'" class="overflow-x-auto">
            <table class="table w-full">
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
                            <i class="ri-close-line mr-1"></i>
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
                        <span class="capitalize">
                          {{ recruit.tim_prioritas }}</span
                        >
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
                      class="flex items-center"
                    >
                      <img
                        :src="`/assets/img/tim/${recruit.tim_diterima}.png`"
                        class="w-16 pr-2"
                      />
                      <div>
                        <span class="capitalize">
                          {{ recruit.tim_diterima }}</span
                        >
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
                      <label
                        for="detilModal"
                        class="btn btn-sm btn-primary p-0"
                        @click="selectedRecruits = recruit"
                      >
                        <div data-tip="Detil" class="tooltip tooltip-primary">
                          <i class="ri-eye-line m-3"></i>
                        </div>
                      </label>
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
          </div>
        </div>
      </div>
    </div>

    <input
      id="confirmModal"
      v-model="confirm.modal"
      type="checkbox"
      class="modal-toggle"
    />
    <div class="modal">
      <div class="modal-box">
        <p>
          Apakah kamu yakin akan
          {{ confirm.state === 'tolak' ? 'menolak' : 'menerima' }}
          <b>{{ selectedRecruits.user ? selectedRecruits.user.name : '' }}</b
          >?
        </p>

        <hr class="my-5 border-white/30" />

        <div
          v-if="confirm.state === 'terima'"
          class="flex flex-row w-full gap-5 pb-5"
        >
          <div class="w-full">
            <label class="label">
              <span class="label-text uppercase tracking-widest">Tim</span>
            </label>
            <select
              v-model="confirm.tim"
              class="select select-bordered w-full"
              required
            >
              <option value="sambergeni">[KRPAI] Sambergeni</option>
              <option value="maladi">[KRSBI] Maladi</option>
              <option value="werkudara">[KRAI] Werkudara</option>
              <option value="sriwedari">[KRSTI] Sriwedari</option>
              <option value="dewisri">[KRTMI] Dewisri</option>
              <option value="jaladara">[ROV] Jaladara</option>
            </select>
          </div>
          <div class="w-full">
            <label class="label">
              <span class="label-text uppercase tracking-widest">Divisi</span>
            </label>
            <select
              v-model="confirm.divisi"
              class="select select-bordered w-full"
              required
            >
              <option value="programmer">[Teknis] Programmer</option>
              <option value="elektro">[Teknis] Elektro</option>
              <option value="mekanik">[Teknis] Mekanik</option>
              <option value="sekretaris">[Non-Teknis] Sekretaris</option>
              <option value="bendahara">[Non-Teknis] Bendahara</option>
              <option value="internal">[Non-Teknis] Internal</option>
              <option value="media">[Non-Teknis] Media</option>
            </select>
          </div>
        </div>

        <div class="modal-action">
          <button
            class="btn btn-sm btn-outline"
            :class="{
              loading: confirm.loading === true,
              'btn-error': confirm.state === 'tolak',
              'btn-success': confirm.state === 'terima',
            }"
            @click="
              confirm.state === 'tolak'
                ? tolakUser(selectedRecruits)
                : terimaUser(selectedRecruits)
            "
          >
            <span> Iya, {{ confirm.state }} </span>
          </button>
          <label for="confirmModal" class="btn btn-sm btn-outline">Batal</label>
        </div>
      </div>
    </div>

    <input id="detilModal" type="checkbox" class="modal-toggle" />
    <div class="modal">
      <div class="modal-box w-6/12 max-w-full">
        <div class="modal-header grid grid-cols-12 bg-base-300 rounded-xl p-5">
          <div class="col-span-11 font-bold text-xl">
            <span class="font-medium text-white/50">{{
              selectedRecruits.nim
            }}</span>
            |
            {{ selectedRecruits.user.name }}
          </div>
          <div class="col-span-1 text-right">
            <label
              for="detilModal"
              class="btn btn-sm btn-error btn-outline h-full"
            >
              <i class="ri-close-line"></i>
            </label>
          </div>
        </div>

        <div class="grid grid-cols-12 gap-5 mt-5">
          <div class="col-span-6">
            <div class="avatar w-full">
              <img :src="selectedRecruits.pas_photo" class="rounded-xl" />
            </div>

            <div class="grid grid-cols-2 gap-5 my-5">
              <a
                :href="selectedRecruits.krs"
                target="_blank"
                class="btn btn-primary btn-sm"
                >KRS <i class="ri-external-link-line ml-1"></i
              ></a>
              <a
                :href="selectedRecruits.karmas"
                target="_blank"
                class="btn btn-primary btn-sm"
                >KARMAS <i class="ri-external-link-line ml-1"></i
              ></a>
            </div>

            <hr class="border-primary/50 mt-12" />

            <div class="flex bg-base-300/50 p-5 rounded-xl my-5">
              <img
                :src="`/assets/img/tim/${selectedRecruits.tim_prioritas}.png`"
                class="w-28 pr-3"
              />
              <div class="card-title my-auto">
                <div class="font-light text-lg tracking-widest uppercase">
                  <div class="badge badge-primary align-middle font-bold">
                    pilihan prioritas
                  </div>
                </div>
                <span class="uppercase tracking-widest text-3xl">
                  {{ selectedRecruits.tim_prioritas }}
                </span>
                <div class="font-light text-lg tracking-widest uppercase">
                  {{ selectedRecruits.divisi_prioritas }}
                </div>
              </div>
            </div>

            <div class="flex bg-base-300/50 p-5 rounded-xl my-5">
              <img
                :src="`/assets/img/tim/${selectedRecruits.tim_alternatif}.png`"
                class="w-28 pr-3"
              />
              <div class="card-title my-auto">
                <div class="font-light text-lg tracking-widest uppercase">
                  <div class="badge badge-primary align-middle font-bold">
                    pilihan alternatif
                  </div>
                </div>
                <span class="uppercase tracking-widest text-3xl">
                  {{ selectedRecruits.tim_alternatif }}
                </span>
                <div class="font-light text-lg tracking-widest uppercase">
                  {{ selectedRecruits.divisi_alternatif }}
                </div>
              </div>
            </div>

            <hr class="border-primary/50 mb-10" />

            <div class="mt-5">
              <div class="form-control">
                <label class="label">
                  <span class="label-text uppercase tracking-widest"
                    >Alasan Memilih</span
                  >
                </label>
                <textarea
                  :value="selectedRecruits.alasan"
                  class="textarea h-52 textarea-bordered"
                  disabled
                ></textarea>
              </div>
            </div>
          </div>
          <div class="col-span-6 bg-base-300 rounded-xl p-5">
            <div class="form-control mb-5">
              <label class="label">
                <span class="label-text uppercase tracking-widest">Prodi</span>
              </label>
              <input
                class="input input-bordered"
                :value="selectedRecruits.prodi"
                disabled
              />
            </div>

            <div class="form-control mb-5">
              <label class="label">
                <span class="label-text uppercase tracking-widest"
                  >Fakultas</span
                >
              </label>
              <input
                class="input input-bordered"
                :value="selectedRecruits.fakultas"
                disabled
              />
            </div>

            <div class="mb-5 grid grid-cols-2 gap-5">
              <div class="form-control">
                <label class="label">
                  <span class="label-text uppercase tracking-widest"
                    >Tempat Lahir</span
                  >
                </label>
                <input
                  class="input input-bordered"
                  :value="selectedRecruits.tempat_lahir"
                  disabled
                />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text uppercase tracking-widest"
                    >Tanggal Lahir</span
                  >
                </label>
                <input
                  class="input input-bordered"
                  :value="
                    selectedRecruits.tanggal_lahir
                      ? tanggalLahir(selectedRecruits.tanggal_lahir)
                      : ''
                  "
                  disabled
                />
              </div>
            </div>

            <div class="mb-5 grid grid-cols-2 gap-5">
              <div class="form-control">
                <label class="label">
                  <span class="label-text uppercase tracking-widest"
                    >No Whatsapp</span
                  >
                </label>
                <input
                  class="input input-bordered"
                  :value="selectedRecruits.no_wa"
                  disabled
                />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text uppercase tracking-widest"
                    >Akun Sosmed</span
                  >
                </label>
                <input
                  class="input input-bordered"
                  :value="selectedRecruits.sosmed"
                  disabled
                />
              </div>
            </div>

            <div class="form-control mb-5">
              <label class="label">
                <span class="label-text uppercase tracking-widest"
                  >Alamat Rumah</span
                >
              </label>
              <input
                class="input input-bordered"
                :value="selectedRecruits.alamat"
                disabled
              />
            </div>

            <div class="form-control mb-5">
              <label class="label">
                <span class="label-text uppercase tracking-widest"
                  >Alamat Kos</span
                >
              </label>
              <input
                class="input input-bordered"
                :value="selectedRecruits.kos"
                disabled
              />
            </div>

            <div class="form-control mb-5">
              <label class="label">
                <span class="label-text uppercase tracking-widest"
                  >Kegiatan yang pernah diikuti</span
                >
              </label>
              <textarea
                :value="selectedRecruits.kegiatan"
                class="textarea h-56 textarea-bordered"
                disabled
              ></textarea>
            </div>

            <div class="form-control">
              <label class="label">
                <span class="label-text uppercase tracking-widest"
                  >Keahlian</span
                >
              </label>
              <textarea
                :value="selectedRecruits.keahlian"
                class="textarea h-56 textarea-bordered"
                disabled
              ></textarea>
            </div>
          </div>
        </div>

        <div class="form-control mt-5">
          <label class="label">
            <span class="label-text uppercase tracking-widest">Essay</span>
          </label>
          <textarea
            :value="selectedRecruits.essay"
            class="textarea h-40 textarea-bordered"
            disabled
          ></textarea>
        </div>

        <div class="modal-action"></div>
      </div>
    </div>

    <Footer />
  </div>
</template>

<script>
import { format } from 'date-fns'
import { id } from 'date-fns/locale'

export default {
  name: 'PengaturanRekrutmenPage',
  middleware: ['authenticated', 'moderator'],

  data() {
    return {
      recruits: '',
      selectedRecruits: {
        user: {
          name: '',
        },
      },
      selectedTab: 'data',

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

    tanggalLahir(tanggal) {
      const formated = format(new Date(tanggal), 'dd MMMM yyyy', {
        locale: id,
      })
      return formated
    },
  },
}
</script>
