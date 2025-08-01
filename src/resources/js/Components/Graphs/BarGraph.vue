<script setup>
import { ref, reactive, onMounted } from 'vue'

const props = defineProps({
    graphData: {
        default: {
            categories: [],
            title: '',
            seriesName: '',
            seriesData: []
        }
    },
});

const series = ref([])

const seriesData = reactive({
    name      : '',
    data      : [],
})

const chartOptions = reactive({
    chart: {
        height: 120,
        width: '100%',
        type: 'line',
        zoom: {
            enabled: false
        }
    },
    responsive: [
        {
            breakpoint: 1300, // For screens smaller than 1000px
            options: {
                chart: {
                    height: 120, // Smaller height for medium screens
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '50%', // Smaller donut hole
                        },
                    },
                },
                legend: {
                    position: 'bottom', // Keep the legend at the bottom
                },
            },
        },
        {
            breakpoint: 600, // For screens smaller than 600px (mobile)
            options: {
                chart: {
                    height: 110, // Even smaller height for mobile screens
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '40%', // Even smaller donut hole for mobile
                        },
                    },
                },
                legend: {
                    position: 'bottom'
                },
            },
        },
    ],
    dataLabels: {
        enabled: false,
    },
    stroke: {
        curve: 'straight',
        colors: ['#AD974F']
    },
    title: {
        text: props.graphData.title,
        align: 'left'
    },
    grid: {
        row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
        },
    },
    xaxis: {
        categories: props.graphData.categories,
    },
    yaxis: {
        labels: {
            formatter: function(value) {
              return value.toFixed(0); // Format Y-axis labels as integers
            }
        },
        min: 0,
    }
})

onMounted(async() => {

    setTimeout(function() {
        seriesData.name         = props.graphData.seriesName
        seriesData.data         = props.graphData.seriesData
        series.value.push(seriesData)
    }, 500);

});

</script>
<template>
    <div id="barGraph" class="chart-wrapper w-full overflow-hidden">
        <apexchart type="bar" width="100%" :height="chartOptions.chart.height" :options="chartOptions" :series="series"></apexchart>
    </div>
</template>

<style scoped>

.apexcharts-title-text, .apexcharts-text {
    fill: rgb(255, 255, 255) !important;
}
.apexcharts-canvas, .apexcharts-svg{
    max-width: 100%; width: 100% !important;
}
.vue-apexcharts{
    background-color: White;
    border-radius: 0.5rem;
}
</style>