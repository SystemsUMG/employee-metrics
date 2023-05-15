<template>
    <div class="card h-100">
        <div class="p-3 card-body">
            <h6>{{ title }}</h6>
            <div class="pt-3 chart">
                <canvas ref="chart-bar" class="chart-canvas" height="180"></canvas>
            </div>
        </div>
    </div>
</template>

<script>
import Chart from "chart.js/auto";
export default {
    name: "antiquities-bar-chart",
    props: ['antiquities'],
    data() {
        return {
            title: 'Años de Antigüedad en la Empresa',
            ctx1: '',
            barChart: '',
        };
    },
    mounted() {
        this.ctx1 =  this.$refs["chart-bar"].getContext("2d")
        this.setGraphic()
    },
    updated() {
        this.setGraphic()
    },
    methods: {
        setGraphic() {
            //Destruir grafica para actualizar datos
            if (this.barChart) this.barChart.destroy()
            this.barChart = new Chart(this.ctx1, {
                type: "bar",
                data: {
                    labels: this.antiquities.labels,
                    datasets: [
                        {
                            label: "Empleados",
                            tension: 0.4,
                            borderWidth: 0,
                            borderRadius: 4,
                            borderSkipped: false,
                            backgroundColor: "#3A416F",
                            data: this.antiquities.values,
                            maxBarThickness: 30,
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
                            precision: 0,
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                            },
                            ticks: {
                                display: true,
                                padding: 10,
                                color: "#9ca2b7",
                            },
                        },
                        x: {
                            precision: 0,
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
                                color: "#9ca2b7",
                            },
                        },
                    },
                },
            });
        },
    }
};
</script>
