import { ref, reactive } from 'vue'

export default function useMetrics(){
    const metricErrors   = ref([])

    const dashboardMetrics = reactive({
        totalOutOfStockProducts      : 0,
        totalLowStockProducts        : 0,
        totalOutOfStockRawMaterials  : 0,
        totalLowStockRawMaterials    : 0,

        totalOrdersToday             : 0,
        totalPendingOrders           : 0,
        totalUnpaidOrders            : 0,
        totalCompletedOrdersToday    : 0,
        totalCancelledOrdersToday    : 0,
        totalPendingChange           : 0,
    })

    async function getStockStatusCounts(){
        metricErrors.value = []

        await axios.get('/getStockStatusCounts').then(response => {
            dashboardMetrics.totalOutOfStockProducts            = response.data.data.totalOutOfStockProducts
            dashboardMetrics.totalLowStockProducts              = response.data.data.totalLowStockProducts
            dashboardMetrics.totalOutOfStockRawMaterials        = response.data.data.totalOutOfStockRawMaterials
            dashboardMetrics.totalLowStockRawMaterials          = response.data.data.totalLowStockRawMaterials
 
        });
    }

    async function getOrderMetrics(){
        metricErrors.value = []

        await axios.get('/getOrderMetrics').then(response => {
            dashboardMetrics.totalOrdersToday                   = response.data.data.totalOrdersToday
            dashboardMetrics.totalPendingOrders                 = response.data.data.totalPendingOrders
            dashboardMetrics.totalUnpaidOrders                  = response.data.data.totalUnpaidOrders
            dashboardMetrics.totalCompletedOrdersToday          = response.data.data.totalCompletedOrdersToday
            dashboardMetrics.totalCancelledOrdersToday          = response.data.data.totalCancelledOrdersToday
            dashboardMetrics.totalPendingChange                 = response.data.data.totalPendingChange
            
 
        });
    }


    return {
        metricErrors,
        getStockStatusCounts,
        getOrderMetrics,
        dashboardMetrics,

    }
}