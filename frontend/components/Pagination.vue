<template>
  <div>
    <div v-if="!(page == 1 && total == 1)">
      <div class="btn-group justify-center">
        <button
          class="btn btn-sm"
          :class="{ 'btn-disabled': page == 1 }"
          @click="
            $parent.filters.page -= 1
            $parent.$fetch()
          "
        >
          «
        </button>
        <button
          v-for="(n, index) in total"
          :key="index"
          class="btn btn-sm"
          :class="{
            'btn-primary btn-disabled': n == $parent.filters.page,
            'btn-disabled':
              (n > 1 && n < 3 && n < $parent.filters.page - 1 && total > 5) ||
              (n > total - 2 &&
                n < total &&
                n > $parent.filters.page + 1 &&
                total > 5),
            hidden:
              (n > 2 && n < $parent.filters.page - 2) ||
              (n < total - 1 && n > $parent.filters.page + 2),
          }"
          @click="
            $parent.filters.page = n
            $parent.$fetch()
          "
          v-text="
            (n > 1 && n < 3 && n < $parent.filters.page - 1 && total > 5) ||
            (n > total - 2 &&
              n < total &&
              n > $parent.filters.page + 1 &&
              total > 5)
              ? '...'
              : n
          "
        ></button>
        <button
          class="btn btn-sm"
          :class="{ 'btn-disabled': page == total }"
          @click="
            $parent.filters.page += 1
            $parent.$fetch()
          "
        >
          »
        </button>
      </div>
      <div class="text-center opacity-50 mt-2 font-normal">
        Halaman <b>{{ page }}</b> dari total <b>{{ total }}</b>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PaginationComponenet',
  props: {
    page: {
      type: Number,
      default: 1,
    },
    total: {
      type: Number,
      default: 0,
    },
    perPage: {
      type: Number,
      default: 10,
    },
  },
}
</script>