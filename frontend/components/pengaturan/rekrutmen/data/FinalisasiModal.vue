<template>
  <div>
    <input
      id="finalisasiModal"
      :checked="finalisasi.modal"
      type="checkbox"
      class="modal-toggle"
    />
    <div class="modal">
      <div class="modal-box">
        <p>Apakah kamu yakin akan memfinalisasi rekrutmen?</p>
        <br />
        <p class="opacity-80">
          Hal dibawah ini <span class="text-info">akan terjadi</span>:
        </p>

        <div class="alert alert-info border-2 border-info/50 mt-1">
          <div class="flex-1 pl-5">
            <label>
              <ul class="list-disc">
                <li>Menutup rekrutmen.</li>
                <li>Mengirim notifikasi pengumuman ke dashboard user.</li>
                <li>Mengubah tipe akun user yang diterima menjadi anggota.</li>
                <li>Menambah journey sesuai tim dan divisi yang diterima.</li>
                <li>Memfinalisasi rekrutmen batch {{ batch }}.</li>
                <li>Rekrutmen selanjutnya adalah batch {{ batch + 1 }}.</li>
              </ul>
            </label>
          </div>
        </div>

        <hr class="my-5 border-white/30" />

        <div class="modal-action">
          <button
            class="btn btn-sm btn-info btn-outline"
            :class="{
              loading: finalisasi.loading === true,
            }"
            @click="$parent.finalisasiRekrutmen()"
          >
            <span> Iya, Finalisasi </span>
          </button>
          <button
            class="btn btn-sm btn-outline"
            @click="
              $parent.finalisasi.modal = false
              $parent.finalisasi.error = ''
            "
          >
            Batal
          </button>
        </div>

        <div v-if="finalisasi.error" class="alert alert-error mt-5">
          <div class="flex-1">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              class="w-6 h-6 mx-2 stroke-current"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"
              ></path>
            </svg>
            <label>{{ finalisasi.error.pesan }}</label>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PengaturanRekrutmenFinalisasiModalComponent',
  props: {
    finalisasi: {
      type: Object,
      default: () => ({
        modal: false,
        loading: false,
        error: '',
      }),
    },
    batch: {
      type: Number,
      default: () => 0,
    },
  },
}
</script>
