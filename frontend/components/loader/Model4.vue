<template>
  <div>
    <svg
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 24 24"
      :width="size"
      :height="size"
      class="animate-spin m-auto"
    >
      <path fill="none" d="M0 0h24v24H0z" />
      <path
        d="M18.364 5.636L16.95 7.05A7 7 0 1 0 19 12h2a9 9 0 1 1-2.636-6.364z"
        class="fill-white"
      />
    </svg>
  </div>
</template>

<script>
export default {
  name: 'LoaderModel4Component',
  props: {
    size: {
      type: Number,
      default: 64,
    },
  },
}
</script>