<template>
  <div>
    <input :checked="detil.modal" type="checkbox" class="modal-toggle" />
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
            <button
              class="btn btn-sm btn-error btn-outline h-full"
              @click="$parent.detil.modal = false"
            >
              <i class="ri-close-line"></i>
            </button>
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
  </div>
</template>

<script>
import { format } from 'date-fns'
import { id } from 'date-fns/locale'

export default {
  name: 'PengaturanRekrutmenDataDetilModalComponent',
  props: {
    selectedRecruits: {
      type: Object,
      default: () => ({}),
    },
    detil: {
      type: Object,
      default: () => ({
        modal: false,
      }),
    },
  },
  methods: {
    tanggalLahir(tanggal) {
      const formated = format(new Date(tanggal), 'dd MMMM yyyy', {
        locale: id,
      })
      return formated
    },
  },
}
</script>
