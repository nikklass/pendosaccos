<template>

    <header class="sp-header auth-header">
      
      <app-auth-header-shared></app-auth-header-shared>

      <div class="form-group mb-0 pull-right">
         <span class="inline-block pr-10">
           Don't Have an Account Yet?
         </span>

         <router-link :to="{ name: 'register' }" >
              <a class="inline-block btn btn-info btn-rounded btn-outline">
                 Register
              </a>
          </router-link>

      </div>
      <div class="clearfix"></div>
   </header>

</template>


<script>
    
    import AuthHeaderShared from './AuthHeaderShared.vue';

    export default {

        components: {
            appAuthHeaderShared: AuthHeaderShared
        },

    }

</script>