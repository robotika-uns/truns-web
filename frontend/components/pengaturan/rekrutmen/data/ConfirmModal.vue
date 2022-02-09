<template>
  <div>
    <input
      id="confirmModal"
      :checked="confirm.modal"
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
              :value="confirm.tim"
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
              :value="confirm.divisi"
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
                ? $parent.tolakUser(selectedRecruits)
                : $parent.terimaUser(selectedRecruits)
            "
          >
            <span> Iya, {{ confirm.state }} </span>
          </button>
          <button
            class="btn btn-sm btn-outline"
            @click="$parent.confirm.modal = false"
          >
            Batal
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PengaturanRekrutmenConfirmModalComponent',
  props: {
    selectedRecruits: {
      type: Object,
      default: () => ({}),
    },
    confirm: {
      type: Object,
      default: () => ({
        state: '',
        modal: false,
        loading: false,
        tim: '',
        divisi: '',
      }),
    },
  },
}
</script>
