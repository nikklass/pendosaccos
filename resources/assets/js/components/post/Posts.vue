<template>

    <div>

        <!-- <app-post v-for="post in postStore.posts" :post="post"></app-post> -->

    </div>

</template>

<script>

    import { mapState } from 'vuex';
    import appPost from './Post.vue'

    export default {

        components: {
            appPost: appPost
        },

        computed: {

            ...mapState({
                postStore: state => state.posts
            })

        }

    }

</script>
