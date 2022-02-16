<template>
  <div>
    <div class="hero min-h-screen bg-base-300 mt-[-9rem] pt-24">
      <div class="flex-col justify-center hero-content lg:flex-row z-10">
        <div class="text-center lg:text-left lg:pr-20">
          <h1 class="mb-5 text-5xl font-bold uppercase">Hubungi Kami</h1>
          <p class="mb-5 lg:pr-32 text-white/60 tracking-wide text-xl">
            Jika kamu punya saran, ingin bertanya sesuatu, butuh bantuan lebih
            lanjut mengenai UKM Robotika UNS, jangan ragu untuk menghubungi kami
            melalui form di bawah ini. atau kamu bisa email langsung ke
            <b class="text-slate-300">robotika[at]mail.uns.ac.id</b>.
          </p>
        </div>
        <div
          class="card flex-shrink-0 w-full max-w-sm shadow-2xl shadow-white/10 bg-base-200"
        >
          <div class="card-body">
            <form id="contactForm" @submit.prevent="sendMessage">
              <input v-model="accessKey" type="hidden" />
              <input type="text" name="honeypot" style="display: none" />

              <div class="form-control">
                <label class="label">
                  <span
                    class="label-text text-white tracking-wider font-extralight"
                    >Nama Lengkap</span
                  >
                </label>
                <input
                  v-model="nama"
                  type="text"
                  name="nama"
                  placeholder="misal: Leonardo da Vinci"
                  class="input input-bordered"
                  required
                />
              </div>
              <br />
              <div class="form-control">
                <label class="label">
                  <span
                    class="label-text text-white tracking-wider font-extralight"
                    >Email</span
                  >
                </label>
                <input
                  v-model="email"
                  type="text"
                  name="email"
                  placeholder="misal: leodavinci@email.com"
                  class="input input-bordered"
                  required
                />
              </div>
              <br />
              <div class="form-control">
                <label class="label">
                  <span
                    class="label-text text-white tracking-wider font-extralight"
                    >Pesan</span
                  >
                </label>
                <textarea
                  v-model="pesan"
                  name="pesan"
                  class="textarea h-36 textarea-bordered"
                  placeholder="Tulis pesan yang ingin kamu sampaikan."
                  required
                ></textarea>
              </div>

              <div class="form-control mt-6">
                <button
                  type="submit"
                  class="btn btn-primary tracking-widest hover:shadow-lg hover:-translate-y-2 hover:shadow-white/50"
                  :disabled="state.isSending"
                >
                  <span v-if="!state.isSending"> KIRIM </span>

                  <svg
                    v-if="state.isSending"
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
            </form>
          </div>
        </div>
      </div>
      <Wave3 />
    </div>

    <input
      id="sendSuccessModal"
      v-model="modal"
      type="checkbox"
      class="modal-toggle"
    />

    <div class="modal">
      <div class="modal-box bg-base-200">
        <p>{{ modalMessage }}</p>
        <div class="modal-action">
          <label for="sendSuccessModal" class="btn btn-primary">Oke</label>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'KontakPage',
  data: () => ({
    nama: '',
    email: '',
    pesan: '',
    accessKey: '',

    modal: false,
    modalMessage: '',

    state: {
      isSending: false,
    },
  }),
  created() {
    this.$store.commit('page/setTitle', 'Kontak')
  },
  methods: {
    async sendMessage() {
      this.state.isSending = true
      await this.$axios
        .post('https://api.staticforms.xyz/submit', {
          accessKey: this.accessKey,
          $nama: this.nama,
          email: this.email,
          $pesan: this.pesan,
        })
        .then((response) => {
          this.state.isSending = false
          this.nama = ''
          this.email = ''
          this.pesan = ''
          this.modalMessage =
            'Pesanmu berhasil terkirim! Kami akan menghubungi Anda sesegera mungkin.'
          this.modal = true
        })
        .catch((error) => {
          this.state.isSending = false
          this.modalMessage = `Whoops! Terjadi kesalahan dan pesan Anda tidak dapat dikirim. ${error}`
          this.modal = true
        })
    },
  },
}
</script>
