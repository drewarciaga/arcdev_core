<script setup>
import axios from 'axios'
import Observer from "@/Components/Observer.vue";
import BreezeCard4 from '@/Components/Card4.vue';
import BreezeLoading from '@/Components/Loading.vue';
import BreezeScrollToTop from "@/Components/ScrollToTop.vue";
import { ref, watch } from 'vue'
import useEncryptUtils from '@/Composables/useEncryptUtils.js'
const emits = defineEmits(['addRemoveItemFromCollection', 'updateMetrics'])

const props = defineProps({
    action: {
        type: String,
        default: null,
    },
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
    fromMyCollections: {
        type: Boolean,
        default: false,
    },
    selectedItemId:{
        type: String,
        default: '',
    }
});
const { decryptJsonResponseData, decryptedResponse } = useEncryptUtils()

const items             = ref([])
const page              = ref(1)
const perPage           = ref(10)
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
        let ret = null

        if(props.action == 'RemoveFromCollection'){
            ret = await axios.get('/getAllMyCollectionsByItem/' + props.selectedItemId,{
                params: {
                    page: page.value,
                    itemsPerPage: perPage.value,
                    search: props.searchInput != null ? props.searchInput : null,
                    filters: props.filters != null ? JSON.stringify(props.filters) : null,
                    fromMyCollections: props.fromMyCollections,
                    selectedItemId: props.selectedItemId
                }
            })
        }else{
            ret = await axios.get('/'+props.routeName+'/getAll',{
                params: {
                    page: page.value,
                    itemsPerPage: perPage.value,
                    search: props.searchInput != null ? props.searchInput : null,
                    filters: props.filters != null ? JSON.stringify(props.filters) : null,
                    fromMyCollections: props.fromMyCollections,
                    selectedItemId: props.selectedItemId
                }
            })
        }

        await decryptJsonResponseData(ret.data.data)
        items.value      = items.value.concat(decryptedResponse.value)
        totalItems.value = ret.data.total
        page.value++
        stopFetch.value  = false

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

function addRemoveItemFromCollection(my_collection_hashid){
    emits('addRemoveItemFromCollection', my_collection_hashid)
}
</script>
<template>
<BreezeLoading :isLoading="isLoading"></BreezeLoading>
<div class="mx-auto pt-1 mt-3 px-4" v-if="!isLoading">
    <div class="flex flex-wrap bg-cover w-full justify-center" v-if="items.length > 0">
        <div class="pb-2 lg:pb-4 xl:pb-14 sm:w-full md:w-1/2 lg:w-1/4 xl:w-1/4 p-2 sm:px-2 md:px-4 lg:px-2 xl:px-4 transition ease-in-out hover:scale-110 duration-300 h-auto"
            v-for="myCollection in items" :key="myCollection.hashid"
            >
                <BreezeCard4
                    @click="addRemoveItemFromCollection(myCollection.hashid)"
                    :caption="myCollection.name"
                    :bg="myCollection.thumbnail_url"
                    :hideOwnedBadge="true"
                >  
                </BreezeCard4>
            </div>
        </div>
        <div class="flex flex-wrap bg-cover w-full" v-else>
            <h1 class="m-auto p-8">No Collection Found</h1>
        </div>
    <div class="flex flex-wrap bg-cover w-full min-h-[100px]">
    </div>
    <Observer @intersect="intersected" class="mt-[100px] absolute"/>
    
    <h1 class=" text-sm relative bottom-20 -mt-48 text-center w-full uppercase mt-20" v-if="items.length == 0">
    </h1>
    <h1 class=" text-sm relative bottom-20 -mt-48 text-center w-full uppercase mt-20" v-else-if="showEndofLine">
        Show more <span class="mdi mdi-chevron-double-down"></span>
    </h1>
</div>

<BreezeScrollToTop @resetOnTop="resetOnTop"></BreezeScrollToTop>
</template>