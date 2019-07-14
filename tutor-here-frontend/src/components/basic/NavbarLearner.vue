<template>
    <div>

        <b-navbar  toggleable="lg" class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container">
                <b-navbar-brand href="#">TutorHere</b-navbar-brand>

                <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

                <b-collapse id="nav-collapse" is-nav>
                    <b-navbar-nav>
                        <b-nav-item href="#">Subjects</b-nav-item>
                        <b-nav-item href="#">Tutors</b-nav-item>
                    </b-navbar-nav>

                    <!-- Right aligned nav items -->
                    <b-navbar-nav class="ml-auto">

                        <b-nav-item-dropdown text="Notificiations" right>
                            <b-dropdown-item href="#" v-for="item in notifications">
                                {{item}}
                            </b-dropdown-item>
                        </b-nav-item-dropdown>

                        <b-nav-item-dropdown text="Messages" right>
                            <b-dropdown-item href="#" v-for="item in messages">
                                {{item}}
                            </b-dropdown-item>
                        </b-nav-item-dropdown>

                        <b-nav-item-dropdown text="User" right>
                            <b-dropdown-item href="#">Profile</b-dropdown-item>
                            <b-dropdown-item href="#">Sign Out</b-dropdown-item>
                        </b-nav-item-dropdown>

                    </b-navbar-nav>
                </b-collapse>
            </div>
        </b-navbar>
    </div>
</template>

<script>
    export default {
        name: 'NavbarLearner',
        data() {
            return {
                notifications : ['THis is good', 'Yeah sure'],
                messages : ['Msg 1', 'Dr Doe'],
            }
        },
        methods: {
        }
    }
</script>

<style scoped>

</style>