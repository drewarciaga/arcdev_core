<script setup>
import { ref, computed  } from 'vue';
import BreezeBadge from '@/Components/Badge.vue';
import BreezeIconButton from '@/Components/IconButton.vue';

const hovered = ref(false)
const emits = defineEmits(['click', 'viewModel', 'showAddItem']);

const props = defineProps({
    item: {
        type: Object,
        default: null,
    },
    routeName: {
        type: String,
        default: '',
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
});

function viewModel(id){
    emits('viewModel',id)
}
function showAddItem(id, itemable_type, stock = null){
    emits('showAddItem',id, itemable_type, stock)
}

const categoryStyle = computed(() => {
	if (props.item?.category?.color) {
		return {
			backgroundColor: props.item.category.color
		}
	}
	return {}
})

const categoryTextColorStyle = computed(() => {
	const fallback = 'white'
	if (props.item?.category?.text_color) {
		return {
			color: props.item.category.text_color
		}
	}
	return {
		color: fallback
	}
})

</script>

<template>
    
<div class='flex items-center justify-center' :class="cardDimensions" @mouseover="hovered = true" @mouseleave="hovered = false" @click="showAddItem(item.hashid, item.itemable_type, item.stock);">
    <div class="overflow-hidden cursor-pointer rounded-lg relative group h-full w-full" :style="categoryStyle" >
        <div class="z-50 cursor-pointer absolute from-black/90 to-transparent/10 bg-gradient-to-t inset-x-0 bottom-0 h-4/6">
            <div class="p-1 md:px-4 space-y-3 group-hover:opacity-100 group-hover:translate-y-0 translate-y-4 pb-10 transform transition duration-300 ease-in-out max-h-40">
                <div class="font-bold text-xxs sm:text-xxs md:text-xs line-clamp-2" :style="categoryTextColorStyle">{{ item.name }}</div>
            </div>
            <div class="opacity-60 text-xxs sm:text-xxs md:text-2xs max-h-40 absolute left-2 bottom-7" :style="categoryTextColorStyle">
                <p>{{ item.category != null ? item.category.name : ''}}</p>
            </div>
            <div class="absolute right-0 bottom-6" v-show="item.stock != null">
                <BreezeBadge :text="item.stock != 0 ? 'Stock:' + item.stock : 'Out of Stock'"
                            :bgColor="item.stock != 0 ? 'bg-yellow-300' : 'bg-red-600 text-white'"
                            :textColor="'text-black'"
                          
                ></BreezeBadge>
            </div>
            <div class="absolute right-0 bottom-0" v-show="item.price != null">
                <BreezeBadge :text="'₱' + item.price"
                            :bgColor="'bg-arc-blue-600'"
                            :textColor="'text-white'"
                        
                ></BreezeBadge>
            </div>
        </div>
        <img v-if="item.thumbnail_url != null" class="'w-full group-hover:scale-110 transition duration-300 ease-in-out h-full w-full object-cover" :src="item.thumbnail_url != null ? item.thumbnail_url : '/images/no_image.jpg'" />
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