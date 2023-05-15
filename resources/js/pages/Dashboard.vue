<template>
    <div class="py-4 container-fluid">
        <div class="row">
            <div class="col-lg-7">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-12" v-for="(total, index) in totals" :key="index">
                        <kpis-card
                            :title="total.title"
                            :value="total.value"
                            :iconClass="total.iconClass"
                            :iconBackground="total.iconBackground"
                            directionReverse/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 mb-lg">
                        <div class="card z-index-2">
                            <departments-line-chart :departments="departments"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="row">
                    <div class="col-lg-12">
                        <study-levels-donut-chart :study_levels="study_levels"/>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <categories-card/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-12">
                <kpis-table :users="users"/>
            </div>
        </div>
    </div>
</template>
<script>
import KpisCard from "../layouts/auth/cards/KpisCard.vue";
import DepartmentsLineChart from "../layouts/auth/charts/DepartmentsLineChart.vue";
import CategoriesCard from "../views/components/CategoriesCard.vue";
import KpisTable from "../layouts/auth/tables/KpisTable.vue";
import {showToast} from "../helpers";
import StudyLevelsDonutChart from "../layouts/auth/charts/StudyLevelsDonutChart.vue";

export default {
    name: "dashboard-default",
    data() {
        return {
            users: [],
            totals: [],
            departments: {
                labels: [],
                values: []
            },
            study_levels: {
                labels: [],
                values: [],
                percentages: []
            },
        };
    },
    components: {
        StudyLevelsDonutChart,
        KpisCard,
        DepartmentsLineChart,
        CategoriesCard,
        KpisTable,
    },
    mounted() {
        const loader = this.$showLoader()
        let _this = this
        setTimeout(function () {
            axios({url: '/kpis', method: 'GET'})
                .then((resp) => {
                    if (resp.data.result) {
                        _this.users = resp.data.records.users
                        _this.totals = resp.data.records.totals
                        _this.departments = resp.data.records.departments
                        _this.study_levels = resp.data.records.study_levels
                        _this.icon = "success"
                    }
                    _this.message = resp.data.message
                    showToast(_this.icon, _this.message)
                    loader.hide()
                })
                .catch((err) => {
                    showToast()
                    loader.hide()
                })
        }, 1000)
    },
};
</script>
