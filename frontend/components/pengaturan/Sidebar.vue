<template>
  <div>
    <div
      class="card bg-base-100 shadow-lg shadow-black/20 transition ease-in-out duration-300 hover:shadow-lg hover:shadow-black border-2 border-primary/10 relative select-none z-10"
    >
      <div class="flex flex-col bg-base-300/50 p-5 gap-2">
        <NuxtLink
          v-for="p in pengaturan"
          :key="p.url"
          :to="`${p.url}`"
          class="btn btn-sm w-full justify-start transition-all ease-in-out duration-300 tracking-widest hover:pl-5"
          :class="
            $route.path == p.url ? 'btn-primary btn-disabled pl-5' : 'btn-ghost'
          "
        >
          <i :class="`ri-${p.icon}-line ri-sm`"></i>

          &nbsp; &nbsp;
          <span class="tracking-widest normal-case font-medium">
            {{ p.text }}
          </span>
        </NuxtLink>
      </div>

      <div v-if="user.role === 'moderator' || user.role === 'administrator'">
        <div
          class="bg-warning/10 pl-7 py-3 border-t-2 border-b-2 border-warning/20 font-bold uppercase text-warning"
        >
          &nbsp; Moderator
        </div>
        <div class="flex flex-col bg-base-300/50 p-5 gap-2">
          <NuxtLink
            v-for="p in moderator"
            :key="p.url"
            :to="`${p.url}`"
            class="btn btn-sm w-full justify-start transition-all ease-in-out duration-300 tracking-widest hover:pl-5"
            :class="
              $route.path == p.url
                ? 'btn-primary btn-disabled pl-5'
                : 'btn-ghost'
            "
          >
            <i :class="`ri-${p.icon}-line ri-sm`"></i>

            &nbsp; &nbsp;
            <span class="normal-case font-medium">
              {{ p.text }}
            </span>
          </NuxtLink>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PengaturanSidebarComponent',
  data() {
    return {
      pengaturan: {
        profil: {
          icon: 'user-3',
          text: 'Profil',
          url: '/pengaturan/profil',
        },
      },
      moderator: {
        user: {
          icon: 'team',
          text: 'User',
          url: '/pengaturan/user',
        },
        rekrutmen: {
          icon: 'user-add',
          text: 'Rekrutmen',
          url: '/pengaturan/rekrutmen',
        },
        log: {
          icon: 'booklet',
          text: 'Log',
          url: '/pengaturan/log',
        },
      },
    }
  },
  computed: {
    user() {
      return this.$store.state.user.currentUser
    },
  },
}
</script>
