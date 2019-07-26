<template>
  <div>
    <b-card>
      <h2>User Profile</h2>

      <b-input-group :prepend="inputOptions.fname.label" class="mt-3">
        <b-form-input :state="valuesFNameState" v-model="values.fname"
                      :disabled="inputOptions.fname.disabled" trim maxlength="44"
                      @input="$v.values.fname.$touch()"></b-form-input>
        <b-input-group-append>
          <b-button v-if="!inputOptions.fname.isEditing" variant="outline-info"
                    @click="enterEditMode(inputOptions.fname)">Edit
          </b-button>
          <b-button v-if="inputOptions.fname.isEditing" variant="outline-success"
                    @click=
                        "exitEditMode(inputOptions.fname);
             api_data.fname = values.fname;
             saveData();"
                    :disabled="this.$v.values.fname.$error">Save
          </b-button>
          <b-button v-if="inputOptions.fname.isEditing" variant="outline-danger"
                    @click="exitEditMode(inputOptions.fname);
             values.fname = api_data.fname;">X
          </b-button>
        </b-input-group-append>

        <b-form-invalid-feedback>
          <div v-if="!$v.values.fname.required">This field is required.</div>
        </b-form-invalid-feedback>
      </b-input-group>


      <b-input-group :prepend="inputOptions.lname.label" class="mt-3">
        <b-form-input :state="valuesLNameState" v-model="values.lname"
                      :disabled="inputOptions.lname.disabled" trim maxlength="44"
                      @input="$v.values.lname.$touch()"></b-form-input>
        <b-input-group-append>
          <b-button v-if="!inputOptions.lname.isEditing" variant="outline-info"
                    @click="enterEditMode(inputOptions.lname)">Edit
          </b-button>
          <b-button v-if="inputOptions.lname.isEditing" variant="outline-success"
                    @click=
                        "exitEditMode(inputOptions.lname);
             api_data.lname = values.lname;
             saveData();"
                    :disabled="this.$v.values.lname.$error">Save
          </b-button>
          <b-button v-if="inputOptions.lname.isEditing" variant="outline-danger"
                    @click="exitEditMode(inputOptions.lname);
             values.lname = api_data.lname;">X
          </b-button>
        </b-input-group-append>

        <b-form-invalid-feedback>
          <div v-if="!$v.values.lname.required">This field is required.</div>
        </b-form-invalid-feedback>
      </b-input-group>

      <b-input-group :prepend="inputOptions.email.label" class="mt-3">
        <b-form-input :state="valuesEmailState" v-model="values.email"
                      :disabled="inputOptions.email.disabled" trim maxlength="255"
                      @input="$v.values.email.$touch()"></b-form-input>
        <b-input-group-append>
          <b-button v-if="!inputOptions.email.isEditing" variant="outline-info"
                    @click="enterEditMode(inputOptions.email)">Edit
          </b-button>
          <b-button v-if="inputOptions.email.isEditing" variant="outline-success"
                    @click=
                        "exitEditMode(inputOptions.email);
             api_data.email = values.email;
             saveData();"
                    :disabled="this.$v.values.email.$error">Save
          </b-button>
          <b-button v-if="inputOptions.email.isEditing" variant="outline-danger"
                    @click="exitEditMode(inputOptions.email);
             values.email = api_data.email;">X
          </b-button>
        </b-input-group-append>

        <b-form-invalid-feedback>
          <div v-if="!$v.values.email.required">This field is required.</div>
          <div v-if="!$v.values.email.email">Invalid email.</div>
        </b-form-invalid-feedback>
      </b-input-group>

      <b-input-group :prepend="inputOptions.mobile.label" class="mt-3">
        <b-form-input :state="valuesMobileState" v-model="values.mobile"
                      :disabled="inputOptions.mobile.disabled" trim maxlength="44"
                      @input="$v.values.mobile.$touch()"></b-form-input>
        <b-input-group-append>
          <b-button v-if="!inputOptions.mobile.isEditing" variant="outline-info"
                    @click="enterEditMode(inputOptions.mobile)">Edit
          </b-button>
          <b-button v-if="inputOptions.mobile.isEditing" variant="outline-success"
                    @click=
                        "exitEditMode(inputOptions.mobile);
             api_data.mobile = values.mobile;
             saveData();"
                    :disabled="this.$v.values.mobile.$error">Save
          </b-button>
          <b-button v-if="inputOptions.mobile.isEditing" variant="outline-danger"
                    @click="exitEditMode(inputOptions.mobile);
             values.mobile = api_data.mobile;">X
          </b-button>
        </b-input-group-append>

        <b-form-invalid-feedback>
          <div v-if="!$v.values.mobile.required">This field is required.</div>
          <div v-if="!$v.values.mobile.number">This field must be a valid mobile number.</div>
        </b-form-invalid-feedback>
      </b-input-group>

      <b-input-group :prepend="inputOptions.password.label" class="mt-3">
        <b-form-input :state="valuesPasswordState" v-model="values.password"
                      :disabled="inputOptions.password.disabled" trim maxlength="44"
                      @input="$v.values.password.$touch()"></b-form-input>
        <b-input-group-append>
          <b-button v-if="!inputOptions.password.isEditing" variant="outline-info"
                    @click="enterEditMode(inputOptions.password)">Edit
          </b-button>
          <b-button v-if="inputOptions.password.isEditing" variant="outline-success"
                    @click=
                        "exitEditMode(inputOptions.password);
             api_data.password = values.password;
             saveData();"
                    :disabled="this.$v.values.password.$error">Save
          </b-button>
          <b-button v-if="inputOptions.password.isEditing" variant="outline-danger"
                    @click="exitEditMode(inputOptions.password);
             values.password = api_data.password;">X
          </b-button>
        </b-input-group-append>

        <b-form-invalid-feedback>
          <div v-if="!$v.values.password.required">This field is required.</div>
        </b-form-invalid-feedback>
      </b-input-group>

      <b-input-group :prepend="inputOptions.currencyType.label" class="mt-3">
        <b-form-input :state="valuesCurrencyTypeState" v-model="values.currencyType"
                      :disabled="inputOptions.currencyType.disabled" trim maxlength="3"
                      @input="$v.values.currencyType.$touch()"></b-form-input>
        <b-input-group-append>
          <b-button v-if="!inputOptions.currencyType.isEditing" variant="outline-info"
                    @click="enterEditMode(inputOptions.currencyType)">Edit
          </b-button>
          <b-button v-if="inputOptions.currencyType.isEditing" variant="outline-success"
                    @click=
                        "exitEditMode(inputOptions.currencyType);
             api_data.currency_type = values.currencyType;
             saveData();"
                    :disabled="this.$v.values.currencyType.$error">Save
          </b-button>
          <b-button v-if="inputOptions.currencyType.isEditing" variant="outline-danger"
                    @click="exitEditMode(inputOptions.currencyType);
             values.currencyType = api_data.currency_type;">X
          </b-button>
        </b-input-group-append>

        <b-form-invalid-feedback>
          <div v-if="!$v.values.currencyType.required">This field is required.</div>
        </b-form-invalid-feedback>
      </b-input-group>

      <h4>Locations</h4>
      <tutor-locations :idTutor="idTutor"></tutor-locations>

    </b-card>
  </div>
