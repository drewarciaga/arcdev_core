<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeDonutChart from '@/Components/Graphs/DonutChart.vue';
import { ref, reactive, computed } from 'vue'
import useFood from '@/Composables/FoodAndProduct/useFood.js'
import useUtils from '@/Composables/useUtils.js'

const { numberWithCommas, decimalOnly } = useUtils()
const { rawMaterialColumns } = useFood()
const isLoading             = ref(false)

const graphPercentage = reactive({
    categories: [],
    seriesName: '',
    seriesData: [],
    title: '',
    seriesLabels: []
})

const totalCost = computed(() => {
    let total_food_cost = 0
    
    props.food.raw_materials.forEach((item) => {
        total_food_cost += parseFloat(item.cost_per_serving)
    });
    return (Math.floor(total_food_cost * 100000) / 100000).toFixed(2)
   
});

const totalProfit = computed(() => {
    const price = parseFloat(props.food.price);
    const cost = parseFloat(totalCost.value);

    if(props.food.price == null || totalCost.value == null || isNaN(price) || isNaN(cost)) {
        return "0.00";
    }

    let total_profit = price - cost;
    return (Math.floor(total_profit * 100000) / 100000).toFixed(2);
});

const props = defineProps({
    food: {
        type: Object,
        default: null,
    },
    cardHeight: {
        type: String,
        default: 'h-[200px]'
    }
});

const dialog = ref(false)

function showAddEditDialog(){
    updateGraph()
    dialog.value = true
}

function hideAddEditDialog(){
    dialog.value = false
}

defineExpose({
    showAddEditDialog,
    hideAddEditDialog,
    updateGraph
});

async function computeTotals(item){
    if(item != null){
        if(item.raw_material.base_price == null || item.raw_material.base_price == ''){
            item.raw_material.base_price = 0
            item.cost_per_unit = 0
        }else{
            item.cost_per_unit = (parseFloat(item.raw_material.base_price) / parseFloat(item.raw_material.uom_qty))
        }

        if(item.uom_qty == null || item.uom_qty == ''){
            item.uom_qty = 0
            item.cost_per_serving = 0
        }else{
            item.cost_per_serving = (parseFloat(item.cost_per_unit) * parseFloat(item.uom_qty))
        }

        item.cost_per_unit = (Math.floor(item.cost_per_unit * 100000) / 100000).toFixed(5);
        item.cost_per_serving = (Math.floor(item.cost_per_serving * 100000) / 100000).toFixed(5);
    }

    await updateGraph()
}

async function updateGraph(){
    graphPercentage.seriesLabels = []
    graphPercentage.seriesData = []
    props.food.raw_materials.forEach((item) => {  
        graphPercentage.seriesLabels.push(item.name)
        let total_item_cost = (parseFloat((parseFloat(item.raw_material.base_price) / parseFloat(item.raw_material.uom_qty))) * parseFloat(item.uom_qty)).toFixed(2)
        graphPercentage.seriesData.push(parseFloat(total_item_cost))
    });
}

</script>

