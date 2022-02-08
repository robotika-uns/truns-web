<template>
  <div>
    <div
      class="card bg-base-100 shadow-lg shadow-black/20 transition ease-in-out duration-300 hover:shadow-lg hover:shadow-black border-2 border-primary/10 relative select-none z-10"
    >
      <div class="flex bg-base-300/50 p-5">
        <NuxtLink
          v-for="p in pengaturan"
          :key="p"
          :to="`${p.url}`"
          class="btn btn-sm w-full justify-start"
          :class="$route.path == p.url ? 'btn-primary' : 'btn-ghost'"
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
          class="bg-warning/10 pl-16 py-3 border-t-2 border-b-2 border-warning/20 font-bold uppercase text-warning"
        >
          Moderator
        </div>
        <div class="flex bg-base-300/50 p-5">
          <NuxtLink
            v-for="p in moderator"
            :key="p"
            :to="`${p.url}`"
            class="btn btn-sm w-full justify-start"
            :class="$route.path == p.url ? 'btn-primary' : 'btn-ghost'"
          >
            <i :class="`ri-${p.icon}-line ri-sm`"></i>

            &nbsp; &nbsp;
            <span class="tracking-widest normal-case font-medium">
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
  name: 'SidebarPengaturanComponent',
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
        rekrutmen: {
          icon: 'user-add',
          text: 'Rekrutmen',
          url: '/pengaturan/rekrutmen',
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
