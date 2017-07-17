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

                            <profile-photos></profile-photos>

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
    import ProfilePhotos from './../profile/ProfilePhotos.vue';
    import SidebarLeft from './../includes/SidebarLeft.vue';
    import SidebarRight from './../includes/SidebarRight.vue';

    export default {

        components: {
            profilePhotos: ProfilePhotos,
            appSidebarLeft: SidebarLeft,
            appSidebarRight: SidebarRight,
        }

    }

</script>

<style>

</style>
