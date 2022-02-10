<template>
  <div>
    <div class="dropdown dropdown-end">
      <div tabindex="0" class="m-1 btn btn-primary">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24"
          width="24"
          height="24"
        >
          <path fill="none" d="M0 0h24v24H0z" />
          <path
            v-if="user"
            d="M3.783 2.826L12 1l8.217 1.826a1 1 0 0 1 .783.976v9.987a6 6 0 0 1-2.672 4.992L12 23l-6.328-4.219A6 6 0 0 1 3 13.79V3.802a1 1 0 0 1 .783-.976zM12 11a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5zm-4.473 5h8.946a4.5 4.5 0 0 0-8.946 0z"
          />
          <path
            v-else
            d="M4 15h2v5h12V4H6v5H4V3a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-6zm6-4V8l5 4-5 4v-3H2v-2h8z"
          />
        </svg>
      </div>
      <ul
        v-if="user"
        tabindex="0"
        class="p-2 shadow menu dropdown-content bg-base-300 rounded-box w-96 border-2 border-primary/10"
      >
        <li class="p-5 border-b-2 border-b-primary/20 mb-2 flex flex-row">
          <div class="avatar placeholder">
            <div class="mb-5 w-20 h-20 mask mask-squircle bg-base-100">
              <img v-if="user.photo" :src="user.photo" />
              <i v-else class="ri-user-3-fill ri-4x text-primary/50"></i>
            </div>
          </div>
          <div class="flex flex-col pl-3">
            <div>
              <b>{{ singkatNama(user.name) }}</b>
            </div>
            <div class="text-white text-sm">
              {{ cutString(user.username, 35) }}
            </div>
            <div
              class="badge badge-primary align-middle select-none uppercase mt-3"
            >
              <NuxtLink :to="`/user/${user.username}`">
                <b>Lihat Profil</b>
              </NuxtLink>
            </div>
          </div>
        </li>
        <li>
          <NuxtLink to="/dashboard" class="btn-sm btn-ghost"
            ><span class="text-white/80 tracking-wider"
              >Dashboard</span
            ></NuxtLink
          >
          <NuxtLink to="/pengaturan/profil" class="btn-sm btn-ghost"
            ><span class="text-white/80 tracking-wider"
              >Pengaturan</span
            ></NuxtLink
          >
        </li>
        <li class="mt-2 pt-2">
          <a class="btn-sm btn-ghost" @click.prevent="logout">
            <b><span class="text-red-500 tracking-wider">Log Out</span></b>
          </a>
        </li>
      </ul>

      <ul
        v-if="!user"
        tabindex="0"
        class="p-2 shadow menu dropdown-content bg-base-300 rounded-box w-36 border-2 border-primary/10"
      >
        <li>
          <NuxtLink to="/login" class="btn-sm btn-ghost"
            ><span class="text-white/80 tracking-wider">Login</span></NuxtLink
          >
        </li>
        <li>
          <NuxtLink to="/register" class="btn-sm btn-ghost"
            ><span class="text-white/80 tracking-wider"
              >Register</span
            ></NuxtLink
          >
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: 'NavbarDropdownComponent',
  data: () => ({}),
  computed: {
    user() {
      return this.$store.state.user.currentUser
    },
  },
  methods: {
    cutString(value, cutto) {
      const str = String(value)
      return str.length > cutto ? value.substring(0, cutto) + '...' : value
    },
    async logout() {
      await this.$axios
        .delete(`${this.$config.apiURL}/auth/logout`)
        .then((response) => {
          localStorage.removeItem('token')
          this.$store.commit('user/setUser', null)
          window.location.reload(true)
        })
        .catch(() => {
          //   store.commit('user/setUser', '')
        })
    },
    singkatNama(name) {
      const singkat = [name[0]]
      for (let i = 0; i < name.length; i++) {
        if (name[i] === ' ') {
          singkat.push(name[i + 1])
        }
      }
      const hasil = singkat
        .map((el) => el.toUpperCase())
        .join('. ')
        .substring(6)

      const first2 = name.split(' ').slice(0, 2).join(' ')
      const lastdot = hasil ? '.' : ''
      return first2 + ' ' + hasil + lastdot
    },
  },
}
</script>
