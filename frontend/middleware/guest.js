export default function ({ redirect, store }) {
  const currentUser = store.state.user.currentUser

  if (currentUser) {
    return redirect('/dashboard')
  } else {
    localStorage.removeItem('token')
    store.commit('user/setUser', '')
  }
}
