<template>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                <app-header></app-header>
                <router-view></router-view>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                <h1>Register User</h1>
                <div class="form-group">
                    <label>First Name</label>
                    <input class="form-control" type="text" v-model="user.first_name">
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input class="form-control" type="text" v-model="user.last_name">
                </div>
                <div class="form-group">
                    <label>Mail</label>
                    <input class="form-control" type="text" v-model="user.email">
                </div>
                <button class="btn btn-primary" @click="submit">Submit</button>
                <hr>
                <input class="form-control" type="text" v-model="node">
                <br><br>
                <button class="btn btn-primary" @click="fetchData">Get Data</button>
                <br><br>
                <ul class="list-group">
                    <li class="list-group-item" v-for="u in users">{{ u.first_name }} {{ u.last_name }} - {{ u.email }}</li>
                </ul>
            </div>
        </div>

    </div>
</template>

<script>
    import Header from './components/Header.vue';

    export default {
        data() {
            return {
                user: {
                    first_name: '',
                    last_name: '',
                    email: ''
                },
                users: [],
                resource: {},
                node: 'data'
            };
        },
        methods: {
            submit() {
                this.$http.post('user/register', this.user)
                    .then(response => {
                        console.log(response);
                    }, error => {
                        console.log(error);
                    });
                //this.resource.save({}, this.user);
                // this.resource.registerUser(this.user);
            },
            fetchData() {
                this.resource.getData({node: this.node})
                    .then(response => {
                        return response.json();
                    })
                    .then(data => {
                        const resultArray = [];
                        for (let key in data) {
                            resultArray.push(data[key]);
                        }
                        this.users = resultArray;
                    });
            }
        },
        created() {
            const customActions = {
                saveData: {method: 'POST'},
                getData: {method: 'GET'}
            };
            this.resource = this.$resource('{node}.json', {}, customActions);
        },
        components: {
            appHeader: Header
        }
    }
</script>

<style>
</style>
