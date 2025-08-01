<script setup>
import axios from 'axios'
import Observer from "@/Components/Observer.vue";
import BreezeInfiniteGridCard from "@/Components/InfiniteScroll/InfiniteGridCard.vue";
import BreezeLoading from '@/Components/Loading.vue';
import BreezeScrollToTop from "@/Components/ScrollToTop.vue";
import { ref, watch } from 'vue'
import useEncryptUtils from '@/Composables/useEncryptUtils.js'
const emits = defineEmits(['updateMetrics', 'viewItem', 'showOwnedAddEditModel', 'addToFavorites', 'removeFromFavorites',
                            'addToWishLists', 'removeFromWishLists', 'showModalMenu', 'showModalCollectionMenu', 'viewCollection', 'showCollectionActionsMenu',
                            'showAddStockModal'])

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
        default: 'h-48 md:h-48 lg:h-60 xl:h-72',
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

        if(props.routeName == 'shop_inventory'){
            route = 'products'
        }

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
function viewCollection(id){
    emits('viewCollection',id)
}
function showModalMenu(id){
    emits('showModalMenu', id)
}
function showAddStockModal(id, thumbnail){
    emits('showAddStockModal', id, thumbnail)
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
<div class="px-0 md:px-4 mx-auto pt-12 mt-3" v-if="!isLoading">
    <div class="px-0 md:px-4 flex flex-wrap -mx-1 overflow-hidden sm:-mx-1 md:-mx-1 lg:-mx-1 xl:-mx-1 mb-72 infinite-card-2" v-if="['products', 'food', 'meals', 'raw_materials', 'recipes', 'prep_foods'].includes(props.routeName)">
        <div class="rounded-sm my-1 md:my-2 px-1 w-1/2 overflow-hidden sm:px-2 sm:w-1/4 md:my-2 md:px-2 md:w-1/4 lg:my-3 lg:px-3 lg:w-1/5 xl:my-3 xl:px-3 xl:w-1/6" v-for="(item, index) in items" :key="item.hashid">
            <div class="relative" :class="cardHeight">
                <BreezeInfiniteGridCard
                    :item="item"
                    :hideDelete="props.hideDelete"
                    :hideEdit="props.hideEdit"
                    :hideActions="props.hideActions"
                    :routeName="props.routeName"
                    @viewModel="viewItem"
                    @showModalMenu="showModalMenu"
                    :showPrices="props.showPrices"
                ></BreezeInfiniteGridCard>
            </div>
        </div>
    </div>

    <div class="px-0 md:px-4 flex flex-wrap -mx-1 overflow-hidden sm:-mx-1 md:-mx-1 lg:-mx-1 xl:-mx-1 mb-72 infinite-card-2" v-else-if="props.routeName=='product_inventory_maps' && props.fromRestoInventory == true">
        <div class="rounded-sm my-1 md:my-2 px-1 w-1/2 overflow-hidden sm:px-2 sm:w-1/4 md:my-2 md:px-2 md:w-1/4 lg:my-3 lg:px-3 lg:w-1/5 xl:my-3 xl:px-3 xl:w-1/6" v-for="(item, index) in items" :key="item.hashid">
            <div class="relative" :class="cardHeight">
                <BreezeInfiniteGridCard
                    :item="item"
                    :hideDelete="props.hideDelete"
                    :hideEdit="props.hideEdit"
                    :hideActions="props.hideActions"
                    :routeName="'shop_inventory'"
                    :fromRestoInventory="props.fromRestoInventory"
                    @viewModel="viewItem"
                    @showAddStockModal="showAddStockModal"

                ></BreezeInfiniteGridCard>
            </div>
        </div>
    </div>
    <Observer @intersect="intersected" class="absolute infinite-observer"/>
    
    <h1 class=" text-sm relative bottom-20 -mt-48 text-center w-full uppercase mt-20" v-if="items.length == 0">
        No Data Found
    </h1>
    <h1 class=" text-sm relative bottom-20 -mt-48 text-center w-full uppercase mt-20" v-else-if="showEndofLine">
        Show more <span class="mdi mdi-chevron-double-down"></span>
    </h1>
    <h1 class=" text-sm relative bottom-20 -mt-48 text-center w-full uppercase mt-20" v-else>
        
    </h1>
    
</div>

<BreezeScrollToTop @resetOnTop="resetOnTop"></BreezeScrollToTop>
</template>