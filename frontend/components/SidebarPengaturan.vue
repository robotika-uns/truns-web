<template>
  <div>
    <div
      class="
        card
        bg-base-100
        shadow-lg shadow-black/20
        transition
        ease-in-out
        duration-300
        hover:shadow-lg hover:shadow-black
        border-2 border-primary/10
        relative
        select-none
        z-10
      "
    >
      <div class="flex bg-base-300/50 p-5">
        <NuxtLink
          v-for="p in pengaturan"
          :key="p"
          :to="`/pengaturan${p.url}`"
          class="btn btn-sm btn-ghost w-full justify-start"
        >
          <i :class="`ri-${p.icon}-line ri-sm`"></i>

          &nbsp; &nbsp;
          <span class="tracking-widest normal-case font-light">
            {{ p.text }}
          </span>
        </NuxtLink>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  name: 'SidebarPengaturanComponent',
  data: () => ({
    pengaturan: {
      profil: {
        icon: 'user-3',
        text: 'Profil',
        url: '/profil',
      },
    },
  }),
}
</script>
