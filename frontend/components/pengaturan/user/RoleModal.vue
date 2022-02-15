<template>
  <div>
    <input
      id="roleModal"
      :checked="roleModal.show"
      type="checkbox"
      class="modal-toggle"
    />
    <div class="modal">
      <div class="modal-box">
        <div class="w-full">
          <label class="label">
            <span class="label-text uppercase tracking-widest">Role</span>
          </label>
          <select
            v-model="$parent.selectedUsers.role"
            class="select select-bordered w-full"
            required
          >
            <option class="font-medium" value="administrator">
              Administrator
            </option>
            <option class="font-medium" value="moderator">Moderator</option>
            <option class="font-medium" value="member">Member</option>
          </select>
        </div>

        <p v-if="changed" class="font-medium mt-5">
          Apakah kamu yakin ingin mengubah role
          <b>@{{ selectedUsers.username }}</b> menjadi
          <b class="capitalize">{{ selectedUsers.role }}</b
          >?
        </p>

        <hr class="my-5 border-white/30" />

        <div class="modal-action">
          <button
            class="btn btn-sm btn-outline btn-success"
            :class="{
              loading: roleModal.loading === true,
              'btn-disabled opacity-50': !changed,
            }"
            @click="$parent.changeRole(selectedUsers)"
          >
            <span> Iya, Ubah Role </span>
          </button>
          <button
            class="btn btn-sm btn-outline"
            @click="$parent.roleModal.show = false"
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
  name: 'PengaturanUserRoleModalComponent',
  props: {
    selectedUsers: {
      type: Object,
      default: () => ({}),
    },
    oldRole: {
      type: String,
      default: '',
    },
    roleModal: {
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
      return this.selectedUsers.role !== this.oldRole
    },
  },
}
</script>
