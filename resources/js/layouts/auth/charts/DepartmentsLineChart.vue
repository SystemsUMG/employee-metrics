<template>
    <div class="card">
        <div class="pb-0 card-header mb-0">
            <h6>{{ title }}</h6>
            <p class="text-sm">
                <span class="font-weight-bold">{{ description }}</span>
            </p>
        </div>
        <div class="p-3 card-body">
            <div class="chart">
                <canvas ref="chart-line" class="chart-canvas" height="300"></canvas>
            </div>
        </div>
    </div>
</template>

<script>
import Chart from "chart.js/auto";

export default {
    name: "gradient-line-chart",
    props: ['departments'],
    data() {
        return {
            title: 'Departamentos',
            description: 'Cantidad de empleados por departamento',
            ctx1: '',
            lineChart: ''
        };
    },
    mounted() {
        this.ctx1 =  this.$refs["chart-line"].getContext("2d")
        this.setGraphic()
    },
    updated() {
        this.setGraphic()
    },
    methods: {
        setGraphic() {
            const gradientStroke1 = this.ctx1.createLinearGradient(0, 230, 0, 50);
            gradientStroke1.addColorStop(1, "rgba(94, 114, 228, 0.2)");
            gradientStroke1.addColorStop(0.2, "rgba(94, 114, 228, 0.0)");
            gradientStroke1.addColorStop(0, "rgba(94, 114, 228, 0)");
            //Destruir grafica para actualizar datos
            if (this.lineChart) this.lineChart.destroy()
            this.lineChart = new Chart(this.ctx1, {
                type: "line",
                data: {
                    labels: this.departments.labels,
                    datasets: [
                        {
                            label: "Empleados",
                            tension: 0.4,
                            pointRadius: 0,
                            borderColor: "#4BB543 ",
                            backgroundColor: gradientStroke1,
                            borderWidth: 3,
                            fill: true,
                            data: this.departments.values,
                            maxBarThickness: 6,
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
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                            },
                            ticks: {
                                display: true,
                                padding: 10,
                                color: "#fbfbfb",
                                font: {
                                    size: 11,
                                    family: "Open Sans",
                                    style: "normal",
                                    lineHeight: 2,
                                },
                            },
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: false,
                                drawTicks: false,
                                borderDash: [5, 5],
                            },
                            ticks: {
                                display: true,
                                color: "#ccc",
                                padding: 20,
                                font: {
                                    size: 11,
                                    family: "Open Sans",
                                    style: "normal",
                                    lineHeight: 2,
                                },
                            },
                        },
                    },
                },
            });
        }
    }
};
</script>
