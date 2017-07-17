<template>

    <header class="sp-header auth-header">
      
      <app-auth-header-shared></app-auth-header-shared>

      <div class="form-group mb-0 pull-right">
         <span class="inline-block pr-10">
           Already Have an Account?
         </span>

         <router-link :to="{ name: 'login' }" >
              <a class="inline-block btn btn-info btn-rounded btn-outline">
                 Login
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