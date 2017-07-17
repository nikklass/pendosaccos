<template>

        <span class="full-width-left">

            <!-- <app-sidebar-left></app-sidebar-left> -->

            <app-sidebar-right></app-sidebar-right>

            <!-- content push wrapper -->
            <div class="st-pusher" id="content">

                <!-- this is the wrapper for the content -->
                <div class="st-content">

                    <!-- extra div for emulating position:fixed of the menu -->
                    <div class="st-content-inner">

                        <div class="container-fluid">

                            <chat-page></chat-page>

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
    import ChatPage from './../chat/ChatPage.vue';
    import SidebarLeft from './../includes/SidebarLeft.vue';
    import SidebarRight from './../includes/SidebarRight.vue';

    export default {

        components: {
            chatPage: ChatPage,
            appSidebarLeft: SidebarLeft,
            appSidebarRight: SidebarRight,
        }

    }

</script>

<style>

</style>
