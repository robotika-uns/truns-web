<template>
  <div>
    <Navbar />
    <div class="hero min-h-screen mt-[-9rem]">
      <div
        class="flex-col justify-center hero-content lg:flex-row-reverse min-w-full px-5 md:px-14 z-10 pt-24"
      >
        <img src="/assets/img/recruitment.svg" class="p-5 md:max-w-lg" />
        <div class="w-full md:pl-10 text-center md:text-left">
          <h1
            class="mb-5 text-5xl font-bold tracking-wide text-slate-100 indicator"
          >
            <div class="indicator-item badge badge-error z-50">DITUTUP</div>
            <span class="font-light">REKRUTMEN</span>&nbsp;ANGGOTA
          </h1>
          <p class="mb-5 lg:pr-32 text-white/60 tracking-wide text-2xl">
            Rekrutmen anggota UKM Robotika untuk mahasiswa aktif UNS yang dibuka
            setahun sekali.
          </p>
          <NuxtLink
            to="#persyaratan"
            class="btn btn-primary tracking-wider hover:shadow-lg hover:-translate-y-2 hover:shadow-white/50"
            >Lihat Persyaratan &nbsp;
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 24 24"
              width="24"
              height="24"
            >
              <path fill="none" d="M0 0h24v24H0z" />
              <path
                d="M12 2c5.52 0 10 4.48 10 10s-4.48 10-10 10S2 17.52 2 12 6.48 2 12 2zm1 10V8h-2v4H8l4 4 4-4h-3z"
              />
            </svg>
          </NuxtLink>
        </div>
      </div>
      <Wave />
    </div>

    <div id="persyaratan" class="hero min-h-screen bg-base-300">
      <div
        class="flex-col justify-center hero-content lg:flex-row min-w-full px-5 md:px-14 z-10 pt-24"
      >
        <img src="/assets/img/persyaratan.svg" class="p-5 md:max-w-lg" />
        <div class="w-full md:pl-10 text-center md:text-left">
          <h1 class="mb-5 text-5xl font-bold tracking-wide text-slate-100">
            <span class="font-light">PERSYARATAN</span>&nbsp;REKRUTMEN
          </h1>
          <p class="mb-5 lg:pr-32 text-white/60 tracking-wide text-2xl">
            Rekruitmen anggota UKM Robotika untuk mahasiswa aktif UNS yang
            dibuka setahun sekali.
          </p>
          <NuxtLink
            to="#formulir"
            class="btn btn-primary tracking-wider hover:shadow-lg hover:-translate-y-2 hover:shadow-white/50"
            >Daftar &nbsp;
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 24 24"
              width="24"
              height="24"
            >
              <path fill="none" d="M0 0h24v24H0z" />
              <path
                d="M12 2c5.52 0 10 4.48 10 10s-4.48 10-10 10S2 17.52 2 12 6.48 2 12 2zm1 10V8h-2v4H8l4 4 4-4h-3z"
              />
            </svg>
          </NuxtLink>
        </div>
      </div>
      <Wave3 />
    </div>

    <div v-if="!user" id="formulir" class="hero min-h-screen bg-base-100">
      <div class="text-center hero-content">
        <div class="max-w-md">
          <h1 class="mb-5 text-5xl font-bold">Whoops!</h1>
          <p class="mb-5">
            Untuk mendaftar rekrutmen kamu harus login terlebih dahulu. Jika
            belum mempunyai akun, silahkan buat akun terlebih dahulu.
          </p>
          <NuxtLink to="/register" class="btn btn-ghost border-primary/20"
            >Buat Akun</NuxtLink
          >
          &nbsp;
          <NuxtLink to="/login" class="btn btn-primary tracking-widest"
            >Login</NuxtLink
          >
        </div>
      </div>
    </div>

    <div
      v-if="status_recruit == 'recruit_sudah_diterima'"
      id="formulir"
      class="hero min-h-screen bg-base-100"
    >
      <div class="text-center hero-content">
        <div class="max-w-md">
          <h1 class="mb-5 text-5xl font-bold">Whoops!</h1>
          <p class="mb-5">
            Kamu sudah menjadi anggota/alumni UKM Robotika UNS.
          </p>
          <!-- <NuxtLink to="/register" class="btn btn-ghost border-primary/20"
            >Buat Akun</NuxtLink
          >
          &nbsp;
          <NuxtLink to="/login" class="btn btn-primary tracking-widest"
            >Login</NuxtLink
          > -->
        </div>
      </div>
    </div>

    <div
      v-if="status_recruit == 'recruit_sudah_submit'"
      id="formulir"
      class="hero min-h-screen bg-base-100"
    >
      <div class="text-center hero-content">
        <div class="max-w-md">
          <h1 class="mb-5 text-5xl font-bold">Terima Kasih</h1>
          <p class="mb-5">
            Jangan lupa untuk memasang twibbon di sosmed kamu sebagai salah satu
            persyaratan rekrutmen. Untuk info lebih lanjut silahkan pantau
            Instagram @robotika.uns atau
          </p>
          <!-- <NuxtLink to="/register" class="btn btn-ghost border-primary/20"
            >Buat Akun</NuxtLink
          >
          &nbsp;
          <NuxtLink to="/login" class="btn btn-primary tracking-widest"
            >Login</NuxtLink
          > -->
        </div>
      </div>
    </div>

    <div
      v-if="user && status_recruit == 'recruit_belum_submit'"
      id="formulir"
      class="hero min-h-screen bg-base-100 mt-24 pb-24"
    >
      <form id="recruitForm" class="w-full" @submit.prevent="kirim">
        <div
          class="text-center hero-content grid grid-cols-12 gap-10 w-full m-auto items-baseline"
        >
          <h1 class="mb-10 text-5xl font-bold col-span-12 uppercase">
            <span class="font-light"> Formulir </span> Rekrutmen
          </h1>
          <div class="col-span-12 md:col-span-6 bg-base-300 rounded-xl p-10">
            <div class="text-left font-bold text-2xl mb-5">Data Pribadi</div>
            <hr class="mb-5 border-slate-800" />
            <div class="form-control mb-5">
              <label class="label">
                <span class="label-text uppercase tracking-widest"
                  >Nama Lengkap</span
                >
              </label>
              <input
                v-model="user.name"
                type="text"
                placeholder="Nama Lengkap"
                class="input input-bordered"
                disabled
                required
                :class="state.error.name ? 'input-error' : ''"
                @input="state.error.name ? (state.error.name = '') : ''"
              />
              <InputErrorLabel :error="state.error.name" />
            </div>
            <div class="form-control mb-5">
              <label class="label">
                <span class="label-text uppercase tracking-widest">Email</span>
              </label>
              <input
                v-model="user.email"
                type="email"
                placeholder="Email"
                class="input input-bordered"
                disabled
                required
                :class="state.error.email ? 'input-error' : ''"
                @input="state.error.email ? (state.error.email = '') : ''"
              />
              <InputErrorLabel :error="state.error.email" />
            </div>
            <div class="mb-5 grid grid-cols-12 gap-5">
              <div class="form-control col-span-3">
                <label class="label">
                  <span class="label-text uppercase tracking-widest">NIM</span>
                </label>
                <input
                  v-model="data.nim"
                  type="text"
                  placeholder="cth. K3518032"
                  class="input input-bordered"
                  required
                  :class="state.error.nim ? 'input-error' : ''"
                  @input="state.error.nim ? (state.error.nim = '') : ''"
                />
                <InputErrorLabel :error="state.error.nim" />
              </div>
              <div class="form-control col-span-9">
                <label class="label">
                  <span class="label-text uppercase tracking-widest"
                    >Prodi</span
                  >
                </label>
                <input
                  v-model="data.prodi"
                  type="text"
                  placeholder="cth. Pendidikan Teknik Informatika Komputer"
                  class="input input-bordered"
                  required
                  :class="state.error.prodi ? 'input-error' : ''"
                  @input="state.error.prodi ? (state.error.prodi = '') : ''"
                />
                <InputErrorLabel :error="state.error.prodi" />
              </div>
            </div>
            <div class="form-control mb-5">
              <label class="label">
                <span class="label-text uppercase tracking-widest"
                  >Fakultas</span
                >
              </label>
              <input
                v-model="data.fakultas"
                type="text"
                placeholder="cth. Fakultas Keguruan Ilmu Pendidikan"
                class="input input-bordered"
                required
                :class="state.error.fakultas ? 'input-error' : ''"
                @input="state.error.fakultas ? (state.error.fakultas = '') : ''"
              />
              <InputErrorLabel :error="state.error.fakultas" />
            </div>
            <div class="mb-5 grid grid-cols-2 gap-5">
              <div class="form-control">
                <label class="label">
                  <span class="label-text uppercase tracking-widest"
                    >Tempat Lahir</span
                  >
                </label>
                <input
                  v-model="data.tempat_lahir"
                  type="text"
                  placeholder="cth. Jakarta"
                  class="input input-bordered"
                  required
                  :class="state.error.tempat_lahir ? 'input-error' : ''"
                  @input="
                    state.error.tempat_lahir
                      ? (state.error.tempat_lahir = '')
                      : ''
                  "
                />
                <InputErrorLabel :error="state.error.tempat_lahir" />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text uppercase tracking-widest"
                    >Tanggal Lahir</span
                  >
                </label>
                <input
                  v-model="data.tanggal_lahir"
                  type="date"
                  class="input input-bordered text-white"
                  required
                  :class="state.error.tanggal_lahir ? 'input-error' : ''"
                  @input="
                    state.error.tanggal_lahir
                      ? (state.error.tanggal_lahir = '')
                      : ''
                  "
                />
                <InputErrorLabel :error="state.error.tanggal_lahir" />
              </div>
            </div>
            <div class="form-control mb-5">
              <label class="label">
                <span class="label-text uppercase tracking-widest"
                  >Alamat Rumah</span
                >
              </label>
              <input
                v-model="data.alamat"
                type="text"
                placeholder="cth. Perum Griya Permata Asri 3 Blok A No.12A, Sonorejo, Sukoharjo, Jawa Tengah."
                class="input input-bordered"
                required
                :class="state.error.alamat ? 'input-error' : ''"
                @input="state.error.alamat ? (state.error.alamat = '') : ''"
              />
              <InputErrorLabel :error="state.error.alamat" />
            </div>
            <div class="form-control mb-5">
              <label class="label">
                <span class="label-text uppercase tracking-widest"
                  >Alamat Kos
                  <div class="badge text-2xs">opsional</div>
                </span>
              </label>
              <input
                v-model="data.kos"
                type="text"
                placeholder="cth. Kos Putra no.36, Kentingan."
                class="input input-bordered"
                :class="state.error.kos ? 'input-error' : ''"
                @input="state.error.kos ? (state.error.kos = '') : ''"
              />
              <InputErrorLabel :error="state.error.kos" />
            </div>
            <div class="mb-5 grid grid-cols-2 gap-5">
              <div class="form-control">
                <label class="label">
                  <span class="label-text uppercase tracking-widest"
                    >Nomor WhatsApp</span
                  >
                </label>
                <label class="input-group w-full">
                  <span class="bg-base-200">+62</span>
                  <input
                    v-model="data.no_wa"
                    type="number"
                    placeholder="cth. 81234567891."
                    class="input input-bordered w-full"
                    required
                    :class="state.error.no_wa ? 'input-error' : ''"
                    @input="state.error.no_wa ? (state.error.no_wa = '') : ''"
                  />
                </label>
                <InputErrorLabel :error="state.error.no_wa" />
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text uppercase tracking-widest"
                    >Akun Sosmed</span
                  >
                </label>
                <input
                  v-model="data.sosmed"
                  type="text"
                  placeholder="cth. IG: robotika.uns"
                  class="input input-bordered"
                  required
                  :class="state.error.sosmed ? 'input-error' : ''"
                  @input="state.error.sosmed ? (state.error.sosmed = '') : ''"
                />
                <InputErrorLabel :error="state.error.sosmed" />
              </div>
            </div>
            <div class="form-control mb-5">
              <label class="label">
                <span class="label-text uppercase tracking-widest"
                  >Kegiatan yang pernah diikuti</span
                >
              </label>
              <textarea
                v-model="data.kegiatan"
                class="textarea h-24 textarea-bordered"
                placeholder="cth. 1. Palang Merah Remaja, 2. OSIS, 3. Juara 2 Lomba Web Design"
                required
                :class="state.error.kegiatan ? 'input-error' : ''"
                @input="state.error.kegiatan ? (state.error.kegiatan = '') : ''"
              ></textarea>
              <InputErrorLabel :error="state.error.kegiatan" />
            </div>
            <div class="form-control mb-5">
              <label class="label">
                <span class="label-text uppercase tracking-widest"
                  >Keahlian</span
                >
              </label>
              <textarea
                v-model="data.keahlian"
                class="textarea h-24 textarea-bordered"
                placeholder="cth. 1. Mengerti bahasa pemrograman C++ dan python, 2. Desain grafis, 3. Desain 3D"
                required
                :class="state.error.keahlian ? 'input-error' : ''"
                @input="state.error.keahlian ? (state.error.keahlian = '') : ''"
              ></textarea>
              <InputErrorLabel :error="state.error.keahlian" />
            </div>
          </div>
          <div class="col-span-12 md:col-span-6">
            <div class="bg-base-300 rounded-xl p-10">
              <div class="mb-5 grid grid-cols-2 gap-5">
                <div class="form-control w-full">
                  <label class="label">
                    <span class="label-text uppercase tracking-widest"
                      >PILIHAN PRIORITAS</span
                    >
                  </label>
                  <select
                    v-model="data.tim_prioritas"
                    class="select select-bordered w-full"
                    required
                    :class="state.error.tim_prioritas ? 'input-error' : ''"
                    @input="
                      state.error.tim_prioritas
                        ? (state.error.tim_prioritas = '')
                        : ''
                    "
                  >
                    <option value="" disabled="disabled" selected="selected">
                      Pilih tim prioritas
                    </option>
                    <option value="sambergeni">[KRPAI] Sambergeni</option>
                    <option value="maladi">[KRSBI] Maladi</option>
                    <option value="werkudara">[KRAI] Werkudara</option>
                    <option value="sriwedari">[KRSTI] Sriwedari</option>
                    <option value="dewisri">[KRTMI] Dewisri</option>
                    <option value="jaladara">[ROV] Jaladara</option>
                  </select>
                  <InputErrorLabel :error="state.error.tim_prioritas" />
                </div>
                <div class="form-control w-full">
                  <label class="label">
                    <span class="label-text uppercase tracking-widest">
                      &nbsp;</span
                    >
                  </label>
                  <select
                    v-model="data.divisi_prioritas"
                    class="select select-bordered w-full"
                    required
                    :class="state.error.divisi_prioritas ? 'input-error' : ''"
                    @input="
                      state.error.divisi_prioritas
                        ? (state.error.divisi_prioritas = '')
                        : ''
                    "
                  >
                    <option value="" disabled="disabled" selected="selected">
                      Pilih divisi prioritas
                    </option>
                    <option value="programmer">[Teknis] Programmer</option>
                    <option value="elektro">[Teknis] Elektro</option>
                    <option value="mekanik">[Teknis] Mekanik</option>
                    <option value="sekretaris">[Non-Teknis] Sekretaris</option>
                    <option value="bendahara">[Non-Teknis] Bendahara</option>
                    <option value="internal">[Non-Teknis] Internal</option>
                    <option value="media">[Non-Teknis] Media</option>
                  </select>
                  <InputErrorLabel :error="state.error.divisi_prioritas" />
                </div>
              </div>

              <div class="mb-5 grid grid-cols-2 gap-5">
                <div class="form-control w-full">
                  <label class="label">
                    <span class="label-text uppercase tracking-widest"
                      >PILIHAN ALTERNATIF</span
                    >
                  </label>
                  <select
                    v-model="data.tim_alternatif"
                    class="select select-bordered w-full"
                    required
                    :class="state.error.tim_alternatif ? 'input-error' : ''"
                    @input="
                      state.error.tim_alternatif
                        ? (state.error.tim_alternatif = '')
                        : ''
                    "
                  >
                    <option value="" disabled="disabled" selected="selected">
                      Pilih tim alternatif
                    </option>
                    <option value="sambergeni">[KRPAI] Sambergeni</option>
                    <option value="maladi">[KRSBI] Maladi</option>
                    <option value="werkudara">[KRAI] Werkudara</option>
                    <option value="sriwedari">[KRSTI] Sriwedari</option>
                    <option value="dewisri">[KRTMI] Dewisri</option>
                    <option value="jaladara">[ROV] Jaladara</option>
                  </select>
                  <InputErrorLabel :error="state.error.tim_alternatif" />
                </div>
                <div class="form-control w-full">
                  <label class="label">
                    <span class="label-text uppercase tracking-widest">
                      &nbsp;</span
                    >
                  </label>
                  <select
                    v-model="data.divisi_alternatif"
                    class="select select-bordered w-full"
                    :class="state.error.divisi_alternatif ? 'input-error' : ''"
                    @input="
                      state.error.divisi_alternatif
                        ? (state.error.divisi_alternatif = '')
                        : ''
                    "
                  >
                    <option value="" disabled="disabled" selected="selected">
                      Pilih divisi alternatif
                    </option>
                    <option value="programmer">[Teknis] Programmer</option>
                    <option value="elektro">[Teknis] Elektro</option>
                    <option value="mekanik">[Teknis] Mekanik</option>
                    <option value="sekretaris">[Non-Teknis] Sekretaris</option>
                    <option value="bendahara">[Non-Teknis] Bendahara</option>
                    <option value="internal">[Non-Teknis] Internal</option>
                    <option value="media">[Non-Teknis] Media</option>
                  </select>
                  <InputErrorLabel :error="state.error.divisi_alternatif" />
                </div>
              </div>

              <div class="form-control mb-5">
                <label class="label">
                  <span class="label-text uppercase tracking-widest"
                    >Alasan</span
                  >
                </label>
                <textarea
                  v-model="data.alasan"
                  class="textarea h-28 textarea-bordered"
                  placeholder="cth. Saya memilih tim maladi karna... dan saya memilih divisi prioritas pemrograman karna... Saya memilih divisi elektro pada pilihan divisi lain karna..."
                  required
                  :class="state.error.alasan ? 'input-error' : ''"
                  @input="state.error.alasan ? (state.error.alasan = '') : ''"
                ></textarea>
                <InputErrorLabel :error="state.error.alasan" />
              </div>

              <div class="form-control mb-5">
                <label class="label">
                  <span class="label-text uppercase tracking-widest"
                    >Essay</span
                  >
                </label>
                <textarea
                  v-model="data.essay"
                  class="textarea h-96 textarea-bordered"
                  :class="state.error.essay ? 'input-error' : ''"
                  @input="state.error.essay ? (state.error.essay = '') : ''"
                ></textarea>
                <InputErrorLabel :error="state.error.essay" />
              </div>
            </div>

            <div class="bg-base-300 rounded-xl p-10 mt-10">
              <div class="form-control w-full mb-5">
                <label class="label">
                  <span class="label-text uppercase tracking-widest"
                    >UPLOAD PAS PHOTO</span
                  >
                </label>
                <input
                  ref="pas_photo"
                  type="file"
                  class="input input-bordered h-full"
                  :class="state.error.pas_photo ? 'input-error' : ''"
                  @input="
                    state.error.pas_photo ? (state.error.pas_photo = '') : ''
                  "
                />
                <InputErrorLabel :error="state.error.pas_photo" />
              </div>
              <div class="form-control w-full mb-5">
                <label class="label">
                  <span class="label-text uppercase tracking-widest"
                    >UPLOAD KARMAS</span
                  >
                </label>
                <input
                  ref="karmas"
                  type="file"
                  class="input input-bordered h-full"
                  :class="state.error.karmas ? 'input-error' : ''"
                  @input="state.error.karmas ? (state.error.karmas = '') : ''"
                />
                <InputErrorLabel :error="state.error.karmas" />
              </div>
              <div class="form-control w-full mb-5">
                <label class="label">
                  <span class="label-text uppercase tracking-widest"
                    >UPLOAD KRS</span
                  >
                </label>
                <input
                  ref="krs"
                  type="file"
                  class="input input-bordered h-full"
                  :class="state.error.krs ? 'input-error' : ''"
                  @input="state.error.krs ? (state.error.krs = '') : ''"
                />
                <InputErrorLabel :error="state.error.krs" />
              </div>
            </div>

            <div class="form-control mt-10">
              <button
                type="submit"
                class="btn btn-primary tracking-widest hover:shadow-lg hover:shadow-white/50"
                :disabled="state.isSubmitting"
              >
                <span v-if="!state.isSubmitting" class="flex flex-row">
                  KIRIM&nbsp;
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    width="20"
                    height="20"
                    class="m-auto"
                  >
                    <path fill="none" d="M0 0h24v24H0z" />
                    <path
                      d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
                    />
                  </svg>
                </span>

                <svg
                  v-if="state.isSubmitting"
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
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>

    <Footer />
  </div>
