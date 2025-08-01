<script setup>
import { ref, reactive, onMounted } from 'vue'

const props = defineProps({
    graphData: {
        default: {
            categories: [],
            title: '',
            seriesName: '',
            seriesData: [],
            seriesName2: '',
            seriesData2: []
        }
    },
    barColor: {
        type: String,
        default: '#56A68D',
    },
});

const series = ref([])

const seriesData = reactive({
    name      : '',
    data      : [],
    color     : props.barColor
})
const seriesData2 = reactive({
    name      : '',
    data      : [],
    color     : '#ff0000'
})

const chartOptions = reactive({
    chart: {
        height: 120,
        width: '100%',
        type: 'line',
        zoom: {
            enabled: false
        },
        toolbar: {
            show: false
        }
    },
    responsive: [
        {
            breakpoint: 1300,
            options: {
                chart: {
                    height: 120,
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '50%',
                        },
                    },
                },
                legend: {
                    position: 'bottom',
                },
            },
        },
        {
            breakpoint: 600,
            options: {
                chart: {
                    height: 110,
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '40%',
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
        curve: 'smooth',
        colors: [props.barColor, '#ff0000'],
        width: .5
    },
    fill: {
        type: 'solid',
        colors: [props.barColor],
        opacity: 0.5
    },
    title: {
        text: props.graphData.title,
        align: 'left'
    },
    grid: {
        row: {
            colors: ['#f3f3f3', 'transparent'],
            opacity: 0.5
        },
    },
    yaxis: {
        labels: {
            show: false,
        },
    },
})

onMounted(async() => {
    setTimeout(function() {
        let tempArray = []
        seriesData.name         = props.graphData.seriesName
        seriesData.data         = props.graphData.seriesData
        tempArray.push(seriesData)
        series.value = tempArray
    }, 500);
});

</script>
<template>
    <div id="areaGraph" class="chart-wrapper w-full overflow-hidden">
        <apexchart type="area" width="100%" :height="chartOptions.chart.height" :options="chartOptions" :series="series"></apexchart>
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
}
</style>