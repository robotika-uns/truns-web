<template>
  <div>
    <div class="pt-36"></div>

    <div
      class="
        navbar
        fixed
        top-0
        left-0
        right-0
        shadow-xl
        backdrop-blur-md
        text-neutral-content
        z-50
      "
    >
      <div class="px-1 md:px-10 navbar-start">
        <NuxtLink to="/">
          <img
            src="/assets/img/logo.png"
            class="w-16 transition ease-in-out hover:scale-110 duration-200"
          />
        </NuxtLink>
      </div>
      <div class="hidden px-2 mx-2 navbar-center lg:flex">
        <div class="flex items-stretch">
          <NuxtLink
            v-for="menu in menus"
            :key="menu.text"
            class="
              px-4
              btn btn-sm
              rounded-btn
              text-lg
              tracking-widest
              transition
              ease-in-out
              hover:scale-110
              duration-200
            "
            :class="
              $route.path == menu.url ? 'font-medium' : 'btn-ghost font-light'
            "
            :to="menu.url"
          >
            {{ menu.text }}
          </NuxtLink>
        </div>
      </div>

      <div class="flex px-2 mx-2 navbar-center lg:hidden">
        <NuxtLink class="btn btn-primary" to="/pendaftaran">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            width="24"
            height="24"
          >
            <path fill="none" d="M0 0h24v24H0z" />
            <path
              d="M14 14.252V22H4a8 8 0 0 1 10-7.748zM12 13c-3.315 0-6-2.685-6-6s2.685-6 6-6 6 2.685 6 6-2.685 6-6 6zm6 4v-3h2v3h3v2h-3v3h-2v-3h-3v-2h3z"
            />
          </svg>
          &nbsp; Pendaftaran
        </NuxtLink>
      </div>

      <div class="navbar-end">
        <div class="hidden lg:flex px-5">
          <NuxtLink class="btn btn-primary tracking-wider" to="/pendaftaran">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 24 24"
              width="24"
              height="24"
            >
              <path fill="none" d="M0 0h24v24H0z" />
              <path
                d="M14 14.252V22H4a8 8 0 0 1 10-7.748zM12 13c-3.315 0-6-2.685-6-6s2.685-6 6-6 6 2.685 6 6-2.685 6-6 6zm6 4v-3h2v3h3v2h-3v3h-2v-3h-3v-2h3z"
              />
            </svg>
            &nbsp; Pendaftaran
          </NuxtLink>
        </div>

        <div class="flex lg:hidden">
          <div class="dropdown dropdown-end">
            <div tabindex="0" class="m-1 btn btn-ghost">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
              >
                <path fill="none" d="M0 0h24v24H0z" />
                <path
                  d="M3 4h18v2H3V4zm0 7h18v2H3v-2zm0 7h18v2H3v-2z"
                  class="fill-white"
                />
              </svg>
            </div>
            <ul
              tabindex="0"
              class="
                p-2
                menu
                dropdown-content
                bg-base-300
                border border-white/10
                rounded-box
                w-52
              "
            >
              <li v-for="menu in menus" :key="menu.text">
                <NuxtLink
                  class="
                    btn btn-md
                    rounded-btn
                    font-light
                    tracking-widest
                    transition
                    ease-in-out
                    hover:scale-110
                    duration-200
                  "
                  :class="$route.path == menu.url ? 'btn-neutral' : 'btn-ghost'"
                  :to="menu.url"
                >
                  {{ menu.text }}
                </NuxtLink>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'NavbarComponent',
  data: () => ({
    menus: {
      tim: {
        text: 'TIM',
        url: '/tim',
      },
      divisi: {
        text: 'DIVISI',
        url: '/divisi',
      },
      kontak: {
        text: 'KONTAK',
        url: '/kontak',
      },
    },
  }),
}
</script>
