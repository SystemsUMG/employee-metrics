<template>
    <div class="collapse navbar-collapse w-auto h-auto h-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <sidenav-item url="/admin" :class="getRoute() === 'admin' ? 'active' : ''" navText="Dashboard">
                    <template v-slot:icon>
                        <i class="fa fa-television text-primary text-sm opacity-10"></i>
                    </template>
                </sidenav-item>
            </li>
            <li class="nav-item">
                <sidenav-item url="/users" :class="getRoute() === 'users' ? 'active' : ''" navText="Usuarios">
                    <template v-slot:icon>
                        <i class="fa fa-users text-warning text-sm opacity-10"></i>
                    </template>
                </sidenav-item>
            </li>
            <li class="nav-item">
                <sidenav-item url="/departments" :class="getRoute() === 'departments' ? 'active' : ''" navText="Departamentos">
                    <template v-slot:icon>
                        <i class="fa fa-building text-success text-sm opacity-10"></i>
                    </template>
                </sidenav-item>
            </li>
            <li class="nav-item">
                <sidenav-item url="/survey" navText="Encuesta">
                    <template v-slot:icon>
                        <i class="fa fa-list-alt text-info text-sm opacity-10 mt-0"></i>
                    </template>
                </sidenav-item>
            </li>
        </ul>
    </div>
</template>
<script>
import SidenavItem from "./SidenavItem.vue";

export default {
    name: "SidenavList",
    props: {
        cardBg: String
    },
    components: {
        SidenavItem
    },
    methods: {
        getRoute() {
            const routeArr = this.$route.path.split("/");
            return routeArr[1];
        }
    }
};
</script>
