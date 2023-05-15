<template>
    <div class="card">
        <div class="p-3 pb-0 card-header">
            <div class="d-flex align-items-center">
                <h6 class="mb-0">{{ title }}</h6>
            </div>
        </div>
        <div class="p-3 card-body">
            <div class="row">
                <div class="text-center col-5">
                    <div class="chart">
                        <canvas ref="chart-donut" class="chart-canvas" height="200"></canvas>
                    </div>
                </div>
                <div class="col-7">
                    <div class="table-responsive">
                        <table class="table mb-0 align-items-center">
                            <tbody>
                            <tr v-for="(label, index) in study_levels.labels" :key="index">
                                <td>
                                    <div class="px-2 py-0 d-flex">
                                        <span class="badge me-2" :style="{ backgroundColor: this.backgroundColors[index] }">&nbsp;</span>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ label }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-sm text-center align-middle">
                                    <span class="text-xs font-weight-bold">{{ study_levels.percentages[index] }}%</span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Chart from "chart.js/auto";

export default {
    name: "study-levels-donut-chart",
    props: ['study_levels'],
    data() {
        return {
            title: 'Nivel de Estudios',
            ctx1: '',
            donutChart: '',
            backgroundColors: [
                "#5e72e4",
                "#8392ab",
                "#11cdef",
                "#fb6340",
            ]
        };
    },
    mounted() {
        this.ctx1 =  this.$refs["chart-donut"].getContext("2d")
        this.setGraphic()
    },
    updated() {
        this.setGraphic()
    },
    methods: {
        setGraphic() {
            const gradientStroke1 = this.ctx1.createLinearGradient(0, 230, 0, 50);
            gradientStroke1.addColorStop(1, "rgba(203,12,159,0.2)");
            gradientStroke1.addColorStop(0.2, "rgba(72,72,176,0.0)");
            gradientStroke1.addColorStop(0, "rgba(203,12,159,0)");
            //Destruir grafica para actualizar datos
            if (this.donutChart) this.donutChart.destroy()
            this.donutChart = new Chart(this.ctx1, {
                type: "doughnut",
                data: {
                    labels: this.study_levels.labels,
                    datasets: [
                        {
                            label: "Consumption",
                            weight: 9,
                            tension: 0.9,
                            pointRadius: 2,
                            borderWidth: 2,
                            backgroundColor: this.backgroundColors,
                            data: this.study_levels.values,
                            fill: false,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                    interaction: {
                        intersect: false,
                        mode: "index",
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: false,
                                drawTicks: false,
                            },
                            ticks: {
                                display: false,
                            },
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: false,
                                drawTicks: false,
                            },
                            ticks: {
                                display: false,
                            },
                        },
                    },
                },
            });
        },
    }
};
</script>
