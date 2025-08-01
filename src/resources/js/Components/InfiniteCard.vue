<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
const emits = defineEmits(['viewModel', 'deleteModel', 'editModel', 'addToFavorites', 'addToWishlists', 'removeFromFavorites', 'removeFromWishlists',
    'addToOwned', 'showModalMenu'
])
const hovered = ref(false)

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
    hasPopupEdit:{
        type: Boolean,
        default: false
    },
    useOwnImages: {
        type: Boolean,
        default: true,
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
<div @mouseover="hovered = true" @mouseleave="hovered = false">
    <div class="absolute -inset-2 bg-gradient-to-r from-nos-turtoise-1000 to-nos-pink-900 rounded-lg blur" :class="hovered?'-inset-3.5':''"> <!-- <div class="absolute -inset-1 bg-gradient-to-r from-nos-pink-400 to-purple-600 rounded-lg blur"> -->

    </div>
    <div v-if="routeName == 'item_inventory_maps'" class="relative flex flex-col md:flex-row bg-gray-900 shadow-xl mb-6 rect-bevel md:max-h-44"  :class="hovered?'bg-gray-800':''" >
        <img v-if="useOwnImages" class=" w-full h-60 md:h-auto object-cover md:w-32 cursor-pointer" :src="item.thumbnail_url != null ? item.thumbnail_url : '/images/logo.jpg'" alt="" @click="emits('viewModel', item.id)"/>
        <img v-else class=" w-full h-60 md:h-auto object-cover md:w-32 cursor-pointer" :src="item.item.thumbnail_url != null ? item.item.thumbnail_url : '/images/logo.jpg'" alt="" @click="emits('viewModel', item.id)"/>

        <div class="p-6 flex flex-col justify-start w-full">
            <div class="w-full md:w-[80%]">
                <h5 class="text-white text-md md:text-xl font-medium mb-2">{{ item.display_name ? item.display_name : item.item.name}}</h5>
                <p class="text-gray-400 text-xs md:text-base mb-10 md:mb-4">
                    {{item.item.brand_text}} <span v-if="item.item.line_text != ''"> - {{ item.item.line_text }}</span>
                </p>
                <p class="text-gray-600 text-xs item_desc">Year Released: {{ item.item.year_released}}</p>
                <p class="text-gray-600 text-xs item_desc">Year Acquired: {{ item.year_acquired}}</p>
            </div>
            <div class="absolute top-4 right-2" >
                <div class="flex flex-wrap space-x-2">
                    <o-tooltip label="Add to Favorites" position="bottom" v-if="item.item.is_favorite == 0">
                        <o-button class="btn-favorite opacity-40 hover:opacity-100" rounded size="small" @click="addToFavoriteItems(item.item.id); item.item.is_favorite=1">
                            <span class="mdi mdi-heart-outline"></span>
                        </o-button>
                    </o-tooltip>
                    <o-tooltip label="Remove from Favorites" position="bottom" v-else-if="item.item.is_favorite == 1">
                        <o-button class="btn-favorite btn-favorite-yes opacity-100" rounded size="small" @click="removeFromFavoriteItems(item.item.id); item.item.is_favorite=0">
                            <span class="mdi mdi-heart" ></span>
                        </o-button>
                    </o-tooltip>
                    <o-tooltip label="Add to Wishlists" position="bottom" v-if="item.item.is_wishlist == 0">
                        <o-button class="btn-favorite opacity-40 hover:opacity-100" rounded size="small" @click="addToWishlistItems(item.item.id); item.item.is_wishlist=1">
                            <span class="mdi mdi-star-outline"></span>
                        </o-button>
                    </o-tooltip>
                    <o-tooltip label="Remove from Wishlists" position="bottom" v-else-if="item.item.is_wishlist == 1">
                        <o-button class="btn-favorite btn-favorite-yes opacity-100" rounded size="small" @click="removFromWishlistItems(item.item.id); item.item.is_wishlist=0">
                            <span class="mdi mdi-star" ></span>
                        </o-button>
                    </o-tooltip>
                </div>
            </div>
            <div class="text-right absolute right-4 bottom-4 md:bottom-1/4">
                <o-button class="btn-view"><span class="mdi mdi-eye" @click="emits('viewModel', item.id)"></span></o-button>
                <span v-if="hideEdit == null || hideEdit == false">
                    <o-button class="btn-edit"><span class="mdi mdi-note-edit" @click="emits('editModel', item.id)"></span></o-button>
                </span>

                <span v-if="hideDelete == null || hideDelete == false">
                    <o-button class="btn-delete"><span class="mdi mdi-trash-can" @click="emits('deleteModel', item.id)"></span></o-button>
                </span>
            </div>
        </div>
    </div>
    <div v-else-if="routeName == 'items'" class="relative flex flex-col md:flex-row bg-gray-900 shadow-xl mb-6 rect-bevel md:max-h-44"  :class="hovered?'bg-gray-800':''" >
        <img class=" w-full h-60 md:h-auto object-cover md:w-32 cursor-pointer" :src="item.thumbnail_url != null ? item.thumbnail_url : '/images/logo.jpg'" alt="" @click="emits('viewModel', item.id)"/>

        <div class="p-6 flex flex-col justify-start w-full">
            <div class="w-full md:w-[80%]">
                <h5 class="text-white text-md md:text-xl font-medium mb-2">{{ item.display_name ? item.display_name : item.name}}</h5>
                <p class="text-gray-400 text-xs md:text-base mb-10 md:mb-4">
                    {{item.brand_text}} <span v-if="item.line_text != ''"> - {{ item.line_text }}</span>
                </p>
            </div>
            <div class="absolute top-4 right-2" >
                <div class="flex flex-wrap space-x-2">
                    <o-tooltip label="Add to Owned" position="bottom">
                        <o-button  class="btn-owned opacity-40 hover:opacity-100" rounded size="small" @click="addToOwnedItems(item.id)">
                            <span class="mdi mdi-check-circle-outline"></span>
                        </o-button>
                    </o-tooltip>
                    <o-tooltip label="Add to Favorites" position="bottom" v-if="item.is_favorite == 0">
                        <o-button class="btn-favorite opacity-40 hover:opacity-100" rounded size="small" @click="addToFavoriteItems(item.id); item.is_favorite=1">
                            <span class="mdi mdi-heart-outline"></span>
                        </o-button>
                    </o-tooltip>
                    <o-tooltip label="Remove from Favorites" position="bottom" v-else-if="item.is_favorite == 1">
                        <o-button class="btn-favorite btn-favorite-yes opacity-100" rounded size="small" @click="removeFromFavoriteItems(item.id); item.is_favorite=0">
                            <span class="mdi mdi-heart" ></span>
                        </o-button>
                    </o-tooltip>
                    <o-tooltip label="Add to Wishlists" position="bottom" v-if="item.is_wishlist == 0">
                        <o-button class="btn-favorite opacity-40 hover:opacity-100" rounded size="small" @click="addToWishlistItems(item.id); item.is_wishlist=1">
                            <span class="mdi mdi-star-outline"></span>
                        </o-button>
                    </o-tooltip>
                    <o-tooltip label="Remove from Wishlists" position="bottom" v-else-if="item.is_wishlist == 1">
                        <o-button class="btn-favorite btn-favorite-yes opacity-100" rounded size="small" @click="removFromWishlistItems(item.id); item.is_wishlist=0">
                            <span class="mdi mdi-star" ></span>
                        </o-button>
                    </o-tooltip>
                    <o-button class="btn-hamburger opacity-70 hover:opacity-100" rounded size="small" @click="showModalMenu(item.id);">
                        <span class="mdi mdi-menu"></span>
                    </o-button>
                </div>
            </div>
            <div class="text-right absolute right-4 bottom-4 md:bottom-1/4">
                <o-button class="btn-view"><span class="mdi mdi-eye" @click="emits('viewModel', item.id)"></span></o-button>
                <span v-if="hideEdit == null || hideEdit == false">
                    <o-button class="btn-edit"><span class="mdi mdi-note-edit" @click="emits('editModel', item.id)"></span></o-button>
                </span>

                <span v-if="hideDelete == null || hideDelete == false">
                    <o-button class="btn-delete"><span class="mdi mdi-trash-can" @click="emits('deleteModel', item.id)"></span></o-button>
                </span>
            </div>
        </div>
    </div>
    <div v-else class="relative flex flex-col md:flex-row bg-gray-900 shadow-xl mb-6 rect-bevel md:max-h-44"  :class="hovered?'bg-gray-800':''" >
        <img class=" w-full h-60 md:h-auto object-cover md:w-32 cursor-pointer" :src="item.thumbnail_url != null ? item.thumbnail_url : '/images/logo.jpg'" alt="" @click="emits('viewModel', item.id)"/>

        <div class="p-6 flex flex-col justify-start w-full">
            <div class="w-full md:w-[80%]">
                <h5 class="text-white text-md md:text-xl font-medium mb-2">{{item.name}}</h5>
                <p class="text-gray-400 text-xs md:text-base mb-10 md:mb-4" v-if="item.brand_text != null">
                    {{item.brand_text}} <span v-if="item.line_text != ''"> - {{ item.line_text }}</span>
                </p>
                <p class="text-gray-600 text-xs md:text-sm lg:text-md item_desc line-clamp-3">{{ item.description }}</p>
            </div>

            <div class="text-right absolute right-4 bottom-4 md:bottom-1/4">
                <o-button class="btn-view"><span class="mdi mdi-eye" @click="viewModel(item.id);"></span></o-button>
                <span v-if="hideEdit == null || hideEdit == false">
                    <span v-if="hasPopupEdit == false">
                        <Link :href="route(routeName+'.edit',item.id)"><o-button class="btn-edit"><span class="mdi mdi-note-edit"></span></o-button></Link>
                    </span>
                    <span v-else>
                        <o-button class="btn-edit"><span class="mdi mdi-note-edit" @click="emits('editModel', item.id)"></span></o-button>
                    </span>
                </span>

                <span v-if="hideDelete == null || hideDelete == false">
                    <o-button class="btn-delete"><span class="mdi mdi-trash-can" @click="emits('deleteModel', item.id)"></span></o-button>
                </span>
            </div>
        </div>
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