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
      <path d="M12 3a9 9 0 0 1 9 9h-2a7 7 0 0 0-7-7V3z" class="fill-white" />
    </svg>
  </div>
</template>

<script>
export default {
  name: 'LoaderModel5Component',
  props: {
    size: {
      type: Number,
      default: 64,
    },
  },
}
</script>