<template>
    <v-dialog v-model="dialog" :width="'90%'">
        <v-card>
            <div class="relative p-1 xl:p-4 w-full max-h-full">

                <!-- Modal Head -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Food Costing
                    </h3>
                    <button @click="hideAddEditDialog" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                        <span class="mdi mdi-close"></span>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-0 md:p-1 space-y-4">
                    <section v-if="!isLoading">
                        <div class="modal-body relative p-0 xl:p-4">
                            <div class="grid grid-cols-3 grid-rows-4 gap-4">
                                <div class="col-span-2">
                                    <div class="grid grid-cols-4 grid-rows-1 gap-4 mb-4">
                                        <div>
                                            <img v-if="props.food.image_img" :src="props.food.image_img" alt="" class="profile_img w-auto object-contain object-top rounded-l-lg transition duration-500 group-hover:rounded-xl" :class="cardHeight" >
                                            <img v-else-if="props.food.image_url" :src="props.food.image_url" alt="" class="profile_img w-auto object-contain object-top rounded-l-lg transition duration-500 group-hover:rounded-xl" :class="cardHeight" >
                                            <img v-else src="/images/no_image.jpg" alt="" class="profile_img w-auto object-contain object-top rounded-l-lg transition duration-500 group-hover:rounded-xl" :class="cardHeight" >
                                        </div>
                                        <div class="col-span-3">
                                        
                                            <div class="w-full pl-0 md:p-5 ml-3" :class="cardHeight" >
                                                <div class="space-y-4">
                                                    <h4 v-if="props.food.name" class="text-base md:text-md lg:text-xl xl:text-xl font-semibold text-arc-blue2 mb-4 ml-2">{{ props.food.name }}</h4>

                                                    <div class="grid grid-cols-4 grid-rows-6 gap-2">
                                                        <div class="col-span-3 line-clamp-4 ml-2 text-sm" v-html="props.food.description"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-4 gap-4">
                                        <div class="col-start-1 col-span-3">
                                            <slot name="control-buttons" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-2 row-span-3 col-start-1 row-start-2 text-sm">
                                    Raw Materials / Ingredients
                                
                                    <v-data-table-virtual
                                        :headers="rawMaterialColumns"
                                        :items="props.food.raw_materials"
                                        height="100%"
                                        item-value="hashid"
                                        item-key="hashid"
                                        density="compact"
                                        id="food-costing-table"
                                    >
                                        <template v-slot:item="{ item }">
                                            <tr>
                                                <td>{{ item.name }}</td>
                                                <td>
                                                    <v-text-field
                                                        v-model.trim.lazy="item.raw_material.base_price"
                                                        label="Price"
                                                        density="compact"
                                                        variant="outlined"
                                                        class="mt-2 custom-text-height"
                                                        @keypress="decimalOnly"
                                                        @keyup="computeTotals(item)"
                                                        onclick="this.select()"
                                                        prefix="₱"
                                                    ></v-text-field>
                                                </td>
                                                <td>
                                                    <v-text-field
                                                        v-model.trim.lazy="item.cost_per_unit"
                                                        density="compact"
                                                        variant="outlined"
                                                        class="mt-2 custom-text-height"
                                                        disabled
                                                        prefix="₱"
                                                    ></v-text-field>
                                                </td>
                                                <td>
                                                    <v-text-field
                                                        v-model.trim.lazy="item.uom_qty"
                                                        label="Qty"
                                                        density="compact"
                                                        variant="outlined"
                                                        class="mt-2 custom-text-height"
                                                        @keypress="decimalOnly"
                                                        @keyup="computeTotals(item)"
                                                        :suffix="item.uom_text"
                                                        onclick="this.select()"
                                                    ></v-text-field>
                                                </td>
                                                <td>
                                                    <v-text-field
                                                        v-model.trim.lazy="item.cost_per_serving"
                                                        density="compact"
                                                        variant="outlined"
                                                        class="mt-2 custom-text-height"
                                                        disabled
                                                        prefix="₱"
                                                    ></v-text-field>
                                                </td>
                                            </tr>
                                        </template>
                                    </v-data-table-virtual>
                                </div>
                                <div class="row-span-4 col-start-3 row-start-1 bg-dark-blue">
                                    <div class="flex flex-row items-center h-auto">
                                        <div class="w-full">
                                            <h5 class="text-xs font-bold uppercase text-white p-2">Food Cost Breakdown</h5><br>
                                            <BreezeDonutChart :graphData="graphPercentage" barColor="#3399ff"/>
                                        </div>
                                    </div>
                                    <br>
                                    <h1 class="text-white px-2">Food Totals</h1><hr class="rounded">
                                    <div class="flex flex-row items-center h-auto">
                                        <div class="w-full">
                                            <div class="space-y-4 plain-table p-4">
                                                <slot name="food-totals" />
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="text-white px-2">Raw Material Totals</h1><hr class="rounded">
                                    <div class="flex flex-row items-center h-auto">
                                        <div class="w-full">
                                            <div class="space-y-4 plain-table p-4">
                                                <v-table density="compact">
                                                    <tbody>
                                                        <tr>
                                                            <td class="w-[50%]">Total Cost:</td><td>&#8369;{{ numberWithCommas(totalCost) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Current Price:</td><td>&#8369;{{ numberWithCommas(props.food.price == null || props.food.price === "" ? "0.00" : props.food.price) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Total Profit:</td><td>&#8369;{{ numberWithCommas(totalProfit) }}</td>
                                                        </tr>
                                                    </tbody>
                                                </v-table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section v-else>
                        <div class="p-4">
                            <v-skeleton-loader type="paragraph"></v-skeleton-loader>
                        </div>
                    </section>
                </div>

                <!-- Modal footer -->
                <div class="flex items-end justify-end p-2">
                    <BreezeButton
                        :type="'button'"
                        :color="'bg-pesto hover:bg-pesto-800'"
                        class="flex items-center justify-center"
                        @click="hideAddEditDialog"
                    >
                        Close
                    </BreezeButton>
                </div>
            </div>
        </v-card>
    </v-dialog>
</template>
<style>
#food-costing-table, #food-costing-table .v-field__input{
    font-size:10pt;
}

#food-costing-table .v-field__input{
    padding:8px;
}

.custom-row-height {
    height: 30px;
}

#food-costing-table .v-data-table-virtual td {
    padding: 4px 8px;
    height: 30px;
}

.custom-text-height .v-input__control,  .v-text-field__suffix__text{
    height: 35px;
    line-height: 21px;
    margin-bottom: -12px;
    font-size: 7pt;

}
#food-costing-table .v-text-field .v-input__control .v-input__slot input {
    line-height: 28px;

}
.v-text-field__suffix__text{
    font-size: 7pt;
}
#food-costing-table .v-field--disabled .v-field__outline{
    background: rgba(51, 170, 51, .1) 
}

#food-costing-table .v-field--disabled{
    opacity: 1 !important;
    /*color: blue !important;*/ /* Change to your desired color */
}

#food-costing-table.v-table > .v-table__wrapper > table > tbody > tr > td{
    padding: 0 2px 0 2px !important;
}

.vue-apexcharts{
    background-color: #FFF0  !important;
    width:100%;
}

.apexcharts-legend-text{
    color: white !important;
}
.plain-table td{
    background-color:#3a3c3c;
    color:white;
}

@media screen and (max-width: 1400px){
    .plain-table td{
        font-size: 0.75rem;
    }  
}
@media screen and (max-width: 810px){
    .plain-table td{
        font-size: 0.75rem;
    }  
}
@media screen and (max-width: 425px){
    .plain-table td{
        font-size: 0.75rem;
    }
}
</style>