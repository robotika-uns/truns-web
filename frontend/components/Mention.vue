<template>
  <node-view-wrapper as="span">
    <span>
      <div class="dropdown dropdown-end dropdown-hover">
        <span tabindex="0" @mouseover="loadUser">
          <NuxtLink
            :to="`/user/${node.attrs.username}`"
            class="px-1 rounded-md text-primary border-[1px] border-primary/50 hover:bg-white hover:text-black transition-all ease-in-out duration-300"
          >
            @<b>{{ node.attrs.username }}</b>
          </NuxtLink>
        </span>

        <div
          tabindex="0"
          class="menu dropdown-content bg-base-300 border-2 border-primary/20 w-96 rounded-box shadow-2xl shadow-black"
          :class="{
            'border-error/70': user.role == 'administrator',
            'border-warning/70': user.role == 'moderator',
          }"
        >
          <LoaderModel6 v-if="isFetching" :size="32" class="py-8" />
          <div v-if="!user && status == 404 && !isFetching">
            <div class="alert alert-error">
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
                <label><b>User tidak ditemukan!</b></label>
              </div>
            </div>
          </div>
          <div v-if="user && !isFetching">
            <div class="flex flex-row">
              <div
                v-if="!(user.role == 'member')"
                class="badge align-middle select-none uppercase w-full py-3"
                :class="
                  user.role == 'moderator'
                    ? 'badge-warning'
                    : user.role == 'administrator'
                    ? 'badge-error'
                    : ''
                "
              >
                <b>{{ user.role }}</b>
              </div>
            </div>

            <div class="flex flex-row gap-5 p-7">
              <div class="avatar placeholder indicator">
                <div
                  class="indicator-item indicator-bottom indicator-center font-bold badge badge-primary uppercase border-2 border-black/50"
                >
                  {{ user.tipe }}
                </div>

                <div class="w-24 h-24 mask mask-squircle bg-base-100">
                  <img v-if="user.photo" :src="user.photo" />
                  <i v-else class="ri-user-3-fill ri-4x text-primary/50"></i>
                </div>
              </div>

              <div class="text-white flex flex-col">
                <div
                  class="normal-case text-lg text-left font-bold"
                  :class="{
                    '': user.role === 'administrator',
                    '': user.role === 'moderator',
                  }"
                >
                  {{ user ? singkatNama(user.name) : '' }}
                </div>
                <div class="font-medium opacity-50 text-sm">
                  @{{ user ? user.username : '' }}
                </div>
                <div class="font-medium opacity-50 mt-3">
                  {{ user ? user.bio : '' }}
                </div>
              </div>
            </div>
            <div
              class="flex flex-row mt-2 border-t-2 border-primary/10 text-primary"
            >
              <div class="font-bold w-4/12 p-2">
                <div class="text-center">
                  {{ singkatAngka(user.xp) }}
                  <span class="font-medium">XP</span>
                </div>
              </div>
              <div
                class="justify-center font-bold flex flex-row border-x-2 border-primary/10 w-4/12 p-2 uppercase text-center"
              >
                <div
                  data-tip="NON-ANGGOTA"
                  class="tooltip tooltip-top tooltip-primary align-middle"
                >
                  <svg
                    v-if="user.tipe == 'outsider'"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    class="w-7 px-1"
                  >
                    <path fill="none" d="M0 0h24v24H0z" />
                    <path
                      d="M17 13a4 4 0 1 1 0 8c-2.142 0-4-1.79-4-4h-2a4 4 0 1 1-.535-2h3.07A3.998 3.998 0 0 1 17 13zM2 12v-2h2V7a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4v3h2v2H2z"
                      class="fill-primary"
                    />
                  </svg>
                </div>
                <div v-for="journey in user.journeys" :key="journey.id">
                  <div
                    :data-tip="journey.struktur + ' ' + journey.divisi"
                    class="tooltip tooltip-top tooltip-primary align-middle"
                  >
                    <img
                      v-if="!(journey.tim == 'pengurus')"
                      :src="`/assets/img/tim/${journey.tim}.png`"
                      class="w-7 px-1"
                    />
                    <svg
                      v-else
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 24 24"
                      class="w-7 px-1"
                    >
                      <path fill="none" d="M0 0h24v24H0z" />
                      <path
                        d="M3.783 2.826L12 1l8.217 1.826a1 1 0 0 1 .783.976v9.987a6 6 0 0 1-2.672 4.992L12 23l-6.328-4.219A6 6 0 0 1 3 13.79V3.802a1 1 0 0 1 .783-.976zM12 13.5l2.939 1.545-.561-3.272 2.377-2.318-3.286-.478L12 6l-1.47 2.977-3.285.478 2.377 2.318-.56 3.272L12 13.5z"
                        class="fill-primary"
                      />
                    </svg>
                  </div>
                </div>
              </div>

              <div
                :data-tip="user.reputasi + ' REPUTASI'"
                class="grid grid-cols-2 gap-[3px] w-4/12 p-2 font-bold tooltip tooltip-success"
              >
                <div class="grid grid-cols-8 gap-[3px]">
                  <div
                    v-for="(n, index) in 8"
                    :key="n"
                    class="py-2 my-1 rounded-sm"
                    :class="
                      user.reputasi > 16 * index ? 'bg-success' : 'bg-base-200'
                    "
                  ></div>
                </div>
                <div class="grid grid-cols-8 gap-[3px]">
                  <div
                    v-for="(n, index) in 8"
                    :key="n"
                    class="py-2 my-1 rounded-sm"
                    :class="
                      user.reputasi > 128 + 16 * index
                        ? 'bg-success'
                        : 'bg-base-200'
                    "
                  ></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </span>
  </node-view-wrapper>
</template>

<script>
import { NodeViewWrapper, nodeViewProps } from '@tiptap/vue-2'

export default {
  name: 'MentionComponent',
  components: {
    NodeViewWrapper,
  },
  props: {
    nodeViewProps,
    username: {
      type: String,
      default: null,
    },
  },
  data() {
    return {
      user: '',
      isFetching: true,
      status: null,
    }
  },

  methods: {
    async loadUser() {
      if (!this.user) {
        await this.$axios
          .get(`${this.$config.apiURL}/user/get/${this.node.attrs.username}`)
          .then((response) => {
            this.user = response.data
            this.isFetching = false
          })
          .catch((error) => {
            this.status = error.response.status
            this.isFetching = false
          })
      }
    },
  },
}
</script>
