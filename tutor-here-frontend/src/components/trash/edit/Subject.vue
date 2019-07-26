<template>
  <div>
    <b-card>
          <h2>Edit Subject</h2>
          <b-form @submit="onSubmit" @reset="onReset" v-if="show">
              <b-form-group id="input-group-1" label="Subject Name:" label-for="input-1">

                <b-form-input 
                  id="input-1" 
                  placeholder="Enter the name for subject" 
                  :state="formNameState"  
                  list="my-list-subjects_names" 
                  v-model="form.name" 
                  trim 
                  maxlength="255"
                  @input="$v.form.name.$touch()"
                  aria-describedby="input-1-live-feedback">
                </b-form-input>

                <datalist v-if="form.name.length >= 2" id="my-list-subjects_names" >
                  <option v-for="item in subjects_names">{{ item }}</option>
                </datalist>

                <b-form-invalid-feedback id="input-1-live-feedback">
                  <div v-if="!$v.form.name.required">This field is required.</div>
                  <div v-if="!$v.form.name.maxLength">Length must not be over 255 characters.</div>
                </b-form-invalid-feedback>

              </b-form-group>


              <b-form-group id="input-group-2" label="Grade/Level/Year:" label-for="input-2">

                <b-form-input 
                  id="input-2" 
                  placeholder="Enter the level" 
                  :state="formGradeState"  
                  list="my-list-subjects_grade" 
                  v-model="form.grade" 
                  trim 
                  maxlength="45"
                  @input="$v.form.grade.$touch()"
                  aria-describedby="input-2-live-feedback">
                </b-form-input>

                <datalist v-if="form.grade.length >= 1" id="my-list-subjects_grade" >
                  <option v-for="item in subjects_grade">{{ item }}</option>
                </datalist>

                <b-form-invalid-feedback id="input-2-live-feedback">
                  <div v-if="!$v.form.grade.required">This field is required.</div> 
                </b-form-invalid-feedback>
                
              </b-form-group>


              <b-form-group id="input-group-3" label="Syllabus Type:" label-for="input-3" description="Where the syllabus from? E.g.: Sri Lanka, Cambridge, London">

                <b-form-input 
                  id="input-3" 
                  placeholder="Enter the syllabus type" 
                  :state="formSyllabusFromState"  
                  list="my-list-syllabus_from" 
                  v-model="form.syllabus_from" 
                  trim 
                  maxlength="255"
                  @input="$v.form.syllabus_from.$touch()"
                  aria-describedby="input-3-live-feedback">
                </b-form-input>

                <datalist v-if="form.syllabus_from.length >= 2" id="my-list-syllabus_from" >
                  <option v-for="item in subjects_syllabus_from">{{ item }}</option>
                </datalist>

                <b-form-invalid-feedback id="input-3-live-feedback">
                  <div v-if="!$v.form.syllabus_from.required">This field is required.</div> 
                </b-form-invalid-feedback>
                
              </b-form-group>

              <b-form-group id="input-group-4" label="Hourly Fee:" label-for="input-4" description="Amount of money charged per hour.">
                <b-form-input
                  id="input-4" v-model="form.hourly_rate"  placeholder="Enter the hourly rate" 
                  @input="$v.form.hourly_rate.$touch()" :state="formHourlyRateState" 
                  aria-describedby="input-4-live-feedback">  
                </b-form-input>  

                <b-form-invalid-feedback id="input-4-live-feedback">
                  <div v-if="!$v.form.hourly_rate.required">This field is required.</div> 
                  <div v-if="!$v.form.hourly_rate.minValue">Fee must be a positive value.</div> 
                </b-form-invalid-feedback>
              </b-form-group>

          <b-button type="submit" variant="primary" :disabled="SubmitDisabled">Add Subject</b-button>
          <b-button type="reset" variant="danger">Reset</b-button>
        </b-form>

        <!-- <b-card class="mt-3" header="Form Data Result">
          <pre class="m-0">{{ form }}</pre>
        </b-card> -->

     </b-card>
  </div>
</template>

<script>
  import { required, minValue, maxLength , alphaNum, decimal } from 'vuelidate/lib/validators'

  export default {
    name: 'CreateSubject',
    props: ['idTutor'],
    data() {
      return {
        form: { 
          name: '',
          grade: '',
          hourly_rate: null,
          syllabus_from: '',
          Tutor_idTutor: 3
        },
        show: true,
        subjects_names: ['Herbology'],
        subjects_syllabus_from: [],
        subjects_grade: [],
      }
    },
    methods: {
      onSubmit(evt) {
        evt.preventDefault()
        //alert(JSON.stringify(this.form))
        this.$http.post('subjects', this.form)
        .then(response => {
          console.log(response);
        }, error => {
          console.log(error);
        });
      },
      onReset(evt) {
        evt.preventDefault()
        // Reset our form values
        this.form.name = ''
        this.form.grade = ''
        this.form.hourly_rate = null 
        this.form.syllabus_from = ''
        // Trick to reset/clear native browser form validation state
        this.show = false
        this.$nextTick(() => {
          this.show = true
        })
      },
    },
    created() {
      this.$http.get('subjects_dist')
        .then(response => {
          console.log(response.data);
          this.subjects_names.push(...response.data.names);
          this.subjects_syllabus_from.push(...response.data.types); 
          this.subjects_grade.push(...response.data.grades); 
        });
    },
    validations: {
      form:{
          name: {
            required,
            maxLength: maxLength(255)
          },
          grade: {
            required
          },
          syllabus_from: {
            required
          },
          hourly_rate: {
            minValue: minValue(0),
            required
        }
      }
    },
    computed: {
      formNameState () {
        if(!this.$v.form.name.$dirty) 
          return null;
        else 
          return (!this.$v.form.name.$error);
      },
      formGradeState () {
        if(!this.$v.form.grade.$dirty) 
          return null;
        else 
          return (!this.$v.form.grade.$error);
      },
      formSyllabusFromState () {
        if(!this.$v.form.syllabus_from.$dirty) 
          return null;
        else 
          return (!this.$v.form.syllabus_from.$error);
      },
      formHourlyRateState () {
        if(!this.$v.form.hourly_rate.$dirty) 
          return null;
        else 
          return (!this.$v.form.hourly_rate.$error);
      },
      SubmitDisabled () {
        if(this.$v.$invalid) return true;
        else return false;
      }
    }
  }
</script> 

<style scoped>
    
</style>