<template>

  <div class="app flex-row align-items-center">
    <b-card>

      <div class="qlt-confirmation">
        <div class="panel panel-default">
          <div class="panel-body" align-items-center aling="center">

            <img class="mx-auto d-block"
                 src="https://cdn4.iconfinder.com/data/icons/social-communication/142/open_mail_letter-512.png"
                 style="width:30px; height: 30px;">
            <p class="desc"> <h5 align="center">Thank you for signing up!</h5>
            <h6>
              <br>We've sent a confirmation link on your email. Please visit
              your email.</h6>
            <router-link to="/login">
              <br>
              <b-button variant="success" block>Continue to Login Page</b-button>
              <br>
            </router-link>


            <p class="notice">Note:<br>You could only <b>sign in</b> to your account after email confirmation. This is
              part of our security policy.</p>
          </div>
        </div>
      </div>
    </b-card>
  </div>

</template>

<script>
  export default {
    name: 'RegisterSuccessful',
    data() {
      return {}
    }
    ,
    methods: {}
  }
</script>


<style scoped>
  /*.btn-primary, .btn-primary:hover, .btn-primary:active, .btn-primary:visited {*/
  /*background-color: #8064A2 !important;*/
  /*}*/
  /* CSS used here will be applied after bootstrap.css */
  .qlt-confirmation {
    width: 30%;
    margin: 10px auto;
  }

  .qlt-confirmation .panel-body {
    width: 99%;
    margin: 0 auto;
    padding: 40px 10px;
  }

  .qlt-confirmation .panel-body .desc {
    margin: 10px auto;
  }

  .qlt-confirmation .panel-body .notice {
    padding: 0px 20px;
    margin-top: 50px;
    text-align: left;
    font-style: italic;
    color: gray;
  }
</style>
