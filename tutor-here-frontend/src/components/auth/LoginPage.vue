<template>

  <div class="app flex-row align-items-center">
    <div class="container">
      <b-row class="justify-content-center">
        <b-col md="8">
          <b-card-group>
            <b-card no-body class="p-4 bg-seco">
              <b-card-body>

                <b-form @submit="onSubmit">
                  <h1>Login</h1>
                  <p class="text-muted">Sign In to your account</p>
                  <b-input-group class="mb-3">
                    <b-input-group-prepend>
                      <b-input-group-text>
                        <font-awesome-icon icon="user"/>
                      </b-input-group-text>
                    </b-input-group-prepend>
                    <b-form-input
                        v-model="form.email"
                        type="email"
                        required
                        class="form-control"
                        placeholder="Email"
                        autocomplete="email"/>
                  </b-input-group>
                  <b-input-group class="mb-4">
                    <b-input-group-prepend>
                      <b-input-group-text>
                        <font-awesome-icon icon="lock"/>
                      </b-input-group-text>
                    </b-input-group-prepend>
                    <b-form-input
                        type="password"
                        class="form-control"
                        placeholder="Password"
                        autocomplete="current-password"
                        v-model="form.password"
                        required/>
                  </b-input-group>
                  <b-row>
                    <b-col cols="6">
                      <b-button type="submit" variant="success" class="px-4">Login</b-button>
                    </b-col>
                    <b-col cols="6" class="text-right">
                      <!--<b-button variant="link" class="px-0">Forgot password?</b-button>-->
                    </b-col>
                  </b-row>
                </b-form>

              </b-card-body>
            </b-card>
            <b-card no-body class="text-white bg-primary   py-5 d-md-down-none" style="width:44%">
              <b-card-body class="text-center">
                <div>
                  <h2>Sign up</h2>
                  <p>“Better than a thousand days of diligent study is one day with a great teacher.”</p>
                  <router-link to="/register_learner">
                    <b-button variant="primary" class="active mt-3">Start Learning!</b-button>
                  </router-link>
                  <br>
                  <router-link to="/register_tutor">
                    <b-button variant="primary" class="active mt-3">Start Teaching!</b-button>
                  </router-link>
                </div>
              </b-card-body>
            </b-card>
          </b-card-group>
        </b-col>
      </b-row>
    </div>

  </div>

</template>

<script>
  export default {
    name: 'Login',
    data() {
      return {
        form: {
          email: '',
          password: '',
        },
      }
    }
    ,
    methods: {
      onSubmit(evt) {
        evt.preventDefault();
        this.$loading(true)
        console.log("hey");
        this.$http.post("auth/login", this.form,
          {
            headers: {
              'Content-Type': 'application/json',
              'X-Requested-With': 'XMLHttpRequest'
            }
          })
          .then(response => {
            this.$auth.setToken(response.body.access_token,
              response.body.expires_at, response.body.type, response.body.id)
            console.log(response);
            this.$loading(false);
            if (response.body.type == 1)
              this.$router.push("/dashboard_tutor");
            else if (response.body.type == 2)
              this.$router.push("/dashboard_learner");
          }).catch(error => {
          this.$loading(false);
          this.showError('Error in logging details. Please try again.')
          console.log("err");
          console.log(error);
          console.log(error.data);

        });
      }
      ,
      onReset(evt) {
        evt.preventDefault()
        // Reset our form values
        this.form.email = ''
        this.form.password = ''
        this.form.food = null
      },

      showError(error) {
        this.$bvModal.msgBoxOk(error, {
          title: 'Error',
          size: 'sm',
          okVariant: 'danger',
          headerBorderVariant: 'danger',
          bodyBorderVariant: 'danger',
          headerBgVariant: 'danger'
        })
          .then(value => {
          })
          .catch(err => {
            // An error occurred
          })
      }
    }
  }
</script>


<style scoped>
  /*.btn-primary, .btn-primary:hover, .btn-primary:active, .btn-primary:visited {*/
  /*background-color: #8064A2 !important;*/
  /*}*/

</style>