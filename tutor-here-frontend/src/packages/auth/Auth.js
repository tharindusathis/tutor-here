import SecureLS from 'secure-ls';

export default function (Vue) {
  let localStorage = new SecureLS({encodingType: 'aes'});

  Vue.auth = {
    setToken(token, expiration, type, id) {
      localStorage.set('token', token)
      localStorage.set('expiration', expiration)
      localStorage.set('type', type)
      localStorage.set('id', id);
    },
    getToken() {
      let token = localStorage.get('token')
      let expiration = localStorage.get('expiration')
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
      let id = localStorage.get('id');
      return parseInt(id)
    },
    getType() {
      let t = localStorage.get('type');
      return t
    },
    destroyToken() {
      localStorage.remove('token')
      localStorage.remove('expiration')
      localStorage.remove('type')
      localStorage.remove('id')
    },
    isAuthenticated() {
      if (this.getToken())
        return true
      else
        return false
    }
    // ,
    // encrypt(m) {
    //   return CryptoJS.AES.encrypt(m, KEY).toString();
    // },
    // decrypt(c) {
    //   let decryptedBytes = CryptoJS.AES.decrypt(c, KEY);
    //   return decryptedBytes.toString(CryptoJS.enc.Utf8);
    // }
  }


  Object.defineProperties(Vue.prototype, {
    $auth: {
      get: () => {
        return Vue.auth
      }
    }
  })
}

//
// import CryptoJS from 'crypto-js';
// import SecureLS from 'secure-ls'
//
// export default function (Vue) {
//   let ls = new SecureLS({encodingType: 'aes'});
//   ls.set('key1', {data: 'test'}); // set key1
//
//   Vue.auth = {
//     setToken(token, expiration, type, id) {
//       localStorage.setItem('token', token)
//       localStorage.setItem('expiration', expiration)
//       localStorage.setItem('type', type)
//       localStorage.setItem('id', id);
//
//     },
//     getToken() {
//       let token = localStorage.getItem('token')
//       let expiration = localStorage.getItem('expiration')
//       if (!token || !expiration)
//         return null
//
//
//       // if(Date.now() > parseInt(expiration)){
//       //     this.destroyToken()
//       //     return null
//       // }else
//       //     return token
//       return token
//
//     },
//     getId() {
//       let id = localStorage.getItem('id');
//       console.log("get id");
//       console.log("get id  ", id);
//       return parseInt(id)
//     },
//     getType() {
//       let t = localStorage.getItem('type');
//       console.log("type ", t);
//       return parseInt(t)
//     },
//     destroyToken() {
//       localStorage.removeItem('token')
//       localStorage.removeItem('expiration')
//       localStorage.removeItem('type')
//       localStorage.removeItem('id')
//     },
//     isAuthenticated() {
//       if (this.getToken())
//         return true
//       else
//         return false
//     }
//     // ,
//     // encrypt(m) {
//     //   return CryptoJS.AES.encrypt(m, KEY).toString();
//     // },
//     // decrypt(c) {
//     //   let decryptedBytes = CryptoJS.AES.decrypt(c, KEY);
//     //   return decryptedBytes.toString(CryptoJS.enc.Utf8);
//     // }
//   }
//
//
//   Object.defineProperties(Vue.prototype, {
//     $auth: {
//       get: () => {
//         return Vue.auth
//       }
//     }
//   })
// }
//
