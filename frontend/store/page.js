// holds your root state
export const state = () => ({
  title: '',
})

// contains your mutations
export const mutations = {
  setTitle(state, value) {
    state.title = value
  },
}

// your root getters
export const getters = {
  getTitle(state) {
    return state.title
  },
}
