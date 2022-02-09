<template>
  <div>
    <LoaderModel6 v-if="$fetchState.pending" size="32" />

    <div v-else>
      <div class="p-6 card border-2 border-primary/20">
        <div class="form-control">
          <label class="cursor-pointer label">
            <span class="label-text text-base"
              >Status

              <div
                class="indicator-item badge"
                :class="{
                  'badge-error': setting['recruit.status'] == 0,
                  'badge-success': setting['recruit.status'] == 1,
                }"
              >
                {{ setting['recruit.status'] == 0 ? 'TUTUP' : 'BUKA' }}
              </div>
            </span>
            <input
              v-model="setting['recruit.status']"
              type="checkbox"
              class="toggle toggle-primary toggle-lg"
              @change="
                updateSetting('recruit.status', setting['recruit.status'])
              "
            />
          </label>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PengaturanRekrutmenKonfigurasiComponent',
  data() {
    return {
      setting: {
        'recruit.status': 0,
      },
    }
  },
  async fetch() {
    await this.$axios
      .get(`${this.$config.apiURL}/setting/get?name=recruit.status`)
      .then((response) => {
        this.setting = response.data
        this.setting['recruit.status'] = parseInt(
          this.setting['recruit.status']
        )
      })
      .catch(() => {
        this.setting = null
      })
  },
  methods: {
    updateSetting(key, val) {
      this.$axios
        .patch(`${this.$config.apiURL}/setting/set`, {
          name: key,
          value: val,
        })
        .then((response) => {
          // this.$toast.success('Berhasil mengubah pengaturan')
        })
        .catch((error) => {
          console.log(error.response)
          // this.$toast.error('Gagal mengubah pengaturan')
        })
    },
  },
}
</script>