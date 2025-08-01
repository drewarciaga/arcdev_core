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
});

const series = ref([])

const seriesData = reactive({
    name      : '',
    data      : [],
    color     : '#56A68D'
})
const seriesData2 = reactive({
    name      : '',
    data      : [],
    color     : '#ff0000'
})

const chartOptions = reactive({
    chart: {
        height: 350,
        type: 'line',
        zoom: {
            enabled: false
        }
    },
    dataLabels: {
        enabled: false,
    },
    stroke: {
        curve: 'smooth',
        colors: ['#56A68D', '#ff0000'],
        width: .5
    },
    fill: {
        colors: ['#56A68D', '#ff0000']
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
        categories: props.graphData.categories,
    },
    yaxis: {
        labels: {
            formatter: function(value) {
              return value.toFixed(0);
            }
        },
        min: 0,
    }
})

onMounted(async() => {
    setTimeout(function() {
        let tempArray = []
        seriesData.name         = props.graphData.seriesName
        seriesData.data         = props.graphData.seriesData
        tempArray.push(seriesData)
        
        seriesData2.name         = props.graphData.seriesName2
        seriesData2.data         = props.graphData.seriesData2
        tempArray.push(seriesData2)
        series.value = tempArray
    }, 500);
});

</script>
<template>
    <div id="splineGraph">
        <apexchart type="area" :height="chartOptions.chart.height" :options="chartOptions" :series="series"></apexchart>
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