<template>

    <div class="app flex-row align-items-center">
        <div class="container">
            <b-row class="justify-content-center">
                <b-col md="8">
                    <b-card-group>
                        <b-card no-body class="p-4">
                            <b-card-body>

                                <b-form @submit="onSubmit">
                                    <h1>Login</h1>
                                    <p class="text-muted">Sign In to your account</p>
                                    <b-input-group class="mb-3">
                                        <b-input-group-prepend><b-input-group-text><i class="icon-user"></i></b-input-group-text></b-input-group-prepend>
                                        <b-form-input
                                                v-model="form.email"
                                                type="email"
                                                required
                                                class="form-control"
                                                placeholder="Email"
                                                autocomplete="email" />
                                    </b-input-group>
                                    <b-input-group class="mb-4">
                                        <b-input-group-prepend><b-input-group-text><i class="icon-lock"></i></b-input-group-text></b-input-group-prepend>
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
                                            <b-button variant="link" class="px-0">Forgot password?</b-button>
                                        </b-col>
                                    </b-row>
                                </b-form>

                            </b-card-body>
                        </b-card>
                        <b-card no-body class="text-white bg-success py-5 d-md-down-none" style="width:44%">
                            <b-card-body class="text-center">
                                <div>
                                    <h2>Sign up</h2>
                                    <p>“Better than a thousand days of diligent study is one day with a great teacher.”</p>
                                    <b-button variant="primary" class="active mt-3">Start Learning!</b-button><br>
                                    <b-button variant="primary" class="active mt-3">Start Teaching!</b-button>
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
                    email: 'emma@up.lk',
                    password: 'password',
                },
            }
        },
        methods: {
            onSubmit(evt) {
                evt.preventDefault();
                console.log("hey");
                this.$http.post("auth/login", this.form,
                    {
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then( response => {
                        this.$auth.setToken(response.body.access_token, response.body.expires_at)
                        console.log(response);
                        this.$router.push("/dashboard");
                    })
            },
            onReset(evt) {
                evt.preventDefault()
                // Reset our form values
                this.form.email = ''
                this.form.password = ''
                this.form.food = null
            }
        }
    }
</script>


<style scoped>
    /*.btn-primary, .btn-primary:hover, .btn-primary:active, .btn-primary:visited {*/
        /*background-color: #8064A2 !important;*/
    /*}*/

</style>