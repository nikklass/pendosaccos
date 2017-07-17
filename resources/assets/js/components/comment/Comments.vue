<template>
    <div>
        <!-- {{ comments }} -->
        <!-- <div v-if="comments.length">
            <app-post-comment 
                v-for="comment in comments" 
                :comment="comment" 
                :post="post">  
            </app-post-comment>
        </div> -->
    </div>
</template>
<script>

    import Comment from './Comment.vue'

    export default{

        props: ['post', 'comments'],

        components: {
            appPostComment: Comment
        }

    }

</script>