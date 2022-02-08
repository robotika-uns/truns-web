import Vue from 'vue'

const mixin = {
  methods: {
    singkatNama(name) {
      const singkat = [name[0]]
      for (let i = 0; i < name.length; i++) {
        if (name[i] === ' ') {
          singkat.push(name[i + 1])
        }
      }
      const hasil = singkat
        .map((el) => el.toUpperCase())
        .join('. ')
        .substring(6)

      const first2 = name.split(' ').slice(0, 2).join(' ')
      const lastdot = hasil ? '.' : ''
      return first2 + ' ' + hasil + lastdot
    },
  },
}

Vue.mixin(mixin)
