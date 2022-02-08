export default function ({ error, store }) {
  const currentUser = store.state.user.currentUser

  if (
    currentUser.role !== 'moderator' &&
    currentUser.role !== 'administrator'
  ) {
    return error({
      statusCode: 403,
    })
  }
}
