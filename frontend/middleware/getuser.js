export default async function ({ $axios, $config, store }) {
  const token = localStorage.getItem('token')
  let options

  if (token) {
    options = {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }
    await $axios
      .get(`${$config.apiURL}/auth/whoami`, options)
      .then((response) => {
        store.commit('user/setUser', response.data.data.user)
      })
      .catch(() => {
        store.commit('user/setUser', '')
      })
  } else {
    store.commit('user/setUser', '')
  }
}
