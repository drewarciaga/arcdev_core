<script setup>
import { ref, reactive, onMounted } from 'vue'

const props = defineProps({
    graphData: {
        default: {
            categories: [],
            title: '',
            seriesName: '',
            seriesData: [],
        }
    },
    barColor: {
        type: String,
        default: '#56A68D',
    },
});
const numberOfItems = props.graphData.seriesData.length + 1;

const series = ref([])

const seriesData = reactive({
    name      : '',
    data      : [],
    color     : props.barColor
})

const chartOptions = reactive({
    chart: {
        type: 'bar',
        zoom: {
            enabled: false
        },
        toolbar: {
            show: false
        },
        height: numberOfItems * 44, 
    },
    dataLabels: {
        enabled: false,
    },
    plotOptions: {
        bar: {
            borderRadius: 4,
            dataLabels: {
                position: 'top',
            },
            colors: {
                ranges: [{
                    from: -10000000,
                    to: -1,
                    color: '#ff0000',
                },{
                    from: 0,
                    to: 10000000,
                    color: props.barColor,
                }]
            },
            horizontal: true,
        }
    },
    stroke: {
        curve: 'smooth',
        colors: [props.barColor, '#ff0000'],
        width: .5
    },
    fill: {
        colors: [props.barColor, '#ff0000']
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
    xaxis: {
        categories: props.graphData.categories
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
    <div id="columnGraph" class="chart-wrapper">
        <apexchart type="bar" :height="chartOptions.chart.height" :options="chartOptions" :series="series"></apexchart>
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