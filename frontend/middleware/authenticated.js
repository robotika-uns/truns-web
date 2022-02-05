export default function ({ $axios, $config, redirect, store }) {

    const currentUser = store.state.user.currentUser

    if (currentUser) {
        if (!(currentUser.email_verified === 'verified')) {
            return redirect('/verify')
        }
    } else {
        localStorage.removeItem('token')
        store.commit('user/setUser', '')
        return redirect('/login')
    }

}