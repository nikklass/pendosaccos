<template>
    <div class="container">
        <h1>User</h1>
        <hr>
        <button @click="goHome" class="btn btn-primary">Go Home</button>
        <hr>
        <router-view></router-view>
    </div>
</template>

<script>
    export default {
        methods: {
            goHome(){
                this.$router.push('/');
            }
        }
    }
</script>