</template>

<script>
export default {
  name: 'RekrutmenPage',
  data: () => ({
    data: {},
    status_recruit: '',
    state: {
      isSubmitting: false,
      error: '',
    },
  }),
  async fetch() {
    this.state.isSubmitting = true
    await this.$axios
      .get(`${this.$config.apiURL}/recruit/check`)
      .then((response) => {
        this.status_recruit = response.data.tag
        this.state.isSubmitting = false
      })
      .catch((error) => {
        this.status_recruit = error.response.data.tag
        this.state.isSubmitting = false
      })
  },
  computed: {
    user() {
      return this.$store.state.user.currentUser
    },
  },
  methods: {
    async kirim() {
      this.state.isSubmitting = true

      const formData = new FormData()
      formData.append('pas_photo', this.$refs.pas_photo.files[0])
      formData.append('karmas', this.$refs.karmas.files[0])
      formData.append('krs', this.$refs.krs.files[0])
      for (const k in this.data) {
        if (typeof this.data[k] !== 'function') {
          formData.append(k, this.data[k])
        }
      }

      await this.$axios
        .post(`${this.$config.apiURL}/recruit`, formData)
        .then((response) => {
          this.status_recruit = 'recruit_sudah_submit'
          this.state.isSubmitting = false
          window.location.href = '#formulir'
        })
        .catch((error) => {
          this.state.error = error.response.data
          this.state.isSubmitting = false
        })
    },
  },
}
</script>
