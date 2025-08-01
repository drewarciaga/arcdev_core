<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    foodItem: {
        type: Object,
        default: null,
    },
    labelHeight: {
        type: String,
        default: ' h-1/2',
    },
    cardHeight: {
        type: String,
        default: 'h-40 md:h-44 lg:h-56 xl:h-22 w-[200px]'
    },
    selected: {
        type: Boolean,
        default: false,
    },
});

const foodItemThumbnail = ref('')

watch(
    () => props.foodItem,
    (newValue, oldValue) => { 
        foodItemThumbnail.value = newValue.thumbnail_url
        foodItemThumbnail.value = foodItemThumbnail.value ? foodItemThumbnail.value.replace(/ /g, '%20') : null
    }
);

if(props.foodItem != null){
    foodItemThumbnail.value = props.foodItem.thumbnail_url != null ? props.foodItem.thumbnail_url : '/images/no_image.jpg'
    foodItemThumbnail.value = foodItemThumbnail.value ? foodItemThumbnail.value.replace(/ /g, '%20') : null
}
</script>

<template>
<div :class="[cardHeight, selected ? 'selectedCard' : '']" class="shadow-md duration-500 hover:scale-110 hover:shadow-xl bg-cover bg-center relative object-cover" :style="{ 'backgroundImage': `url(${foodItemThumbnail})` }" >
    <!--<img v-if="foodItem.thumbnail_url != null && foodItem.thumbnail_url != ''" :src="foodItem.thumbnail_url" alt="Product" class="h-24 w-auto m-auto object-cover mt-2" />
    <img v-else src="/images/no_image_foodItem.webp" alt="Product" class="h-24 w-full object-cover" / -->

    <div :class="labelHeight" class="overflow-hidden w-full opacity-100 cursor-pointer absolute from-arc-lightgray/90 to-transparent/20 bg-gradient-to-t bottom-0 text-white">
        <div class="mx-3 min-h-[55px]">
            <p class="text-sm font-bold block capitalize line-clamp-2">{{ props.foodItem.name }}</p>
            <p class="text-xs font-bold block text-yellow-200 line-clamp-2" v-if="props.foodItem.uom_qty != null && props.foodItem.uom_id != null">{{ props.foodItem.uom_qty }} {{ props.foodItem.uom_text }}</p>
        </div>
        <slot/>
    </div>
</div>
</template>
<style scoped>
.selectedCard{
    border-radius: 0.8rem !important;
    box-shadow: 0 0 .2rem #fff, 0 0 .2rem #fff, 0 0 1.2rem #1379fe, 0 0 0.8rem #1379fe, 0 0 1.8rem #1379fe, inset 0 0 1.3rem #1379fe;
}
</style>