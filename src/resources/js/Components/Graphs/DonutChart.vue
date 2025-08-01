<script setup>
import { ref, reactive, onMounted } from 'vue'

const props = defineProps({
    graphData: {
        default: {
            categories: [],
            title: '',
            seriesName: '',
            seriesData: [],
            seriesLabels: [],
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
    color     : props.barColor,
    labels    : [],
})

const chartOptions = reactive({
    chart: {
        height: 143,
        width: '100%',
        type: 'donut',
        zoom: {
            enabled: false
        },
        toolbar: {
            show: false
        },
  
    },
    labels: props.graphData.seriesLabels,

    plotOptions: {
      pie: {
        donut: {
          size: '60%'
        }
      }
    },
    dataLabels: {
        enabled: true,
    },
    title: {
        text: props.graphData.title,
        align: 'left'
    },
    responsive: [
        {
            breakpoint: 1300,
            options: {
                chart: {
                    height: 146,
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
    <div id="areaGraph"  class="chart-wrapper w-full overflow-hidden">
        <div class="h-6"></div>
        <apexchart type="donut" :height="chartOptions.chart.height"  :options="chartOptions" :series="seriesData.data" :labels="chartOptions.labels"  ></apexchart>
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