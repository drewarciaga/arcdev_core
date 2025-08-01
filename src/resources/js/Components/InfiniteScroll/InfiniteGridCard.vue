<script setup>
import { ref } from 'vue';
import BreezeBadge from '@/Components/Badge.vue';
import BreezeIconButton from '@/Components/IconButton.vue';

const hovered = ref(false)
const emits = defineEmits(['click', 'addToFavorites', 'addToWishLists', 'removeFromFavorites',
'removeFromWishLists', 'viewModel', 'showModalMenu', 'addToOwned', 'showAddStockModal']);

defineProps({
    item: {
        type: Object,
        default: null,
    },
    hideDelete: {
        type: Boolean,
        default: true,
    },
    hideEdit: {
        type: Boolean,
        default: true,
    },
    routeName: {
        type: String,
        default: '',
    },
    hideActions: {
        type: Boolean,
        default: true,
    },
    useOwnImages: {
        type: Boolean,
        default: false,
    },
    fromRestoInventory: {
        type: Boolean,
        default: false,
    },
    cardDimensions: {
        type: String,
        default: 'h-40 md:h-44 lg:h-56 xl:h-72',
    },
    showPrices: {
        type: Boolean,
        default: false,
    },
});

function viewModel(id){
    emits('viewModel',id)
}
function showModalMenu(id){
    emits('showModalMenu',id)
}
function showAddStockModal(id, thumbnail){
    emits('showAddStockModal',id, thumbnail)
}

</script>

<template>
    
<div class='flex items-center justify-center' :class="cardDimensions" @mouseover="hovered = true" @mouseleave="hovered = false" @click="viewModel(item.hashid);">
    <div class="overflow-hidden cursor-pointer rounded-lg relative group h-full w-full" >
        <div class="z-50 cursor-pointer absolute from-black/90 to-transparent/10 bg-gradient-to-t inset-x-0 bottom-0 text-white h-3/5">
            <div class="p-1 md:px-4 space-y-3 group-hover:opacity-100 group-hover:translate-y-0 translate-y-4 pb-10 transform transition duration-300 ease-in-out max-h-40">
                <div class="font-bold text-xxs sm:text-xxs md:text-sm line-clamp-2">{{ item.name }}</div>
            </div>
            <div class="opacity-60 text-xxs sm:text-xxs md:text-xs max-h-40 absolute left-2 bottom-7">
                <p>{{ item.category != null ? item.category.name : ''}}</p>
                <p class="text-orange">{{ item.supplier != null ? item.supplier.name : ''}}</p>
            </div>
            <div class="absolute right-0 bottom-5" v-if="showPrices && item.base_price != null">
                <BreezeBadge :text="'cost:₱' + item.base_price"
                            :bgColor="'bg-yellow-300'"
                            :textColor="'text-black'"
                ></BreezeBadge>
            </div>
            <div class="absolute right-0 bottom-0" v-if="showPrices && item.price != null">
                <BreezeBadge :text="'price:₱' + item.price"
                            :bgColor="'bg-arc-blue-600'"
                            :textColor="'text-black'"
                ></BreezeBadge>
            </div>
        </div>
        <img class="'w-full group-hover:scale-110 transition duration-300 ease-in-out h-full w-full object-cover" :src="item.thumbnail_url != null ? item.thumbnail_url : '/images/no_image.jpg'" />
    </div>
</div>

<div class="absolute top-4 right-2" v-if="['products', 'food', 'meals', 'raw_materials', 'recipes', 'prep_foods'].includes(routeName)">
    <div class="flex flex-wrap space-x-1">
        <v-tooltip location="top" text="More Actions">
            <template v-slot:activator="{ props }">
                <BreezeIconButton v-bind="props" @click="showModalMenu(item.hashid)" buttonSize="h-7 w-7 rounded-xl">
                    <span class="mdi mdi-menu"></span>
                </BreezeIconButton>
            </template>
        </v-tooltip>
    </div>
</div>

<div class="absolute bottom-4 right-0" v-if="routeName == 'items' && hideActions == false && item.product_inventory_maps_count > 0">
    <BreezeBadge :text="'owned:' + item.item_inventory_maps_count"
                :bgColor="'bg-yellow-300'"
                :textColor="'text-black'"
    ></BreezeBadge>
</div>

<div class="absolute top-4 right-2" v-if="routeName == 'product_inventory_maps' && fromRestoInventory == true">
    <div class="flex flex-wrap space-x-1">
        <v-tooltip location="top" text="Add Stock">
            <template v-slot:activator="{ props }">
                <BreezeIconButton v-bind="props" @click="showAddStockModal(item.hashid, item.thumbnail_url)" buttonSize="h-7 w-7 rounded-xl">
                    <span class="mdi mdi-plus"></span>
                </BreezeIconButton>
            </template>
        </v-tooltip>
    </div>
</div>

</template>
<style scoped>
.btn-view{
    background: none;
    border: none;
    color: #ffb300;
    font-size: 20px;
    height: auto;
    line-height: .7;
    padding-left: 0;
}
.btn-edit{
    background: none;
    border: none;
    color: #1474ce;
    font-size: 20px;
    height: auto;
    line-height: .7;
    padding-left: 0;
}
.btn-delete{
    background: none;
    border: none;
    color: #c91818;
    font-size: 20px;
    height: auto;
    line-height: .7;
    padding-left: 0;
}
.rect-bevel{
	/**clip-path: polygon(3% 0, 100% 0, 100% 85%, 97% 100%, 0 100%, 0 15%);**/
    /**clip-path: polygon(3% 0, 100% 0, 100% 85%, 97% 100%, 0 100%, 0 15%);**/
    clip-path: polygon(0% 0, 100% 0, 100% 85%, 97% 100%, 0 100%, 0 15%);
}
.item_desc{
    display: block;
}

.btn-hamburger{
    background-color: rgba(19, 168, 194, 0.801);
}
.btn-favorite-yes{
    background-color: #143965 !important;
}

.yeah{
    opacity: 100 !important;
}
@media screen and (max-width: 425px){
    .rect-bevel{
        /**clip-path: polygon(3% 0, 100% 0, 100% 85%, 97% 100%, 0 100%, 0 15%);**/
        /**clip-path: polygon(3% 0, 100% 0, 100% 85%, 97% 100%, 0 100%, 0 15%);**/
        clip-path: polygon(0% 0, 100% 0, 100% 100%, 100% 100%, 0 100%, 0 0%);
    }
    .item_desc{
        display: none;
    }
}
</style>