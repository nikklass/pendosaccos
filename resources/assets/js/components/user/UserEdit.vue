<template>
    <div class="container">

        <h1>User Edit</h1>

        <p>Locale: {{ $route.query.locale }}</p>
        <p>Q: {{ $route.query.q }}</p>

        <hr>

        <button class="btn btn-primary" @clicked="confirmed = true">Confirm</button>

    </div>
</template>

<script>
    export default {
        data(){
            return {
                confirmed: false
            }
        },
        beforeRouteLeave(to, from, next){
            //proceed if confirmed
            if (this.confirmed) {
                next();
            } else {
                if (confirm('Are you sure?')) {
                    next();
                } else {
                    next(false);
                }
            }
        }
    }
</script>
