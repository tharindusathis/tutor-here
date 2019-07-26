export default function (Vue) {
  Vue.auth = {
    setToken(token, expiration, type, id) {
      localStorage.setItem('token', token)
      localStorage.setItem('expiration', expiration)
      localStorage.setItem('type', type)
      localStorage.setItem('id', id)
    },
    getToken() {
      let token = localStorage.getItem('token')
      let expiration = localStorage.getItem('expiration')
      if (!token || !expiration)
        return null

      // if(Date.now() > parseInt(expiration)){
      //     this.destroyToken()
      //     return null
      // }else
      //     return token
      return token

    },
    getId() {
      let id = localStorage.getItem('id')
      return parseInt(id)
    },
    getType() {
      let t = localStorage.getItem('type')
      return t
    },
    destroyToken() {
      localStorage.removeItem('token')
      localStorage.removeItem('expiration')
      localStorage.removeItem('type')
      localStorage.removeItem('id')
    },
    isAuthenticated() {
      if (this.getToken())
        return true
      else
        return false
    }
  }

  Object.defineProperties(Vue.prototype, {
    $auth: {
      get: () => {
        return Vue.auth
      }
    }
  })
}
