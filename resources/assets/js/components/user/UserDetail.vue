<template>
    <div class="container">

        <h1>User Detail</h1>
        <p>User Loaded: {{ $route.params.id }}</p>

        <router-link
                class="btn btn-primary"
                tag="button"
                :to="link">Edit</router-link>

    </div>
</template>

<script>
    export default {
        data(){
            return {
                link: {
                    name: 'userEdit',
                    params: {
                        id: this.$route.params.id
                    },
                    query: {
                        locale: 'en',
                        q: 100
                    },
                    hash: '#data'
                }
            }
        },
        beforeRouteEnter(to, from, next){
            //proceed if user is logged in
            if (true) {
                next();
            } else {
                next(false);
            }
        }
    }
</script>
