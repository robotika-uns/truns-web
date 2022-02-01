// holds your root state
export const state = () => ({
    currentUser: []
})

// contains your actions
export const actions = {
    counterUp({ state, commit }) {
        commit('setCounter', state.counter + 1)
    }
}
// contains your mutations
export const mutations = {
    setUser(state, value) {
        state.currentUser = value
    }
}
// your root getters
export const getters = {
    getCurrentUser(state) { return state.currentUser }
}