<script setup>
import { ref } from 'vue';
import { isMobileOnly } from 'mobile-device-detect';
import BreezeBadge from '@/Components/Badge.vue';
const hovered = ref(false)
const emits = defineEmits(['click', 'addToFavorites', 'addToWishlists', 'removeFromFavorites',
'removeFromWishlists', 'viewModel', 'showModalMenu', 'addToOwned']);

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

});

function viewModel(id){
    emits('viewModel',id)
}

function addToOwnedItems(id){
    emits('addToOwned',id)
}

function addToFavoriteItems(id){
    emits('addToFavorites',id)
}

function addToWishlistItems(id){
    emits('addToWishlists',id)
}

function removeFromFavoriteItems(id){
    emits('removeFromFavorites',id)
}

function removFromWishlistItems(id){
    emits('removeFromWishlists',id)
}

function showModalMenu(id){
    emits('showModalMenu',id)
}

</script>

<template>
<div class='flex items-center justify-center h-full' @mouseover="hovered = true" @mouseleave="hovered = false" @click="viewModel(item.id);">
    <div class="absolute -inset-0 inset-y-2 bg-gradient-to-r from-nos-turtoise-1000 to-nos-pink-900 rounded-lg blur" :class="hovered?'-inset-2.5 inset-y-0.5':''">          
    </div>
    <div v-if="routeName == 'item_inventory_maps'" class="overflow-hidden  aspect-video cursor-pointer rounded-lg relative group h-[90%] w-full" >
        <div class="z-50 opacity-0 group-hover:opacity-100 transition duration-300 ease-in-out cursor-pointer absolute from-black/90 to-transparent/10 bg-gradient-to-t inset-x-0 -bottom-2 pt-30 text-white h-3/4">
            <div class="p-1 md:p-4 space-y-3 group-hover:opacity-100 group-hover:translate-y-0 translate-y-4 pb-10 transform transition duration-300 ease-in-out max-h-40">
                <div class="font-bold text-xxs sm:text-xxs md:text-sm">{{ item.item.name }}</div>

                <div class="opacity-60 text-xxs sm:text-xxs md:text-xs max-h-40" v-if="!isMobileOnly">
                    {{item.item.brand_text}} <span v-if="item.item.line_text != ''"> - {{ item.item.line_text }}</span>
                </div>          
            </div>
        </div>
        <img v-if="useOwnImages" class="object-cover object-top w-full aspect-square group-hover:scale-110 transition duration-300 ease-in-out h-48 md:h-64 lg:h-72 xl:h-80" :src="item.thumbnail_url != null ? item.thumbnail_url : '/images/logo.jpg'" />
        <img v-else class="object-cover object-top w-full aspect-square group-hover:scale-110 transition duration-300 ease-in-out h-48 md:h-64 lg:h-72 xl:h-80" :src="item.item.thumbnail_url != null ? item.item.thumbnail_url : '/images/logo.jpg'" />
    </div>
    <div v-else class="overflow-hidden  aspect-video cursor-pointer rounded-lg relative group h-[90%] w-full" >
        <div class="z-50 opacity-0 group-hover:opacity-100 transition duration-300 ease-in-out cursor-pointer absolute from-black/90 to-transparent/10 bg-gradient-to-t inset-x-0 -bottom-2 pt-30 text-white h-3/4">
            <div class="p-1 md:p-4 space-y-3 group-hover:opacity-100 group-hover:translate-y-0 translate-y-4 pb-10 transform transition duration-300 ease-in-out max-h-40">
                <div class="font-bold text-xxs sm:text-xxs md:text-sm">{{ item.name }}</div>

                <div class="opacity-60 text-xxs sm:text-xxs md:text-xs max-h-40" v-if="!isMobileOnly">
                    {{item.brand_text}} <span v-if="item.line_text != ''"> - {{ item.line_text }}</span>
                </div>
            </div>
        </div>
        <img class="object-cover object-top w-full aspect-square group-hover:scale-110 transition duration-300 ease-in-out h-48 md:h-64 lg:h-72 xl:h-80" :src="item.thumbnail_url != null ? item.thumbnail_url : '/images/logo.jpg'" />
    </div>
</div>

<div class="absolute top-4 right-2" v-if="routeName == 'items' && hideActions == false">
    <div class="flex flex-wrap space-x-1">
        <o-tooltip label="Add to Owned" position="bottom">
            <o-button  class="btn-owned opacity-40 hover:opacity-100" rounded size="small"  @click="addToOwnedItems(item.id)">
                <span class="mdi mdi-check-circle-outline"></span>
            </o-button>
        </o-tooltip>
        <o-tooltip label="Add to Favorites" v-if="item.is_favorite == 0" position="bottom">
            <o-button class="btn-favorite opacity-40 hover:opacity-100" rounded size="small"  @click="addToFavoriteItems(item.id); item.is_favorite=1">
                <span class="mdi mdi-heart-outline"></span>
            </o-button>
        </o-tooltip>
        <o-tooltip label="Remove from Favorites" v-else-if="item.is_favorite == 1" position="bottom" >
            <o-button class="btn-favorite btn-favorite-yes opacity-100" rounded size="small" @click="removeFromFavoriteItems(item.id); item.is_favorite=0">
                <span class="mdi mdi-heart" ></span>
            </o-button>
        </o-tooltip>
        <o-tooltip label="Add to Wishlists" v-if="item.is_wishlist == 0" position="bottom">
            <o-button class="btn-wish_list opacity-40 hover:opacity-100" rounded size="small" @click="addToWishlistItems(item.id); item.is_wishlist=1">
                <span class="mdi mdi-star-outline"></span>
            </o-button>
        </o-tooltip>
        <o-tooltip label="Remove from Wishlists" v-else-if="item.is_wishlist == 1" position="bottom">
            <o-button class="btn-wish_list btn-favorite-yes opacity-100" rounded size="small" @click="removFromWishlistItems(item.id); item.is_wishlist=0">
                <span class="mdi mdi-star" ></span>
            </o-button>
        </o-tooltip>
        <o-button class="btn-hamburger opacity-70 hover:opacity-100" rounded size="small" @click="showModalMenu(item.id);">
            <span class="mdi mdi-menu"></span>
        </o-button>
    </div>
</div>
<div class="absolute bottom-4 right-0" v-if="routeName == 'items' && hideActions == false && item.item_inventory_maps_count > 0">
    <BreezeBadge :text="'owned:' + item.item_inventory_maps_count"
                :bgColor="'bg-yellow-300'"
                :textColor="'text-black'"
    ></BreezeBadge>
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