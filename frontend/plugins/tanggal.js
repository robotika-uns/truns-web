import Vue from 'vue'
import { parseJSON, formatRelative } from 'date-fns'
import { id } from 'date-fns/locale'

const mixin = {
  methods: {
    tanggal(date) {
        return formatRelative(new Date(parseJSON(date)), new Date(), {
          addSuffix: true,
          locale: id,
        })
      },
  },
}

Vue.mixin(mixin)
