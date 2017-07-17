<template>

    <div>

        <app-header></app-header>

        <app-sidebar-left></app-sidebar-left>

        <app-sidebar-right></app-sidebar-right>

        <app-settings-right></app-settings-right>

        <app-sidebar-backdrop-right></app-sidebar-backdrop-right>

    </div>

</template>

<script>

    import Header from './Header.vue';
    import SidebarLeft from './SidebarLeft.vue';
    import SidebarRight from './SidebarRight.vue';
    import SettingsRight from './SettingsRight.vue';
    import SidebarBackdropRight from './SidebarBackdropRight.vue';

    export default {

        components: {
            appHeader: Header,
            appSidebarLeft: SidebarLeft,
            appSidebarRight: SidebarRight,
            appSettingsRight: SettingsRight,
            appSidebarBackdropRight: SidebarBackdropRight
        }

    }

</script>