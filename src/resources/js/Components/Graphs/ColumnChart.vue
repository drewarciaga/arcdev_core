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

const columnWidth = props.graphData.seriesData.length < 2 ? '40%' : '80%'

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
        height: 140,
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
                    height: 120,
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
    plotOptions: {
        bar: {
            columnWidth: columnWidth,
            borderRadius: 1,
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
            }
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
    yaxis: {
        labels: {
            show: false
        }
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
    <div id="columnGraph" class="chart-wrapper w-full overflow-hidden">
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
}
</style>