</template>

<script>
  import TutorLocations from './TutorLocations.vue'
  import {required, minValue, email, maxLength, alphaNum, decimal} from 'vuelidate/lib/validators'


  export default {
    name: 'TutorProfile',
    components: {
      TutorLocations
    },
    props: {
      idTutor: {
        default: 1
      }
    },
    data() {
      return {
        api_data: [],
        values: {
          fname: '',
          lname: '',
          email: '',
          mobile: '',
          password: '',
          currencyType: '',
        },
        inputOptions: {
          fname: {
            isEditing: false,
            label: 'First Name',
            value: '',
            disabled: true
          },
          lname: {
            isEditing: false,
            label: 'Last Name',
            value: '',
            disabled: true
          },
          email: {
            isEditing: false,
            label: 'Email',
            value: '',
            disabled: true
          },
          password: {
            isEditing: false,
            label: 'Password',
            value: '',
            disabled: true
          },
          mobile: {
            isEditing: false,
            label: 'Mobile No.',
            value: '',
            disabled: true
          },
          currencyType: {
            isEditing: false,
            label: 'Currency Type',
            value: '',
            disabled: true
          },
        }
      }
    },
    methods: {
      listData() {
        this.$http.get('tutors/' + this.idTutor)
          .then(response => {
            this.api_data = response.data;
            this.values.fname = this.api_data.fname;
            this.values.lname = this.api_data.lname;
            this.values.email = this.api_data.email;
            this.values.password = this.api_data.password;
            this.values.mobile = this.api_data.mobile;
            this.values.currencyType = this.api_data.currency_type;
            console.log(response.data);
          });
      },
      enterEditMode(attrib) {
        attrib.isEditing = true;
        attrib.state = null;
        attrib.disabled = false;
      },
      exitEditMode(attrib) {
        attrib.isEditing = false;
        attrib.state = null;
        attrib.disabled = true;
      },
      saveData() {
        this.$http.put('tutors/' + this.idTutor, this.api_data)
          .then(response => {
            console.log(response);
            //this.listData();
          }, error => {
            console.log(error);
          });
      }
    },
    created() {
      this.listData();
    },
    validations: {
      values: {
        fname: {
          required,
          maxLength: maxLength(255)
        },
        lname: {
          required,
          maxLength: maxLength(255)
        },
        email: {
          required,
          email
        },
        currencyType: {
          required
        },
        password: {
          required
        },
        mobile: {
          required
        }
      }
    },
    computed: {
      valuesFNameState() {
        if (!this.inputOptions.fname.isEditing)
          return null;
        else
          return (!this.$v.values.fname.$error);
      },
      valuesLNameState() {
        if (!this.inputOptions.lname.isEditing)
          return null;
        else
          return (!this.$v.values.lname.$error);
      },
      valuesEmailState() {
        if (!this.inputOptions.email.isEditing)
          return null;
        else
          return (!this.$v.values.email.$error);
      },
      valuesMobileState() {
        if (!this.inputOptions.mobile.isEditing)
          return null;
        else
          return (!this.$v.values.mobile.$error);
      },
      valuesPasswordState() {
        if (!this.inputOptions.password.isEditing)
          return null;
        else
          return (!this.$v.values.password.$error);
      },
      valuesCurrencyTypeState() {
        if (!this.inputOptions.currencyType.isEditing)
          return null;
        else
          return (!this.$v.values.currencyType.$error);
      },

    }
  }
</script>

<style scoped>
  .input-group > .input-group-prepend {
    flex: 0 0 25%;
  }

  .input-group .input-group-text {
    width: 100%;
  }
</style>