<script setup>
import { ref } from 'vue';
import { isMobileOnly } from 'mobile-device-detect';
const hovered = ref(false)
const emits = defineEmits(['click', 'addToFavorites', 'addToWishlists', 'removeFromFavorites', 'removeFromWishlists', 'viewModel']);

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
    large: {
        type: Boolean,
        default: '',
    }
});

function viewModel(id){
    emits('viewModel',id)
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

</script>

<template>
<div class='flex items-center justify-center h-full' @mouseover="hovered = true" @mouseleave="hovered = false" @click="viewModel(item.id);">
    <div class="absolute -inset-0 inset-y-2 bg-gradient-to-r from-nos-turtoise-1000 to-nos-pink-900 rounded-lg blur" :class="hovered?'-inset-2.5 inset-y-0.5':''">          
    </div>
    <div class="overflow-hidden  aspect-video cursor-pointer rounded-lg relative group h-[90%] w-full" >
        <div v-if="item.completed" class="ribbon-1 right nowrap w-[30%] md:w-[30%] lg:w-[25%] xl:w-[20%] text-xxs md:text-xs"><span class="mdi mdi-marker-check"></span> Complete!</div>
        <div class="z-50 opacity-0 group-hover:opacity-100 transition duration-300 ease-in-out cursor-pointer absolute from-black/90 to-transparent/10 bg-gradient-to-t inset-x-0 -bottom-2 pt-30 text-white h-3/4">
            <div class="p-1 md:p-4 space-y-3 group-hover:opacity-100 group-hover:translate-y-0 translate-y-4 pb-10 transform transition duration-300 ease-in-out max-h-40">
                <div class="font-bold text-lg sm:text-lg md:text-xl">{{ item.name }}</div>

                <div class="opacity-60 text-xxs sm:text-xxs md:text-xs max-h-40" v-if="!isMobileOnly">
                    {{item.description}}
                </div>
            </div>
        </div>
        <img v-if="large == null" class="object-cover object-top w-full aspect-square group-hover:scale-110 transition duration-300 ease-in-out h-48 md:h-64 lg:h-72 xl:h-80" :src="item.thumbnail_url != null ? item.thumbnail_url : '/images/logo.jpg'" />
        <img v-else class="object-cover object-top w-full aspect-square group-hover:scale-110 transition duration-300 ease-in-out h-48 md:h-64 lg:h-72 xl:h-80" :src="item.profile_url != null ? item.profile_url : '/images/logo.jpg'" />
    </div>
</div>

<div class="absolute top-4 right-2" v-if="routeName == 'items'">
    <div class="odocs-spaced">
        <o-button class="btn-favorite opacity-40 hover:opacity-100" rounded size="small" v-if="item.is_favorite == 0" @click="addToFavoriteItems(item.id); item.is_favorite=1">
            <span class="mdi mdi-heart-outline"></span>
        </o-button>
        <o-button class="btn-favorite btn-favorite-yes opacity-100" rounded size="small" v-else-if="item.is_favorite == 1" @click="removeFromFavoriteItems(item.id); item.is_favorite=0">
            <span class="mdi mdi-heart" ></span>
        </o-button>

        <o-button class="btn-favorite opacity-40 hover:opacity-100" rounded size="small" v-if="item.is_wishlist == 0" @click="addToWishlistItems(item.id); item.is_wishlist=1">
            <span class="mdi mdi-star-outline"></span>
        </o-button>
        <o-button class="btn-favorite btn-favorite-yes opacity-100" rounded size="small" v-else-if="item.is_wishlist == 1" @click="removFromWishlistItems(item.id); item.is_wishlist=0">
            <span class="mdi mdi-star" ></span>
        </o-button>
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
.btn-favorite{
    background-color: rgb(190, 36, 36);
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

.ribbon-1 {
    position: absolute;
    background: #FFD700;
    box-shadow: 0 0 0 999px #FFD700;
    clip-path: inset(0 -100%);
    opacity: .6;
    padding: 1px;
    text-align: left;
}

.right {
    inset: 0 0 auto auto;
    transform-origin: 0 0;
    transform: translate(50%) rotate(40deg);
}
</style>