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

                            <profile-about></profile-about>

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
    import ProfileAbout from './../profile/ProfileAbout.vue';
    import SidebarLeft from './../includes/SidebarLeft.vue';
    import SidebarRight from './../includes/SidebarRight.vue';

    export default {

        components: {
            profileAbout: ProfileAbout,
            appSidebarLeft: SidebarLeft,
            appSidebarRight: SidebarRight,
        }

    }

</script>

<style>

</style>
