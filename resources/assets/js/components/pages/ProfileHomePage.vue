<template>

        <span>

            <app-sidebar-left></app-sidebar-left>

            <app-sidebar-right></app-sidebar-right>

            <!-- content push wrapper -->
            <div class="st-pusher" id="content">

                <!-- this is the wrapper for the content -->
                <div class="st-content">

                    <!-- extra div for emulating position:fixed of the menu -->
                    <div class="st-content-inner">

                        <div class="container-fluid">

                            <profile-home></profile-home>

                        </div>

                    </div>
                    <!-- /st-content-inner -->

                </div>
                <!-- /st-content -->

            </div>
            <!-- /st-pusher -->

        </span>

</template>

<script>

    import { mapState } from 'vuex';
    import ProfileHome from './../profile/ProfileHome.vue';
    import SidebarLeft from './../includes/SidebarLeft.vue';
    import SidebarRight from './../includes/SidebarRight.vue';

    export default {

        components: {
            profileHome: ProfileHome,
            appSidebarLeft: SidebarLeft,
            appSidebarRight: SidebarRight,
        }

    }

</script>

<style>

</style>
