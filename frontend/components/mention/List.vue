<template>
  <div class="bg-base-300 flex flex-col gap-1 rounded-lg shadow-xl">
    <div
      v-if="items === 'initiate'"
      class="text-center font-medium rounded-lg py-1 px-4"
    >
      Ketik username untuk mention.
    </div>
    <template v-else-if="items.length">
      <button
        v-for="(item, index) in items"
        :key="index"
        class="text-left flex flex-row items-center hover:bg-primary hover:text-black font-medium rounded-lg px-3 transition-all ease-in-out duration-300"
        :class="{ 'bg-primary text-black': index === selectedIndex }"
        @click="selectItem(index)"
      >
        <div class="w-5 h-5 mask mask-squircle bg-base-100 mr-2">
          <img v-if="item.photo" :src="item.photo" />
          <i v-else class="ri-user-3-fill ri-4x text-primary/50"></i>
        </div>
        {{ item.username }}
      </button>
    </template>
    <div v-else>
      <div class="alert alert-error rounded-lg py-1 pl-1 pr-3 m-0">
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
  </div>
</template>

<script>
export default {
  name: 'MentionListComponent',
  props: {
    items: {
      type: Array,
      required: true,
    },

    command: {
      type: Function,
      required: true,
    },
  },

  data() {
    return {
      selectedIndex: 0,
    }
  },

  watch: {
    items() {
      this.selectedIndex = 0
    },
  },

  methods: {
    onKeyDown({ event }) {
      if (event.key === 'ArrowUp') {
        this.upHandler()
        return true
      }

      if (event.key === 'ArrowDown') {
        this.downHandler()
        return true
      }

      if (event.key === 'Enter') {
        this.enterHandler()
        return true
      }

      return false
    },

    upHandler() {
      this.selectedIndex =
        (this.selectedIndex + this.items.length - 1) % this.items.length
    },

    downHandler() {
      this.selectedIndex = (this.selectedIndex + 1) % this.items.length
    },

    enterHandler() {
      this.selectItem(this.selectedIndex)
    },

    selectItem(index) {
      const item = this.items[index]

      if (item) {
        this.command({ id: item, username: item.username })
      }
    },
  },
}
</script>

