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
      <div class="col-span-8">
        <div class="flex flex-row lg:flex-row-reverse gap-10">
          <div class="avatar placeholder indicator basis-1/3 -mt-5">
            <div class="indicator-item">
              <button
                class="btn btn-primary btn-circle mt-20 mr-20 border-2 border-black/70"
                @click="$refs.photo.click()"
              >
                <i class="ri-pencil-fill"></i>
              </button>
            </div>

            <div class="w-full mask mask-squircle bg-base-300">
              <InputErrorLabel v-if="state.error" :error="state.error.photo" />
              <i
                v-else-if="state.isUploading"
                class="ri-loader-5-fill ri-6x text-primary/50 animate-spin"
              ></i>
              <img v-else-if="user.photo" :src="user.photo" />
              <i v-else class="ri-user-3-fill ri-6x text-primary/50"></i>
            </div>
          </div>

          <!-- <label for="my-modal-2" class="btn btn-primary modal-button hidden"
            >open modal</label
          > -->
          <input
            id="cropModal"
            v-model="showCropModal"
            type="checkbox"
            class="modal-toggle"
          />
          <div class="modal">
            <div class="modal-box">
              <div>
                <!-- {{ $refs.photo ? $refs.photo.files[0] : '' }} -->
                <!-- <img
                  id="image"
                  :src="user.photo"
                  style="display: block; max-width: 100%"
                /> -->
                <VueCropper
                  ref="cropper"
                  :src="preview"
                  :aspect-ratio="1 / 1"
                  :zoomOnWheel="false"
                >
                </VueCropper>
                <!-- <img
                  :src="
                    $refs.photo ? URL.createObjectURL($refs.photo.files[0]) : ''
                  "
                  alt=""
                /> -->
              </div>
              <div class="modal-action">
                <label for="cropModal" class="btn btn-primary" @click="upload"
                  >Simpan</label
                >
                <label for="cropModal" class="btn" @click="batal">Batal</label>
              </div>
            </div>
          </div>

          <div class="bg-base-200 rounded-xl p-8 basis-2/3">
            <input
              ref="photo"
              type="file"
              accept="image/*"
              class="hidden"
              @change="crop"
            />
            <form id="recruitForm" @submit.prevent="update">
              <div class="form-control mb-5">
                <label class="label">
                  <span class="label-text uppercase tracking-widest"
                    >Nama Lengkap</span
                  >
                </label>
                <input
                  v-model="user.name"
                  type="text"
                  class="input input-bordered"
                  required
                  :class="state.error.name ? 'input-error' : ''"
                  @input="state.error.name ? (state.error.name = '') : ''"
                />
                <InputErrorLabel :error="state.error.name" />
              </div>

              <div class="form-control mb-5">
                <label class="label">
                  <span class="label-text uppercase tracking-widest"
                    >Bio Singkat</span
                  >
                </label>
                <input
                  v-model="user.bio"
                  type="text"
                  class="input input-bordered"
                  :class="state.error.bio ? 'input-error' : ''"
                  @input="state.error.bio ? (state.error.bio = '') : ''"
                />
                <InputErrorLabel :error="state.error.bio" />
              </div>

              <div class="form-control mt-10">
                <button
                  type="submit"
                  class="btn btn-sm btn-primary w-32 tracking-widest hover:shadow-lg hover:shadow-white/50"
                  :disabled="state.isUpdating || state.isSaved"
                >
                  <span
                    v-if="!state.isUpdating && !state.isSaved"
                    class="flex flex-row"
                  >
                    Update
                  </span>

                  <svg
                    v-if="state.isUpdating"
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
                  <i
                    v-if="state.isSaved"
                    class="ri-check-line text-success"
                  ></i>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <Footer />
  </div>
</template>

<script>
import VueCropper from 'vue-cropperjs'
import 'cropperjs/dist/cropper.css'

export default {
  name: 'PengaturanProfilPage',
  components: { VueCropper },
  middleware: 'authenticated',

  data() {
    return {
      photo: '',
      preview: '',
      showCropModal: false,
      state: {
        isUploading: false,
        isUpdating: false,
        isSaved: false,
        error: '',
      },
    }
  },
  head() {
    return {
      title: `Profil - Pengaturan | ${this.$config.appName}`,
    }
  },
  computed: {
    user() {
      return { ...this.$store.state.user.currentUser }
    },
  },
  methods: {
    async update() {
      this.state.isUpdating = true
      this.state.error = ''
      await this.$axios
        .patch(`${this.$config.apiURL}/user`, this.user)
        .then((response) => {
          // this.status_recruit = 'recruit_sudah_submit'
          this.state.isUpdating = false
          this.state.isSaved = true
          setTimeout(() => {
            this.state.isSaved = false
          }, 1000)
        })
        .catch((error) => {
          this.state.error = error.response.data
          this.state.isUpdating = false
        })
    },
    upload() {
      this.$refs.cropper.getCroppedCanvas().toBlob((blob) => {
        this.state.isUploading = true
        this.state.error = ''

        const formData = new FormData()
        formData.append('photo', blob)

        this.$axios
          .post(`${this.$config.apiURL}/user/photo`, formData)
          .then((response) => {
            this.user.photo = response.data.photo
            this.state.isUploading = false
          })
          .catch((error) => {
            this.state.error = error.response.data
            this.state.isUploading = false
          })
      })
      this.$refs.photo.value = null
    },
    batal() {
      this.$refs.photo.value = null
    },
    crop() {
      const file = this.$refs.photo.files[0]
      if (!file.type.includes('image/')) {
        alert('Silahkan pilih file berformat gambar')

        return
      }

      this.showCropModal = true

      if (typeof FileReader === 'function') {
        const reader = new FileReader()
        reader.onload = (event) => {
          this.imgSrc = event.target.result
          // rebuild cropperjs with the updated source
          this.$refs.cropper.replace(event.target.result)
        }
        reader.readAsDataURL(file)
      } else {
        alert('Sorry, FileReader API not supported')
      }
    },
  },
}
</script>
