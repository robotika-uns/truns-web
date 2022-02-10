export default function ({ redirect, store }) {
  const currentUser = store.state.user.currentUser

  if (currentUser) {
    if (currentUser.email_verified !== 'verified') {
      return redirect('/verify')
    }
  } else {
    return redirect('/login')
  }
}
