<template>
    <div>
        <b-card>
            <h2>Title</h2>
            <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                <!---->
                <b-form-group id="input-group-1" :label="input1.label" label-for="input-1">
                    <b-form-input
                            v-model="input1.data" state="formNameState" id="input-1"
                            :placeholder="input1.placeholder"
                            aria-describedby="input-1-live-feedback"
                            :list="input1.list"
                            trim :maxlength="input1.maxLength"
                            @input="$v.input1.data.$touch()">
                    </b-form-input>

                    <datalist id="input-1-list" >
                        <option v-for="item in input1.list" >{{ item }}</option>
                    </datalist>

                    <b-form-invalid-feedback id="input-1-live-feedback">
                        <div v-if="!$v.input1.data.required">This field is required.</div>
                        <div v-if="!$v.form.name.maxLength">Length must not be over 255 characters.</div>
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
                input1: {
                    label: "Label1",
                    data: "",
                    state: true,
                    placeholder: "ThisIsPlaceholder",
                    list: ['aaa','bbb'],
                    maxLength: 255,

                },

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
            input1: {
                data: {
                    required
                }
            },
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
                if(!this.$v.input1.data.$dirty)
                    return null;
                else
                    return (!this.$v.input1.data.$error);
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