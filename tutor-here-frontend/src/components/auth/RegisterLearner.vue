<template>
  <div class="app flex-row align-items-center">
    <div class="container">
      <b-row class="justify-content-center">
        <b-col md="6" sm="8">
          <b-card no-body class="mx-4">
            <b-card-body class="p-4">
              <b-form @submit="onSubmit">
                <h1>Learner Sign-up</h1>
                <p class="text-muted">Create your account</p>
                <b-input-group class="mb-3">
                  <b-input-group-prepend>
                    <b-input-group-text>
                      <i class="icon-user"></i>
                    </b-input-group-text>
                  </b-input-group-prepend>
                  <b-form-input
                    type="text"
                    class="form-control"
                    placeholder="First Name"
                    autocomplete="text"
                    required
                    v-model="form.fname"
                  />
                </b-input-group>

                <b-input-group class="mb-3">
                  <b-input-group-prepend>
                    <b-input-group-text>
                      <i class="icon-user"></i>
                    </b-input-group-text>
                  </b-input-group-prepend>
                  <b-form-input
                    type="text"
                    class="form-control"
                    placeholder="Last Name"
                    autocomplete="text"
                    required
                    v-model="form.lname"
                  />
                </b-input-group>

                <b-input-group class="mb-3">
                  <b-input-group-prepend>
                    <b-input-group-text>@</b-input-group-text>
                  </b-input-group-prepend>
                  <b-form-input
                    type="email"
                    class="form-control"
                    placeholder="Email"
                    autocomplete="email"
                    required
                    v-model="form.email"
                  />
                </b-input-group>

                <b-input-group class="mb-3">
                  <b-input-group-prepend>
                    <b-input-group-text>
                      <i class="icon-lock"></i>
                    </b-input-group-text>
                  </b-input-group-prepend>
                  <b-form-input
                    type="password"
                    class="form-control"
                    placeholder="Password"
                    autocomplete="new-password"
                    required
                    v-model="form.password"
                  />
                </b-input-group>

                <!--<b-input-group class="mb-4">-->
                <!--<b-input-group-prepend>-->
                <!--<b-input-group-text><i class="icon-lock"></i></b-input-group-text>-->
                <!--</b-input-group-prepend>-->
                <!--<b-form-input type="passwo  rd" class="form-control" placeholder="Repeat password" autocomplete="new-password"-->
                <!--required v-model="form.password_confirmation"/>-->
                <!--</b-input-group>-->

                <b-button type="submit" variant="success" block>Create Account</b-button>
              </b-form>
            </b-card-body>
            <!--<b-card-footer class="p-4">-->
            <!--<b-row>-->
            <!--<b-col cols="6">-->
            <!--<b-button block class="btn btn-facebook"><span>facebook</span></b-button>-->
            <!--</b-col>-->
            <!--<b-col cols="6">-->
            <!--<b-button block class="btn btn-twitter" type="button"><span>twitter</span></b-button>-->
            <!--</b-col>-->
            <!--</b-row>-->
            <!--</b-card-footer>-->
          </b-card>
        </b-col>
      </b-row>
    </div>
  </div>
</template>

<script>
export default {
  name: "RegisterTutor",
  data() {
    return {
      form: {
        type: "2",
        email: "tharindu.sathis@gmail.com",
        password_confirmation: "",
        password: "password",
        fname: "a",
        lname: "b"
      },
      error: null
    };
  },
  methods: {
    onSubmit(evt) {
      evt.preventDefault();
      this.form.password_confirmation = this.form.password;
      this.$http
        .post("auth/signup", this.form, {
          headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest"
          }
        })
        .then(response => {
          console.log("res");
          console.log(response);
          this.$router.push("/login");
        })
        .catch(error => {
          console.log("err");
          console.log(error);
          console.log(error.data);
          if (error) {
            /*
             * The request was made and the server responded with a
             * status code that falls out of the range of 2xx
             */
            console.log(error.body);
            console.log(error.status);
            console.log(error.headers);
          } else if (error.request) {
            /*
             * The request was made but no response was received, `error.request`
             * is an instance of XMLHttpRequest in the browser and an instance
             * of http.ClientRequest in Node.js
             */
            console.log(error.request);
          } else {
            // Something happened in setting up the request and triggered an Error
            console.log("Error", error.message);
          }
          console.log(error.config);
        });
    },
    onReset(evt) {
      evt.preventDefault();
      // Reset our form values
      this.form.email = "";
      this.form.password = "";
      this.form.fname = "";
      this.form.lname = "";
    }
  }
};
</script>
