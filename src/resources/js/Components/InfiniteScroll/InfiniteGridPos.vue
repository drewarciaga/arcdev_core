<script setup>
import axios from 'axios'
import Observer from "@/Components/Observer.vue";
import BreezeInfiniteGridPosCard from "@/Components/InfiniteScroll/InfiniteGridPosCard.vue";
import BreezeLoading from '@/Components/Loading.vue';
import BreezeScrollToTop from "@/Components/ScrollToTop.vue";
import { ref, watch } from 'vue'
import useEncryptUtils from '@/Composables/useEncryptUtils.js'
const emits = defineEmits(['updateMetrics', 'viewItem', 'showAddItem'])

const props = defineProps({
    triggerRefresh: {
        type: Boolean,
        default: false,
    },
    searchInput: {
        type: String,
        default: null,
    },
    hideDelete: {
        type: Boolean,
        default: false,
    },
    hideEdit: {
        type: Boolean,
        default: false,
    },
    hideActions: {
        type: Boolean,
        default: false,
    },
    routeName: {
        type: String,
        default: '',
    },
    filters: {
        type: Object,
        default: null,
    },
    hasPopupEdit: {
        type: Boolean,
        default: false,
    },
    fromRestoInventory: {
        type: Boolean,
        default: false,
    },
    cardHeight:{
        type: String,
        default: '',
    },
    showPrices: {
        type: Boolean,
        default: false,
    },
    
});
const { decryptJsonResponseData, decryptedResponse } = useEncryptUtils()

const items             = ref([])
const page              = ref(1)
const perPage           = ref(21)
const totalItems        = ref(0)
const stopFetch         = ref(false)
const holdFunction      = ref(false)
const selectedItem      = ref(null)
const showEndofLine     = ref(true)
const maxItemCount      = ref(200)
const isLoading         = ref(false)

async function intersected (fromSearch = false) {
    if(items.value.length > maxItemCount.value){
        isLoading.value = true
        items.value = []
        setTimeout(() => {
                isLoading.value = false
        }, 1000);
           
    }
    if(stopFetch.value == false && (fromSearch || holdFunction.value == false)){
        stopFetch.value = true
        let route = props.routeName

        let ret = await axios.get('/'+route+'/getAll',{
            params: {
                page: page.value,
                itemsPerPage: perPage.value,
                search: props.searchInput != null ? props.searchInput : null,
                filters: props.filters != null ? JSON.stringify(props.filters) : null,
            }
        })

        await decryptJsonResponseData(ret.data.data)
        items.value      = items.value.concat(decryptedResponse.value)
        totalItems.value = ret.data.total
        page.value++
        stopFetch.value = false

        if(decryptedResponse.value.length == 0){
            stopFetch.value = true
            showEndofLine.value = false
        }
        
        emits('updateMetrics',totalItems.value)
    }
}

watch(
    () => props.triggerRefresh,
    (newValue, oldValue) => { 
        if(newValue == true){
            items.value = []
            page.value = 1
            totalItems.value = 0
            stopFetch.value = false
            holdFunction.value = true
            intersected(true)
            holdFunction.value = false
            showEndofLine.value = true
        }
    }
);

function viewItem(id){
    emits('viewItem',id)
}
function showAddItem(id, itemable_type, stock = null){
    emits('showAddItem',id, itemable_type, stock)
}

function resetOnTop(){
    items.value = []
    page.value = 1
    totalItems.value = 0
    stopFetch.value = false
    holdFunction.value = true
    intersected(true)
    holdFunction.value = false
    showEndofLine.value = true
}
</script>
<template>
<BreezeLoading :isLoading="isLoading"></BreezeLoading>
<div class="px-0 md:px-4 mx-auto mt-3 relative" v-if="!isLoading">

    <div class="grid grid-cols-4 lg:grid-cols-5 xl:grid-cols-7 gap-x-2 gap-y-2 overflow-hidden mb-72">
        <div class="rounded-sm" v-for="(item, index) in items" :key="item.hashid">
            <div class="relative" :class="cardHeight">
                <BreezeInfiniteGridPosCard
                    :item="item"
                    :routeName="props.routeName"
                    @viewModel="viewItem"
                    @showAddItem="showAddItem"
                    cardDimensions="h-40 md:h-44 lg:h-44 xl:h-52"
                ></BreezeInfiniteGridPosCard>
            </div>
        </div>
    </div>

    <Observer @intersect="intersected" class="absolute infinite-observer"/>
    
    <h1 class=" text-sm relative bottom-20 -mt-48 text-center w-full uppercase mt-20 text-white" v-if="items.length == 0">
        No Data Found
    </h1>
    <h1 class=" text-sm relative bottom-20 -mt-48 text-center w-full uppercase mt-20 text-white" v-else-if="showEndofLine">
        Show more <span class="mdi mdi-chevron-double-down"></span>
    </h1>
    <h1 class=" text-sm relative bottom-20 -mt-48 text-center w-full uppercase mt-20" v-else>
    </h1>
</div>

<BreezeScrollToTop @resetOnTop="resetOnTop"></BreezeScrollToTop>
</template>