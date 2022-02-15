<template>
  <div>
    <input
      id="tipeModal"
      :checked="tipeModal.show"
      type="checkbox"
      class="modal-toggle"
    />
    <div class="modal">
      <div class="modal-box">
        <div class="w-full">
          <label class="label">
            <span class="label-text uppercase tracking-widest">Tipe</span>
          </label>
          <select
            v-model="$parent.selectedUsers.tipe"
            class="select select-bordered w-full"
            required
          >
            <option class="font-medium" value="anggota">Anggota</option>
            <option class="font-medium" value="alumni">Alumni</option>
            <option class="font-medium" value="outsider">Outsider</option>
          </select>
        </div>

        <p v-if="changed" class="font-medium mt-5">
          Apakah kamu yakin ingin mengubah tipe
          <b>@{{ selectedUsers.username }}</b> menjadi
          <b class="capitalize">{{ selectedUsers.tipe }}</b
          >?
        </p>

        <hr class="my-5 border-white/30" />

        <div class="modal-action">
          <button
            class="btn btn-sm btn-outline btn-success"
            :class="{
              loading: tipeModal.loading === true,
              'btn-disabled opacity-50': !changed,
            }"
            @click="$parent.changeTipe(selectedUsers)"
          >
            <span> Iya, Ubah Tipe </span>
          </button>
          <button
            class="btn btn-sm btn-outline"
            @click="$parent.tipeModal.show = false"
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
  name: 'PengaturanUserTipeModalComponent',
  props: {
    selectedUsers: {
      type: Object,
      default: () => ({}),
    },
    oldTipe: {
      type: String,
      default: '',
    },
    tipeModal: {
      type: Object,
      default: () => ({
        state: '',
        show: false,
        loading: false,
      }),
    },
  },

  computed: {
    changed() {
      return this.selectedUsers.tipe !== this.oldTipe
    },
  },
}
</script>
