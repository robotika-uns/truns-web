<template>
  <div>
    <label v-if="error" class="label pb-0">
      <ul>
        <li v-for="err in error" :key="err" class="list-disc text-error">
          <span
            class="
              label-text-alt
              tracking-wider
              text-error
              font-medium
              text-[10pt]
            "
            >{{ err }}</span
          >
        </li>
      </ul>
    </label>
  </div>
</template>

<script>
export default {
  name: 'InputErrorLabelComponent',
  props: {
    error: {
      type: Array,
      default: null,
    },
  },
}
</script>